<?php $__env->startSection('title', '会员登录注册'); ?>

<?php $__env->startSection('header'); ?>
<?php echo $__env->make('pc.common/top', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="v4-reg-header">
        <div class="v4-reg">
            <h1 class="v4-header-logo">
                <a href="/"></a>
                <div class="v4-header-subhead">
                    耀盛中国
                    <p>旗下互联网金融平台</p>
                </div>
           </h1>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <div class="v4-register">
             <div class="v4-reg">
                <div class="v4-reg-left">
                    <?php if(!empty($ad)): ?>
                        <?php foreach( $ad as $item ): ?>
                            <a href="<?php if( empty($item['url']) ): ?>javascript:void(0)<?php else: ?> <?php echo e($item['url']); ?> <?php endif; ?>">
                                <img src="<?php echo e($item['purl']); ?>" width="620" height="600" alt="">
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="v4-reg-right">
                    <div class="Js_tab_box v4-reg-tab">
                        <ul class="Js_tab_click v4-reg-main">
                            <li class="<?php if($action == 'login'): ?> cur <?php endif; ?>">登录</li>
                            <li class="<?php if($action == 'register'): ?> cur <?php endif; ?>">注册</li>
                        </ul>
                        <div class="Js_tab_main_click" <?php if($action == 'register'): ?> style="display: none;" <?php endif; ?>>
                         <form method="post" action="/login/doLogin" id="login-form">
                             <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <ul class="v4-login">
                                <li>
                                     <input type="text" id="username" name="username" value="" placeholder="请输入手机号" data-pattern="registerphone" class="v4-reg-input" />
                                </li>
                                <li>
                                    <input type="password" value="" placeholder="请输入密码"  name="password" id="password" data-pattern="" class="v4-reg-input" />
                                    <!-- <span  class="v4-reg-icon" ><i class="t1-icon v4-iconfont">&#xe6a1;</i></span> -->
                                    <span  class="v4-reg-icon v4-iconfont" >&#xe6a1;</span>
                                </li>
                                <li>
                                    <input type="hidden" name="reffer" value="<?php echo e(isset($reffer) ? $reffer : null); ?>" />
                                    <input type="hidden" name="returnUrl" value="<?php echo e(isset($returnUrl) ? $returnUrl : null); ?>" />
                                </li>
                            </ul>
                            <div id="v4-input-msg" class="v4-input-msg">
                                <?php if(Session::has('msg')): ?>
                                    <?php echo e(Session::get('msg')); ?>

                                <?php endif; ?>
                            </div>
                            <div class="v4-input-agree">
                                <label><input type="checkbox" checked="checked" id="checkbox">我已阅读并同意<a href="/registerAgreement" class="blue" target="_blank">《九斗鱼会员注册协议》</a></label>
                            </div>
                            <input type="submit" class="v4-input-btn" value="立即登录" id="v4-input-btn">
                            <a href="/forgetLoginPassword" class="v4-reg-pwd">忘记密码？</a>
                            </form>

                        </div>
                        <div class="Js_tab_main_click" <?php if($action == 'login'): ?> style="display: none;" <?php endif; ?>>
                        <form action="/register/doRegister" method="post" id="registerForm">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <ul class="v4-login v4-reg1">
                                <li>
                                     <input type="text" id="username1" name="phone" value="" placeholder="请输入手机号" data-pattern="registerphone"  class="v4-reg-input" />
                                </li>
                                <li><input type="password" name="password"  style="display: none;"/>
                                    <input type="password" value="" placeholder="设置6~16位字母及数字组合"  name="password" id="password1" data-pattern="password"  class="v4-reg-input" />
                                    <span  class="v4-reg-icon v4-iconfont" >&#xe6a1;</span>
                                </li>
                                <li>
                                    <input type="text" value="" placeholder="校验码"  name="captcha" id="captchaCode" data-pattern="checkcode" class="v4-reg-input" />
                                    <span><img id="captcha" class="v4-reg-code"  src="/captcha/pc_register" width="104" height="40" onclick="this.src=this.src+Math.random()"></span>
                                </li>
                                <li>
                                    <input type="text" value="" placeholder="短信验证码"  name="phone_code" id="phoneCode" data-pattern="phonecode"  class="v4-reg-input" />
                                    <input value="获取验证码" id="code" type="button" class="v4-input-code" default-value="获取验证码" >
<!--                                     <input value="60s后重新获取" type="button" class="v4-input-code disable">
 -->                            </li>
                                <li>
                                    <input type="text" value="" placeholder="请添加邀请人手机号（选填）"  name="invite_phone" id="invite_phone" data-pattern="registerphone"/>
                                </li>
                            </ul>
                            <div id="v4-input-msg1" class="v4-input-msg"></div>
                            <div class="v4-input-agree">
                                <label><input type="checkbox" name="aggreement" checked="checked" id="checkbox-1">我已阅读并同意<a href="/registerAgreement" class="blue" target="_blank">《九斗鱼会员注册协议》</a></label>
                            </div>
                            <input type="hidden" name="request_source" value="1" class="mr5">
                            <input type="hidden" name="channel" value="<?php echo e($channel); ?>" class="mr5">
                            <input type="submit" class="v4-input-btn" value="注册完成" id="v4-input-btn-1">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 注册成功弹窗 -->
        <div class="v4-layer_wrap js-mask v4-layer-reg" data-modul="modul1" style="display: none;" id="lay_wrap1">
            <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
            <div class="Js_layer v4-layer">
                <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
                <div class="v4-layer_0">
                    <p class="v4-layer-normal-icon v4-layer-success-icon"><i class="v4-icon-20 v4-iconfont">&#xe69f;</i></p>
                    <p class="v4-layer_text">恭喜您，注册成功！</p>
                    <p class="v4-layer-withdraw-tip">完成实名认证，领取新手福利。</p>
                    <a href="/user/setting/verify" class="v4-input-btn" id="">实名认证</a>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
   
<?php $__env->startSection('jspage'); ?>
    
    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('/assets/js/pc4/custodyAccount.js')); ?>"></script>
    <script type="text/javascript">
    $.checkedBox('#checkbox','#v4-input-btn');
    $.checkedBox('#checkbox-1','#v4-input-btn-1');

     $.validation('#login-form .v4-reg-input',{
           className:'red'
        });
     $.validation('#registerForm .v4-reg-input',{
            errorMsg:'#v4-input-msg1',
            className:'red'
        });

      // 表单提交验证
         $("#login-form").bind('submit',function(){
            if(!$.formSubmitF('#login-form .v4-reg-input',{
                fromT:'#login-form',
                className:'red'
            })) return false;
        });

        //点击关闭跳转首页
        $('.v4-layer_mask,.v4-layer_close').click(function(){
            window.location.href = '/'
        });

        // 表单提交验证
        $("#registerForm").bind('submit', function () {
            if (!$.formSubmitF('#registerForm .v4-reg-input', {
                        fromT: '#registerForm',
                        fromErrorMsg: '#v4-input-msg1',
                        className: 'red'
                    })){
                return false;
            }else{
                $.ajax({
                    url : $('#registerForm').attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: $('#registerForm').serialize(),
                    success : function(result) {
                        if(result.code == 500){
                            $("#v4-input-msg1").text(result.msg);
                        }else if(result.code == 200){
                            $("#lay_wrap1").mask();
                        }else{
                            window.location.href = result.data.url;
                        }
                    },
                    error : function(msg) {
                        $("#v4-input-msg1").text("服务器端错误，请点击重新获取");
                    }
                });
                $("#registerForm").data("lock", false);
            }
        });

        // tab click no package only one
        function tabclick(tab,tabmain,cur){
            $(tab).click(function(){
                var index = $(tab).index(this);
                $(this).addClass(cur).siblings(tab).removeClass(cur);
                $(tabmain).eq(index).show().siblings(tabmain).hide();
            })
        };
      tabclick('.Js_tab_click li','.Js_tab_main_click','cur');
      // 密码的eye开关
      $(".v4-reg-icon").click(function(){
        if($(this).hasClass("open")){
           $(this).removeClass("open").html('&#xe6a1;');
           $(this).prev().attr("type","password");
        }else{
            $(this).addClass("open").html('&#xe6a2;');
            $(this).prev().attr("type","text");
        }

      })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    (function($){
        $(document).ready(function(){
            var timeout=0, maxTimeout = 60;
            var desc    = "秒后重发";
            var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[0135678])\d{8}$/;
            //$.bindSendCode({type: 'register', autoPhone: false, timeout: timeout, maxTimeout: maxTimeout});
            $("#code").click(function(){
                var  phone = $.trim($("#username1").val());
                var  captcha = $.trim($("input[name=captcha]").val());
                if(phone == ''){
                    $("#code").addClass("error").val('请输入手机号');
                    return false;
                }
                if(!phone.match(pattern)) {
                    $("#code").addClass("error").val('手机号不正确');
                    borderColor('phone',1);
                    return false;
                }
                if(captcha == ''){
                    $("#code").addClass("error").val('请输入校验码');
                    $.register.borderColor('captchaCode',1);
                    return false;
                }
                $.ajax({
                    url : '/register/sendSms',
                    type: 'POST',
                    dataType: 'json',
                    data: {'phone': phone,'captcha':captcha},
                    success : function(result) {
                        sendRes = result;
                        if(sendRes.captcha === false && options.captcha) {
                            $("#captcha").click();
                        }
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
                            $.register.borderColor('captchaCode',2);

                        } else {

                            //$("#code").addClass("error").val(sendRes.msg);
                            $("#v4-input-msg1").text(sendRes.msg);
                            $("#captcha").click();
                            $("input[name=captcha]").val('');

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