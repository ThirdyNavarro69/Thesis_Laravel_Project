@extends('layouts.admin.app')
@section('title', 'Subscription Plans')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- Add New Plan Button --}}
                    <div class="mb-3 text-end">
                        <a href="{{ route('admin.subscription.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Add New Plan
                        </a>
                    </div>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- TABLE --}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">List of Subscription Plans</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input type="search" id="tableSearch" class="form-control" placeholder="Search...">
                                    <i class="ti ti-search app-search-icon text-muted"></i>
                                </div>
                                <div>
                                    <select id="userTypeFilter" class="form-select">
                                        <option value="">All User Types</option>
                                        <option value="studio">Studio</option>
                                        <option value="freelancer">Freelancer</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="statusFilter" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-hover table-bordered w-100 mb-0" id="subscriptionPlansTable">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th>ID</th>
                                        <th>User Type</th>
                                        <th>Plan Type</th>
                                        <th>Billing</th>
                                        <th>Plan Name</th>
                                        <th>Price</th>
                                        <th>Commission</th>
                                        <th>Max Booking</th>
                                        <th>Max Photographers</th>
                                        <th>Support</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @forelse($plans as $plan)
                                        <tr>
                                            <td>{{ $plan->id }}</td>
                                            <td>{{ ucfirst($plan->user_type) }}</td>
                                            <td>{{ $plan->formatted_plan_type }}</td>
                                            <td>{{ $plan->formatted_billing_cycle }}</td>
                                            <td>{{ $plan->name }}</td>
                                            <td>{{ $plan->formatted_price }}</td>
                                            <td>{{ $plan->commission_rate }}%</td>
                                            <td>{{ $plan->max_booking_display }}</td>
                                            <td>
                                                @if($plan->user_type === 'studio')
                                                    {{ $plan->max_studio_photographers_display }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $plan->formatted_support_level }}</td>
                                            <td>
                                                @if($plan->status === 'active')
                                                    <span class="badge badge-soft-success">Active</span>
                                                @else
                                                    <span class="badge badge-soft-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm btn-view" data-id="{{ $plan->id }}" data-bs-toggle="modal" data-bs-target="#viewPlanModal">
                                                        <i class="ti ti-eye"></i>
                                                    </button>
                                                    <a href="{{ route('admin.subscription.edit', $plan->id) }}" class="btn btn-sm btn-edit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-delete" data-id="{{ $plan->id }}">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ti ti-file-text fs-2"></i>
                                                    <p class="mb-0">No subscription plans found.</p>
                                                    <a href="{{ route('admin.subscription.create') }}" class="btn btn-primary btn-sm mt-2">Create your first plan</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="dataTables_info">
                                    Showing {{ $plans->firstItem() ?? 0 }} to {{ $plans->lastItem() ?? 0 }} of {{ $plans->total() }} entries
                                </div>
                                <div class="dataTables_paginate">
                                    {{ $plans->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- View Plan Modal --}}
    <div class="modal fade" id="viewPlanModal" tabindex="-1" aria-labelledby="viewPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPlanModalLabel">Plan Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-4" id="planLoadingSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading plan details...</p>
                    </div>
                    
                    <div id="planDetails" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 40%">User Type:</th>
                                        <td id="view_user_type"></td>
                                    </tr>
                                    <tr>
                                        <th>Plan Type:</th>
                                        <td id="view_plan_type"></td>
                                    </tr>
                                    <tr>
                                        <th>Billing Cycle:</th>
                                        <td id="view_billing_cycle"></td>
                                    </tr>
                                    <tr>
                                        <th>Plan Code:</th>
                                        <td><code id="view_plan_code"></code></td>
                                    </tr>
                                    <tr>
                                        <th>Plan Name:</th>
                                        <td id="view_name"></td>
                                    </tr>
                                    <tr>
                                        <th>Price:</th>
                                        <td id="view_price"></td>
                                    </tr>
                                    <tr>
                                        <th>Commission Rate:</th>
                                        <td id="view_commission_rate"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 40%">Max Bookings:</th>
                                        <td id="view_max_booking"></td>
                                    </tr>
                                    <tr>
                                        <th>Max Photographers:</th>
                                        <td id="view_max_photographers"></td>
                                    </tr>
                                    <tr>
                                        <th>Support Level:</th>
                                        <td id="view_support_level"></td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td id="view_status"></td>
                                    </tr>
                                    <tr>
                                        <th>Created At:</th>
                                        <td id="view_created_at"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-bold">Description:</h6>
                                <p id="view_description" class="text-muted"></p>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-bold">Features:</h6>
                                <ul id="view_features" class="list-group list-group-flush">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // ===== SEARCH FUNCTIONALITY =====
            $('#tableSearch').on('keyup', function() {
                let searchText = $(this).val().toLowerCase();
                
                $('#tableBody tr').each(function() {
                    let rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // ===== FILTER FUNCTIONALITY =====
            function applyFilters() {
                let userType = $('#userTypeFilter').val().toLowerCase();
                let status = $('#statusFilter').val().toLowerCase();
                
                $('#tableBody tr').each(function() {
                    let showRow = true;
                    let row = $(this);
                    
                    // Skip empty row
                    if (row.find('td').length === 1 && row.find('td').attr('colspan')) {
                        return;
                    }
                    
                    // User Type filter
                    if (userType) {
                        let rowUserType = row.find('td:eq(1)').text().toLowerCase();
                        if (rowUserType !== userType) {
                            showRow = false;
                        }
                    }
                    
                    // Status filter
                    if (status && showRow) {
                        let rowStatus = row.find('td:eq(10) .badge').text().toLowerCase();
                        if (rowStatus !== status) {
                            showRow = false;
                        }
                    }
                    
                    if (showRow) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
                
                // Update showing count
                updateShowingCount();
            }

            $('#userTypeFilter, #statusFilter').on('change', applyFilters);

            // Update showing entries count
            function updateShowingCount() {
                let visibleRows = $('#tableBody tr:visible').length;
                let totalRows = $('#tableBody tr').length;
                let showingText = 'Showing ';
                
                if (visibleRows === 0) {
                    showingText += '0 to 0 of ' + totalRows + ' entries';
                } else {
                    let firstVisible = 1;
                    let lastVisible = visibleRows;
                    showingText += firstVisible + ' to ' + lastVisible + ' of ' + totalRows + ' entries';
                }
                
                $('.dataTables_info').text(showingText);
            }

            // ===== VIEW PLAN MODAL =====
            $(document).on('click', '.btn-view', function() {
                let planId = $(this).data('id');
                
                // Show loading spinner, hide details
                $('#planLoadingSpinner').show();
                $('#planDetails').hide();
                
                // Fetch plan details
                $.ajax({
                    url: '/admin/subscription/' + planId,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let plan = response.data;
                            
                            // Populate modal with plan data
                            $('#view_user_type').text(plan.user_type === 'studio' ? 'Studio Owner' : 'Freelancer');
                            $('#view_plan_type').text(plan.plan_type.charAt(0).toUpperCase() + plan.plan_type.slice(1));
                            $('#view_billing_cycle').text(plan.billing_cycle.charAt(0).toUpperCase() + plan.billing_cycle.slice(1));
                            $('#view_plan_code').text(plan.plan_code);
                            $('#view_name').text(plan.name);
                            $('#view_price').text('₱' + parseFloat(plan.price).toFixed(2));
                            $('#view_commission_rate').text(plan.commission_rate + '%');
                            $('#view_max_booking').text(plan.max_booking ? plan.max_booking + ' per ' + plan.billing_cycle : 'Unlimited');
                            $('#view_max_photographers').text(plan.max_studio_photographers ? plan.max_studio_photographers : 'N/A');
                            $('#view_support_level').text(plan.support_level.charAt(0).toUpperCase() + plan.support_level.slice(1) + ' Support');
                            $('#view_status').html(plan.status === 'active' ? 
                                '<span class="badge badge-soft-success">Active</span>' : 
                                '<span class="badge badge-soft-secondary">Inactive</span>');
                            $('#view_description').text(plan.description || 'No description provided.');
                            $('#view_created_at').text(new Date(plan.created_at).toLocaleDateString());
                            
                            // Features
                            let featuresList = $('#view_features');
                            featuresList.empty();
                            if (plan.features && plan.features.length > 0) {
                                plan.features.forEach(function(feature) {
                                    featuresList.append('<li class="list-group-item"><i class="ti ti-check text-success me-2"></i>' + feature + '</li>');
                                });
                            } else {
                                featuresList.append('<li class="list-group-item text-muted">No features listed.</li>');
                            }
                            
                            // Hide loading, show details
                            $('#planLoadingSpinner').hide();
                            $('#planDetails').show();
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load plan details.',
                            confirmButtonColor: '#3475db'
                        });
                        $('#viewPlanModal').modal('hide');
                    }
                });
            });

            // ===== DELETE PLAN =====
            $(document).on('click', '.btn-delete', function() {
                let planId = $(this).data('id');
                let row = $(this).closest('tr');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3475db',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/subscription/' + planId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true
                                    }).then(() => {
                                        row.fadeOut(300, function() {
                                            $(this).remove();
                                            
                                            // Check if table is empty
                                            if ($('#tableBody tr').length === 0) {
                                                location.reload(); // Reload to show empty state
                                            }
                                            
                                            updateShowingCount();
                                        });
                                    });
                                }
                            },
                            error: function(xhr) {
                                let message = 'Failed to delete plan.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: message,
                                    confirmButtonColor: '#3475db'
                                });
                            }
                        });
                    }
                });
            });

            // Initialize showing count
            updateShowingCount();
        });
    </script>
@endsection