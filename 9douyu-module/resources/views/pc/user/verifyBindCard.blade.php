@extends('pc.common.layout')

@section('title', '实名认证')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="v4-wrap v4-custody-wrap">
        <h2 class="v4-account-titlex">实名认证</h2>
        <div class="v4-custody-main">
            <form action="/user/setting/doVerify" method="post" id="verifyBindCard">
                <dl class="v4-input-group">
                    @if(!empty($realName) && !empty($identityCard))
                        <input type="hidden" id="name" name="real_name" value="{{$realName}}">
                        <input type="hidden" id="idcard" name="card_no" value="{{$identityCard}}">
                        <!-- 已实名 -->
                        <dt>
                            <label>真实姓名</label>
                        </dt>
                        <dd>
                            <p>{{$realName}}</p>
                        </dd>
                        <dt>
                            <label>身份证号</label>
                        </dt>
                        <dd>
                            <p>{{\App\Tools\ToolStr::hideNum($identityCard,3,2)}}</p>
                        </dd>
                    @else
                        <!-- 未实名 -->
                        <dt>
                            <label for="name"><span>*</span>真实姓名</label>
                        </dt>
                        <dd>
                            <input name="real_name" value="{{!empty($realName)?$realName:''}}" placeholder="请输入真实姓名" id="name" data-pattern="name" class="v4-input">
                            <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                        </dd>
                        <dt>
                            <label for="idcard"><span>*</span>身份证号</label>
                        </dt>
                        <dd>
                            <input name="card_no" value="{{!empty($identityCard)?$identityCard:''}}" placeholder="请输入身份证号" id="idcard" data-pattern="idcard" class="v4-input">
                            <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                        </dd>
                    @endif
                    <dt>
                        <label for="bankcard"><span>*</span>银行卡号</label>
                    </dt>
                    <dd>
                        <input type="text" value="" placeholder="仅支持储蓄银行卡" id="bankcard" data-pattern="bankcard" class="v4-input" name="bank_card" value="" autocomplete="off"/>
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>
                    <dt>
                        <label for="password"><span>*</span>交易密码</label>
                    </dt>
                    <dd>
                        <!-- 阻止表单自动填充 hack -->
                        <input type="password" name="trading_password"  style="display: none;"/>

                        <input value="" type="password" name="trading_password" placeholder="请输入6-16位字母和数字组合" id="password" data-pattern="password" class="v4-input" autocomplete="passwordTrading">
                        <i class="v4-eye-icon v4-iconfont">&#xe6a1;</i>
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
                        <input type="button" class="v4-input-btn" value="确认"  id="v4-input-btn">
                    </dd>
                    <dt>
                        &nbsp;
                    </dt>
                    <dd>
                    <p class="v4-address-tip"><i class="v4-iconfont v4-icon-light">&#xe6a9;</i>温馨提示：绑定的银行卡需开通银行在线支付功能</p>
                    </dd>
                </dl>
            </form>
        </div>
    </div>


<!-- 注册成功弹窗 -->
<div class="v4-layer_wrap js-mask v4-layer-reg" data-modul="modul1" style="display: none;" id="lay_wrap1">
    <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
    <div class="Js_layer v4-layer">
        <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
        <div class="v4-layer_0">
            <p class="v4-layer-normal-icon v4-layer-success-icon"><i class="v4-icon-20 v4-iconfont">&#xe69f;</i></p>
            <p class="v4-layer_text">恭喜您，完成实名认证！</p>
            <p class="v4-layer-withdraw-tip">新手专享最高可享15%，快来抢购吧。</p>
            <a href="/user" class="v4-input-btn" id="">我的账户</a>
        </div>
    </div>
</div>
@endsection
@section('jspage')
<script type="text/javascript">
(function($){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //关闭弹框跳转至首页
    $('.v4-layer_mask,.v4-layer_close').click(function(){
        window.location.href = '/'
    });
        
    // 检验输入框内容
    $.validation('.v4-input');

    // 表单提交验证
    $("#v4-input-btn").bind('click',function(){
        if(!$.formSubmitF('.v4-input',{
            fromT:'#verifyBindCard'
        })){
            return false;
        }else{
            var  name = $.trim($("#name").val());
            var  idcard = $.trim($("#idcard").val());
            var  bankcard = $.trim($("#bankcard").val());
            var  password = $.trim($("#password").val());
            $("#v4-input-btn").addClass('disable');
            $.ajax({
                url : '/user/setting/doVerify',
                type: 'POST',
                dataType: 'json',
                data: {'real_name': name,'card_no':idcard,'bank_card':bankcard,'trading_password':password},
                success : function(result) {
                    $("#v4-input-btn").removeClass('disable');
                    sendRes = result;
                    if(sendRes.status) {
                        $("#lay_wrap1").mask();
                    } else {
                        $("#v4-input-msg").text(sendRes.msg);
                    }
                },
            });
        }
    });


    // 密码的eye开关
    $(".v4-eye-icon").click(function(){
        if($(this).hasClass("open")){
            $(this).removeClass("open").html('&#xe6a1;');
            $(this).prev().attr("type","password");
        }else{
            $(this).addClass("open").html('&#xe6a2;');
            $(this).prev().attr("type","text");
        }
    });

})(jQuery)
</script>
@endsection
