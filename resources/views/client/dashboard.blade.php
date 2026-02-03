@extends('layouts.client.app')
@section('title', 'Client Home')
@section('content')
        <div class="content-page">
            <div class="container-fluid">
                <div class="page-title-head d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="fw-bold m-0">Welcome to SnapStudio</h3>
                        <p>Providing Reliable and Continuous Photography Services for Clients</p>
                    </div>
                </div>

                {{-- FILTER TOGGLE - MOBILE VIEW --}}
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

                                    {{-- PHOTOGRAPHER TYPE --}}
                                    <div class="p-3 border-bottom border-dashed">
                                        <div class="d-flex mb-2 justify-content-between align-items-center">
                                            <h5 class="mb-0">Photographer Type:</h5>
                                            <a href="javascript: void(0);" class="btn btn-link btn-sm px-0 fw-semibold">View All</a>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="type-studio-type-photographer" class="form-check-input">
                                                <label for="type-studio-type-photographer" class="form-check-label mb-0">Studio Photographer</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="type-freelancer-type-photographer" class="form-check-input">
                                                <label for="type-freelancer-type-photographer" class="form-check-label mb-0">Freelancer Photographer</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- CATEGORY --}}
                                    <div class="p-3 border-bottom border-dashed">
                                        <div class="d-flex mb-2 justify-content-between align-items-center">
                                            <h5 class="mb-0">Category:</h5>
                                            <a href="javascript: void(0);" class="btn btn-link btn-sm px-0 fw-semibold">View All</a>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-portrait" class="form-check-input">
                                                <label for="cat-portrait" class="form-check-label mb-0">Portrait Photography</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-wedding" class="form-check-input">
                                                <label for="cat-wedding" class="form-check-label mb-0">Wedding Photography</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-event" class="form-check-input">
                                                <label for="cat-event" class="form-check-label mb-0">Event Photography</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-lifestyle" class="form-check-input">
                                                <label for="cat-lifestyle" class="form-check-label mb-0">Lifestyle Photography</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-fashion" class="form-check-input">
                                                <label for="cat-fashion" class="form-check-label mb-0">Fashion Photography</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-commercial" class="form-check-input">
                                                <label for="cat-commercial" class="form-check-label mb-0">Commercial Photography</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-corporate" class="form-check-input">
                                                <label for="cat-corporate" class="form-check-label mb-0">Corporate Photography</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="cat-food" class="form-check-input">
                                                <label for="cat-food" class="form-check-label mb-0">Food Photography</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- LOCATION --}}
                                    <div class="p-3 border-bottom border-dashed">
                                        <div class="d-flex mb-2 justify-content-between align-items-center">
                                            <h5 class="mb-0">Locations:</h5>
                                            <a href="javascript: void(0);" class="btn btn-link btn-sm px-0 fw-semibold">View All</a>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-bacoor" class="form-check-input">
                                                <label for="loc-bacoor" class="form-check-label mb-0">Bacoor</label>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge text-bg-light">18</span></div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-dasmarinas" class="form-check-input">
                                                <label for="loc-dasmarinas" class="form-check-label mb-0">Dasmariñas</label>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge text-bg-light">22</span></div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-imus" class="form-check-input">
                                                <label for="loc-imus" class="form-check-label mb-0">Imus</label>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge text-bg-light">15</span></div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-general-trias" class="form-check-input">
                                                <label for="loc-general-trias" class="form-check-label mb-0">General Trias</label>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge text-bg-light">10</span></div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-cavite-city" class="form-check-input">
                                                <label for="loc-cavite-city" class="form-check-label mb-0">Cavite City</label>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge text-bg-light">8</span></div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-tagaytay" class="form-check-input">
                                                <label for="loc-tagaytay" class="form-check-label mb-0">Tagaytay</label>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge text-bg-light">12</span></div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-kawit" class="form-check-input">
                                                <label for="loc-kawit" class="form-check-label mb-0">Kawit</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted py-1">
                                            <div class="form-check flex-grow-1">
                                                <input type="checkbox" id="loc-silang" class="form-check-input">
                                                <label for="loc-silang" class="form-check-label mb-0">Silang</label>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge text-bg-light">9</span></div>
                                        </div>
                                    </div>

                                    {{-- PRICE --}}
                                    <div class="p-3 border-bottom border-dashed">
                                        <h5 class="mb-3">Price Range:</h5>

                                        <div id="price-filter" data-slider-size="sm"></div>

                                        <div class="d-flex gap-2 align-items-center mt-3">
                                            <input type="number" class="form-control form-control-sm text-center" placeholder="PHP 00.00">
                                            <span class="fw-semibold text-muted">to</span>
                                            <input type="number" class="form-control form-control-sm text-center" placeholder="PHP 00.00">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="row row-cols-xxl-3 row-cols-lg-3 row-cols-sm-2 row-cols-1 g-2">
                            <div class="col">
                                <div class="card h-100 mb-2 border-0 shadow-sm">
                                    <div class="card-body pb-2">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('assets/images/sellers/7.png') }}" class="rounded" alt="Luxe Lens Co." style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>                                            
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="card-title mb-1">Luxe Lens Co.</h4>
                                                <p class="text-muted mb-1">Studio</p>
                                                <div class="mb-2">
                                                    <span class="text-muted small">
                                                        <i class="ti ti-map-pin me-1"></i>
                                                        <span>Dasmariñas, Cavite</span>
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
                                                <h5 class="text-success d-flex align-items-center gap-2 mb-0">PHP 12,000.00</h5>
                                            </div>                                            
                                            <a class="btn btn-primary px-4" href="{{ route('client.booking-details') }}">Book Service</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100 mb-2 border-0 shadow-sm">
                                    <div class="card-body pb-2">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('assets/images/sellers/3.png') }}" class="rounded" alt="Luxe Lens Co." style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>                                            
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="card-title mb-1">Pitik Gods</h4>
                                                <p class="text-muted mb-1">Freelancer</p>
                                                <div class="mb-2">
                                                    <span class="text-muted small">
                                                        <i class="ti ti-map-pin me-1"></i>
                                                        <span>Carmona, Cavite</span>
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
                                                <h5 class="text-success d-flex align-items-center gap-2 mb-0">PHP 10,000.00</h5>
                                            </div>                                            
                                            <a class="btn btn-primary px-4" href="{{ route('client.booking-details') }}">Book Service</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100 mb-2 border-0 shadow-sm">
                                    <div class="card-body pb-2">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('assets/images/sellers/7.png') }}" class="rounded" alt="Luxe Lens Co." style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>                                            
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="card-title mb-1">Luxe Lens Co.</h4>
                                                <p class="text-muted mb-1">Studio</p>
                                                <div class="mb-2">
                                                    <span class="text-muted small">
                                                        <i class="ti ti-map-pin me-1"></i>
                                                        <span>Dasmariñas, Cavite</span>
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
                                                <h5 class="text-success d-flex align-items-center gap-2 mb-0">PHP 12,000.00</h5>
                                            </div>                                            
                                            <a class="btn btn-primary px-4" href="{{ route('client.booking-details') }}">Book Service</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100 mb-2 border-0 shadow-sm">
                                    <div class="card-body pb-2">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('assets/images/sellers/3.png') }}" class="rounded" alt="Luxe Lens Co." style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>                                            
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="card-title mb-1">Pitik Gods</h4>
                                                <p class="text-muted mb-1">Freelancer</p>
                                                <div class="mb-2">
                                                    <span class="text-muted small">
                                                        <i class="ti ti-map-pin me-1"></i>
                                                        <span>Carmona, Cavite</span>
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
                                                <h5 class="text-success d-flex align-items-center gap-2 mb-0">PHP 10,000.00</h5>
                                            </div>                                            
                                            <a class="btn btn-primary px-4" href="{{ route('client.booking-details') }}">Book Service</a>
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
