<?php $__env->startSection('title', '交易记录'); ?>

<?php $__env->startSection('content'); ?>

    <div class="v4-account">
        <!-- account begins -->
        <?php echo $__env->make('pc.common.leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php

        $type = isset($data['type']) ? $data['type'] : 'all';

        $activeDate = '';

        if(empty($data['start_time']) && empty($data['end_time'])){
            $activeDate = 'active';
        }


        ?>

        <div class="v4-content v4-account-white">
            <h2 class="v4-account-titlex">交易记录</h2>
            <div class="v4-query-nav">
                <form action="/user/fundhistory" method="get" id="searchFormId">

                    <input type="hidden" name="type" value="<?php echo e($type); ?>"  id="typeId" />
                    <dl>
                        <dt>交易日期:</dt>
                        <dd><a href="javascript:void(0)" class="doSearchFormDate <?php echo $activeDate; ?>">全部</a></dd>
                        <dd class="v4-date-picker">
                            <span><input id="date1" type="text" value="<?php echo e(isset($data['start_time'])? $data['start_time'] :''); ?>" name="start_time" class="v4-date-input" onClick="WdatePicker({maxDate:'#F{$dp.$D(\'date2\')}'})"/><i class="v4-iconfont">&#xe6a7;</i></span>
                            -
                            <span><input id="date2" type="text" value="<?php echo e(isset($data['end_time'])? $data['end_time'] :''); ?>" name="end_time" class="v4-date-input" onClick="WdatePicker({minDate:'#F{$dp.$D(\'date1\')}'})"/><i class="v4-iconfont">&#xe6a7;</i></span>

                            <a href="javascript:;" id="doSearchForm" class="v4-btn-text">查询</a>
                        </dd>
                    </dl>
                </form>

                <dl>
                    <dt>交易状态:</dt>
                    <dd><a href="javascript:void(0)" typeVal="all" class="doSearchForm <?php echo ($type== 'all') ? 'active' : ''; ?>">全部</a></dd>
                    <dd><a href="javascript:void(0)" typeVal="invest" class="doSearchForm <?php echo ($type == 'invest') ? 'active' : ''; ?>">出借</a></dd>
                    <dd><a href="javascript:void(0)" typeVal="refund" class="doSearchForm <?php echo ($type == 'refund') ? 'active' : ''; ?>">回款</a></dd>
                    <dd><a href="javascript:void(0)" typeVal="recharge" class="doSearchForm <?php echo ($type == 'recharge') ? 'active' : ''; ?>">充值</a></dd>
                    <dd><a href="javascript:void(0)" typeVal="withdraw" class="doSearchForm <?php echo ($type == 'withdraw') ? 'active' : ''; ?>">提现</a></dd>
                    <dd><a href="javascript:void(0)" typeVal="reward" class="doSearchForm <?php echo ($type == 'reward') ? 'active' : ''; ?>">奖励</a></dd>
                    <dd><a href="javascript:void(0)" typeVal="other" class="doSearchForm <?php echo ($type == 'other') ? 'active' : ''; ?>">其他</a></dd>
                </dl>
            </div>


            <div class="v4-table-wrap v4-mt-20">
                <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left">
                    <thead>
                    <tr>
                        <td width="200">交易日期</td>
                        <td width="140">交易类型</td>
                        <td width="140">收/支金额</td>
                        <td width="140">可用余额</td>
                        <td>详情</td>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if( !empty($list) ): ?>
                        <?php foreach( $list as $fund ): ?>
                            <tr>
                                <td><?php echo e($fund['created_at']); ?></td>
                                <td><?php echo e($fund['event_id_type']); ?></td>
                                <td class="m-bluefont"><?php echo e(number_format($fund['balance_change'] ,2,'.',',')); ?></td>
                                <td><?php echo e(number_format($fund['balance'] ,2,'.',',')); ?></td>
                                <td><?php echo e(empty($fund['note']) ? $fund['event_id_label'] : $fund['note']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="v4-table-none">暂无记录</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- pagination -->
            <div class="v4-table-pagination">
                <?php echo $__env->make('scripts/paginate', ['paginate'=>$paginate], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

        </div>
    </div>
    <!-- account ends -->
    <div class="clear"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jspage'); ?>
    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('static/js/My97DatePicker/WdatePicker.js')); ?>"></script>
    <script>

        (function ($) {

            function checkTime(a, b) {
                var a = new Date(a).getTime();
                var b = new Date(b).getTime();
                if(b >= a){
                    return true;
                }
                return false;
            }
            
            
            $('#doSearchForm').click(function () {
                $('#searchFormId').submit();
                return false;
            });

            $('.doSearchForm').click(function () {
                var $type       = $(this).attr('typeVal');
                $('#typeId').val($type);

                $('#searchFormId').submit();

                return false;
            });

            $('.doSearchFormDate').click(function () {
                $('#date1').val('');
                $('#date2').val('');

                $('#searchFormId').submit();

                return false;
            });


            // 日历插件使用文档 http://www.my97.net/demo/index.htm
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>