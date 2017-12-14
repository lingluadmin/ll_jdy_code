
<div id="v4-full-screen-slider">
    <div class="v4-sliders_btn">
        <div class="v4-wrap pr">
            <div id="v4-slides_prev" class="v4-sliders_prev"></div>
            <div id="v4-slides_next" class="v4-sliders_next"></div>
        </div>

    </div>
    <div class="v4-wrap">
        <div class="v4-slider-content">
            <?php if(!empty($view_user)): ?>{
           	<div class="v4-slider-welcome">
                <i class="v4-icon51 v4-iconfont">&#xe683;</i>
           		<p class="v4-text">欢迎您  <?php echo e(!empty($view_user['real_name']) ? $view_user['real_name']: $view_user['phone']); ?></p>
           	</div>
            <p class="v4-slider-account">
            	账户余额: 
            	<span><?php echo e(number_format($view_user['balance'], 2)); ?>元</span>
            </p>
            <a class="v4-btn v4-btn-primary" href="/project/index">立即出借</a>
            <?php else: ?>
            <!-- 登录前-->
            <div class="v4-slider-title">
                <div class="v4-slider-title-1"></div>
                <div class="v4-slider-title-3"></div>
                <span class="v4-slider-title-2">新用户注册送</span>
            </div>
            <p class="v4-slider-num"><span><?php echo e(isset($indexButton['BANK_TIMES']) ? $indexButton['BANK_TIMES'] : 5); ?></span><?php echo e(isset($indexButton['BANK_NOTE']) ? $indexButton['BANK_NOTE'] : '倍'); ?></p>
            <p class="v4-slider-text"><?php echo e(isset($indexButton['CONTENT_WORD']) ? $indexButton['CONTENT_WORD'] : '银行定期存款收益'); ?></p>
            <a class="v4-btn v4-btn-primary v4-btn-red" href="/register"><?php echo e(isset($indexButton['BUTTON_TEXT']) ? $indexButton['BUTTON_TEXT'] : '立即注册'); ?></a>
            <p class="v4-slider-login">已有账户？<a href="/login">立即登录</a></p>
            <?php endif; ?>
        </div>
    </div>
    <ul id="v4-slides">
        <?php if( !empty( $bannerList ) ): ?>
            <?php foreach( $bannerList as $banner ): ?>
                <li style="background-image: url(<?php echo e($banner['param']['file']); ?>);  background-position: 50% 0%; background-repeat: no-repeat no-repeat;">
                    <a target="_blank" href="<?php echo e($banner['param']['url']); ?>"><?php echo e($banner['title']); ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <?php echo $__env->make('pc4.home.stat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<div class="clearfix"></div>
