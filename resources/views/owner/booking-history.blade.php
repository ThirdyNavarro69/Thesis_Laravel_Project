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
@endsection