@extends('layouts.owner.app')
@section('title', 'View Packages')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-title d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Subscription Plans</h4>
                        </div>
                        <div class="card-body">

                            <div class="card-header border-0 justify-content-end">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold">
                                        <i class="ti ti-filter me-1"></i>Filter Types:
                                    </span>
                                    <div class="app-filter">
                                        <select id="categoryFilter" class="me-0 form-select form-control">
                                            <option value="">All Types</option>
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4" id="packagesContainer">

                                <!-- Subscription 1: Basic Personal -->
                                <div class="col-md-4 package-item" data-category="individual">
                                    <div class="card shadow-none h-100 my-4 my-lg-0 border border-primary border-2">
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1">Personal Snapshot</h3>
                                            <p class="text-muted mb-0">Perfect for individuals & social media</p>
                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">₱1,499 <small class="fs-5">/ month</small></h1>
                                                <small class="d-block text-muted fs-base">Billed monthly • Cancel anytime</small>
                                                <small class="d-block text-success mt-1">or ₱14,990/year (save 17%)</small>
                                            </div>
                                            <div class="text-start mb-3">
                                                <small class="text-muted fw-semibold d-block mb-2">INCLUDES:</small>
                                                <ul class="list-unstyled fs-sm mb-0">
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        4 photo sessions per year (mini sessions)
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        Up to 40 edited high-res photos / year
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        Private online gallery & downloads
                                                    </li>
                                                    <li class="mb-2 text-muted">
                                                        <i class="ti ti-dots me-2"></i>
                                                        <small>+ more perks</small>
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-calendar text-primary me-2"></i>
                                                        Priority booking within 14 days
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent px-5 pb-4">
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-primary w-100 py-2 fw-semibold rounded-pill view-package-btn" data-package-id="1">
                                                    View Plan Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subscription 2: Family Premium -->
                                <div class="col-md-4 package-item" data-category="family">
                                    <div class="card shadow-none h-100 my-4 my-lg-0 border border-success border-2 position-relative">
                                        <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2">Most Popular</span>
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1">Family Moments</h3>
                                            <p class="text-muted mb-0">Ideal for growing families & milestones</p>
                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">₱2,999 <small class="fs-5">/ month</small></h1>
                                                <small class="d-block text-muted fs-base">Billed monthly • Pause option available</small>
                                                <small class="d-block text-success mt-1">or ₱29,990/year (save 17%)</small>
                                            </div>
                                            <div class="text-start mb-3">
                                                <small class="text-muted fw-semibold d-block mb-2">INCLUDES:</small>
                                                <ul class="list-unstyled fs-sm mb-0">
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        6 sessions per year (mix mini + full)
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        Up to 120 edited photos / year
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        Unlimited gallery access + sharing
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        Free wardrobe consultation
                                                    </li>
                                                    <li class="mb-2 text-muted">
                                                        <i class="ti ti-dots me-2"></i>
                                                        <small>+ family perks</small>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent px-5 pb-4">
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-success w-100 py-2 fw-semibold rounded-pill view-package-btn" data-package-id="2">
                                                    View Plan Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subscription 3: Business / Creator -->
                                <div class="col-md-4 package-item" data-category="business">
                                    <div class="card shadow-none h-100 my-4 my-lg-0 border border-info border-2">
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1">Creator Pro</h3>
                                            <p class="text-muted mb-0">For influencers, brands & businesses</p>
                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">₱4,999 <small class="fs-5">/ month</small></h1>
                                                <small class="d-block text-muted fs-base">Billed monthly or yearly</small>
                                                <small class="d-block text-success mt-1">or ₱49,900/year (save 17%)</small>
                                            </div>
                                            <div class="text-start mb-3">
                                                <small class="text-muted fw-semibold d-block mb-2">INCLUDES:</small>
                                                <ul class="list-unstyled fs-sm mb-0">
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        8 sessions per year (studio + on-location)
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        Up to 250 edited photos / year
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        Commercial usage rights included
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="ti ti-check text-success me-2"></i>
                                                        Priority same-week booking
                                                    </li>
                                                    <li class="mb-2 text-muted">
                                                        <i class="ti ti-dots me-2"></i>
                                                        <small>+ pro features</small>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent px-5 pb-4">
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-info w-100 py-2 fw-semibold rounded-pill view-package-btn" data-package-id="3">
                                                    View Plan Details
                                                </button>
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

    {{-- MODAL --}}
    <div class="modal fade" id="viewPackageModal" tabindex="-1" aria-labelledby="viewPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPackageModalLabel">Subscription Plan Details — Family Moments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="packageDetailsContent">
                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-8">
                                <h3 class="fw-bold">Family Moments</h3>
                                <p class="text-muted mb-1">Recurring photo membership for families</p>
                                <p class="text-muted">Best for: growing families, seasonal milestones, annual portraits</p>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <h2 class="display-5 fw-bold text-success">₱2,999 / month</h2>
                                <small class="text-muted">or ₱29,990/year — save ₱5,998</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3">Core Benefits</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i>6 professional photo sessions per year</li>
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Up to 120 professionally edited images annually</li>
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Unlimited private online gallery access</li>
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i>High-resolution downloads + print rights</li>
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Free outfit & location consultation</li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3">Extra Perks</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="ti ti-calendar text-primary me-2"></i>Priority scheduling (within 10 days)</li>
                                    <li class="mb-2"><i class="ti ti-gift text-primary me-2"></i>1 complimentary mini session (birthday/Christmas)</li>
                                    <li class="mb-2"><i class="ti ti-users text-primary me-2"></i>Up to 8 family members included</li>
                                    <li class="mb-2"><i class="ti ti-refresh text-primary me-2"></i>Easy pause or cancel anytime</li>
                                </ul>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="alert alert-info mb-0">
                            <strong>Important:</strong> Sessions must be scheduled at least 14 days in advance. 
                            Yearly plan offers better value and locks in current pricing. 
                            First month includes setup session at no extra cost.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection