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
}