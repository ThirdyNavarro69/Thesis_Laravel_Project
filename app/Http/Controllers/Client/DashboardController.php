<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudioOwner\StudiosModel;
use App\Models\Freelancer\ProfileModel;
use App\Models\Admin\CategoriesModel;
use App\Models\Admin\LocationModel;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function index(Request $request)
    {
        // Fetch approved studios (status = 'approved')
        $studios = StudiosModel::whereIn('status', ['approved', 'active', 'verified'])
            ->with(['location', 'category', 'packages'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch freelancers with profile data
        $freelancers = ProfileModel::with(['user', 'location', 'categories'])
            ->whereHas('user', function($query) {
                $query->where('status', 'active');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch categories for filter
        $categories = CategoriesModel::where('status', 'active')
            ->orderBy('category_name', 'asc')
            ->get();

        // Fetch locations for filter
        $locations = LocationModel::where('status', 'active')
            ->orderBy('municipality', 'asc')
            ->get();

        return view('client.dashboard', compact('studios', 'freelancers', 'categories', 'locations'));
    }

    /**
     * AJAX endpoint for filtering studios and freelancers.
     */
    public function filter(Request $request)
    {
        $query = $request->input('query', '');
        $categoryId = $request->input('category_id');
        $locationId = $request->input('location_id');
        $photographerType = $request->input('photographer_type');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $results = [];

        // Filter studios
        if (!$photographerType || $photographerType === 'studio') {
            $studioQuery = StudiosModel::whereIn('status', ['approved', 'active', 'verified'])
                ->with(['location', 'category', 'packages']);

            if ($categoryId) {
                $studioQuery->where('category_id', $categoryId);
            }

            if ($locationId) {
                $studioQuery->where('location_id', $locationId);
            }

            if ($minPrice) {
                $studioQuery->where('starting_price', '>=', $minPrice);
            }

            if ($maxPrice) {
                $studioQuery->where('starting_price', '<=', $maxPrice);
            }

            if ($query) {
                $studioQuery->where(function($q) use ($query) {
                    $q->where('studio_name', 'like', "%{$query}%")
                      ->orWhere('studio_description', 'like', "%{$query}%");
                });
            }

            $studios = $studioQuery->orderBy('created_at', 'desc')->get();
            
            foreach ($studios as $studio) {
                $results[] = [
                    'type' => 'studio',
                    'id' => $studio->id,
                    'name' => $studio->studio_name,
                    'logo' => $studio->studio_logo ? asset('storage/' . $studio->studio_logo) : asset('assets/images/sellers/7.png'),
                    'location' => $studio->location ? $studio->location->municipality . ', Cavite' : 'Location not specified',
                    'starting_price' => number_format($studio->starting_price, 2),
                    'description' => $studio->studio_description,
                    'type_label' => 'Studio'
                ];
            }
        }

        // Filter freelancers
        if (!$photographerType || $photographerType === 'freelancer') {
            $freelancerQuery = ProfileModel::with(['user', 'location', 'categories'])
                ->whereHas('user', function($q) {
                    $q->where('status', 'active');
                });

            if ($categoryId) {
                $freelancerQuery->whereHas('categories', function($q) use ($categoryId) {
                    $q->where('tbl_categories.id', $categoryId);
                });
            }

            if ($locationId) {
                $freelancerQuery->where('location_id', $locationId);
            }

            if ($minPrice) {
                $freelancerQuery->where('starting_price', '>=', $minPrice);
            }

            if ($maxPrice) {
                $freelancerQuery->where('starting_price', '<=', $maxPrice);
            }

            if ($query) {
                $freelancerQuery->where(function($q) use ($query) {
                    $q->where('brand_name', 'like', "%{$query}%")
                      ->orWhere('tagline', 'like', "%{$query}%")
                      ->orWhere('bio', 'like', "%{$query}%");
                });
            }

            $freelancers = $freelancerQuery->orderBy('created_at', 'desc')->get();
            
            foreach ($freelancers as $freelancer) {
                $results[] = [
                    'type' => 'freelancer',
                    'id' => $freelancer->user_id, // Use user_id instead of id for freelancers
                    'name' => $freelancer->brand_name,
                    'logo' => $freelancer->brand_logo ? asset('storage/' . $freelancer->brand_logo) : asset('assets/images/sellers/3.png'),
                    'location' => $freelancer->location ? $freelancer->location->municipality . ', Cavite' : 'Location not specified',
                    'starting_price' => number_format($freelancer->starting_price, 2),
                    'description' => $freelancer->tagline,
                    'type_label' => 'Freelancer'
                ];
            }
        }

        return response()->json([
            'success' => true,
            'results' => $results,
            'total' => count($results)
        ]);
    }
}