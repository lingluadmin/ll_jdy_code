<!DOCTYPE html>
<html>
    <head>
        <title>九斗鱼 - <?php echo $__env->yieldContent('title'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?php echo e(env('META_KEYWORD')); ?>" />
        <meta name="description" content="<?php echo e(env('META_DESCRIPTION')); ?>" />
        <meta name="renderer" content="webkit" />
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" />
        <link href="<?php echo e(assetUrlByCdn('/static/images/favicon.ico')); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link rel="stylesheet" href="<?php echo e(assetUrlByCdn('/static/css/pc4.css')); ?>" type="text/css" />
        <?php if( \App\Http\Logics\SystemConfig\SystemConfigLogic::getConfig('SKIN_CSS') ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/theme/'.\App\Http\Logics\SystemConfig\SystemConfigLogic::getConfig('SKIN_CSS').'/css/theme.css')); ?>">
        <?php endif; ?>
        <?php echo $__env->yieldContent('csspage'); ?>
        <script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/js/jquery-1.9.1.min.js')); ?>"></script>
    </head>
<body>
    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('pc.common/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldSection(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php $__env->startSection('footer'); ?>
        <?php echo $__env->make('pc.home/about', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('pc.common/footerNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldSection(); ?>

    <?php echo $__env->make('pc.common/qqService', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('jspage'); ?>

</body>


</html>
