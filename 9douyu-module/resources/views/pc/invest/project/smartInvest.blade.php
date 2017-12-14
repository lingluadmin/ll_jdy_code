@extends('pc.common.layoutNew')

@section('title', '项目详情')

@section('csspage')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/assets/css/pc4/tip-yellow.css')}}">
@endsection

@section('content')

<div class="v4-wrap">
    @include('pc.invest.project.smartInvest.invest')
    <div class="pr Js_tab_box1" ms-controller="projectDetailBottom">
        <p class="v4-project-list-tip">网贷有风险，出借需谨慎</p>
            <!--tab-->
            <ul class="Js_tab v4-user-tab clearfix">
                <li ms-class="[@tabId==1 && 'cur']"><a href="javascript:void(0)" ms-click="changeTab($event)" data-tab-id="1">项目详情</a></li>
                <li ms-class="[@tabId==2 && 'cur']"><a href="javascript:void(0)" ms-click="changeTab($event)" data-tab-id="2">安全保障</a></li>
                <li ms-class="[@tabId==5 && 'cur']"><a href="javascript:void(0)" ms-click="changeTab($event)" data-tab-id="5">债权信息</a></li>
                <li ms-class="[@tabId==4 && 'cur']"><a href="javascript:void(0)" ms-click="changeTab($event)" data-tab-id="4">出借记录</a></li>
            </ul>
            <div class="js_tab_content">
                <div class="Js_tab_main current_tab_main v4-hidden-tabbox" ms-visible="@tabId==1">
                   @include('pc.invest.project.smartInvest/content')
                </div>

                <div class="Js_tab_main current_tab_main v4-hidden-tabbox" ms-visible="@tabId==2">
                    @include('pc.invest.project.smartInvest/security')
                </div>

                <div class="Js_tab_main current_tab_main v4-hidden-tabbox" ms-visible="@tabId==5">
                    @include('pc.invest.project.smartInvest/bond')
                </div>

                <div class="Js_tab_main current_tab_main v4-hidden-tabbox" ms-visible="@tabId==4">
                    @include('pc.invest.project.smartInvest/record')
                </div>
            </div>
            <!--tabouterbox-->
    </div>
    <script type="text/javascript" src="{{assetUrlByCdn('/static/js/interest/interest.js')}}"></script>
    <script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/project-detail.js')}}"></script>
    <script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/jquery.placeholder.js')}}"></script>
    <script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/jquery.poshytip.min.js')}}"></script>

    <script type="text/javascript">
    $.extend({
        checkedBox:function(checkbox,button){
            var $checkbox = $(checkbox),
                $button = $(button);
            $checkbox.on('change',function(){
                if($(this).is(':checked')){
                    $button.removeAttr("disabled").removeClass('disable');
                }else{
                    $button.attr("disabled","disabled").addClass('disable');
                }
            })
        },
        __noop: function(){}
    });
    $.checkedBox('#checkbox-1','.v4-input-btn');

    $('#evaluate1').poshytip({
            alignY: 'bottom',
            showTimeout: 100,
            alignTo: 'cursor'
        })
    </script>
</div>

<!-- ends -->
<div class="clear"></div>
@endsection




