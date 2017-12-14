<?php $__env->startSection('title', '用户登录'); ?>

<?php $__env->startSection('css'); ?>
    <style>
        body{background-color: #f2f2f2;}
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(url('/login/doLogin')); ?>" method="post" id="loginForm">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
        <section class="wap2-input-group2 mt1">
            <div class="wap2-input-box">
                <span class="wap2-input-icon wap2-input-iconphone"></span>
                <input type="text" name="username" autocomplete="off" id="username" placeholder="请输入手机号码" value="<?php echo e(old('username')); ?>">
            </div>
        </section>
        <section class="wap2-input-group2">
            <div class="wap2-input-box pwdTip">
                <span class="wap2-input-icon wap2-input-iconlock"></span>
                <input type="password" name="password" id="password"  autocomplete="off" placeholder="请输入登录密码（6-16位数字及字母）">
                <input type="text" name="" id="showPwd"  autocomplete="off" placeholder="请输入登录密码（6-16位数字及字母）">
                <input type="hidden" name="reffer" value="weixin">
                <?php /*<span class="wap2-eye" ></span>*/ ?>
            </div>
            </section>
            <?php if( !empty($showCaptcha) ): ?>
                <section class="wap2-input-group2 mt1">
                    <div class="wap2-input-box">
                        <span class="wap2-input-icon wap2-input-icon4"></span>
                        <input type="text" name="code" id="code" placeholder="请输入验证码">
                        <a href="javascript:;" class="wap2-code-link" style="border:none;">
                            <?php /*<img id="captcha" style="right:27px;height:36px;width:100px" src="{:C('LOGIN_URL_HTTPS')}{:U('/CaptchaLogin/createCode')}?t=1"  onclick="this.src=this.src.substring(0,this.src.indexOf('?')+1)+Math.random()" />
                        */ ?></a>
                    </div>
                    </a>
                    </div>
                </section>
            <?php endif; ?>

            <section class="wap2-btn-wrap">
                <a href="<?php echo e(url('/findLoginPassword')); ?>" class="fr blue2 f12">忘记密码？</a>
            </section>
            <p class="wap2-tip wap2-tip1 error">
                <?php if(Session::has('msg')): ?>
                    <?php echo e(Session::get('msg')); ?>

                <?php endif; ?>
            </p>
        </section>
        <section class="wap2-btn-wrap mb8px">
            <input type="submit" class="wap2-btn wap2-btn-blue2" id="submit-next" data-lock="lock" value="登录">
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        </section>
    </form>
    <section class="wap2-btn-wrap">
        <!--<a href="{:C('WEIXIN_URL_HTTPS')}{:U('/register')}">-->
        <!--<input type="submit" class="wap2-btn wap2-btn-2" value="免费注册送10000元">-->
        <!--</a>-->
        <a href="<?php echo e(url('/register')); ?>" class="fr blue2 f12">没有账号，立即注册
        </a>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jsScript'); ?>
    <?php echo $__env->make('wap.common.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(assetUrlByCdn('static/weixin/js/wap2/loginForms.js')); ?> "></script>
    <script>
        //点击查看密码
        $(".wap2-eye").click(function(){
            var rel= $.trim($(".wap2-eye").attr("class"));
            // alert(rel);
            if(rel=='wap2-eye'){
                $(".wap2-eye").addClass('open');
                $("#password").hide();
                $("#showPwd").show();

            }else{
                $(".wap2-eye").removeClass('open');
                $(".wap2-eye").attr('type','password');
                $("#password").show();
                $("#showPwd").hide();
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('wap.common.wapBase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>