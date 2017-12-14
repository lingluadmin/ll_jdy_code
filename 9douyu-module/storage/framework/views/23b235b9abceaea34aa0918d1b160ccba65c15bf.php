<?php $__env->startSection('title', '产品详情'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/information.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<article class="Js_tab_box" >
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">产品详情</h5>
        <div class="v4-user">
            <a href="javascript:;" data-show="nav">我的</a>
        </div>
    </nav>
    <section ms-controller="investRecordDetail">
        <input type="hidden" name="invest_id" id="investRecordId" value="<?php echo e($investId); ?>">
        <div class="v4-pro-detail">
            <ul class="v4-pro-detail-1">
                <li><h4>{% investDetail.format_project_name%}</h4></li>
                <li>投资金额<span>{% investDetail.invest_cash| number(2)%}元</span></li>
                <li>年化收益<span>{% investDetail.profit_percentage | number(1)%}%</span></li>
                <li>已收利息<span>{% investDetail.ownInterest | number(2)%}元</span></li>
                <li>预计待收利息<span>{% investDetail.ingInterest | number(2)%}元</span></li>
                <li>投资日期<span>{% investDetail.invest_time%}</span></li>
                <li>起息日期<span>{% investDetail.invest_time%}</span></li>
                <li>预计完结日期<span>{% investDetail.refund_end_time%}</span></li>
                <li>回款方式<span>{% investDetail.refund_type_text%}</span></li>
            </ul>
        </div>
        <div class="v4-pro-detail1">
            <h4>预计回款记录</h4>
            <div class="v4-pro-detail1-1"  ms-repeat="refundList">
                <p>{% el.refund_status %}<span ms-if=" el.principal=='0.00'">{% el.refund_cash %}</span><span ms-if=" el.principal !='0.00'">{% el.principal | number(2)%}+{% el.interest %}元</span></p>
                <p>{% el.refund_time %}<span ms-if=" el.principal=='0.00'">利息</span> <span ms-if=" el.principal !='0.00'">本金+利息</span></p>
            </div>
        </div>
        <div class="v4-pro-detail2">
            <a  ms-attr-href="/agreement?type=argument&project_id={% investDetail.project_id %}" >合同协议</a>
        </div>
    </section>
</article>

 <!-- 侧边栏 -->
<?php echo $__env->make('wap.home.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsScript'); ?>
    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/weixin/js/lib/biz/user-invest-record.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('wap.common.wapBaseLayoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>