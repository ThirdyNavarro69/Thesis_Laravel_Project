@extends('layouts.client.app')
@section('title', 'My Booking History')

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="10" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Booking History</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search by booking ID, provider name, or category...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort>Booking ID</th>
                                        <th data-table-sort>Provider</th>
                                        <th data-table-sort>Category</th>
                                        <th data-table-sort>Event Date</th>
                                        <th data-table-sort>Status</th>
                                        <th data-table-sort>Payment</th>
                                        <th data-table-sort>Total Amount</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr data-booking-id="{{ $booking->id }}" data-booking-status="{{ $booking->status }}">
                                            <td>
                                                <span class="fw-medium">{{ $booking->booking_reference }}</span>
                                                <small class="text-muted d-block">{{ ucfirst($booking->booking_type) }}</small>
                                            </td>
                                            <td>
                                                @if($booking->booking_type === 'studio')
                                                    {{ $booking->provider->studio_name ?? ($booking->provider->studio_name ?? 'Studio') }}
                                                @else
                                                    {{ $booking->provider->brand_name ?? ($booking->provider->brand_name ?? 'Freelancer') }}
                                                @endif
                                            </td>
                                            <td>{{ $booking->category->category_name ?? 'N/A' }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}
                                                <small class="text-muted d-block">{{ $booking->start_time }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $statusBadge = [
                                                        'completed' => 'badge-soft-success',
                                                        'cancelled' => 'badge-soft-danger'
                                                    ][$booking->status] ?? 'badge-soft-secondary';
                                                    $statusText = $booking->status === 'completed' ? 'Completed' : 'Cancelled';
                                                @endphp
                                                <span class="badge {{ $statusBadge }} fs-8 px-2 w-100">{{ $statusText }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $paymentBadge = [
                                                        'paid' => 'badge-soft-success',
                                                        'partially_paid' => 'badge-soft-info',
                                                        'refunded' => 'badge-soft-secondary',
                                                        'cancelled' => 'badge-soft-danger'
                                                    ][$booking->payment_status] ?? 'badge-soft-secondary';
                                                @endphp
                                                <span class="badge {{ $paymentBadge }} fs-8 px-2 w-100">{{ str_replace('_', ' ', $booking->payment_status) }}</span>
                                                @php
                                                    $totalPaid = $booking->payments->where('status', 'succeeded')->sum('amount');
                                                $refunded = $booking->payments->where('status', 'refunded')->sum('amount');
                                                $finalAmount = $booking->payment_status === 'refunded' ? $refunded : $totalPaid;
                                                $paymentText = $booking->payment_status === 'refunded' ? 'Refunded' : 'Paid';
                                                $paymentClass = $booking->payment_status === 'refunded' ? 'text-warning' : 'text-success';
                                                @endphp
                                                <small class="{{ $paymentClass }} d-block mt-1">
                                                    ${paymentText}: ₱{{ number_format($finalAmount, 2) }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="text-end">
                                                    <span class="fw-semibold">₱{{ number_format($booking->total_amount, 2) }}</span>
                                                    @if($booking->payment_status === 'refunded')
                                                    <small class="text-warning d-block">Fully refunded</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm btn-outline-primary view-booking-btn" 
                                                            data-booking-id="{{ $booking->id }}" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#bookingModal"
                                                            title="View Details">
                                                        <i class="ti ti-eye fs-lg"></i>
                                                    </button>
                                                    @if($booking->status === 'completed')
                                                    <button class="btn btn-sm btn-outline-info review-booking-btn" 
                                                            data-booking-id="{{ $booking->id }}"
                                                            data-booking-reference="{{ $booking->booking_reference }}"
                                                            title="Leave Review">
                                                        <i class="ti ti-star fs-lg"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i data-lucide="history" class="fs-20 mb-2"></i>
                                                    <p class="mb-0">No booking history found</p>
                                                    <small class="mt-1">Your completed and cancelled bookings will appear here.</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div data-table-pagination-info="bookings"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- BOOKING DETAILS MODAL (Same as in view-my-bookings) --}}
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="bookingModalLabel">
                        Booking Details - <span id="bookingReference">Loading...</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="bookingModalBody">
                        <div class="text-center py-5">
                            <div class="loading-spinner" style="width: 3rem; height: 3rem; margin: 0 auto;"></div>
                            <p class="mt-3">Loading booking details...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- REVIEW MODAL --}}
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Leave a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="reviewFormContainer">
                        <div class="text-center py-3">
                            <div class="loading-spinner" style="margin: 0 auto;"></div>
                            <p class="mt-2">Loading review form...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            let currentBookingId = null;
            
            // View booking details
            $(document).on('click', '.view-booking-btn', function() {
                currentBookingId = $(this).data('booking-id');
                loadBookingDetails(currentBookingId);
            });

            // Leave review button
            $(document).on('click', '.review-booking-btn', function() {
                const bookingId = $(this).data('booking-id');
                const bookingRef = $(this).data('booking-reference');
                
                Swal.fire({
                    title: 'Leave a Review',
                    text: 'Would you like to leave a review for this completed booking?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3475db',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, leave review',
                    cancelButtonText: 'Not now'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showReviewForm(bookingId, bookingRef);
                    }
                });
            });

            // Filter bookings
            $(document).on('click', '[data-filter]', function(e) {
                e.preventDefault();
                const filter = $(this).data('filter');
                
                // Update active filter
                $('[data-filter]').removeClass('active');
                $(this).addClass('active');
                
                // Filter table rows
                if (filter === 'all') {
                    $('tbody tr').show();
                } else {
                    $('tbody tr').hide();
                    $(`tbody tr[data-booking-status="${filter}"]`).show();
                }
                
                // Update pagination info
                updatePaginationInfo();
            });

            // Load booking details (reuse function from view-my-bookings)
            function loadBookingDetails(bookingId) {
                $.ajax({
                    url: '{{ route("client.booking.details", ":id") }}'.replace(':id', bookingId),
                    type: 'GET',
                    beforeSend: function() {
                        $('#bookingModalBody').html(`
                            <div class="text-center py-5">
                                <div class="loading-spinner" style="width: 3rem; height: 3rem; margin: 0 auto;"></div>
                                <p class="mt-3">Loading booking details...</p>
                            </div>
                        `);
                    },
                    success: function(response) {
                        if (response.success) {
                            renderBookingDetails(response);
                        } else {
                            showError('Error loading booking details: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        showError('Error loading booking details. Please try again.');
                    }
                });
            }

            // Render booking details (similar to view-my-bookings but with history-specific info)
            function renderBookingDetails(data) {
                const booking = data.booking;
                const provider = data.provider;
                const providerType = data.provider_type;
                const category = data.category;
                const packages = data.packages;
                const payments = data.payments;
                const assignedPhotographers = data.assignedPhotographers;
                const paymentSummary = data.payment_summary;

                let packagesHtml = '';
                if (packages && packages.length > 0) {
                    packages.forEach(pkg => {
                        let inclusions = '';
                        if (pkg.package_inclusions && Array.isArray(pkg.package_inclusions)) {
                            inclusions = pkg.package_inclusions.map(inc => `<li>${inc}</li>`).join('');
                        }
                        
                        packagesHtml += `
                            <div class="card border mb-3">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-2">${pkg.package_name}</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Price:</span>
                                        <span class="fw-semibold">₱${parseFloat(pkg.package_price).toFixed(2)}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Duration:</span>
                                        <span>${pkg.duration} hours</span>
                                    </div>
                                    ${inclusions ? `
                                        <div class="mt-3">
                                            <small class="text-muted d-block mb-1">Inclusions:</small>
                                            <ul class="mb-0 ps-3">${inclusions}</ul>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    });
                }

                let refundInfo = '';
                if (booking.payment_status === 'refunded') {
                    const refundAmount = payments.filter(p => p.status === 'refunded').reduce((sum, p) => sum + parseFloat(p.amount), 0);
                    refundInfo = `
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-center">
                                <i data-lucide="refresh-ccw" class="fs-20 me-3"></i>
                                <div>
                                    <h6 class="mb-1">Refund Processed</h6>
                                    <p class="mb-0">Amount refunded: <span class="fw-semibold">₱${refundAmount.toFixed(2)}</span></p>
                                </div>
                            </div>
                        </div>
                    `;
                }

                let completionInfo = '';
                if (booking.status === 'completed') {
                    completionInfo = `
                        <div class="alert alert-success">
                            <div class="d-flex align-items-center">
                                <i data-lucide="check-circle" class="fs-20 me-3"></i>
                                <div>
                                    <h6 class="mb-1">Service Successfully Completed</h6>
                                    <p class="mb-0">Thank you for choosing our service!</p>
                                </div>
                            </div>
                        </div>
                    `;
                }

                const modalContent = `
                    <div class="row g-4">
                        <div class="col-md-6">
                            ${refundInfo}
                            ${completionInfo}
                            
                            <div class="card border-0 shadow-none mb-4">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                        Booking Summary
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="receipt-text" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Booking Reference</label>
                                                    <p class="mb-0 fw-semibold">${booking.booking_reference}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="calendar" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Event Date</label>
                                                    <p class="mb-0 fw-medium">${new Date(booking.event_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                                                    <small class="text-muted">${booking.start_time} - ${booking.end_time}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="layers" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Service Category</label>
                                                    <p class="mb-0 fw-medium">${category ? category.category_name : 'N/A'}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-none">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                        Service Provider
                                    </h6>
                                    <div class="d-flex align-items-center p-3 border rounded">
                                        ${provider ? `
                                            <div class="avatar-xl me-3">
                                                                                                <img src="${provider && (providerType === 'studio' ? (provider.studio_logo ? '{{ asset("storage/") }}/' + provider.studio_logo : '{{ asset("assets/images/sellers/7.png") }}') : (provider.brand_logo ? '{{ asset("storage/") }}/' + provider.brand_logo : '{{ asset("assets/images/sellers/3.png") }}')) || '{{ asset("assets/images/sellers/7.png") }}'}" 
                                                     class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" alt="Provider Logo">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">
                                                    ${providerType === 'studio' ? provider.studio_name : provider.brand_name}
                                                </h6>
                                                <small class="text-muted">
                                                    ${provider.contact_number ? provider.contact_number + ' • ' : ''}
                                                    ${provider.contact_email || provider.studio_email || ''}
                                                </small>
                                            </div>
                                        ` : `
                                            <div class="text-center w-100">
                                                <small class="text-muted">Provider information not available</small>
                                            </div>
                                        `}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-none mb-4">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                        Financial Summary
                                    </h6>
                                    <div class="bg-light p-3 rounded mb-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Total Amount:</span>
                                            <span class="fw-semibold">₱${parseFloat(paymentSummary.total_amount).toFixed(2)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Amount Paid:</span>
                                            <span class="fw-medium text-success">₱${parseFloat(paymentSummary.total_paid).toFixed(2)}</span>
                                        </div>
                                        ${booking.payment_status === 'refunded' ? `
                                            <div class="d-flex justify-content-between mb-2 text-warning">
                                                <span>Amount Refunded:</span>
                                                <span class="fw-semibold">₱${parseFloat(paymentSummary.total_paid).toFixed(2)}</span>
                                            </div>
                                        ` : ''}
                                        <div class="d-flex justify-content-between pt-2 border-top">
                                            <span class="fw-semibold">Final Status:</span>
                                            <span class="fw-bold ${booking.payment_status === 'refunded' ? 'text-warning' : 'text-success'}">
                                                ${booking.payment_status === 'refunded' ? 'FULLY REFUNDED' : 'PAID IN FULL'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-none">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="card-title mb-0 fw-semibold text-uppercase small text-primary">
                                            Packages Used
                                        </h6>
                                    </div>
                                    ${packagesHtml || '<p class="text-muted">No package information available</p>'}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#bookingReference').text(booking.booking_reference);
                $('#bookingModalBody').html(modalContent);
                loadIcons();
            }

            // Show review form
            function showReviewForm(bookingId, bookingRef) {
                $('#reviewFormContainer').html(`
                    <form id="reviewForm">
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-2">Booking: ${bookingRef}</h6>
                            <p class="text-muted small">Please share your experience with this service.</p>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-medium">Overall Rating</label>
                            <div class="rating-stars mb-2">
                                <div class="d-flex">
                                    <i class="ti ti-star text-warning fs-4 me-1 rating-star" data-value="1"></i>
                                    <i class="ti ti-star text-warning fs-4 me-1 rating-star" data-value="2"></i>
                                    <i class="ti ti-star text-warning fs-4 me-1 rating-star" data-value="3"></i>
                                    <i class="ti ti-star text-warning fs-4 me-1 rating-star" data-value="4"></i>
                                    <i class="ti ti-star text-warning fs-4 me-1 rating-star" data-value="5"></i>
                                </div>
                                <small class="text-muted">Click stars to rate</small>
                            </div>
                            <input type="hidden" name="rating" id="ratingValue" value="0">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-medium">Review Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Summarize your experience..." required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-medium">Detailed Review</label>
                            <textarea class="form-control" name="review" rows="4" placeholder="Share details about your experience with the service provider..." required></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-check-label fw-medium">Would you recommend this service to others?</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="recommend" id="recommendYes" value="1" checked>
                                    <label class="form-check-label" for="recommendYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="recommend" id="recommendNo" value="0">
                                    <label class="form-check-label" for="recommendNo">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="booking_id" value="${bookingId}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-send me-2"></i> Submit Review
                            </button>
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                `);
                
                // Initialize rating stars
                $('.rating-star').on('click', function() {
                    const rating = $(this).data('value');
                    $('#ratingValue').val(rating);
                    
                    // Update star display
                    $('.rating-star').removeClass('filled');
                    $('.rating-star').each(function() {
                        if ($(this).data('value') <= rating) {
                            $(this).addClass('filled');
                        }
                    });
                });
                
                // Initialize star display
                $('.rating-star').addClass('ti-star');
                $('.rating-star.filled').addClass('ti-star-filled');
                
                // Handle form submission
                $('#reviewForm').on('submit', function(e) {
                    e.preventDefault();
                    submitReview(bookingId);
                });
                
                // Show modal
                const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
                reviewModal.show();
            }

            // Submit review
            function submitReview(bookingId) {
                const formData = $('#reviewForm').serialize();
                
                $.ajax({
                    url: '/client/reviews',
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#reviewForm button[type="submit"]').prop('disabled', true).html('<span class="loading-spinner"></span> Submitting...');
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Review Submitted!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                const reviewModal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
                                reviewModal.hide();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#3475db'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to submit review. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                    },
                    complete: function() {
                        $('#reviewForm button[type="submit"]').prop('disabled', false).html('<i class="ti ti-send me-2"></i> Submit Review');
                    }
                });
            }

            // Update pagination info after filtering
            function updatePaginationInfo() {
                const visibleRows = $('tbody tr:visible').length;
                $('[data-table-pagination-info]').text(`Showing ${visibleRows} bookings`);
            }

            // Helper functions
            function showError(message) {
                $('#bookingModalBody').html(`
                    <div class="text-center py-5">
                        <i data-lucide="alert-circle" class="fs-20 text-danger mb-3"></i>
                        <p class="text-danger">${message}</p>
                        <button class="btn btn-sm btn-primary mt-2" onclick="loadBookingDetails(${currentBookingId})">
                            <i data-lucide="refresh-cw" class="me-1"></i> Retry
                        </button>
                    </div>
                `);
                loadIcons();
            }

            function loadIcons() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }

            // Initialize icons
            loadIcons();
            
            // Initialize filter
            $('[data-filter="all"]').addClass('active');
        });
    </script>
    <style>
        .rating-star {
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.2s;
        }
        .rating-star:hover,
        .rating-star.filled {
            opacity: 1;
        }
        .rating-star.filled::before {
            content: "\\eb1a"; /* ti-star-filled */
        }
    </style>
@endsection