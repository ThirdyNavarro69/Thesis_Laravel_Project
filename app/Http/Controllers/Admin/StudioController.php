<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudioOwner\StudiosModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudioApprovedMail;
use App\Mail\StudioRejectedMail;

class StudioController extends Controller
{
    public function index()
    {
        $studios = StudiosModel::with(['user', 'location', 'category', 'categories', 'schedules'])
            ->whereIn('status', ['verified', 'active', 'inactive'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.view-studios', compact('studios'));
    }

    public function pending()
    {
        $studios = StudiosModel::with(['user', 'location', 'category', 'categories', 'schedules'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.pending-studios', compact('studios'));
    }

    public function approve(Request $request, $id)
    {
        try {
            $studio = StudiosModel::with('user')->findOrFail($id);
            
            $studio->update([
                'status' => 'verified',
                'rejection_note' => null, // Clear any previous rejection note
            ]);
            
            // Send approval email to studio owner
            Mail::to($studio->user->email)->send(new StudioApprovedMail($studio));
            
            return response()->json([
                'success' => true,
                'message' => 'Studio approved successfully! Email notification sent to owner.',
                'alert_color' => '#007BFF', // Blue for success
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve studio: ' . $e->getMessage(),
                'alert_color' => '#DC3545' // Red for error
            ], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'rejection_note' => 'required|string|min:10|max:500',
            ]);
            
            $studio = StudiosModel::with('user')->findOrFail($id);
            
            $studio->update([
                'status' => 'rejected',
                'rejection_note' => $request->rejection_note,
            ]);
            
            // Send rejection email to studio owner
            Mail::to($studio->user->email)->send(new StudioRejectedMail($studio));
            
            return response()->json([
                'success' => true,
                'message' => 'Studio rejected successfully. Email notification sent to owner.',
                'alert_color' => '#007BFF', // Blue for success
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
                'alert_color' => '#DC3545' // Red for error
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject studio: ' . $e->getMessage(),
                'alert_color' => '#DC3545' // Red for error
            ], 500);
        }
    }

    // public function destroy($id)
    // {
    //     try {
    //         $studio = StudiosModel::findOrFail($id);
            
    //         // Delete files if needed
    //         // $this->deleteFile($studio->studio_logo);
    //         // $this->deleteFile($studio->business_permit);
    //         // $this->deleteFile($studio->owner_id_document);
            
    //         $studio->delete();
            
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Studio deleted successfully.',
    //             'alert_color' => '#007BFF' // Blue for success
    //         ]);
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to delete studio: ' . $e->getMessage(),
    //             'alert_color' => '#DC3545' // Red for error
    //         ], 500);
    //     }
    // }
}