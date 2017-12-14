@extends('wap.common.activity')

@section('title', '相约在冬季 遇见xing福')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/activity/winter/css/index.css')}}">

@endsection
@section('content')
<section ms-controller="activityHome">
<div class="page-banner" >
    <div class="page-time">活动时间：{{date('m.d',$activityTime['start'])}}~{{date('m.d',$activityTime['end'])}}</div>
    <h2 class="page-title">浓情冬日 火热加息</h2>
    <div class="inner">
        <p class="page-text page-text2">活动期间净充值金额（净充值金额=新充值金额-提现金额）<br>满10000元，即可领取冬日礼包。<br>内含1%加息券，100元红包，300元红包。</p>
        <div class="page-img-default"></div>
        <a href="javascript:;" class="page-btn-receive" ms-if="@package== true" ms-click="@doReceivePackage">立即领取</a>

        <!-- 已领取 -->
        <ul class="page-coupon clearfix" ms-if="@package== false">
            <li>
                <p>加息<big>1</big>%</p>
                <p>恭喜您已领取</p>
            </li>
            <li>
                <p><big>300</big>元</p>
                <p>恭喜您已领取</p>
            </li>
            <li>
                <p><big>100</big>元</p>
                <p>恭喜您已领取</p>
            </li>
         </ul>
    </div>
</div>

<div class="page-wrap">
<h2 class="page-title page-title1">好事成双 惊喜升级</h2>
<div class="page-box">
    @include("wap.activity.winter.reward")
</div>
</div>

<div class="page-wrap">
    <h2 class="page-title page-title1">优选项目</h2>
    @include('wap.activity.winter.project')
</div>
</section>
<div class="page-rule">
    <div class="inner">
        <h2> -活动规则- </h2>
        <p>1、活动时间：{{date('Y年m月d日',$activityTime['start'])}}~{{date('m月d日',$activityTime['end'])}}；</p>
        <p>2、仅限在活动页面投资6月期或12月期项目，可获得对应奖励，奖励只可获得一次，按累积最高投资金额计算；</p>
        <p>3、所有在活动页面进行的投资，在项目周期内不可进行债权转让；</p>
        <p>4、在活动页面投资6月期或12月期项目，使用红包或加息券投资的项目金额不计入累积金额；</p>
        <p>5、现金奖励及iPhoneX奖励获得者，若活动期间提现金额≥50000元，将取消其领奖资格；</p>
        <p>6、现金奖励将于2018年1月31日前发放至账户余额中；</p>
        <p>7、iPhoneX以实物形式发放，由于库存及发货时间的特殊性，客服将于活动结束后5个工作日内与获得iPhoneX的用户沟通确定奖品发放事宜，在此期间联系未果视为用户自动放弃奖品；</p>
        <p>8、红包和加息券有效期截止至2017年12月31日；</p>
        <p>9、活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服。</p>
        <p>本活动最终解释权归九斗鱼所有。</p>
    </div>
</div>
<div class="page-layer layer1">
    <div class="page-mask"></div>
    <div class="page-share"></div>
    <div class="page-pop page-pop2">

    <div class="page-pop-pos"></div>

        <div class="page-pop-inner">
            <div class="page-pop-content">
                <p class="page-pop-text1"><big>恭喜您</big><br>已经<span>成功领取</span>冬日礼包</p>
                <ul class="page-pop-coupon clearfix">
                    <li>
                        <p>加息<big>1</big>%</p>
                        <p>已领取</p>
                    </li>
                    <li>
                        <p><big>300</big>元</p>
                        <p>已领取</p>
                    </li>
                    <li>
                        <p><big>100</big>元</p>
                        <p>已领取</p>
                    </li>
                </ul>
                <p class="page-pop-text2">请至“我的账户”中查看</p>
                <a href="javascript:;" class="page-btn-receive page-pop-btn">我知道了</a>
            </div>
        </div>
    </div>
</div>

<div class="page-layer layer2">
    <div class="page-mask"></div>
    <div class="page-pop page-pop1">
    <div class="page-pop-pos"></div>
        <div class="page-pop-inner">
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer2">close</a>
            <div class="page-pop-content">
                <p class="page-pop-text">还没有登录哦~<br>请登录后参加活动</p>
                <a href="javascript:;" class="page-btn-receive page-pop-btn userDoLogin">去登录</a>
            </div>
        </div>
    </div>
</div>

<div class="page-layer layer3">
    <div class="page-mask"></div>
    <div class="page-pop page-pop1">
        <div class="page-pop-pos"></div>
        <div class="page-pop-inner">
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer3">close</a>
            <div class="page-pop-content">
                <p class="page-pop-text">还没有登录哦~<br>请登录后参加活动</p>
                <a href="javascript:;" class="page-btn-receive page-pop-btn" data-toggle="mask" data-target="layer3">我知道了</a>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name='_token' id="csrf_token" value="{{ csrf_token() }}" />
@endsection
@section('jsScript')
<script type="text/javascript" src="{{ assetUrlByCdn('static/weixin/activity/winter/js/activity-winter.js')}}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/pop.js')}}"></script>
<script type="text/javascript">
    document.body.addEventListener('touchstart', function () { });
    var evclick = "ontouchend" in window ? "touchend" : "click";

    $(document).on("click", '.page-btn-receive',function(event){
        event.stopPropagation();
        window.location.reload();
    })
</script>
@endsection
