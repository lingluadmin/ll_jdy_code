<div id="v4-full-screen-slider" class="ms-controller" ms-controller="headerIndex">
    <div class="v4-sliders_btn">
        <div class="v4-wrap pr">
            <div id="v4-slides_prev" class="v4-sliders_prev"></div>
            <div id="v4-slides_next" class="v4-sliders_next"></div>
        </div>

    </div>
    <div class="v4-wrap">
        <div class="v4-slider-content" ms-if="@user.status==0">
            <!-- 登录前-->
            <div class="v4-slider-title">
                <div class="v4-slider-title-1"></div>
                <div class="v4-slider-title-3"></div>
                <span class="v4-slider-title-2">新用户注册送</span>
            </div>
            <p class="v4-slider-num"><span>{% @button.BANK_TIMES %}</span><span>{% @button.BANK_NOTE %}</span></p>
            <p class="v4-slider-text">{% @button.CONTENT_WORD %}</p>
            <a class="v4-btn v4-btn-primary v4-btn-red" href="/register">{% @button.BUTTON_TEXT %}</a>
            <p class="v4-slider-login">已有账户？<a href="/login">立即登录</a></p>
        </div>
        <div class="v4-slider-content" ms-if="@user.status==1">
            <div class="v4-slider-title">
                <div class="v4-slider-title-1"></div>
                <div class="v4-slider-title-3"></div>
                <span class="v4-slider-title-2">欢迎使用九斗鱼</span>
            </div>
            <ul class="v4-slider-account">
                <li><label>可用余额: </label><span>{% @user.user.balance|number(2) %}</span><span>元</span></li>
                <li><label>累计收益: </label><span>{% @user.totalInterested|number(2) %}</span><span>元</span></li>
            </ul>
            <a class="v4-btn v4-btn-primary v4-btn-red" href="/user">我的账户</a>
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
    <?php echo $__env->make('pc.home.stat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<div class="clearfix"></div>
