<!DOCTYPE html>
<html lang="en" class="sidebar-with-line">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Default Title'); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    
    <link href="<?php echo e(asset('assets/images/favicon.ico')); ?>"/>

    
    <script src="<?php echo e(asset('assets/js/config.js')); ?>"></script>

    
    <link href="<?php echo e(asset('assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css">

    
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/choices/choices.min.css')); ?>">

    
    <link href="<?php echo e(asset('assets/css/vendors.min.css')); ?>" rel="stylesheet" type="text/css" />

    
    <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />

    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>

    
    <div class="wrapper">
        <?php echo $__env->make('layouts.freelancer.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.freelancer.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('layouts.freelancer.theme', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <script src="<?php echo e(asset('assets/js/vendors.min.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/plugins/chartjs/chart.umd.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/js/pages/custom-table.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/js/pages/dashboard.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/js/pages/custom-table.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/misc-sweetalerts.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/plugins/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/inputmask/inputmask.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/handlebars/handlebars.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/typeahead/typeahead.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/form-inputmask.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/form-typehead.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/plugins/choices/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/form-choice.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/form-select2.js')); ?>"></script>

    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\proj\resources\views/layouts/freelancer/app.blade.php ENDPATH**/ ?>