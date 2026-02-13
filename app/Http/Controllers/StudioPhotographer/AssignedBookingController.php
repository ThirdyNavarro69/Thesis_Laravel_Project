<?php

namespace App\Http\Controllers\StudioPhotographer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudioOwner\BookingAssignedPhotographerModel;
use App\Models\BookingModel;
use App\Models\StudioOwner\StudiosModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StudioPhotographer\UpdateAssignmentStatusRequest;

class AssignedBookingController extends Controller
{
    /**
     * Display assigned bookings for the photographer
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get all assignments for this photographer
        $assignments = BookingAssignedPhotographerModel::where('photographer_id', $userId)
            ->with([
                'booking:id,booking_reference,client_id,event_name,event_date,start_time,end_time,total_amount,status,payment_status',
                'booking.client:id,first_name,last_name,email,mobile_number',
                'studio:id,studio_name',
                'assigner:id,first_name,last_name'
            ])
            ->orderBy('assigned_at', 'desc')
            ->get();
        
        return view('studio-photographer.view-assigned-booking', compact('assignments'));
    }

    /**
     * Get booking details for modal view
     */
    public function getBookingDetails($assignmentId)
    {
        try {
            $userId = Auth::id();
            
            // Get the assignment with related data
            $assignment = BookingAssignedPhotographerModel::where('id', $assignmentId)
                ->where('photographer_id', $userId)
                ->with([
                    'booking' => function($query) {
                        $query->with([
                            'client:id,first_name,last_name,email,mobile_number',
                            'category:id,category_name',
                            'packages:id,booking_id,package_name,package_price,package_inclusions,duration,maximum_edited_photos,coverage_scope',
                            'payments:id,booking_id,amount,status,payment_method,paid_at'
                        ]);
                    },
                    'studio:id,studio_name,studio_logo',
                    'assigner:id,first_name,last_name'
                ])
                ->firstOrFail();
            
            // Get the studio if not loaded through relationship
            if (!$assignment->studio && $assignment->studio_id) {
                $assignment->studio = StudiosModel::find($assignment->studio_id);
            }
            
            // Get the booking
            $booking = $assignment->booking;
            
            // Get studio relationship from booking if it exists
            if ($booking && $booking->studio) {
                $studio = $booking->studio;
            } else {
                $studio = $assignment->studio;
            }
            
            return response()->json([
                'success' => true,
                'assignment' => $assignment,
                'booking' => $booking,
                'studio' => $studio,
                'assigner' => $assignment->assigner
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching booking details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update assignment status (confirm/complete/cancel)
     */
    public function updateAssignmentStatus(UpdateAssignmentStatusRequest $request, $assignmentId)
    {
        try {
            $userId = Auth::id();
            
            $assignment = BookingAssignedPhotographerModel::where('id', $assignmentId)
                ->where('photographer_id', $userId)
                ->firstOrFail();
            
            // Prevent updating if already cancelled
            if ($assignment->status === 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'This assignment has already been cancelled.'
                ]);
            }
            
            // For completed status, check if booking is fully paid
            if ($request->status === 'completed') {
                $booking = BookingModel::find($assignment->booking_id);
                
                // Calculate total paid
                $totalPaid = $booking->payments()->where('status', 'succeeded')->sum('amount');
                
                if ($totalPaid < $booking->total_amount) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot mark assignment as completed because the booking is not fully paid. Remaining balance: PHP ' . number_format($booking->total_amount - $totalPaid, 2)
                    ]);
                }
            }
            
            $updateData = ['status' => $request->status];
            
            switch ($request->status) {
                case 'confirmed':
                    $updateData['confirmed_at'] = now();
                    break;
                case 'completed':
                    $updateData['completed_at'] = now();
                    
                    // Also update booking status to in_progress if it's still pending/confirmed
                    $booking = BookingModel::find($assignment->booking_id);
                    if (in_array($booking->status, ['pending', 'confirmed'])) {
                        $booking->status = 'in_progress';
                        $booking->save();
                    }
                    break;
                case 'cancelled':
                    $updateData['cancelled_at'] = now();
                    $updateData['cancellation_reason'] = $request->cancellation_reason;
                    break;
            }
            
            $assignment->update($updateData);
            
            return response()->json([
                'success' => true,
                'message' => 'Assignment status updated successfully.',
                'assignment' => $assignment
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating assignment status: ' . $e->getMessage()
            ], 500);
        }
    }
}