@extends('pc.common.activity')

@section('title', '注册送888元红包')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/landon/css/index.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<!-- head -->
@section('header')
    <div class="landon-header">
        <div class="landon-reg">
            <h1 class="landon-header-logo">
                <a href="/"></a>
                <div class="landon-header-subhead">
                    耀盛中国
                    <p>旗下互联网金融平台</p>
                </div>
           </h1>
           <div class="landon-user-info">
            <span class="customer">客服电话：400-6686-568</span>
            <span>
                @if(empty($view_user))
                    已有账号？<a href="/login" class="login">立即登录</a>
                   @else
                    您好，<a href="/user" class="login">@if(!empty($view_user['real_name'])) {{$view_user['real_name']}}@else {{ \App\Tools\ToolStr::hidePhone($view_user['phone'], 3, 4)}}  @endif</a><a href="{{url('logout')}}">［退出］</a>
                @endif
            </span>
           </div>
        </div>
    </div>
@endsection


<div class="landon-banner">
    
    <div class="landon-register-warp">
        <div class="landon-register clearfix">
            <!-- 未注册状态 -->
            @if( $userStatus == false)
            <div class="landon-register-bonus">
                <a class="landon-btn-oth" href="javascript:;" data-target="module">一键领取</a>
            </div>
            @endif
             <!-- 已注册状态 -->
            @if($userStatus == true)
             <div class="landon-qcode-app">
                <h5>注册成功，<span>888</span>元红包已到账<br>即刻投资赚收益吧！</h5>
                <p>扫码下载APP<br>操作更便捷</p>
            </div>
            @endif
        </div>
    </div>
    

</div>
<div class="landon-box">
    <h1 class="title">新手操作流程</h1>
    <div class="landon-flow"></div>
    <ul class="landon-flow-text clearfix">
        <li class="li1">注册<br>送<span>888</span>元红包</li>
        <li class="li2">账户<br>实名认证</li>
        <li class="li3">账户<br>充值</li>
        <li class="li4">投资<br>新手专享项目</li>
        <li class="li5">坐等<br>收益到账</li>
    </ul>
</div>
<div class="landon-box landon-66">
    <h1 class="title">新手888元红包</h1>
    <div class="landon-lucky"></div>
    @if( $userStatus == true)
        <a href="javascript:;" class="landon-btn-oth disable">已领取</a>
    @endif
    @if( $userStatus == false)
        <a href="javascript:;" class="landon-btn landon-register-btn" data-target="module">一键领取888元</a>
    @endif
</div>
<!-- project -->
@if( !empty($project))
<div class="landon-box">
    <h1 class="title">新手专享项目</h1>
    <div class="landon-project">
        <table>
            <tr>
                <td class="td1">
                    <p class="text-color-red">{{$project['base_rate']}}<em>%@if($project['after_rate'] >0)+{{$project['after_rate']}}% @endif</em></p>
                    <span>借款利率</span>
                </td>
                <td class="td2">
                    <p>5<em>万元</em></p>
                    <span>单人限额</span>
                </td>
                <td class="td3">
                    <p>{{$project['format_invest_time']}}<em>{{$project['invest_time_unit']}}</em></p>
                    <span>借款期限</span>
                </td>
                <td class="td4">
                    <p>100<em>元</em></p>
                    <span>起投金额</span>
                </td>
                <td align="right">
                    @if( $userStatus == true)
                        <a href="javascript:;" class="landon-btn landon-btn-invest">立即投资
                            <img src="{{assetUrlByCdn('/static/activity/landon/images/qcode-app1.png')}}" class="landon-app-img1" />
                        </a>
                    @endif
                    @if( $userStatus == false)
                        <a href="javascript:;" class="landon-btn landon-register-btn landon-register-btn" data-target="module">立即投资</a>
                    @endif

                </td>
            </tr>
        </table>
    </div>
</div>
@endif
<div class="landon-advantage">
    <div class="inner">
        <h1 class="landon-advantage-title">九斗鱼优势</h1>
        <div class="landon-advantage-img"></div>
        <ul class="landon-advantage-text clearfix">
            <li class="li1">
                <h5>集团实力</h5>
                <p>母公司耀盛中国为中港两地持牌金融机构，涵盖网络小贷、企业征信、私募基金、香港证券经纪等9张金融牌照</p>
            </li>
            <li class="li2">
                <h5>安全合规</h5>
                <p>平台稳定运营超3年，累计投资人数超17万，江西银行资金存管，全程交易签署具有法律效力的电子合同</p>
            </li>
             <li class="li3">
                <h5>收益稳健</h5>
                <p>预期年化利率7%~14%，项目期限1~12个月灵活可选，100元起投，无额外开户费用及交易费用</p>
            </li>
        </ul>
    </div>
</div>

<!-- fixed bottom -->
<div class="landon-fixed-bottom">
    <!-- 已注册 -->
@if( $userStatus == true )
    <a href="/project/index" class="landon-btn">立即投资</a>
@endif
<!-- 未注册 -->
@if( $userStatus == false )
    <a href="javascript:;" class="landon-btn landon-register-btn" data-target="module">注册送888元红包</a>
@endif
</div>
@if( $userStatus == false )
<!-- pop -->
<div class="pop-wrap landon-pop-register">
    <div class="pop-mask" ></div>
    <div class="landon-pop">
        <span data-toggle="mask" data-target="landon-pop-register" class="landon-pop-close"></span>
        <div class="landon-pop-img">
            <img src="{{assetUrlByCdn('/static/activity/landon/images/landon-movie.png')}}" width="821" height="416" />
            <a href="javascript:;" data-toggle="mask" data-target="landon-pop-register" id="landon-pop-btn" class="landon-btn-oth landon-pop-btn">一键领取</a>
        </div>
    </div>
</div>

<!-- 注册成功弹窗 -->
<div class="landon-register-layer js-mask" id="landon-register-layer" data-modul="module" style="display: none;">
    <div class="mask"></div>
    <div class="pop">
        <div class="landon-register pop-register">
            <h1 class="register-title">注册送888元红包<a href="javascript:;" class="register-close" data-toggle="mask" data-target="js-mask">关闭</a></h1>
            @include('pc.activity.landon.registerPop')
        </div>
    </div>
</div>
@endif
@endsection

@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/static/js/custodyAccount.js')}}"></script>
<script type="text/javascript">
    $(function() {

        $(document).on("click", '.landon-register-btn', function (event) {
            event.stopPropagation();
            $("#landon-register-layer").show()
        });

        $('#landon-pop-btn').click(function() {
            $('.landon-register-layer').mask();
        });
    })

</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    (function($){
        $(document).ready(function(){
            $('.first_form').click(function(){
                sendPhoneCode('first_form');
            });
            $('.two_form').click(function(){
                sendPhoneCode('two_form');
            });
        });
    })(jQuery);
    function sendPhoneCode( element ) {
        var timeout=0, maxTimeout = {{env('PHONE_CONFIG.TIMEOUT')}};
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
        if(!phone.match(pattern) ) {
            baseElementObj.find(".v4-input-msg").html("手机号不正确")
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
</script>
@endsection