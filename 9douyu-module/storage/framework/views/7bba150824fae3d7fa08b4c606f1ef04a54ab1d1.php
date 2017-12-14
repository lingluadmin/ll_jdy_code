<div class="v4-header">
    <div class="v4-wrap">
        <div class="v4-header-nav-wrap">
            <i class="newyear-decorate-icon1"></i>
            <i class="newyear-decorate-icon2"></i>
            <h1 class="v4-header-logo">
                <a href="/"></a>
                <div class="v4-header-subhead">
                    耀盛中国
                    <p>旗下互联网金融平台</p>
                </div>
           </h1>
            <div class="v4-header-nav">
                <ul class="v4-header-nav-item">
                    <li><a href="/">首页</a></li>
                    
                    <li><a href="/project/index">我要出借</a></li>
                    <li><a href="/timecash/timecashloan">我要借款</a></li>
                    <li><a href="javascript:;" class="v4-header-nav-itemup">信息披露</a>
                        <div class="v4-header-nav-sub">
                            <a href="/about/index">公司介绍</a>
                            <a href="/about/insurance">安全保障</a>
                            <?php /*<a href="/zt/statistics">平台数据</a>*/ ?>
                            <a href="/help/1601">风险教育</a>
                            <a href="<?php echo e(assetUrlByCdn('/static/images/new/companyinfo.pdf')); ?>" target="_blank">从业机构信息</a>

                        </div>
                    </li>
                    <?php if(!empty($view_user)): ?>
                    <li><a href="/user" class="mr0px">我的账户</a></li>
                    <?php else: ?>
                    <li class="v4-header-login"><a href="/login">登录</a> / <a href="/register">注册</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<div class="clearfix"></div>

<div class="clear"></div>
