<?php $__env->startSection('title', '出借记录'); ?>

<?php $__env->startSection('csspage'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="v4-account" >
        <!-- account begins -->
        <?php echo $__env->make('pc.common.leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="v4-content v4-account-white ms-controller" ms-controller="InvestSmartMatch">
            <h2 class="v4-account-titlex">出借记录</h2>
            <h4 class="v4-section-title pr"><span></span>资金匹配情况<a ms-attr="{href:'/user/invest/smartDetail?record_id=' + investId }" class="v4-section-detail-right">返回></a></h4>
            
            <div class="v4-tabel-detail-wrap">
                <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-28 ">
                    <thead>
                        <tr>
                            <td width="15%">债权编号</td>
                            <td width="13%">借款人姓名</td>
                            <td width="20%">身份证号</td>
                            <td width="14%">债权到期日</td>
                            <td width="13%">匹配金额</td>
                            <td width="14%">匹配日期</td>
                            <td>状态</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ms-for="(k, v) in @list">
                            <td>{% @v.contractNo %}</td>
                            <td>{% @v.loanName|truncate(2,'*')  %}</td>
                            <td>{% @v.loanCard  %}</td>
                            <td>{% @v.endDate|date("yyyy-MM-dd")    %}</td>
                            <td>{% @v.matchAmount|number(2)         %}</td>
                            <td>{% @v.matchDate|date("yyyy-mm-dd")  %}</td>
                            <td>{% @v.status_note  %}</td>
                        </tr>
                        <tr ms-for="(k, v) in @list">
                            <td>{% @v.contractNo %}</td>
                            <td>{% @v.loanName|truncate(2,'*')  %}</td>
                            <td>{% @v.loanCard  %}</td>
                            <td>{% @v.endDate|date("yyyy-MM-dd")    %}</td>
                            <td>{% @v.matchAmount|number(2)         %}</td>
                            <td>{% @v.matchDate|date("yyyy-mm-dd")  %}</td>
                            <td>{% @v.status_note  %}</td>
                        </tr>


                    </tbody>
                </table>
            </div>

            <div class="v4-table-pagination">
                <a ms-if="@pager.current_page > 1" href="javascript:void(0)" ms-attr="{'data-url':@pager.prev_page_url}"    class="turn" ms-click="getInvestSmartMatchData($event)">上一页</a>
                <span ms-for="(k,v) in @pager.view">
                    <a ms-if="@pager.current_page==@v" href="javascript:void(0)" class="active">{% @pager.current_page %}</a>
                    <a ms-if="@pager.current_page!=@v" href="javascript:void(0)" ms-attr="{'data-url':@pager.page_url+@v}"  ms-click="getInvestSmartMatchData($event)">{% @v  %}</a>
                </span>
                <a ms-if="@pager.current_page<@pager.last_page" href="javascript:void(0)" ms-attr="{'data-url':@pager.next_page_url}" class="turn" ms-click="getInvestSmartMatchData($event)">下一页</a>
            </div>

      </div>

        
    </div>
<!-- account ends -->
<div class="clear"></div>

<input type="hidden" id="investId"  value="<?php echo e($investId); ?>">
<input type="hidden" id="currPage"  value="<?php echo e($page); ?>">
<script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/lib/biz//user/invest_smart_match.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>