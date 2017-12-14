<?php $__env->startSection('title','项目详情'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/project.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 
<article class="v4-detail-page">
    <div lass="v4-detail-page-head">
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title"><?php echo e($project['name'].' '.$project['format_name']); ?></h5>
        <div class="v4-user">
                <!-- <a href="/login">登录</a> | <a href="/register">注册</a> -->
                <a href="javascript:;" data-show="nav">我的</a>
        </div>
    </nav>
    <header class="v4-detail-head">
        <div class="rate">
            <?php if($project['pledge'] == 1): ?>
                <big><?php echo e((float)$project['base_rate']); ?></big><span>%</span><big>+<?php echo e((float)$project['after_rate']); ?></big><span>%</span>
            <?php else: ?>
                <big><?php echo e((float)$project['profit_percentage']); ?></big><span>%</span>
            <?php endif; ?>
        </div>
        <p class="text">借款利率</p>
        <div class="flag">
            <span>
                <?php if( $project['calculator_type'] != 'equalInterest' ): ?>
                    30 天转让
                <?php else: ?>
                    不可转让
                <?php endif; ?>
            </span>
            <?php /*<span>不支持优惠券</span>*/ ?>
        </div>

        <div class="progress">
            <div class="bar" style="width:<?php echo e($project['invest_speed']); ?>%;" data-length="bar">
            </div>
            <p class="txt" data-offset="auto">可投金额<?php echo e(number_format($project['left_amount'],2)); ?>元</p>
        </div>

        <ul class="v4-detail-box flex-box box-align box-pack">
            <li>
                <p>项目期限</p>
                <span><?php echo e($project['invest_time_note']); ?></span>
            </li>
            <li>
                <p>还款方式</p>
                <span><?php echo e($project['refund_type_note']); ?></span>
            </li>
            <li>
                <p>起投金额</p>
                <span>100元</span>
            </li>
        </ul>
    </header>
</div>
    <?php /*<a href="javascript:;" class="v4-detail-link">*/ ?>
       <?php /*<span class="tag">活动</span>*/ ?>
       <?php /*爱情银行，长存的不只有时光*/ ?>
       <?php /*<span class="arrow"></span>*/ ?>
    <?php /*</a>*/ ?>

    <section class="v4-detail-content">
        <h3>交易须知</h3>
        <!-- <table>
            <tr>
                <td class="td1">计息方式</td>
                <td class="td2">出借当日计息</td>
            </tr>
            <tr>
                <td class="td1">预期回款日</td>
                <td class="td2">2017-12-08</td>
            </tr>
            <tr>
                <td class="td1">借款总额</td>
                <td class="td2">910,000元</td>
            </tr>
            <tr>
                <td class="td1">风险等级</td>
                <td class="td2">稳定型</td>
            </tr>
            <tr valign="top">
                <td class="td1">赎回方式</td>
                <td class="td2">持有项目债权30天以上可申请债权转让，仅支持一次性全额转让</td>
            </tr>
            <tr valign="top">
                <td class="td1">费用</td>
                <td class="td2">买入费用:0.00%，退出费用:0.00%提前赎回费用:0.00%</td>
            </tr>
        </table> -->
        <div>
            <dl class="clearfix">
                <dt class="td1">计息方式</dt>
                <dd class="td2"><?php if( $project['new'] == 0 ): ?> 出借当日计息 <?php else: ?> 满标当日计息 <?php endif; ?></dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">预期回款日</dt>
                <dd class="td2"><?php echo e($project['end_at']); ?></dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">借款总额</dt>
                <dd class="td2"><?php echo e(number_format($project['total_amount'])); ?>元</dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">风险等级</dt>
                <dd class="td2">稳定型</dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">赎回方式</dt>
                <dd class="td2">持有项目债权30天以上可申请债权转让，仅支持一次性全额转让</dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">费用</dt>
                <dd class="td2">买入费用:0.00%，退出费用:0.00%提前赎回费用:0.00%</dd>
            </dl>
        </div>
        
    </section>

    <section class="v4-detail-content">
        <a href="/project/companyDetail/<?php echo e($project['id']); ?>" class="v4-detail-link">
            项目详情<span class="arrow"></span>
        </a>
        <h6 class="intro">项目介绍</h6>
        <div class="v4-mult-ellipsis">
            <p>
            <?php if($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_THIRD_CREDIT): ?> <!--第三方-->

            <?php echo isset($creditDetail['companyView']['project_desc']) ? $creditDetail['companyView']['project_desc'] : ''; ?>


            <?php elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_FACTORING): ?> <!--保理-->
                <?php echo e(isset($creditDetail['companyView']['factor_summarize']) ? htmlspecialchars_decode($creditDetail['companyView']['factor_summarize']) : '九安心产品是保理公司将应收账款收益权转让给出借人；原债权企业多为国企及上市公司，切负有连带责任，借款期限一般为30~90天，适合偏好短期，且稳定的出借人。'); ?>


            <?php elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_CREDIT_LOAN): ?><!--信贷-->

                <?php echo e(!empty($creditDetail['companyView']) && $creditDetail['companyView']['founded_time'] != '0000-00-00 00:00:00' && isset($creditDetail['companyView']['background']) ? $creditDetail['companyView']['background'] : ' 债权借款人均为工薪精英人群，该人群有较高的教育背景、稳定的经济收入及良好的信用意识。'); ?>


            <?php elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_HOUSING_MORTGAGE): ?><!--房抵-->

                <?php echo e(isset($creditDetail['companyView']['credit_desc']) ? $creditDetail['companyView']['credit_desc'] : '借款人因资金周转需要，故以个人名下房产作为抵押进行借款。此类借款人有稳定的经济收入及良好的信用意识。'); ?>


            <?php else: ?>
                九安心产品是保理公司将应收账款收益权转让给出借人；原债权企业多为国企及上市公司，切负有连带责任，借款期限一般为30~90天，适合偏好短期，且稳定的出借人。
            <?php endif; ?>
            </p>
        </div>
        
    </section>
    <a href="/project/refund_plan/<?php echo e($project['id']); ?>" class="v4-detail-link v4-detail-link-single">
            回款计划<span class="arrow"></span>
    </a>
    <a href="/project/invest_record/<?php echo e($project['id']); ?>" class="v4-detail-link v4-detail-link-single">
            出借记录<span class="arrow"></span>
    </a>
    <!-- 出借 -->
    <a href="/invest/project/confirm/<?php echo e($project['id']); ?>" class="v4-invset-btn">立即出借</a>
    <!-- <a href="javascript:;" class="v4-invset-btn disabled">已售罄</a> -->


</article>
<!-- 侧边栏 -->
<?php echo $__env->make('wap.home.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 


<?php $__env->stopSection(); ?>
<?php $__env->startSection('jsScript'); ?>

<script>
  
    //判断进度条上文字的偏移位置 
    $(function(){
        var bar = $('[data-length="bar"]');
        var txtOffset = $('[data-offset="auto"]');

        var w = txtOffset.width()/46.875;
        var l = (bar.width())/46.875;
        txtOffset.css({"left":bar.width()-txtOffset.width()/2});
        // alert(bar.width());
        var w = parseInt(bar[0].style.width);
        if(w>86 && w<=100){
            txtOffset.css({"left":"12rem",});
        }
        if(w<=20){
            txtOffset.css({"left":"0.2rem"});
        }
    })

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('wap.common.wapBaseNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>