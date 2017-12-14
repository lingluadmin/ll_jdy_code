@extends('wap.common.activity')

@section('title', '护住你的肾，九斗鱼送iPhone8啦')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/iphone8/css/index.css') }}">

@endsection

@section('content')
<article>
    <section class="iphone8-banner">
        <span>广<br>告</span>
    </section>
    <section class="iphone8-lottery" id="btn-lottery-vip">
        <div id="lottery1" class="iphone8-lottery-main" data-lock="start" http_static_url="{{env ('STATIC_URL_HTTPS')}}">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="lottery-unit lottery-unit-0">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/lottery-img1.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-1">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/lottery-img2.png')}}" class="sp-img1"></div>
                    <td class="lottery-unit lottery-unit-2">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/lottery-img3.png')}}" ></div>
                    </td>
                </tr>
                <tr>
                    <td class="lottery-unit lottery-unit-7">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/lottery-img8.png')}}"></div>
                    </td>
                    @if($userStatus== false )
                    <td><a href="javascript:;" class="lottery-btn"  id="lottery-btn-login" ></a></td>
                    @elseif( !empty($exchange) && $verify == true)
                        <td><a href="javascript:;" class="lottery-btn" data-lock="start" id="lottery-success" ></a></td>
                    @else
                    <td><a href="javascript:;" class="lottery-btn" data-lock="start" id="lottery-btn1" onclick="doLotteryEvent(1)"></a></td>
                    @endif
                    <td class="lottery-unit lottery-unit-3">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/lottery-img4.png')}}"></div>
                    </td>
                </tr>
                <tr>
                    <td class="lottery-unit lottery-unit-6">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/lottery-img7.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-5">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/lottery-img6.png')}}"></div>
                    </td>
                    <td class="lottery-unit lottery-unit-4">
                        <div class="sp-bg"><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/lottery-img5.png')}}"></div>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <section class="iphone8-list">
        <h3>看看大家的手气</h3>
        <div class="iphone8-list-main" id="messageList">
            <ul>
            @if($lotteryList['lotteryNum'] <= 20 )
                <li><i>超级大奖</i><span>iPhone X 一部</span><em>157****1755</em></li>
                <li><span>100M流量</span><em>136****3817</em></li>
                <li><i>大奖</i><span>500M流量</span><em>139****6889</em> </li>
                <li><i>超级大奖</i><span>iPhone 8p 一部</span><em>150****8519</em></li>
                <li><span>10M流量</span><em>136****8147</em></li>
                <li><span>30M流量</span><em>150****2714</em></li>
                <li><span>10M流量</span><em>151****9829</em></li>
                <li><i>大奖</i><span>500M流量</span><em>157****8783</em> </li>
                <li><span>100M流量</span><em>151****9966</em></li>
                <li><i>大奖</i><span>iwatch 3 一部</span><em>134****4946</em></li>
                <li><span>10M流量</span><em>131****5250</em></li>
                <li><span>100M流量</span><em>152****0151</em></li>
                <li><i>大奖</i><span>500M流量</span><em>186****5589</em> </li>
                <li><span>30M流量</span><em>186****3891</em></li>
                <li><span>30M流量</span><em>139****0402</em></li>
                <li><span>30M流量</span><em>183****8164</em></li>
                <li><span>10M流量</span><em>136****7671</em></li>
                <li><span>10M流量</span><em>134****1728</em></li>
                <li><span>10M流量</span><em>158****4475</em></li>
                <li><i>大奖</i><span>iPhone 8 一部</span><em>156****6889</em></li>
                <li><span>100M流量</span><em>182****3960</em></li>
            @else
                @foreach( $lotteryList['list'] as $lottery )
                    @if( strpos( strtolower($lottery['award_name']),'x')!== false )
                    <li><i>超级大奖</i><span>iPhone X 一部</span><em>{{\App\Tools\ToolStr::hidePhone ($lottery['phone'],3, 4)}}</em></li>
                    @elseif(strpos(strtolower($lottery['award_name']),'8p')!== false)
                    <li><i>超级大奖</i><span>{{$lottery['award_name']}} 一部</span><em>{{\App\Tools\ToolStr::hidePhone ($lottery['phone'],3, 4)}}</em></li>
                    @elseif(strpos(strtolower($lottery['award_name']),'iwatch')!== false)
                    <li><i>大奖</i><span>{{$lottery['award_name']}} 一部</span><em>{{\App\Tools\ToolStr::hidePhone ($lottery['phone'],3, 4)}}</em></li>
                    @elseif(strpos(strtolower($lottery['award_name']),'iphone')!== false)
                    <li><i>大奖</i><span>{{$lottery['award_name']}} 一部</span><em>{{\App\Tools\ToolStr::hidePhone ($lottery['phone'],3, 4)}}</em></li>
                    @elseif(strpos(strtolower($lottery['award_name']),'500')!== false)
                    <li><i>大奖</i><span>{{$lottery['award_name']}}</span><em>{{\App\Tools\ToolStr::hidePhone ($lottery['phone'],3, 4)}}</em></li>
                    @else
                    <li><span>{{$lottery['award_name']}}</span><em>{{\App\Tools\ToolStr::hidePhone ($lottery['phone'],3, 4)}}</em></li>
                    @endif
                @endforeach
            @endif
            </ul>
        </div>
    </section>
    <section class="iphone8-rule">
        <h3><small>•</small>活动规则<small>•</small></h3>
        <p>1、活动时间：{{date('Y年m月d日',$activityTime['start'])}}~{{date('Y年m月d日',$activityTime['end'])}};</p>
        <p>2、参与用户：此页面新注册的用户，可参与抽奖；</p>
        <p>3、实物中奖用户，兑奖后九斗鱼客服将在3个工作日内与您联系并确定奖品邮寄事宜；</p>
        <p>4、流量中奖用户，兑奖后系统自动将流量充值到注册的手机号中；</p>
        <p>5、活动时间范围内可兑换奖品，活动时间以外不可兑奖；</p>
        <p>6、本活动奖品的售后服务事宜，请与奖品厂商联系，九斗鱼不承担售后工作；</p>
        <p>7. 其他问题，请咨询客服400-6686-568 (9:00~18:00) 。</p>
    </section>
