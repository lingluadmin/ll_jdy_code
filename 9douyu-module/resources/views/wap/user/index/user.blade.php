@extends('wap.common.wapBaseNew')

@section('title','我的资产')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/user.css')}}">
@endsection

@section('content')

<article>
     <div class="v4-user-page-head">

        <nav class="v4-top flex-box box-align box-pack v4-page-head">
            <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
            <h5 class="v4-page-title">我的资产</h5>
            <div class="v4-user">
                    <!-- <a href="/login">登录</a> | <a href="/register">注册</a> -->
                    <a href="javascript:;" data-show="nav">我的</a>
            </div>
        </nav>

        <a href="javascript:;" onclick="window.location.href='/user/asset'" class="v4-user-head" data-touch="false">
            <p class="v4-asset-txt">预期总资产(元)<span href="javascript:;" class="v4-asset-eye" data-eye="">eye</span></p>
            <p class="v4-asset-num" data-display="text">{{ $user['total_cash'] }}</p>
            <p class="v4-asset-num hidden" data-display="star">****</p>
            <ul class="v4-asset-list flex-box box-align box-pack">
                <li>
                    <p>在投本金(元)</p>
                    <span data-display="text">{{ $user['investing_cash'] }}</span>
                    <span data-display="star">****</span>
                </li>
                <li>
                    <p>累计收益(元)</p>
                    <span data-display="text">{{ $user['total_interest'] }}</span>
                    <span data-display="star">****</span>
                </li>
            </ul>
        </a>

    </div>

    <div class="v4-user-space flex-box box-align box-pack">
        <div class="v4-asset-balance">
            <p>可用余额(元)</p>
            <span data-display="text">{{ $user['balance'] }}</span>
            <span data-display="star">****</span>
        </div>
        <div class="v4-user-btn-wrap clearfix">
            <a href="/withdraw" class="v4-btn-user v4-btn-hollow" data-touch="false">提现</a>
            <a href="/pay/index" class="v4-btn-user" data-touch="false">充值</a>
        </div>
    </div>
    <div class="v4-user-auto clearfix">
        <a href="/refund/calendar/" class="v4-user-link" data-touch="false">
          <div class="inner flex-box box-align">
            <div class="icon"><img src="{{assetUrlByCdn('/static/weixin/images/wap4/asset/icon1.png')}}" alt=""></div>
            <hgroup class="menu">
                <h6>回款计划</h6>
                <p>查看回款计划明细</p>
            </hgroup>
          </div>
        </a>
        <a href="/user/record" class="v4-user-link" data-touch="false">
          <div class="inner flex-box box-align">
            <div class="icon"><img src="{{assetUrlByCdn('/static/weixin/images/wap4/asset/icon2.png')}}" alt=""></div>
            <hgroup class="menu">
                <h6>资金记录</h6>
                <p>查看资金流水明细</p>
            </hgroup>
          </div>
        </a>
        
        <a href="/bonus/index/" class="v4-user-link" data-touch="false">
          <div class="inner flex-box box-align">
            <div class="icon"><img src="{{assetUrlByCdn('/static/weixin/images/wap4/asset/icon3.png')}}" alt=""></div>
            <hgroup class="menu">
                <h6>优惠券</h6>
                <p><span>{{$view_bonus['ableUserBonusCount']}}</span>张可用</p>
            </hgroup>
          </div>
        </a>
        <a href="/activity/partner1?from=wap" class="v4-user-link" data-touch="false">
          <div class="inner flex-box box-align">
            <div class="icon"><img src="{{assetUrlByCdn('/static/weixin/images/wap4/asset/icon4.png')}}" alt=""></div>
            <hgroup class="menu">
                <h6>邀请好友</h6>
                <p>分享财富增值快乐</p>
            </hgroup>
          </div>
        </a>

      
         
    </div>
   
</article>
<!-- fixed footer -->
@include('wap.home.downloadapp')
<!-- 侧边栏 -->
@include('wap.home.nav')


@endsection

@section('jsScript')

<script>
 
    $("[data-eye]").on("click touched",function(event){
        event.stopPropagation();
        var dataText = $('[data-display="text"]'),
            dataStar = $('[data-display="star"]'),
            $this = $(this);
        if(!($this.hasClass("active"))){
            $this.addClass("active");
            dataText.hide();
            dataStar.show();
        }else{
            $this.removeClass("active");
            dataText.show();
            dataStar.hide();
        }
    });

</script>

@endsection

