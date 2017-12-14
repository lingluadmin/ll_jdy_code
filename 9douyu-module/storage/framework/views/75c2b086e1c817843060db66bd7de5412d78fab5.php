<?php $__env->startSection('title', '实名成功'); ?>

<?php $__env->startSection('keywords', env('META_KEYWORD')); ?>

<?php $__env->startSection('description', env('META_DESCRIPTION')); ?>

<?php $__env->startSection('content'); ?>

    <article>
        <section class="wap2-dd-box clearfix">
            <div class="wap2-dd-info">
                <p class="tc">
                    恭喜您，实名认证成功
                </p>

                <i class="wap2-arrow-2"></i>
            </div>
            <div class="wap-dd-block">
                <img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap2/wap2-dd.png')); ?>" class="img">
            </div>
        </section>

        <section class="wap2-btn-wrap">
            <a href="/user" class="wap2-btn  wap2-btn-blue2">去我的账户</a>
        </section>
    </article>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('wap.common.wapBase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>