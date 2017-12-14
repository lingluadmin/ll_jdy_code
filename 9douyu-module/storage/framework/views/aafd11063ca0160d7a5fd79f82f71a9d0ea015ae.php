<?php if( !empty(\App\Http\Logics\Ad\AdLogic::getUseAbleListByPositionId(13)) && empty($tag)): ?>
    <div class="index-activity-mask"></div>
    <div class="index-activity-pop">
        <a href="javascript:;" class="index-activity-pop-close" data-toggle="mask" data-target="index-activity-layer"></a>
        <?php if( isset(\App\Http\Logics\Ad\AdLogic::getUseAbleListByPositionId(13)[0]['param']['file'] ) && !empty(\App\Http\Logics\Ad\AdLogic::getUseAbleListByPositionId(13)[0]['param']['file']) ): ?>
            <a target="_blank" href="<?php echo e(\App\Http\Logics\Ad\AdLogic::getUseAbleListByPositionId(13)[0]['param']['url']); ?>">
                <img src="<?php echo e(\App\Http\Logics\Ad\AdLogic::getUseAbleListByPositionId(13)[0]['param']['file']); ?>">
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php /*<div class="index-activity-mask"></div>*/ ?>
<?php /*<div class="index-activity-pop">*/ ?>
    <?php /*<a href="javascript:;" class="index-activity-pop-close" data-toggle="mask" data-target="index-activity-layer"></a>*/ ?>
        <?php /*<a target="_blank" href="#">*/ ?>
            <?php /*<img src="<?php echo e(assetUrlByCdn('/static/theme/spring/images/theme-pop.png')); ?>">*/ ?>
        <?php /*</a>*/ ?>
<?php /*</div>*/ ?>