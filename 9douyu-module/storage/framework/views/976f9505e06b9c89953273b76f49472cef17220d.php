<?php $__env->startSection('title', '优选项目'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/information.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<article class="Js_tab_box">
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">优选项目</h5>
        <div class="v4-user">
            <a href="javascript:;" data-show="nav">我的</a>
        </div>
    </nav>
    <div class="v4-project-1">
        <ul>
            <li>
                <p id="user_principal_note">在投本金(元)</p>
                <p id="user_principal">0.00</p>
            </li>
            <li>
                <p id="user_interest_note">待收收益(元)</p>
                <p id="user_interest">0.00</p>
            </li>
        </ul>
    </div>

    <ul class="v4-bonus-nav Js_tab">
        <li <?php if( $holdType == "investing"): ?>  class="active" <?php endif; ?>   ><a href="/user/invest/PreferredItem?holdType=investing"><span>持有中</span></a></li>
        <li <?php if( $holdType == "assignment"): ?> class="active" <?php endif; ?>   ><a href="/user/invest/PreferredItem?holdType=assignment"><span>转让中</span></a></li>
        <li <?php if( $holdType == "finish"): ?>     class="active" <?php endif; ?>   ><a href="/user/invest/PreferredItem?holdType=finish"><span>已完结</span></a></li>
    </ul>

    <div class="scroller-wrap " ms-controller="investHome" ms-on-swipeup="swipeUp()" ms-on-swipedown="swipeDown()">

        <div class="scroller">
            <ul class="v4-project-2">
                <a  data-touch="false" ms-repeat="invest" ms-attr-href="/user/invest/detail?investId={%el.invest_id%}" >
                    <li>
                         <p><span>{% el.project_name %}</span><span>{% el.invest_principal %} </span><span>{% el.invest_interest %}</span></p>
                         <p><span>{% el.format_name  %}<?php if( $holdType == "assignment"): ?><i class="v4-pro-icon">转让中</i><?php elseif($holdType == "finish"): ?><i class="v4-pro-icon">已完结</i><?php endif; ?></span><span>{% el.invest_principal_note %}(元)</span><span>{% el.invest_interest_note %}(元)</span></p>
                    </li>
                </a>
             </ul>
            <div class="v4-load-more"><i class="pull_icon"></i><span>加载中...</span></div>
         </div>
    </div>
    <input type="hidden" id="holdType" value="<?php echo e($holdType); ?>">
    <?php /*
    <div class="v4-pro-main Js_tab_main">
        <ul class="v4-project-2">
             <li>
                 <a href="/user/invest/detail" data-touch="false">
                     <p><span>九省心12月期</span><span>1,000,33</span><span>90.9</span></p>
                     <p><span>170911-11<i class="v4-pro-icon">转让中</i></span><span>买入金额(元)</span><span>预期收益(元)</span></p>
                  </a>
             </li>
             <li>
                 <a href="/user/invest/detail" data-touch="false">
                     <p><span>九省心12月期</span><span>1,000,33</span><span>90.9</span></p>
                     <p><span>170911-11<i class="v4-pro-icon">转让中</i></span><span>买入金额(元)</span><span>预期收益(元)</span></p>
                  </a>
             </li>
             <li>
                 <a href="/user/invest/detail" data-touch="false">
                     <p><span>九省心12月期</span><span>1,000,33</span><span>90.9</span></p>
                     <p><span>170911-11<i class="v4-pro-icon">转让中</i></span><span>买入金额(元)</span><span>预期收益(元)</span></p>
                  </a>
             </li>
         </ul>
    </div>
    <div class="v4-pro-main Js_tab_main">

          <ul class="v4-project-2">
             <li>
                 <a href="/user/invest/detail" data-touch="false">
                    <p><span>九省心12月期</span><span>1,000,33</span><span>90.9</span></p>
                    <p><span>170911-11<i class="v4-pro-icon">已转让</i></span><span>买入金额(元)</span><span>预期收益(元)</span></p>
                 </a>
             </li>
             <li>
                 <a href="/user/invest/detail" data-touch="false">
                    <p><span>九省心12月期</span><span>1,000,33</span><span>90.9</span></p>
                    <p><span>170911-11<i class="v4-pro-icon">已转让</i></span><span>买入金额(元)</span><span>预期收益(元)</span></p>
                 </a>
             </li>
             <li>
                 <a href="/user/invest/detail" data-touch="false">
                    <p><span>九省心12月期</span><span>1,000,33</span><span>90.9</span></p>
                    <p><span>170911-11<i class="v4-pro-icon">已转让</i></span><span>买入金额(元)</span><span>预期收益(元)</span></p>
                 </a>
             </li>
         </ul>
    </div>
    */ ?>


</article>
 
 <!-- 侧边栏 -->
<?php echo $__env->make('wap.home.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsScript'); ?>
<script src="<?php echo e(assetUrlByCdn('/static/weixin/js/lib/biz/user-invest-home.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/weixin/js/wap4/tab.js')); ?>"></script>
<script type="text/javascript">

//var evclick = "ontouchend" in window ? "touchend" : "click";

//$(".Js_tab_box").tabs({action: evclick });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('wap.common.wapBaseLayoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>