@extends('pc.common.layout')

@section('title', '注册送888元红包')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/novice/css/index_baidu.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
<!-- content -->
@section('header')
    <div class="landon-header">
        <div class="landon-reg">
            <h1 class="landon-header-logo">
                <a href="/"></a>
           </h1>
           <div class="landon-user-info">
            <span>
                @if(empty($view_user))
                    已有账号？<a href="/login" class="login">立即登录</a>
                   @else
                    您好，<a href="/user" class="login">@if(!empty($view_user['real_name'])) {{$view_user['real_name']}}@else {{ \App\Tools\ToolStr::hidePhone($view_user['phone'], 3, 4)}}  @endif</a><a href="{{url('logout')}}">［退出］</a>
                @endif
            </span>
           </div>
        </div>
    </div>
@endsection
@section('content')

<div class="page-banner" id="register-paper">
    @if($userStatus == false)
    <div class="page_wrap">
        <form action="/register/doRegister" method="post" id="two_form_registerForm" name="two_code_registerForm" onsubmit="return false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="channel" value="{{ $channel}}">
            <input type="hidden" name="back_url" value="{{ $registerUrl}}">
            <h2 class="page_title"><span></span>注册领888元红包</h2>
            <ul class="v4-login v4-reg1">
                <li>
                     <input type="text" id="username1" name="phone" value="" placeholder="请输入手机号" data-pattern="registerphone"  class="v4-reg-input" />
                </li>
                <li>
                    <input type="password" value="" placeholder="设置6~16位字母及数字组合"  name="password"  data-pattern="password"  class="v4-reg-input" />
                    <span  class="v4-reg-icon v4-iconfont" >&#xe6a1;</span>

                </li>
                <li>
                    <input type="text" value="" placeholder="校验码"  name="captcha" id="captchaCode" data-pattern="checkcode" class="v4-reg-input" />
                    <span><img id="captcha" class="v4-reg-code"  src="/captcha/pc_register" width="104" height="40" onclick="this.src=this.src+Math.random()"></span>
                </li>
                <li>
                    <input type="text" value="" placeholder="短信验证码"  name="phone_code"  data-pattern="phonecode"  class="v4-reg-input" />
                    <input value="获取验证码" type="button" class="v4-input-code two_form">
                </li>
            </ul>
            <div id="v4-input-msg2" class="v4-input-msg">@if(Session::has('errorMsg')){{Session::get('errorMsg')}}@endif</div>
            <div class="v4-input-agree">
                <label><input type="checkbox" name="aggreement" checked="checked" id="checkbox-2"> 我已阅读并同意<a href="/registerAgreement" class="blue" target="_blank">《九斗鱼会员注册协议》</a></label>
            </div>
            <input type="hidden" name="request_source" value="1" class="mr5">
            <input type="submit" class="register-input-btn" value="注册完成" id="v4-input-btn-2">
        </form>
    </div>
    @endif
</div>

<div class="landon-box">
    <h1 class="title">新手操作流程</h1>
    <div class="landon-flow"></div>
    <ul class="landon-flow-text clearfix">
        <li class="li1">注册<br>送<span>888</span>元红包</li>
        <li class="li2">账户<br>实名认证</li>
        <li class="li3">账户<br>充值</li>
        <li class="li4">投资<br>新手专享项目</li>
        <li class="li5">坐等<br>收益到账</li>
    </ul>
</div>

<div class="landon-outer">
<div class="landon-box">
    <h1 class="title">新手888元红包</h1>
    <div class="sub"></div>
    <div class="landon-lucky"></div>
    @if($userStatus == true)
        <a href="javascript:;" class="landon-btn-oth disable">已领取</a>
    @else
        <a href="#register-paper" class="landon-btn">一键领取888元</a>
    @endif
</div>
</div>


