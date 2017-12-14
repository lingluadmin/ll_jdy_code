/**
 * Created by scofie on 2017/9/23.
 */

var _phone   =   {
    sendCode:function (element , maxTimeout) {
        var timeout=0;
        var desc    = "秒后重发";
        var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[0135678])\d{8}$/;
        var  baseElementObj =   $("#" + element+ '_' + 'registerForm') ;
        var  phone      =   $.trim(baseElementObj.find("input[name='phone']").val());
        var  captcha    =   $.trim(baseElementObj.find("input[name='captcha']").val());
        baseElementObj.find(".v4-input-msg").html("")
        if( phone == ''){
            baseElementObj.find(".v4-input-msg").html("请输入手机号")
            return false;
        }
        if( phone.length != 11 ) {
            baseElementObj.find(".v4-input-msg").html("手机号码位数不正确");
            return false;
        }
        if(!phone.match(pattern)) {
            baseElementObj.find(".v4-input-msg")("手机号不正确")
            return false;
        }
        if(captcha == ''){
            baseElementObj.find(".v4-input-msg").html("请输入校验码")
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
                    $(".captcha").click();
                }
                if(sendRes.status) {
                    if(timeout <= 0) {
                        timeout = maxTimeout;
                        $('.'+element).addClass("disable").val(timeout + desc).attr("disabled", true);
                    }
                    var timer = setInterval(function() {
                        timeout--;
                        if(timeout > 0) {
                            $('.'+element).addClass("disable").val(timeout + desc);
                        } else {
                            $('.'+element).removeClass("disable").val('获取验证码').attr("disabled", null);
                            clearInterval(timer);
                        }
                    }, 1000);
                    baseElementObj.find(".v4-input-msg").html('验证码已发送到'+ phone +'手机，请您查收。')
                } else {
                    baseElementObj.find(".v4-input-msg").html(sendRes.msg);
                    baseElementObj.find("input[name='captcha']").val('');
                }
            },
            error : function(msg) {
                codeObj.attr("disabled", null);
                $("v4-input-msg").text("服务器端错误，请点击重新获取").show();
                clearInterval(timer);
            }
        });
    }
};
