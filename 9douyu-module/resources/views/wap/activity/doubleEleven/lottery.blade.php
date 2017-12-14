@extends('wap.common.activity')

@section('title', '11.11 理财节')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/css/lottery.css') }}">

@endsection

@section('content')
<article>
    <section class="iphone8-banner">
        <p>活动时间：{{date('m.d',$activityTime['start'])}}~{{date('m.d',$activityTime['end'])}}</p>
    </section>
    <section class="iphone8-lottery" id="btn-lottery-vip">
        <div id="lottery1" class="iphone8-lottery-main" data-lock="start" http_static_url="{{env ('STATIC_URL_HTTPS')}}">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="lottery-unit lottery-unit-0">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/lottery-img1.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-1">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/lottery-img2.png')}}" class="sp-img1"></div>
                    <td class="lottery-unit lottery-unit-2">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/lottery-img3.png')}}" ></div>
                    </td>
                </tr>
                <tr>
                    <td class="lottery-unit lottery-unit-7">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/lottery-img8.png')}}"></div>
                    </td>
                    @if($userStatus== false )
                    <td><a href="javascript:;" class="lottery-btn"  data-layer="page-layer-login" ></a></td>
                    @else
                    <td><a href="javascript:;" class="lottery-btn" data-lock="start" onclick="doLotteryEvent(1)"></a></td>
                    @endif
                    <td class="lottery-unit lottery-unit-3">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/lottery-img4.png')}}"></div>
                    </td>
                </tr>
                <tr>
                    <td class="lottery-unit lottery-unit-6">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/lottery-img7.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-5">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/lottery-img6.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-4">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/lottery-img5.png')}}"></div>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <section class="iphone8-list">
        <h3>看看大家的手气</h3>
        <div class="iphone8-list-main" id="messageList">
            <ul>
            @if( count ($lotteryList) <= 20 )
                <li class="cash"><span>20元</span><em>138****3817</em></li>
                <li class="cash"><span>2元</span><em>137****6889</em> </li>
                <li class="cash"><span>5元</span><em>150****8519</em></li>
                <li class="cash"><span>3元</span><em>136****8147</em></li>
                <li class="cash"><span>2元</span><em>150****3455</em></li>
                <li class="cash"><span>1元</span><em>157****5643</em></li>
                <li class="cash"><span>2元</span><em>137****2114</em></li>
                <li class="flow"><span>500M流量</span><em>157****1755</em></li>
                <li class="cash"><span>2元</span><em>157****6754</em></li>
                <li class="cash"><span>3元</span><em>186****8776</em></li>
                <li class="cash"><span>10元</span><em>150****0923</em></li>
                <li class="cash"><span>5元</span><em>186****3709</em></li>
            @else
                @foreach( $lotteryList as $lottery )
                @if($lottery['type'] ==\App\Http\Dbs\Activity\LotteryConfigDb::LOTTERY_TYPE_PHONE_FLOW)
                <li class="flow"><span>{{$lottery['award_name']}}</span><em>{{$lottery['format_phone']}}</em></li>
                @else
                <li class="cash"><span>{{$lottery['award_name']}}</span><em>{{$lottery['format_phone']}}</em></li>
                @endif
                @endforeach
            @endif
            </ul>
        </div>
    </section>
    
</article>
<!-- 抽奖失败 -->
<div class="page-layer-error" style="display: none;">
  <div class="page-mask"></div>
  <div class="page-pop pop-error">
    <span class="page-pop-close" data-toggle="mask" data-target="page-layer-error"></span>
    <div class="page-pop-content">
        <p><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/pop-error.png')}}" class="pop-error-img"></p>
        <p>抽奖失败</p>
        <p>请稍后再试！</p>
        <a href="javascript:;" data-toggle="mask" data-target="page-layer-error" class="page-pop-btn2">知道了</a>
    </div>
  </div>
</div>
<!-- End 抽奖失败 -->
<!-- 中奖 -->
<div class="page-layer-lottery" style="display: none;">
  <div class="page-mask"></div>
  <div class="page-pop">
    <span class="page-pop-close" data-toggle="mask" data-target="page-layer-lottery"></span>
    <div class="page-pop-content">
      <h4>恭喜啦</h4>
      <p>130*****888</p>
      <p>抽中100M流量</p>
      <div class="pop-bonus">100M流量</div>
      <a href="javascript:;" data-toggle="mask" data-target="page-layer-lottery" class="page-pop-btn btn2">立即兑换</a>
    </div>
  </div>
</div>
<div class="page-layer-login" style="display: none;">
    <div class="page-mask"></div>
    <div class="page-pop pop-error">
        <span class="page-pop-close" data-toggle="mask" data-target="page-layer-login"></span>
        <div class="page-pop-content">
            <p><img src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/images/lottery/pop-error.png')}}" class="pop-error-img"></p>
            <p>抽奖失败</p>
            <p>您还未登录！</p>
            <a href="javascript:;"  data-target="page-layer-login" class="page-pop-btn2 userDoLogin">立即登录</a>
        </div>
    </div>
</div>
@endsection

@section('footer')

@endsection

@section('jsScript')
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/activity/doubleEleven/js/lottery.js') }}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/account.js')}}"></script>
<script>
    document.body.addEventListener('touchstart', function () { });
    var evclick = "ontouchend" in window ? "touchend" : "click";
    $(document).ready(function() {
        setInterval(function () {
            $('#messageList').find("ul:first").animate({
                marginTop: "-2.325rem"
            }, 1000, function() {
                $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
            });
        }, 2000);

    });
    var click=false;
    function doLotteryEvent(id) {
        var lotteryLevel    =   'lottery' +  id;
        lottery.init(lotteryLevel);
        if ( click ) {//click控制一次抽奖过程中不能重复点击抽奖按钮，后面的点击不响应
            return false;
        }
        lottery.speed=100;
        var activity    =   'doubleEleven';
        lotteryEvent.doLottery(id,activity);
    }

  // 显示弹窗
  $(document).on(evclick, '[data-layer]',function(event){
      event.stopPropagation();
      var $this = $(this);
      var target = $this.attr("data-layer");
      var $target = $("."+target);
      $target.show();
      $target.css('pointer-events', 'none');
      setTimeout(function(){
          $target.css('pointer-events', 'auto');
      }, 400);
  })
  $(document).on(evclick, '[data-toggle="mask"]', function (event) {
        event.stopPropagation();
        var target = $(this).attr("data-target");
        var $target = $("."+target);
        $target.hide();

        $('body,html').removeClass('body-fix');
        //window.location.reload();
   })
    $(document).on(evclick, '#lottery-success', function (event) {
        event.stopPropagation();
        $('#page-layer-lottery-success').show();
    })

    </script>
@endsection
