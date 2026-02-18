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
            <li class="side-nav-title mt-2" data-lang="apps-title">Studio Photographer Panel</li>

            
            <?php
                $isDashboardActive = Route::is('studio-photographer.dashboard');
            ?>
            
            <li class="side-nav-item <?php echo e($isDashboardActive ? 'active' : ''); ?>">
                <a href="<?php echo e(route('studio-photographer.dashboard')); ?>" class="side-nav-link <?php echo e($isDashboardActive ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-layout-dashboard"></i></span>
                    <span class="menu-text" data-lang="dashboard">Dashboard</span>
                </a>
            </li>

            
            <?php
                $assignedStudioRoutes   = Route::is('studio-photographer.studio.index');
            ?>
            
            <li class="side-nav-item <?php echo e($assignedStudioRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageAssignedStudio" aria-expanded="<?php echo e($assignedStudioRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageAssignedStudio" class="side-nav-link <?php echo e($assignedStudioRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-aperture"></i></span>
                    <span class="menu-text" data-lang="assigned-studio">Studio</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($assignedStudioRoutes ? 'show' : ''); ?>" id="sidebarManageAssignedStudio">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('studio-photographer.studio.index')); ?>" class="side-nav-link <?php echo e($assignedStudioRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="assigned-studio">Assigned Studios</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $assignedBookingRoutes = Route::is('assigned.bookings');
            ?>

            <li class="side-nav-item <?php echo e($assignedBookingRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarManageAssignedBooking" aria-expanded="<?php echo e($assignedBookingRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarManageAssignedBooking" class="side-nav-link <?php echo e($assignedBookingRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-calendar-check"></i></span>
                    <span class="menu-text" data-lang="assigned-booking">Booking</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($assignedBookingRoutes ? 'show' : ''); ?>" id="sidebarManageAssignedBooking">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('assigned.bookings')); ?>" class="side-nav-link <?php echo e($assignedBookingRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="assigned-booking">Assigned Booking</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageOnlineGalleryRoutes = Route::is('studio-photographer.online-gallery.index');
            ?>

            <li class="side-nav-item <?php echo e($manageOnlineGalleryRoutes ? 'active' : ''); ?>">
                <a href="<?php echo e(route('studio-photographer.online-gallery.index')); ?>" class="side-nav-link <?php echo e($manageOnlineGalleryRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-photo"></i></span>
                    <span class="menu-text" data-lang="online-gallery">Online Gallery</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proj\resources\views/layouts/studio-photographer/sidebar.blade.php ENDPATH**/ ?>