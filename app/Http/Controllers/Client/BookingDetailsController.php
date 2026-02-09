<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudioOwner\StudiosModel;
use App\Models\StudioOwner\PackagesModel;
use App\Models\StudioOwner\StudioScheduleModel;
use App\Models\Freelancer\ProfileModel;
use App\Models\Freelancer\PackagesModel as FreelancerPackagesModel;
use App\Models\Freelancer\FreelancerScheduleModel;
use App\Models\Admin\CategoriesModel;

class BookingDetailsController extends Controller
{
    /**
     * Display booking details for studio or freelancer.
     */
    public function index($type, $id)
    {
        if ($type === 'studio') {
            // Fetch studio details
            $studio = StudiosModel::whereIn('status', ['approved', 'active', 'verified'])
                ->with(['location', 'category', 'packages', 'schedules'])
                ->findOrFail($id);

            // Fetch all categories for the dropdown
            $categories = CategoriesModel::where('status', 'active')
                ->orderBy('category_name', 'asc')
                ->get();

            // Fetch studio packages grouped by category
            $studioPackages = PackagesModel::where('studio_id', $id)
                ->where('status', 'active')
                ->with('category')
                ->get()
                ->groupBy('category_id');

            return view('client.booking-details', compact('studio', 'categories', 'studioPackages', 'type'));
        }
        
        // For freelancer
        if ($type === 'freelancer') {
            // Fetch freelancer details by user_id
            $freelancer = ProfileModel::with(['user', 'location', 'categories', 'services', 'schedule'])
                ->whereHas('user', function($query) {
                    $query->where('status', 'active');
                })
                ->where('user_id', $id) // Changed from findOrFail($id) to where('user_id', $id)
                ->firstOrFail(); // Changed to firstOrFail()

            // Fetch all categories for the dropdown
            $categories = CategoriesModel::where('status', 'active')
                ->orderBy('category_name', 'asc')
                ->get();

            // Fetch freelancer packages grouped by category
            $freelancerPackages = FreelancerPackagesModel::where('user_id', $freelancer->user_id)
                ->where('status', 'active')
                ->with('category')
                ->get()
                ->groupBy('category_id');

            return view('client.booking-details', compact('freelancer', 'categories', 'freelancerPackages', 'type'));
        }
        
        abort(404, 'Invalid type');
    }
}