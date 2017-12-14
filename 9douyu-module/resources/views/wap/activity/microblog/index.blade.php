@extends('wap.common.wapBase')

@section('title', '九斗鱼粉丝趴')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/microblog/css/index.css') }}">

@endsection

@section('content')
<div class="wei-banner"></div>
<div class="wei-bg">
    <div class="wei-bg-1">
        为了给关注九斗鱼的新老客户们送上一波暖冬惊喜福利 <span class="icon"></span>，九斗鱼决定在官方微博平台定期发起有奖活动，最高价值500元的现金红包 <span class="icon1"></span> 痛快送！大家快来踊跃参与吧！<span class="icon2"></span>
    </div>
    <div class="wei-bg-1 wei-1">
        <h4 class="wei-title">活动时间</h4>
        <p class="wei-time">2017年11月29日——2018年1月17日</p>
    </div>
    <div class="wei-bg-1 wei-3">
        <h4 class="wei-title">活动规则</h4>
        <p class="wei-list"> <span></span>关注九斗鱼官方微博</p>
        <p class="wei-list"> <span></span>参与九斗鱼官方微博平台定期发布的活动</p>
        <p class="wei-list"> <span></span>部分活动需要注册为九斗鱼APP用户才可领奖</p>
        <div class="wei-2">（为保证活动的真实性与公平性，活动所有奖品均将由微博第三方后台抽取，烦请关注私信内容，避免耽误您的奖品领取)</div>
    </div>
    <div class="wei-bg-1 wei-3">
        <h4 class="wei-title">奖品设置</h4>
        <div class="wei-prize"></div>
    </div>
        <img src="{{ assetUrlByCdn('/static/weixin/activity/microblog/images/text.png') }}" class="wei-text">
        <a href="https://weibo.com/9douyu" class="wei-btn"></a>
        <img src="{{ assetUrlByCdn('/static/weixin/activity/microblog/images/logo.png') }}" class="wei-logo">
</div>
@endsection