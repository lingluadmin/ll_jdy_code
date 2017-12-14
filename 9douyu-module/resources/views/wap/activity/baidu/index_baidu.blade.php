@extends('wap.common.activity')

@section('title', '注册送888元红包')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/novice1016/css/index_baidu.css')}}">
@endsection

@section('content')

<div class="landon-regitster" id="register-pape">
    @if( $userStatus== false)
    <form action="/register/doRegister" method="post" id="wap_registerForm" register-status="lock">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="channel" value="{{ $channel}}">
        <input type="hidden" name="back_url" value="{{ $registerUrl}}">
        <ul class="v4-login v4-reg1">
            <li>
                 <input type="text" id="username1" name="phone" value="" placeholder="请输入手机号" data-pattern="registerphone" class="v4-reg-input ann2promote-input">
            </li>
            <li>
                <input type="password" value="" placeholder="设置6~16位字母及数字组合" name="password" id="password1" data-pattern="password" class="v4-reg-input ann2promote-input">
                <span class="v4-reg-icon"></span>
            </li>
            <li>
                <input type="text" value="" placeholder="校验码" name="captcha" id="captchaCode" data-pattern="checkcode" class="v4-reg-input ann2promote-input">
                <span><img id="captcha" class="v4-reg-code checkcode" src="/captcha/pc_register"  onclick="this.src=this.src+Math.random()"></span>
            </li>
            <li>
                <input type="text" value="" placeholder="短信验证码" name="code" id="phoneCode" data-pattern="phonecode" class="v4-reg-input ann2promote-input">
                <input value="获取验证码" id="code" type="button" class="v4-input-code wap ann2promote-code" default-value="获取验证码">
            </li>
        </ul>
        <div id="v4-input-msg" class="v4-input-msg"> @if(Session::has('errorMsg')){{Session::get('errorMsg')}}@endif</div>
          <div class="v4-input-agree">
            <label><input type="checkbox" name="aggreement" checked="checked" id="checkbox">我已阅读并同意<a href="/registerAgreement" class="blue" target="_blank">《九斗鱼会员注册协议》</a></label>
        </div>
        <input type="submit" class="v4-input-btn ann2promote-btn" value="立即领取" id="v4-input-btn">
    </form>
    @endif
</div>


<!-- 新手操作流程 -->
<div class="landon-box">
	<div class="landon-title">新手操作流程</div>
	<div class="landon-progress">
		<img src="{{ assetUrlByCdn('/static/weixin/activity/novice1016/images/progress.png')}}">
	</div>
</div>
<!-- End 新手操作流程 -->

<!-- 新手888元红包 -->
<div class="landon-box box2">
	<div class="landon-title">新手888元红包<i class="landon-title-icon"></i></div>
	<div class="landon-bonus">
		<img src="{{ assetUrlByCdn('/static/weixin/activity/novice1016/images/bonus.png')}}">
		<!-- 未注册 -->
	@if($userStatus == false)
		<a href="#register-paper" class="landon-btn userDoLogin">一键领取888元</a>
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
			<p class="red"><big>{{$project['base_rate'] or 9}}</big>@if($project['after_rate'] >0)+{{$project['after_rate'] or 2}} @endif</p>
			<p>借款利率(%)</p>
		</li>
		<li>
			<p class="black"><big>{{$project['format_invest_time'] or 30}}</big>{{$project['invest_time_unit'] or '天'}}</p>
			<p>借款期限</p>
		</li>
		<li>
			<p class="black"><big>100</big>元</p>
			<p>起投金额</p>
		</li>
	</ul>
	<!-- 未注册 -->
@if($isNovice == false)
	<a href="javascript:;" class="landon-btn2 disable" id="project-btn">立即投资</a>
@endif
@if($isNovice == true)
	<!-- 已注册 -->
	<a href="javascript:;" attr-data-id = "{{$project['id']}}"  ttr-act-token = '' class="landon-btn2 doInvest" id="project-btn-over">立即投资</a>
@endif
</div>
<!-- End 新手专享项目 -->

<!-- 计算器 -->
<div class="landon-calculator">
    <div class="calculator-sumarry">
        <p class="invest_rate_note">预期年利率：{{$project['base_rate'] or 9}}%@if($project['after_rate'] >0)+{{$project['after_rate'] or 2}}% @endif</p>
        <p>到期总收益：<span class="yellow">91.67</span>元</p>
    </div>
    <p class="calculator-title">选择投资周期</p>
    <div class="calculator-tab invest_time_unit">
        <a href="javascript:;" class="active" attr-invest-type=100  attr-invest-time="{{$project['format_invest_time'] or 30}}" attr-invest-rate="{{$project['base_rate'] or 9}}+{{$project['after_rate'] or 2}}">新手专享项目</a>
        <a href="javascript:;" attr-invest-type=200 attr-invest-time="3" attr-invest-rate="11">3个月</a>
        <a href="javascript:;" attr-invest-type=200 attr-invest-time="6" attr-invest-rate="11.5">6个月</a>
        <a href="javascript:;" attr-invest-type=200 attr-invest-time="12" attr-invest-rate="12">12个月</a>
    </div>
    <p class="calculator-title">输入投资金额</p>
    <input type="hidden" name="invest_time" value="{{$project['format_invest_time'] or 30}}">
    <input type="hidden" name="invest_type" value="100">
    <input type="hidden" name="invest_rate" value="{{$project['profit_percentage'] or 11}}">
    <input value="10000" placeholder="10000" name="invest_cash" class="calculator-input">
    <a href="javascript:;" class="landon-btn2 landon-btn-invest" >开始计算</a>
</div>
<!-- End 计算器 -->

