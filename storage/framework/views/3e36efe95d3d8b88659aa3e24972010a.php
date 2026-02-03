
<?php $__env->startSection('title', 'Studio Details'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header card-title">
                            <h4 class="card-title">Booking Details</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate>
                                
                                <h4 class="card-title text-primary mb-3">Client Information</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" placeholder="Enter your full name"
                                                required>
                                            <div class="invalid-feedback">
                                                Please enter your full name.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact Number</label>
                                            <input type="tel" class="form-control"
                                                placeholder="Enter your contact number" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid contact number.
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control"
                                                placeholder="Enter your email address" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <h4 class="card-title text-primary mb-3">Service and Packages Selection</h4>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Service Category</label>
                                    <div class="form-select-wrapper">
                                        <select class="form-select" id="serviceCategory" name="service_category" required>
                                            <option value="">Select Category</option>
                                            <option value="wedding">Wedding Photography</option>
                                            <option value="portrait">Portrait Photography</option>
                                            <option value="event">Event Photography</option>
                                            <option value="family">Family Photography</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a service category.
                                    </div>
                                </div>

                                <h4 class="card-title text-primary mb-3">Packages</h4>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Select Package</label>
                                    <div class="btn-group w-100" role="group" aria-label="Package selection">
                                        <input type="radio" class="btn-check" name="package" value="basic"
                                            id="basicPackage" required>
                                        <label class="btn btn-outline-primary text-start" for="basicPackage">
                                            <div class="d-flex flex-column">
                                                <h5 class="fw-semibold">Basic Package</h5>
                                                <small class="text-success">PHP 15,000</small>
                                            </div>
                                        </label>
                                        <input type="radio" class="btn-check" name="package" value="essentials"
                                            id="essentialsPackage">
                                        <label class="btn btn-outline-primary text-start" for="essentialsPackage">
                                            <div class="d-flex flex-column">
                                                <h5 class="fw-semibold">Essentials Package</h5>
                                                <small class="text-success">PHP 20,000</small>
                                            </div>
                                        </label>
                                        <input type="radio" class="btn-check" name="package" value="premium"
                                            id="premiumPackage">
                                        <label class="btn btn-outline-primary text-start" for="premiumPackage">
                                            <div class="d-flex flex-column">
                                                <h5 class="fw-semibold">Premium Package</h5>
                                                <small class="text-success">PHP 30,000</small>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="invalid-feedback mt-2">
                                        Please select a package.
                                    </div>
                                </div>

                                
                                <h4 class="card-title text-primary mb-3">Event Date & Time</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Event Date</label>
                                            <input type="date" class="form-control" id="eventDate" name="event_date"
                                                min="<?php echo e(date('Y-m-d')); ?>" placeholder="Enter event date" required>
                                            <div class="invalid-feedback">
                                                Please select a valid event date.
                                            </div>
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
                                </div>

                                
                                <h4 class="card-title text-primary mb-3">Event Location</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Location Type</label>
                                            <select class="form-select" aria-label="Select location type"
                                                name="location_type" required>
                                                <option value="">Select Location Type</option>
                                                <option value="in-studio">In-Studio</option>
                                                <option value="on-location">On-Location</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid location type.
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Venue Name</label>
                                            <input type="text" class="form-control" id="venueName" name="venue_name"
                                                placeholder="Enter venue name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Street</label>
                                            <input type="text" class="form-control" id="street" name="street"
                                                placeholder="Enter street name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">City/Municipality</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="Enter city/municipality name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Barangay</label>
                                            <input type="text" class="form-control" id="barangay" name="barangay"
                                                placeholder="Enter barangay name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Province</label>
                                            <input type="text" class="form-control" id="province" name="province"
                                                value="Cavite" placeholder="Enter province name" disabled readonly>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Special Requests / Notes</label>
                                    <textarea class="form-control" rows="3" id="specialRequests" name="notes"
                                        placeholder="Enter special requests or notes..."></textarea>
                                </div>

                                
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

                                
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-primary w-100" id="submitBtn"
                                            data-bs-toggle="modal" data-bs-target="#bookingSummaryModal">
                                            <span id="submitText">Submit Booking</span>
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

    
    <div class="modal fade" id="bookingSummaryModal" tabindex="-1" aria-labelledby="bookingSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="bookingSummaryModalLabel">Booking Summary</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="mb-4">
                        <h4 class="card-title mb-3 d-none">Booking Summary</h4>
                        <!-- hidden since it's now in modal title -->
                        <div class="mb-3">
                            <p class="text-muted small mb-1">Full Name:</p>
                            <p class="fw-medium mb-2" id="summaryFullName">John Doe</p>

                            <p class="text-muted small mb-1">Contact Number:</p>
                            <p class="fw-medium mb-2" id="summaryContactNumber">+(63) 123 456 7890</p>

                            <p class="text-muted small mb-1">Email Address:</p>
                            <p class="fw-medium mb-2" id="summaryEmailAddress">john.doe@example.com</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <p class="text-muted small mb-1">Selected Services:</p>
                            <p class="fw-medium mb-2" id="summaryServices">Wedding Photography</p>

                            <p class="text-muted small mb-1">Selected Package:</p>
                            <p class="fw-medium mb-2" id="summaryPackage">Essential Package</p>

                            <p class="text-muted small mb-1">Event Date:</p>
                            <p class="fw-medium mb-2" id="summaryDate">02/02/2026</p>

                            <p class="text-muted small mb-1">Event Time:</p>
                            <p class="fw-medium mb-2" id="summaryTime">08:00am - 05:00pm</p>

                            <p class="text-muted small mb-1">Location:</p>
                            <p class="fw-medium mb-2" id="summaryLocation">The Green Pavilion</p>
                        </div>
                    </div>

                    <hr>

                    
                    <div class="mb-3">
                        <p class="text-muted small mb-1">Price Breakdown</p>
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
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="fw-medium" id="subTotal">₱0</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Total Price:</span>
                            <span class="fw-semibold h5 text-success" id="totalPrice">₱0</span>
                        </div>
                    </div>

                    
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary btn-lg" onclick="validateBooking()">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/client/booking-forms.blade.php ENDPATH**/ ?>