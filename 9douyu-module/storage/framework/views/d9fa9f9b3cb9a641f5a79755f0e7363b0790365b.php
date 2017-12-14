<div class="v4-wrap-margin clearfix">
    <a href="javascript:;" class="v4-novice-banner">
        <img src="<?php echo e(assetUrlByCdn('/static/images/pc4/index/v4-novice-banner.jpg')); ?>">
    </a>
    <div class="v4-current-container">
        <h4>零钱计划<sub>灵活存取</sub></h4>
        <div class="v4-current-inner clearfix">
            <div class="inner inner1">
                <p class="big"><?php echo e($current['rate']); ?><sub>%</sub></p>
                <span>借款利率</span>
            </div>
            <div class="inner inner2">
                <div class="line line1"></div>
                <p><?php echo e(round( ($current['total_amount'] - $current['invested_amount'])/1000 ,2)); ?><sub>万元</sub></p>
                <span>开放额度</span>
                <div class="line line2"></div>
            </div>
            <div class="inner inner3">
                <a href="javascript:;" class="v4-btn v4-btn-min" window.location.href="/project/current/detail">立即出借</a>
            </div>
        </div>
    </div>
    <a href="javascript:;" class="v4-AD">
        <img src="<?php echo e(assetUrlByCdn('/static/images/pc4/index/v4-AD.jpg')); ?>">
    </a>
</div>