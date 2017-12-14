
        
<form action="/register/doRegister" method="post" id="first_form_registerForm" name="first_form_registerForm">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="channel" value="{{ $channel}}">
    <input type="hidden" name="redirect_url" value="/activity/landonSuccess">
    <input type="hidden" name="back_url" value="{{ $backUrl}}">
    <ul class="v4-login v4-reg1">
        <li>
             <input type="text" id="phone" name="phone" value="" placeholder="请输入手机号" data-pattern="registerphone"  class="v4-reg-input" />
        </li>
        <li>
            <input type="password" value="" placeholder="设置6~16位字母及数字组合"  name="password" id="password1" data-pattern="password"  class="v4-reg-input" />
            <span  class="v4-reg-icon open v4-reg-icon1"></span>
        </li>
        <li>
            <input type="text" value="" placeholder="校验码"  name="captcha" id="captchaCode" data-pattern="checkcode" class="v4-reg-input" />
            <span><img  class="v4-reg-code captcha"  src="/captcha/pc_register" width="104" height="40" onclick="this.src=this.src+Math.random()"></span>
        </li>
        <li>
            <input type="text" value="" placeholder="短信验证码"  name="phone_code"  data-pattern="phonecode"  class="v4-reg-input" />
            <input value="获取验证码"  type="button" class="v4-input-code first_form">
            <!-- <input value="60s后重新获取" type="button" class="v4-input-code disable"> -->
        </li>
    </ul>
    <div id="v4-input-msg1" class="v4-input-msg ">@if(Session::has('errorMsg')){{Session::get('errorMsg')}}@endif</div>
    <div class="v4-input-agree">
        <label><input type="checkbox" name="aggreement" checked="checked" id="checkbox-1"> 我已阅读并同意<a href="/registerAgreement" class="blue" target="_blank">《九斗鱼会员注册协议》</a></label>
    </div>
    <input type="hidden" name="request_source" value="1" class="mr5">
    <input type="submit" class="register-input-btn" value="立即注册" id="v4-input-btn-1">
</form>

<script type="text/javascript">
    $(function(){
        $.checkedBox('#checkbox-1','#v4-input-btn-1');

        $.validation('#first_form_registerForm .v4-reg-input',{
            errorMsg:'#v4-input-msg1',
            className:'red'
        });
        // 表单提交验证
        $("#first_form_registerForm").bind('submit',function(){
            if(!$.formSubmitF('#first_form_registerForm .v4-reg-input',{
                fromT:'#first_form_registerForm',
                fromErrorMsg:'#v4-input-msg1',
                className:'red'
            })) return false;
        });
        // 密码的eye开关
        $(".v4-reg-icon1").click(function(){
            if($(this).hasClass("open")){
                $(this).removeClass("open");
                $(this).prev().attr("type","password");
            }else{
                $(this).addClass("open");
                $(this).prev().attr("type","text");
            }
        })
    })
 </script>
       



