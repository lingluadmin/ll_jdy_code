@extends('wap.common.wapBaseLayoutNew')

@section('title', '九斗鱼理财')

@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/project.css')}}">
@endsection

@section('content')
<article>
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">项目列表</h5>
        <div class="v4-user">
                @if($userId>0)
                    <a href="javascript:;" data-show="nav">我的</a>
                @else
                    <a href="/login">登录</a> | <a href="/register">注册</a>
                @endif
        </div>
    </nav>

    <div class="scroller-wrap ms-controller" ms-controller="projectHome" ms-on-swipeup="swipeUp()" ms-on-swipedown="swipeDown()">
        <div class="scroller">
            @if(!empty($novice))
                <div class="v4-section-head flex-box box-align box-pack">
                    <img src="{{ assetUrlByCdn('static/weixin/images/wap4/index/icon-title2.png')}}" alt="新手专享" class="title" />
                    <a href="/project/detail/{{$novice['id']}}" class="v4-btn-arrow">仅限首次投资</a>
                </div>

                <a href="/project/detail/{{$novice['id']}}" class="v4-project-list" data-touch="false">
                    <ul class="flex-box box-align box-pack">
                      <li>
                          <p class="big v4-text-red">{{number_format($novice['base_rate'],1)}}<span>%</span>@if($novice['after_rate']>0)<span>+{{ number_format($novice['after_rate'],1)}}%</span>@endif</p>
                          <span>期待年回报率</span>
                      </li>
                      <li>
                          <p>项目期限 <em class="v4-text-red">{{$novice['format_invest_time'].$novice['invest_time_unit']}}</em></p>
                          <span>{{$novice['refund_type_note']}}</span>
                      </li>
                    </ul>
                </a>
            @endif

            <a ms-repeat="project" ms-attr-href="/project/detail/{%el.id%}"  ms-class="{% el.status==130? 'v4-project-list':'v4-project-list disabled'%}">
                <header class="clearfix"><h5 class="title">{% el.name %}<em>&nbsp;{% el.format_name %}</em></h5></header>
                <ul class="flex-box box-align box-pack">
                  <li>
                      {{--<p class="big v4-text-red">{% el.profit_percentage|number(1) %}%</p>--}}
                      <p class="big v4-text-red">{% el.base_rate|number(1) %}<span>%</span></span><span ms-if="el.after_rate>0">+{% el.after_rate|number(1) %}%</span></p>
                      <span>期待年回报率</span>
                  </li>
                  <li>
                      <p>项目期限 <em class="v4-text-red">{% el.format_invest_time+''+el.invest_time_unit %}</em></p>
                      <span>{% el.refund_type_note %}</span>
                  </li>
                </ul>
            </a>

            <!-- loading more -->
          <div class="v4-load-more"><i class="pull_icon"></i><span>加载中...</span></div>
       </div>

    </div>
    <script src="{{ assetUrlByCdn('/static/weixin/js/lib/biz/project-home.js') }}"></script>
</article>
    <!-- fixed footer -->
    @include('wap.home.downloadapp')
    <!-- 侧边栏 -->
    @include('wap.home.nav')
@endsection


