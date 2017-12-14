<?php $__env->startSection('title', '耀盛中国旗下P2P网贷平台 为用户提供借款与出借服务'); ?>

<?php $__env->startSection('content'); ?>

    <!-- banner -->
    <?php echo $__env->make('pc4.home.banner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

     <!-- 平台优势 -->
    <?php echo $__env->make('pc4.home.chooseJdy', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="index-activity-theme">

    <div class="v4-wrap">
        <?php echo $__env->make('pc4.home/project', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <!-- 媒体报道 -->
    <?php echo $__env->make('pc4.home.mediaReport', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- 合作伙伴 -->
    <?php echo $__env->make('pc4.home.cooper', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>
<!-- 关于我们 -->
<?php echo $__env->make('pc4.home.about', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="index-activity-layer">
    <!-- index 活动弹窗 -->
    <?php echo $__env->make('pc4.home/pop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pc4.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>