<!-- project -->
<div class="landon-box">
    <h1 class="title">新手专享项目</h1>
    <div class="landon-project">
        <table>
            <tr>
                <td class="td1">
                    <p class="text-color-red">{{$project['base_rate'] or 9}}<em>%@if( isset($project['after_rate']) && $project['after_rate']>0)+{{$project['after_rate'] or 2}}%@endif</em></p>
                    <span>借款利率</span>
                </td>
                <td class="td2">
                    <p>5<em>万元</em></p>
                    <span>单人限额</span>
                </td>
                <td class="td3">
                    <p>{{$project['format_invest_time'] or 30}}<em>{{$project['invest_time_unit'] or '天'}}</em></p>
                    <span>借款期限</span>
                </td>
                <td class="td4">
                    <p>100<em>元</em></p>
                    <span>起投金额</span>
                </td>
                <td align="right">
                    @if( $isNovice == true)
                        <a href="/redirect/noviceProject" class="landon-btn landon-btn-invest">立即投资</a>
                    @else
                        <a href="javascript:;" class="landon-btn landon-btn-invest disable">立即投资</a>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page-box clearfix">
    <div class="page-calculator">
        <div class="page-des">
            <p class="invest_rate_note">预期年利率：{{$project['base_rate'] or 9}}%@if($project['after_rate'] >0)+{{$project['after_rate'] or 2}}% @endif</p>
            <p>预期总收益：<span class="invest_cash_profit">91.67</span>元</p>
        </div>
        <p class="page-text">选择投资周期</p>
        <div class="page-calculator-btn invest_time_unit">
            <a href="javascript:;" class="active" attr-invest-type='100' attr-invest-time="{{$project['format_invest_time'] or 30}}" attr-invest-rate="{{$project['base_rate'] or 9}} +{{$project['after_rate'] or 2}} ">新手专享项目</a>
            <a href="javascript:;" attr-invest-type='200' attr-invest-time="3" attr-invest-rate="11">3个月</a>
            <a href="javascript:;" attr-invest-type='200' attr-invest-time="6" attr-invest-rate="11.5">6个月</a>
            <a href="javascript:;" attr-invest-type='200' attr-invest-time="12" attr-invest-rate="12">12个月</a>
        </div>
        <p class="page-text">输入投资金额</p>
        <div class="page-textarea">
            <input type="text" name="invest_cash" value="10000" placeholder="10000">
        </div>
         <input type="hidden" name="invest_time" value="{{$project['format_invest_time'] or 30}}">
         <input type="hidden" name="invest_rate" value="{{$project['profit_percentage'] or 11}}">
         <input type="hidden" name="invest_type" value="100">
         <a href="javascript:;" class="landon-btn landon-btn-invest">开始计算</a>
    </div>

    <div class="page-scroll">
        <h2><span></span>大家都在投资</h2>
        <div style="overflow: hidden;" id="messageList">

            <ul>
            @if( !empty($investList) )
                @foreach($investList as $key => $invest)
            <li><p><span>{{date('m/d',$invest['time'])}}</span>{{$invest['username']}} 投资了<em>{{$invest['invest_cash']}}</em>元</p></li>
                @endforeach
            @endif
            </ul>

        </div>

    </div>
</div>


<!-- 优势 -->
<div class="landon-advantage">
    <div class="landon-box">
        <h1 class="title">九斗鱼优势</h1>
        <div class="landon-advantage-img"></div>
        <ul class="landon-advantage-text clearfix">
            <li class="li1">
                <h5>集团实力</h5>
                <p>母公司耀盛中国为中港两地持牌金融机构，涵盖网络小贷、企业征信、私募基金、香港证券经纪等9张金融牌照</p>
            </li>
            <li class="li2">
                <h5>安全合规</h5>
                <p>平台稳定运营超3年，累计投资人数超17万，江西银行资金存管，全程交易签署具有法律效力的电子合同</p>
            </li>
             <li class="li3">
                <h5>收益稳健</h5>
                <p>预期年化利率7%~12%，项目期限1~12个月灵活可选，100元起投，无额外开户费用及交易费用</p>
            </li>
        </ul>
    </div>
</div>

