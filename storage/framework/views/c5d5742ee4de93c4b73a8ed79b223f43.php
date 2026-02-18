
<?php $__env->startSection('title', 'Booking Details'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-8">
                                    <div class="d-flex align-items-center flex-column flex-md-row">
                                        <div class="flex-shrink-0 mb-3 mb-md-0">
                                            <?php if($type === 'studio'): ?>
                                            <img src="<?php echo e($studio->studio_logo ? asset('storage/' . $studio->studio_logo) : asset('assets/images/sellers/7.png')); ?>"  
                                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="Studio Logo">
                                            <?php else: ?>
                                            <img src="<?php echo e($freelancer->brand_logo ? asset('storage/' . $freelancer->brand_logo) : asset('assets/images/sellers/3.png')); ?>"  
                                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="Freelancer Logo">
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="flex-grow-1 ms-md-4 text-center text-md-start">
                                            <h2 class="mb-1 h4 h3-md">
                                                <?php if($type === 'studio'): ?>
                                                    <?php echo e($studio->studio_name); ?>

                                                <?php else: ?>
                                                    <?php echo e($freelancer->brand_name); ?>

                                                <?php endif; ?>
                                            </h2>
                                            <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2 flex-wrap">
                                                <span class="text-warning me-2">
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-half-filled"></i>
                                                    <i class="ti ti-star"></i>
                                                </span>
                                                <span class="text-muted me-2">4.5</span>
                                                <span class="badge badge-soft-success p-1">
                                                    <?php echo e($type === 'studio' ? 'Verified Studio' : 'Verified Freelancer'); ?>

                                                </span>
                                            </div>
                                            
                                            <p class="text-muted mb-0 small">
                                                <i class="ti ti-map-pin me-1"></i> 
                                                <?php if($type === 'studio'): ?>
                                                    <?php echo e($studio->location ? $studio->location->municipality . ', Cavite' : 'Location not specified'); ?> | 
                                                    Established: <?php echo e($studio->year_established); ?>

                                                <?php else: ?>
                                                    <?php echo e($freelancer->location ? $freelancer->location->municipality . ', Cavite' : 'Location not specified'); ?>

                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                                    <div class="d-flex flex-column gap-2 align-items-center align-items-lg-end">
                                        <div class="text-center text-lg-end">
                                            <span class="text-muted d-block">Starting Price at</span>
                                            <h3 class="text-success mb-0 h4">
                                                PHP 
                                                <?php if($type === 'studio'): ?>
                                                    <?php echo e(number_format($studio->starting_price, 2)); ?>

                                                <?php else: ?>
                                                    <?php echo e(number_format($freelancer->starting_price, 2)); ?>

                                                <?php endif; ?>
                                            </h3>
                                        </div>
                                        <a href="<?php echo e(route('client.booking-forms', ['type' => $type, 'id' => $type === 'studio' ? $studio->id : $freelancer->user_id])); ?>" class="btn btn-primary w-md-auto">
                                            <i class="ti ti-calendar-check me-2"></i> Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    
                                    <div class="row mb-3">
                                        <h5 class="card-title mb-2 text-primary">
                                            <?php echo e($type === 'studio' ? 'About Our Studio' : 'About Me'); ?>

                                        </h5>
                                        <p class="mb-0">
                                            <?php if($type === 'studio'): ?>
                                                <?php echo e($studio->studio_description ?: 'No description available.'); ?>

                                            <?php else: ?>
                                                <?php echo e($freelancer->bio ?: 'No bio available.'); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>

                                    
                                    <div class="mb-4">
                                        <h5 class="card-title text-primary mb-3">List of Packages</h5>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Select Service Package</label>
                                                    <select class="form-select" id="packageCategory" aria-label="Select service category">
                                                        <option value="">All Categories</option>
                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->category_name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="packages-container">
                                            <?php
                                                $packagesData = $type === 'studio' ? $studioPackages : $freelancerPackages;
                                            ?>
                                            
                                            <?php $__currentLoopData = $packagesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId => $packages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="package-category mb-4" data-category="<?php echo e($categoryId); ?>">
                                                <h4 class="mb-2 text-primary"><?php echo e($packages->first()->category->category_name ?? 'Packages'); ?></h4>
                                                <div class="row g-3">
                                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-6 col-xl-4">
                                                        <div class="card border h-100 package-card">
                                                            <div class="card-body">
                                                                <!-- Package Name & Price -->
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h6 class="card-title fw-bold mb-0"><?php echo e($package->package_name); ?></h6>
                                                                    <span class="text-success fw-bold">₱<?php echo e(number_format($package->package_price, 2)); ?></span>
                                                                </div>
                                                                
                                                                <!-- Package Description -->
                                                                <p class="text-muted small mb-3"><?php echo e($package->package_description ?: 'No description available.'); ?></p>
                                                                
                                                                <?php if($type === 'studio'): ?>
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <?php if($package->online_gallery): ?>
                                                                            <span class="p-1 badge badge-soft-success">
                                                                                <i class="ti ti-photo me-1"></i> Online Gallery: Included
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <span class="p-1 badge badge-soft-warning">
                                                                                <i class="ti ti-photo-off me-1"></i> Online Gallery: Not Included
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                
                                                                <?php if($type === 'studio'): ?>
                                                                    <div class="d-flex align-items-center mb-3">
                                                                        <span class="p-1 badge badge-soft-primary">
                                                                            <i class="ti ti-users me-1"></i> 
                                                                            Photographers: <?php echo e($package->photographer_count ?? 1); ?> 
                                                                            <?php if(($package->photographer_count ?? 1) > 1): ?> photographers <?php else: ?> photographer <?php endif; ?>
                                                                        </span>
                                                                    </div>
                                                                <?php endif; ?>
                                                                
                                                                <!-- Package Features -->
                                                                <div class="col">
                                                                    <small class="text-muted d-block mb-2"><i class="ti ti-checklist me-1"></i> Package Includes:</small>
                                                                    <ul class="list-unstyled small mb-0">
                                                                        <?php if($package->duration): ?>
                                                                            <li class="mb-1">
                                                                                <i class="ti ti-clock text-primary me-2"></i> 
                                                                                <?php echo e($package->duration); ?> <?php echo e($package->duration > 1 ? 'hours' : 'hour'); ?> coverage
                                                                            </li>
                                                                        <?php endif; ?>
                                                                        <?php if($package->maximum_edited_photos): ?>
                                                                            <li class="mb-1">
                                                                                <i class="ti ti-camera text-primary me-2"></i> 
                                                                                <?php echo e($package->maximum_edited_photos); ?> edited photos
                                                                            </li>
                                                                        <?php endif; ?>
                                                                        <?php if($package->package_inclusions && is_array($package->package_inclusions)): ?>
                                                                            <?php $__currentLoopData = array_slice($package->package_inclusions, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inclusion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <li class="mb-1">
                                                                                    <i class="ti ti-check text-success me-2"></i> 
                                                                                    <?php echo e($inclusion); ?>

                                                                                </li>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if(count($package->package_inclusions) > 3): ?>
                                                                                <li class="text-muted">
                                                                                    <small>+<?php echo e(count($package->package_inclusions) - 3); ?> more items</small>
                                                                                </li>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                        <?php if($package->coverage_scope): ?>
                                                                            <li class="mb-1">
                                                                                <i class="ti ti-map-pin text-primary me-2"></i> 
                                                                                Coverage: <?php echo e($package->coverage_scope); ?>

                                                                            </li>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>

                                        <?php if($packagesData->isEmpty()): ?>
                                        <div class="alert alert-info">
                                            <i class="ti ti-info-circle me-2"></i> No packages available.
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <div class="row mb-3">
                                        <h5 class="card-title mb-3 text-primary">
                                            <?php echo e($type === 'studio' ? 'Operating Hours' : 'Availability'); ?>

                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Opening Time</th>
                                                        <th>Closing Time</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($type === 'studio'): ?>
                                                        <?php if($studio->schedules && $studio->schedules->isNotEmpty()): ?>
                                                            <?php
                                                                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                                                $schedule = $studio->schedules->first();
                                                                
                                                                // Ensure operating_days is always an array
                                                                $operatingDays = $schedule->operating_days ?? [];
                                                                
                                                                // If it's a string, try to decode it
                                                                if (is_string($operatingDays)) {
                                                                    $decoded = json_decode($operatingDays, true);
                                                                    $operatingDays = is_array($decoded) ? $decoded : [];
                                                                }
                                                                
                                                                // If it's not an array, make it an empty array
                                                                if (!is_array($operatingDays)) {
                                                                    $operatingDays = [];
                                                                }
                                                            ?>
                                                            
                                                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e(ucfirst($day)); ?></td>
                                                                <?php if(in_array($day, $operatingDays)): ?>
                                                                <td><?php echo e($schedule->opening_time ? \Carbon\Carbon::parse($schedule->opening_time)->format('h:i A') : 'N/A'); ?></td>
                                                                <td><?php echo e($schedule->closing_time ? \Carbon\Carbon::parse($schedule->closing_time)->format('h:i A') : 'N/A'); ?></td>
                                                                <td><span class="badge badge-soft-primary w-100">AVAILABLE</span></td>
                                                                <?php else: ?>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td><span class="badge badge-soft-danger w-100">UNAVAILABLE</span></td>
                                                                <?php endif; ?>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="4" class="text-center text-muted">
                                                                    No operating schedule available.
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        
                                                        <?php if($freelancer->schedule): ?>
                                                            <?php
                                                                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                                                $schedule = $freelancer->schedule;
                                                                $operatingDays = $schedule->operating_days ?? [];
                                                                
                                                                // Ensure operating_days is always an array
                                                                if (is_string($operatingDays)) {
                                                                    $decoded = json_decode($operatingDays, true);
                                                                    $operatingDays = is_array($decoded) ? $decoded : [];
                                                                }
                                                                
                                                                if (!is_array($operatingDays)) {
                                                                    $operatingDays = [];
                                                                }
                                                            ?>
                                                            
                                                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e(ucfirst($day)); ?></td>
                                                                <?php if(in_array($day, $operatingDays)): ?>
                                                                <td><?php echo e($schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') : 'N/A'); ?></td>
                                                                <td><?php echo e($schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') : 'N/A'); ?></td>
                                                                <td><span class="badge badge-soft-primary w-100">AVAILABLE</span></td>
                                                                <?php else: ?>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td><span class="badge badge-soft-danger w-100">UNAVAILABLE</span></td>
                                                                <?php endif; ?>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="4" class="text-center text-muted">
                                                                    No schedule available.
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    
                                    <div class="row mb-3">
                                        <h5 class="card-title mb-3 text-primary">
                                            <?php echo e($type === 'studio' ? 'Studio Location' : 'Location'); ?>

                                        </h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1">Province</label>
                                                    <p class="mb-0 fw-medium">
                                                        <?php if($type === 'studio'): ?>
                                                            <?php echo e($studio->location ? $studio->location->province : 'Not specified'); ?>

                                                        <?php else: ?>
                                                            <?php echo e($freelancer->location ? $freelancer->location->province : 'Not specified'); ?>

                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1">Municipality</label>
                                                    <p class="mb-0 fw-medium">
                                                        <?php if($type === 'studio'): ?>
                                                            <?php echo e($studio->location ? $studio->location->municipality : 'Not specified'); ?>

                                                        <?php else: ?>
                                                            <?php echo e($freelancer->location ? $freelancer->location->municipality : 'Not specified'); ?>

                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1">Barangay</label>
                                                    <p class="mb-0 fw-medium">
                                                        <?php if($type === 'studio'): ?>
                                                            <?php echo e($studio->barangay ?: 'Not specified'); ?>

                                                        <?php else: ?>
                                                            <?php echo e($freelancer->barangay ?: 'Not specified'); ?>

                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1">Address</label>
                                                    <p class="mb-0 fw-medium">
                                                        <?php if($type === 'studio'): ?>
                                                            <?php echo e($studio->street ? $studio->street . ', ' : ''); ?>

                                                            <?php echo e($studio->barangay ? 'Brgy. ' . $studio->barangay . ', ' : ''); ?>

                                                            <?php echo e($studio->location ? $studio->location->municipality . ', ' : ''); ?>

                                                            <?php echo e($studio->location ? $studio->location->province : ''); ?>

                                                        <?php else: ?>
                                                            <?php echo e($freelancer->street ? $freelancer->street . ', ' : ''); ?>

                                                            <?php echo e($freelancer->barangay ? 'Brgy. ' . $freelancer->barangay . ', ' : ''); ?>

                                                            <?php echo e($freelancer->location ? $freelancer->location->municipality . ', ' : ''); ?>

                                                            <?php echo e($freelancer->location ? $freelancer->location->province : ''); ?>

                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-3">Contact Information</h5>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted mb-1">
                                            <?php echo e($type === 'studio' ? 'Studio Owner' : 'Name'); ?>

                                        </label>
                                        <p class="mb-0 fw-medium">
                                            <?php if($type === 'studio'): ?>
                                                <?php echo e($studio->user ? $studio->user->full_name : 'Not available'); ?>

                                            <?php else: ?>
                                                <?php echo e($freelancer->user ? $freelancer->user->full_name : 'Not available'); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted mb-1">
                                            <?php echo e($type === 'studio' ? 'Studio Email' : 'Email'); ?>

                                        </label>
                                        <p class="mb-0 fw-medium">
                                            <?php if($type === 'studio'): ?>
                                                <?php echo e($studio->studio_email ?: 'Not available'); ?>

                                            <?php else: ?>
                                                <?php echo e($freelancer->user ? $freelancer->user->email : 'Not available'); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted mb-1">Contact Number</label>
                                        <p class="mb-0 fw-medium">
                                            <?php if($type === 'studio'): ?>
                                                <?php echo e($studio->contact_number ?: 'Not available'); ?>

                                            <?php else: ?>
                                                <?php echo e($freelancer->user ? $freelancer->user->mobile_number : 'Not available'); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label text-muted mb-1">Response Time</label>
                                        <p class="mb-0 fw-medium">Usually responds within 2 hours</p>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary">
                                            <i class="ti ti-phone me-2"></i>
                                            <?php echo e($type === 'studio' ? 'Contact Studio' : 'Contact'); ?>

                                        </button>
                                        <button class="btn btn-soft-primary">
                                            <i class="ti ti-message-circle me-2"></i>
                                            Send Message
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-3">Booking Terms</h5>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start mb-3">
                                            <i class="ti ti-calendar text-primary me-2 mt-1"></i>
                                            <div>
                                                <h5 class="mb-1">Advance Booking</h5>
                                                <p class="text-muted mb-0">
                                                    <?php if($type === 'studio'): ?>
                                                        Book at least <?php echo e($studio->advance_booking_days ?? 3); ?> days in advance
                                                    <?php else: ?>
                                                        Book at least <?php echo e($freelancer->schedule->advance_booking ?? 3); ?> days in advance
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-start mb-3">
                                            <i class="ti ti-coin text-primary me-2 mt-1"></i>
                                            <div>
                                                <h5 class="mb-1">Payment Terms</h5>
                                                <p class="text-muted mb-0">
                                                    <?php if($type === 'studio'): ?>
                                                        <?php echo e($studio->deposit_policy ?? '30%'); ?> downpayment to confirm booking
                                                    <?php else: ?>
                                                        <?php echo e($freelancer->deposit_policy ?? '30%'); ?> downpayment to confirm booking
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-start mb-3">
                                            <i class="ti ti-users text-primary me-2 mt-1"></i>
                                            <div>
                                                <h5 class="mb-1">Capacity</h5>
                                                <p class="text-muted mb-0">
                                                    <?php if($type === 'studio'): ?>
                                                        Maximum <?php echo e($studio->max_clients_per_day ?? 3); ?> clients per day
                                                    <?php else: ?>
                                                        Maximum <?php echo e($freelancer->schedule->booking_limit ?? 3); ?> clients per day
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Function to filter packages
            function filterPackages(categoryId) {
                // Show all packages if no category selected
                if (!categoryId) {
                    $('.package-category').show();
                    return;
                }
                
                // Hide all packages first
                $('.package-category').hide();
                
                // Show packages for selected category
                $(`.package-category[data-category="${categoryId}"]`).show();
            }
            
            // Initial state - show all packages
            filterPackages('');
            
            // Filter on dropdown change
            $('#packageCategory').on('change', function() {
                const categoryId = $(this).val();
                filterPackages(categoryId);
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/client/booking-details.blade.php ENDPATH**/ ?>