@extends('pc.common.layout')
@section('title', '企业荣誉')
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/partner/css/index.css')}}">
@endsection
@section('content')
<div class="partner-bg">
  <div class="partner-main">
    <h2><span>赚钱攻略</span></h2>
    <p>每日佣金收益=全部好友在投本金×佣金收益率÷365</p>
    <img src="{{assetUrlByCdn('/static/activity/partner/images/flow.png')}}" width="913" height="212">
  </div>
</div>
@endsection
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/tabs.js')}}"></script>
<script type="text/javascript">
  $(function(){
    $('.Js_tab_box1').tabs({action: "click" });
  })
</script>
@endsection