<?php $__env->startSection('title', '充值支付－九斗鱼'); ?>

<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<div class="m-myuser">
    <!-- account begins -->
    <?php echo $__env->make('pc.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="m-content grayborder">
        <div class="m-pagetitle hidden">
            <p class="fl">我要充值</p><p class="fr t-racharge">
                <span></span><a href="javascript:;" id="t-recharge-notice" data-target="modul1">充值须知</a>
            </p>
        </div>
        <div class="t-r-showbox hidden">
            <form action="/jx/recharge/submit" method="post" id="rechargeForm">
                <div class="fl t-recharge5">
                    <p class="t-recharge2"><span>充值金额</span><input type="text" id="recharge-cash" name="cash" autocomplete="off" maxlength="8" class="form-input t-recharge-input" /> 元</p>
                </div>
                <div class="fr t-recharge3">
                    <p>当前可用余额：<span><?php echo e($user['balance']); ?></span>元</p>
                    <p id="lastBalance" style="display:none;">充值后余额：<span class="fontorange t-red" balance="<?php echo e($user['balance']); ?>"><?php echo e($user['balance']); ?></span>元</p>
                </div>
                <div class="clear"></div>
                <p class="t-recharge4"><span></span>温馨提示：<?php echo e(isset($minRecharge) ? $minRecharge : 100); ?> 元起充,单笔充值限额视开户行定</p>
                <div class="t-recharge6">
                    <p class="t-recharge6-1">充值方式</p>
                    <ul class="recharge-method t-recharge-nav">
                        <li data-type="2" class="recharge-width-nav">快捷支付<em></em><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'.$cardInfo['bank_id'].'.png')); ?>" width="25" alt="" /><b><?php echo e($cardInfo['bank_name']); ?> **** <?php echo e(substr($cardInfo['card_no'],-4)); ?></b><span></span></li>
                    </ul>
                </div>
                <div class="clear"></div>

                <p class="t-recharge7"><span></span>每个用户只能选择一张银行卡作为快捷支付卡，一旦支付成功后，将只能提现到该快捷卡。</p>

                <div class="t-recharge6">
                    <p class="t-recharge2"><span>手机号</span><input type="text" id="phone" maxlength="8" class="form-input t-recharge-input" placeholder="请输入银行预留手机号" value="<?php echo e($user['phone']); ?>" name="phone" readonly="true" /> </p>
                </div>

                <div class="t-recharge6">
                    <p class="t-recharge2"><span>验证码</span><input type="text" maxlength="6" class="form-input t-recharge-input" placeholder="请输入短信验证码" name="code"  /></p>
                    <input type="button" value="点击获取" class=" code" id="code">
                </div>

                <div class="clear"></div>
                <div class="recharge-bank-box t-recharge8">
                    <p class="tips mt5 t-recharge-tip" id="cash-tips" style="width:233px; position:static">
                        <?php if(Session::has('errors')): ?> <?php echo e(Session::get('errors')); ?> <?php endif; ?></p>
                    <div class="t-recharge9">
                        <input type="hidden"    name="smsSeq" id="smsSeq" value="" />
                        <input type="hidden"    name="cardNo" value="<?php echo e($cardInfo['card_no']); ?>" id="cardNo">
                        <input type="hidden"    name="_token" value="<?php echo e(csrf_token()); ?>" />
                        <input type="submit"    class="btn btn-red btn-large t-recharge-btn" value="充  值">
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="clearfix"></div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jspage'); ?>
    <script src="<?php echo e(assetUrlByCdn('/static/js/pc2/formCheck.js')); ?> "></script>
    <?php /*<script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/js/pc2/findPwd.js')); ?>"></script>*/ ?>
    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/js/pc2/sendCode.js')); ?>"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        (function($){
            $(document).ready(function(){
                var timeout=0, maxTimeout = 60;
                var desc    = "秒后重发";
                $("#code").click(function(){
                    var  phone = $.trim($("#phone").val());
                    var  cardNo= $.trim($("#cardNo").val());
                    var  type  = 'directRechargeOnline';
                    $.ajax({
                        url : '/jx/api/smsCodeApply',
                        type: 'POST',
                        dataType: 'json',
                        data: {'phone': phone,'type':type,'cardNo':cardNo},
                        success : function(result) {
                            if(result.status) {
                                $("#smsSeq").val(result.data.smsSeq)
                                if(timeout <= 0) {
                                    timeout = maxTimeout;
                                    $("#code").addClass("disable").val(/*sendRes.msg + "," + */timeout + desc).attr("disabled", true);
                                }
                                var timer = setInterval(function() {
                                    timeout--;

                                    if(timeout > 0) {
                                        $("#code").addClass("disable").val(/*sendRes.msg + "," + */timeout + desc);
                                    } else {
                                        $("#code").removeClass("disable").val($("#code").attr("default-value")).attr("disabled", null);
                                        clearInterval(timer);
                                    }

                                }, 1000);

                            } else {
                                //$("#code").addClass("error").val('发送失败');
                                $("#cash-tips").html(result.data.retMsg);
                                //$("#captcha").click();

                            }
                        },
                        error : function(msg) {
                            $("#code").attr("disabled", null);
                            $("#tipMsg").text("服务器端错误，请点击重新获取");
                            //clearInterval(timer);
                        }
                    });
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>