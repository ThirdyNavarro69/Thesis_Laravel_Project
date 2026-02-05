
<?php $__env->startSection('title', 'View Packages'); ?>


<?php $__env->startSection('content'); ?>
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
                                <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-md-4">
                                    <div class="card shadow-none border h-100 my-4 my-lg-0">
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1"><?php echo e($package->package_name); ?></h3>
                                            <p class="text-muted mb-0"><?php echo e($package->studio->studio_name ?? 'N/A'); ?> - <?php echo e($package->category->category_name ?? 'N/A'); ?></p>

                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">PHP <?php echo e(number_format($package->package_price, 2)); ?></h1>
                                                <small class="d-block text-muted fs-base"><?php echo e($package->duration); ?> Hours</small>
                                                <small class="d-block text-muted"><?php echo e($package->maximum_edited_photos); ?> Edited Photos</small>
                                            </div>

                                            <ul class="list-unstyled text-start fs-sm mb-0">
                                                <?php if($package->package_inclusions && is_array($package->package_inclusions)): ?>
                                                    <?php $__currentLoopData = $package->package_inclusions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inclusion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> <?php echo e($inclusion); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                
                                                <?php if($package->coverage_scope): ?>
                                                    <li class="mb-2"><i class="ti ti-map-pin text-primary me-2"></i> <?php echo e($package->coverage_scope); ?></li>
                                                <?php endif; ?>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12">
                                    <div class="text-center">
                                        <i class="ti ti-package-off fs-1 text-muted"></i>
                                        <h4 class="mt-3">No Packages Created Yet</h4>
                                        <p class="text-muted mb-4">Start by creating your first package</p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.owner.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/owner/packages-list.blade.php ENDPATH**/ ?>