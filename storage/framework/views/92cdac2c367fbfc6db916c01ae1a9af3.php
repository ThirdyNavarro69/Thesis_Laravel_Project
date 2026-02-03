
<?php $__env->startSection('title', 'View Packages'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-title d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Package Lists</h4>
                            <div>
                                <a href="<?php echo e(route('freelancer.packages.create')); ?>" class="btn btn-primary btn-sm">
                                    <i class="ti ti-plus me-1"></i> Create New Package
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if($packages->isEmpty()): ?>
                                <div class="text-center py-5">
                                    <i class="ti ti-package-off fs-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">No packages found</h5>
                                    <p class="text-muted mb-4">You haven't created any packages yet.</p>
                                    <a href="<?php echo e(route('freelancer.packages.create')); ?>" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i> Create Your First Package
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="row g-3 mb-4">
                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4">
                                        <div class="card shadow-none border h-100 my-4 my-lg-0">
                                            <div class="card-body p-lg-4 pb-0 text-center">
                                                <h3 class="fw-bold mb-1"><?php echo e($package->package_name); ?></h3>
                                                <p class="text-muted mb-0"><?php echo e($package->category->category_name ?? 'Uncategorized'); ?></p>

                                                <div class="my-4">
                                                    <h1 class="display-6 fw-bold mb-0">PHP <?php echo e(number_format($package->package_price, 2)); ?></h1>
                                                    <small class="d-block text-muted fs-base"><?php echo e($package->duration); ?> Hours</small>
                                                    <small class="d-block text-muted"><?php echo e($package->maximum_edited_photos); ?> Edited Photos</small>
                                                </div>

                                                <ul class="list-unstyled text-start fs-sm mb-0">
                                                    <?php if($package->package_inclusions && is_array($package->package_inclusions)): ?>
                                                        <?php $__currentLoopData = array_slice($package->package_inclusions, 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inclusion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="mb-2">
                                                            <i class="ti ti-check text-success me-2"></i> 
                                                            <?php echo e($inclusion); ?>

                                                        </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                        <?php if(count($package->package_inclusions) > 5): ?>
                                                        <li class="mb-2">
                                                            <i class="ti ti-dots me-2"></i>
                                                            <small class="text-muted">+<?php echo e(count($package->package_inclusions) - 5); ?> more inclusions</small>
                                                        </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    
                                                    <?php if($package->coverage_scope): ?>
                                                    <li class="mb-2">
                                                        <i class="ti ti-map-pin text-primary me-2"></i> 
                                                        <?php echo e($package->coverage_scope); ?>

                                                    </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                            <div class="card-footer bg-transparent px-5 pb-4">
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-outline-primary w-100 py-2 fw-semibold rounded-pill view-details-btn" 
                                                            data-package-id="<?php echo e($package->id); ?>">
                                                        View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
                                <?php if($packages->count() > 3): ?>
                                <div class="text-center mt-4">
                                    <nav aria-label="Package navigation">
                                        <ul class="pagination justify-content-center mb-0">
                                            <!-- Simple pagination display -->
                                            <li class="page-item disabled">
                                                <span class="page-link">Showing <?php echo e($packages->count()); ?> packages</span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.freelancer.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/freelancer/packages-list.blade.php ENDPATH**/ ?>