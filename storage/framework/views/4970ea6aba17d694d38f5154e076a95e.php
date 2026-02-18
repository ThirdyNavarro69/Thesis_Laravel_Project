
<?php $__env->startSection('title', 'View Packages'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    
                    <div data-table data-table-rows-per-page="10" class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">List of Packages</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search services...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold">
                                    <i class="ti ti-filter me-1"></i>Filter By:
                                </span>
                                <div class="app-filter">
                                    <select data-table-filter="status" class="me-0 form-select form-control">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort>Studio</th>
                                        <th data-table-sort>Category</th>
                                        <th data-table-sort>Package Name</th>
                                        <th data-table-sort>Price</th>
                                        <th data-table-sort>Online Gallery</th>
                                        <th data-table-sort>Photographers</th>
                                        <th data-table-sort>Duration</th>
                                        <th data-table-sort>Max Photos</th>
                                        <th data-table-sort data-column="status">Status</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($package->studio->studio_name ?? 'N/A'); ?></td>
                                            <td><?php echo e($package->category->category_name ?? 'N/A'); ?></td>
                                            <td><?php echo e($package->package_name); ?></td>
                                            <td>PHP <?php echo e(number_format($package->package_price, 2)); ?></td>
                                            <td>
                                                <?php if($package->online_gallery): ?>
                                                    <span class="badge badge-soft-success fs-8 px-1 w-100">
                                                        <i class="ti ti-check me-1"></i> Yes
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-soft-secondary fs-8 px-1 w-100">
                                                        <i class="ti ti-x me-1"></i> No
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-semibold"><?php echo e($package->photographer_count ?? 0); ?></span>
                                                <small class="text-muted d-block">photographer(s)</small>
                                            </td>
                                            <td><?php echo e($package->duration); ?> hours</td>
                                            <td><?php echo e($package->maximum_edited_photos); ?></td>
                                            <td>
                                                <?php if($package->status == 'active'): ?>
                                                    <span class="badge badge-soft-success fs-8 px-1 w-100">ACTIVE</span>
                                                <?php else: ?>
                                                    <span class="badge badge-soft-danger fs-8 px-1 w-100">INACTIVE</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm">
                                                        <i class="ti ti-edit fs-lg"></i>
                                                    </button>
                                                    <button class="btn btn-sm">
                                                        <i class="ti ti-trash fs-lg"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div data-table-pagination-info="packages"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.owner.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/owner/view-packages.blade.php ENDPATH**/ ?>