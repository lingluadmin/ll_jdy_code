<?php $__env->startSection('title', '用户提现－九斗鱼'); ?>

<?php $__env->startSection('content'); ?>


<div class="v4-account">
    <!-- account begins -->
    <?php echo $__env->make('pc4.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">提现</h2>
        <div class="v4-account-rapid-info-wrap">
            <div class="v4-account-info"><span>账户余额(元)</span><big><?php echo e($userInfo['balance']); ?></big></div>
            <span id="minMoney"         data-value="<?php echo e(isset($minMoney) ? $minMoney : 100); ?>"></span>
            <span id="freeAmount"       data-value="<?php echo e(isset($userInfo['balance']) ? $userInfo['balance'] : 0); ?>"></span>
            <span id="needHandling"     data-value="<?php echo e(isset($commission) ? $commission : 0); ?>"></span>
            <span id="withDrawNum"      data-value="<?php echo e(isset($withDrawNum) ? $withDrawNum : 0); ?>"></span>
            <span id="withDrawFreeNum"  data-value="<?php echo e(isset($maxFreeNum) ? $maxFreeNum : 0); ?>"></span>
            <div class="v4-account-info">
                <span>绑定银行卡</span>
                <div class="v4-account-card">
                    <p class="cardNum"><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'.$withdrawCard[0]['bank_id'].'.png')); ?>" class="v4-bank-icon"><?php echo e(App\Http\Models\Bank\CardModel::getBankName($withdrawCard[0]['bank_id'])); ?>  <?php echo e(substr($withdrawCard[0]['card_no'],0,4)); ?>****<?php echo e(substr($withdrawCard[0]['card_no'],-4)); ?></p>
                    <p class="limited">限额：5万/笔，20万/日</p>
                </div>

            </div>
            <form action="/jx/withdraw/submit" id="withdrawFrom" method="post">
                <dl class="v4-input-group">
                    <dt>
                        <label for="bankcard">提现金额</label>
                    </dt>
                    <dd>
                        <input  value="" placeholder="请输入提现金额，最低100元" id="withdrawCash" data-pattern="amountwithdraw" class="v4-input" name="withdraw_cash">
                        <span   class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                        <p      class="v4-fee-tip">提现手续费：<span class="v4-fee-num"><?php echo e($commission); ?></span></p>
                    </dd>

                    <dt>
                        <label for="bankcard">银行联行号</label>
                    </dt>
                    <dd>
                        <input  value="" placeholder="大额提现，请输入联行号" id="cardBankCnaps"  class="v4-input" name="cardBankCnaps">
                        <p      class="v4-fee-tip">联行号查询：<a href="http://lianhanghao.com" target="_blank">http://lianhanghao.com</a></p>
                    </dd>

                    <dt>
                        &nbsp;
                    </dt>
                    <dd>
                        <input  type="hidden"   name="_token"   value="<?php echo e(csrf_token()); ?>">

                        <div id="v4-input-msg"  class="v4-input-msg"><?php if(Session::has('errors')): ?> <?php echo e(Session::get('errors')); ?> <?php endif; ?></div>

                        <input type="submit"    class="v4-input-btn" value="确认提现">
                    </dd>
                </dl>

            </form>
        </div>
        <div class="v4-user-warm-tip">
            <p>温馨提示：</p>
            <p>1.每位用户每自然月有4次免费提现机会，超过4次以后的每笔提现将收5元手续费；</p>
            <p>2.单笔提现金额100元起；</p>
            <p>3.周末和法定节假日期间，用户可申请提现，将在假期后的第一个工作日进行处理，不便之处，敬请谅解！</p>
            <p>4.提现时，只支持提现到借记卡，不能提现到信用卡；</p>
            <p>5.提现流程全部由第三方存管账户代为管理，单笔代付不超过5万，当提现金额超过5万，将分为多笔到账，请知晓。</p>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jspage'); ?>

<script>
$(function(){
    // 检验输入框内容
    // $.validation('.v4-input');

    var needHandling    = parseInt($("#needHandling").attr('data-value'));
    var withDrawNum     = parseInt($("#withDrawNum").attr('data-value'));
    var withDrawAllNum  = parseInt($("#withDrawFreeNum").attr('data-value'));

    var minMoney        = $("#minMoney").attr("data-value");
    var freeAmount      = $("#freeAmount").attr("data-value");
    var withdrawFeeRate = $("#withdrawFeeRate").attr("data-value");
    var balance         = $("#balance").attr("value");

    $("#withdrawCash").blur(function() {
        $(this).formatInput(/^[0-9]+([.][0-9]{0,2})?$/);
        var cash    = $("#withdrawCash").val();

        var desc    = "(本月已经免费提现"+withDrawNum+"笔,剩余"+(withDrawAllNum-withDrawNum)+"次免费提现机会)";
        //需要手续费
        if( needHandling > 0 || withDrawAllNum-withDrawNum <= 0 ){
            desc    = "(本月已经免费提现"+withDrawAllNum+"笔,当前提现将收取"+needHandling+"元手续费)";
        }
        if(Number(cash) >= minMoney){
            $('.v4-fee-num').html(needHandling + "元 " + desc);
        }
        cashValitate()
    });

    // 金额验证
    function cashValitate() {

        var cash    = $("#withdrawCash").val();

        if( !cash ) {
            $(".v4-input-msg").html(minMoney + "元起提现，请输入提现金额");
            $(".v4-input-status").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else if( Number(cash) < minMoney ){
            $('.v4-input-msg').html("提现不小于" + minMoney +"元");
            $(".v4-input-status").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else if( Number(cash) > freeAmount ) {
            $(".v4-input-msg").html("账户余额不足");
            $(".v4-input-status").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else {
            $(".v4-input-msg").html("");
            $(".v4-input-status").find('i').removeClass('error').html('&#xe69f;').data('error','');
            return true;
        }
    }


    // 表单提交验证
    $("#withdrawFrom").bind('submit',function(){
        if(!cashValitate()) return false;
    });
})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc4.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>