<article data-nav="true">
    <section class="v4-mask" data-show="sidemask"></section>
    <section class="v4-side-wrap" data-show="sidewrap">
        <div class="v4-profile">
            <?php if(!empty($view_user)): ?>
            <div class="v4-profile-user flex-box box-align">
                <img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/user/avatar.png')); ?>" alt="avatar" class="v4-profile-avatar">
                <div class="v4-profile-info">
                    <?php if(empty($view_user['real_name'])): ?>
                        <h4><?php echo e(\App\Tools\ToolStr::hideNum($view_user['phone'],3,3)); ?></h4>
                        <p></p>
                    <?php else: ?>
                        <h4><?php echo e(\App\Tools\ToolStr::hideName($view_user['real_name'])); ?></h4>
                        <p><?php echo e(\App\Tools\ToolStr::hideNum($view_user['identity_card'],3,3)); ?></p>
                    <?php endif; ?>

                </div>
            </div>
            <ul class="v4-profile-account">

                <li class="flex-box box-align arrow">
                    <a href="/bank/userCard">
                        <p>我的银行卡</p>
                    </a>
                </li>
                <li class="flex-box box-align arrow">
                    <a href="/user/asset">
                        <p><?php echo e(number_format($view_user_total_amount+$view_user['balance'], 2)); ?></p>
                        <span>总资产(元)</span>
                    </a>
                </li>
                <li class="flex-box box-align arrow">
                    <a href="/user">
                        <p><?php echo e(number_format($view_user['balance'], 2)); ?></p>
                        <span>账户余额(元)</span>
                    </a>
                </li>

            </ul>
            <?php endif; ?>
        </div>
        <nav class="v4-side-nav">
            <a href="/"><img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/user/icon-nav0.png')); ?>" alt="首页">首页</a>
            <a href="/project/lists"><img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/user/icon-nav1.png')); ?>" alt="项目列表">项目列表</a>
            <a href="/user/managementPassword"><img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/user/icon-nav2.png')); ?>" alt="密码管理">密码管理</a>
            <a href="/article/questionnaire"><img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/user/icon-nav3.png')); ?>" alt="风险评估">风险评估</a>
            <a href="/article/hotQuestion"><img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/user/icon-nav4.png')); ?>" alt="常见问题">常见问题</a>
            <a href="tel:400-6686-568"><img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/user/icon-nav5.png')); ?>" alt="联系客服">联系客服(400-6686-568)</a>
            <a href="/logout"><img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/user/icon-nav6.png')); ?>" alt="退出登录">退出登录</a>
        </nav>
    </section>

</article>
