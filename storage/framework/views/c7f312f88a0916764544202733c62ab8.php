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
            <li class="side-nav-title mt-2" data-lang="apps-title">Studio Owner Panel</li>

            
            <?php
                $isDashboardActive = Route::is('owner.dashboard');
            ?>
            
            <li class="side-nav-item <?php echo e($isDashboardActive ? 'active' : ''); ?>">
                <a href="<?php echo e(route('owner.dashboard')); ?>" class="side-nav-link <?php echo e($isDashboardActive ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-layout-dashboard"></i></span>
                    <span class="menu-text" data-lang="dashboard">Dashboard</span>
                </a>
            </li>

            
            <?php
                $manageStudiosRoutes   = Route::is('owner.studio.index');
                $pendingStudiosRoutes  = Route::is('owner.studio.create');
            ?>
            
            <li class="side-nav-item <?php echo e($manageStudiosRoutes || $pendingStudiosRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageStudios" aria-expanded="<?php echo e($manageStudiosRoutes || $pendingStudiosRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageStudios" class="side-nav-link <?php echo e($manageStudiosRoutes || $pendingStudiosRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-aperture"></i></span>
                    <span class="menu-text" data-lang="manage-studios">Studios</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageStudiosRoutes || $pendingStudiosRoutes ? 'show' : ''); ?>" id="sidebarManageStudios">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.studio.index')); ?>" class="side-nav-link <?php echo e($manageStudiosRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="studios">View Studios</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.studio.create')); ?>" class="side-nav-link <?php echo e($pendingStudiosRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="create-studio">Create Studio</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageBookingsRoutes   = Route::is('owner.booking.index');
                $pendingBookingsRoutes  = Route::is('owner.booking.create');
            ?>
            
            <li class="side-nav-item <?php echo e($manageBookingsRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageBookings" aria-expanded="<?php echo e($manageBookingsRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageBookings" class="side-nav-link <?php echo e($manageBookingsRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-notebook"></i></span>
                    <span class="menu-text" data-lang="manage-bookings">Bookings</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageBookingsRoutes ? 'show' : ''); ?>" id="sidebarManageBookings">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.booking.index')); ?>" class="side-nav-link <?php echo e($manageBookingsRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="bookings">View Bookings</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.booking.history')); ?>" class="side-nav-link">
                                <span class="menu-text" data-lang="booking-history">Booking History</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageOnlineGalleryRoutes = Route::is('owner.online-gallery.index');
            ?>
            
            <li class="side-nav-item <?php echo e($manageOnlineGalleryRoutes ? 'active' : ''); ?>">
                <a href="<?php echo e(route('owner.online-gallery.index')); ?>" class="side-nav-link <?php echo e($manageOnlineGalleryRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-photo"></i></span>
                    <span class="menu-text" data-lang="online-gallery">Online Gallery</span>
                </a>
            </li>

            
            <?php
                $manageSchedulesRoutes  = Route::is('owner.studio-schedule.index');
                $setupSchedulesRoutes   = Route::is('owner.setup-studio-schedules');
            ?>
            
            <li class="side-nav-item <?php echo e($manageSchedulesRoutes || $setupSchedulesRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageSchedules" aria-expanded="<?php echo e($manageSchedulesRoutes || $setupSchedulesRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageSchedules" class="side-nav-link <?php echo e($manageSchedulesRoutes || $setupSchedulesRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-calendar-check"></i></span>
                    <span class="menu-text" data-lang="manage-schedules">Schedules</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageSchedulesRoutes || $setupSchedulesRoutes ? 'show' : ''); ?>" id="sidebarManageSchedules">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.studio-schedule.index')); ?>" class="side-nav-link <?php echo e($manageSchedulesRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="schedules">View Schedules</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.setup-studio-schedules')); ?>" class="side-nav-link <?php echo e($setupSchedulesRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="setup-schedule">Setup Studio Schedule</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageMembersRoutes   = Route::is('owner.members.index');
            ?>
            
            <li class="side-nav-item <?php echo e($manageMembersRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageMembers" aria-expanded="<?php echo e($manageMembersRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageMembers" class="side-nav-link <?php echo e($manageMembersRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-user-star"></i></span>
                    <span class="menu-text" data-lang="manage-members">Members</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageMembersRoutes ? 'show' : ''); ?>" id="sidebarManageMembers">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.members.index')); ?>" class="side-nav-link <?php echo e($manageMembersRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="members">View Members</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.members.invite')); ?>" class="side-nav-link">
                                <span class="menu-text" data-lang="invite-members">Invite New Members</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.members.apply')); ?>" class="side-nav-link">
                                <span class="menu-text" data-lang="apply-members">Members Application</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageStudioPhotographersRoutes = Route::is('owner.studio-photographers.index');
            ?>

            <li class="side-nav-item <?php echo e($manageStudioPhotographersRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageStudioPhotographers" aria-expanded="<?php echo e($manageStudioPhotographersRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageStudioPhotographers" class="side-nav-link <?php echo e($manageStudioPhotographersRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-user-circle"></i></span>
                    <span class="menu-text" data-lang="manage-studio-photographers">Photographers</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageStudioPhotographersRoutes ? 'show' : ''); ?>" id="sidebarManageStudioPhotographers">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.studio-photographers.index')); ?>" class="side-nav-link <?php echo e($manageStudioPhotographersRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="studio-photographers">Studio Photographers</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.studio-photographers.create')); ?>" class="side-nav-link">
                                <span class="menu-text" data-lang="add-photographer">Add Photographer</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $managePackagesRoutes = Route::is('owner.packages.index');
                $createPackagesRoutes = Route::is('owner.packages.create');
                $listPackagesRoutes   = Route::is('owner.packages.list');
            ?>

            <li class="side-nav-item <?php echo e($managePackagesRoutes || $createPackagesRoutes || $listPackagesRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManagePackages" aria-expanded="<?php echo e($managePackagesRoutes || $createPackagesRoutes || $listPackagesRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManagePackages" class="side-nav-link <?php echo e($managePackagesRoutes || $createPackagesRoutes || $listPackagesRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-package"></i></span>
                    <span class="menu-text" data-lang="manage-packages">Packages</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($managePackagesRoutes || $createPackagesRoutes || $listPackagesRoutes ? 'show' : ''); ?>" id="sidebarManagePackages">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.packages.index')); ?>" class="side-nav-link <?php echo e($managePackagesRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="packages">View Packages</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.packages.create')); ?>" class="side-nav-link <?php echo e($createPackagesRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="create-package">Create Package</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.packages.list')); ?>" class="side-nav-link <?php echo e($listPackagesRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="list-packages">List Packages</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageCategoryServicesRoutes   = Route::is('owner.services.index');
                $createCategoryServicesRoutes  = Route::is('owner.services.create');
            ?>
            
            <li class="side-nav-item <?php echo e($manageCategoryServicesRoutes || $createCategoryServicesRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageCategoryServices" aria-expanded="<?php echo e($manageCategoryServicesRoutes || $createCategoryServicesRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageCategoryServices" class="side-nav-link <?php echo e($manageCategoryServicesRoutes || $createCategoryServicesRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-list-tree"></i></span>
                    <span class="menu-text" data-lang="manage-category-services">Services</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($manageCategoryServicesRoutes || $createCategoryServicesRoutes ? 'show' : ''); ?>" id="sidebarManageCategoryServices">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.services.index')); ?>" class="side-nav-link <?php echo e($manageCategoryServicesRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="category-services">View Services</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('owner.services.create')); ?>" class="side-nav-link <?php echo e($createCategoryServicesRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="create-category-service">Create Service</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proj\resources\views/layouts/owner/sidebar.blade.php ENDPATH**/ ?>