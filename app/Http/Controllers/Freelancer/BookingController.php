<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingModel;
use App\Models\BookingPackageModel;
use App\Models\PaymentModel;
use App\Models\UserModel;
use App\Models\Admin\CategoriesModel;
use App\Models\Freelancer\ProfileModel;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display current and upcoming bookings
     */
    public function index()
    {
        // Get the current freelancer's user ID
        $userId = Auth::id();
        
        // Get bookings for this freelancer (current and upcoming)
        $bookings = BookingModel::where('provider_id', $userId)
            ->where('booking_type', 'freelancer')
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->orderBy('event_date', 'asc')
            ->with([
                'client:id,first_name,last_name,email,mobile_number',
                'category:id,category_name',
                'packages:id,booking_id,package_name,package_price',
                'payments:id,booking_id,amount,status'
            ])
            ->get();
        
        return view('freelancer.view-bookings', compact('bookings'));
    }

    /**
     * Get booking details for modal
     */
    public function getBookingDetails($id)
    {
        try {
            $booking = BookingModel::with([
                'client:id,first_name,last_name,email,mobile_number',
                'category:id,category_name',
                'packages:id,booking_id,package_name,package_price,package_inclusions,duration,maximum_edited_photos,coverage_scope',
                'payments:id,booking_id,amount,status,payment_method,paid_at'
            ])->findOrFail($id);
            
            // Check if booking belongs to the freelancer
            $userId = Auth::id();
            
            if ($booking->provider_id != $userId || $booking->booking_type != 'freelancer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this booking.'
                ], 403);
            }
            
            return response()->json([
                'success' => true,
                'booking' => $booking,
                'client' => $booking->client,
                'category' => $booking->category,
                'packages' => $booking->packages,
                'payments' => $booking->payments
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching booking details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:confirmed,rejected,in_progress,completed,cancelled',
                'reason' => 'required_if:status,rejected,cancelled|nullable|string|max:500'
            ]);
            
            $booking = BookingModel::findOrFail($id);
            
            // Check if booking belongs to the freelancer
            $userId = Auth::id();
            
            if ($booking->provider_id != $userId || $booking->booking_type != 'freelancer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this booking.'
                ], 403);
            }
            
            $oldStatus = $booking->status;
            $newStatus = $request->status;
            
            // Validate status transition
            $allowedTransitions = [
                'pending' => ['confirmed', 'rejected', 'cancelled'],
                'confirmed' => ['in_progress', 'cancelled'],
                'in_progress' => ['completed', 'cancelled'],
            ];
            
            if (!isset($allowedTransitions[$oldStatus]) || !in_array($newStatus, $allowedTransitions[$oldStatus])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status transition from ' . $oldStatus . ' to ' . $newStatus
                ], 400);
            }
            
            $updateData = ['status' => $newStatus];
            
            // Add reason for rejection or cancellation
            if (in_array($newStatus, ['rejected', 'cancelled']) && $request->filled('reason')) {
                $updateData['cancellation_reason'] = $request->reason;
            }
            
            // Mark as completed - update completion time
            if ($newStatus === 'completed') {
                $updateData['completed_at'] = now();
            }
            
            $booking->update($updateData);
            
            // If rejected or cancelled, check if refund is needed
            if (in_array($newStatus, ['rejected', 'cancelled'])) {
                $this->handleCancellationRefund($booking);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully.',
                'booking' => $booking->fresh(['client', 'category', 'packages'])
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating booking status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'payment_status' => 'required|in:paid,partially_paid,failed,refunded',
                'amount_paid' => 'required_if:payment_status,partially_paid|nullable|numeric|min:0',
                'notes' => 'nullable|string|max:500'
            ]);
            
            $booking = BookingModel::findOrFail($id);
            
            // Check if booking belongs to the freelancer
            $userId = Auth::id();
            
            if ($booking->provider_id != $userId || $booking->booking_type != 'freelancer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this booking.'
                ], 403);
            }
            
            $updateData = ['payment_status' => $request->payment_status];
            
            // Update remaining balance if partially paid
            if ($request->payment_status === 'partially_paid' && $request->filled('amount_paid')) {
                $amountPaid = floatval($request->amount_paid);
                $totalPaid = $this->getTotalPaidAmount($booking) + $amountPaid;
                $remainingBalance = max(0, $booking->total_amount - $totalPaid);
                
                $updateData['remaining_balance'] = $remainingBalance;
                
                // Create payment record for manual payment
                PaymentModel::create([
                    'booking_id' => $booking->id,
                    'payment_reference' => PaymentModel::generatePaymentReference(),
                    'amount' => $amountPaid,
                    'payment_method' => 'manual',
                    'status' => 'succeeded',
                    'payment_details' => [
                        'type' => 'manual_payment',
                        'notes' => $request->notes,
                        'recorded_by' => $userId,
                        'recorded_at' => now()->toDateTimeString()
                    ],
                    'paid_at' => now()
                ]);
            }
            
            // If fully paid, update remaining balance to 0
            if ($request->payment_status === 'paid') {
                $updateData['remaining_balance'] = 0;
            }
            
            $booking->update($updateData);
            
            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully.',
                'booking' => $booking->fresh(['payments'])
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating payment status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display booking history (completed/cancelled)
     */
    public function history()
    {
        // Get the current freelancer's user ID
        $userId = Auth::id();
        
        // Get completed/cancelled bookings for this freelancer
        $bookings = BookingModel::where('provider_id', $userId)
            ->where('booking_type', 'freelancer')
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('event_date', 'desc')
            ->with([
                'client:id,first_name,last_name,email,mobile_number',
                'category:id,category_name',
                'packages:id,booking_id,package_name,package_price',
                'payments:id,booking_id,amount,status'
            ])
            ->get();
        
        return view('freelancer.booking-history', compact('bookings'));
    }

    /**
     * Handle cancellation refund logic
     */
    private function handleCancellationRefund($booking)
    {
        // Check if payments exist and need refund
        $payments = $booking->payments()->where('status', 'succeeded')->get();
        
        if ($payments->isNotEmpty()) {
            // In a real system, you would:
            // 1. Initiate refund through payment gateway
            // 2. Update payment records
            // 3. Send refund notification
            
            // For now, we'll just log it
            \Log::info('Booking cancelled/refund needed', [
                'booking_id' => $booking->id,
                'booking_reference' => $booking->booking_reference,
                'total_amount' => $booking->total_amount,
                'total_paid' => $payments->sum('amount')
            ]);
        }
    }

    /**
     * Get total paid amount for a booking
     */
    private function getTotalPaidAmount($booking)
    {
        return $booking->payments()
            ->where('status', 'succeeded')
            ->sum('amount');
    }
}