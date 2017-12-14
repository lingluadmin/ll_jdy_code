@extends('wap.common.activity')

@section('title', '12.12 狂欢嘉年华')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/doubleTwelve/css/index.css') }}">
@endsection

@section('content')
<section>
<div class="page-banner" >
    <div class="page-time">{{date('Y.m.d',$activityTime['start'])}}~{{date('Y.m.d',$activityTime['end'])}}</div>
</div>
<section ms-controller="activityHome" >
    <div class="page-box">
        <h2 class="page-title page-title-color1">
            <img src="{{ assetUrlByCdn('/static/weixin/activity/doubleTwelve/images/page-title1.png') }}" alt="" class="page-title1">
        </h2>
        <p class="page-text1">
            活动期间每日登录平台可领取双12投资红包<br>请在以下中任选一个领取
        </p>
        @include('wap.activity.doubleTwelve.bonus')
    </div>

    <div class="page-box">
        <h2 class="page-title">
            <img src="{{ assetUrlByCdn('/static/weixin/activity/doubleTwelve/images/page-title2.png') }}" alt="" class="page-title2">
        </h2>
        <div class="money-box">
            <div class="money-return">
                <img src="{{ assetUrlByCdn('/static/weixin/activity/doubleTwelve/images/money.png') }}">
                <p>用户在活动页面投资九安心、3月、6月、12月期项目，累积投资总金额≥1万元，除正常投资收益外，用户还可额外获得累计投资总金额*2‰的返现奖励。</p>
            </div>
            <div class="money-return-case">
                <p>投资九省心3月期项目3万元，投资九省心6月期项目7万元<br>累积总投资金额=<span>3</span>万元+<span>7</span>万元</p>
                <p>小王可获得<br>返现金额为:<big>10</big>万元*<big>2‰</big>=<big>200</big>元</p>
            </div>
        </div>
    </div>

    <div class="page-box">
        <h2 class="page-title page-title-color1">
            <img src="{{ assetUrlByCdn('/static/weixin/activity/doubleTwelve/images/page-title3.png') }}" alt="" class="page-title3">
        </h2>
        @include('wap.activity.doubleTwelve.project')
    </div>
</section>

<div class="page-rule">
    <h2>活动规则：</h2>
    <p>1、活动时间：{{date('Y年m月d日',$activityTime['start'])}}~{{date('Y年m月d日',$activityTime['end'])}}；</p>
    <p>2、双12投资红包有效期截止到{{date('Y年m月d日',$activityTime['end'])}}；</p>
    <p>3、请将app升级至4.2.2及以上版本，方可参与活动；</p>
    <p>4、活动期间累积提现金额≥5万元，将取消获得返现奖励的资格；</p>
    <p>5、仅限在活动页面投资项目才可计入累积投资金额，返现奖励将于2018年2月28日前发放；</p>
    <p>6、活动期间如有任何疑问请致电九斗鱼官方客服：</p>
    <p>400-6686-568，或登录九斗鱼咨询在线客服；</p>
    <p>本活动最终解释权归九斗鱼所有。</p>
</div>

<!-- pop -->
<div class="page-layer layer1">
    <div class="page-mask"></div>
    <div class="page-pop">
        <div class="page-pop-title">恭喜您
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer1">close</a>
        </div>
        <div class="page-pop-content">
            <p class="page-pop-text2 receive-success">成功领取XX元双12投资红包一个<br>请至“我的账户”中查看</p>
            <ul class="page-pop-coupon clearfix">
                <li>
                    <p><big id="bonus-value">30</big>元</p>
                    <p>恭喜您已领取</p>
                </li>
            </ul>
            <a href="javascript:;" class="page-pop-btn" data-toggle="mask" data-target="layer1">我知道了</a>
        </div>
    </div>
</div>

<div class="page-layer layer2">
    <div class="page-mask"></div>
    <div class="page-pop">
        <div class="page-pop-title">很抱歉
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer2">close</a>
        </div>
        <div class="page-pop-content">
            <img src="{{ assetUrlByCdn('/static/weixin/activity/doubleTwelve/images/page-pop-smile.png') }}" alt="" class="page-pop-smile">
            <p class="page-pop-text1">请登录后参加活动～</p>
            <a href="javascript:;" class="page-pop-btn userDoLogin">去登录</a>
        </div>
    </div>
</div>
<div class="page-layer layer3">
    <div class="page-mask"></div>
    <div class="page-pop">
        <div class="page-pop-title">很抱歉
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer3">close</a>
        </div>
        <div class="page-pop-content">
            <img src="{{ assetUrlByCdn('/static/weixin/activity/doubleTwelve/images/page-pop-smile.png') }}" alt="" class="page-pop-smile">
            <p class="page-pop-text1 error-message-common">您已领取过了哦~</p>
            <a href="javascript:;" class="page-pop-btn" data-toggle="mask" data-target="layer3">我知道了</a>
        </div>
    </div>
</div>

    <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
@endsection

@section('footer')

@endsection

@section('jsScript')
<script type="text/javascript" src="{{ assetUrlByCdn('static/weixin/activity/doubleTwelve/js/avtivity-double.js')}}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/pop.js')}}"></script>
<script type="text/javascript">
    document.body.addEventListener('touchstart', function () { });
    var evclick = "ontouchend" in window ? "touchend" : "click";
    // 显示弹窗
    $(document).on(evclick, '[data-target]',function(event){
        event.stopPropagation();
        var $this = $(this);
        var target = $this.attr("data-target");
        var $target = $("div[data-modul="+target+"]");
        $target.show();
        //禁止鼠标穿透底层
        $target.css('pointer-events', 'none');
        setTimeout(function(){
            $target.css('pointer-events', 'auto');
            $('#bonus_list').attr('attr-bonus-status','open')
        }, 400);
//        $("body,html").css({"overflow":"hidden","height":"100%"});
    })

    $(document).on('click',".receive-bonus",function(event){
        var _this = $(this);
        event.stopPropagation();
        if ("{{$userStatus}}" == false) {
            $(".layer2").show();
            return false;
        }
        var global_statsu=$('#bonus_list').attr('attr-bonus-status');
        if(global_statsu !='open'){
            return false;
        }
        var status = _this.attr('attr-bonus-status');
        if(status =='received'){
            $('.error-message-common').html('您已经领取过红包了');
            $(".layer3").show();
            return false;
        }
        var bonus_id =  _this.attr('attr-bonus-id');
        var position =  _this.attr('attr-bonus-position');
        $('#bonus_list').attr('attr-bonus-status','close')
        $.ajax({
            url: '/activity/doubleTwelve/doGetBonus',
            type: 'post',
            dataType:'json',
            data:{'_token':$('#csrf_token').val(),'receive_bonus':bonus_id},
            async:false,
            success: function(res){
                if (res.status == true) {
                    _this.addClass('active');
                    _this.find('.bonus-value').removeClass('in2');
                    _this.find('.bonus-value').addClass('in1');
                    var html = '<span class="des">恭喜您已领取</span>';
                    _this.append(html);
                    $(".receive-success").html('成功领取'+position+'元双投资红包一个<br/>请至“我的账户”中查看');
                    $("#bonus-value").html(position);
                    $('.layer1').show();
                } else {
                    $('.error-message-common').html(res.msg);
                    $(".layer3").show();
                }
            }

        })

    });
</script>
@endsection
