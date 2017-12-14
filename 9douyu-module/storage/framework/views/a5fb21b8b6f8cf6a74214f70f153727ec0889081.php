<?php $__env->startSection('title', '充值支付－九斗鱼'); ?>

<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<div class="v4-account">
    <!-- account begins -->
    <?php echo $__env->make('pc4.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="v4-content v4-account-white">
        <ul class="v4-user-tab clearfix">
            <li class="active"><a href="/jx/recharge">快捷充值</a></li>
            <li><a href="/jx/transfer">转账充值</a></li>
        </ul>
        <div class="v4-account-rapid-info-wrap">
            <div class="v4-account-info"><span>账户余额(元)</span><big><?php echo e(isset($user['balance']) ? $user['balance'] : 0); ?></big></div>
            <div class="v4-account-info">
                <span>绑定银行卡</span>
                <div class="v4-account-card">
                    <p class="cardNum"><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'.$cardInfo['bank_id'].'.png')); ?>" class="v4-bank-icon"><?php echo e($cardInfo['bank_name']); ?> <?php echo e(substr($cardInfo['card_no'],0,4)); ?>****<?php echo e(substr($cardInfo['card_no'],-4)); ?></p>
                    <p class="limited">限额：5万/笔，20万/日</p>
                </div>
                                         
            </div>
            <form action="/jx/recharge/submit" id="rapidFrom" method="post">
                <dl class="v4-input-group">
                    <dt>
                        <label for="bankcard">充值金额</label>
                    </dt>
                    <dd>
                        <input value="" placeholder="请输入充值金额，最低100元"  data-pattern="amountrecharge" class="v4-input" name="recharge_cash" id="rechargeCash">
                        <span class="v4-input-status i-cash"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>

                    <dt>
                        <label>手机号码</label>
                    </dt>
                    <dd>
                        <input class="v4-input" value="<?php echo e($user['phone']); ?>" id="phone" name="phone" readonly="true" />
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>

                    <dt>
                        <label>手机验证码</label>
                    </dt>
                    <dd>
                        <input name="code"      class="v4-input v4-input-short"     data-pattern="phonecode" placeholder="请输入验证码"  id="code">
                        <input name="smsCode"   class="v4-input-code"  type="button" id="smsCode" value="获取验证码" default-value="获取验证码" >
                        <span class="v4-input-status i-code"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>
                    <dt>
                        &nbsp;
                    </dt>
                    <dd>

                        <div id="v4-input-msg" class="v4-input-msg"><?php if(Session::has('errors')): ?> <?php echo e(Session::get('errors')); ?> <?php endif; ?></div>
                        <input type="hidden"    name="minRecharge" id="minRecharge" value="<?php echo e($minRecharge); ?>" />
                        <input type="hidden"    name="smsSeq" id="smsSeq" value="" />
                        <input type="hidden"    name="cardNo" value="<?php echo e($cardInfo['card_no']); ?>" id="cardNo">
                        <input type="hidden"    name="_token" value="<?php echo e(csrf_token()); ?>" />

                        <input type="submit" class="v4-input-btn" value="确认充值" >
                    </dd>
                </dl>
                
            </form>
        </div>
        <div class="v4-user-warm-tip">
            <p>温馨提示：</p>
            <p>1.每日充值限额以绑定银行卡的限额为准，单笔最低1元起充。</p>
            <p>2.严禁银行卡盗刷违法行为，一经查实，将采取账号冻结处理，并移交公安机关。</p>
            <p>3.为保证用户安全，江西银行电子交易账户采用同卡进出规则，既您账户内的资金只能提现至您的绑定银行卡；同时，当您的江西银行电子账户余额为零且债权全部结清时，才可申请更换绑定银行卡。</p>
            <p>4.点击确认充值按钮，表示您已经仔细阅读并同意以上资金存管规定条款。</p>
        </div>
    </div>
</div>
    <?php /*
    <!-- 快速充值弹窗 -->
    <div class="v4-layer_wrap js-mask" data-modul="modul0"  style="display:block;" id="">
        <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
        <div class="Js_layer v4-layer">
            <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
            <div class="v4-layer_0">
                <p class="v4-layer-normal-icon"><i class="v4-icon-20 iconfont">&#xe696;</i></p>
                <p class="v4-layer_text">请您在新打开的页面完成充值</p>
                <p class="v4-layer-withdraw-tip">充值完成前请不要关闭此窗口</p>
                <a href="#" class="v4-btn v4-btn-primary v4-layer-btn" id="">查看结果</a>
                <a href="javascript:;" class="v4-layer-withdraw-question">充值遇到问题？</a>
            </div>
        </div>
    </div>
    */ ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jspage'); ?>

<script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/js/pc2/sendCode.js')); ?>"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){
    // 检验输入框内容
    // $.validation('.v4-input');

    var minRecharge = $("#minRecharge").val()
    var maxRecharge = 5000000

    $("#rechargeCash").blur(function() {

        $(this).formatInput(/^[0-9]{1,}$/);

        cashValitate()
    });

    // check data
    function  cashValitate() {

        var cash    = $("#rechargeCash").val();

        if( !cash ) {
            $(".v4-input-msg").html(minRecharge + "元起充，请输入充值金额");
            $(".i-cash").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else if( Number(cash) < minRecharge ){
            $('.v4-input-msg').html("充值金额不小于" + minRecharge +"元");
            $(".i-cash").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else if( Number(cash) > maxRecharge ) {
            $(".v4-input-msg").html("充值金额不大于"+maxRecharge+"元");
            $(".i-cash").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        } else {
            $(".v4-input-msg").html("");
            $(".i-cash").find('i').removeClass('error').html('&#xe69f;').data('error','');
            return true;
        }
    }


    $("#code").blur(function() {
        var code        = $("#code").val()
        var pattenCode  = /^\d{4,8}$/;
        if( ! pattenCode.test( code ) ){
            $(".v4-input-msg").html("请输入4~8位短信验证码");
            $(".i-code").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        }
        // $(this).formatInput(/^[4-9]{1,8}$/);

        checkCode()
    });


    function checkCode() {

        var code    = $("#code").val()
        if(!code){
            $(".v4-input-msg").html("请输入短信验证码");
            $(".i-code").find('i').addClass('error').html('&#xe69d;').data('error','error');
            return false;
        }else{
            $(".v4-input-msg").html("");
            $(".i-code").find('i').removeClass('error').html('&#xe69f;').data('error','');
            return true;
        }

    }
    // 表单提交验证
    $("#rapidFrom").bind('submit',function(){
        // if(!$.formSubmitF('.v4-input',{
        //    fromT:'#rapidFrom'
        // })) return false;
        if(!cashValitate() || !checkCode()) return false;

    });

    $(document).ready(function(){
        var timeout     = 0
        var maxTimeout  = 60;
        var desc        = "秒后重发";

        $("#smsCode").click(function(){
            var  phone  = $.trim($("#phone").val());
            var  cardNo = $.trim($("#cardNo").val());
            var  type   = 'directRechargeOnline';
            $.ajax({
                url : '/jx/api/smsCodeApply',
                type: 'POST',
                dataType: 'json',
                data: {'phone': phone, 'type':type, 'cardNo':cardNo},
                success : function( result ) {
                    if( result.status ) {
                        $("#smsSeq").val(result.data.smsSeq)
                        if( timeout <= 0 ) {
                            timeout = maxTimeout;
                            $("#smsCode").addClass("disable").val(/*sendRes.msg + "," + */timeout + desc).attr("disabled", true);
                        }
                        var timer   = setInterval(function() {

                            timeout--;

                            if( timeout > 0 ) {

                                $("#smsCode").addClass("disable").val(/*sendRes.msg + "," + */timeout + desc);

                            } else {

                                $("#smsCode").removeClass("disable").val($("#smsCode").attr("default-value")).attr("disabled", null);

                                clearInterval(timer);
                            }

                        }, 1000);

                    } else {

                        $("#v4-input-msg").html(result.data.retMsg);

                    }
                },
                error : function(msg) {
                    $("#smsCode").attr("disabled", null);
                    $("#v4-input-msg").html("服务器端错误，请点击重新获取");
                    //clearInterval(timer);
                }
            });
        });
    });

})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc4.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>