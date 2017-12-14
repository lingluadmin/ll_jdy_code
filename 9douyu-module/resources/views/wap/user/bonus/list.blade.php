@extends('wap.common.wapBaseNew')

@section('title','我的优惠券')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/bonus.css')}}">
@endsection

@section('content')
    <article class="Js_tab_box">
        <header class="v4-header">
            <a href="javascript:;" class="v4-header-back" onclick="window.history.go(-1);">返回</a>
            <h1>我的优惠券</h1>
        </header>
        <div class="v4-bonus-main v4-bonus-mb" style="display: block;">
            <div class="v4-bonus-title">可使用优惠券(3张)</div>
            <!-- 红包 -->
            <div class="v4-bonus-box cash">
                <div class="v4-bonus-num">
                    <p><big>2%</big></p>
                    <p>满100元</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>员工福利2%</h3>
                    <p>优先项目 九安心1/3/6/12期<br>有效期：2016.12.31-2017.02.10</p>
                </div>
                <i class="v4-bonus-icon"></i>
                <i class="v4-bonus-select selected"></i>
            </div>
            
            <!-- 加息券 -->
            <div class="v4-bonus-box rate">
                <div class="v4-bonus-num">
                    <p><big>2%</big></p>
                    <p>满100元</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>员工福利2%</h3>
                    <p>优先项目 九安心1/3/6/12期<br>有效期：2016.12.31-2017.02.10</p>
                </div>
                <i class="v4-bonus-icon"></i>
                <i class="v4-bonus-select"></i>
            </div>
            
                
            <div class="v4-bonus-title">不可使用优惠券(2张)</div>
                   
            <!-- 红包 -->
            <div class="v4-bonus-box cash disable">
                <div class="v4-bonus-num">
                    <p><big>2%</big></p>
                    <p>满100元</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>员工福利2%</h3>
                    <p>优先项目 九安心1/3/6/12期<br>有效期：2016.12.31-2017.02.10</p>
                </div>
                <i class="v4-bonus-icon"></i>
            </div>
            
            <!-- 加息券 -->
            <div class="v4-bonus-box rate disable">
                <div class="v4-bonus-num">
                    <p><big>2%</big></p>
                    <p>满100元</p>
                </div>
                <div class="v4-bonus-info">
                    <h3>员工福利2%</h3>
                    <p>优先项目 九安心1/3/6/12期<br>有效期：2016.12.31-2017.02.10</p>
                </div>
                <i class="v4-bonus-icon"></i>
            </div>
        </div>

        
    </article>
    <a class="v4-bonus-btn" href="javascript:;">暂不使用优惠券</a>
@endsection

@section('jsScript')
<script type="text/javascript">

var evclick = "ontouchend" in window ? "touchend" : "click";
$('.v4-bonus-box').each(function(){
    $(this).on(evclick,function(){
        var $sel = $(this).find('.v4-bonus-select')
        if($sel.hasClass('selected')){
            $sel.removeClass('selected');
        }else{
            $sel.addClass('selected');

        }
    })
})

</script>
@endsection



