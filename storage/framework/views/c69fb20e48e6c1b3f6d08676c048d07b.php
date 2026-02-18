
<?php $__env->startSection('title', 'View Packages'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-title d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Package Lists</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-header border-0 justify-content-end">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold">
                                        <i class="ti ti-filter me-1"></i>Filter Categories:
                                    </span>
                                    <div class="app-filter">
                                        <select id="categoryFilter" class="me-0 form-select form-control">
                                            <option value="">All Categories</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->category_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-4" id="packagesContainer">
                                <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-md-4 package-item" data-category="<?php echo e($package->category_id ?? ''); ?>">
                                    <div class="card shadow-none h-100 my-4 my-lg-0">
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1"><?php echo e($package->package_name); ?></h3>
                                            <p class="text-muted mb-0"><?php echo e($package->studio->studio_name ?? 'N/A'); ?> - <?php echo e($package->category->category_name ?? 'N/A'); ?></p>

                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">PHP <?php echo e(number_format($package->package_price, 2)); ?></h1>
                                                <small class="d-block text-muted fs-base"><?php echo e($package->duration); ?> Hours</small>
                                                <small class="d-block text-muted"><?php echo e($package->maximum_edited_photos); ?> Edited Photos</small>
                                                <div class="d-flex justify-content-center gap-3 mt-2">
                                                    <div class="text-center">
                                                        <span class="badge <?php echo e($package->online_gallery ? 'badge-soft-success' : 'badge-soft-secondary'); ?>">
                                                            <i class="ti ti-photo <?php echo e($package->online_gallery ? '' : 'ti ti-photo-off'); ?> me-1"></i>
                                                            Gallery: <?php echo e($package->online_gallery ? 'Yes' : 'No'); ?>

                                                        </span>
                                                    </div>
                                                    <div class="text-center">
                                                        <span class="badge badge-soft-primary">
                                                            <i class="ti ti-users me-1"></i>
                                                            <?php echo e($package->photographer_count ?? 0); ?> Photographer(s)
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <ul class="list-unstyled text-start fs-sm mb-0">
                                                <?php if($package->package_inclusions && is_array($package->package_inclusions)): ?>
                                                    <?php $__currentLoopData = $package->package_inclusions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inclusion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> <?php echo e($inclusion); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                
                                                <?php if($package->coverage_scope): ?>
                                                    <li class="mb-2"><i class="ti ti-map-pin text-primary me-2"></i> <?php echo e($package->coverage_scope); ?></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer bg-transparent px-5 pb-4">
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-primary w-100 py-2 fw-semibold rounded-pill view-package-btn" data-package-id="<?php echo e($package->id); ?>">
                                                    View Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12">
                                    <div class="text-center">
                                        <i class="ti ti-package-off fs-1 text-muted"></i>
                                        <h4 class="mt-3">No Packages Created Yet</h4>
                                        <p class="text-muted mb-4">Start by creating your first package</p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="viewPackageModal" tabindex="-1" aria-labelledby="viewPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPackageModalLabel">Package Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="packageLoading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading package details...</p>
                    </div>
                    <div id="packageDetailsContent" style="display: none;">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Category filter functionality
            $('#categoryFilter').change(function() {
                const selectedCategory = $(this).val();
                
                if (selectedCategory === '') {
                    // Show all packages
                    $('.package-item').fadeIn();
                } else {
                    // Hide all packages first
                    $('.package-item').hide();
                    
                    // Show only packages with matching category
                    $(`.package-item[data-category="${selectedCategory}"]`).fadeIn();
                    
                    // Show message if no packages found
                    const visibleCount = $(`.package-item[data-category="${selectedCategory}"]:visible`).length;
                    if (visibleCount === 0) {
                        $('#packagesContainer').append(`
                            <div class="col-12 no-packages-message">
                                <div class="text-center">
                                    <i class="ti ti-package-off fs-1 text-muted"></i>
                                    <h4 class="mt-3">No Packages Found</h4>
                                    <p class="text-muted mb-4">No packages found for this category.</p>
                                </div>
                            </div>
                        `);
                    }
                }
                
                // Remove any existing "no packages" message
                $('.no-packages-message').remove();
                
                // If all packages are hidden and no message exists, show "no packages" message
                if ($('.package-item:visible').length === 0 && $('.no-packages-message').length === 0) {
                    $('#packagesContainer').append(`
                        <div class="col-12 no-packages-message">
                            <div class="text-center">
                                <i class="ti ti-package-off fs-1 text-muted"></i>
                                <h4 class="mt-3">No Packages Found</h4>
                                <p class="text-muted mb-4">No packages found for this category.</p>
                            </div>
                        </div>
                    `);
                }
            });

            // Function to generate modal HTML from package data
            function generatePackageModalHtml(package) {
                // Format inclusions as HTML list
                let inclusionsHtml = '';
                if (package.package_inclusions && Array.isArray(package.package_inclusions)) {
                    package.package_inclusions.forEach(function(inclusion) {
                        inclusionsHtml += '<li class="mb-2"><i class="ti ti-check text-success me-2"></i> ' + inclusion + '</li>';
                    });
                }
                
                // Format coverage scope badges
                let coverageBadges = '';
                if (package.coverage_scope) {
                    let coverageAreas = Array.isArray(package.coverage_scope) ? package.coverage_scope : [package.coverage_scope];
                    coverageAreas.forEach(function(area) {
                        if (area && area.trim()) {
                            coverageBadges += '<span class="badge badge-soft-secondary fs-6 p-1 fw-medium me-1 mb-1">' + area + '</span>';
                        }
                    });
                }
                
                // Format status badge
                let statusBadge = package.status === 'active' 
                    ? '<span class="badge badge-soft-success px-2 fw-medium">Active</span>'
                    : '<span class="badge badge-soft-danger px-2 fw-medium">Inactive</span>';
                
                // ========== NEW: Format online gallery badge ==========
                let galleryBadge = package.online_gallery 
                    ? '<span class="badge badge-soft-success px-2 fw-medium"><i class="ti ti-check me-1"></i> Included</span>'
                    : '<span class="badge badge-soft-secondary px-2 fw-medium"><i class="ti ti-x me-1"></i> Not Included</span>';
                
                // Format created date
                let createdDate = package.created_at ? new Date(package.created_at).toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                }) : 'N/A';
                
                // Studio and category info
                let studioName = package.studio ? package.studio.studio_name : 'N/A';
                let categoryName = package.category ? package.category.category_name : 'N/A';
                
                // Generate modal HTML using your template structure
                return `
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-lg-8">
                        <div class="d-flex align-items-center flex-column flex-md-row">
                            <div class="flex-shrink-0 mb-3 mb-md-0">
                                <img src="${package.studio && package.studio.logo_url ? package.studio.logo_url : '<?php echo e(asset("assets/images/sellers/7.png")); ?>'}" 
                                    class="rounded-circle" 
                                    style="width: 80px; height: 80px; object-fit: cover;" 
                                    alt="Studio Logo">
                            </div>
                            
                            <div class="flex-grow-1 ms-md-4 text-center text-md-start">
                                <h2 class="mb-1 h3 h3-md">${package.package_name}</h2>
                                <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2 flex-wrap">
                                    ${statusBadge}
                                    <span class="ms-2 text-muted small">Created: ${createdDate}</span>
                                </div>
                                
                                <p class="text-muted mb-0">
                                    <i class="ti ti-building me-1"></i> ${studioName} | 
                                    <i class="ti ti-category me-1 ms-2"></i> ${categoryName}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="row g-2 mb-3">
                            <h5 class="card-title text-primary">PACKAGE INFORMATION</h5>
                            
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-package fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Package Name</label>
                                        <p class="mb-0 fw-medium">${package.package_name}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-tag fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Package Price</label>
                                        <p class="mb-0 fw-medium">PHP ${parseFloat(package.package_price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- ========== NEW: ONLINE GALLERY FIELD ========== -->
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-photo fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Online Gallery</label>
                                        <div class="mb-0 fw-medium">
                                            ${galleryBadge}
                                        </div>
                                        <small class="text-muted d-block mt-1">Client access to digital gallery</small>
                                    </div>
                                </div>
                            </div>

                            <!-- ========== NEW: PHOTOGRAPHER COUNT FIELD ========== -->
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-users fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Assigned Photographers</label>
                                        <p class="mb-0 fw-medium">${package.photographer_count || 0} Photographer(s)</p>
                                        <small class="text-muted d-block mt-1">Studio photographers assigned to this package</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-clock fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Duration</label>
                                        <p class="mb-0 fw-medium">${package.duration} Hours</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-camera fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Maximum Edited Photos</label>
                                        <p class="mb-0 fw-medium">${package.maximum_edited_photos} Photos</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ... rest of the modal content ... -->
                    </div>
                </div>`;
            }

            // Update the AJAX success handler to use the JavaScript function
            $(document).on('click', '.view-package-btn', function() {
                const packageId = $(this).data('package-id');
                const modal = new bootstrap.Modal(document.getElementById('viewPackageModal'));
                
                // Show modal
                modal.show();
                
                // Show loading spinner, hide content
                $('#packageLoading').show();
                $('#packageDetailsContent').hide();
                
                // Build the URL correctly
                const url = "<?php echo e(route('owner.packages.show', ['package' => '__PACKAGE_ID__'])); ?>".replace('__PACKAGE_ID__', packageId);
                
                // Fetch package details via AJAX
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Hide loading spinner
                            $('#packageLoading').hide();
                            
                            // Generate HTML using JavaScript function
                            const packageHtml = generatePackageModalHtml(response.data);
                            
                            // Populate modal with package details
                            $('#packageDetailsContent').html(packageHtml);
                            $('#packageDetailsContent').show();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to load package details.',
                                confirmButtonColor: '#3475db',
                                confirmButtonText: 'OK'
                            });
                            modal.hide();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load package details. Please try again.',
                            confirmButtonColor: '#3475db',
                            confirmButtonText: 'OK'
                        });
                        modal.hide();
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.owner.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/owner/packages-list.blade.php ENDPATH**/ ?>