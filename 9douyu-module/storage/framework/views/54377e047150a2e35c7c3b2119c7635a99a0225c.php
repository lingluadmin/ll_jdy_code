<?php $__env->startSection('title', '充值支付－九斗鱼'); ?>

<?php $__env->startSection('content'); ?>

<div class="v4-account">
    <!-- account begins -->
    <?php echo $__env->make('pc.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">提现</h2>
        <div class="v4-account-rapid-info-wrap">
            <span id="minMoney"         data-value="<?php echo e(isset($minMoney) ? $minMoney : 0); ?>"></span>
            <span id="freeAmount"       data-value="<?php echo e(isset($userInfo['balance']) ? $userInfo['balance'] : 0); ?>"></span>
            <span id="needHandling"     data-value="<?php echo e(isset($commission) ? $commission : 5); ?>"></span>
            <span id="withDrawNum"      data-value="<?php echo e(isset($withDrawNum['total']) ? $withDrawNum['total'] : 0); ?>"></span>
            <span id="withDrawFreeNum"  data-value="<?php echo e(isset($maxFreeNum) ? $maxFreeNum : 0); ?>"></span>

            <div class="v4-account-info"><span>账户余额(元)</span><big><?php echo e(isset($userInfo['balance']) ? $userInfo['balance'] : 0); ?></big></div>
            <div class="v4-account-info v4-mt-50">
                <span>绑定银行卡</span>
                <div class="v4-account-card">
                    <p class="cardNum"><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'.$withdrawCard[0]['bank_id'].'.png')); ?>" class="v4-bank-icon"><?php echo e(App\Http\Models\Bank\CardModel::getBankName($withdrawCard[0]['bank_id'])); ?>  <?php echo e(substr($withdrawCard[0]['card_no'],0,4)); ?>****<?php echo e(substr($withdrawCard[0]['card_no'],-4)); ?></p>
                    <?php /*<p class="limited">限额：5万/笔，20万/日</p> */ ?>
                </div>
                                         
            </div>

            <dl class="v4-input-group">
                <dt>
                    <label for="bankcard">提现金额</label>
                </dt>
                <dd class="v4-relative">
                    <input placeholder="请输入提现金额，最低100元" data-pattern="amountwithdraw" class="v4-input" name="withdraw_cash" id="withdrawCash">
                    <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    <div class="v4-fee-tip">提现手续费：<span class="v4-fee-num"><?php echo e(isset($commission) ? $commission : 0.00); ?></span></div>
                </dd>
                <dt>
                    <label for="paypassword">支付密码</label>
                </dt>
                <dd>
                    <input type="password" placeholder="请输入支付密码" id="trading_password"  name="trading_password" data-pattern="password" class="v4-input">
                    <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                </dd>

                <dt>
                    &nbsp;
                </dt>
                <dd>
                    <div id="v4-input-msg" class="v4-input-msg"><?php if(Session::has('errors')): ?><?php echo e(Session::get('errors')); ?><?php endif; ?></div>
                    <input type="hidden"    name="from"     value="pc"  id="from">
                    <input type="hidden"    name="version"  value=""    id="version">
                    <input type="hidden"    name="card_no"  value="<?php echo e(isset($withdrawCard[0]['card_no']) ? $withdrawCard[0]['card_no'] : null); ?>" id="cardNo">
                    <input type="hidden"    name="bank_id"  value="<?php echo e(isset($withdrawCard[0]['bank_id']) ? $withdrawCard[0]['bank_id'] : null); ?>" id="bankId">
                    <input type="hidden"    name="_token"   value="<?php echo e(csrf_token()); ?>">
                    <button id="preWithdraw" class="v4-input-btn">确认提现</button>
                </dd>
            </dl>
                

        </div>
        <div class="v4-user-warm-tip">
            <p>提现须知：</p>
            <p>1.每位用户每自然月有<?php echo e($maxFreeNum); ?>次免费提现机会，超过<?php echo e($maxFreeNum); ?>次以后的每笔提现将收<?php echo e($commission); ?>元手续费。</p>
            <p>2.单笔提现金额<?php echo e($minMoney); ?>元起。</p>
            <p>3.提现到账：收到您的提现申请后，预计下一工作日到账，如遇双休日和法定节假日顺延，实际到账时间依据提现银行而有所差异。</p>
            <p>4.提现时，只支持提现到借记卡，不能提现到信用卡。</p>
            <p>5.九斗鱼提现全部由第三方支付公司“网银在线”代付，单笔代付不超过5万，当提现金额超过5万，将分为多笔到账，请知晓。</p>
        </div>
     
    </div>
</div>
<!-- 提现弹窗 -->
<div class="v4-layer_wrap js-mask" data-modul="modul0"  style="display:none;" id="preWithdrawShow">
    <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
    <div class="Js_layer v4-layer">
       <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
       <p class="v4-pop-confirm-tip">提现确认</p>
        <div class="v4-layer-widthdraw">
            <div class="v4-account-holder">
                <p><label>提现金额</label><span   id="showCash"></span></p>
                <p><label>提现手续费</label><span id="showHandleFee"></span></p>
                <p><label>实际到账</label><span   id="showRealCash"></span></p>
                <p><label>剩余免费提现次数</label><span id="showFreeNum"></span></p>
            </div> 
            <div class="v4-pop-doublebtn-wrap">
                <a href="javascript:;"      class="v4-input-btn" id="confirmSubmit">继续提现</a>
                <a href="/project/index"    class="v4-input-btn" id="">马上投资</a>
            </div>
            
        </div>
    </div>
</div>
<!-- 提现弹窗 -->
<div class="v4-layer_wrap js-mask1" data-modul="modul1"  style="display:none;" id="withdrawResult">
    <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
    <div class="Js_layer v4-layer">
        <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask1"></a>
        <div class="v4-layer_0">
            <p class="v4-layer-normal-icon v4-layer-success-icon"><i class="v4-icon-20 v4-iconfont">&#xe69f;</i></p>
            <p class="v4-layer_text">您的提现申请已提交！</p>
            <p class="v4-layer-withdraw-tip">提现时间为T+1（节假日顺延）</p>
            <a href="/user" class="v4-input-btn" id="">完成</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jspage'); ?>
<script>
$(function(){
    // 检验输入框内容
    // $.validation('.v4-input');

    // 表单提交验证
    // $("#withdrawFrom").bind('submit',function(){
    //    if(!$.formSubmitF('.v4-input',{
    //        fromT:'#withdrawFrom'
    //    })) return false;
    //});
    var needHandling    = parseInt($("#needHandling").attr('data-value'));
    var minMoney        = $("#minMoney").attr("data-value");
    var freeAmount      = $("#freeAmount").attr("data-value");

    var withDrawNum     = parseInt($("#withDrawNum").attr('data-value'));
    var withDrawFreeNum = parseInt($("#withDrawFreeNum").attr('data-value'));

    $("#withdrawCash").blur(function() {
        $(this).formatInput(/^[0-9]+([.][0-9]{0,2})?$/);
//        var cash    = $("#withdrawCash").val();
//        var desc    = "(本月已经免费提现"+withDrawNum+"笔,剩余"+(withDrawFreeNum-withDrawNum)+"次免费提现机会)";
//        //需要手续费
//        if( needHandling > 0 || withDrawFreeNum-withDrawNum <= 0 ){
//            desc    = "(本月已经免费提现"+withDrawAllNum+"笔,当前提现将收取"+needHandling+"元手续费)";
//        }
//        if(Number(cash) >= minMoney){
//            $('.v4-fee-num').html(needHandling + "元 " + desc);
//        }
        cashValitate()
    });


    // check data
    function  cashValitate() {

        var cash    = $("#withdrawCash").val();
        cash        = parseInt(cash);

        if( !cash ) {
            $(".v4-input-msg").html(minMoney + "元起提现，请输入提现金额");
            //$(".v4-input-status").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else if( Number(cash) < minMoney ){
            $('.v4-input-msg').html("提现不小于" + minMoney +"元");
            //$(".v4-input-status").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else if( Number(cash) > freeAmount ) {
            $(".v4-input-msg").html("账户余额不足");
            //$(".v4-input-status").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else {
            $(".v4-input-msg").html("");
            // $(".v4-input-status").find('i').removeClass('error').html('&#xe69f;').data('error','');
            return true;
        }
    }

    function passwordValitate() {
        var password= $("#trading_password").val();
        var pattern = /^(?![0-9]+$)(?![a-z]+$).{6,16}$/i;
        //var pattern = /^[0-9]{6}$/i;
        if(!password) {
            $(".v4-input-msg").html("请输入交易密码");
            return false;
        } else if(password.length < 6){
            $(".v4-input-msg").html("交易密码不少于6位");
            return false;
        } else if(!password.match(pattern)){
            $(".v4-input-msg").html("6到16位的字母及数字组合");
            return false;
        } else {
            $(".v4-input-msg").html("");
            return true;
        }
    }



    $("#preWithdraw").click(function(){
        //TODO: 验证提现信息
        if( cashValitate() && passwordValitate() ){
            //TODO: 预览提现信息
            var cash        = $("#withdrawCash").val();
            var real_cash   = cash - needHandling;

            // 剩余免费次数
            var surplus_num = withDrawFreeNum-withDrawNum;
            if( surplus_num <= 0 ){
                surplus_num = 0;
            }

            $("#showCash").html(cash);
            $("#showHandleFee").html(needHandling);
            $("#showRealCash").html(real_cash);
            $("#showFreeNum").html(surplus_num);

            $("#preWithdrawShow").show();

        }
    });

    $("#confirmSubmit").click(function(){
        var  withdraw_cash      = $.trim($("#withdrawCash").val());
        var  trading_password   = $.trim($("#trading_password").val());
        var  card_no    = $.trim($("#cardNo").val());
        var  bank_id    = $.trim($("#bankId").val());
        var  from       = $.trim($("#from").val());
        var  version    = $.trim($("#version").val());

        $.ajax({
            url : '/pay/withdraw/ajaxSubmit',
            type: 'POST',
            dataType: 'json',
            data: {'withdraw_cash': withdraw_cash,'trading_password':trading_password,'bank_id':bank_id, 'card_no':card_no,'from':from,'version':version},
            success : function( result ) {
                $("#preWithdrawShow").hide();
                if( result.status == 'success') {
                    $("#withdrawResult").show();
                    return true;
                } else {
                    $("#v4-input-msg").html(result.msg);
                    return false;
                }
            },
            error : function(msg) {
                $("#v4-input-msg").html("服务器端错误，请重新操作");
                return false;
            }
        });
    });

})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>