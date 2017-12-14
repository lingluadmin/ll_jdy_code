@extends('wap.common.wapBaseLayoutNew')

@section('title','转出确认')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/confirm.css')}}">
@endsection
@section('content')
<article>

<nav class="v4-nav-top">
    <a href="javascript:void(0)" onclick="window.history.go(-1);"></a>转出确认
</nav>
<div class="v4-confirm-1">持有金额：{{number_format($current_cash,2)}}元</div>
<form action="/invest/project/doInvest" method="post" id="investOutConfirm" ms-controller="investOutConfirm">
    <input type="hidden" name="investOutMax" value="{{ $invest_out_max }}">
    <input type="hidden" name="currentCash" value="{{ $current_cash }}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="v4-confirm-2">
        <input type="text" placeholder="请输入转出金额" name="cashInput"  class="v4-input-1 m-input" id="cashInput" ms-keyup="checkMoney($event)">
        <div class="v4-confirm-cash">
            <span>当前可转出金额：{{number_format($invest_out_max,2)}}元</span>
        </div>
    </div>
     <section class="v4-tip error">
        <p>{% ajaxMsg %}</p>
    </section>
    <section class="v4-confirm-5">
        <input type="button" class="v4-btn next" id="doInvestOut" value="确认" ms-click="doInvestOut($event)">
        {{--<p class="v4-confirm-6"><input type="checkbox" id="checkbox_a1" ms-duplex-checked="isCheck"  class="chk_1" ms-click="cleanMsg('agree')" /><label for="checkbox_a1"></label><a href="{{assetUrlByCdn('/static/pdf/InvestmentAndManagement.pdf')}}">《投资咨询与管理服务协议》</a></p>--}}
    </section>

 <!-- 交易成功弹层开始 -->
    <section class="v4-pop layer-11" style="display:none;" id="v5-pop">
        <div class="v4-pop-mask"></div>
        <div class="v4-pop-main">
            <div class="v4-pop-sucess clearfix">
                <p class="v4-pop-icon"><span></span></p>
                <p class="v4-pop-text1">交易成功</p>
                <p class="v4-pop-text2" ms-click="jumpToCurrent($event)">完成</p>
            </div>
        </div>
    </section>
</form>
<!-- 交易成功结束 -->
</article>
<script src="{{ assetUrlByCdn('/static/weixin/js/lib/biz/user-current-out.js') }}"></script>
@endsection