<!-- 背景图定位 -->
<div class="pos1"></div>
<div class="pos2"></div>
@section('footer')
    <div class="v4-footer-bottom">
    <div class="v4-wrap hidden">
        <div class="v4-footer-copyright">
            <p>星果时代信息技术有限公司版权所有&nbsp;&nbsp;京ICP备16011752号-1&nbsp;&nbsp;<a href="http://www.beian.gov.cn/portal/registerSystemInfo" rel='nofollow' target="_blank"><img src="https://img1.9douyu.com/static/images/pc4/v4-installation.png?v=10000237" width="20" height="20"> 京公网安备 11010502033496号</a></p>
            <p>Copyright©2017 9douyu. All Right Reserved&nbsp;&nbsp; &nbsp;&nbsp;    风险提示：网贷有风险，出借需谨慎</p>
        </div>
        <div class="v4-footer-checkwebsite">
            <ul>
                <li><a href="https://trustsealinfo.verisign.com/splash?form_file=fdf/splash.fdf&dn=www.jiudouyu.com&lang=zh_cn" target="_blank" rel="nofollow" class="v4-footer-icon2"></a></li>
                <li><a href="http://www.itrust.org.cn/Home/Index/itrust_certifi?wm=1A00257T3R" target="_blank" rel="nofollow" class="v4-footer-icon4"></a></li>
            </ul>
        </div>
    </div>
</div>

<!-- fixed bottom -->
<div class="landon-fixed-bottom">
    <!-- 已注册 -->
@if( $userStatus == true )
    <a href="/project/index" class="landon-btn">立即投资</a>
@endif
<!-- 未注册 -->
@if( $userStatus == false )
    <a href="#register-paper" class="landon-btn landon-register-btn" data-target="module">注册送888元红包</a>
@endif
</div>
@endsection
@endsection

<!-- js -->
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/static/js/custodyAccount.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    (function($){
        $(document).ready(function(){
            $('.two_form').click(function(){
                sendPhoneCode('two_form');
            });
        });
    })(jQuery);
    function sendPhoneCode( element ) {
        var timeout=0, maxTimeout = {{env('PHONE_CONFIG.TIMEOUT')}};
        var desc    = "秒后重发";
        var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[0135678])\d{8}$/;
        var  baseElementObj =   $("#" + element+ '_' + 'registerForm') ;
        var  phone      =   $.trim(baseElementObj.find("input[name='phone']").val());
        var  captcha    =   $.trim(baseElementObj.find("input[name='captcha']").val());
        baseElementObj.find(".v4-input-msg").html("")
        if( phone == ''){
            baseElementObj.find(".v4-input-msg").html("请输入手机号")
            return false;
        }
        if( phone.length != 11 ) {
            baseElementObj.find(".v4-input-msg").html("手机号码位数不正确");
            return false;
        }
        if(!phone.match(pattern) ) {
            baseElementObj.find(".v4-input-msg").html("手机号不正确")
            return false;
        }
        if(captcha == ''){
            baseElementObj.find(".v4-input-msg").html("请输入校验码")
            return false;
        }
        $.ajax({
            url : '/register/sendSms',
            type: 'POST',
            dataType: 'json',
            data: {'phone': phone,'captcha':captcha},
            success : function(result) {
                sendRes = result;
                if(sendRes.captcha === false && options.captcha) {
                    $(".captcha").click();
                }
                if(sendRes.status) {
                    if(timeout <= 0) {
                        timeout = maxTimeout;
                        $('.'+element).addClass("disable").val(timeout + desc).attr("disabled", true);
                    }
                    var timer = setInterval(function() {
                        timeout--;
                        if(timeout > 0) {
                            $('.'+element).addClass("disable").val(timeout + desc);
                        } else {
                            $('.'+element).removeClass("disable").val('获取验证码').attr("disabled", null);
                            clearInterval(timer);
                        }
                    }, 1000);
                    baseElementObj.find(".v4-input-msg").html('验证码已发送到'+ phone +'手机，请您查收。')
                } else {
                    baseElementObj.find(".v4-input-msg").html(sendRes.msg);
                    baseElementObj.find("input[name='captcha']").val('');
                }
            },
            error : function(msg) {
                codeObj.attr("disabled", null);
                $("v4-input-msg").text("服务器端错误，请点击重新获取").show();
                clearInterval(timer);
            }
        });
    }
