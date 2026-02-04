<div class="sidenav-menu">
    
    <a href="index.html" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="logo"></span>
            <span class="logo-sm"><img src="<?php echo e(asset('assets/images/logo-sm.png')); ?>" alt="small logo"></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img src="<?php echo e(asset('assets/images/logo-black.png')); ?>" alt="dark logo"></span>
            <span class="logo-sm"><img src="<?php echo e(asset('assets/images/logo-sm.png')); ?>" alt="small logo"></span>
        </span>
    </a>

    
    <button class="button-on-hover">
        <i class="ti ti-menu-4 fs-22 align-middle"></i>
    </button>

    
    <button class="button-close-offcanvas">
        <i class="ti ti-x align-middle"></i>
    </button>

    
    <div class="scrollbar" data-simplebar>
        <ul class="side-nav">
            <li class="side-nav-title mt-2" data-lang="apps-title">Admin Panel</li>

            
            <?php
                $isDashboardActive = Route::is('admin.dashboard');
            ?>
            
            <li class="side-nav-item <?php echo e($isDashboardActive ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="side-nav-link <?php echo e($isDashboardActive ? 'active' : ''); ?>">
                    <span class="menu-icon"><i data-lucide="layout-dashboard"></i></span>
                    <span class="menu-text" data-lang="dashboard">Dashboard</span>
                </a>
            </li>

            
            <?php
                $manageUsersRoutes  = Route::is('admin.user.index');
            ?>
            
            <li class="side-nav-item <?php echo e($manageUsersRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageUsers" aria-expanded="<?php echo e($manageUsersRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageUsers" class="side-nav-link <?php echo e($manageUsersRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i data-lucide="users"></i></span>
                    <span class="menu-text" data-lang="manage-users">Users</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageUsersRoutes ? 'show' : ''); ?>" id="sidebarManageUsers">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('admin.user.index')); ?>" class="side-nav-link <?php echo e($manageUsersRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="users">View Users</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageStudiosRoutes   = Route::is('admin.studio.index');
                $pendingStudiosRoutes  = Route::is('admin.studio.pending');
            ?>
            
            <li class="side-nav-item <?php echo e($manageStudiosRoutes || $pendingStudiosRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageStudios" aria-expanded="<?php echo e($manageStudiosRoutes || $pendingStudiosRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageStudios" class="side-nav-link <?php echo e($manageStudiosRoutes || $pendingStudiosRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i data-lucide="clapperboard"></i></span>
                    <span class="menu-text" data-lang="manage-studios">Studios</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageStudiosRoutes || $pendingStudiosRoutes ? 'show' : ''); ?>" id="sidebarManageStudios">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('admin.studio.index')); ?>" class="side-nav-link <?php echo e($manageStudiosRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="studios">View Studios</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('admin.studio.pending')); ?>" class="side-nav-link <?php echo e($pendingStudiosRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="pending-studio-registration">Pending Studios</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $viewFreelancerRoutes    = Route::is('admin.freelancer.index');
            ?>
            
            <li class="side-nav-item <?php echo e($viewFreelancerRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageFreelancer" aria-expanded="<?php echo e($viewFreelancerRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageFreelancer" class="side-nav-link <?php echo e($viewFreelancerRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i data-lucide="file-user"></i></span>
                    <span class="menu-text" data-lang="manage-freelancer">Freelancer</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($viewFreelancerRoutes ? 'show' : ''); ?>" id="sidebarManageFreelancer">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('admin.freelancer.index')); ?>" class="side-nav-link <?php echo e($viewFreelancerRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="freelancer">View Freelancer</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageCategoriesRoutes  = Route::is('admin.categories.index');
                $createCategoryRoutes    = Route::is('admin.categories.create');
            ?>
            
            <li class="side-nav-item <?php echo e($manageCategoriesRoutes || $createCategoryRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageCategories" aria-expanded="<?php echo e($manageCategoriesRoutes || $createCategoryRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageCategories" class="side-nav-link <?php echo e($manageCategoriesRoutes || $createCategoryRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i data-lucide="layout-list"></i></span>
                    <span class="menu-text" data-lang="manage-categories">Categories</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageCategoriesRoutes || $createCategoryRoutes ? 'show' : ''); ?>" id="sidebarManageCategories">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="side-nav-link <?php echo e($manageCategoriesRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="categories">View Categories</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('admin.categories.create')); ?>" class="side-nav-link <?php echo e($createCategoryRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="create-category">Create Category</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $viewLocationRoutes    = Route::is('admin.location.index');
                $createLocationRoutes  = Route::is('admin.location.create');
            ?>
            
            <li class="side-nav-item <?php echo e($viewLocationRoutes || $createLocationRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageLocations" aria-expanded="<?php echo e($viewLocationRoutes || $createLocationRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageLocations" class="side-nav-link <?php echo e($viewLocationRoutes || $createLocationRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i data-lucide="map-pinned"></i></span>
                    <span class="menu-text" data-lang="manage-locations">Locations</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($viewLocationRoutes || $createLocationRoutes ? 'show' : ''); ?>" id="sidebarManageLocations">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('admin.location.index')); ?>" class="side-nav-link <?php echo e($viewLocationRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="locations">View Locations</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('admin.location.create')); ?>" class="side-nav-link <?php echo e($createLocationRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="create-location">Create Location</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proj\resources\views/layouts/admin/sidebar.blade.php ENDPATH**/ ?>