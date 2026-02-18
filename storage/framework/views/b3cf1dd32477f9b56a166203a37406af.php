
<?php $__env->startSection('title', 'Studio Owner Dashboard'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">              
            <div class="page-title-head d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="fs-xl fw-bold m-0">Dashboard</h4>
                    <?php if($studio): ?>
                        <p class="text-muted mt-1"><?php echo e($studio->studio_name); ?></p>
                    <?php endif; ?>
                </div>
            </div>          

            <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">
                <!-- Total Earnings Card -->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar fs-60 avatar-img-size flex-shrink-0 me-3">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                                        <i class="ti ti-credit-card"></i>
                                    </span>
                                </div>
                                <div class="text-start">
                                    <h3 class="mb-2 fw-normal">₱<span data-target="<?php echo e($totalEarnings); ?>"><?php echo e(number_format($totalEarnings, 2)); ?></span></h3>
                                    <p class="mb-0 text-muted"><span>Total Earnings</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Bookings Card -->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar fs-60 avatar-img-size flex-shrink-0 me-3">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-24">
                                        <i class="ti ti-calendar-time"></i>
                                    </span>
                                </div>
                                <div class="text-start">
                                    <h3 class="mb-2 fw-normal"><span data-target="<?php echo e($totalBookings); ?>"><?php echo e($totalBookings); ?></span></h3>
                                    <p class="mb-0 text-muted"><span>Active Bookings</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Bookings Card -->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar fs-60 avatar-img-size flex-shrink-0 me-3">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-24">
                                        <i class="ti ti-checklist"></i>
                                    </span>
                                </div>
                                <div class="text-start">
                                    <h3 class="mb-2 fw-normal"><span data-target="<?php echo e($completedBookings); ?>"><?php echo e($completedBookings); ?></span></h3>
                                    <p class="mb-0 text-muted"><span>Completed Bookings</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Studio Photographers Card -->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar fs-60 avatar-img-size flex-shrink-0 me-3">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-24">
                                        <i class="ti ti-users"></i>
                                    </span>
                                </div>
                                <div class="text-start">
                                    <h3 class="mb-2 fw-normal"><span data-target="<?php echo e($totalPhotographers); ?>"><?php echo e($totalPhotographers); ?></span></h3>
                                    <p class="mb-0 text-muted"><span>Studio Photographers</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Initialize counter animation for statistics
            $('[data-target]').each(function() {
                var $this = $(this);
                var target = parseFloat($this.data('target'));
                
                // Skip animation if target is 0
                if (target === 0) {
                    return;
                }

                // For earnings, handle decimal values
                if ($this.parent().is('h3') && $this.parent().text().includes('₱')) {
                    $this.prop('Counter', 0).animate({
                        Counter: target
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function(now) {
                            $this.text(number_format(now, 2));
                        }
                    });
                } else {
                    // For integer values
                    $this.prop('Counter', 0).animate({
                        Counter: target
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function(now) {
                            $this.text(Math.ceil(now));
                        }
                    });
                }
            });
        });

        // Helper function to format numbers
        function number_format(number, decimals) {
            return parseFloat(number).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.owner.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/owner/dashboard.blade.php ENDPATH**/ ?>