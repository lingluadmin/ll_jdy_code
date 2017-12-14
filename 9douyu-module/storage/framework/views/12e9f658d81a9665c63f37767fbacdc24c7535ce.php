<div class="v4-top">
    <div class="v4-wrap">
        <div class="v4-top-txt">
            客服热线：400-6686-568 (9:00~18:00)
            <div class="v4-new-hover">

                <i class="v4-icon-wechart v4-iconfont">&#xe63d;</i>关注微信
                <div class="v4-new-code">
                    <div class="v4-new-weixin-code"></div>
                </div>
            </div>

            <div class="v4-new-hover">

                <i class="v4-icon-weibocode v4-iconfont">&#xe6db;</i>关注微博
                <div class="v4-new-code">
                    <div class="v4-new-weibo-code"></div>
                </div>
            </div>
        </div>
        <div class="v4-top-nav-wrap">
            <ul class="v4-top-nav">
                <?php if(!empty($view_user)): ?>
                    <li class="v4-top-nav-account">您好，<?php if(!empty($view_user['real_name'])): ?> <?php echo e($view_user['real_name']); ?> <?php else: ?> <?php echo e(\App\Tools\ToolStr::hidePhone($view_user['phone'], 3, 4)); ?>  <?php endif; ?>  <a href="<?php echo e(url('logout')); ?>">[退出]</a></li>
                <?php endif; ?>
                <li class="v4-top-nav-app"><i class="v4-icon-iphone v4-iconfont">&#xe63c;</i>手机客户端<div class="v4-top-nav-appimg"></div></li>
                <li>｜ <a href="/help">帮助中心</a></li>
            </ul>

        </div>
        <div class="clear"></div>
    </div>
</div>
