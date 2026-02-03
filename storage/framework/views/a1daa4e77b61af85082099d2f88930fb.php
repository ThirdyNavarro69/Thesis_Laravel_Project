
<?php $__env->startSection('title', 'View Services'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-title">
                            <h4 class="card-title">List of Services</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="card h-100 my-4 my-lg-0">
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1">Starter Plan</h3>
                                            <p class="text-muted mb-0">Best for freelancers and personal use</p>

                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">$9</h1>
                                                <small class="d-block text-muted fs-base">Billed monthly</small>
                                                <small class="d-block text-muted">1 project included</small>
                                            </div>

                                            <ul class="list-unstyled text-start fs-sm mb-0">
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> 1 active project</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Access to all components</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Email support</li>
                                                <li class="mb-2"><i class="ti ti-x text-danger me-2"></i> No team collaboration</li>
                                                <li class="mb-2"><i class="ti ti-x text-danger me-2"></i> No SaaS rights</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer bg-transparent px-5 pb-4">
                                            <a href="#!" class="btn btn-outline-primary w-100 py-2 fw-semibold rounded-pill">Choose Starter</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-bg-primary h-100 my-4 my-lg-0">
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1">Professional</h3>
                                            <p class="text-white-50 mb-0">Ideal for small teams and startups</p>

                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">$29</h1>
                                                <small class="d-block text-white-50 fs-base">Billed monthly</small>
                                                <small class="d-block text-white-50">Up to 5 projects</small>
                                            </div>

                                            <ul class="list-unstyled text-start fs-sm mb-0">
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> 5 active projects</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Component + plugin access</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Team collaboration</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Priority email support</li>
                                                <li class="mb-2"><i class="ti ti-x text-danger me-2"></i> No resale rights</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer bg-transparent px-5 pb-4">
                                            <a href="#!" class="btn btn-light w-100 py-2 fw-semibold rounded-pill">Choose Professional</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card h-100 my-4 my-lg-0">
                                        <div class="card-body p-lg-4 pb-0 text-center">
                                            <h3 class="fw-bold mb-1">Business</h3>
                                            <p class="text-muted mb-0">For agencies and large teams</p>

                                            <div class="my-4">
                                                <h1 class="display-6 fw-bold mb-0">$79</h1>
                                                <small class="d-block text-muted fs-base">Billed monthly</small>
                                                <small class="d-block text-muted">Unlimited projects</small>
                                            </div>

                                            <ul class="list-unstyled text-start fs-sm mb-0">
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Unlimited projects</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> SaaS &amp; client projects allowed</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> All premium components</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Priority support</li>
                                                <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Team management tools</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer bg-transparent px-5 pb-4">
                                            <a href="#!" class="btn btn-dark w-100 py-2 fw-semibold rounded-pill">Choose Business</a>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.owner.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/owner/services-cards.blade.php ENDPATH**/ ?>