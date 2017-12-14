<?php $__env->startSection('title', '出借记录'); ?>

<?php $__env->startSection('csspage'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="v4-account" >
        <!-- account begins -->
        <?php echo $__env->make('pc.common.leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="v4-content v4-account-white">
            <h2 class="v4-account-titlex">出借记录</h2>
            <h4 class="v4-section-title"><span></span>出借详情</h4>
            <div class="v4-tabel-detail-wrap" >
                <h4 class="v4-section-title">参数错误</h4>
            </div>
            <div class="v4-tabel-detail-wrap">
                    <table class="v4-tabel-detail">
                        <tbody><tr class="grey">
                            <td><label>项目名称</label><span>九随心1月期 171105-2</span></td>
                            <td><label>回款方式</label><span>到期还本息</span></td>
                        </tr>
                        <tr>
                            <td><label>出借金额</label><span>100.00</span></td>
                            <td><label>优惠券</label><span>未使用加息券</span></td>
                        </tr>
                        <tr class="grey">
                            <td><label>借款利率</label><span>7.00</span>%</td>
                            <td><label>加息奖励</label><span>0.00</span></td>
                        </tr>
                        <tr>
                            <td><label>已收利息</label><span>0.00</span></td>
                            <td><label>交易日期</label> <span>2017-11-22 17:40:43</span></td>
                        </tr>
                        <tr class="grey">
                            <td><label>预期待收利息</label><span>0.23</span></td>
                            <td><label>到期日期</label><span>2017-12-04</span></td>
                        </tr>
                    </tbody></table>
                </div>
            
            <h4 class="v4-section-title v4-mt-plus-20"><span></span>预期回款记录</h4>
            <div class="v4-tabel-detail-wrap ">
                <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-48">
                    <thead>
                        <tr>
                            <td>回款期数</td>
                            <td>本金</td>
                            <td>利息</td>
                            <td>回款时间</td>
                            <td>回款状态</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>第1/1期</td>
                            <td>100.00</td>
                            <td>0.23</td>
                            <td>2017-12-04</td>
                            <td>未回款</td>
                        </tr>
                    </tbody>
                </table>
            <h4 class="v4-section-title">暂无回款计划</h4>
        </div>
      </div>

        
    </div>
<!-- account ends -->
<div class="clear"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>