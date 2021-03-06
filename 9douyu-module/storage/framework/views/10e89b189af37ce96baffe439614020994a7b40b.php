<?php $__env->startSection('title','总资产'); ?>

<?php $__env->startSection('css'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/user.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<article>
     <div class="v4-user-page-head">
        <nav class="v4-top flex-box box-align box-pack v4-page-head">
            <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
            <h5 class="v4-page-title">总资产</h5>
            <div class="v4-user"></div>
        </nav>
     </div>
     <hgroup class="v4-asset-hgroup">
         <h5>预期总资产(元)</h5>
         <p><?php echo e($user['total_cash']); ?></p>
     </hgroup>

     <div class="v4-asset-canvas flex-box box-align box-pack">
         <div class="text">
             <p><span></span>可用余额<em><?php echo e($user['balance']); ?></em></p>
             <p><span></span>优选项目<em><?php echo e($user['doing_invest_amount']); ?></em></p>
             <p><span></span>零钱计划<em><?php echo e($user['current_cash']); ?></em></p>
         </div>
         <div id="main" class="shape"></div>
     </div>

     <div class="v4-asset-item clearfix">
         <a href="/user/invest/PreferredItem" data-touch="false">
             <h5>优选项目(元)</h5>
             <p><?php echo e($user['doing_invest_amount']); ?></p>
         </a>
         <a href="javascript:;" data-layer="layer-10" data-touch="false">
             <h5>零钱计划(元)</h5>
             <p><?php echo e($user['current_cash']); ?></p>
         </a>
     </div>
     
   
</article>

<section class="v4-pop layer-10" style="display:none;">
    <div class="v4-pop-mask"></div>
    <div class="v4-pop-main">
        <a href="#" class="v4-pop-close" data-toggle="mask" data-target="layer-10"></a>
        <div class="v4-pop-box v4-asset-pop-box">
            <img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/asset/img1.png')); ?>" alt="" class="img1">
            <p class="p1">零钱计划资金的转入转出</p>
            <p class="p2">请使用九斗鱼APP进行操作</p>
            <a href="javascript:;" class="v4-btn-user" data-toggle="mask" data-target="layer-10">知道了</a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsScript'); ?>

<script src="<?php echo e(assetUrlByCdn('static/weixin/js/wap4/echarts.common.min.js')); ?>"></script>
<script src="<?php echo e(assetUrlByCdn('static/weixin/js/pop.js')); ?>"></script>
<script>
 
    /*饼状图*/
    var myChart = echarts.init(document.getElementById('main'));
     // 指定图表的配置项和数据
    var option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            color:['#FFAA02', '#449CFF','#1458A6'],
            legend: {
                show:false,
                orient: 'vertical',
                x: 'right',
                data:['可用余额','优选项目','零钱计划']
            },
            series: [
                {
                    name:'资产占比',
                    type:'pie',
                    radius: ['40%', '55%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '16',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:[
                        {value:'<?php echo e(str_replace(',','',$user['balance'])); ?>', name:'可用余额'},
                        {value:'<?php echo e(str_replace(',','',$user['doing_invest_amount'])); ?>', name:'优选项目'},
                        {value:'<?php echo e(str_replace(',','',$user['current_cash'])); ?>', name:'零钱计划'}
                      
                    ]
                }
            ]
        };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('wap.common.wapBaseNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>