@extends('pc.common.base')
@section('title', '修改紧急联系人')
@section('csspage')

@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="v4-account">
    @include('pc.common/leftMenu')
    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">修改紧急联系人</h2>
        <div class="v4-custody-main v4-phone-main">
            <form action="/user/modify/urgent/stepTwo" method="post"  id="modifyUrgentStepOne">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input name='phone' id="phone" value="{{$userInfo['phone']}}" type="hidden"/>
                <input name='' id="hide_phone" value="{{ \App\Tools\ToolStr::hidePhone($userInfo['phone'], 3, 4) }}" type="hidden"/>
                <dl class="v4-input-group">
                    <dt>
                        <label for="phone"><span>*</span> 手机号</label>
                    </dt>
                    <dd>
                        <p>{{$userInfo['phone']}}</p>
                    </dd>

                    <dt>
                        <label for="phoneCode"><span>*</span> 手机验证码</label>
                    </dt>
                    <dd>
                        <input name="phoneCode" id="phoneCode" value="" placeholder="请输入验证码" data-pattern="phonecode" class="v4-input v4-input-short">
                        <input value="获取验证码" default-value="获取验证码" type="button" class="v4-input-code" id="code">
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
                        <input type="submit" class="v4-input-btn" value="下一步"  id="v4-input-btn">
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

$(function(){
 // 检验输入框内容
        $.validation('.v4-input');
    // 表单提交验证
         $("#modifyUrgentStepOne").bind('submit',function(){
           // if(!$.formSubmitF('.v4-input',{
           //     fromT:'#modifyUrgentStepOne'
           // })) return false;
        });

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
        var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[013678])\d{8}$/;
        $("#code").click(function(){
            var  phone = $.trim($("#phone").val());
            var  hide_phone = $.trim($("#hide_phone").val());
            var sendSmsTip = '验证码已发送到'+hide_phone+'手机, 请您查收';
            if(phone == ''){
                $("#code").addClass("error").val('请输入手机号');
                $("#phone").css('border-color', '#ff7200');
                return false;
            }
            if(!phone.match(pattern)) {
                $("#code").addClass("error").val('手机号不正确');
                $("#phone").css('border-color', '#ff7200');
                return false;
            }
            $.ajax({
                url : '/user/setting/verify/sendSms',
                type: 'POST',
                dataType: 'json',
                data: {'phone': phone},
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
                                $("#v4-input-msg").html(sendSmsTip);
                                $("#code").addClass("disable").val(/*sendRes.msg + "," + */timeout + desc);
                            } else {
                                $("#code").removeClass("disable").val($("#code").attr("default-value")).attr("disabled", null);
                                $("#v4-input-msg").html('');
                                clearInterval(timer);
                            }

                        }, 1000);
                        $("#captchaCode").css('border-color', '#cccccc');

                    } else {

                        //$("#code").addClass("error").val(sendRes.msg);
                        $("#v4-input-msg").html(sendRes.msg);
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
@endsection
