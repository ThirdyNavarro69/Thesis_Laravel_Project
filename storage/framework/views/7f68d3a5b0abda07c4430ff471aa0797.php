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
            <li class="side-nav-title mt-2" data-lang="apps-title">Client Panel</li>

            
            <?php
                $isDashboardActive = Route::is('client.dashboard');
            ?>
            
            <li class="side-nav-item <?php echo e($isDashboardActive ? 'active' : ''); ?>">
                <a href="<?php echo e(route('client.dashboard')); ?>" class="side-nav-link <?php echo e($isDashboardActive ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-layout-dashboard"></i></span>
                    <span class="menu-text" data-lang="dashboard">Dashboard</span>
                </a>
            </li>

            
            <?php
                $myBookingsRoutes = Route::is('client.my-bookings.index');
                $bookingHistoryRoutes = Route::is('client.my-bookings.history');
            ?>
            
            <li class="side-nav-item <?php echo e($myBookingsRoutes || $bookingHistoryRoutes ? 'active' : ''); ?>">
                <a data-bs-toggle="collapse" href="#sidebarMyBookings" aria-expanded="<?php echo e($myBookingsRoutes || $bookingHistoryRoutes ? 'true' : 'false'); ?>" aria-controls="sidebarMyBookings" class="side-nav-link <?php echo e($myBookingsRoutes || $bookingHistoryRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-notebook"></i></span>
                    <span class="menu-text" data-lang="manage-bookings">My Bookings</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo e($myBookingsRoutes || $bookingHistoryRoutes ? 'show' : ''); ?>" id="sidebarMyBookings">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('client.my-bookings.index')); ?>" class="side-nav-link <?php echo e($myBookingsRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="view-bookings">View Bookings</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('client.my-bookings.history')); ?>" class="side-nav-link <?php echo e($bookingHistoryRoutes ? 'active' : ''); ?>">
                                <span class="menu-text" data-lang="booking-history">Booking History</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $manageOnlineGalleryRoutes = Route::is('client.online-gallery.index');
            ?>
            
            <li class="side-nav-item <?php echo e($manageOnlineGalleryRoutes ? 'active' : ''); ?>">
                <a href="<?php echo e(route('client.online-gallery.index')); ?>" class="side-nav-link <?php echo e($manageOnlineGalleryRoutes ? 'active' : ''); ?>">
                    <span class="menu-icon"><i class="ti ti-photo"></i></span>
                    <span class="menu-text" data-lang="online-gallery">Online Gallery</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proj\resources\views/layouts/client/sidebar.blade.php ENDPATH**/ ?>