@extends('wap.common.wapBaseNew')

@section('title','零钱计划')
@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/project.css')}}">
@endsection

@section('content')
 <article class="v4-detail-page">
    <div lass="v4-detail-page-head">
        <nav class="v4-top flex-box box-align box-pack v4-page-head">
            <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
            <h5 class="v4-page-title">零钱计划</h5>
            <div class="v4-user">
                <a href="javascript:;" data-show="nav">我的</a>
            </div>
        </nav>
    </div>
    <header class="v4-detail-head v4-current-4">
        <div class="rate">
            <big>{{$detail['rate']}}</big>
        </div>
        <p class="text">{{$detail['rate_note']}}</p>

        <div class="progress">
            <div class="bar" style="width:{{$detail['left_amount']/$detail['total_amount']*100}}%;" data-length="bar">
            </div>
            <p class="txt" data-offset="auto">可投金额{{$detail['left_amount_note']}}元</p>
        </div>

        <ul class="v4-detail-box flex-box box-align box-pack">
            <li>
                <p>累计收益(元)</p>
                <span>{{number_format($user_current['interest'],2)}}</span>
            </li>
            <li>
                <p>昨日收益(元)</p>
                <span>{{number_format($user_current['yesterday_interest'],2)}}</span>
            </li>
            <li>
                <p>持有金额(元)</p>
                <span>{{number_format($user_current['amount'],2)}}</span>
            </li>
        </ul>
    </header>
     @if(!empty($ad))
         <a href="@if(!empty($ad['project_id'])) /project/detail/{{$ad['project_id']}} @elseif(!empty($ad['url'])) {{$ad['url']}} @else javascript:void(0) @endif" class="v4-detail-link v4-detail-link-single v4-current-1">
            <span class="v4-current-tips">通知</span><span class="v4-current-3">{{$ad['word']}}</span><span class="arrow"></span>
         </a>
     @endif
    <a href="project/descriptions" class="v4-detail-link v4-detail-link-single">
            项目详情<span class="arrow"></span>
    </a>
    <a href="article/security" class="v4-detail-link v4-detail-link-single">
            安全保障<span class="arrow"></span>
    </a>
    <div class="v4-current-btn">
        <a href="javascript:void(0)">转入</a>
        @if(!empty($user_current['amount']) && $user_current['amount']!=0)
            <a href="/invest/current/investOut">转出</a>
        @else
            <a href="javascript:void(0)" style="color: #999999">转出</a>
        @endif
    </div>

</article>
<!-- 侧边栏 -->
@include('wap.home.nav')
@endsection

@section('jsScript')
    <script>
        //判断进度条上文字的偏移位置
        $(function(){
            var bar = $('[data-length="bar"]');
            var txtOffset = $('[data-offset="auto"]');

            var w = txtOffset.width()/46.875;
            var l = (bar.width())/46.875;
            txtOffset.css({"left":bar.width()-txtOffset.width()/2});

            var w = parseInt(bar[0].style.width);
            if(w>86 && w<=100){
                txtOffset.css({"left":"12rem",});
            }
            if(w<=20){
                txtOffset.css({"left":"0.2rem"});
            }
        })
    </script>
@endsection
