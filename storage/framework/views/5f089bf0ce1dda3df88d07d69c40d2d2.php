
<?php $__env->startSection('title', 'Payment Successful'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <div class="avatar avatar-lg bg-soft-success rounded-circle mx-auto mb-3">
                                    <i class="ti ti-circle-check fs-2 text-success"></i>
                                </div>
                                <h3 class="text-success mb-3">Payment Successful!</h3>
                                <p class="text-muted mb-0">Your booking has been confirmed</p>
                            </div>
                            
                            <?php if(isset($booking) && $booking): ?>
                            <div class="card border mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Booking Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Booking Reference:</p>
                                            <p class="fw-medium mb-3"><?php echo e($booking->booking_reference); ?></p>
                                        </div>
                                        <?php if(isset($payment) && $payment): ?>
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Amount Paid:</p>
                                            <p class="fw-medium mb-3">₱<?php echo e(number_format($payment->amount, 2)); ?></p>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Event Date:</p>
                                            <p class="fw-medium mb-3">
                                                <?php if($booking->event_date): ?>
                                                    <?php echo e(\Carbon\Carbon::parse($booking->event_date)->format('F d, Y')); ?>

                                                <?php else: ?>
                                                    Not specified
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <?php if(isset($payment) && $payment): ?>
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Payment Method:</p>
                                            <p class="fw-medium mb-3"><?php echo e(ucfirst(str_replace('_', ' ', $payment->payment_method))); ?></p>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Payment Type:</p>
                                            <p class="fw-medium mb-3">
                                                <?php if($booking->payment_type === 'downpayment'): ?>
                                                    30% Downpayment
                                                <?php else: ?>
                                                    Full Payment
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Payment Status:</p>
                                            <p class="fw-medium mb-3">
                                                <?php if($booking->payment_status === 'partially_paid'): ?>
                                                    <span class="p-1 badge badge-soft-warning">Partially Paid (Downpayment)</span>
                                                <?php elseif($booking->payment_status === 'paid'): ?>
                                                    <span class="p-1 badge badge-soft-success">Fully Paid</span>
                                                <?php else: ?>
                                                    <span class="p-1 badge badge-soft-secondary"><?php echo e(ucfirst($booking->payment_status)); ?></span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="alert alert-info">
                                <i class="ti ti-mail me-2"></i>
                                A confirmation email has been sent to your registered email address.
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-center mt-4">
                                <a href="<?php echo e(route('client.dashboard')); ?>" class="btn btn-primary">
                                    <i class="ti ti-home me-2"></i> Back to Dashboard
                                </a>
                                <button class="btn btn-outline-primary" onclick="window.print()">
                                    <i class="ti ti-printer me-2"></i> Print Receipt
                                </button>
                            </div>
                            
                            <div class="mt-3">
                                <p class="text-muted small">
                                    Need assistance? <a href="mailto:support@snapstudio.com" class="text-primary">Contact Support</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/client/payment-success.blade.php ENDPATH**/ ?>