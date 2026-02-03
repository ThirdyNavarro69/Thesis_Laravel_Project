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
                    <span class="menu-icon"><i data-lucide="layout-dashboard"></i></span>
                    <span class="menu-text" data-lang="dashboard">Dashboard</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proj\resources\views/layouts/client/sidebar.blade.php ENDPATH**/ ?>