@extends('layouts.client.app')
@section('title', 'Booking Form')

{{-- STYLES --}}
@section('styles')
    <style>
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .calendar-day {
            position: relative;
            text-align: center;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .calendar-day:hover:not(.past):not(.unavailable) {
            background: #e7f1ff;
            border-color: #3475db;
        }
        
        .calendar-day.today {
            background: #3475db;
            color: white;
            border-color: #3475db;
        }
        
        .calendar-day.past {
            background: #f8f9fa;
            color: #adb5bd;
            cursor: not-allowed;
        }
        
        .calendar-day.unavailable {
            background: #fee;
            color: #dc3545;
            cursor: not-allowed;
        }
        
        .calendar-day.empty {
            background: transparent;
            border: none;
        }
        
        .availability-dot {
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }
        
        .availability-dot.available {
            background: #28a745;
        }
        
        .availability-dot.unavailable {
            background: #dc3545;
        }
    </style>
@endsection

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header card-title">
                            <h4 class="card-title">Booking Form</h4>
                            <p class="text-muted mb-0">Booking for
                                {{ $type === 'studio' ? $provider->studio_name : $provider->brand_name }}</p>
                        </div>
                        <div class="card-body">
                            <form id="bookingForm" class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" id="bookingType" value="{{ $type }}">
                                <input type="hidden" id="providerId" value="{{ $id }}">

                                {{-- CLIENT INFORMATION --}}
                                <h4 class="card-title text-primary mb-3">Client Information</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="fullName"
                                                value="{{ $user->first_name . ' ' . $user->last_name }}"
                                                placeholder="Enter your full name" required>
                                            <div class="invalid-feedback">
                                                Please enter your full name.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact Number</label>
                                            <input type="tel" class="form-control" id="contactNumber"
                                                value="{{ $user->mobile_number }}" placeholder="Enter your contact number"
                                                required>
                                            <div class="invalid-feedback">
                                                Please enter a valid contact number.
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email"
                                                value="{{ $user->email }}" placeholder="Enter your email address" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SERVICE AND PACKAGES SELECTION --}}
                                <h4 class="card-title text-primary mb-3">Service and Packages Selection</h4>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Service Category</label>
                                    <div class="form-select-wrapper">
                                        <select class="form-select" id="serviceCategory" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a service category.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Select Package</label>
                                    <div id="packagesContainer">
                                        <div class="alert alert-warning">
                                            <i class="ti ti-warning-circle me-2"></i> Please select a category first to view available packages.
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mt-2">
                                        Please select a package.
                                    </div>
                                </div>

                                {{-- EVENT DATE & TIME --}}
                                <h4 class="card-title text-primary mb-3">Event Date & Time</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Event Date</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="eventDate" name="event_date"
                                                    min="{{ date('Y-m-d') }}"
                                                    max="{{ date('Y-m-d', strtotime('+60 days')) }}"
                                                    placeholder="Select event date" required>
                                                <button class="btn btn-outline-primary" type="button" id="viewCalendarBtn">
                                                    <i class="ti ti-calendar me-1"></i> Check Available Dates
                                                </button>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please select a valid event date.
                                            </div>
                                            <small class="text-muted" id="dateAvailabilityStatus"></small>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Start Time</label>
                                            <input type="time" class="form-control" id="startTime" name="start_time"
                                                value="08:00" placeholder="Enter start time" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">End Time</label>
                                            <input type="time" class="form-control" id="endTime" name="end_time"
                                                value="18:00" placeholder="Enter end time" required>
                                        </div>
                                    </div>

                                    {{-- Calendar Modal --}}
                                    <div class="modal fade" id="calendarModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Select Available Date</h5>
                                                    <button type="button" class="btn btn-default btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="availabilityCalendar"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- PAYMENT TYPE --}}
                                <h4 class="card-title text-primary mb-3">Payment Type</h4>
                                <div class="mb-4">
                                    <div class="btn-group w-100" role="group" aria-label="Payment type selection">
                                        <input class="btn-check" type="radio" name="payment_type" id="payment_type_downpayment" value="downpayment" checked>
                                        <label class="btn btn-outline-primary" for="payment_type_downpayment">
                                            <i class="ti ti-percentage me-1"></i> 30% Downpayment
                                        </label>
                                        
                                        <input class="btn-check" type="radio" name="payment_type" id="payment_type_full" value="full_payment">
                                        <label class="btn btn-outline-primary" for="payment_type_full">
                                            <i class="ti ti-discount-2 me-1"></i> Full Payment (5% OFF)
                                        </label>
                                    </div>
                                </div>

                                {{-- EVENT LOCATION --}}
                                <h4 class="card-title text-primary mb-3">Event Location</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Location Type</label>
                                            <select class="form-select" id="locationType" name="location_type" required>
                                                <option value="">Select Location Type</option>
                                                @if ($type === 'studio')
                                                    <option value="in-studio">In-Studio</option>
                                                @endif
                                                <option value="on-location">On-Location</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid location type.
                                            </div>
                                        </div>

                                        <div id="locationDetails" style="display: none;">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Venue Name</label>
                                                <input type="text" class="form-control" id="venueName"
                                                    name="venue_name" placeholder="Enter venue name" required>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Street</label>
                                                <input type="text" class="form-control" id="street" name="street"
                                                    placeholder="Enter street name">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">City/Municipality</label>
                                                <input type="text" class="form-control" id="city" name="city"
                                                    placeholder="Enter city/municipality name">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Barangay</label>
                                                <input type="text" class="form-control" id="barangay"
                                                    name="barangay" placeholder="Enter barangay name">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Province</label>
                                                <input type="text" class="form-control" id="province"
                                                    name="province" value="Cavite" placeholder="Enter province name"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SPECIAL REQUESTS --}}
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Special Requests / Notes</label>
                                    <textarea class="form-control" rows="3" id="specialRequests" name="special_requests"
                                        placeholder="Enter special requests or notes..."></textarea>
                                </div>

                                {{-- TERMS & CONDITIONS --}}
                                <div class="mb-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="termsCheck"
                                            name="terms_agree" required>
                                        <label class="form-check-label" for="termsCheck">
                                            I agree to the <a href="#" class="text-primary">Booking Terms and
                                                Conditions</a>
                                        </label>
                                        <div class="invalid-feedback">
                                            You must agree to the terms and conditions.
                                        </div>
                                    </div>
                                </div>

                                {{-- SUBMIT BUTTON --}}
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-primary w-100" id="submitBookingBtn">
                                            <span id="submitText">Proceed to Summary</span>
                                            <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none"
                                                role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BOOKING SUMMARY MODAL --}}
    <div class="modal fade" id="bookingSummaryModal" tabindex="-1" aria-labelledby="bookingSummaryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="bookingSummaryModalLabel">Booking Summary</h4>
                    <button type="button" class="btn btn-default btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- BOOKING SUMMARY --}}
                    <div class="mb-4">
                        <div class="mb-3">
                            <h5 class="text-primary mb-2">Client Information</h5>
                            <p class="text-muted small mb-1">Full Name:</p>
                            <p class="fw-medium mb-2" id="summaryFullName"></p>

                            <p class="text-muted small mb-1">Contact Number:</p>
                            <p class="fw-medium mb-2" id="summaryContactNumber"></p>

                            <p class="text-muted small mb-1">Email Address:</p>
                            <p class="fw-medium mb-2" id="summaryEmailAddress"></p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="text-primary mb-2">Booking Details</h5>
                            <p class="text-muted small mb-1">Selected Package:</p>
                            <p class="fw-medium mb-2" id="summaryPackage"></p>

                            <p class="text-muted small mb-1">Package Inclusions:</p>
                            <ul class="mb-2" id="summaryInclusions"></ul>

                            <p class="text-muted small mb-1">Event Date:</p>
                            <p class="fw-medium mb-2" id="summaryDate"></p>

                            <p class="text-muted small mb-1">Event Time:</p>
                            <p class="fw-medium mb-2" id="summaryTime"></p>

                            <p class="text-muted small mb-1">Location Type:</p>
                            <p class="fw-medium mb-2" id="summaryLocationType"></p>

                            <div id="summaryLocationDetails"></div>
                        </div>
                    </div>

                    <hr>

                    {{-- PRICE BREAKDOWN --}}
                    <div class="mb-3">
                        <h5 class="text-primary mb-2">Price Breakdown</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Package Price:</span>
                            <span class="fw-medium" id="packagePrice">₱0</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Down Payment (30%):</span>
                            <span class="fw-medium" id="downPayment">₱0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Remaining Balance:</span>
                            <span class="fw-medium" id="remainingBalance">₱0</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Total Amount:</span>
                            <span class="fw-semibold h5 text-success" id="totalAmount">₱0</span>
                        </div>
                    </div>

                    {{-- NEXT STEP --}}
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary btn-lg" id="proceedToPaymentBtn">
                            <i class="ti ti-credit-card me-2"></i>Proceed to Payment
                        </button>
                    </div>

                    <p class="text-muted small text-center mt-3">
                        <i class="ti ti-info-circle me-1"></i>You'll review all details before payment
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- PAYMENT MODAL --}}
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Complete Payment</h5>
                    <button type="button" class="btn btn-default btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="paymentContainer">
                        {{-- Payment form will be loaded here --}}
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
            // Initialize variables
            let selectedPackageId = null;
            let bookingData = null;
            let bookingId = null;

            // Handle payment option selection
            $('input[name="payment_type"]').on('change', function() {
                const paymentType = $(this).val();
                
                // Only get summary if package is already selected
                if (selectedPackageId) {
                    const packageRadio = $(`.package-radio[value="${selectedPackageId}"]`);
                    if (packageRadio.length) {
                        const packageData = packageRadio.data('package');
                        getBookingSummaryWithPaymentType(packageData, paymentType);
                    }
                }
            });

            // Initialize the checked state on page load
            $('input[name="payment_type"]:checked').trigger('change');

            // Load packages when category is selected
            $('#serviceCategory').on('change', function() {
                const categoryId = $(this).val();
                const type = $('#bookingType').val();
                const providerId = $('#providerId').val();
                
                if (!categoryId) {
                    $('#packagesContainer').html(`
                        <div class="alert alert-warning">
                            <i class="ti ti-warning-circle me-2"></i> Please select a category first to view available packages.
                        </div>
                    `);
                    return;
                }
                
                // Show loading
                $('#packagesContainer').html(`
                    <div class="text-center py-3">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2">Loading packages...</span>
                    </div>
                `);
                
                $.ajax({
                    url: '{{ route("client.bookings.packages") }}',
                    type: 'POST',
                    data: {
                        type: type,
                        provider_id: providerId,
                        category_id: categoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success && response.packages.length > 0) {
                            let packagesHtml = '<div class="btn-group w-100" role="group" aria-label="Package selection">';
                            
                            response.packages.forEach(function(package, index) {
                                // Format duration hours
                                const durationText = package.duration === 1 ? '1 Hour' : `${package.duration} Hours`;
                                const priceText = `₱${parseFloat(package.package_price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                                
                                packagesHtml += `
                                    <input type="radio" class="btn-check package-radio" 
                                        name="package" value="${package.id}" 
                                        id="package${package.id}" data-package='${JSON.stringify(package)}'>
                                    <label class="btn btn-outline-primary d-flex flex-column justify-content-center text-start px-3 py-3" for="package${package.id}" style="flex: 1;">
                                        <strong class="mb-2">${package.package_name}</strong>
                                        <div class="mb-1">
                                            <i class="ti ti-clock text-muted me-1"></i>
                                            <small class="text-muted">${durationText}</small>
                                        </div>
                                        <div class="mb-2">
                                            <i class="ti ti-photo text-muted me-1"></i>
                                            <small class="text-muted">${package.maximum_edited_photos} Photos</small>
                                        </div>
                                        <div class="mt-2">
                                            <h4 class="text-success fw-bold mb-0">${priceText}</h4>
                                        </div>
                                    </label>
                                `;
                            });
                            
                            packagesHtml += '</div>';
                            $('#packagesContainer').html(packagesHtml);
                        } else {
                            $('#packagesContainer').html(`
                                <div class="alert alert-info">
                                    <i class="ti ti-info-circle me-2"></i> No packages available for this category.
                                </div>
                            `);
                        }
                    },
                    error: function(xhr) {
                        $('#packagesContainer').html(`
                            <div class="alert alert-danger">
                                <i class="ti ti-alert-circle me-2"></i> Failed to load packages. Please try again.
                            </div>
                        `);
                    }
                });
            });
            
            // Handle package selection
            $(document).on('change', '.package-radio', function() {
                selectedPackageId = $(this).val();
                const packageData = $(this).data('package');
                const paymentType = $('input[name="payment_type"]:checked').val();
                
                // Get booking summary with payment type
                getBookingSummaryWithPaymentType(packageData, paymentType);
            });
            
            // Toggle location details based on location type
            $('#locationType').on('change', function() {
                if ($(this).val() === 'on-location') {
                    $('#locationDetails').show();
                    $('#venueName').prop('required', true);
                } else {
                    $('#locationDetails').hide();
                    $('#venueName').prop('required', false);
                }
            });
            
            // Check date availability
            $('#eventDate').on('change', function() {
                const selectedDate = $(this).val();
                const type = $('#bookingType').val();
                const providerId = $('#providerId').val();
                
                if (!selectedDate) return;
                
                $.ajax({
                    url: '{{ route("client.bookings.check-availability") }}',
                    type: 'POST',
                    data: {
                        type: type,
                        provider_id: providerId,
                        date: selectedDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.available) {
                                $('#dateAvailabilityStatus').html(`
                                    <span class="text-success">
                                        <i class="ti ti-check me-1"></i> Available (${response.existing_bookings}/${response.max_bookings} bookings)
                                    </span>
                                `);
                            } else {
                                $('#dateAvailabilityStatus').html(`
                                    <span class="text-danger">
                                        <i class="ti ti-x me-1"></i> Fully booked (${response.existing_bookings}/${response.max_bookings} bookings)
                                    </span>
                                `);
                            }
                        }
                    },
                    error: function(xhr) {
                        $('#dateAvailabilityStatus').html('');
                    }
                });
            });
            
            // View calendar modal
            $('#viewCalendarBtn').on('click', function() {
                // Generate calendar
                generateAvailabilityCalendar();
                $('#calendarModal').modal('show');
            });
            
            // Submit booking button
            $('#submitBookingBtn').on('click', function() {
                if (!validateBookingForm()) return;
                
                // Collect booking data
                bookingData = {
                    type: $('#bookingType').val(),
                    provider_id: $('#providerId').val(),
                    category_id: $('#serviceCategory').val(),
                    package_id: selectedPackageId,
                    event_date: $('#eventDate').val(),
                    start_time: $('#startTime').val(),
                    end_time: $('#endTime').val(),
                    location_type: $('#locationType').val(),
                    venue_name: $('#venueName').val(),
                    street: $('#street').val(),
                    barangay: $('#barangay').val(),
                    city: $('#city').val(),
                    special_requests: $('#specialRequests').val(),
                    full_name: $('#fullName').val(),
                    contact_number: $('#contactNumber').val(),
                    email: $('#email').val(),
                    payment_type: $('input[name="payment_type"]:checked').val(), // Add payment type
                    _token: '{{ csrf_token() }}'
                };
                
                // Show summary modal
                showBookingSummary();
            });
            
            // Proceed to payment
            $('#proceedToPaymentBtn').on('click', function() {
                processBooking();
            });
            
            // Functions
            function getBookingSummaryWithPaymentType(packageData, paymentType) {
                if (!packageData || !packageData.id) {
                    console.error('Package data or ID is missing');
                    return;
                }
                
                $.ajax({
                    url: '{{ route("client.bookings.summary") }}',
                    type: 'POST',
                    data: {
                        package_id: packageData.id,
                        type: $('#bookingType').val(),
                        payment_type: paymentType,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Store summary data
                            window.bookingSummary = response.summary;
                            
                            // Update price display if summary modal is open
                            if ($('#bookingSummaryModal').hasClass('show')) {
                                updateSummaryPriceDisplay(response.summary);
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Summary error:', xhr);
                    }
                });
            }

            function validateBookingForm() {
                const form = document.getElementById('bookingForm');
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return false;
                }
                
                if (!selectedPackageId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Package Required',
                        text: 'Please select a package.',
                        confirmButtonColor: '#3475db'
                    });
                    return false;
                }
                
                // Check if payment type is selected
                const paymentType = $('input[name="payment_type"]:checked').val();
                if (!paymentType) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Payment Type Required',
                        text: 'Please select a payment type.',
                        confirmButtonColor: '#3475db'
                    });
                    return false;
                }
                
                return true;
            }
            
            function getBookingSummary(packageData) {
                $.ajax({
                    url: '{{ route("client.bookings.summary") }}',
                    type: 'POST',
                    data: {
                        package_id: packageData.id,
                        type: $('#bookingType').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Store summary data
                            window.bookingSummary = response.summary;
                        }
                    },
                    error: function(xhr) {
                        console.error('Summary error:', xhr);
                    }
                });
            }
            
            function showBookingSummary() {
                // Populate summary modal
                $('#summaryFullName').text(bookingData.full_name);
                $('#summaryContactNumber').text(bookingData.contact_number);
                $('#summaryEmailAddress').text(bookingData.email);
                
                // Get package name from selected radio button
                const packageName = $(`.package-radio[value="${selectedPackageId}"]`).siblings('label').find('h6').text();
                $('#summaryPackage').text(packageName);
                
                // Format date and time
                const eventDate = new Date(bookingData.event_date);
                $('#summaryDate').text(eventDate.toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                }));
                
                $('#summaryTime').text(
                    formatTime(bookingData.start_time) + ' - ' + formatTime(bookingData.end_time)
                );
                
                $('#summaryLocationType').text(
                    bookingData.location_type === 'in-studio' ? 'In-Studio' : 'On-Location'
                );
                
                // Location details
                if (bookingData.location_type === 'on-location') {
                    let locationText = '';
                    if (bookingData.venue_name) locationText += bookingData.venue_name + '<br>';
                    if (bookingData.street) locationText += bookingData.street + ', ';
                    if (bookingData.barangay) locationText += bookingData.barangay + ', ';
                    if (bookingData.city) locationText += bookingData.city + ', ';
                    locationText += 'Cavite';
                    
                    $('#summaryLocationDetails').html(`
                        <p class="text-muted small mb-1">Location Details:</p>
                        <p class="fw-medium mb-2">${locationText}</p>
                    `).show();
                } else {
                    $('#summaryLocationDetails').hide();
                }
                
                // Price breakdown
                if (window.bookingSummary) {
                    $('#packagePrice').text('₱' + window.bookingSummary.package_price);
                    $('#downPayment').text('₱' + window.bookingSummary.down_payment);
                    $('#remainingBalance').text('₱' + window.bookingSummary.remaining_balance);
                    $('#totalAmount').text('₱' + window.bookingSummary.total_amount);
                    
                    // Inclusions
                    let inclusionsHtml = '';
                    if (window.bookingSummary.inclusions && Array.isArray(window.bookingSummary.inclusions)) {
                        window.bookingSummary.inclusions.forEach(function(inclusion) {
                            inclusionsHtml += `<li>${inclusion}</li>`;
                        });
                    }
                    $('#summaryInclusions').html(inclusionsHtml);
                }
                
                // Show modal
                $('#bookingSummaryModal').modal('show');
            }
            
            function processBooking() {
                $('#proceedToPaymentBtn').prop('disabled', true);
                $('#proceedToPaymentBtn').html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Processing...
                `);
                
                // Ensure bookingData has payment_type
                if (!bookingData.payment_type) {
                    bookingData.payment_type = $('input[name="payment_type"]:checked').val();
                }
                
                // Create booking
                $.ajax({
                    url: '{{ route("client.bookings.store") }}',
                    type: 'POST',
                    data: bookingData,
                    success: function(response) {
                        if (response.success) {
                            bookingId = response.booking.id;
                            initializePayment();
                        } else {
                            showError('Failed to create booking: ' + response.message);
                            resetPaymentButton();
                        }
                    },
                    error: function(xhr) {
                        console.error('Booking store error:', xhr);
                        // Show specific validation errors
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMessages = [];
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                errorMessages.push(messages.join(', '));
                            });
                            showError('Validation errors: ' + errorMessages.join('; '));
                        } else {
                            showError('Booking creation failed. Please try again.');
                        }
                        resetPaymentButton();
                    }
                });
            }
            
            function initializePayment() {
                Swal.fire({
                    title: 'Confirm Payment',
                    text: 'Are you sure you want to proceed to payment?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Proceed to Payment',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3475db',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        proceedWithPayment();
                    } else {
                        resetPaymentButton();
                    }
                });
            }

            function proceedWithPayment() {
                // Show loading
                $('#proceedToPaymentBtn').prop('disabled', true);
                $('#proceedToPaymentBtn').html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Creating payment link...
                `);
                
                $.ajax({
                    url: '{{ route("client.payments.initialize") }}',
                    type: 'POST',
                    data: {
                        booking_id: bookingId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.type === 'payment_intent') {
                                // Redirect to card payment page
                                window.location.href = response.redirect_url;
                            } else if (response.redirect_url) {
                                // Redirect to checkout session
                                window.location.href = response.redirect_url;
                            } else {
                                showError('No redirect URL provided');
                                resetPaymentButton();
                            }
                        } else {
                            showError('Payment initialization failed: ' + (response.message || 'Unknown error'));
                            if (response.test_mode_note) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Test Mode Notice',
                                    text: response.test_mode_note,
                                    confirmButtonColor: '#3475db'
                                });
                            }
                            resetPaymentButton();
                        }
                    },
                    error: function(xhr) {
                        console.error('Payment init error:', xhr);
                        showError('Payment initialization failed. Please try again.');
                        resetPaymentButton();
                    }
                });
            }
            
            function generateAvailabilityCalendar() {
                const calendarEl = document.getElementById('availabilityCalendar');
                const today = new Date();
                const twoMonthsLater = new Date();
                twoMonthsLater.setMonth(today.getMonth() + 2);
                
                // Get availability data from server
                getCalendarAvailability(today.getFullYear(), today.getMonth() + 1).then(availabilityData => {
                    let calendarHtml = `
                        <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                            <button class="btn btn-sm btn-outline-secondary" id="prevMonth"><i class="ti ti-chevron-left"></i></button>
                            <h6 class="mb-0" id="currentMonth">${today.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</h6>
                            <button class="btn btn-sm btn-outline-secondary" id="nextMonth"><i class="ti ti-chevron-right"></i></button>
                        </div>
                        <div class="calendar-grid" id="calendarGrid">
                    `;
                    
                    // Add day headers
                    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    days.forEach(day => {
                        calendarHtml += `<div class="calendar-day-header">${day}</div>`;
                    });
                    
                    // Add days
                    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    
                    // Empty cells for days before first day of month
                    for (let i = 0; i < firstDay.getDay(); i++) {
                        calendarHtml += `<div class="calendar-day empty"></div>`;
                    }
                    
                    // Days of the month
                    for (let day = 1; day <= lastDay.getDate(); day++) {
                        const date = new Date(today.getFullYear(), today.getMonth(), day);
                        const dateString = date.toISOString().split('T')[0];
                        const isToday = date.toDateString() === today.toDateString();
                        const isPast = date < today;
                        
                        // Check if date is available
                        const dateAvailability = availabilityData[dateString];
                        const isAvailable = dateAvailability ? dateAvailability.available : true;
                        const isFullyBooked = dateAvailability ? dateAvailability.fully_booked : false;
                        
                        let dateClass = 'calendar-day';
                        
                        if (isToday) dateClass += ' today';
                        if (isPast) dateClass += ' past';
                        if (!isAvailable || isFullyBooked) dateClass += ' unavailable';
                        if (isFullyBooked) dateClass += ' fully-booked';
                        
                        calendarHtml += `
                            <div class="${dateClass}" data-date="${dateString}" title="${isFullyBooked ? 'Fully Booked' : (isAvailable ? 'Available' : 'Not Available')}">
                                ${day}
                                ${isFullyBooked ? '<div class="availability-dot unavailable"></div>' : (isAvailable ? '<div class="availability-dot available"></div>' : '')}
                            </div>
                        `;
                    }
                    
                    calendarHtml += '</div>';
                    calendarEl.innerHTML = calendarHtml;
                    
                    // Add click handlers
                    $('.calendar-day:not(.past):not(.unavailable):not(.fully-booked)').on('click', function() {
                        const selectedDate = $(this).data('date');
                        $('#eventDate').val(selectedDate);
                        $('#calendarModal').modal('hide');
                        $('#eventDate').trigger('change');
                    });
                    
                    // Add styles for fully booked dates
                    $('<style>')
                        .prop('type', 'text/css')
                        .html('.calendar-day.fully-booked { background: #fee; border-color: #dc3545; color: #dc3545; cursor: not-allowed; }')
                        .appendTo('head');
                });
            }

            function getCalendarAvailability(year, month) {
                const type = $('#bookingType').val();
                const providerId = $('#providerId').val();
                
                return $.ajax({
                    url: '{{ route("client.bookings.calendar-availability") }}',
                    type: 'POST',
                    data: {
                        type: type,
                        provider_id: providerId,
                        year: year,
                        month: month,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        return response.availability || {};
                    },
                    error: function() {
                        return {};
                    }
                });
            }
            
            function formatTime(timeString) {
                const [hours, minutes] = timeString.split(':');
                const hour = parseInt(hours);
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const formattedHour = hour % 12 || 12;
                return `${formattedHour}:${minutes} ${ampm}`;
            }
            
            function showError(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message,
                    confirmButtonColor: '#3475db'
                });
            }
            
            function resetPaymentButton() {
                $('#proceedToPaymentBtn').prop('disabled', false);
                $('#proceedToPaymentBtn').html(`
                    <i class="ti ti-credit-card me-2"></i>Proceed to Payment
                `);
            }

            function updateSummaryPriceDisplay(summary) {
                $('#packagePrice').text('₱' + summary.package_price);
                $('#downPayment').text('₱' + summary.down_payment);
                $('#remainingBalance').text('₱' + summary.remaining_balance);
                $('#totalAmount').text('₱' + summary.total_amount);
                
                // Update payment type display
                const paymentTypeText = summary.payment_type === 'downpayment' ? '30% Downpayment' : 'Full Payment';
                $('#summaryPaymentType').remove();
                $('#summaryPackage').after(`
                    <p class="text-muted small mb-1">Payment Type:</p>
                    <p class="fw-medium mb-2" id="summaryPaymentType">${paymentTypeText}</p>
                `);
            }
        });
    </script>
@endsection