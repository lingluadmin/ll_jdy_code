<div class="v4-top">
    <div class="v4-wrap">
        <div class="v4-top-txt">
            客服热线：400-6686-568 (9:00~18:00)
            <div class="v4-new-hover">

                <i class="v4-icon-wechart v4-iconfont">&#xe63d;</i>关注微信
                <div class="v4-new-code">
                    <div class="v4-new-web-code"></div>
                </div>
            </div>
        </div>
        <div class="v4-top-nav-wrap">
            <ul class="v4-top-nav">
                
               <li>
                   <?php if(!empty($view_user)): ?>
                       <?php if(!empty($view_user['real_name'])): ?>
                           <em>您好，<a href="/user"><?php echo e($view_user['real_name']); ?></a></em><a href="/logout">［退出］</a>
                       <?php elseif(!empty($view_user['phone'])): ?>
                           <em>您好，<a href="/user"><?php echo e($view_user['phone']); ?></a></em><a href="/logout">［退出］</a>
                       <?php endif; ?>
                   <?php endif; ?>
               </li>

                <li class="v4-top-nav-app"><i class="v4-icon-iphone v4-iconfont">&#xe63c;</i>手机客户端<div class="v4-top-nav-appimg"></div></li>
                <li>｜<a href="/help">帮助中心</a></li>
            </ul>

        </div>
        <div class="clear"></div>
    </div>
</div>