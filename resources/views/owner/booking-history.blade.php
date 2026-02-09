@extends('layouts.owner.app')
@section('title', 'Booking History')

{{-- Content --}}
@section('content')
        <div class="content-page">
            <div class="container-fluid">                  
                <div class="row mt-3">
                    <div class="col-12">
                        {{-- TABLE --}}
                        <div data-table data-table-rows-per-page="5" class="card">
                            <div class="card-header">
                                <h4 class="card-title">List of Booking History</h4>
                            </div>

                            <div class="card-header border-light justify-content-between">
                                <div class="d-flex gap-2">
                                    <div class="app-search">
                                        <input data-table-search type="search" class="form-control" placeholder="Search...">
                                        <i data-lucide="search" class="app-search-icon text-muted"></i>
                                    </div>
                                    <button class="btn btn-danger d-none">Delete</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                    <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                        <tr class="text-uppercase fs-xxs">
                                            <th class="ps-3" style="width: 1%;">
                                                <input data-table-select-all class="form-check-input form-check-input-light fs-14 mt-0" type="checkbox" value="option">
                                            </th>
                                            <th data-table-sort>Client Name</th>
                                            <th data-table-sort>Category</th>
                                            <th data-table-sort>Service</th>
                                            <th data-table-sort>Package</th>
                                            <th data-table-sort>Date & Time</th>
                                            <th data-table-sort>Booking Status</th>
                                            <th data-table-sort>Total Amount</th>
                                            <th class="text-center" style="width: 1%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-3">
                                                <input class="form-check-input form-check-input-light fs-14 product-item-check mt-0" type="checkbox" value="option">
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <div class="link-reset">Maria Josefina Santos</div>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="fw-medium">Booking ID:</span>
                                                            <span class="text-muted">BK-00123</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Wedding Photography</td>
                                            <td>Full Wedding Day Coverage</td>
                                            <td>Basic</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <p class="mb-1">November 22, 2022</p>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="text-muted">11:00 AM</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-soft-success fs-8 px-1 w-100">FINISHED</span></td>
                                            <td>PHP 25,000</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="#" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#bookingModal"><i class="ti ti-edit fs-lg"></i></a>
                                                    <a href="#" class="btn btn-sm"><i class="ti ti-trash fs-lg"></i></a>
                                                </div>
                                            </td>
                                        </tr>
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
        
        {{-- Modal --}}
        <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold" id="bookingModalLabel">
                            Booking Details - BK-00123
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            {{-- Left Side: Booking & Client Information --}}
                            <div class="col-md-6 col-lg-6">
                                {{-- Booking Status & ID --}}
                                <div class="card border-0 shadow-none mb-4">
                                    <div class="card-body p-0">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h6 class="card-title mb-0 fw-semibold text-uppercase small text-primary">
                                                Booking Overview
                                            </h6>
                                        </div>
                                        
                                        <div class="row g-3">
                                            {{-- Booking ID --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="receipt-text" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Booking ID</label>
                                                        <p class="mb-0 fw-medium">BK-00123</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Booking Date --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="calendar" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Booking Date</label>
                                                        <p class="mb-0 fw-medium">November 22, 2022</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Booking Status --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="check-circle" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Booking Status</label>
                                                        <p class="mb-0 fw-medium text-success">Finished</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Client Information --}}
                                <div class="card border-0 shadow-none mb-4">
                                    <div class="card-body p-0">
                                        <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                            Client Information
                                        </h6>
                                        <div class="row g-3">
                                            {{-- Client Name --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="user" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Client Name</label>
                                                        <p class="mb-0 fw-medium">Maria Josefina Santos</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Contact Number --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="phone" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Contact Number</label>
                                                        <p class="mb-0 fw-medium">+(63) 123 456 7890</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Email Address --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="mail" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Email Address</label>
                                                        <p class="mb-0 fw-medium">mariasantos@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Service Information --}}
                                <div class="card border-0 shadow-none mb-4">
                                    <div class="card-body p-0">
                                        <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                            Service Information
                                        </h6>
                                        <div class="row g-3">
                                            {{-- Category --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="layers" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Category</label>
                                                        <p class="mb-0 fw-medium">Wedding Photography</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Service --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="camera" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Service</label>
                                                        <p class="mb-0 fw-medium">Full Wedding Day Coverage</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Package --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="package" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Package</label>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fw-medium">PHP 40,000</span> |
                                                            <span class="badge badge-soft-primary px-2 fw-medium">Basic</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Add-ons --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="plus-circle" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Add-ons</label>
                                                        <div class="mb-2">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="fw-medium">Drone Shots</span>
                                                                <span class="fw-medium">+PHP 5,000</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="fw-medium">Extra Hour</span>
                                                                <span class="fw-medium">+PHP 2,000</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Side: Schedule & Payment Information --}}
                            <div class="col-md-6 col-lg-6">
                                {{-- Schedule Information --}}
                                <div class="card border-0 shadow-none mb-4">
                                    <div class="card-body p-0">
                                        <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                            Schedule Information
                                        </h6>
                                        <div class="row g-3">
                                            {{-- Event Date --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="calendar-heart" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Event Date</label>
                                                        <p class="mb-0 fw-medium">May 18, 2026</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Event Location --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="map-pin" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Event Location</label>
                                                        <p class="mb-0 fw-medium">Tagaytay City, Cavite</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Time Schedule --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="clock" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Scheduled Time</label>
                                                        <p class="mb-0 fw-medium">8:00 AM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Payment Information --}}
                                <div class="card border-0 shadow-none mb-4">
                                    <div class="card-body p-0">
                                        <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                            Payment Information
                                        </h6>
                                        <div class="row g-3">
                                            {{-- Total Amount --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="credit-card" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Total Amount</label>
                                                        <p class="mb-0 fw-semibold fs-5">PHP 47,000</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Down Payment --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="percent" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Down Payment Required</label>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fw-medium">PHP 14,100</span>
                                                            <span class="badge badge-soft-success px-2 fw-medium">Yes (30%)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Amount Paid --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="wallet" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Amount Paid</label>
                                                        <p class="mb-0 fw-medium text-success">PHP 14,100</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Remaining Balance --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="alert-circle" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Remaining Balance</label>
                                                        <p class="mb-0 fw-medium text-danger">PHP 32,900</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Payment Method --}}
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="banknote" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Payment Method</label>
                                                        <p class="mb-0 fw-medium">Bank Transfer</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Payment Summary --}}
                                            <div class="col-12 mt-3 pt-3 border-top">
                                                <div class="bg-light p-3 rounded">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="text-muted">Package:</span>
                                                        <span class="fw-medium">PHP 40,000</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="text-muted">Drone Shots:</span>
                                                        <span class="fw-medium">+PHP 5,000</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="text-muted">Extra Hour:</span>
                                                        <span class="fw-medium">+PHP 2,000</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between pt-2 border-top">
                                                        <span class="fw-semibold">Total:</span>
                                                        <span class="fw-bold">PHP 47,000</span>
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
        </div>
@endsection