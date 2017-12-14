@extends('wap.common.wapBaseNew')

@section('title', '九斗鱼理财')

@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/recharge.css')}}">
@endsection

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<article>
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">充值</h5>
        <div class="v4-user">
                <!-- <a href="/login">登录</a> | <a href="/register">注册</a> -->
                <a href="javascript:;" data-show="nav">我的</a>
        </div>
    </nav>
    <form action="/pay/submit" method="post" id="rapidFrom">
        <div class="recharge-bank">
            <img src="{{assetUrlByCdn('/static/app/images/bank/'.$authCard['info']['bank_id'].'.png')}}">
            <span>{{ $authCard['info']['bank_name'] }}</span>
            <span>尾号{{ substr($authCard['info']['card_no'],-4)}}</span>
        </div>

        <div class="recharge-pay" id="payChannel">
            <a href="javascript:;">
                <ins></ins>
                <span id="getChannel">选择支付渠道</span>
                <i></i>
            </a>
        </div>

        <div class="recharge-main">
            <p>充值金额</p>
            <div class="recharge-main-input">
                <span>￥</span><input type="text" placeholder="请输入充值金额" class="recharge-input" id="rechargeCash" name="cash">
            </div>
        </div>
        <div class="recharge-info">快捷充值最低<span>100</span>元</div>
        <input type="hidden"    name="_token"  value="{{csrf_token()}}">
        <input type="hidden"    name="payType" value="2">
        <input type="hidden"    name="channel"      id="channel"    />
        <input type="hidden"    name="realLimit"    id="realLimit"  />
        <input type="hidden"    name="minRecharge"  id="minRecharge" value="{{ $withholding_recharge_min_money or 0 }}" />
        <input type="hidden"    name="maxRecharge"  id="maxRecharge" value="{{ $authCard['limit']['cash']  or 0 }}" />

        <div id="v4-input-msg" class="v4-input-msg">@if(Session::has('errors')){{  Session::get('errors') }}@endif</div>
        <input type="submit" class="v4-btn next" id="subInvestProject" value="确认">
    </form>
</article>
<section class="v4-pop-wrap">
    <div class="v4-pop-mask none "></div>
    <div class="v4-pop-pay">
        <span class="v4-pop-close"></span>
        @if( !empty( $authCard['list'] ) )
            @foreach($authCard['list'] as $val)
            <div class="v4-pop-pay-box" bvalue="{{$val['pay_type']}}" data-cash="{{$val['real_limit']}}">
                <p><img src="{{assetUrlByCdn('/static/weixin/images/wap4/recharge/'.$val['pay_type'].'.png')}}" class="pay1">@if( $val["is_recommend"] == 1 )<ins class="pay-rec">推荐</ins>@endif</p>
                <p><big>{{ $typeList[$val['pay_type']]['name'] }}</big></p>
                <p class="v4-pop-pay-txt">单笔限额<em>{{ $val['limit'] or 0 }}元</em></p>
                <p class="v4-pop-pay-txt">当日限额剩余<em>{{ $val['day_free_limit'] or 0 }}元</em></p>
            </div>
            @endforeach
        @else
            <div class="v4-pop-pay-box">
                暂无可用通道
            </div>
        @endif
            {{--
            <div class="v4-pop-pay-box">
                <p><img src="{{assetUrlByCdn('/static/weixin/images/wap4/recharge/pay2.png')}}" class="pay2"></p>
                <p><big>丰付支付</big></p>
                <p class="v4-pop-pay-txt">单笔限额<em>50,000元</em></p>
                <p class="v4-pop-pay-txt">当日限额剩余<em>1,000.000元</em></p>
            </div>
            <div class="v4-pop-pay-box">
                <p><img src="{{assetUrlByCdn('/static/weixin/images/wap4/recharge/pay3.png')}}" class="pay3"></p>
                <p><big>宝付支付</big></p>
                <p class="v4-pop-pay-txt">单笔限额<em>50,000元</em></p>
                <p class="v4-pop-pay-txt">当日限额剩余<em>1,000.000元</em></p>
            </div>
            --}}
    </div>
</section>
    
    <!-- 侧边栏 -->
    @include('wap.home.nav')
 
@endsection


@section('jsScript')
<script>
(function($){
    $(function(){

        var maxRecharge = $("#maxRecharge").val();
        var minRecharge = $("#minRecharge").val();
        maxRecharge     = parseInt(maxRecharge);
        minRecharge     = parseInt(minRecharge);


        var evclick = "ontouchend" in window ? "touchend" : "click";
        $('#payChannel').on(evclick,function(){
            $('.v4-pop-mask').removeClass('none');
            $('.v4-pop-pay').addClass('show');
            $("html,body").css({"height":"100%","overflow":"hidden"});
        });
        $('.v4-pop-close,.v4-pop-mask').on(evclick,function(){
            $('.v4-pop-mask').addClass('none');
            $('.v4-pop-pay').removeClass('show');
            $("html,body").css({"height":"auto","overflow":"auto"});
        });

        // select
        $(".v4-pop-pay-box").on(evclick,function(){
            $("#getChannel").html($(this).find("big").html());

            $("#channel").val($(this).attr("bvalue"));
            $("#realLimit").val($(this).attr("data-cash"));

            $('.v4-pop-mask').addClass('none');
            $('.v4-pop-pay').removeClass('show');
            $("html,body").css({"height":"auto","overflow":"auto"});
            
        });

        $("#rechargeCash").blur(function() {

            cashValitate()

        });
        // check data
        function  cashValitate() {

            var cash    = $("#rechargeCash").val();

            var cashPatten  = /^[1-9]\d{0,}$/
            var cashV       = $.trim(cash)
            // alert(cashPatten.test(cashV))
            if( !cashPatten.test(cashV)){
                $(".v4-input-msg").html("请输入有效充值金额");
                $("#rechargeCash").val("")
                return false;
            }

            cash        = parseInt(cash);

            if( !cash ) {
                $(".v4-input-msg").html(minRecharge + "元起充，请输入充值金额");
                return false;
            } else if( Number(cash) < minRecharge ){
                $('.v4-input-msg').html("最小充值金额为" + minRecharge +"元");
                return false;
            } else if( Number(cash) > maxRecharge ) {
                $(".v4-input-msg").html("最大充值金额为"+maxRecharge+"元");
                return false;
            } else if( maxRecharge <=0 ){
                $(".v4-input-msg").html("今日已达限额，请明日再来");
                return false;
            }else {
                $(".v4-input-msg").html("");
                return true;
            }
        }


        // 表单提交验证
        $("#rapidFrom").bind('submit',function(){
            // if(!$.formSubmitF('.v4-input',{
            //    fromT:'#rapidFrom'
            // })) return false;
            if( !cashValitate() ) return false;

            var channel = $("input[name=channel]").val();
            if(!channel){
                $(".v4-input-msg").html("请选择支付渠道");
                return false;
            }

            var cash    = $("#rechargeCash").val();
            cash        = parseInt(cash);
            var realLimit   = $("input[name=realLimit]").val();
            realLimit       = parseInt(realLimit);

            if( cash > realLimit ){
                $(".v4-input-msg").html("该通道最多可充值"+realLimit+'元');
                return false;
            }

        });

    })
})(jQuery)
</script>

@endsection