<!-- 投资列表 -->
<div class="landon-list">
    <div class="landon-list-title"><img src="{{ assetUrlByCdn('/static/weixin/activity/novice1016/images/bag.png')}}">大家都在投资</div>
    <div class="landon-list-main" id="messageList">
        @if( !empty($investList) )
        <ul>
            @foreach($investList as $key => $invest)
            <li>
                <p>{{date('m/d',$invest['time'])}}</p>
                <p>{{$invest['username']}} 投资了<span class="red">{{$invest['invest_cash']}}</span>元</p>
            </li>
            @endforeach

        </ul>
        @endif
    </div>
</div>
<!-- End 投资列表 -->

<!-- 九斗鱼优势 -->
<div class="landon-box box3">
    <div class="landon-title">九斗鱼优势</div>
	<div class="landon-advantage-item first clearfix">
		<div class="landon-advantage-img">
            <p><img src="{{ assetUrlByCdn('/static/weixin/activity/novice1016/images/icon1.png')}}"></p>
    		<p>集团实力</p>
        </div>
		<div class="landon-advantage-txt">母公司耀盛中国为中港两地持牌金融机构，涵盖网络小贷、企业征信、私募基金、香港证券经纪等9张金融牌照</div>
	</div>
	<div class="landon-advantage-item second clearfix">
		<div class="landon-advantage-img">
            <p><img src="{{ assetUrlByCdn('/static/weixin/activity/novice1016/images/icon2.png')}}"></p>
            <p>安全合规</p>
        </div>
		<div class="landon-advantage-txt">平台稳定运营超3年，累计投资人数超17万，江西银行资金存管，全程交易签署具有法律效力的电子合同</div>
	</div>
	<div class="landon-advantage-item third clearfix">
		<div class="landon-advantage-img">
            <p><img src="{{ assetUrlByCdn('/static/weixin/activity/novice1016/images/icon3.png')}}"></p>
            <p>收益稳健</p>
        </div>
		<div class="landon-advantage-txt">预期年化利率7%~12%，项目期限1~12个月灵活可选，100元起投，无额外开户费用及交易费用</div>
	</div>
    <div class="clear"></div>
</div>
<!-- End 九斗鱼优势 -->
<div id="checkcode1" data-img="/captcha/wx_register"  style="overflow: hidden;"></div>



@endsection
@section('jsScript')

 <script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/account.js')}}"></script>
<script type="text/javascript">
(function($){
    $(function(){
        var evclick = "ontouchend" in window ? "touchend" : "click";

        $.checkedBox('#checkbox','#v4-input-btn');
        $.validation('#wap_registerForm .v4-reg-input',{
            errorMsg:'#v4-input-msg',
        });
        // 表单提交验证
         $("#wap_registerForm").bind('submit',function(){
            var lock    =   $(this).attr('register-status');
            if( lock =='lock') {
                $(".v4-reg1 li").css("display","block");
                $("#v4-input-btn").val('完成注册');
                $(this).attr('register-status','unlock')
                return false
            }
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
<script type="text/javascript">
(function($){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        setInterval(function () {
            $('#messageList').find("ul:first").animate({
                marginTop: "-1.493rem"
            }, 1000, function() {
                $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
            });
        }, 2000);
    });

})(jQuery)

$(document).ready(function () {
    var evclick = "ontouchend" in window ? "touchend" : "click";
    $('.invest_time_unit a').on(evclick,function () {
        var _this   =   $(this);
        $('.invest_time_unit').find('a').removeClass('active');
        _this.addClass('active');
        var invest_time =   _this.attr('attr-invest-time');
        var invest_rate =   _this.attr('attr-invest-rate');
        var invest_reg  =   /\+/;
        var invest_rate_note = '预期年利率：'+invest_rate+'%';
        if( invest_reg.exec(invest_rate)){
            var  rateArr=   invest_rate.split('+');
            invest_rate =   parseInt(rateArr[0])+parseInt(rateArr[1]);
            invest_rate_note    =   '预期年利率：'+rateArr[0]+'%';
            if(rateArr['1'] >0) {
                invest_rate_note= invest_rate_note +'+'+rateArr['1']+"%";
            }
        }
        var invest_type=    _this.attr('attr-invest-type');
        $("input[name='invest_time']").val(invest_time);
        $("input[name='invest_rate']").val(invest_rate);
        $("input[name='invest_type']").val(invest_type);
        var invest_cash =   $("input[name='invest_cash']").val();
        var invest_profit = getInvestProfit(invest_time , invest_cash , invest_rate ,invest_type);
        $('.invest_rate_note').html(invest_rate_note);
        $('.yellow').html(invest_profit);

    })
    getInvestProfit = function (time , cash , rate , type) {
        if( time == '') {
            time = 1;
        }
        if( cash == '' ){
            cash = 10000;
        }
        if (rate =='') {
            rate = 11;
        }
        if(type==100){
            return ((cash * rate / 100 /365 ) * time ) .toFixed(2);
        }
        return ((cash * rate / 100 /12 ) * time ) .toFixed(2);
    }

    loadInvestProfit    =   function(){
        var invest_cash =   $("input[name='invest_cash']").val();
        var invest_time =   $("input[name='invest_time']").val();
        var invest_rate =   $("input[name='invest_rate']").val();
        var invest_type =   $("input[name='invest_type']").val();
        var invest_profit = getInvestProfit(invest_time , invest_cash , invest_rate , invest_type);
        $('.yellow').html(invest_profit);
    }
    $('.landon-btn-invest').on(evclick , function () {
        loadInvestProfit();
    });
    loadInvestProfit();
})
</script>
@endsection