</article>
<!-- 抽奖失败 -->
<div class="page-layer-error" style="display: none;">
  <div class="page-mask"></div>
  <div class="page-pop pop-error">
    <span class="page-pop-close" data-toggle="mask" data-target="page-layer-error"></span>
    <div class="page-pop-content">
        <p><img src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/images/pop-error.png')}}" class="pop-error-img"></p>
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
@if( !empty($exchange) && $verify==true && ($exchange['type'] == \App\Http\Dbs\Activity\LotteryConfigDb::LOTTERY_TYPE_PHONE_FLOW||$exchange['type'] == \App\Http\Dbs\Activity\LotteryConfigDb::LOTTERY_TYPE_PHONE_CALLS))
<div class="page-layer-lottery-success" id="page-layer-lottery-success">
    <div class="page-mask"></div>
    <div class="page-pop">
        <span class="page-pop-close" data-toggle="mask" data-target="page-layer-lottery-success"></span>
        <div class="page-pop-content">
            <h4>恭喜啦</h4>
            <p>{{\App\Tools\ToolStr::hidePhone ($exchange['phone'] ,3,4)}}</p>
            <p>已充入您绑定手机中</p>
            <div class="pop-bonus">{{$exchange['award_name']}}流量</div>
            <a href="/redirect/noviceProject"  data-target="page-layer-lottery-success" class="page-pop-btn">立即体验年化11%新手项目</a>
        </div>
    </div>
</div>
@endif
<!-- End 中奖 -->

<!-- 注册弹窗 -->
<div class="page-layer-login" style="display: none;" >
  <div class="page-mask"></div>
  <div class="page-pop pop-register">
    <span class="page-pop-close" data-toggle="mask" data-target="page-layer-login"></span>
    <div class="pop-register-title">先报名 再抽奖</div>
    <div class="page-pop-content2">
      <form action="/register/doRegister" method="post" id="iphone_registerForm">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="channel" value="{{ $channel}}">
          <input type="hidden" name="redirect_url" value="{{$redirect_url}}">
          <input type="hidden" name="back_url" value="{{ $backUrl}}">
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
        <div id="v4-input-msg" class="v4-input-msg">  @if(Session::has('errorMsg')){{Session::get('errorMsg')}}@endif </div>
        <input type="submit" class="v4-input-btn" value="报名抽大奖" id="v4-input-btn">
        <div class="pop-register-login"><a href="/login">已有账号，点这里</a></div>
    </form>
  </div>
</div>
@if( env('APP_ENV') == 'production' )
@include('wap.common.sharejs')
@endif
<!-- End 注册弹窗 -->
@endsection

@section('footer')

@endsection

@section('jsScript')
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/js/lottery.js') }}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/account.js')}}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/activity/iphone8/js/iphoneSendCode.js') }}"></script>
    <script>
        document.body.addEventListener('touchstart', function () { });

    // 文字滚动
    function AutoScroll(obj) {
        $(obj).find("ul:first").animate({
            marginTop: "-2.325rem"
        }, 1000, function() {
            $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
        });
    }

    $(document).ready(function() {
        setInterval('AutoScroll("#messageList")', 2000);

    });
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

    var click=false;
    function doLotteryEvent(id) {
        var lotteryLevel    =   'lottery' +  id;
        lottery.init(lotteryLevel);
        if ( click ) {//click控制一次抽奖过程中不能重复点击抽奖按钮，后面的点击不响应
            return false;
        }
        lottery.speed=100;
        var activity    =   'iphone8';
        lotteryEvent.doLottery(id,activity);
    }

  // pop
  var evclick = "ontouchend" in window ? "touchend" : "click";
  // 显示弹窗
  $(document).on("click", '[data-layer]',function(event){
      event.stopPropagation();
      var $this = $(this);
      var target = $this.attr("data-layer");
      var $target = $("."+target);
      $target.show();
  })
  $(document).on(evclick, '[data-toggle="mask"]', function (event) {
        event.stopPropagation();
        var target = $(this).attr("data-target");
        var $target = $("."+target);
        $target.hide();

        $('body,html').removeClass('body-fix');
        //window.location.reload();
   })
    $(document).on(evclick, '#lottery-btn-login', function (event) {
        event.stopPropagation();
        console.log('login');
        $('.page-layer-login').show();
        $('body,html').addClass('body-fix');
    })
    $(document).on(evclick, '#lottery-success', function (event) {
        event.stopPropagation();
        $('#page-layer-lottery-success').show();
    })
    $(document).on(evclick, '#code', function (event) {
        event.stopPropagation();
        _phone.sendCode('iphone' ,{{env('PHONE_CONFIG.TIMEOUT')}});
    });
    </script>
@endsection
