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
                    <li><a href="/" <?php if( $_SERVER['REQUEST_URI'] == '/'): ?> class="blue"  <?php endif; ?>>首页</a></li>

                    <li><a href="/project/index" <?php if( in_array($_SERVER['REQUEST_URI'],['/project/index','/invest/project/investConfirm/']) || strstr($_SERVER['REQUEST_URI'],'/project/detail/') ): ?> class="blue"  <?php endif; ?>>我要出借</a></li>
                    <li><a href="/timecash/timecashloan" <?php if( $_SERVER['REQUEST_URI'] == '/timecash/timecashloan'): ?> class="blue"  <?php endif; ?>>我要借款</a></li>
                    <li><a href="/risk" <?php if( $_SERVER['REQUEST_URI'] == '/risk'): ?> class="blue"  <?php endif; ?> >出借人教育</a></li>
                    <li><a href="javascript:;" class="v4-header-nav-itemup" <?php if(in_array($_SERVER['REQUEST_URI'], ['/about','/about/security','/zt/statistics','/compliance','/activity/secondCustody','/about/companyinfo'])): ?> style="color:#00bafb;"  <?php endif; ?>>信息披露</a>
                        <div class="v4-header-nav-sub">
                            <a href="/about">公司介绍</a>
                            <a href="/about/security">安全保障</a>
                            <?php /*<a href="/zt/statistics">平台数据</a>*/ ?>
                            <a href="/compliance">平台合规</a>
                            <a href="/activity/secondCustody">资金存管</a>
                            <a href="/about/companyinfo">机构信息</a>

                        </div>
                    </li>
                    <?php if(!empty($view_user)): ?>
                        <li class="v4-header-login"><a href="/user" class="mr0px blue"> 我的账户</a></li>
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