</script>
<script>

    $(document).ready(function() {
        setInterval(function () {
            $('#messageList').find("ul:first").animate({
                marginTop: "-35px"
            }, 1200, function() {
                $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
            });
        }, 2000);
    });
    $(document).ready(function () {
        $('.invest_time_unit a').on('click',function () {
            var _this   =   $(this);
            $('.invest_time_unit').find('a').removeClass('active');
            _this.addClass('active');
            var invest_time =   _this.attr('attr-invest-time');
            var invest_rate =   _this.attr('attr-invest-rate');
            var invest_reg  =   /\+/;
            var invest_rate_note = '预期年利率：'+invest_rate+'%';
            if( invest_reg.exec(invest_rate)){
                var  rateArr=   invest_rate.split('+');
                invest_rate =   parseInt(rateArr[0])+parseInt(rateArr[1]);
                invest_rate_note    =   '预期年利率：'+rateArr[0]+'%';
                if(rateArr['1'] >0){
                    invest_rate_note = invest_rate_note + '+'+rateArr['1']+"%";
                }
            }
            var invest_type =   _this.attr('attr-invest-type');
            $("input[name='invest_time']").val(invest_time);
            $("input[name='invest_rate']").val(invest_rate);
            $("input[name='invest_type']").val(invest_type);
            var invest_cash =   $("input[name='invest_cash']").val();
            var invest_profit = getInvestProfit(invest_time , invest_cash , invest_rate , invest_type);
            $('.invest_rate_note').html(invest_rate_note);
            $('.invest_cash_profit').html(invest_profit);

        })
        getInvestProfit = function (time , cash , rate,type) {
            if( time == '') {
                time = 30;
            }
            if( cash == '' ){
                cash = 10000;
            }
            if (rate =='') {
                rate = 11;
            }
            if( type == 100 ){
                return ((cash * rate / 100 /365 ) * time ) .toFixed(2);
            }
            return ((cash * rate / 100 /12 ) * time ) .toFixed(2);
        }
        loadInvestProfit  =   function(){
            var invest_cash =   $("input[name='invest_cash']").val();
            var invest_time =   $("input[name='invest_time']").val();
            var invest_type =   $("input[name='invest_type']").val();
            var invest_rate =   $("input[name='invest_rate']").val();
            var invest_profit = getInvestProfit(invest_time , invest_cash , invest_rate ,invest_type);
            $('.invest_cash_profit').html(invest_profit);
        }
        $('.landon-btn-invest').on('click' , function () {
            loadInvestProfit();
        });
        loadInvestProfit();
    })
</script>
<script type="text/javascript">
    $(function(){
        $.checkedBox('#checkbox-2','#v4-input-btn-2');

         $.validation('#two_form_registerForm .v4-reg-input',{
                errorMsg:'#v4-input-msg2',
                className:'red'
            });
            // 表单提交验证
        $("#two_form_registerForm").bind('submit', function () {
            if ( !$.formSubmitF('#two_form_registerForm .v4-reg-input',
                    {
                        fromT: '#two_form_registerForm',
                        fromErrorMsg: '#v4-input-msg2',
                        className: 'red'
                    })
            ){
                return false;
            } else {
                $.ajax({
                    url : $('#two_form_registerForm').attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: $('#two_form_registerForm').serialize(),
                    success : function(result) {
                        if(result.code == 500){
                            $("#v4-input-msg2").text(result.msg);
                        }
                        if(result.code == 200){
                            window.location.href = result.data.url;
                        }
                    },
                    error : function(msg) {
                        $("#v4-input-msg2").text("服务器端错误，请点击重新获取");
                    }
                });
                $("#two_form_registerForm").data("lock", false);
            }
        });
     // 密码的eye开关
      $(".v4-reg-icon").click(function(){
        if($(this).hasClass("open")){
           $(this).removeClass("open").html('&#xe6a1;');
           $(this).prev().attr("type","password");
        }else{
            $(this).addClass("open").html('&#xe6a2;');
            $(this).prev().attr("type","text");
        }

      })
    })

   
    </script>
@endsection
