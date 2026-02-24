<?php

namespace App\Http\Controllers\StudioOwner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudioOwner\SubscribeRequest;
use App\Models\SubscriptionPlanModel;
use App\Models\StudioPlanModel;
use App\Models\StudioOwner\StudiosModel;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Display a listing of available subscription plans.
     */
    public function index()
    {
        $plans = SubscriptionPlanModel::where('user_type', 'studio')
            ->where('status', 'active')
            ->orderBy('price')
            ->get();

        // Get current active subscription if any
        $currentSubscription = null;
        if (auth()->user()->studio) {
            $currentSubscription = StudioPlanModel::where('studio_id', auth()->user()->studio->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->latest()
                ->first();
        }

        return view('owner.view-subscription-plans', compact('plans', 'currentSubscription'));
    }

    public function status()
    {
        return view('owner.view-subscription-status');
    }

    /**
     * Get subscription plan details.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $plan = SubscriptionPlanModel::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'description' => $plan->description,
                    'price' => number_format($plan->price, 2),
                    'billing_cycle' => ucfirst($plan->billing_cycle),
                    'plan_type' => ucfirst($plan->plan_type),
                    'plan_code' => $plan->plan_code ?? 'N/A',
                    'priority_level' => $plan->priority_level ?? 0,
                    'features' => $plan->features,
                    'max_booking' => $plan->max_booking === null ? 'Unlimited' : $plan->max_booking,
                    'max_studio_photographers' => $plan->max_studio_photographers === null ? 'Unlimited' : $plan->max_studio_photographers,
                    'max_studios' => $plan->max_studios === null ? 'Unlimited' : $plan->max_studios,
                    'staff_limit' => $plan->staff_limit === null ? 'Unlimited' : $plan->staff_limit,
                    'support_level' => ucfirst($plan->support_level),
                    'commission_rate' => $plan->commission_rate . '%',
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch subscription plan', [
                'error' => $e->getMessage(),
                'plan_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Subscription plan not found.'
            ], 404);
        }
    }

    /**
     * Initialize subscription payment.
     */
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();
            
            // Check if user has a studio
            $studio = $user->studio;
            
            if (!$studio) {
                // Check if there are any studios owned by this user
                $studio = \App\Models\StudioOwner\StudiosModel::where('user_id', $user->id)->first();
                
                if (!$studio) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You need to create a studio first before subscribing to a plan.',
                        'redirect_to_studio_creation' => true,
                        'studio_creation_url' => route('owner.studio.create')
                    ], 400);
                }
            }

            // Check if there's an active subscription
            $activeSubscription = StudioPlanModel::where('studio_id', $studio->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->first();

            if ($activeSubscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have an active subscription. Please wait until it expires or cancel it first.'
                ], 400);
            }

            $plan = SubscriptionPlanModel::findOrFail($request->plan_id);

            // Generate subscription reference
            $subscriptionReference = StudioPlanModel::generateSubscriptionReference();

            // Create pending subscription
            $studioPlan = StudioPlanModel::create([
                'studio_id' => $studio->id,
                'plan_id' => $plan->id,
                'subscription_reference' => $subscriptionReference,
                'start_date' => now(),
                'end_date' => $this->calculateEndDate($plan->billing_cycle),
                'next_billing_date' => $this->calculateNextBillingDate($plan->billing_cycle),
                'amount_paid' => $plan->price,
                'payment_status' => 'pending',
                'status' => 'pending',
                'plan_snapshot' => $plan->toArray(),
            ]);

            // Create Stripe checkout session using the dedicated subscription method
            $checkoutSession = $this->stripeService->createSubscriptionCheckoutSession(
                $plan->price,
                $subscriptionReference,
                $plan->name,
                $plan->billing_cycle,
                'PHP'
            );

            if (!$checkoutSession) {
                throw new \Exception('Failed to create Stripe checkout session');
            }

            // Update subscription with Stripe session ID
            $studioPlan->update([
                'stripe_session_id' => $checkoutSession['id']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Redirecting to payment...',
                'checkout_url' => $checkoutSession['url']
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to initialize subscription', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'plan_id' => $request->plan_id ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process subscription. Please try again.'
            ], 500);
        }
    }

    /**
     * Get subscription history.
     */
    public function history(): JsonResponse
    {
        try {
            $user = auth()->user();
            
            // Get the studio - check both relations
            $studio = $user->studio;
            
            if (!$studio) {
                // Try to find studio directly
                $studio = \App\Models\StudioOwner\StudiosModel::where('user_id', $user->id)->first();
            }
            
            // If still no studio, return empty history instead of error
            if (!$studio) {
                return response()->json([
                    'success' => true,
                    'data' => []
                ]);
            }

            $subscriptions = StudioPlanModel::with('plan')
                ->where('studio_id', $studio->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($subscription) {
                    return [
                        'id' => $subscription->id,
                        'subscription_reference' => $subscription->subscription_reference,
                        'plan_name' => $subscription->plan->name ?? 'Unknown Plan',
                        'amount' => number_format($subscription->amount_paid, 2),
                        'start_date' => $subscription->start_date->format('M d, Y'),
                        'end_date' => $subscription->end_date->format('M d, Y'),
                        'payment_status' => $subscription->payment_status,
                        'payment_status_badge' => $this->getPaymentStatusBadge($subscription->payment_status),
                        'status' => $subscription->status,
                        'status_badge' => $this->getStatusBadge($subscription->status),
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $subscriptions
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch subscription history', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch subscription history.'
            ], 500);
        }
    }

    /**
     * Calculate end date based on billing cycle.
     */
    private function calculateEndDate(string $billingCycle)
    {
        switch ($billingCycle) {
            case 'monthly':
                return now()->addMonth();
            case 'yearly':
                return now()->addYear();
            default:
                return now()->addMonth();
        }
    }

    /**
     * Calculate next billing date based on billing cycle.
     */
    private function calculateNextBillingDate(string $billingCycle)
    {
        switch ($billingCycle) {
            case 'monthly':
                return now()->addMonth();
            case 'yearly':
                return now()->addYear();
            default:
                return now()->addMonth();
        }
    }

    /**
     * Get payment status badge.
     */
    private function getPaymentStatusBadge(string $status): string
    {
        $classes = [
            'pending' => 'badge-soft-warning',
            'paid' => 'badge-soft-success',
            'failed' => 'badge-soft-danger',
            'refunded' => 'badge-soft-secondary'
        ];

        $labels = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refunded' => 'Refunded'
        ];

        $class = $classes[$status] ?? 'badge-soft-secondary';
        $label = $labels[$status] ?? ucfirst($status);

        return "<span class='badge {$class}'>{$label}</span>";
    }

    /**
     * Get status badge.
     */
    private function getStatusBadge(string $status): string
    {
        $classes = [
            'active' => 'badge-soft-success',
            'expired' => 'badge-soft-secondary',
            'cancelled' => 'badge-soft-danger',
            'pending' => 'badge-soft-warning'
        ];

        $labels = [
            'active' => 'Active',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
            'pending' => 'Pending'
        ];

        $class = $classes[$status] ?? 'badge-soft-secondary';
        $label = $labels[$status] ?? ucfirst($status);

        return "<span class='badge {$class}'>{$label}</span>";
    }

    /**
     * Verify payment after Stripe redirect
     */
    public function verifyPayment(Request $request, string $reference)
    {
        try {
            $sessionId = $request->get('session_id');
            
            if (!$sessionId) {
                return redirect()->route('owner.subscription.failed', ['reference' => $reference])
                    ->with('error', 'Invalid payment session.');
            }

            // Retrieve the subscription
            $studioPlan = StudioPlanModel::where('subscription_reference', $reference)->first();
            
            if (!$studioPlan) {
                Log::error('Subscription not found for verification', ['reference' => $reference]);
                return redirect()->route('owner.subscription.failed', ['reference' => $reference])
                    ->with('error', 'Subscription record not found.');
            }

            // Retrieve the checkout session from Stripe
            $session = $this->stripeService->retrieveCheckoutSession($sessionId);
            
            if (!$session) {
                return redirect()->route('owner.subscription.failed', ['reference' => $reference])
                    ->with('error', 'Failed to retrieve payment information.');
            }

            // Check if payment was successful
            if ($session['payment_status'] === 'paid') {
                DB::beginTransaction();
                
                try {
                    // Update subscription as paid
                    $studioPlan->update([
                        'payment_status' => 'paid',
                        'status' => 'active',
                        'paid_at' => now(),
                        'stripe_payment_intent_id' => $session['payment_intent'] ?? null,
                        'stripe_response' => $session,
                    ]);

                    DB::commit();

                    Log::info('Subscription payment verified', [
                        'subscription_reference' => $reference,
                        'session_id' => $sessionId
                    ]);

                    return redirect()->route('owner.subscription.success', ['reference' => $reference]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Failed to update subscription after payment', [
                        'error' => $e->getMessage(),
                        'reference' => $reference
                    ]);
                    
                    return redirect()->route('owner.subscription.failed', ['reference' => $reference])
                        ->with('error', 'Failed to update subscription status.');
                }
            }

            // Payment not successful
            return redirect()->route('owner.subscription.failed', ['reference' => $reference])
                ->with('error', 'Payment was not successful.');

        } catch (\Exception $e) {
            Log::error('Payment verification failed', [
                'error' => $e->getMessage(),
                'reference' => $reference
            ]);

            return redirect()->route('owner.subscription.failed', ['reference' => $reference])
                ->with('error', 'Payment verification failed.');
        }
    }

    /**
     * Handle successful payment
     */
    public function paymentSuccess(string $reference)
    {
        $studioPlan = StudioPlanModel::where('subscription_reference', $reference)->first();
        
        if (!$studioPlan) {
            return redirect()->route('owner.subscription.index')
                ->with('error', 'Subscription not found.');
        }

        return view('owner.subscription-success', [
            'subscription' => $studioPlan,
            'plan' => $studioPlan->plan
        ]);
    }

    /**
     * Handle failed payment
     */
    public function paymentFailed(string $reference)
    {
        $studioPlan = StudioPlanModel::where('subscription_reference', $reference)->first();
        
        // Update status to failed if needed
        if ($studioPlan && $studioPlan->payment_status === 'pending') {
            $studioPlan->update([
                'payment_status' => 'failed',
                'status' => 'cancelled'
            ]);
        }

        return view('owner.subscription-failed', [
            'subscription' => $studioPlan,
            'error' => session('error', 'Payment was cancelled or failed.')
        ]);
    }
}