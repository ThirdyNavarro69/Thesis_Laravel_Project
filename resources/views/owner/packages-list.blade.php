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
                            <h4 class="card-title">Package Lists</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-4">
                                @forelse($packages as $package)
                                <div class="col-md-4">
                                    <div class="card shadow-none border h-100 my-4 my-lg-0">
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1">{{ $package->package_name }}</h3>
                                            <p class="text-muted mb-0">{{ $package->studio->studio_name ?? 'N/A' }} - {{ $package->category->category_name ?? 'N/A' }}</p>

                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">PHP {{ number_format($package->package_price, 2) }}</h1>
                                                <small class="d-block text-muted fs-base">{{ $package->duration }} Hours</small>
                                                <small class="d-block text-muted">{{ $package->maximum_edited_photos }} Edited Photos</small>
                                            </div>

                                            <ul class="list-unstyled text-start fs-sm mb-0">
                                                @if($package->package_inclusions && is_array($package->package_inclusions))
                                                    @foreach($package->package_inclusions as $inclusion)
                                                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> {{ $inclusion }}</li>
                                                    @endforeach
                                                @endif
                                                
                                                @if($package->coverage_scope)
                                                    <li class="mb-2"><i class="ti ti-map-pin text-primary me-2"></i> {{ $package->coverage_scope }}</li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="card-footer bg-transparent px-5 pb-4">
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-primary w-100 py-2 fw-semibold rounded-pill">
                                                    View Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="text-center">
                                        <i class="ti ti-package-off fs-1 text-muted"></i>
                                        <h4 class="mt-3">No Packages Created Yet</h4>
                                        <p class="text-muted mb-4">Start by creating your first package</p>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection