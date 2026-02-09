<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\StudioOwner\StudiosModel;
use App\Models\Freelancer\ProfileModel;
use App\Models\StudioOwner\PackagesModel as StudioPackagesModel;
use App\Models\Freelancer\PackagesModel as FreelancerPackagesModel;
use App\Models\BookingModel;
use App\Models\PaymentModel;
use App\Models\BookingPackageModel;
use App\Services\StripeService;
use Carbon\Carbon;

class BookingController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Show booking form with dynamic data
     */
    public function create($type, $id)
    {
        $user = Auth::user();
        
        if ($type === 'studio') {
            $provider = StudiosModel::whereIn('status', ['approved', 'active', 'verified'])
                ->with(['category', 'packages', 'schedules'])
                ->findOrFail($id);
            
            // Get studio categories
            $categories = $provider->categories()->where('status', 'active')->get();
        } else {
            $provider = ProfileModel::with(['user', 'categories', 'schedule'])
                ->whereHas('user', function($query) {
                    $query->where('status', 'active');
                })
                ->where('user_id', $id)
                ->firstOrFail();
            
            // Get freelancer categories
            $categories = $provider->categories()->where('status', 'active')->get();
        }

        // Get available dates for the next 60 days
        $availableDates = $this->getAvailableDates($type, $id);
        
        return view('client.booking-forms', compact('type', 'id', 'provider', 'categories', 'user', 'availableDates'));
    }

    /**
     * Get packages for selected category
     */
    public function getPackages(Request $request)
    {
        $request->validate([
            'type' => 'required|in:studio,freelancer',
            'provider_id' => 'required|integer',
            'category_id' => 'required|exists:tbl_categories,id',
        ]);

        if ($request->type === 'studio') {
            // For studio, use studio_id (provider_id is studio_id)
            $packages = \App\Models\StudioOwner\PackagesModel::where('studio_id', $request->provider_id)
                ->where('category_id', $request->category_id)
                ->where('status', 'active')
                ->get();
        } else {
            // For freelancer, use user_id (provider_id is user_id)
            $packages = \App\Models\Freelancer\PackagesModel::where('user_id', $request->provider_id)
                ->where('category_id', $request->category_id)
                ->where('status', 'active')
                ->get();
        }

        return response()->json([
            'success' => true,
            'packages' => $packages,
        ]);
    }

    /**
     * Get available dates for booking
     */
    public function getAvailableDates($type, $providerId)
    {
        $dates = [];
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(60);
        
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            // Check if date is available (for now, mark all as available)
            // You can implement logic to check against existing bookings
            $dates[] = [
                'date' => $currentDate->format('Y-m-d'),
                'available' => true,
                'is_weekend' => $currentDate->isWeekend(),
            ];
            
            $currentDate->addDay();
        }
        
        return $dates;
    }

    /**
     * Check date availability
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'type' => 'required|in:studio,freelancer',
            'provider_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        // Get existing bookings for this date
        $existingBookings = BookingModel::where('booking_type', $request->type)
            ->where('provider_id', $request->provider_id)
            ->where('event_date', $request->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        // Get provider's max bookings per day
        if ($request->type === 'studio') {
            $provider = StudiosModel::find($request->provider_id);
            $maxBookings = $provider->max_clients_per_day ?? 3;
        } else {
            $provider = ProfileModel::where('user_id', $request->provider_id)->first();
            $maxBookings = $provider->schedule->booking_limit ?? 3;
        }

        $available = $existingBookings < $maxBookings;

        return response()->json([
            'success' => true,
            'available' => $available,
            'existing_bookings' => $existingBookings,
            'max_bookings' => $maxBookings,
        ]);
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:studio,freelancer',
            'provider_id' => 'required|integer',
            'category_id' => 'required|exists:tbl_categories,id',
            'package_id' => 'required|integer',
            'event_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location_type' => 'required|in:in-studio,on-location',
            'venue_name' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'special_requests' => 'nullable|string|max:1000',
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'payment_type' => 'required|in:downpayment,full_payment',
        ]);

        try {
            // Get package details
            if ($request->type === 'studio') {
                $package = StudioPackagesModel::findOrFail($request->package_id);
            } else {
                $package = FreelancerPackagesModel::findOrFail($request->package_id);
            }

            // Calculate amounts based on payment type
            $totalAmount = $package->package_price;
            
            if ($request->payment_type === 'downpayment') {
                $downPayment = $totalAmount * 0.3; // 30% downpayment
                $remainingBalance = $totalAmount - $downPayment;
                // For downpayment, initial status is 'unpaid', will become 'partially_paid' after payment
                $paymentStatus = 'unpaid';
                $bookingStatus = 'pending';
            } else {
                // Full payment
                $downPayment = $totalAmount;
                $remainingBalance = 0;
                // For full payment, initial status is 'unpaid', will become 'paid' after payment
                $paymentStatus = 'unpaid';
                $bookingStatus = 'pending';
            }

            // Create booking
            $booking = BookingModel::create([
                'booking_reference' => BookingModel::generateBookingReference(),
                'client_id' => Auth::id(),
                'booking_type' => $request->type,
                'provider_id' => $request->provider_id,
                'category_id' => $request->category_id,
                'event_date' => $request->event_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location_type' => $request->location_type,
                'venue_name' => $request->venue_name,
                'street' => $request->street,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => 'Cavite',
                'special_requests' => $request->special_requests,
                'total_amount' => $totalAmount,
                'down_payment' => $downPayment,
                'remaining_balance' => $remainingBalance,
                'deposit_policy' => $request->payment_type === 'downpayment' ? '30%' : '100%',
                'payment_type' => $request->payment_type,
                'status' => $bookingStatus,
                'payment_status' => $paymentStatus,
            ]);

            // Create booking package record
            BookingPackageModel::create([
                'booking_id' => $booking->id,
                'package_id' => $package->id,
                'package_type' => $request->type,
                'package_name' => $package->package_name,
                'package_price' => $package->package_price,
                'package_inclusions' => json_encode($package->package_inclusions),
                'duration' => $package->duration,
                'maximum_edited_photos' => $package->maximum_edited_photos,
                'coverage_scope' => $package->coverage_scope,
            ]);

            // Create initial payment record
            $payment = PaymentModel::create([
                'booking_id' => $booking->id,
                'payment_reference' => PaymentModel::generatePaymentReference(),
                'amount' => $downPayment,
                'payment_method' => 'pending',
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'booking' => $booking,
                'payment' => $payment,
                'message' => 'Booking created successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Initialize Payment with proper redirect URLs
     */
    public function initializePayment(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:tbl_bookings,id',
        ]);

        $booking = BookingModel::with('client')->findOrFail($request->booking_id);
        $payment = $booking->payments()->where('status', 'pending')->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'No pending payment found',
            ], 404);
        }

        try {
            // Create Stripe checkout session
            $checkoutSession = $this->stripeService->createCheckoutSession(
                $payment->amount,
                $booking->booking_reference,
                'PHP',
                'Booking ' . ($booking->payment_type === 'downpayment' ? 'Deposit' : 'Payment') . ' - ' . $booking->booking_reference
            );

            if ($checkoutSession) {
                // Prepare payment details array
                $paymentDetails = [
                    'checkout_session_created' => true,
                    'checkout_url' => $checkoutSession['url'],
                    'session_id' => $checkoutSession['id'],
                    'amount' => $payment->amount,
                    'created_at' => now()->toDateTimeString(),
                    'mode' => config('services.stripe.mode', 'test'),
                ];
                
                // Update payment with checkout session ID
                $payment->update([
                    'stripe_session_id' => $checkoutSession['id'],
                    'payment_method' => 'stripe_checkout',
                    'payment_details' => $paymentDetails,
                ]);

                Log::info('Stripe Checkout Session Created', [
                    'booking_id' => $booking->id,
                    'session_id' => $checkoutSession['id'],
                    'checkout_url' => $checkoutSession['url'],
                ]);

                return response()->json([
                    'success' => true,
                    'type' => 'checkout',
                    'redirect_url' => $checkoutSession['url'],
                    'session_id' => $checkoutSession['id'],
                    'booking_reference' => $booking->booking_reference,
                    'mode' => config('services.stripe.mode', 'test'),
                    'note' => 'You will be redirected to Stripe for payment.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Payment initialization failed. Please try again or contact support.',
                'test_mode_note' => config('services.stripe.mode', 'test') === 'test' ? 
                    'Note: You are in test mode. Use test card: 4242424242424242' : 
                    '',
            ], 500);

        } catch (\Exception $e) {
            Log::error('Payment initialization error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment initialization failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify payment after redirect from Stripe
     */
    public function verifyPayment($reference, Request $request)
    {
        if (!$reference) {
            return view('client.payment-callback-error', [
                'message' => 'No booking reference provided.',
                'contact_support' => true,
            ]);
        }

        Log::info('Payment verification triggered', ['reference' => $reference]);

        // Find booking
        $booking = BookingModel::where('booking_reference', $reference)->first();
        
        if (!$booking) {
            return view('client.payment-callback-error', [
                'message' => 'Booking not found.',
                'reference' => $reference,
                'contact_support' => true,
            ]);
        }

        // Find pending payment
        $payment = $booking->payments()->where('status', 'pending')->first();
        
        if (!$payment) {
            // Check if already paid
            $paidPayment = $booking->payments()->where('status', 'succeeded')->first();
            if ($paidPayment) {
                // Redirect to success page if already paid
                return redirect()->route('client.payment.success', ['reference' => $reference]);
            }
            
            return view('client.payment-callback-error', [
                'message' => 'No pending payment found.',
                'reference' => $reference,
                'contact_support' => true,
            ]);
        }

        // Get session ID from request or payment details
        $sessionId = request()->query('session_id') ?? $payment->stripe_session_id;
        
        if (!$sessionId) {
            // If no session ID, check if payment was already processed via webhook
            if ($payment->status === 'succeeded') {
                return redirect()->route('client.payment.success', ['reference' => $reference]);
            }
            
            return view('client.payment-callback-error', [
                'message' => 'Payment session not found.',
                'reference' => $reference,
                'contact_support' => true,
            ]);
        }

        try {
            // Check Stripe checkout session status
            $sessionData = $this->stripeService->retrieveCheckoutSession($sessionId);
            
            if (!$sessionData) {
                // Try to check payment status directly from Stripe
                Log::warning('Could not retrieve Stripe session, checking payment status');
                
                // Show verifying page
                return view('client.payment-verifying', [
                    'booking' => $booking,
                    'payment' => $payment,
                    'status' => 'checking',
                    'message' => 'Checking payment status with Stripe...',
                ]);
            }

            $status = $sessionData['payment_status'] ?? 'unknown';
            
            Log::info('Stripe checkout session status', [
                'session_id' => $sessionId,
                'status' => $status,
                'reference' => $reference,
            ]);

            if ($status === 'paid') {
                // Payment successful!
                $paymentDetails = $payment->payment_details ?? [];
                $paymentDetails['verified_at'] = now()->toDateTimeString();
                $paymentDetails['stripe_status'] = $status;
                $paymentDetails['session_id'] = $sessionId;
                
                $payment->update([
                    'status' => 'succeeded',
                    'paid_at' => now(),
                    'payment_method' => 'card',
                    'payment_details' => $paymentDetails,
                ]);

                // Update booking payment status based on payment type
                if ($booking->payment_type === 'full_payment') {
                    $paymentStatus = 'paid';
                } else {
                    $paymentStatus = 'partially_paid';
                }
                
                $booking->update([
                    'payment_status' => $paymentStatus,
                    'status' => 'confirmed',
                ]);

                Log::info('Stripe payment verified successfully', [
                    'payment_id' => $payment->id,
                    'booking_id' => $booking->id,
                    'amount' => $payment->amount,
                    'payment_type' => $booking->payment_type,
                    'payment_status' => $paymentStatus,
                ]);

                // REDIRECT TO SUCCESS PAGE
                return redirect()->route('client.payment.success', ['reference' => $reference]);

            } elseif ($status === 'unpaid' || $status === 'open') {
                // Payment not yet completed
                return view('client.payment-verifying', [
                    'booking' => $booking,
                    'payment' => $payment,
                    'status' => 'pending',
                    'message' => 'Payment is still pending. Please wait or try again.',
                    'retry_url' => $payment->payment_details['checkout_url'] ?? route('client.payments.initialize'),
                ]);
                
            } else {
                // Unknown status or expired/cancelled
                return redirect()->route('client.payment.failed', ['reference' => $reference]);
            }

        } catch (\Exception $e) {
            Log::error('Payment verification error: ' . $e->getMessage());
            
            // Check if payment was already succeeded (webhook might have processed it)
            $updatedPayment = PaymentModel::find($payment->id);
            if ($updatedPayment && $updatedPayment->status === 'succeeded') {
                return redirect()->route('client.payment.success', ['reference' => $reference]);
            }
            
            return view('client.payment-verifying', [
                'booking' => $booking,
                'payment' => $payment,
                'status' => 'error',
                'message' => 'Error verifying payment. Please contact support.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Test Stripe API connection
     */
    public function testStripeConnection()
    {
        $result = $this->stripeService->testConnection();
        
        // Add additional info for test mode
        if ($this->stripeService->isTestMode) {
            $result['test_mode_info'] = [
                'test_card' => '4242424242424242',
                'test_expiry' => 'Any future date (e.g., 12/30)',
                'test_cvv' => 'Any 3 digits',
                'note' => 'Use test cards only in test mode',
            ];
        }
        
        return response()->json($result);
    }

    /**
     * Handle Stripe webhook for checkout session updates
     */
    public function handleStripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');
        
        Log::info('Stripe Webhook Received', ['signature' => $signature]);
        
        try {
            $event = $this->stripeService->verifyWebhookSignature($payload, $signature, $webhookSecret);
            
            if (!$event) {
                Log::error('Stripe webhook verification failed');
                return response()->json(['error' => 'Invalid signature'], 400);
            }
            
            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object;
                    
                    // Find payment by session ID
                    $payment = PaymentModel::where('stripe_session_id', $session->id)->first();
                    
                    if ($payment && $payment->status !== 'succeeded') {
                        $payment->update([
                            'status' => 'succeeded',
                            'paid_at' => now(),
                            'payment_method' => 'card',
                        ]);
                        
                        // Update booking
                        $booking = $payment->booking;
                        if ($booking) {
                            if ($booking->payment_type === 'full_payment') {
                                $paymentStatus = 'paid';
                            } else {
                                $paymentStatus = 'partially_paid';
                            }
                            
                            $booking->update([
                                'payment_status' => $paymentStatus,
                                'status' => 'confirmed',
                            ]);
                        }
                        
                        Log::info('Payment updated via Stripe webhook', [
                            'payment_id' => $payment->id,
                            'booking_id' => $booking->id ?? 'N/A',
                            'session_id' => $session->id,
                        ]);
                    }
                    break;
                    
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    Log::info('Payment intent succeeded', ['intent_id' => $paymentIntent->id]);
                    break;
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Test Paymongo API connection
     */
    public function testPaymongoConnection()
    {
        $result = $this->paymongoService->testConnection();
        
        // Add additional info for test mode
        if ($this->paymongoService->isTestMode) {
            $result['test_mode_info'] = [
                'limitation' => 'Test mode only supports card payments',
                'test_card' => '4111111111111111',
                'test_expiry' => 'Any future date (e.g., 12/30)',
                'test_cvv' => 'Any 3 digits',
                'note' => 'GCash, GrabPay, Maya require live merchant accounts',
            ];
        }
        
        return response()->json($result);
    }

    /**
     * Fallback: Create simple checkout session
     */
    private function createSimpleCheckoutSession($payment, $booking)
    {
        try {
            $successUrl = route('client.payment.success') . '?reference=' . $booking->booking_reference;
            $failedUrl = route('client.payment.failed');
            
            $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
                ->post('https://api.paymongo.com/v1/checkout_sessions', [
                    'data' => [
                        'attributes' => [
                            'cancel_url' => $failedUrl,
                            'success_url' => $successUrl,
                            'line_items' => [[
                                'amount' => $payment->amount * 100,
                                'currency' => 'PHP',
                                'name' => 'Booking Deposit - ' . $booking->booking_reference,
                                'quantity' => 1,
                            ]],
                            // IMPORTANT: For test mode, don't specify payment_method_types
                            // Let Paymongo decide what's available
                            'description' => 'Booking deposit for photography services',
                        ],
                    ],
                ]);
            
            if ($response->successful()) {
                $data = $response->json()['data'];
                
                $payment->update([
                    'paymongo_source_id' => $data['id'],
                    'payment_details' => json_encode([
                        'checkout_session_created' => true,
                        'checkout_url' => $data['attributes']['checkout_url'],
                        'created_at' => now()->toDateTimeString(),
                    ]),
                ]);

                return response()->json([
                    'success' => true,
                    'redirect_url' => $data['attributes']['checkout_url'],
                    'session_id' => $data['id'],
                ]);
            }
            
            // If both methods fail, show manual payment instructions for testing
            return response()->json([
                'success' => false,
                'message' => 'Payment gateway not available. For testing purposes, please use the test credentials below.',
                'test_mode' => true,
                'booking_reference' => $booking->booking_reference,
                'amount' => $payment->amount,
                'manual_test_instructions' => 'Since Paymongo test mode is not showing payment methods, you can simulate payment by marking this booking as paid manually in the database.',
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Simple checkout error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle successful payment redirect from Stripe
     */
    public function paymentSuccess(Request $request)
    {
        try {
            \Log::info('Payment success callback', [
                'query_params' => $request->query(),
                'referer' => $request->header('referer'),
                'path' => $request->path()
            ]);
            
            // Get reference from route parameter
            $reference = $request->route('reference');
            
            if (!$reference) {
                \Log::error('No booking reference found in success callback');
                return view('client.payment-callback-error', [
                    'message' => 'No booking reference provided.',
                    'contact_support' => true,
                ]);
            }
            
            // Find booking by reference
            $booking = BookingModel::where('booking_reference', $reference)->first();
            
            if (!$booking) {
                \Log::error('Booking not found for reference', ['reference' => $reference]);
                return view('client.payment-callback-error', [
                    'message' => 'Payment received but booking not found.',
                    'reference' => $reference,
                    'contact_support' => true,
                ]);
            }
            
            // Check if we have a session_id in query (direct from Stripe)
            $sessionId = $request->query('session_id');
            
            if ($sessionId) {
                // If we came directly from Stripe with session_id, redirect to verifyPayment
                \Log::info('Redirecting to verifyPayment from paymentSuccess', [
                    'reference' => $reference,
                    'session_id' => $sessionId
                ]);
                
                return redirect()->route('client.payment.verify', [
                    'reference' => $reference,
                    'session_id' => $sessionId
                ]);
            }
            
            // Find the successful payment
            $payment = $booking->payments()->where('status', 'succeeded')->latest()->first();
            
            if (!$payment) {
                // Check for any payment
                $payment = $booking->payments()->latest()->first();
                
                \Log::warning('No successful payment found for booking, showing verifying page', [
                    'booking_id' => $booking->id,
                    'payment_status' => $payment ? $payment->status : 'no payment'
                ]);
                
                // Show verifying page since payment isn't verified yet
                return view('client.payment-verifying', [
                    'booking' => $booking,
                    'payment' => $payment,
                    'status' => 'checking',
                    'message' => 'Verifying your payment...',
                ]);
            }
            
            \Log::info('Showing payment success page', [
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
                'reference' => $reference,
            ]);
            
            return view('client.payment-success', [
                'booking' => $booking,
                'payment' => $payment,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Payment success error: ' . $e->getMessage());
            return view('client.payment-callback-error', [
                'message' => 'An error occurred while processing your payment.',
                'reference' => 'Error: ' . $e->getMessage(),
                'contact_support' => true,
            ]);
        }
    }

    /**
     * Process successful payment and update records
     */
    private function processSuccessfulPayment($payment)
    {
        // Check if already processed
        if ($payment->status === 'succeeded') {
            \Log::info('Payment already marked as succeeded', ['payment_id' => $payment->id]);
            return view('client.payment-success', [
                'booking' => $payment->booking,
                'payment' => $payment,
            ]);
        }
        
        // Mark payment as succeeded
        $payment->update([
            'status' => 'succeeded',
            'paid_at' => now(),
            'payment_details' => array_merge(
                $payment->payment_details ?? [],
                [
                    'paid_at' => now()->toDateTimeString(),
                    'verified' => true,
                    'processed_via' => 'redirect_callback',
                    'callback_received' => now()->toDateTimeString(),
                ]
            ),
        ]);
        
        // Update booking status
        $payment->booking()->update([
            'payment_status' => 'partially_paid',
            'status' => 'confirmed',
        ]);
        
        \Log::info('Payment marked as successful via callback', [
            'payment_id' => $payment->id,
            'booking_id' => $payment->booking_id,
            'amount' => $payment->amount,
        ]);
        
        return view('client.payment-success', [
            'booking' => $payment->booking,
            'payment' => $payment,
        ]);
    }

    /**
     * Handle failed payment
     */
    public function paymentFailed(Request $request)
    {
        $checkoutId = $request->query('checkout_session_id');
        
        if ($checkoutId) {
            $payment = PaymentModel::where('paymongo_source_id', $checkoutId)->first();
            
            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                    'payment_details' => array_merge(
                        $payment->payment_details ?? [],
                        ['failed_at' => now()->toDateTimeString()]
                    ),
                ]);
            }
        }
        
        return view('client.payment-callback-error');
    }

    /**
     * Get booking summary
     */
    public function getSummary(Request $request)
    {
        $request->validate([
            'package_id' => 'required|integer',
            'type' => 'required|in:studio,freelancer',
            'payment_type' => 'required|in:downpayment,full_payment',
        ]);

        if ($request->type === 'studio') {
            $package = StudioPackagesModel::findOrFail($request->package_id);
        } else {
            $package = FreelancerPackagesModel::findOrFail($request->package_id);
        }

        $totalAmount = $package->package_price;
        
        if ($request->payment_type === 'downpayment') {
            $downPayment = $totalAmount * 0.3;
            $remainingBalance = $totalAmount - $downPayment;
        } else {
            $downPayment = $totalAmount;
            $remainingBalance = 0;
        }

        return response()->json([
            'success' => true,
            'summary' => [
                'package_name' => $package->package_name,
                'package_price' => number_format($package->package_price, 2),
                'total_amount' => number_format($totalAmount, 2),
                'down_payment' => number_format($downPayment, 2),
                'remaining_balance' => number_format($remainingBalance, 2),
                'inclusions' => $package->package_inclusions,
                'duration' => $package->duration,
                'maximum_edited_photos' => $package->maximum_edited_photos,
                'payment_type' => $request->payment_type,
            ],
        ]);
    }

    private function handleCheckoutSessionCompleted($data)
    {
        $checkoutSessionId = $data['id'];
        $status = $data['attributes']['status'] ?? null;
        
        if ($status === 'paid') {
            $payment = PaymentModel::where('paymongo_source_id', $checkoutSessionId)->first();
            
            if ($payment && $payment->status !== 'succeeded') {
                $payment->markAsPaid();
                $payment->booking()->update([
                    'payment_status' => 'partially_paid',
                    'status' => 'confirmed',
                ]);
                
                Log::info('Payment marked as paid via webhook', [
                    'payment_id' => $payment->id,
                    'booking_id' => $payment->booking_id,
                ]);
            }
        }
    }

    private function handlePaymentPaid($data)
    {
        // Handle paid payment webhook
        $paymentId = $data['attributes']['data']['id'] ?? null;
        
        if ($paymentId) {
            $payment = PaymentModel::where('paymongo_payment_id', $paymentId)->first();
            
            if ($payment) {
                $payment->markAsPaid();
                $payment->booking()->update(['payment_status' => 'partially_paid']);
            }
        }
    }

    /**
     * Test method to check Paymongo API directly
     */
    public function testPaymongoApi()
    {
        try {
            // Test 1: Create a simple checkout session
            $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
                ->post('https://api.paymongo.com/v1/checkout_sessions', [
                    'data' => [
                        'attributes' => [
                            'cancel_url' => route('client.payment.failed'),
                            'success_url' => route('client.payment.success') . '?test=true',
                            'line_items' => [[
                                'amount' => 10000, // 100 PHP
                                'currency' => 'PHP',
                                'name' => 'Test Payment',
                                'quantity' => 1,
                            ]],
                            'payment_method_types' => ['card', 'gcash'],
                            'description' => 'Test Payment',
                        ],
                    ],
                ]);
            
            if ($response->successful()) {
                $data = $response->json()['data'];
                return response()->json([
                    'success' => true,
                    'message' => 'Paymongo API is working',
                    'checkout_url' => $data['attributes']['checkout_url'],
                    'session_id' => $data['id'],
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Paymongo API test failed',
                'error' => $response->json(),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Get calendar availability for a specific month
     */
    public function getCalendarAvailability(Request $request)
    {
        $request->validate([
            'type' => 'required|in:studio,freelancer',
            'provider_id' => 'required|integer',
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
        ]);

        try {
            // Create start and end dates for the month
            $startDate = Carbon::create($request->year, $request->month, 1);
            $endDate = $startDate->copy()->endOfMonth();
            
            // Get provider's max bookings per day
            if ($request->type === 'studio') {
                $provider = StudiosModel::find($request->provider_id);
                $maxBookings = $provider->max_clients_per_day ?? 3;
            } else {
                $provider = ProfileModel::where('user_id', $request->provider_id)->first();
                $maxBookings = $provider->schedule->booking_limit ?? 3;
            }

            // Get existing bookings for this month
            $existingBookings = BookingModel::where('booking_type', $request->type)
                ->where('provider_id', $request->provider_id)
                ->whereBetween('event_date', [$startDate, $endDate])
                ->whereIn('status', ['pending', 'confirmed'])
                ->selectRaw('event_date, COUNT(*) as booking_count')
                ->groupBy('event_date')
                ->get()
                ->keyBy(function($item) {
                    return $item->event_date->format('Y-m-d');
                });

            // Build availability data
            $availability = [];
            $currentDate = $startDate->copy();
            
            while ($currentDate->lte($endDate)) {
                $dateString = $currentDate->format('Y-m-d');
                $bookingCount = $existingBookings[$dateString]->booking_count ?? 0;
                $available = $bookingCount < $maxBookings;
                $fullyBooked = $bookingCount >= $maxBookings;
                
                $availability[$dateString] = [
                    'date' => $dateString,
                    'available' => $available,
                    'fully_booked' => $fullyBooked,
                    'booking_count' => $bookingCount,
                    'max_bookings' => $maxBookings,
                    'is_weekend' => $currentDate->isWeekend(),
                ];
                
                $currentDate->addDay();
            }

            return response()->json([
                'success' => true,
                'availability' => $availability,
                'month' => $startDate->format('F Y'),
                'max_bookings' => $maxBookings,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get calendar availability: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Paymongo webhook for checkout session updates
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $eventType = $payload['data']['attributes']['type'] ?? null;

        Log::info('Paymongo Webhook Received', ['event_type' => $eventType]);

        if ($eventType === 'checkout_session.completed' || $eventType === 'checkout_session.paid') {
            $sessionData = $payload['data'];
            $sessionId = $sessionData['id'];
            $status = $sessionData['attributes']['status'] ?? null;
            
            if ($status === 'paid') {
                // Find payment by session ID
                $payment = PaymentModel::where('paymongo_source_id', $sessionId)->first();
                
                if ($payment && $payment->status !== 'succeeded') {
                    $payment->update([
                        'status' => 'succeeded',
                        'paid_at' => now(),
                        'payment_method' => $sessionData['attributes']['payment_method_used'] ?? 'card',
                    ]);
                    
                    // Update booking
                    $booking = $payment->booking;
                    if ($booking) {
                        if ($booking->payment_type === 'full_payment') {
                            $paymentStatus = 'paid';
                        } else {
                            $paymentStatus = 'partially_paid';
                        }
                        
                        $booking->update([
                            'payment_status' => $paymentStatus,
                            'status' => 'confirmed',
                        ]);
                    }
                    
                    Log::info('Payment updated via webhook', [
                        'payment_id' => $payment->id,
                        'booking_id' => $booking->id ?? 'N/A',
                        'status' => $status,
                    ]);
                }
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show card payment page (updated for Stripe)
     */
    public function showCardPayment($reference)
    {
        $booking = BookingModel::where('booking_reference', $reference)->firstOrFail();
        $payment = $booking->payments()->where('status', 'pending')->first();
        
        if (!$payment) {
            return redirect()->route('client.dashboard')->with('error', 'Payment session expired.');
        }
        
        // Create Stripe payment intent for direct card payment
        $paymentIntent = $this->stripeService->createPaymentIntent(
            $payment->amount,
            $booking->booking_reference,
            'PHP',
            'Booking ' . ($booking->payment_type === 'downpayment' ? 'Deposit' : 'Payment')
        );
        
        if (!$paymentIntent) {
            return redirect()->route('client.dashboard')->with('error', 'Failed to create payment session.');
        }
        
        // Update payment with intent ID
        $payment->update([
            'stripe_payment_intent_id' => $paymentIntent['id'],
        ]);
        
        return view('client.payment-card', [
            'reference' => $reference,
            'amount' => $payment->amount,
            'client_secret' => $paymentIntent['client_secret'],
            'stripe_key' => $this->stripeService->getPublicKey(),
        ]);
    }

    /**
     * Process Stripe payment (updated)
     */
    public function processStripePayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
            'booking_reference' => 'required|string',
        ]);
        
        try {
            $booking = BookingModel::where('booking_reference', $request->booking_reference)->firstOrFail();
            $payment = $booking->payments()->where('status', 'pending')->first();
            
            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found',
                ], 404);
            }
            
            // Confirm payment intent with Stripe
            $intent = $this->stripeService->stripe->paymentIntents->retrieve($payment->stripe_payment_intent_id);
            
            if ($intent->status === 'succeeded') {
                // Payment already succeeded (webhook may have processed it)
                $payment->update([
                    'status' => 'succeeded',
                    'paid_at' => now(),
                ]);
                
                // Update booking
                if ($booking->payment_type === 'full_payment') {
                    $paymentStatus = 'paid';
                } else {
                    $paymentStatus = 'partially_paid';
                }
                
                $booking->update([
                    'payment_status' => $paymentStatus,
                    'status' => 'confirmed',
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Payment successful',
                    'redirect_url' => route('client.payment.success', ['reference' => $booking->booking_reference]),
                ]);
            }
            
            // Try to confirm the payment
            $confirmedIntent = $this->stripeService->stripe->paymentIntents->confirm(
                $intent->id,
                ['payment_method' => $request->payment_method_id]
            );
            
            if ($confirmedIntent->status === 'succeeded') {
                // Payment successful
                $payment->update([
                    'status' => 'succeeded',
                    'paid_at' => now(),
                ]);
                
                // Update booking
                if ($booking->payment_type === 'full_payment') {
                    $paymentStatus = 'paid';
                } else {
                    $paymentStatus = 'partially_paid';
                }
                
                $booking->update([
                    'payment_status' => $paymentStatus,
                    'status' => 'confirmed',
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Payment successful',
                    'redirect_url' => route('client.payment.success', ['reference' => $booking->booking_reference]),
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed. Status: ' . $confirmedIntent->status,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Stripe payment processing error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment processing error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Attach payment method to payment intent
     */
    public function attachPaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
            'booking_reference' => 'required|string',
        ]);
        
        try {
            $booking = BookingModel::where('booking_reference', $request->booking_reference)->firstOrFail();
            $payment = $booking->payments()->where('status', 'pending')->first();
            
            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found',
                ], 404);
            }
            
            // Get payment details as array
            $paymentDetails = $payment->payment_details;
            
            // Attach payment method to payment intent
            $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
                ->post('https://api.paymongo.com/v1/payment_intents/' . $payment->paymongo_source_id . '/attach', [
                    'data' => [
                        'attributes' => [
                            'payment_method' => $request->payment_method_id,
                            'return_url' => route('client.payment.verify', ['reference' => $booking->booking_reference]),
                        ],
                    ],
                ]);
            
            if ($response->successful()) {
                $responseData = $response->json()['data'];
                $status = $responseData['attributes']['status'];
                
                if ($status === 'succeeded') {
                    // Payment successful
                    $paymentDetails['attached_at'] = now()->toDateTimeString();
                    $paymentDetails['payment_method_id'] = $request->payment_method_id;
                    $paymentDetails['paymongo_status'] = $status;
                    
                    $payment->update([
                        'status' => 'succeeded',
                        'paid_at' => now(),
                        'payment_details' => $paymentDetails, // Will be cast to JSON
                    ]);
                    
                    // Update booking status
                    if ($booking->payment_type === 'full_payment') {
                        $paymentStatus = 'paid';
                    } else {
                        $paymentStatus = 'partially_paid';
                    }
                    
                    $booking->update([
                        'payment_status' => $paymentStatus,
                        'status' => 'confirmed',
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Payment successful',
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed',
                'response' => $response->json(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Attach payment method error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment processing error: ' . $e->getMessage(),
            ], 500);
        }
    }
}