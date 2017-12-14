@extends('wap.common.activity')

@section('title', '幸运转转转')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/lottery/css/lottery.css') }}">

@endsection

@section('content')
<article>
    <!-- <section class="iphone8-banner">
        <p>活动时间：</p>
    </section> -->
    <section class="iphone8-lottery" id="btn-lottery-vip">
        <div id="lottery1" class="iphone8-lottery-main" data-lock="start" http_static_url="{{env ('STATIC_URL_HTTPS')}}">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="lottery-unit lottery-unit-0">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/lottery-img1.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-1">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/lottery-img2.png')}}" class="sp-img1"></div>
                    <td class="lottery-unit lottery-unit-2">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/lottery-img3.png')}}" ></div>
                    </td>
                </tr>
                <tr>
                    <td class="lottery-unit lottery-unit-7">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/lottery-img8.png')}}"></div>
                    </td>
                   @if( $userStatus == false)
                    <td><a href="javascript:;" class="lottery-btn disabled"  data-layer="page-layer-login" ></a></td>
                   @endif
                    @if( $userStatus == true)
                    <td><a href="javascript:;" class="lottery-btn" data-lock="start" onclick="doLotteryEvent(1)"></a></td>
                    @endif
                    <td class="lottery-unit lottery-unit-3">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/lottery-img4.png')}}"></div>
                    </td>
                </tr>
                <tr>
                    <td class="lottery-unit lottery-unit-6">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/lottery-img7.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-5">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/lottery-img6.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-4">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/lottery-img5.png')}}"></div>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    @if( !empty($lotteryList))
    <section class="iphone8-list">
        <h3>看看大家的手气</h3>
        <div class="iphone8-list-main" id="messageList">
            <ul>
                @foreach($lotteryList as $key => $lottery)
                <li class="hot"><span>{{$lottery['award_name']}}</span><em>{{$lottery['format_phone']}}</em></li>
                @endforeach
            </ul>
        </div>
    </section>
    @endif
    <section class="iphone8-rule">
        <h3><small></small>活动规则<small></small></h3>
        <p>1、活动时间自即日起至2017年11月13日23:59:59；</p>
        <p>2、本次活动所有平台用户均可参加；</p>
        <p>3、加息券、红包奖励将在用户兑奖成功后由客服统一发放；</p>
        <p>4、流量奖励将自动发放到用户注册手机号；</p>
        <p>5、未注册用户请注册成为平台用户后再领取奖励；</p>
        <p>6、如有其它疑问，请咨询在线客服（09:00~18:00）；</p>
        <p>7、本次活动解释权在法律允许范围内归耀盛中国拥有。</p>
    </section>
    
</article>
<!-- 抽奖失败 -->
<div class="page-layer-error" style="display: none;">
  <div class="page-mask"></div>
  <div class="page-pop pop-error">
    <span class="page-pop-close" data-toggle="mask" data-target="page-layer-error"></span>
    <div class="page-pop-content">
        <p><img src="{{ assetUrlByCdn('/static/weixin/activity/lottery/images/lottery/pop-error.png')}}" class="pop-error-img"></p>
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
      <p>抽中100M流量</p>
      <a href="javascript:;" data-toggle="mask" data-target="page-layer-lottery" class="page-pop-btn btn2">使用九斗鱼账号领取</a>
    </div>
  </div>
</div>
<div class="page-layer-login" style="display: none;" >
  <div class="page-mask"></div>
  <div class="page-pop pop-register">
    <span class="page-pop-close" data-toggle="mask" data-target="page-layer-login"></span>
    <div class="pop-register-title">完成注册领取奖品</div>
    <div class="page-pop-content2">
      <form action="/register/doRegister" method="post" id="iphone_registerForm">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="channel" value="{{ $channel or ''}}">
          <input type="hidden" name="redirect_url" value="{{$backUrl or ''}}">
          <input type="hidden" name="back_url" value="{{$backUrl or '' }}">
          <input type="hidden" name="aggreement" value="1">
        <ul class="v4-login v4-reg1">
            <li>
                 <input type="text" id="username1" name="phone" value="" placeholder="请输入手机号" data-pattern="registerphone" class="v4-reg-input">
            </li>
            <li>
                <input type="password" value="" placeholder="请设置6~16位字母和数字组合" name="password" id="password1" data-pattern="password" class="v4-reg-input">
                <span class="v4-reg-icon"></span>
            </li>
            <li>
                <input type="text" value="" placeholder="校验码" name="captcha" id="captchaCode" data-pattern="checkcode" class="v4-reg-input">
                <span><img id="captcha" class="v4-reg-code" src="/captcha/pc_register"  onclick="this.src=this.src+Math.random()"></span>
            </li>
            <li>
                <input type="text" value="" placeholder="请正确输入验证码" name="code" id="phoneCode" data-pattern="phonecode" class="v4-reg-input">
                <input value="获取验证码" id="code" type="button" class="v4-input-code iphone" default-value="获取验证码">
            </li>
        </ul>
        <div id="v4-input-msg" class="v4-input-msg"></div>
        <input type="submit" class="v4-input-btn" value="立即注册" id="v4-input-btn">
        <div class="pop-register-login"><a href="/login">已有账号，点这里</a></div>
    </form>
  </div>
  </div>
</div>


@endsection

@section('footer')

@endsection

@section('jsScript')
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/activity/lottery/js/lottery.js') }}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/account.js')}}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/activity/lottery/js/iphoneSendCode.js') }}"></script>
<script>
    document.body.addEventListener('touchstart', function () { });
    var evclick = "ontouchend" in window ? "touchend" : "click";
    // 滚动
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
        var activity    =   'inside';
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

    // 验证
    $(document).ready(function(){
        $.validation('#iphone_registerForm .v4-reg-input',{
            errorMsg:'#v4-input-msg',
        });
        // 表单提交验证
         $("#iphone_registerForm").bind('submit',function(){
            if(!$.formSubmitF('#iphone_registerForm .v4-reg-input',{
                fromT:'#iphone_registerForm'
            })) return false;
        });
    });

    $(document).on(evclick, '#lottery-btn-login', function (event) {
        event.stopPropagation();
        console.log('login');
        $('.page-layer-login').show();
        $('body,html').addClass('body-fix');
    })
    $(document).on(evclick, '#code', function (event) {
        event.stopPropagation();
        _phone.sendCode('iphone' ,{{env('PHONE_CONFIG.TIMEOUT')}});
    });
    </script>
@endsection
