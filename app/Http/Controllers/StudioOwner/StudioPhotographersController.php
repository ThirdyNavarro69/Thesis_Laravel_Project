<?php

namespace App\Http\Controllers\StudioOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudioOwner\StudioPhotographerRequest;
use App\Models\StudioOwner\StudioPhotographersModel;
use App\Models\StudioOwner\StudioPhotographerPivotModel;
use App\Models\StudioOwner\UserModel;
use App\Models\StudioOwner\StudiosModel;
use App\Models\StudioOwner\ServicesModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudioPhotographersController extends Controller
{
    public function index()
    {
        $ownerId = auth()->id();
        
        // Get studios owned by the current user
        $studios = StudiosModel::where('user_id', $ownerId)->get();
        
        // Get studio photographers for the current owner with category name
        $photographers = StudioPhotographersModel::with([
                'photographer',
                'studio',
            ])
            ->where('owner_id', $ownerId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($photographer) {
                // Get category name
                $category = \App\Models\Admin\CategoriesModel::find($photographer->specialization);
                $photographer->category_name = $category ? $category->category_name : 'Not specified';
                return $photographer;
            });
        
        return view('owner.view-studio-photographers', compact('studios', 'photographers'));
    }

    public function create()
    {
        $ownerId = auth()->id();
        
        // Get studios owned by the current user
        $studios = StudiosModel::where('user_id', $ownerId)->get();
        
        return view('owner.create-studio-photographers', compact('studios'));
    }

    /**
     * Get services for a specific studio - grouped by category
     */
    public function getStudioServices($studioId)
    {
        $ownerId = auth()->id();
        
        // Verify the studio belongs to the owner
        $studio = StudiosModel::where('id', $studioId)
            ->where('user_id', $ownerId)
            ->firstOrFail();
        
        // Get all services for this studio
        $services = ServicesModel::where('studio_id', $studioId)
            ->with('category')
            ->get();
        
        // Group services by category
        $categories = [];
        
        foreach ($services as $service) {
            $categoryId = $service->category_id;
            $categoryName = $service->category->category_name ?? 'Uncategorized';
            
            if (!isset($categories[$categoryId])) {
                $categories[$categoryId] = [
                    'category_id' => $categoryId,
                    'category_name' => $categoryName,
                    'service_ids' => [],
                    'service_names' => [],
                    'services_count' => 0
                ];
            }
            
            // Add service ID
            $categories[$categoryId]['service_ids'][] = $service->id;
            
            // Count individual service items within the service_name JSON
            if (is_array($service->service_name)) {
                $categories[$categoryId]['services_count'] += count($service->service_name);
                $categories[$categoryId]['service_names'] = array_merge(
                    $categories[$categoryId]['service_names'],
                    $service->service_name
                );
            } elseif (is_string($service->service_name)) {
                try {
                    $decoded = json_decode($service->service_name, true);
                    if (is_array($decoded)) {
                        $categories[$categoryId]['services_count'] += count($decoded);
                        $categories[$categoryId]['service_names'] = array_merge(
                            $categories[$categoryId]['service_names'],
                            $decoded
                        );
                    } else {
                        $categories[$categoryId]['services_count']++;
                        $categories[$categoryId]['service_names'][] = $service->service_name;
                    }
                } catch (\Exception $e) {
                    $categories[$categoryId]['services_count']++;
                    $categories[$categoryId]['service_names'][] = $service->service_name;
                }
            }
        }
        
        // Convert to array and reset keys
        $categories = array_values($categories);
        
        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created studio photographer - SIMPLIFIED for single category
     */
    public function store(StudioPhotographerRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $ownerId = auth()->id();
            $uuid = Str::uuid();
            
            // Generate password: role + uuid
            $password = 'studio-photographer' . $uuid;
            
            // Create photographer user
            $photographerUser = UserModel::create([
                'uuid' => $uuid,
                'role' => 'studio-photographer',
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'user_type' => 'photographer',
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'password' => Hash::make($password),
                'profile_photo' => $this->handleProfilePhoto($request),
                'status' => $request->status,
                'email_verified' => 1,
                'verification_token' => null,
                'token_expiry' => null,
            ]);
            
            // Get selected category ID (single value now)
            $categoryId = $request->specialization;
            
            // Get all service IDs for this category in this studio
            $serviceIds = ServicesModel::where('studio_id', $request->studio_id)
                ->where('category_id', $categoryId)
                ->pluck('id')
                ->toArray();
            
            // Create studio photographer record - store single category ID
            $studioPhotographer = StudioPhotographersModel::create([
                'studio_id' => $request->studio_id,
                'owner_id' => $ownerId,
                'photographer_id' => $photographerUser->id,
                'position' => $request->position,
                'specialization' => $categoryId, // Store single category ID (not JSON)
                'years_of_experience' => $request->years_experience,
                'status' => $request->status,
            ]);
            
            // Create pivot records for ALL services in selected category
            foreach ($serviceIds as $serviceId) {
                StudioPhotographerPivotModel::create([
                    'studio_id' => $request->studio_id,
                    'owner_id' => $ownerId,
                    'photographer_id' => $photographerUser->id,
                    'services_id' => $serviceId,
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Studio photographer created successfully!',
                'data' => [
                    'photographer_id' => $photographerUser->id,
                    'password' => $password // For demo purposes only
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create studio photographer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get studio photographers list
     */
    public function getStudioPhotographers(Request $request)
    {
        $ownerId = auth()->id();
        
        $query = StudioPhotographersModel::with([
            'photographer',
            'studio',
            'services'
        ])
        ->where('owner_id', $ownerId);
        
        // Filter by studio
        if ($request->filled('studio_id')) {
            $query->where('studio_id', $request->studio_id);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('photographer', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $photographers = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 10));
        
        return response()->json([
            'success' => true,
            'data' => $photographers
        ]);
    }

    /**
     * Get photographer details
     */
    public function show($id)
    {
        $ownerId = auth()->id();
        
        $photographer = StudioPhotographersModel::with([
            'photographer',
            'studio',
            'services.category'
        ])
        ->where('id', $id)
        ->where('owner_id', $ownerId)
        ->firstOrFail();
        
        // Get category name for the specialization (single value now)
        $categoryName = null;
        if ($photographer->specialization) {
            $category = \App\Models\Admin\CategoriesModel::find($photographer->specialization);
            $categoryName = $category ? $category->category_name : null;
        }
        
        return response()->json([
            'success' => true,
            'data' => $photographer,
            'category_name' => $categoryName
        ]);
    }

    /**
     * Handle profile photo upload
     */
    private function handleProfilePhoto($request)
    {
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profiles/photographers', $filename, 'public');
            return $filename;
        }
        
        return null;
    }
}