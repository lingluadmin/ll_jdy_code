<?php $__env->startSection('title', '首页'); ?>
<?php $__env->startSection('keywords', "<?php echo e(env('META_KEYWORD')); ?>"); ?>

<?php $__env->startSection('description', "<?php echo e(env('META_DESCRIPTION')); ?>"); ?>
<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
        <!--top-->
        <?php echo $__env->make('wap.home.top', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if(!empty($view_user)): ?>
        <!--已登录 banner-->
        <?php echo $__env->make('wap.home.adBanner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
        <!--未登录 注册引导 register guide-->
        <?php echo $__env->make('wap.home.guide', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        <!-- about nav-->
        <?php echo $__env->make('wap.home.about9douyu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- 新手 -->
        <?php echo $__env->make('wap.home.novice', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- 项目 -->
        <?php echo $__env->make('wap.home.project', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- 头条 -->
        <?php echo $__env->make('wap.home.news', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- 侧边栏 -->
        <?php echo $__env->make('wap.home.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('downloadApp'); ?>
    <?php echo $__env->make('wap.home.downloadapp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsScript'); ?>

<script type="text/javascript" src="<?php echo e(assetUrlByCdn('static/weixin/js/jquery-1.9.1.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(assetUrlByCdn('static/weixin/js/swiper3.1.0.jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(assetUrlByCdn('static/weixin/js/wap4/sidenav.js')); ?>"></script>
<script>
$(function(){
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay: 2000,
        loop: true
    });
})      
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('wap.common.wapHome', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>