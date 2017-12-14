<form action="/register/doRegister" method="post" id="two_form_registerForm" name="two_code_registerForm" onsubmit="return false">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="channel" value="{{ $channel}}">
    <input type="hidden" name="back_url" value="{{ $backUrl}}">
    <input type="hidden" name="redirect_url" value="/activity/landonSuccess">
    <ul class="v4-login v4-reg1">
        <li>
             <input type="text" id="username1" name="phone" value="" placeholder="请输入手机号" data-pattern="registerphone"  class="v4-reg-input" />
        </li>
        <li>
            <input type="password" value="" placeholder="设置6~16位字母及数字组合"  name="password"  data-pattern="password"  class="v4-reg-input" />
            <span  class="v4-reg-icon open v4-reg-icon2"></span>
        </li>
        <li>
            <input type="text" value="" placeholder="校验码"  name="captcha" id="captchaCode" data-pattern="checkcode" class="v4-reg-input" />
            <span><img id="captcha" class="v4-reg-code"  src="/captcha/pc_register" width="104" height="40" onclick="this.src=this.src+Math.random()"></span>
        </li>
        <li>
            <input type="text" value="" placeholder="短信验证码"  name="phone_code"  data-pattern="phonecode"  class="v4-reg-input" />
            <input value="获取验证码" type="button" class="v4-input-code two_form">
        </li>
    </ul>
    <div id="v4-input-msg2" class="v4-input-msg">@if(Session::has('errorMsg')){{Session::get('errorMsg')}}@endif</div>
    <div class="v4-input-agree">
        <label><input type="checkbox" name="aggreement" checked="checked" id="checkbox-2"> 我已阅读并同意<a href="/registerAgreement" class="blue" target="_blank">《九斗鱼会员注册协议》</a></label>
    </div>
    <input type="hidden" name="request_source" value="1" class="mr5">
    <input type="submit" class="register-input-btn" value="立即注册" id="v4-input-btn-2">
</form>
 <script type="text/javascript">
    $(function(){
        $.checkedBox('#checkbox-2','#v4-input-btn-2');

         $.validation('#two_form_registerForm .v4-reg-input',{
                errorMsg:'#v4-input-msg2',
                className:'red'
            });
            // 表单提交验证
        $("#two_form_registerForm").bind('submit', function () {
            if ( !$.formSubmitF('#two_form_registerForm .v4-reg-input',
                    {
                        fromT: '#two_form_registerForm',
                        fromErrorMsg: '#v4-input-msg2',
                        className: 'red'
                    })
            ){
                return false;
            } else {
                $.ajax({
                    url : $('#two_form_registerForm').attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: $('#two_form_registerForm').serialize(),
                    success : function(result) {
                        if(result.code == 500){
                            $("#v4-input-msg2").text(result.msg);
                        }
                        if(result.code == 200){
                            window.location.href = result.data.url;
                        }
                    },
                    error : function(msg) {
                        $("#v4-input-msg2").text("服务器端错误，请点击重新获取");
                    }
                });
                $("#two_form_registerForm").data("lock", false);
            }
        });
          // 密码的eye开关
      $(".v4-reg-icon2").click(function(){
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


       



