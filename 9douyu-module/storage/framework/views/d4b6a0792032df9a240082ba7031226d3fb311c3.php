<?php $__env->startSection('title', '耀盛中国旗下金融科技平台 提供一站式金融服务【安全|智能|稳健|高效】'); ?>
<?php $__env->startSection('content'); ?>

    <!-- banner -->
    <?php echo $__env->make('pc.home.banner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- 平台优势 -->
    <?php echo $__env->make('pc.home.chooseJdy', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="index-activity-theme ms-controller" ms-controller="homeIndex">
        <div class="v4-wrap">
            <!-- current -->
            <?php echo $__env->make('pc.home.novice', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- 智投计划 -->
            <?php echo $__env->make('pc.home.projectSmart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- 短期项目 -->
            <?php echo $__env->make('pc.home.projectShort', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- 中长期项目 -->
            <?php echo $__env->make('pc.home.projectMiddle', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- 长期项目 -->
            <?php echo $__env->make('pc.home.projectLong', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- credit 债权转让 -->
            <?php echo $__env->make('pc.home.assignProject', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <!-- 媒体报道 -->
        <?php echo $__env->make('pc.home.mediaReport', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- 合作伙伴 -->
        <?php echo $__env->make('pc.home.cooper', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
   

    <div class="index-activity-layer">
        <!-- index 活动弹窗 -->
        <?php echo $__env->make('pc.home.pop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/lib/biz/home-index.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('assets/js/pc4/nummove.js')); ?>"></script>

    <script src="<?php echo e(assetUrlByCdn('assets/js/pc4/jquery.slides.js')); ?> "></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('pc.common.layoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>