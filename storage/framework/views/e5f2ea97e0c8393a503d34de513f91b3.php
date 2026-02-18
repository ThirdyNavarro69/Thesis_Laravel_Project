
<?php $__env->startSection('title', 'Client Home'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">
            <div class="page-title-head d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="fw-bold m-0">Welcome to SnapStudio</h3>
                    <p>Providing Reliable and Continuous Photography Services for Clients</p>
                </div>
            </div>

            
            <div class="row mb-2">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap justify-content-end align-items-center gap-3">
                        <div class="d-lg-none d-flex gap-2">
                            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#productFillterOffcanvas" aria-controls="productFillterOffcanvas">
                                <i data-lucide="sliders-horizontal"></i>
                                <span class="d-lg-none ms-2">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-3">
                    <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="productFillterOffcanvas">
                        <div class="card h-100" data-simplebar>
                            <div class="card-body p-0">

                                
                                <div class="p-3 border-bottom border-dashed">
                                    <div class="d-flex mb-2 justify-content-between align-items-center">
                                        <h5 class="mb-0">Photographer Type:</h5>
                                        <a href="javascript: void(0);" class="btn btn-link btn-sm px-0 fw-semibold text-primary view-all-type">View All</a>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 text-muted py-1">
                                        <div class="form-check flex-grow-1">
                                            <input type="checkbox" id="type-studio-type-photographer" class="form-check-input filter-type" value="studio">
                                            <label for="type-studio-type-photographer" class="form-check-label mb-0">Studio Photographer</label>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 text-muted py-1">
                                        <div class="form-check flex-grow-1">
                                            <input type="checkbox" id="type-freelancer-type-photographer" class="form-check-input filter-type" value="freelancer">
                                            <label for="type-freelancer-type-photographer" class="form-check-label mb-0">Freelancer Photographer</label>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="p-3 border-bottom border-dashed">
                                    <div class="d-flex mb-2 justify-content-between align-items-center">
                                        <h5 class="mb-0">Category:</h5>
                                        <a href="javascript: void(0);" class="btn btn-link btn-sm px-0 fw-semibold text-primary view-all-category">View All</a>
                                    </div>

                                    <div id="category-filter-container">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-<?php echo e($category->id); ?>" class="form-check-input filter-category" value="<?php echo e($category->id); ?>">
                                                <label for="cat-<?php echo e($category->id); ?>" class="form-check-label mb-0"><?php echo e($category->category_name); ?></label>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                
                                <div class="p-3 border-bottom border-dashed">
                                    <div class="d-flex mb-2 justify-content-between align-items-center">
                                        <h5 class="mb-0">Locations:</h5>
                                        <a href="javascript: void(0);" class="btn btn-link btn-sm px-0 fw-semibold text-primary view-all-location">View All</a>
                                    </div>

                                    <div id="location-filter-container">
                                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-<?php echo e($location->id); ?>" class="form-check-input filter-location" value="<?php echo e($location->id); ?>">
                                                <label for="loc-<?php echo e($location->id); ?>" class="form-check-label mb-0"><?php echo e($location->municipality); ?></label>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge text-bg-light location-count" data-location="<?php echo e($location->id); ?>">0</span></div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                
                                <div class="p-3 border-bottom border-dashed">
                                    <h5 class="mb-3">Price Range:</h5>

                                    <div class="d-flex gap-2 align-items-center mt-3">
                                        <input type="number" id="min-price" class="form-control form-control-sm text-center" placeholder="PHP 00.00" min="0">
                                        <span class="fw-semibold text-muted">to</span>
                                        <input type="number" id="max-price" class="form-control form-control-sm text-center" placeholder="PHP 00.00" min="0">
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" id="apply-price-filter" class="btn btn-sm btn-primary w-100">Apply Price</button>
                                    </div>
                                </div>

                                <div class="p-3">
                                    <button type="button" id="apply-filters" class="btn btn-primary w-100">Apply Filters</button>
                                    <button type="button" id="clear-filters" class="btn btn-outline-secondary w-100 mt-2">Clear All</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="row g-2" id="photographer-cards-container">
                        
                        <?php $__currentLoopData = $studios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <div class="card h-100 mb-2 border-1 shadow-sm">
                                <div class="card-body pb-2">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo e($studio->studio_logo ? asset('storage/' . $studio->studio_logo) : asset('assets/images/sellers/7.png')); ?>" 
                                                class="rounded" alt="<?php echo e($studio->studio_name); ?>" 
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>                                            
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="card-title mb-1"><?php echo e($studio->studio_name); ?></h4>
                                            <p class="text-muted mb-1">Studio</p>
                                            <div class="mb-2">
                                                <span class="text-muted small">
                                                    <i class="ti ti-map-pin me-1"></i>
                                                    <span><?php echo e($studio->location ? $studio->location->municipality . ', Cavite' : 'Location not specified'); ?></span>
                                                </span>
                                            </div>                                                
                                            <div class="d-flex align-items-center">
                                                <span class="text-warning">
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-half-filled fs-6"></i>
                                                    <i class="ti ti-star fs-6"></i>
                                                </span>
                                                <span class="ms-2 fw-medium">(4.5)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted small mb-1">Starting Price</p>
                                            <h5 class="text-success d-flex align-items-center gap-2 mb-0">PHP <?php echo e(number_format($studio->starting_price, 2)); ?></h5>
                                        </div>                                            
                                        <a class="btn btn-primary w-10" href="<?php echo e(route('client.booking-details', ['type' => 'studio', 'id' => $studio->id])); ?>">Book Service</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                        <?php $__currentLoopData = $freelancers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $freelancer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <div class="card h-100 mb-2 border-1 shadow-sm">
                                <div class="card-body pb-2">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo e($freelancer->brand_logo ? asset('storage/' . $freelancer->brand_logo) : asset('assets/images/sellers/3.png')); ?>" 
                                                class="rounded" alt="<?php echo e($freelancer->brand_name); ?>" 
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>                                            
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="card-title mb-1"><?php echo e($freelancer->brand_name); ?></h4>
                                            <p class="text-muted mb-1">Freelancer</p>
                                            <div class="mb-2">
                                                <span class="text-muted small">
                                                    <i class="ti ti-map-pin me-1"></i>
                                                    <span><?php echo e($freelancer->location ? $freelancer->location->municipality . ', Cavite' : 'Location not specified'); ?></span>
                                                </span>
                                            </div>                                                
                                            <div class="d-flex align-items-center">
                                                <span class="text-warning">
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-half-filled fs-6"></i>
                                                    <i class="ti ti-star fs-6"></i>
                                                </span>
                                                <span class="ms-2 fw-medium">(4.5)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted small mb-1">Starting Price</p>
                                            <h5 class="text-success d-flex align-items-center gap-2 mb-0">PHP <?php echo e(number_format($freelancer->starting_price, 2)); ?></h5>
                                        </div>                                            
                                        <a class="btn btn-primary w-10" href="<?php echo e(route('client.booking-details', ['type' => 'freelancer', 'id' => $freelancer->user_id])); ?>">Book Service</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div id="loading-spinner" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading photographers...</p>
                    </div>

                    
                    <div id="no-results" class="text-center py-5" style="display: none;">
                        <i class="ti ti-search-off fs-1 text-muted"></i>
                        <h5 class="mt-3">No photographers found</h5>
                        <p class="text-muted">Try adjusting your filters</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // CSRF Token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Filter variables
            let activeFilters = {
                type: [],
                category: [],
                location: [],
                min_price: null,
                max_price: null
            };

            // Apply Filters Function
            function applyFilters() {
                // Show loading spinner
                $('#loading-spinner').show();
                $('#no-results').hide();
                $('#photographer-cards-container').hide();

                // Get selected types
                activeFilters.type = [];
                $('.filter-type:checked').each(function() {
                    activeFilters.type.push($(this).val());
                });

                // Get selected categories
                activeFilters.category = [];
                $('.filter-category:checked').each(function() {
                    activeFilters.category.push($(this).val());
                });

                // Get selected locations
                activeFilters.location = [];
                $('.filter-location:checked').each(function() {
                    activeFilters.location.push($(this).val());
                });

                // Get price range
                activeFilters.min_price = $('#min-price').val() || null;
                activeFilters.max_price = $('#max-price').val() || null;

                // AJAX request
                $.ajax({
                    url: '<?php echo e(route("client.dashboard.filter")); ?>',
                    type: 'POST',
                    data: {
                        photographer_type: activeFilters.type.length > 0 ? activeFilters.type.join(',') : '',
                        category_id: activeFilters.category.length > 0 ? activeFilters.category[0] : '', // Taking first category only
                        location_id: activeFilters.location.length > 0 ? activeFilters.location[0] : '', // Taking first location only
                        min_price: activeFilters.min_price,
                        max_price: activeFilters.max_price
                    },
                    success: function(response) {
                        // Hide loading spinner
                        $('#loading-spinner').hide();

                        if (response.success) {
                            updatePhotographerCards(response.results);
                        }
                    },
                    error: function(xhr) {
                        $('#loading-spinner').hide();
                        $('#photographer-cards-container').show();
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to apply filters. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            }

            // Update photographer cards
            function updatePhotographerCards(results) {
                const container = $('#photographer-cards-container');
                container.empty();

                if (results.length === 0) {
                    $('#no-results').show();
                    return;
                }

                $.each(results, function(index, photographer) {
                    const cardHtml = `
                        <div class="col-xxl-4 col-lg-4 col-sm-6 col-12 mb-3">
                            <div class="card h-100 border-1 shadow-sm photographer-card" data-type="${photographer.type}" data-id="${photographer.id}">
                                <div class="card-body pb-2">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <img src="${photographer.logo}" 
                                                class="rounded" alt="${photographer.name}" 
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>                                            
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="card-title mb-1">${photographer.name}</h4>
                                            <p class="text-muted mb-1">${photographer.type_label}</p>
                                            <div class="mb-2">
                                                <span class="text-muted small">
                                                    <i class="ti ti-map-pin me-1"></i>
                                                    <span>${photographer.location}</span>
                                                </span>
                                            </div>                                                
                                            <div class="d-flex align-items-center">
                                                <span class="text-warning">
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-filled fs-6"></i>
                                                    <i class="ti ti-star-half-filled fs-6"></i>
                                                    <i class="ti ti-star fs-6"></i>
                                                </span>
                                                <span class="ms-2 fw-medium">(4.5)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted small mb-1">Starting Price</p>
                                            <h5 class="text-success d-flex align-items-center gap-2 mb-0">PHP ${photographer.starting_price}</h5>
                                        </div>                                            
                                        <a class="btn btn-primary w-10" href="<?php echo e(route('client.booking-details', ['type' => 'studio', 'id' => $studio->id])); ?>">Book Service</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    container.append(cardHtml);
                });

                container.show();
            }

            // Event Listeners
            $('#apply-filters').on('click', applyFilters);

            $('#apply-price-filter').on('click', function() {
                applyFilters();
            });

            // Clear all filters
            $('#clear-filters').on('click', function() {
                // Uncheck all checkboxes
                $('.filter-type, .filter-category, .filter-location').prop('checked', false);
                
                // Clear price inputs
                $('#min-price').val('');
                $('#max-price').val('');
                
                // Reset active filters
                activeFilters = {
                    type: [],
                    category: [],
                    location: [],
                    min_price: null,
                    max_price: null
                };
                
                // Reload page to show all
                location.reload();
            });

            // View All buttons
            $('.view-all-type').on('click', function() {
                $('.filter-type').prop('checked', true);
                applyFilters();
            });

            $('.view-all-category').on('click', function() {
                $('.filter-category').prop('checked', true);
                applyFilters();
            });

            $('.view-all-location').on('click', function() {
                $('.filter-location').prop('checked', true);
                applyFilters();
            });

            // Apply filters on checkbox change
            $('.filter-type, .filter-category, .filter-location').on('change', function() {
                applyFilters();
            });

            // Initialize location counts
            function initializeLocationCounts() {
                $('.location-count').each(function() {
                    const locationId = $(this).data('location');
                    const count = $(`.photographer-card[data-type="studio"][data-location="${locationId}"], .photographer-card[data-type="freelancer"][data-location="${locationId}"]`).length;
                    $(this).text(count);
                });
            }

            // Call on page load
            initializeLocationCounts();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/client/dashboard.blade.php ENDPATH**/ ?>