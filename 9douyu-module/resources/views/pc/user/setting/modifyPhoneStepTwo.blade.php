@extends('pc.common.base')
@section('title', '修改手机号')
@section('csspage')

@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="v4-account">
    @include('pc.common/leftMenu')
    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">修改手机号</h2>
        <div class="v4-custody-main v4-phone-main">
            <form action="" method="post"  id="modifyPhoneStepTwo">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="token" id="token" value="{{ $token }}" />
                <dl class="v4-input-group">
                    <dt>
                        <label for="phone"><span>*</span>新手机号</label>
                    </dt>
                    <dd>
                        <input type="text"  name="phone" id="phone" placeholder="请输入11位手机号" data-pattern="registerphone"  class="v4-input"/>
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>

                    <dt>
                        <label for="phoneCode"><span>*</span>手机验证码</label>
                    </dt>
                    <dd>
                        <input name="code" id="phoneCode" value="" placeholder="请输入验证码" data-pattern="phonecode" class="v4-input v4-input-short">
                        <input value="获取验证码" type="button" class="v4-input-code" id="code" default-value="获取验证码">
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>

                    <dt>
                        &nbsp;
                    </dt>
                    <dd>
                        <div id="v4-input-msg" class="v4-input-msg">
                            @if(Session::has('errorMsg'))
                                {{ Session::get('errorMsg') }}
                            @endif
                        </div>
                        <input type="button" class="v4-input-btn" value="下一步"  id="v4-input-btn">
                    </dd>
                </dl>
            </form>
        </div>

    </div>


</div>
@endsection
@section('jspage')
<script src="{{assetUrlByCdn('/assets/js/pc4/custodyAccount.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function(){
 // 检验输入框内容
    $.validation('.v4-input');

    // 表单提交验证
    $("#v4-input-btn").bind('click',function(){
        if(!$.formSubmitF('.v4-input',{
            fromT:'#modifyPhoneStepTwo'
        })){
            return false;
        }else{
            var  phone = $.trim($("#phone").val());
            var  code = $.trim($("#phoneCode").val());
            var  token = $.trim($("#token").val());
            $.ajax({
                url : '/user/setting/phone/modify',
                type: 'POST',
                dataType: 'json',
                data: {'phone': phone,'code':code,'token':token},
                success : function(result) {
                    sendRes = result;
                    if(sendRes.status) {
                        window.location.href=sendRes.data.url;
                    } else {
                        $("#v4-input-msg").text(sendRes.msg);
                    }
                },
            });
        }
    });

    var timeout=0, maxTimeout = 60;
    var desc    = "秒后重发";
    var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[0135678])\d{8}$/;
    $("#code").click(function(){
        var  phone = $.trim($("#phone").val());
        if(phone == ''){
            $("#code").addClass("error").val('请输入手机号');
            return false;
        }
        if(!phone.match(pattern)) {
            $("#code").addClass("error").val('手机号不正确');
            // borderColor('phone',1);
            return false;
        }
        $.ajax({
            url : '/user/setting/phone/sendSms',
            type: 'POST',
            dataType: 'json',
            data: {'phone': phone},
            success : function(result) {
                sendRes = result;

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
                // $.register.borderColor('captchaCode',2);
                $("#v4-input-msg").text(sendRes.msg);
            },
            error : function(msg) {
                $("#code").attr("disabled", null);
                $("#v4-input-msg").text("服务器端错误，请点击重新获取");
                clearInterval(timer);
            }
        });
    });
})
</script>
@endsection