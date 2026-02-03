
<?php $__env->startSection('title', 'Freelancers'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    <div data-table data-table-rows-per-page="5" class="card">
                        
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">List of Freelancers</h4>
                            </div>

                            <div class="card-header border-light justify-content-between">
                                <div class="d-flex gap-2">
                                    <div class="app-search">
                                        <input type="search" class="form-control" placeholder="Search..." id="freelancerSearch">
                                        <i data-lucide="search" class="app-search-icon text-muted"></i>
                                    </div>
                                    <button class="btn btn-danger d-none">Delete</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                    <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                        <tr class="text-uppercase fs-xxs">
                                            <th data-table-sort>Freelancer Fullname</th>
                                            <th data-table-sort>Email Address</th>
                                            <th data-table-sort>Contact Number</th>
                                            <th data-table-sort>Role</th>
                                            <th data-table-sort>Status</th>
                                            <th data-table-sort>Registration Date</th>
                                            <th class="text-center" style="width: 1%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="freelancerTableBody">
                                        <?php $__currentLoopData = $freelancers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $freelancer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $profile = $freelancer->freelancerProfile;
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <a href="#" class="link-reset" data-bs-toggle="modal" data-bs-target="#freelancerModal<?php echo e($freelancer->id); ?>">
                                                                <?php echo e($freelancer->first_name); ?> <?php echo e($freelancer->last_name); ?>

                                                            </a>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="fw-medium">UUID:</span>
                                                            <span class="text-muted"><?php echo e($freelancer->uuid); ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo e($freelancer->email); ?></td>
                                            <td><?php echo e($freelancer->mobile_number); ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <a href="#" class="link-reset"><?php echo e(ucfirst($freelancer->role)); ?></a>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="text-muted"><?php echo e(ucfirst($freelancer->user_type)); ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($freelancer->status === 'active'): ?>
                                                    <span class="badge badge-soft-success fs-8 px-1 w-100">ACTIVE</span>
                                                <?php elseif($freelancer->status === 'inactive'): ?>
                                                    <span class="badge badge-soft-warning fs-8 px-1 w-100">INACTIVE</span>
                                                <?php else: ?>
                                                    <span class="badge badge-soft-danger fs-8 px-1 w-100"><?php echo e(strtoupper($freelancer->status)); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($freelancer->created_at->format('F d, Y')); ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="#" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#freelancerModal<?php echo e($freelancer->id); ?>">
                                                        <i class="ti ti-eye fs-lg"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm"><i class="ti ti-edit fs-lg"></i></a>
                                                    <a href="#" class="btn btn-sm"><i class="ti ti-trash fs-lg"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="card-footer border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div data-table-pagination-info="users"></div>
                                    <div data-table-pagination></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php $__currentLoopData = $freelancers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $freelancer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $profile = $freelancer->freelancerProfile;
            $portfolioWorks = $profile ? (is_array($profile->portfolio_works) ? $profile->portfolio_works : json_decode($profile->portfolio_works, true)) : [];
            
            // Prepare operating days
            $operatingDays = [];
            if ($profile && $profile->schedule && $profile->schedule->operating_days) {
                $days = json_decode($profile->schedule->operating_days, true);
                $dayNames = [
                    'monday' => 'Monday',
                    'tuesday' => 'Tuesday',
                    'wednesday' => 'Wednesday',
                    'thursday' => 'Thursday',
                    'friday' => 'Friday',
                    'saturday' => 'Saturday',
                    'sunday' => 'Sunday'
                ];
                
                if (is_array($days)) {
                    foreach ($days as $day) {
                        if (isset($dayNames[$day])) {
                            $operatingDays[] = $dayNames[$day];
                        }
                    }
                }
            }
        ?>
        
        <div class="modal fade" id="freelancerModal<?php echo e($freelancer->id); ?>" tabindex="-1" aria-labelledby="freelancerModalLabel<?php echo e($freelancer->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="freelancerModalLabel<?php echo e($freelancer->id); ?>">Freelancer Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row align-items-center mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center flex-column flex-md-row">
                                        <div class="flex-shrink-0 mb-3 mb-md-0">
                                            <img src="<?php echo e($freelancer->profile_photo ? asset('storage/' . $freelancer->profile_photo) : asset('assets/images/users/user-default.jpg')); ?>" 
                                                class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;" 
                                                alt="<?php echo e($freelancer->first_name); ?> <?php echo e($freelancer->last_name); ?>">
                                        </div>

                                        <div class="flex-grow-1 ms-md-4 text-center text-md-start">
                                            <h3 class="mb-1 fw-bold"><?php echo e($freelancer->first_name); ?> <?php echo e($freelancer->last_name); ?></h3>
                                            <?php if($profile && $profile->brand_name): ?>
                                            <p class="text-primary fw-semibold mb-1"><?php echo e($profile->brand_name); ?></p>
                                            <?php endif; ?>
                                            <p class="text-muted mb-0">
                                                <i class="ti ti-map-pin me-1"></i> 
                                                <?php if($profile && $profile->location): ?>
                                                    <?php echo e($profile->location->municipality ?? 'N/A'); ?>, <?php echo e($profile->location->province ?? 'N/A'); ?>

                                                <?php else: ?>
                                                    Location not set
                                                <?php endif; ?>
                                                · Since <?php echo e($freelancer->created_at->format('Y')); ?>

                                            </p>
                                            <div class="mt-2">
                                                <?php if($freelancer->email_verified): ?>
                                                <span class="badge badge-soft-success fs-6 p-1 ms-1">Verified Email</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <h5 class="text-primary fw-semibold mb-3">Personal Information</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="user" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Full Name</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($freelancer->first_name); ?> <?php echo e($freelancer->last_name); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="mail" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Email Address</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($freelancer->email); ?></p>
                                                    <small class="text-muted">Status: <?php echo e($freelancer->email_verified ? 'Verified' : 'Not Verified'); ?></small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="phone" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Mobile Number</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($freelancer->mobile_number); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="calendar" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Registered Since</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($freelancer->created_at->format('F d, Y')); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="shield" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Account Status</label>
                                                    <p class="mb-0 fw-medium">
                                                        <span class="badge badge-soft-<?php echo e($freelancer->status === 'active' ? 'success' : ($freelancer->status === 'inactive' ? 'warning' : 'danger')); ?>">
                                                            <?php echo e(strtoupper($freelancer->status)); ?>

                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="user-check" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">User Type</label>
                                                    <p class="mb-0 fw-medium"><?php echo e(ucfirst($freelancer->role)); ?> <?php echo e(ucfirst($freelancer->user_type)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if($profile): ?>
                                
                                <?php if($profile->brand_name || $profile->tagline || $profile->bio): ?>
                                <div class="col-12">
                                    <h5 class="text-primary fw-semibold mb-3">Brand Identity</h5>
                                    <div class="row g-3">
                                        <?php if($profile->brand_name): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="building" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Brand Name</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($profile->brand_name); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->tagline): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="info" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Professional Tagline</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($profile->tagline); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->bio): ?>
                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="file-text" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">About Me</label>
                                                    <p class="mb-0"><?php echo e($profile->bio); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->years_experience): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="calendar" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Years of Experience</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($profile->years_experience); ?> <?php echo e(Str::plural('year', $profile->years_experience)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <?php if($profile->street || $profile->barangay || $profile->service_area): ?>
                                <div class="col-12">
                                    <h5 class="text-primary fw-semibold mb-3">Location & Service Coverage</h5>
                                    <div class="row g-3">
                                        <?php if($profile->location): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="map" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Province</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($profile->location->province ?? 'N/A'); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="map-pin" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Municipality / Barangay</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($profile->location->municipality ?? 'N/A'); ?> · <?php echo e($profile->barangay); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->street): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="home" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Street Address</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($profile->street); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->service_area): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="navigation" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Service Coverage</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($profile->service_area); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <?php if($profile && ($profile->categories->count() > 0 || $profile->services->count() > 0 || $profile->starting_price || $profile->deposit_policy)): ?>
                                <div class="col-12">
                                    <h5 class="text-primary fw-semibold mb-3">Services & Pricing</h5>
                                    <div class="row g-3">
                                        
                                        <?php if($profile->services->count() > 0): ?>
                                        <div class="col-12 mb-3">
                                            <label class="text-muted small mb-1">Services Offered</label>
                                            <div class="list-group">
                                                <?php $__currentLoopData = $profile->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-group-item">
                                                    <div class="d-flex align-items-start">
                                                        <i class="ti ti-check text-success me-2 mt-1"></i>
                                                        <div class="flex-grow-1">
                                                            <h5 class="mb-1 fw-semibold">
                                                                <?php echo e($service->category->category_name ?? 'Services'); ?>

                                                            </h5>
                                                            
                                                            <?php if($service->services_name): ?>
                                                                <div class="mt-2">
                                                                    <ul class="mb-2 ps-3">
                                                                        <?php
                                                                            // Handle both array and JSON string formats
                                                                            $serviceNames = is_array($service->services_name) 
                                                                                ? $service->services_name 
                                                                                : json_decode($service->services_name, true);
                                                                            
                                                                            // Ensure we have an array
                                                                            $serviceNames = is_array($serviceNames) ? $serviceNames : [$service->services_name];
                                                                        ?>
                                                                        
                                                                        <?php $__currentLoopData = $serviceNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <li class="text-muted mb-1"><?php echo e($serviceName); ?></li>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </ul>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                        
                                        <?php elseif($profile->categories->count() > 0): ?>
                                        <div class="col-12 mb-3">
                                            <label class="text-muted small mb-1">Service Categories</label>
                                            <div class="list-group">
                                                <?php $__currentLoopData = $profile->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-group-item">
                                                    <div class="d-flex align-items-start">
                                                        <i class="ti ti-check text-success me-2 mt-1"></i>
                                                        <div>
                                                            <h5 class="mb-1 fw-semibold"><?php echo e($category->category_name); ?></h5>
                                                            <?php if($category->description): ?>
                                                            <p class="text-muted mb-0"><?php echo e($category->description); ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->starting_price): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="tag" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Starting Price</label>
                                                    <p class="mb-0 fs-5">PHP <?php echo e(number_format($profile->starting_price, 2)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->deposit_policy): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="banknote-arrow-down" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Deposit Policy</label>
                                                    <p class="mb-0 fw-medium">
                                                        <?php echo e($profile->deposit_policy == 'required' ? 'Required' : 'Not Required'); ?>

                                                        <?php if($profile->deposit_policy == 'required'): ?>
                                                        (50% upon booking)
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <?php if($profile->schedule): ?>
                                <div class="col-12">
                                    <h5 class="text-primary fw-semibold mb-3">Availability and Schedule</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="calendar-days" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Operating Days</label>
                                                    <p class="mb-0 fw-medium"><?php echo e(!empty($operatingDays) ? implode(', ', $operatingDays) : 'Not set'); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if($profile->schedule->start_time && $profile->schedule->end_time): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="clock" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Operating Hours</label>
                                                    <p class="mb-0 fw-medium">
                                                        <?php echo e(date('h:i A', strtotime($profile->schedule->start_time))); ?> – 
                                                        <?php echo e(date('h:i A', strtotime($profile->schedule->end_time))); ?>

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->schedule->booking_limit): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="users" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Max Clients per Day</label>
                                                    <p class="mb-0 fw-medium"><?php echo e($profile->schedule->booking_limit); ?> <?php echo e(Str::plural('client', $profile->schedule->booking_limit)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->schedule->advance_booking): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="alert-circle" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Advance Booking</label>
                                                    <p class="mb-0 fw-medium">Minimum <?php echo e($profile->schedule->advance_booking); ?> <?php echo e(Str::plural('day', $profile->schedule->advance_booking)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <?php if(!empty($portfolioWorks) && count($portfolioWorks) > 0): ?>
                                <div class="col-12">
                                    <h5 class="text-primary fw-semibold mb-3">Personal Portfolio</h5>
                                    <p class="text-muted">Sample works and recent projects</p>

                                    <div id="portfolioCarousel<?php echo e($freelancer->id); ?>" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php $__currentLoopData = $portfolioWorks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $portfolio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                                <img src="<?php echo e(asset('storage/' . $portfolio)); ?>" 
                                                    class="d-block w-100 rounded shadow" 
                                                    alt="Portfolio <?php echo e($index + 1); ?>" 
                                                    style="height: 300px; object-fit: cover;">
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php if(count($portfolioWorks) > 1): ?>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#portfolioCarousel<?php echo e($freelancer->id); ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#portfolioCarousel<?php echo e($freelancer->id); ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <?php if($profile->facebook_url || $profile->instagram_url || $profile->website_url): ?>
                                <div class="col-12">
                                    <h5 class="text-primary fw-semibold mb-3">Social Media and Portfolio Links</h5>
                                    <div class="row g-3">
                                        <?php if($profile->facebook_url): ?>
                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="facebook" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Facebook Link</label>
                                                    <p class="mb-0 fw-medium">
                                                        <a href="<?php echo e($profile->facebook_url); ?>" target="_blank" class="text-decoration-none">
                                                            <?php echo e($profile->facebook_url); ?>

                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->instagram_url): ?>
                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="instagram" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Instagram Link</label>
                                                    <p class="mb-0 fw-medium">
                                                        <a href="<?php echo e($profile->instagram_url); ?>" target="_blank" class="text-decoration-none">
                                                            <?php echo e($profile->instagram_url); ?>

                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($profile->website_url): ?>
                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="globe" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Website Link</label>
                                                    <p class="mb-0 fw-medium">
                                                        <a href="<?php echo e($profile->website_url); ?>" target="_blank" class="text-decoration-none">
                                                            <?php echo e($profile->website_url); ?>

                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php else: ?>
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i data-lucide="info" class="me-2"></i>
                                        This freelancer hasn't completed their profile setup yet.
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Simple search functionality
            $('#freelancerSearch').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                
                $('#freelancerTableBody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // Initialize all carousels when modals are shown
            $('.modal').on('shown.bs.modal', function(event) {
                const modalId = $(event.target).attr('id');
                const freelancerId = modalId.replace('freelancerModal', '');
                const carouselId = '#portfolioCarousel' + freelancerId;
                
                if ($(carouselId).length) {
                    const carousel = new bootstrap.Carousel($(carouselId)[0]);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/admin/view-freelancers.blade.php ENDPATH**/ ?>