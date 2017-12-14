<?php $__env->startSection('title', '出借记录'); ?>

<?php $__env->startSection('csspage'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="v4-account" >
        <!-- account begins -->
        <?php echo $__env->make('pc.common.leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="v4-content v4-account-white ms-controller" ms-controller="InvestSmart">
            <h2 class="v4-account-titlex">出借记录</h2>
            <h4 class="v4-section-title pr"><span></span>出借详情<a ms-attr="{href:'/user/invest/smartMatchDetail?record_id=' + investId }" class="v4-section-detail-right">资金匹配情况></a></h4>
            <!-- <div class="v4-tabel-detail-wrap" >
                <h4 class="v4-section-title">参数错误</h4>
            </div> -->
            <div class="v4-tabel-detail-wrap">
                    <table class="v4-tabel-detail">
                        <tbody><tr class="grey">
                            <td><label>项目名称</label><span>{% @investDetail.project_name + ' ' +@investDetail.format_name  %}</span></td>
                            <td><label>回款方式</label><span>{% @investDetail.refund_type_text %}</span></td>
                        </tr>
                        <tr>
                            <td><label>出借金额</label><span>{% @investDetail.invest_cash   %}</span></td>
                            <td><label>交易状态</label><span>{% @investDetail.project_status_note %}</span></td>
                        </tr>
                        <tr class="grey">
                            <td><label>期待年回报率</label><span>{% @investDetail.profit_percentage %}</span>%</td>
                            <td><label>锁定期限</label><span>{% @investDetail.invest_time   %}</span>天</td>
                        </tr>
                        <tr>
                            <td><label>已赚收益</label><span>{% @orderInterest  %}</span></td>
                            <td><label>交易日期</label><span>{% @investDetail.invest_created_at %}</span></td>
                        </tr>
                        <tr class="grey">
                            <td><label>到期日期</label><span>{% @investDetail.refund_end_time   %}</span></td>
                            <td ms-if="@investDetail.is_show == 1"><label>赎回申请</label><a ms-attr="{href:'/smart/invest/apply?invest_id='+investId+'&interest='+orderInterest }" class="blue">发起赎回</a></td>

                        </tr>
                    </tbody></table>
                </div>
            
            <h4 class="v4-section-title v4-mt-plus-20"><span></span>项目每日收益情况</h4>
            <div class="v4-tabel-detail-wrap ">
                <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-48">
                    <thead>
                        <tr>
                            <td width="40%">时间</td>
                            <td width="30%">收益</td>
                            <td>已匹配本金</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ms-for="(k, v) in @list">
                            <td>{% @v.recordDate %}</td>
                            <td>{% @v.interestAmount|number(2)  %}</td>
                            <td>{% @v.principal|number(2)       %}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- <h4 class="v4-section-title">暂无回款计划</h4> -->

                <!-- pagination -->
                <div class="v4-table-pagination">
                    <a ms-if="@pager.current_page > 1" href="javascript:void(0)" ms-attr="{'data-url':@pager.prev_page_url}"    class="turn" ms-click="getInvestSmartData($event)">上一页</a>
                    <span ms-for="(k,v) in @pager.view">
                        <a ms-if="@pager.current_page==@v" href="javascript:void(0)" class="active">{% @pager.current_page %}</a>
                        <a ms-if="@pager.current_page!=@v" href="javascript:void(0)" ms-attr="{'data-url':@pager.page_url+@v}"  ms-click="getInvestSmartData($event)">{% @v  %}</a>
                    </span>
                    <a ms-if="@pager.current_page<@pager.last_page" href="javascript:void(0)" ms-attr="{'data-url':@pager.next_page_url}" class="turn" ms-click="getInvestSmartData($event)">下一页</a>
                </div>
            </div>
        </div>

        
    </div>
<!-- account ends -->
<div class="clear"></div>
<input type="hidden" id="investId"  value="<?php echo e($investId); ?>">
<input type="hidden" id="currPage"  value="<?php echo e($page); ?>">
<script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/lib/biz//user/invest_smart.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>