<?php $__env->startSection('header'); ?>
    <div class="wrap">
        <div class="login-header">
            <a href="/"><img src="<?php echo e(assetUrlByCdn('/static/images/new/logo-login-replace.png')); ?>" width="144" height="80"></a><span>江西银行</span>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', '电子账户-密码重置'); ?>

<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <div class="t-wrap t-mt30px">
        <div class="t-account1">
            <h3 class="t-accout-title"><span></span>电子账户-密码重置</h3>
            <form method="post" action="" id="findPasswordForm">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                <dl class="t-accout-2">
                    <dt class="t-lh36px">手机号</dt>
                    <dd><input type="text"  name="phone" id="phone" autocomplete="off" placeholder="请输入手机号码" class="form-input t-a-1" value="<?php echo e($phone); ?>" disabled/></dd>
                </dl>
                <dl class="t-accout-2">
                    <dt class="t-lh36px">手机验证码</dt>
                    <dd><input type="text" name="smsCode" id="smsCode" placeholder="请输入验证码" class="form-input t-a-1"/>
                        <span class="t-account-img"><input id="code" class="code" type="button" default-value="免费获取验证码" value="免费获取验证码"></span>
                        <!-- <span class="t-account-img">重新发送</span>
                        <span class="t-account-img t-account-img2">60s后重新发送</span>   -->
                    </dd>
                </dl>
                <div class="t-login4 login_notice_msg " id="login_notice_msg" style="text-align: center">
                    <?php if(Session::has('errorMsg')): ?>
                        <?php echo e(Session::get('errorMsg')); ?>

                    <?php endif; ?>
                </div>

                <p class="tc t-pb100px"><input type="submit" class="btn btn-blue btn-large t-w236px" value="下一步"/>
                </p>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jspage'); ?>
    <script src="<?php echo e(assetUrlByCdn('/static/js/pc2/formCheck.js')); ?> "></script>
<?php /*    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/js/pc2/findPwd.js')); ?>"></script>*/ ?>
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
                    var  type  = 'passwordResetPlus';
                    $.ajax({
                        url : '/jx/api/smsCodeApply',
                        type: 'POST',
                        dataType: 'json',
                        data: {'phone': phone,'type':type},
                        success : function(result) {
                            sendRes = result;
                            if(sendRes.status) {
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

                                //$("#code").addClass("error").val(sendRes.msg);
                                $("#login_notice_msg").html(sendRes.msg);
                                $("#captcha").click();

                            }
                        },
                        error : function(msg) {
                            $("#code").attr("disabled", null);
                            $("#tipMsg").text("服务器端错误，请点击重新获取");
                            clearInterval(timer);
                        }
                    });
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>