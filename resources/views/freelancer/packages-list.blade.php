@extends('layouts.freelancer.app')
@section('title', 'View Packages')

{{-- CONTENT --}}
@section('content')
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
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if($packages->isEmpty())
                                <div class="text-center py-5">
                                    <i class="ti ti-package-off fs-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">No packages found</h5>
                                    <p class="text-muted mb-4">You haven't created any packages yet.</p>
                                    <a href="{{ route('freelancer.packages.create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i> Create Your First Package
                                    </a>
                                </div>
                            @else
                                <div class="row g-3 mb-4">
                                    @foreach($packages as $package)
                                    <div class="col-md-4">
                                        <div class="card shadow-none border h-100 my-4 my-lg-0">
                                            <div class="card-body p-lg-4 pb-0 text-center">
                                                <h3 class="fw-bold mb-1">{{ $package->package_name }}</h3>
                                                <p class="text-muted mb-0">{{ $package->category->category_name ?? 'Uncategorized' }}</p>

                                                <div class="my-4">
                                                    <h1 class="display-6 fw-bold mb-0">PHP {{ number_format($package->package_price, 2) }}</h1>
                                                    <small class="d-block text-muted fs-base">{{ $package->duration }} Hours</small>
                                                    <small class="d-block text-muted">{{ $package->maximum_edited_photos }} Edited Photos</small>
                                                </div>

                                                <ul class="list-unstyled text-start fs-sm mb-0">
                                                    @if($package->package_inclusions && is_array($package->package_inclusions))
                                                        @foreach(array_slice($package->package_inclusions, 0, 5) as $inclusion)
                                                        <li class="mb-2">
                                                            <i class="ti ti-check text-success me-2"></i> 
                                                            {{ $inclusion }}
                                                        </li>
                                                        @endforeach
                                                        
                                                        @if(count($package->package_inclusions) > 5)
                                                        <li class="mb-2">
                                                            <i class="ti ti-dots me-2"></i>
                                                            <small class="text-muted">+{{ count($package->package_inclusions) - 5 }} more inclusions</small>
                                                        </li>
                                                        @endif
                                                    @endif
                                                    
                                                    @if($package->coverage_scope)
                                                    <li class="mb-2">
                                                        <i class="ti ti-map-pin text-primary me-2"></i> 
                                                        {{ $package->coverage_scope }}
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="card-footer bg-transparent px-5 pb-4">
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-outline-primary w-100 py-2 fw-semibold rounded-pill view-details-btn" data-package-id="{{ $package->id }}"data-category-id="{{ $package->category_id }}">
                                                        View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @if($packages->count() > 3)
                                <div class="text-center mt-4">
                                    <nav aria-label="Package navigation">
                                        <ul class="pagination justify-content-center mb-0">
                                            <li class="page-item disabled">
                                                <span class="page-link">Showing {{ $packages->count() }} packages</span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="viewPackageModal" tabindex="-1" aria-labelledby="viewPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPackageModalLabel">Package Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="packageLoading" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading package details...</p>
                    </div>
                    <div id="packageDetailsContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // View Package Details
            $(document).on('click', '.view-details-btn', function() {
                const packageId = $(this).data('package-id');
            });

            // Category filter change event
            $('#categoryFilter').on('change', function() {
                filterPackagesByCategory($(this).val());
            });

            /**
             * Filter packages by category
             */
            function filterPackagesByCategory(categoryId) {
                if (!categoryId) {
                    // Show all packages when "All Categories" is selected
                    $('.col-md-4').show();
                    $('#noPackagesMessage').remove();
                    return;
                }

                // Hide all packages first
                $('.col-md-4').hide();
                
                // Show only packages with matching category
                $(`.col-md-4 .view-details-btn[data-category-id="${categoryId}"]`).closest('.col-md-4').show();
                
                // Check if any packages are visible
                const visiblePackages = $('.col-md-4:visible').length;
                
                if (visiblePackages === 0) {
                    // Show "no packages" message
                    if (!$('#noPackagesMessage').length) {
                        const messageHtml = `
                            <div id="noPackagesMessage" class="text-center py-5 col-12">
                                <i class="ti ti-package-off fs-1 text-muted mb-3"></i>
                                <h5 class="text-muted">No packages found in this category</h5>
                                <p class="text-muted mb-4">Try selecting a different category or create a package in this category.</p>
                                <a href="{{ route('freelancer.packages.create') }}" class="btn btn-primary">
                                    <i class="ti ti-plus me-1"></i> Create Package
                                </a>
                            </div>
                        `;
                        $('.row.g-3.mb-4').append(messageHtml);
                    }
                    $('#noPackagesMessage').show();
                } else {
                    // Hide the message if it exists
                    $('#noPackagesMessage').hide();
                }
            }

            /**
             * Load package details via AJAX
             */
            function loadPackageDetails(packageId) {
                // Show loading
                $('#packageLoading').show();
                $('#packageDetailsContent').hide();
                
                // Reset modal title
                $('#viewPackageModalLabel').text('Package Details');
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('viewPackageModal'));
                modal.show();

                $.ajax({
                    url: '{{ url("freelancer/packages") }}/' + packageId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            renderPackageDetails(response.data);
                        } else {
                            showError(response.message || 'Failed to load package details');
                        }
                    },
                    error: function(xhr, status, error) {
                        showError('Error loading package details. Please try again.');
                        console.error('Error:', error);
                    },
                    complete: function() {
                        $('#packageLoading').hide();
                        $('#packageDetailsContent').show();
                    }
                });
            }

            /**
             * Render package details in modal
             */
            function renderPackageDetails(package) {
                // Set modal title
                $('#viewPackageModalLabel').text(package.package_name + ' Details');
                
                // Format inclusions as list
                let inclusionsHtml = '';
                if (package.package_inclusions && Array.isArray(package.package_inclusions)) {
                    package.package_inclusions.forEach(inclusion => {
                        inclusionsHtml += `<li class="mb-1"><i class="ti ti-check text-success me-2"></i>${inclusion}</li>`;
                    });
                }
                
                // Format date
                const createdAt = new Date(package.created_at);
                const formattedDate = createdAt.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // Build HTML
                const html = `
                    <div class="row align-items-center mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h3 class="mb-1">${package.package_name}</h3>
                                    <div class="d-flex align-items-center mb-2 flex-wrap">
                                        <span class="badge ${package.status === 'active' ? 'badge-soft-success' : 'badge-soft-danger'} px-2 fw-medium">
                                            ${package.status.toUpperCase()}
                                        </span>
                                        <span class="ms-2 text-muted small">Created: ${formattedDate}</span>
                                    </div>
                                    
                                    <p class="text-muted mb-0">
                                        <i class="ti ti-category me-1"></i> ${package.category?.category_name || 'Uncategorized'}
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
                                            <p class="mb-0 fw-medium">PHP ${parseFloat(package.package_price).toFixed(2)}</p>
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

                            <div class="row g-2 mb-3">
                                <h5 class="card-title text-primary">PACKAGE DETAILS</h5>
                                
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i class="ti ti-file-text fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Package Description</label>
                                            <p class="mb-0 fw-medium">${package.package_description || 'No description provided'}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i class="ti ti-check-circle fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Package Inclusions</label>
                                            ${inclusionsHtml ? `<ul class="list-unstyled mb-0">${inclusionsHtml}</ul>` : '<p class="text-muted mb-0">No inclusions specified</p>'}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            ${package.coverage_scope ? `
                            <div class="row g-2 mb-3">
                                <h5 class="card-title text-primary">COVERAGE SCOPE</h5>
                                
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i class="ti ti-map-pin fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Service Coverage Area</label>
                                            <p class="mb-0 fw-medium">${package.coverage_scope}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `;
                
                $('#packageDetailsContent').html(html);
            }

            /**
             * Show no packages message
             */
            function showNoPackagesMessage() {
                const $cardBody = $('.card-body');
                if (!$('#noPackagesMessage').length) {
                    const messageHtml = `
                        <div id="noPackagesMessage" class="text-center py-5">
                            <i class="ti ti-package-off fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No packages found in this category</h5>
                            <p class="text-muted mb-4">Try selecting a different category.</p>
                        </div>
                    `;
                    $cardBody.append(messageHtml);
                }
                $('#noPackagesMessage').show();
            }

            /**
             * Show error message
             */
            function showError(message) {
                const errorHtml = `
                    <div class="alert alert-danger" role="alert">
                        <i class="ti ti-alert-circle me-2"></i>
                        ${message}
                    </div>
                `;
                $('#packageDetailsContent').html(errorHtml);
            }
        });
    </script>
@endsection