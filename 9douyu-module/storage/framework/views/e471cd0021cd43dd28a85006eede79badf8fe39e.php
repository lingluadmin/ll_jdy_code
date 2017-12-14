<?php $__env->startSection('title', '回款日历'); ?>

<?php $__env->startSection('content'); ?>

<div class="v4-account">
    <!-- account begins -->
    <?php echo $__env->make('pc.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="v4-content">
        <div class="v4-account-white">
            <h2 class="v4-account-titlex">回款日历</h2>

            <form action="<?php echo e(url('/user/refundPlan')); ?>" method="post"  id="calendar-form">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" name="year" value="<?php echo e($year); ?>">
                <input type="hidden" name="month" value="<?php echo e($month); ?>">
              <div class="v4-calendar-caption clearfix">
                  <?php /*<span class="date"><?php echo e($dateStr); ?></span>
                  <div class="select-wrap">
                      <select name="year" id="">
                      <?php for($y=date('Y')+1;$y>=2014;$y--): ?>
                          <option value="<?php echo e($y); ?>" <?php if($y==$year): ?> selected <?php endif; ?>><?php echo e($y); ?></option>
                      <?php endfor; ?>
                      </select>
                      <select name="month" id="">
                      <?php for($m=12;$m>=1;$m--): ?>
                          <option value="<?php echo e(sprintf('%02d', $m)); ?>" <?php if($m==$month): ?> selected <?php endif; ?>><?php echo e(sprintf('%02d', $m)); ?>月</option>
                      <?php endfor; ?>
                      </select>
                      <input type='submit' class="v4-btn-text" value='查询'/>
                  </div>*/ ?>
                    <div class="v4-calendar-time">
                      <span class="v4-calendar-time-left" data-year="<?php echo e($prev_year); ?>" data-month="<?php echo e($prev_month); ?>"></span><em><?php echo e($dateStr); ?></em><span class="v4-calendar-time-right" data-year="<?php echo e($next_year); ?>" data-month="<?php echo e($next_month); ?>"></span>
                      <a href="javascript:;" class="v4-calendar-btn" data-year="<?php echo e(date('Y')); ?>" data-month="<?php echo e(date('m')); ?>">返回今天</a>
                    </div>
              </div>
            </form>

<?php echo $__env->make('pc.common.calendar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
           <ul class="v4-calendar-footer clearfix">
               <li>
                   <span class="active-incomplete">•</span><?php echo e($refund_amount_data['refunded_cash_note']); ?><em><?php echo e($refund_amount_data['refunded_cash']); ?> <?php echo e($refund_amount_data['refund_amount_unit']); ?></em>
               </li>
                <li>
                   <span class="active-uncomplete">•</span><?php echo e($refund_amount_data['refund_cash_note']); ?><em><?php echo e($refund_amount_data['refund_cash']); ?> <?php echo e($refund_amount_data['refund_amount_unit']); ?></em>
               </li>
           </ul>
       </div>

       <div class="v4-account-white v4-mt-15">
           <div class="v4-table-wrap">
               <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-48">
                   <thead>
                       <tr>
                           <td>回款日期</td>
                           <td>项目名称</td>
                           <td>回款状态</td>
                           <td>回款金额</td>
                           <td>回款期数</td>
                           <td>交易状态</td>
                       </tr>
                   </thead>
                   <tbody>
                    <?php if(!empty($month_refund_list)): ?>
                    <?php foreach($month_refund_list as $key=>$value): ?>
                       <tr>
                           <td><?php echo e($value['times']); ?></td>
                           <td><span class="v4-text-ellips"><?php echo e(\App\Tools\ToolStr::hideStr( $value['project_name'], 15, '...')); ?> <?php echo e($value['format_name']); ?> </span></td>
                           <td><?php echo e($value['type'] == 1 ? '加息奖励' : ($value['principal'] == 0 ? '利息' : '本金+利息')); ?></td>
                           <td><?php echo e(\App\Tools\ToolMoney::moneyFormat($value['cash'])); ?></td>
                           <td>第<?php echo e($value['current_periods']); ?>/<?php echo e($value['periods']); ?>期</td>
                           <td><?php if($value['status'] == 200): ?> 已回款 <?php else: ?> 未回款 <?php endif; ?></td>
                       </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr><td colspan="6" class="v4-table-none">暂无数据</td></tr>
                    <?php endif; ?>
                   </tbody>
               </table>
            </div>
        <?php echo $__env->make('pc.common.paginate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
       </div>

</div>
    <div class="clearfix"></div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jspage'); ?>
<script>
        (function($){
            $(document).ready(function(){

               $("#datetimepicker3").on("click",function(e){
                    e.stopPropagation();
                    $(this).lqdatetimepicker({
                        css : 'datetime-day',
                        dateType : 'D',
                        selectback : function(){

                        }
                    });

                });
            $('.v4-calendar-time-left, .v4-calendar-time-right, .v4-calendar-btn').on("click",function(e){
                    var year = $(this).attr('data-year');
                    var month = $(this).attr('data-month');
                    $("input[name=year]").val(year);
                    $("input[name=month]").val(month);
                    $("#calendar-form").submit();
            });

            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>