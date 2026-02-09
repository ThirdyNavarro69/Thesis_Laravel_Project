<?php

namespace App\Http\Controllers\StudioOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingModel;
use App\Models\BookingPackageModel;
use App\Models\PaymentModel;
use App\Models\StudioOwner\BookingAssignedPhotographerModel;
use App\Models\StudioOwner\StudiosModel;
use App\Models\StudioOwner\StudioPhotographersModel;
use App\Models\UserModel;
use App\Models\Admin\CategoriesModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        // Get the current studio owner's user ID
        $userId = Auth::id();
        
        // Get the studio owned by this user
        $studio = StudiosModel::where('user_id', $userId)->first();
        
        if (!$studio) {
            return view('owner.view-bookings')->with('error', 'No studio found for this account.');
        }
        
        // Get bookings for this studio (current and upcoming)
        $bookings = BookingModel::where('provider_id', $studio->id)
            ->where('booking_type', 'studio')
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->orderBy('event_date', 'asc')
            ->with([
                'client:id,first_name,last_name,email,mobile_number',
                'category:id,category_name',
                'packages:id,booking_id,package_name,package_price',
                'payments:id,booking_id,amount,status'
            ])
            ->get();
        
        return view('owner.view-bookings', compact('bookings', 'studio'));
    }

    public function history()
    {
        // Get the current studio owner's user ID
        $userId = Auth::id();
        
        // Get the studio owned by this user
        $studio = StudiosModel::where('user_id', $userId)->first();
        
        if (!$studio) {
            return view('owner.booking-history')->with('error', 'No studio found for this account.');
        }
        
        // Get completed/cancelled bookings for this studio
        $bookings = BookingModel::where('provider_id', $studio->id)
            ->where('booking_type', 'studio')
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('event_date', 'desc')
            ->with([
                'client:id,first_name,last_name,email,mobile_number',
                'category:id,category_name',
                'packages:id,booking_id,package_name,package_price',
                'payments:id,booking_id,amount,status'
            ])
            ->get();
        
        return view('owner.booking-history', compact('bookings', 'studio'));
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
                'payments:id,booking_id,amount,status,payment_method,paid_at',
                'assignedPhotographers.photographer:id,first_name,last_name',
                'assignedPhotographers.studioPhotographer:id,photographer_id,position,specialization,years_of_experience'
            ])->findOrFail($id);
            
            // Check if booking belongs to the studio owner
            $userId = Auth::id();
            $studio = StudiosModel::where('user_id', $userId)->first();
            
            if (!$studio || $booking->provider_id != $studio->id) {
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
                'payments' => $booking->payments,
                'assignedPhotographers' => $booking->assignedPhotographers
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching booking details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available photographers for assignment
     */
    public function getAvailablePhotographers($bookingId)
    {
        try {
            $booking = BookingModel::findOrFail($bookingId);
            
            // Check if booking belongs to the studio owner
            $userId = Auth::id();
            $studio = StudiosModel::where('user_id', $userId)->first();
            
            if (!$studio || $booking->provider_id != $studio->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this booking.'
                ], 403);
            }
            
            // Get all photographers from this studio
            $photographers = StudioPhotographersModel::where('studio_id', $studio->id)
                ->where('status', 'active')
                ->with(['photographer:id,first_name,last_name'])
                ->get();
            
            // Get already assigned photographers for this booking
            $assignedPhotographerIds = BookingAssignedPhotographerModel::where('booking_id', $bookingId)
                ->whereIn('status', ['assigned', 'confirmed'])
                ->pluck('photographer_id')
                ->toArray();
            
            // Check photographer availability for the booking date
            $availablePhotographers = [];
            foreach ($photographers as $photographer) {
                // Check if photographer is already assigned
                if (in_array($photographer->photographer_id, $assignedPhotographerIds)) {
                    continue;
                }
                
                // Check if photographer has other bookings on the same date
                $hasConflict = BookingAssignedPhotographerModel::where('photographer_id', $photographer->photographer_id)
                    ->whereHas('booking', function ($query) use ($booking) {
                        $query->where('event_date', $booking->event_date)
                            ->whereIn('status', ['confirmed', 'in_progress']);
                    })
                    ->whereIn('status', ['assigned', 'confirmed'])
                    ->exists();
                
                if (!$hasConflict) {
                    $availablePhotographers[] = [
                        'id' => $photographer->photographer_id,
                        'studio_photographer_id' => $photographer->id,
                        'name' => $photographer->photographer->first_name . ' ' . $photographer->photographer->last_name,
                        'position' => $photographer->position,
                        'specialization' => $photographer->specialization,
                        'years_experience' => $photographer->years_of_experience,
                        'status' => 'available'
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'photographers' => $availablePhotographers,
                'booking' => [
                    'id' => $booking->id,
                    'reference' => $booking->booking_reference,
                    'event_date' => $booking->event_date->format('Y-m-d'),
                    'event_name' => $booking->event_name,
                    'category' => $booking->category ? $booking->category->category_name : 'N/A'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching photographers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assign photographers to booking
     */
    public function assignPhotographers(Request $request, $bookingId)
    {
        try {
            $request->validate([
                'photographer_ids' => 'required|array|min:1',
                'photographer_ids.*' => 'exists:tbl_users,id',
                'assignment_notes' => 'nullable|string|max:500'
            ]);
            
            $booking = BookingModel::findOrFail($bookingId);
            
            // Check if booking belongs to the studio owner
            $userId = Auth::id();
            $studio = StudiosModel::where('user_id', $userId)->first();
            
            if (!$studio || $booking->provider_id != $studio->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this booking.'
                ], 403);
            }
            
            $assignedPhotographers = [];
            
            foreach ($request->photographer_ids as $photographerId) {
                // Check if photographer belongs to this studio
                $studioPhotographer = StudioPhotographersModel::where('studio_id', $studio->id)
                    ->where('photographer_id', $photographerId)
                    ->where('status', 'active')
                    ->first();
                
                if (!$studioPhotographer) {
                    continue; // Skip if photographer doesn't belong to this studio
                }
                
                // Check if already assigned
                $existingAssignment = BookingAssignedPhotographerModel::where('booking_id', $bookingId)
                    ->where('photographer_id', $photographerId)
                    ->whereIn('status', ['assigned', 'confirmed'])
                    ->exists();
                
                if ($existingAssignment) {
                    continue; // Skip if already assigned
                }
                
                // Create assignment
                $assignment = BookingAssignedPhotographerModel::create([
                    'booking_id' => $bookingId,
                    'studio_id' => $studio->id,
                    'photographer_id' => $photographerId,
                    'assigned_by' => $userId,
                    'status' => 'assigned',
                    'assignment_notes' => $request->assignment_notes,
                    'assigned_at' => now()
                ]);
                
                $assignedPhotographers[] = $assignment;
            }
            
            if (empty($assignedPhotographers)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No photographers were assigned. They might already be assigned or not available.'
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => count($assignedPhotographers) . ' photographer(s) assigned successfully.',
                'assignments' => $assignedPhotographers
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning photographers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove photographer assignment
     */
    public function removePhotographerAssignment($assignmentId)
    {
        try {
            $assignment = BookingAssignedPhotographerModel::findOrFail($assignmentId);
            
            // Check if assignment belongs to the studio owner
            $userId = Auth::id();
            $studio = StudiosModel::where('user_id', $userId)->first();
            
            if (!$studio || $assignment->studio_id != $studio->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this assignment.'
                ], 403);
            }
            
            $assignment->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Photographer assignment removed successfully.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing assignment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update assignment status
     */
    public function updateAssignmentStatus(Request $request, $assignmentId)
    {
        try {
            $request->validate([
                'status' => 'required|in:confirmed,completed,cancelled',
                'cancellation_reason' => 'required_if:status,cancelled|nullable|string|max:500'
            ]);
            
            $assignment = BookingAssignedPhotographerModel::findOrFail($assignmentId);
            
            // Check if assignment belongs to the studio owner
            $userId = Auth::id();
            $studio = StudiosModel::where('user_id', $userId)->first();
            
            if (!$studio || $assignment->studio_id != $studio->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this assignment.'
                ], 403);
            }
            
            $updateData = ['status' => $request->status];
            
            switch ($request->status) {
                case 'confirmed':
                    $updateData['confirmed_at'] = now();
                    break;
                case 'completed':
                    $updateData['completed_at'] = now();
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