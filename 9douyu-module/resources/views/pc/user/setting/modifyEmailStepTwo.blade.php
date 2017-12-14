@extends('pc.common.base')
@section('title', '修改常用邮箱')
@section('csspage')

@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="v4-account">
    @include('pc.common/leftMenu')
    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">修改常用邮箱</h2>
        <div class="v4-custody-main v4-phone-main">
            <form action="" method="post"  id="modifyEmailStepTwo">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="setting" value="modify">
                <dl class="v4-input-group">
                    <dt>
                        <label for="email"><span>*</span> 常用邮箱</label>
                    </dt>
                    <dd>
                        <input type="text"  name="email" id="email" placeholder="请输入您的常用邮箱" data-pattern="email"  class="v4-input"/>
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
                        <input type="button" class="v4-input-btn" value="确认" data-value='confirm'  id="v4-input-btn">
                    </dd>
                </dl>
            </form>
        </div>

    </div>


    <!-- 邮箱发送弹窗 -->
<div class="v4-layer_wrap js-mask1" data-modul="modul1"  id="email-tip">
    <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
    <div class="Js_layer v4-layer">
        <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask1"></a>
        <div class="v4-layer_0">
            <p class="v4-layer-normal-icon v4-layer-success-icon"><i class="v4-icon-20 v4-iconfont">&#xe69f;</i></p>
            <p class="v4-layer_text">邮件发送成功！</p>
            <p class="v4-layer-withdraw-tip">请登录您的邮箱激活，有效期12小时。</p>
            <input type="button" class="v4-input-btn" default-value = '重新发送' value="重新发送" data-value='repeat'  id="re-send">
<!--             <a href="#" class="v4-input-btn disable" id="">重新发送（60）</a>
 -->        </div>
    </div>
</div>


</div>


@endsection
@section('jspage')
<script src="{{assetUrlByCdn('/assets/js/pc4/custodyAccount.js')}}" type="text/javascript"></script>
<script src="{{assetUrlByCdn('/assets/js/pc4/layer.js')}}" type="text/javascript"></script>
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
         $("#modifyEmailStepTwo").bind('submit',function(){
        });

        $('.v4-input-btn').click(function(){
            var timeout=0, maxTimeout = 60;
            var desc    = "重新发送";
            var email = $("#email").val();
            var flag = $(this).attr('data-value');
            var setting = $("input[name=setting]").val();

            if(!$.formSubmitF('.v4-input',{
                fromT:'#setEmail'
            })) return false;

            $.ajax({
                url : '/user/send/activeEmail',
                type: 'POST',
                dataType: 'json',
                data: {'email': email, 'setting':setting},
                success : function(result) {
                    if (result.status == true){
                        if(flag == 'repeat'){
                            if(timeout <= 0) {
                                timeout = maxTimeout;
                                $("#code").addClass("disable").val(/*sendRes.msg + "," + */timeout + desc).attr("disabled", true);
                            }
                            var timer = setInterval(function() {
                                timeout--;

                                if(timeout > 0) {
                                    $("#re-send").addClass("disable").val(/*sendRes.msg + "," + */ desc + '('+timeout+')');
                                } else {
                                    $("#re-send").removeClass("disable").val($("#re-send").attr("default-value")).attr("disabled", null);
                                    clearInterval(timer);
                                }

                            }, 1000);
                        }else if(flag == 'confirm'){
                            $('.v4-layer-withdraw-tip').html(result.msg);
                            $("#email-tip").layer();
                        }
                    }else{
                        $("#v4-input-msg").html(result.msg);
                    }
                },
                error : function(msg) {
                    $("#v4-input-msg").html('服务器链接错误');
                }
            });
        });
})
</script>
@endsection
