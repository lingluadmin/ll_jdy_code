@extends('wap.common.wapBaseLayoutNew')

@section('title', '优选项目')

@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/information.css')}}">
@endsection

@section('content')
<article class="Js_tab_box">
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">优选项目</h5>
        <div class="v4-user">
            <a href="javascript:;" data-show="nav">我的</a>
        </div>
    </nav>
    <div class="v4-project-1">
        @if( $holdType == "assignment")
            <ul>
                <li>
                    <p id="assignment_note">在投本金(元)</p>
                </li>
                <li>
                    <p id="assignment_cash">0.00</p>
                </li>
            </ul>
        @else
            <ul>
                <li>
                    <p id="user_principal_note">在投本金(元)</p>
                    <p id="user_principal">0.00</p>
                </li>
                <li>
                    <p id="user_interest_note">待收收益(元)</p>
                    <p id="user_interest">0.00</p>
                </li>
            </ul>
        @endif
    </div>

    <ul class="v4-bonus-nav Js_tab">
        <li @if( $holdType == "investing")  class="active" @endif   ><a href="/user/invest/PreferredItem?holdType=investing"><span>持有中</span></a></li>
        <li @if( $holdType == "assignment") class="active" @endif   ><a href="/user/invest/PreferredItem?holdType=assignment"><span>转让中</span></a></li>
        <li @if( $holdType == "finish")     class="active" @endif   ><a href="/user/invest/PreferredItem?holdType=finish"><span>已完结</span></a></li>
    </ul>

    <div class="scroller-wrap ms-controller" ms-controller="investHome" ms-on-swipeup="swipeUp()" ms-on-swipedown="swipeDown()">

        <div class="scroller">
            <ul class="v4-project-2">
                <a  data-touch="false" ms-repeat="invest" ms-attr-href="/user/invest/detail?investId={%el.invest_id%}" >
                    @if( $holdType == "assignment")
                        <li>
                             <p><span>{% el.project_name %}</span><span>{% el.credit_cash %}</span><span>{% el.refund_time_note %} {% el.refund_time %}</span></p>
                             <p><span>{% el.format_name  %}</span><span>{% el.credit_cash_note %}(元)</span><span>{% el.rest_days_note %}{% el.rest_days %}</span></p>
                        </li>

                    @elseif($holdType == "finish")
                        <li>
                            <p><span>{% el.project_name %}</span><span>{% el.invest_principal %} </span><span>{% el.invest_interest %}</span></p>
                            <p><span>{% el.format_name  %}<i class="v4-pro-icon">已完结</i></span><span>{% el.invest_principal_note %}(元)</span><span>{% el.invest_interest_note %}(元)</span></p>
                        </li>
                    @else
                        <li>
                            <p><span>{% el.project_name %}</span><span>{% el.invest_principal %} </span><span>{% el.invest_interest %}</span></p>
                            <p><span ms-if=" el.assignment  > 0 ">{% el.format_name  %}<i class="v4-pro-icon">{% el.assignment_note %}</i></span><span ms-if=" el.assignment <= 0 ">{% el.format_name  %}</span><span>{% el.invest_principal_note %}(元)</span><span>{% el.invest_interest_note %}(元)</span></p>
                        </li>
                    @endif

                </a>
             </ul>
            <div class="v4-load-more"><i class="pull_icon"></i><span>加载中...</span></div>
         </div>
    </div>
    <input type="hidden" id="holdType" value="{{ $holdType }}">
   


</article>
 
 <!-- 侧边栏 -->
@include('wap.home.nav')
 
@endsection

@section('jsScript')
<script src="{{ assetUrlByCdn('/static/weixin/js/lib/biz/user-invest-home.js')}}"></script>
@endsection
