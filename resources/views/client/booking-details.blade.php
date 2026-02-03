@extends('layouts.client.app')
@section('title', 'Studio Details')

{{-- CONTENT --}}
@section('content')
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
                                            <img src="{{ asset('assets/images/sellers/7.png') }}"  class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="Studio Logo">
                                        </div>
                                        
                                        <div class="flex-grow-1 ms-md-4 text-center text-md-start">
                                            <h2 class="mb-1 h4 h3-md">Luxe Lens Photography Studio</h2>
                                            <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2 flex-wrap">
                                                <span class="text-warning me-2">
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-half-filled"></i>
                                                    <i class="ti ti-star"></i>
                                                </span>
                                                <span class="text-muted me-2">4.5</span>
                                                <span class="badge badge-soft-success p-1">Verified Studio</span>
                                            </div>
                                            
                                            <p class="text-muted mb-0 small">
                                                <i class="ti ti-map-pin me-1"></i> Dasmariñas City, Cavite | Established: 2018
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                                    <div class="d-flex flex-column gap-2 align-items-center align-items-lg-end">
                                        <div class="text-center text-lg-end">
                                            <span class="text-muted d-block">Starting Price at</span>
                                            <h3 class="text-success mb-0 h4">PHP 3,500</h3>
                                        </div>
                                        <a href="{{ route('client.booking-forms') }}" class="btn btn-primary w-md-auto">
                                            <i class="ti ti-calendar-check me-2"></i> Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- LEFT SIDE --}}
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    {{-- ABOUT --}}
                                    <div class="row mb-3">
                                        <h5 class="card-title mb-2 text-primary">About Our Studio</h5>
                                        <p class="mb-0">
                                            Professional photography studio specializing in wedding, portrait, and event photography. 
                                            With over 5 years of experience, we capture your special moments with creativity and precision. 
                                            Our team of certified photographers ensures high-quality results for every project.
                                        </p>
                                    </div>

                                    {{-- SERVICES --}}
                                    <div class="row mb-3">
                                        <h5 class="card-title text-primary">Services Offered</h5>
                                        <div class="row g-0">
                                            <div class="col-md-6">
                                                <ul class="list-group border-0">
                                                    <li class="list-group-item"><i class="ti ti-check text-success me-2"></i> Wedding Photography</li>
                                                    <li class="list-group-item"><i class="ti ti-check text-success me-2"></i> Portrait Photography</li>
                                                    <li class="list-group-item"><i class="ti ti-check text-success me-2"></i> Food Photography</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PACKAGES --}}
                                    <div class="mb-4">
                                        <h5 class="card-title text-primary mb-3">List of Packages</h5>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Select Service Package</label>
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected>Select Service Category</option>
                                                        <option value="">Wedding Photography</option>
                                                        <option value="">Pet Photography</option>
                                                        <option value="">Fashion Photography</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card border h-100 rounded-0">
                                                    <div class="card-body pb-0">
                                                        <div class="mb-3">
                                                            <h6 class="card-title fw-bold">Basic Wedding Package</h6>
                                                            <span class="text-success fw-semibold mb-0">PHP 15,000</span>
                                                        </div>
                                                        <div class="list-group">
                                                            <div class="mb-1">2 hours photography coverage</div>
                                                            <div class="mb-1">Basic editing & retouching</div>
                                                            <div class="mb-1">Digital delivery of all photos</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="card border h-100 rounded-0 border-top-0">
                                                    <div class="card-body pb-0">
                                                        <div class="mb-3">
                                                            <h6 class="card-title fw-bold">Essentials Wedding Package</h6>
                                                            <span class="text-success fw-semibold mb-0">PHP 30,000</span>
                                                        </div>
                                                        <div class="list-group">
                                                            <div class="mb-1">6 hours photography coverage</div>
                                                            <div class="mb-1">Standard editing & retouching</div>
                                                            <div class="mb-1">Digital delivery of all photos</div>
                                                            <div class="mb-1">Online gallery for 60 days</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="card border h-100 rounded-0 border-top-0">
                                                    <div class="card-body pb-0">
                                                        <div class="mb-3">
                                                            <h6 class="card-title fw-bold">Premium Wedding Package</h6>
                                                            <span class="text-success fw-semibold mb-0">PHP 45,000</span>
                                                        </div>
                                                        <div class="list-group">
                                                            <div class="mb-1">12 hours photography coverage</div>
                                                            <div class="mb-1">Advanced editing & retouching</div>
                                                            <div class="mb-1">Digital delivery of all photos</div>
                                                            <div class="mb-1">Online gallery for 90 days</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- COVERAGE AREAS --}}
                                    <div class="row mb-3">
                                        <h5 class="card-title text-primary">Service Coverage Areas</h5>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <ul class="list-group border-0">
                                                    <li class="list-group-item"><i class="ti ti-map-pin text-success me-2"></i> Dasmariñas City</li>
                                                    <li class="list-group-item"><i class="ti ti-map-pin text-success me-2"></i> Imus City</li>
                                                    <li class="list-group-item"><i class="ti ti-map-pin text-success me-2"></i> Bacoor City</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- OPERATING HOURS --}}
                                    <div class="row mb-3">
                                        <h5 class="card-title mb-3 text-primary">Operating Hours</h5>
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
                                                    <tr>
                                                        <td>Monday</td>
                                                        <td>9:00 AM</td>
                                                        <td>6:00 PM</td>
                                                        <td><span class="badge badge-soft-primary w-100">AVAILABLE</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tuesday</td>
                                                        <td>9:00 AM</td>
                                                        <td>6:00 PM</td>
                                                        <td><span class="badge badge-soft-primary w-100">AVAILABLE</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Wednesday</td>
                                                        <td>9:00 AM</td>
                                                        <td>6:00 PM</td>
                                                        <td><span class="badge badge-soft-primary w-100">AVAILABLE</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Thursday</td>
                                                        <td>9:00 AM</td>
                                                        <td>6:00 PM</td>
                                                        <td><span class="badge badge-soft-primary w-100">AVAILABLE</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Friday</td>
                                                        <td>9:00 AM</td>
                                                        <td>6:00 PM</td>
                                                        <td><span class="badge badge-soft-primary w-100">AVAILABLE</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Saturday</td>
                                                        <td>9:00 AM</td>
                                                        <td>6:00 PM</td>
                                                        <td><span class="badge badge-soft-primary w-100">AVAILABLE</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sunday</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td><span class="badge badge-soft-danger w-100">UNAVAILABLE</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- AVAILABLE DATE --}}
                                    <div class="row g-2 mb-3">
                                        <h5 class="card-title mb-2 text-primary">Available Date</h5>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-default-date data-inline-date="true">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted mb-2">Calendar Indicator</label>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="ti ti-circle-filled text-success me-2 lh-1"></i>
                                                    <span class="text-muted">Available Date for Booking</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="ti ti-circle-filled text-danger me-2 lh-1"></i>
                                                    <span class="text-muted">Fully Booked / Unavailable</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- LOCATION --}}
                                    <div class="row mb-3">
                                        <h5 class="card-title mb-3 text-primary">Studio Location</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1">Province</label>
                                                    <p class="mb-0 fw-medium">Cavite</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1">Municipality</label>
                                                    <p class="mb-0 fw-medium">Dasmariñas City</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1">Barangay</label>
                                                    <p class="mb-0 fw-medium">Zone 4</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1">Address</label>
                                                    <p class="mb-0 fw-medium">123 Photography Street, Zone 4, Dasmariñas City, Cavite 4114</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT SIDE --}}
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-3">Contact Information</h5>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted mb-1">Studio Owner</label>
                                        <p class="mb-0 fw-medium">Juan Dela Cruz</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted mb-1">Email Address</label>
                                        <p class="mb-0 fw-medium">info@luxelens.com</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted mb-1">Contact Number</label>
                                        <p class="mb-0 fw-medium">+(63) 917 123 4567</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label text-muted mb-1">Response Time</label>
                                        <p class="mb-0 fw-medium">Usually responds within 2 hours</p>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary">
                                            <i class="ti ti-phone me-2"></i>
                                            Contact Studio
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
                                                <p class="text-muted mb-0">Book at least 3 days in advance</p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-start mb-3">
                                            <i class="ti ti-coin text-primary me-2 mt-1"></i>
                                            <div>
                                                <h5 class="mb-1">Payment Terms</h5>
                                                <p class="text-muted mb-0">30% downpayment to confirm booking</p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-start mb-3">
                                            <i class="ti ti-users text-primary me-2 mt-1"></i>
                                            <div>
                                                <h5 class="mb-1">Capacity</h5>
                                                <p class="text-muted mb-0">Maximum 3 clients per day</p>
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
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        // Simple JavaScript for price calculation (static example)
        document.addEventListener('DOMContentLoaded', function() {
            // Get all interactive elements
            const packageSelect = document.getElementById('packageSelect');
            const eventDate = document.getElementById('eventDate');
            const startTime = document.getElementById('startTime');
            const endTime = document.getElementById('endTime');
            const venueName = document.getElementById('venueName');
            const city = document.getElementById('city');
            const addonCheckboxes = document.querySelectorAll('input[type="checkbox"][data-price]');
            
            // Set tomorrow's date as default
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            eventDate.valueAsDate = tomorrow;
            
            // Update summary when any input changes
            const updateElements = [packageSelect, eventDate, startTime, endTime, venueName, city, ...addonCheckboxes];
            updateElements.forEach(element => {
                element.addEventListener('change', updateSummary);
            });
            
            // Also update when typing in location fields
            ['street', 'barangay', 'city', 'province'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', updateSummary);
                }
            });
            
            // Initialize summary
            updateSummary();
            
            function updateSummary() {
                // Update booking summary
                const packageOption = packageSelect.options[packageSelect.selectedIndex];
                document.getElementById('summaryPackage').textContent = packageOption.text || '-';
                
                // Format date
                if (eventDate.value) {
                    const date = new Date(eventDate.value);
                    document.getElementById('summaryDate').textContent = date.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    
                    // Update balance due text
                    document.getElementById('balanceDueText').textContent = 
                        `Remaining balance due on or before ${date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}`;
                } else {
                    document.getElementById('summaryDate').textContent = '-';
                }
                
                // Update time
                if (startTime.value && endTime.value) {
                    const formatTime = (time) => {
                        const [hours, minutes] = time.split(':');
                        const hour = parseInt(hours);
                        const ampm = hour >= 12 ? 'PM' : 'AM';
                        const displayHour = hour % 12 || 12;
                        return `${displayHour}:${minutes} ${ampm}`;
                    };
                    document.getElementById('summaryTime').textContent = 
                        `${formatTime(startTime.value)} - ${formatTime(endTime.value)}`;
                } else {
                    document.getElementById('summaryTime').textContent = '-';
                }
                
                // Update location
                const venue = venueName.value;
                const cityVal = document.getElementById('city').value;
                const provinceVal = document.getElementById('province').value;
                
                if (venue || cityVal || provinceVal) {
                    const locationParts = [];
                    if (venue) locationParts.push(venue);
                    if (cityVal) locationParts.push(cityVal);
                    if (provinceVal) locationParts.push(provinceVal);
                    document.getElementById('summaryLocation').textContent = locationParts.join(', ');
                } else {
                    document.getElementById('summaryLocation').textContent = '-';
                }
                
                // Calculate prices
                const basePrice = packageOption.dataset.price ? parseInt(packageOption.dataset.price) : 0;
                
                // Calculate add-ons
                let addonsTotal = 0;
                let addonsHTML = '';
                addonCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const price = parseInt(checkbox.dataset.price);
                        addonsTotal += price;
                        
                        // Get label text
                        const label = checkbox.nextElementSibling.textContent.split(' - ')[0];
                        addonsHTML += `
                            <div class="d-flex justify-content-between mb-2">
                                <span>${label}:</span>
                                <span class="fw-medium">₱${price.toLocaleString()}</span>
                            </div>
                        `;
                    }
                });
                
                // Calculate travel fee (example: if outside Dasmariñas)
                const travelFeeRow = document.getElementById('travelFeeRow');
                let travelFee = 0;
                const currentCity = city.value.toLowerCase();
                if (currentCity && !currentCity.includes('dasmariñas') && !currentCity.includes('dasmariÃ±as')) {
                    travelFee = 2000;
                    travelFeeRow.style.display = 'flex';
                } else {
                    travelFeeRow.style.display = 'none';
                }
                
                // Update prices
                document.getElementById('packagePrice').textContent = `₱${basePrice.toLocaleString()}`;
                document.getElementById('addonsList').innerHTML = addonsHTML;
                document.getElementById('travelFee').textContent = `₱${travelFee.toLocaleString()}`;
                
                const total = basePrice + addonsTotal + travelFee;
                document.getElementById('totalPrice').textContent = `₱${total.toLocaleString()}`;
                
                const downPayment = Math.round(total * 0.3);
                const remainingBalance = total - downPayment;
                
                document.getElementById('downPayment').textContent = `₱${downPayment.toLocaleString()}`;
                document.getElementById('remainingBalance').textContent = `₱${remainingBalance.toLocaleString()}`;
            }
        });

        function validateBooking() {
            // Simple validation
            const requiredFields = [
                'venueName', 'street', 'barangay', 'city', 'province'
            ];
            
            let isValid = true;
            
            // Check required fields
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Check package selection
            const packageSelect = document.getElementById('packageSelect');
            if (!packageSelect.value) {
                isValid = false;
                packageSelect.classList.add('is-invalid');
            } else {
                packageSelect.classList.remove('is-invalid');
            }
            
            // Check date and time
            const eventDate = document.getElementById('eventDate');
            const startTime = document.getElementById('startTime');
            const endTime = document.getElementById('endTime');
            
            if (!eventDate.value || !startTime.value || !endTime.value) {
                isValid = false;
                if (!eventDate.value) eventDate.classList.add('is-invalid');
                if (!startTime.value) startTime.classList.add('is-invalid');
                if (!endTime.value) endTime.classList.add('is-invalid');
            } else {
                eventDate.classList.remove('is-invalid');
                startTime.classList.remove('is-invalid');
                endTime.classList.remove('is-invalid');
            }
            
            // Check terms
            const termsCheck = document.getElementById('termsCheck');
            const cancellationCheck = document.getElementById('cancellationCheck');
            
            if (!termsCheck.checked || !cancellationCheck.checked) {
                isValid = false;
                alert('Please agree to the terms and conditions');
            }
            
            if (isValid) {
                // Show payment modal
                const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                paymentModal.show();
            } else {
                alert('Please fill in all required fields marked with *');
            }
        }
    </script>
@endsection