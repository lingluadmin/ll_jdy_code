@extends('wap.common.wapBase')

@section('title', '注册送888元红包')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/landon/css/index.css')}}">
@endsection

@section('content')
<div class="landon-top">
	<a href="/" class="landon-logo"><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/logo.png')}}"></a>

	<div class="landon-login">
		@if(empty($view_user))
			已有账号？<a href="/login" class="login">立即登录</a>
		@else
			您好，<a href="/user" class="login">@if(!empty($view_user['real_name'])) {{$view_user['real_name']}}@else {{ \App\Tools\ToolStr::hidePhone($view_user['phone'], 3, 4)}}  @endif</a><a href="{{url('logout')}}">［退出］</a>
		@endif
	</div>
</div>

<div class="landon-banner"><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/banner.jpg')}}" class="img"></div>
@if($userStatus == false)
<!-- 未注册 -->
<div class="landon-box register">
	<div class="landon-custody"><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/right.png')}}">投资资金全程由江西银行存管</div>
	<div class="landon-regitster">
            <form action="/register/doRegister" method="post" id="wap_registerForm">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="channel" value="{{ $channel}}">
				<input type="hidden" name="redirect_url" value="{{$redirect_url}}">
				<input type="hidden" name="back_url" value="{{ $backUrl}}">
                <ul class="v4-login v4-reg1">
                    <li>
                         <input type="text" id="username1" name="phone" value="" placeholder="请输入手机号" data-pattern="registerphone" class="v4-reg-input">
                    </li>
                    <li>
                        <input type="password" value="" placeholder="设置6~16位字母及数字组合" name="password" id="password1" data-pattern="password" class="v4-reg-input">
                        <span class="v4-reg-icon"></span>
                    </li>
                    <li>
                        <input type="text" value="" placeholder="校验码" name="captcha" id="captchaCode" data-pattern="checkcode" class="v4-reg-input">
                        <span><img id="captcha" class="v4-reg-code" src="/captcha/pc_register"  onclick="this.src=this.src+Math.random()"></span>
                    </li>
                    <li>
                        <input type="text" value="" placeholder="短信验证码" name="code" id="phoneCode" data-pattern="phonecode" class="v4-reg-input">
                        <input value="获取验证码" id="code" type="button" class="v4-input-code wap" default-value="获取验证码">
<!--                     <input value="60s后重新获取" type="button" class="v4-input-code disable">
-->                 </li>
                </ul>
                <div id="v4-input-msg" class="v4-input-msg"> @if(Session::has('errorMsg')){{Session::get('errorMsg')}}@endif</div>
                <input type="submit" class="v4-input-btn" value="注册完成" id="v4-input-btn">
                <div class="v4-input-agree">
                    <label><input type="checkbox" name="aggreement" checked="checked" id="checkbox">我已阅读并同意<a href="/registerAgreement" class="blue" target="_blank">《九斗鱼会员注册协议》</a></label>
                </div>
            </form>

	</div>
</div>
<!-- End 未注册 -->
@endif
@if($userStatus == true)
<!-- 已注册 -->
<div class="landon-box unregister">
	<p><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/icon-bonus.png')}}"></p>
    <p class="red">注册成功，888元红包已到账</p>
	<!-- <p><a href="{{$package}}" class="v4-block-btn">下载手机APP体验新手福利</a></p> -->
</div>
<!-- End 已注册 -->
@endif
<!-- 新手操作流程 -->
<div class="landon-box">
	<div class="landon-title">新手操作流程</div>
	<div class="landon-progress">
		<img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/progress.png')}}">
	</div>
</div>
<!-- End 新手操作流程 -->

<!-- 新手888元红包 -->
<div class="landon-box">
	<div class="landon-title">新手888元红包</div>
	<div class="landon-bonus">
		<img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/bonus.png')}}">
		<!-- 未注册 -->
	@if($userStatus == false)
		<a href="javascript:;" class="landon-btn" id="bonus-btn">一键领取888元</a>
	@endif
	@if($userStatus == true))
		<!-- 已注册 -->
		<a href="javascript:;" class="landon-btn disable">已领取</a>
	@endif
	</div>
</div>
<!-- End 新手888元红包 -->

