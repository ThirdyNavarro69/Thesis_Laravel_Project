<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Default Title'); ?></title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    
    <link href="<?php echo e(asset('assets/images/favicon.ico')); ?>"/>

    
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/nouislider/nouislider.min.css')); ?>">

    
    <script src="<?php echo e(asset('assets/js/config.js')); ?>"></script>

    
    <link href="<?php echo e(asset('assets/css/vendors.min.css')); ?>" rel="stylesheet" type="text/css" />

    
    <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />

    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>

    
    <div class="wrapper">
        <?php echo $__env->make('layouts.client.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.client.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('layouts.client.theme', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <script src="<?php echo e(asset('assets/js/vendors.min.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/plugins/nouislider/nouislider.min.js')); ?>"></script>

    
    <script src="<?php echo e(asset('assets/js/pages/ecommerce-products.js')); ?>"></script>

    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\proj\resources\views/layouts/client/app.blade.php ENDPATH**/ ?>