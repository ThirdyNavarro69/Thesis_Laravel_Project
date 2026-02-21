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

            // Fetch studio packages grouped by category
            $studioPackages = PackagesModel::where('studio_id', $id)
                ->where('status', 'active')
                ->with('category')
                ->get()
                ->groupBy('category_id');

            // Get category IDs that have active packages
            $categoryIdsWithPackages = $studioPackages->keys()->toArray();

            // Fetch only those categories
            $categories = CategoriesModel::whereIn('id', $categoryIdsWithPackages)
                ->where('status', 'active')
                ->orderBy('category_name', 'asc')
                ->get();

            return view('client.booking-details', compact('studio', 'categories', 'studioPackages', 'type'));
        }

        // For freelancer
        $freelancer = ProfileModel::with(['user', 'location', 'categories', 'services', 'schedule'])
            ->whereHas('user', function($query) {
                $query->where('status', 'active');
            })
            ->where('user_id', $id)
            ->firstOrFail();

        // Fetch freelancer packages grouped by category
        $freelancerPackages = FreelancerPackagesModel::where('user_id', $freelancer->user_id)
            ->where('status', 'active')
            ->with('category')
            ->get()
            ->groupBy('category_id');

        // Get category IDs that have active packages
        $categoryIdsWithPackages = $freelancerPackages->keys()->toArray();

        // Fetch only those categories
        $categories = CategoriesModel::whereIn('id', $categoryIdsWithPackages)
            ->where('status', 'active')
            ->orderBy('category_name', 'asc')
            ->get();

        return view('client.booking-details', compact('freelancer', 'categories', 'freelancerPackages', 'type'));
        
        abort(404, 'Invalid type');
    }
}