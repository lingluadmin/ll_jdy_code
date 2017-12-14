<!DOCTYPE html>
<html lang="zh">
<head>

    <?php $__env->startSection('css'); ?>
        <link href="<?php echo e(assetUrlByCdn('css/admin/style.default.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(assetUrlByCdn('css/admin/jquery.datatables.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(assetUrlByCdn('css/admin/sweetalert.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldSection(); ?>
    <?php echo $__env->make('admin/common/html-head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
<!-- start: Header -->
<?php echo $__env->make('admin/common/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- start: Header -->

<div class="container-fluid-full">
    <div class="row-fluid">
                <!--测导航 -->
        <?php echo $__env->make('admin/common/sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <!--测导航 -->

        <div id="content" class="span10">
            <?php echo $__env->yieldContent('content'); ?>
        </div><!--/.fluid-container-->

        <!-- end: Content -->
    </div><!--/#content.span10-->

</div><!--/fluid-row-->

<div class="clearfix"></div>
<?php echo $__env->make('admin/common/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('admin/common/js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('javascript'); ?>
    <script src="<?php echo e(assetUrlByCdn('js/admin/jquery-migrate-1.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/jquery-ui-1.10.3.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/modernizr.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/toggles.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/retina.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/jquery.cookies.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/flot/flot.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/flot/flot.resize.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/morris.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/raphael-2.1.0.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/chosen.jquery.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('js/admin/custom.js')); ?>"></script>
    <?php /*<script src="<?php echo e(assetUrlByCdn('/static/js/jquery-1.9.1.min.js')); ?>"></script>*/ ?>

    <?php echo Toastr::render(); ?>

    <?php echo $__env->yieldContent('jsScript'); ?>
<?php echo $__env->yieldSection(); ?>
</body>
</html>
