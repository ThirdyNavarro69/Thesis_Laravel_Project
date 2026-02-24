@extends('layouts.owner.app')
@section('title', 'View Subscription Status')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="10" class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Subscription Status</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input type="search" id="searchInput" class="form-control" placeholder="Search subscriptions...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold">
                                    <i class="ti ti-filter me-1"></i>Filter By:
                                </span>
                                <div class="app-filter">
                                    <select id="statusFilter" class="me-0 form-select form-control">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="expired">Expired</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th>Reference</th>
                                        <th>Plan</th>
                                        <th>Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="subscriptionTableBody">
                                    @php
                                        $user = auth()->user();
                                        $studio = $user->studio ?? \App\Models\StudioOwner\StudiosModel::where('user_id', $user->id)->first();
                                        $subscriptions = [];
                                        
                                        if ($studio) {
                                            $subscriptions = \App\Models\StudioPlanModel::with('plan')
                                                ->where('studio_id', $studio->id)
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                                        }
                                    @endphp

                                    @forelse($subscriptions as $subscription)
                                    @php
                                        $canCancel = $subscription->canBeCancelled();
                                        $cancelDeadline = $subscription->getCancellationDeadline()->format('M d, Y');
                                        
                                        // Debug - Remove this in production
                                        \Log::info('Subscription Debug', [
                                            'id' => $subscription->id,
                                            'reference' => $subscription->subscription_reference,
                                            'status' => $subscription->status,
                                            'payment_status' => $subscription->payment_status,
                                            'paid_at' => $subscription->paid_at,
                                            'start_date' => $subscription->start_date,
                                            'canCancel' => $canCancel,
                                            'cancelDeadline' => $cancelDeadline,
                                            'now' => now(),
                                        ]);
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-medium font-monospace">{{ $subscription->subscription_reference }}</span>
                                        </td>
                                        <td>{{ $subscription->plan->name ?? 'Unknown Plan' }}</td>
                                        <td>₱{{ number_format($subscription->amount_paid, 2) }}</td>
                                        <td>{{ $subscription->start_date->format('M d, Y') }}</td>
                                        <td>{{ $subscription->end_date->format('M d, Y') }}</td>
                                        <td>
                                            @if($subscription->payment_status == 'paid')
                                                <span class="badge badge-soft-success">Paid</span>
                                            @elseif($subscription->payment_status == 'pending')
                                                <span class="badge badge-soft-warning">Pending</span>
                                            @elseif($subscription->payment_status == 'failed')
                                                <span class="badge badge-soft-danger">Failed</span>
                                            @else
                                                <span class="badge badge-soft-secondary">{{ ucfirst($subscription->payment_status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($subscription->status == 'active')
                                                <span class="badge badge-soft-success">Active</span>
                                            @elseif($subscription->status == 'pending')
                                                <span class="badge badge-soft-warning">Pending</span>
                                            @elseif($subscription->status == 'expired')
                                                <span class="badge badge-soft-secondary">Expired</span>
                                            @elseif($subscription->status == 'cancelled')
                                                <span class="badge badge-soft-danger">Cancelled</span>
                                            @else
                                                <span class="badge badge-soft-secondary">{{ ucfirst($subscription->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- View Details Button -->
                                            <button class="btn btn-sm view-subscription-btn" 
                                                data-id="{{ $subscription->id }}"
                                                data-reference="{{ $subscription->subscription_reference }}"
                                                data-plan="{{ $subscription->plan->name ?? 'Unknown' }}"
                                                data-plan-type="{{ $subscription->plan->plan_type ?? 'N/A' }}"
                                                data-amount="₱{{ number_format($subscription->amount_paid, 2) }}"
                                                data-start="{{ $subscription->start_date->format('M d, Y') }}"
                                                data-end="{{ $subscription->end_date->format('M d, Y') }}"
                                                data-payment-status="{{ $subscription->payment_status }}"
                                                data-payment-status-label="{{ ucfirst($subscription->payment_status) }}"
                                                data-status="{{ $subscription->status }}"
                                                data-status-label="{{ ucfirst($subscription->status) }}"
                                                data-billing-cycle="{{ $subscription->plan->billing_cycle ?? 'N/A' }}"
                                                data-created-at="{{ $subscription->created_at->format('M d, Y') }}"
                                                data-paid-at="{{ $subscription->paid_at ? $subscription->paid_at->format('Y-m-d H:i:s') : '' }}"
                                                data-can-cancel="{{ $canCancel ? 'true' : 'false' }}"
                                                data-cancel-deadline="{{ $cancelDeadline }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewSubscriptionModal">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="ti ti-credit-card-off fs-1 text-muted mb-3 d-block"></i>
                                            <h5>No Subscriptions Found</h5>
                                            <p class="text-muted">You haven't subscribed to any plans yet.</p>
                                            <a href="{{ route('owner.subscription.index') }}" class="btn btn-primary mt-2">
                                                <i class="ti ti-credit-card me-2"></i>Browse Plans
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Showing {{ $subscriptions->count() }} entries</div>
                                <div>
                                    <!-- Pagination can be added here if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- View Subscription Details Modal --}}
    <div class="modal fade" id="viewSubscriptionModal" tabindex="-1" aria-labelledby="viewSubscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="viewSubscriptionModalLabel">
                        Subscription Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <!-- Loading Spinner -->
                    <div class="text-center py-5" id="subscriptionLoadingSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading subscription details...</p>
                    </div>

                    <!-- Subscription Details Content -->
                    <div id="subscriptionDetails" style="display: none;">

                        <!-- Subscription Header -->
                        <div class="row align-items-center mb-4">
                            <div class="col-12 col-lg-8">
                                <div class="d-flex align-items-center flex-column flex-md-row">
                                    <div class="flex-shrink-0 mb-3 mb-md-0">
                                        <div class="bg-light-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="ti ti-crown fs-32 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-md-4 text-center text-md-start">
                                        <h2 class="mb-1 h3" id="viewPlanNameHeader"></h2>
                                        <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2 flex-wrap gap-2">
                                            <span class="badge badge-soft-primary" id="viewPlanTypeBadge"></span>
                                            <span class="badge" id="viewStatusBadge"></span>
                                        </div>
                                        <p class="text-muted mb-0">
                                            <i class="ti ti-receipt me-1"></i>
                                            Reference: <span class="fw-medium font-monospace" id="viewReferenceHeader"></span>
                                            &nbsp;|&nbsp;
                                            <i class="ti ti-calendar me-1"></i>
                                            <span id="viewDatesHeader"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">

                                <!-- SUBSCRIPTION INFORMATION -->
                                <div class="row g-2 mb-4">
                                    <h5 class="card-title text-primary">SUBSCRIPTION INFORMATION</h5>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-receipt fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">Reference Number</label>
                                                <p class="mb-0 fw-medium font-monospace" id="viewReference"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-badge fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">Plan Name</label>
                                                <p class="mb-0 fw-medium" id="viewPlanName"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-layers-subtract fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">Plan Type</label>
                                                <p class="mb-0 fw-medium" id="viewPlanType"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-refresh fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">Billing Cycle</label>
                                                <p class="mb-0 fw-medium" id="viewBillingCycle"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-currency-peso fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">Amount Paid</label>
                                                <p class="mb-0 fw-medium" id="viewAmount"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-calendar-event fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">Start Date</label>
                                                <p class="mb-0 fw-medium" id="viewStartDate"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-calendar-x fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">End Date</label>
                                                <p class="mb-0 fw-medium" id="viewEndDate"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-credit-card fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">Payment Status</label>
                                                <p class="mb-0 fw-medium" id="viewPaymentStatus"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i class="ti ti-shield-check fs-20 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="text-muted small mb-1">Subscription Status</label>
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    <span class="badge" id="viewStatus"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12" id="cancellationDeadlineInfo" style="display: none;">
                                        <div class="alert alert-warning mb-0">
                                            <i class="ti ti-alert-triangle me-2"></i>
                                            <strong>Cancellation Deadline:</strong> You can cancel this subscription until <span id="cancelDeadlineDate"></span>.
                                            After this date, cancellation will no longer be allowed.
                                        </div>
                                    </div>

                                    <div class="col-12" id="cancellationExpiredInfo" style="display: none;">
                                        <div class="alert alert-danger mb-0">
                                            <i class="ti ti-alert-circle me-2"></i>
                                            <strong>Cancellation Period Expired:</strong> The 3-day cancellation period for this subscription has ended. You can no longer cancel this subscription.
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="showCancelModalBtn" style="display: none;">
                                <i class="ti ti-x me-2"></i>Cancel Subscription
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cancel Subscription Confirmation Modal --}}
    <div class="modal fade" id="cancelSubscriptionModal" tabindex="-1" aria-labelledby="cancelSubscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold text-danger" id="cancelSubscriptionModalLabel">
                        <i class="ti ti-alert-triangle me-2"></i>Cancel Subscription
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Important:</strong> Cancelling your subscription will take effect immediately. 
                        You will lose access to premium features and your subscription benefits.
                    </div>

                    <div class="mb-3 p-3 bg-light rounded">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted d-block">Plan Name</small>
                                <span class="fw-semibold" id="cancelModalPlanName">-</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Reference</small>
                                <span class="fw-semibold font-monospace" id="cancelModalReference">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cancellationReason" class="form-label fw-semibold">Reason for cancellation <span class="text-muted">(optional)</span></label>
                        <textarea class="form-control" id="cancellationReason" rows="4" placeholder="Please let us know why you're cancelling..."></textarea>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmCancellation">
                        <label class="form-check-label" for="confirmCancellation">
                            I understand that cancelling will immediately end my subscription benefits and I will not be refunded for the remaining period.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Go Back</button>
                    <button type="button" class="btn btn-danger" id="confirmCancelBtn" disabled>
                        <span class="spinner-border spinner-border-sm d-none" id="cancelSpinner" role="status"></span>
                        <span id="cancelBtnText">Yes, Cancel Subscription</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            let selectedSubscriptionId = null;
            let selectedSubscriptionReference = null;

            // Search functionality
            $('#searchInput').on('keyup', function() {
                let searchText = $(this).val().toLowerCase();
                
                $('#subscriptionTableBody tr').each(function() {
                    let rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // Filter by status
            $('#statusFilter').on('change', function() {
                let filterStatus = $(this).val().toLowerCase();
                
                $('#subscriptionTableBody tr').each(function() {
                    let statusCell = $(this).find('td:eq(6)').text().toLowerCase().trim();
                    
                    if (filterStatus === '' || statusCell.indexOf(filterStatus) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // ===== VIEW SUBSCRIPTION DETAILS =====
            $(document).on('click', '.view-subscription-btn', function() {
                // Show loading, hide details
                $('#subscriptionLoadingSpinner').show();
                $('#subscriptionDetails').hide();

                // Get data from button attributes
                selectedSubscriptionId = $(this).data('id');
                selectedSubscriptionReference = $(this).data('reference');
                let planName = $(this).data('plan');
                let planType = $(this).data('plan-type');
                let amount = $(this).data('amount');
                let startDate = $(this).data('start');
                let endDate = $(this).data('end');
                let paymentStatus = $(this).data('payment-status');
                let paymentStatusLabel = $(this).data('payment-status-label');
                let status = $(this).data('status');
                let statusLabel = $(this).data('status-label');
                let billingCycle = $(this).data('billing-cycle');
                let createdAt = $(this).data('created-at');
                let canCancel = $(this).data('can-cancel');
                let cancelDeadline = $(this).data('cancel-deadline');
                let startDateValue = $(this).data('start-date');
                let paidAt = $(this).data('paid-at');

                // Debug logging
                console.log('=== SUBSCRIPTION DEBUG ===');
                console.log('ID:', selectedSubscriptionId);
                console.log('Reference:', selectedSubscriptionReference);
                console.log('Status:', status);
                console.log('Payment Status:', paymentStatus);
                console.log('Paid At:', paidAt);
                console.log('Can Cancel (raw):', canCancel);
                console.log('Can Cancel (type):', typeof canCancel);
                console.log('Can Cancel (boolean):', canCancel === 'true' || canCancel === true);
                console.log('Cancel Deadline:', cancelDeadline);
                
                // Convert to boolean properly
                canCancel = canCancel === 'true' || canCancel === true;

                // Calculate days since subscription started
                let today = new Date();
                let start = paidAt ? new Date(paidAt) : new Date(startDateValue);
                let daysSinceStart = Math.floor((today - start) / (1000 * 60 * 60 * 24));
                
                console.log('Days since subscription started:', daysSinceStart); // For debugging

                // Simulate loading (remove in production)
                setTimeout(function() {
                    // Set header data
                    $('#viewPlanNameHeader').text(planName);
                    $('#viewPlanTypeBadge').text(planType.charAt(0).toUpperCase() + planType.slice(1));
                    $('#viewReferenceHeader').text(selectedSubscriptionReference);
                    $('#viewDatesHeader').text(startDate + ' – ' + endDate);

                    // Set status badge
                    let statusBadgeClass = '';
                    let statusText = '';
                    
                    if (status === 'active') {
                        statusBadgeClass = 'bg-success';
                        statusText = 'Active';
                    } else if (status === 'pending') {
                        statusBadgeClass = 'badge-soft-warning';
                        statusText = 'Pending';
                    } else if (status === 'expired') {
                        statusBadgeClass = 'badge-soft-secondary';
                        statusText = 'Expired';
                    } else if (status === 'cancelled') {
                        statusBadgeClass = 'badge-soft-danger';
                        statusText = 'Cancelled';
                    } else {
                        statusBadgeClass = 'badge-soft-secondary';
                        statusText = statusLabel;
                    }
                    
                    $('#viewStatusBadge').attr('class', 'badge ' + statusBadgeClass).text(statusText);

                    // Set subscription information
                    $('#viewReference').text(selectedSubscriptionReference);
                    $('#viewPlanName').text(planName);
                    $('#viewPlanType').text(planType);
                    $('#viewBillingCycle').text(billingCycle);
                    $('#viewAmount').text(amount);
                    $('#viewStartDate').text(startDate);
                    $('#viewEndDate').text(endDate);

                    // Set payment status with appropriate color
                    let paymentStatusColor = '';
                    if (paymentStatus === 'paid') {
                        paymentStatusColor = 'text-success';
                    } else if (paymentStatus === 'pending') {
                        paymentStatusColor = 'text-warning';
                    } else if (paymentStatus === 'failed') {
                        paymentStatusColor = 'text-danger';
                    } else {
                        paymentStatusColor = 'text-muted';
                    }
                    $('#viewPaymentStatus').attr('class', 'mb-0 fw-medium ' + paymentStatusColor).text(paymentStatusLabel);

                    // Set status
                    $('#viewStatus').attr('class', 'badge ' + statusBadgeClass).text(statusText);

                    // Handle cancellation options
                    console.log('=== CANCELLATION LOGIC ===');
                    console.log('Can Cancel:', canCancel);
                    console.log('Status:', status);
                    console.log('Payment Status:', paymentStatus);
                    console.log('Days Since Start:', daysSinceStart);
                    
                    if (canCancel) {
                        console.log('✅ SHOWING CANCEL BUTTON');
                        console.log('Cancel Deadline:', cancelDeadline);
                        $('#cancellationDeadlineInfo').show();
                        $('#cancellationExpiredInfo').hide();
                        $('#cancelDeadlineDate').text(cancelDeadline);
                        $('#showCancelModalBtn').show();
                    } else {
                        console.log('❌ HIDING CANCEL BUTTON');
                        $('#cancellationDeadlineInfo').hide();
                        
                        // Check if subscription is active but cancellation period expired
                        if (status === 'active' && paymentStatus === 'paid' && daysSinceStart > 3) {
                            console.log('📅 Showing expired message');
                            $('#cancellationExpiredInfo').show();
                            $('#cancellationExpiredInfo .alert').html(`
                                <i class="ti ti-alert-circle me-2"></i>
                                <strong>Cancellation Period Expired:</strong> The 3-day cancellation period for this subscription ended on ${cancelDeadline}. 
                                You can no longer cancel this subscription.
                            `);
                        } else {
                            console.log('ℹ️ Not showing any cancellation message');
                            $('#cancellationExpiredInfo').hide();
                        }
                        
                        $('#showCancelModalBtn').hide();
                    }

                    // Hide loading, show details
                    $('#subscriptionLoadingSpinner').hide();
                    $('#subscriptionDetails').show();
                }, 500); // Simulate loading for demo - remove in production
            });

            // ===== SHOW CANCEL MODAL =====
            $('#showCancelModalBtn').on('click', function() {
                // Reset modal
                $('#cancellationReason').val('');
                $('#confirmCancellation').prop('checked', false);
                $('#confirmCancelBtn').prop('disabled', true);
                
                // Show cancel modal
                $('#viewSubscriptionModal').modal('hide');
                setTimeout(function() {
                    $('#cancelSubscriptionModal').modal('show');
                }, 300);
            });

            // ===== ENABLE/DISABLE CONFIRM BUTTON BASED ON CHECKBOX =====
            $('#confirmCancellation').on('change', function() {
                $('#confirmCancelBtn').prop('disabled', !$(this).is(':checked'));
            });

            // ===== CONFIRM CANCELLATION =====
            $('#confirmCancelBtn').on('click', function() {
                if (!selectedSubscriptionId) return;

                // Show loading
                $(this).prop('disabled', true);
                $('#cancelSpinner').removeClass('d-none');
                $('#cancelBtnText').text('Cancelling...');

                $.ajax({
                    url: '{{ route("owner.subscription.cancel", ["id" => "PLACEHOLDER"]) }}'.replace('PLACEHOLDER', selectedSubscriptionId),
                    type: 'POST',
                    data: {
                        reason: $('#cancellationReason').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#cancelSubscriptionModal').modal('hide');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred. Please try again.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonColor: '#3475db'
                        });
                    },
                    complete: function() {
                        // Reset button
                        $('#confirmCancelBtn').prop('disabled', false);
                        $('#cancelSpinner').addClass('d-none');
                        $('#cancelBtnText').text('Yes, Cancel Subscription');
                    }
                });
            });

            // Reset modals on close
            $('#viewSubscriptionModal').on('hidden.bs.modal', function() {
                $('#subscriptionDetails').hide();
                $('#subscriptionLoadingSpinner').show();
            });

            $('#cancelSubscriptionModal').on('hidden.bs.modal', function() {
                $('#cancellationReason').val('');
                $('#confirmCancellation').prop('checked', false);
                $('#confirmCancelBtn').prop('disabled', true);
            });
        });
    </script>
@endsection