<!-- 新手专享项目 -->
<div class="landon-box">
	<div class="landon-title">新手专享项目</div>
	<ul class="landon-project">
		<li>
			<p class="red"><big>{{$project['base_rate']}}</big>@if($project['after_rate'] >0)+{{$project['after_rate']}} @endif</p>
			<p>借款利率(%)</p>
		</li>
		<li>
			<p class="black"><big>{{$project['format_invest_time']}}</big>{{$project['invest_time_unit']}}</p>
			<p>借款期限</p>
		</li>
		<li>
			<p class="black"><big>100</big>元</p>
			<p>起投金额</p>
		</li>
	</ul>
	<!-- 未注册 -->
@if($userStatus == false)
	<a href="javascript:;" class="landon-btn" id="project-btn">立即投资</a>
@endif
@if($userStatus == true)
	<!-- 已注册 -->
	<a href="javascript:;" class="landon-btn" id="project-btn-over">立即投资</a>
@endif
</div>
<!-- End 新手专享项目 -->

<!-- 九斗鱼优势 -->
<div class="landon-advantage">
	<h3>九斗鱼优势</h3>
	<div class="landon-advantage-item">
		<p><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/icon1.png')}}"></p>
		<p><strong>集团实力</strong></p>
		<p>母公司耀盛中国为中港两地持牌金融机构，涵盖网络小贷、企业征信、私募基金、香港证券经纪等9张金融牌照</p>
	</div>
	<div class="landon-advantage-item">
		<p><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/icon2.png')}}"></p>
		<p><strong>安全合规</strong></p>
		<p>平台稳定运营超3年，累计投资人数超17万，江西银行资金存管，全程交易签署具有法律效力的电子合同</p>
	</div>
	<div class="landon-advantage-item">
		<p><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/icon3.png')}}"></p>
		<p><strong>收益稳健</strong></p>
		<p>预期年化利率7%~14%，项目期限1~12个月灵活可选，100元起投，无额外开户费用及交易费用</p>
	</div>
</div>
<!-- End 九斗鱼优势 -->

<div class="landon-hotline">客服电话：400-6686-568</div>

<div class="landon-fixed">
	<span>下载APP，领新手福利</span>
	<a href="{{$package}}" class="landon-fixed-btn">下载APP</a>
</div>


<section class="pop-wrap" id="pop-success">
    <div class="pop-mask"></div>
    <div class="pop">
        <span class="pop-close"></span>
        <p class="pop-text">下载手机App，体验新手专享项目</p>
        <p><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/phone.png')}}" class="pop-phone"></p>
        <a href="{{$package}}" class="pop-btn">下载体验</a>
    </div>
</section>
@if($userStatus == false)
<section class="pop-wrap" id="pop-img" style="display: block;">
    <div class="pop-mask"></div>
    <div class="pop-img">
        <span class="pop-close2"></span>
        <p><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/pop-img.png')}}"></p>
        <a href="javascript:;" class="landon-btn" id="pop-img-btn">一键领取</a>
    </div>
</section>
@endif
@endsection
@section('jsScript')
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/account.js')}}"></script>
<script type="text/javascript">
(function($){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$(function(){
		var evclick = "ontouchend" in window ? "touchend" : "click";
	  // 密码的eye开关
	  $(".v4-reg-icon").on(evclick,function(){
	        if($(this).hasClass("open")){
	           $(this).removeClass("open");
	           $(this).prev().attr("type","password");
	        }else{
	            $(this).addClass("open");
	            $(this).prev().attr("type","text");
	        };
		});

		$.checkedBox('#checkbox','#v4-input-btn');
		$.validation('#wap_registerForm .v4-reg-input',{
            errorMsg:'#v4-input-msg',
        });
        // 表单提交验证
         $("#wap_registerForm").bind('submit',function(){
            if(!$.formSubmitF('#wap_registerForm .v4-reg-input',{
                fromT:'#wap_registerForm'
            })) return false;
        });

         $('#bonus-btn,#project-btn').on(evclick,function(){
         	var topH = $('.landon-top').height();
         	var bannerH = $('.landon-banner').height();
         	$('html,body').animate({scrollTop: (topH+bannerH-30)}, 500);
         	
         });

            // 一键领取 弹窗关闭
         $('#pop-img-btn').on(evclick,function(){
            $('.pop-wrap').hide()
            
         });

         // 遮罩关闭
         $('.pop-close,.pop-mask,.pop-close2').on(evclick,function(){
         	$('.pop-wrap').hide()
         });

         $('#project-btn-over').on(evclick,function(){
         	$('#pop-success').show()
         });
        $(document).ready(function(){

            $('#code').click(function(){
                sendPhoneCode('wap');
            });
            //输入或者失去焦点判断
        })
	})
})(jQuery)

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
</script>
@endsection

