@extends('wap.common.wapBaseLayoutNew')

@section('title','我的优惠券')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/bonus.css')}}">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/project.css')}}">
@endsection

@section('content')
<article >
   <div ms-controller="wapBonusList" ms-on-swipeup="swipeUp()" ms-on-swipedown="swipeDown()">
        <header class="v4-header">
            <a href="javascript:;" class="v4-header-back" onclick="window.history.go(-1);">返回</a>
            <h1>{%title%}</h1>
        </header>
        <ul class="v4-bonus-nav Js_tab">
            <li ms-class="{% toggole==1 ? 'active' : '' %}"  ms-click="changeTab($event)" ><span data-tab-id="1" >未使用</span></li>
            <li ms-class="{% toggole==2 ? 'active' : '' %}"  ms-click="changeTab($event)" ><span data-tab-id="2" >已使用</span></li>
            <li ms-class="{% toggole==3 ? 'active' : '' %}"  ms-click="changeTab($event)"  ><span data-tab-id="3" >已过期</span></li>
        </ul>
        <div class="v4-bonus-main Js_tab_main" ms-visible="toggole==1" >
          <div ms-repeat="list1" >
            <!-- 红包 -->
            <div class="v4-bonus-box cash" ms-if="el.bonus_type == 300">
                <div class="v4-bonus-num">
                    <p><big>{% el.bonus_value_note %} {% el.bonus_value %}</big></p>
                    <p>{% el.min_money_note %}</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>{% el.name %}</h3>
                    <p>{% el.using_desc %}<br>有效期：{% el.use_start_time_dot %}~{% el.use_end_time_dot %}</p>
                </div>
                <i class="v4-bonus-icon"></i>
            </div>

            <!-- 加息券 -->
            <div class="v4-bonus-box rate" ms-if="el.bonus_type != 300">
                <div class="v4-bonus-num">
                    <p><big>{% el.bonus_value %}{% el.bonus_value_note %}</big></p>
                    <p>{% el.min_money_note %}</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>{% el.name %}</h3>
                    <p>{% el.using_desc %}<br>有效期：{% el.use_start_time_dot %}~{% el.use_end_time_dot %}</p>
                </div>
                <i class="v4-bonus-icon"></i>
            </div>
         </div>
        </div>

        <!-- 已使用 -->
        <div class="v4-bonus-main Js_tab_main" ms-visible="toggole==2">
          <div ms-repeat="list2">
            <!-- 红包 -->
            <div class="v4-bonus-box cash disable" ms-if="el.bonus_type == 300">
                <div class="v4-bonus-num">
                    <p><big>{% el.bonus_value_note %} {%el.bonus_value%}</big></p>
                    <p>{%el.min_money_note%}</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>{% el.name %}</h3>
                    <p>{%el.using_desc%}<br>有效期：{%el.use_start_time_dot%}~{%el.use_end_time_dot%}</p>
                </div>
                <i class="v4-bonus-icon"></i>
            </div>

            <!-- 加息券 -->
            <div class="v4-bonus-box rate disable" ms-if="el.bonus_type != 300">
                <div class="v4-bonus-num">
                    <p><big>{%el.bonus_value%}{% el.bonus_value_note %}</big></p>
                    <p>{%el.min_money_note%}</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>{% el.name %}</h3>
                    <p>{%el.using_desc%}<br>有效期：{%el.use_start_time_dot%}~{%el.use_end_time_dot%}</p>
                </div>
                <i class="v4-bonus-icon"></i>
            </div>
         </div>
        </div>

        <!-- 已过期 -->
        <div class="v4-bonus-main Js_tab_main" ms-visible="toggole==3">
          <div ms-repeat="list3">
            <!-- 红包 -->
            <div class="v4-bonus-box cash disable" ms-if="el.bonus_type == 300">
                <div class="v4-bonus-num">
                    <p><big>{% el.bonus_value_note %} {%el.bonus_value%}</big></p>
                    <p>{%el.min_money_note%}</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>{% el.name %}</h3>
                    <p>{%el.using_desc%}<br>有效期：{%el.use_start_time_dot%}~{%el.use_end_time_dot%}</p>
                </div>
                <i class="v4-bonus-icon"></i>
            </div>

            <!-- 加息券 -->
            <div class="v4-bonus-box rate disable" ms-if="el.bonus_type != 300">
                <div class="v4-bonus-num">
                    <p><big>{%el.bonus_value%}{% el.bonus_value_note %}</big></p>
                    <p>{%el.min_money_note%}</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>{% el.name %}</h3>
                    <p>{%el.using_desc%}<br>有效期：{%el.use_start_time_dot%}~{%el.use_end_time_dot%}</p>
                </div>
                <i class="v4-bonus-icon"></i>
            </div>
          </div>
        </div>
      <div class="v4-load-more"><i class="pull_icon"></i><span id="load-more">加载中...</span></div>
   </div>
</article>
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
@endsection
@section('jsScript')
<script type="text/javascript" src="{{assetUrlByCdn('/static/weixin/js/lib/biz/wap-user-bonus.js')}}"></script>
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
@endsection



