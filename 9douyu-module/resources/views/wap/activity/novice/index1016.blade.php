@extends('wap.common.wapBase')

@section('title', '注册送888元红包')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/novice1016/css/index.css')}}">
@endsection

@section('content')

<div class="landon-banner">
    @if($userStatus == false)
    <a href="{{$registerUrl}}" class="landon-bonus-btn userDoLogin">一键领取</a>
    @endif
    @if($userStatus == true)
        <a href="javascript:;" class="landon-bonus-btn disable">已领取</a>
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
		<a href="{{$registerUrl}}" class="landon-btn userDoLogin">一键领取888元</a>
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


@endsection
@section('jsScript')
<script type="text/javascript">
(function($){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        var myar = setInterval('AutoScroll("#messageList")', 2000);
         // $("#messageList").hover(function() { clearInterval(myar); }, function() { myar = setInterval('AutoScroll("#messageList")', 2000) });

    });

})(jQuery)
function AutoScroll(obj) {
    $(obj).find("ul:first").animate({
        marginTop: "-1.493rem"
    }, 1000, function() {
        $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
    });
};

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
$(document).delegate(".doInvest","click",function(){var projectId=$(this).attr("attr-data-id");var act_token=$(this).attr("attr-act-token");if(!projectId||projectId==0){return false}if(!act_token){act_token="{{$actToken}}_"+projectId}if(client=="ios"){if(version&&version<"4.1.0"){window.location.href="objc:certificationOrInvestment("+projectId+",1)";return false}if(version=="4.1.2"){setActToken(act_token,projectId);return false}if(!version||version>="4.1.0"){window.location.href="objc:toProjectDetail("+projectId+",1,"+act_token+")";return false}}if(client=="android"){if(version<"4.1.0"){window.jiudouyu.fromNoviceActivity(projectId,1);return false}if(version>="4.1.0"){window.jiudouyu.fromNoviceActivity(projectId,1,act_token);return false}}setActToken(act_token,projectId)});function setActToken(act_token,projectId){if(act_token){var _token=$("input[name='_token']").val();$.ajax({url:"/activity/setActToken",data:{act_token:act_token,_token:_token},dataType:"json",type:"post",success:function(){window.location.href="/project/detail/"+projectId},error:function(){window.location.href="/project/detail/"+projectId}})}window.location.href="/project/detail/"+projectId;return false};

$(document).delegate(".userDoLogin,.introduce-btn","click",function () {
    if( client =='ios'){
        if(version =='4.1.2') {
            window.location.href='/login';
            return false
        } else {
            window.location.href = "objc:gotoLogin";
            return false;
        }
    }
    if (client =='android'){
        window.jiudouyu.login();
        return false;
    }
    window.location.href='/login';
})

</script>
@endsection

