@extends('wap.common.activity')

@section('title', '爱情银行长存的不只有时光')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/activity/Tanabata/css/index.css')}}">
<script type="text/javascript" src="{{ assetUrlByCdn('/static/angular/angular.min.js')}}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/angular/angular-route.js')}}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/angular/angular-animate.min.js')}}"></script>
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/activity/coupon/js/coupon.js')}}"></script>
@endsection

@section('content')
    <article class="page-bg" ng-controller="dataPacketCtrl">
        <input type="hidden" name="_token"  value="{{csrf_token()}}">
    	<!-- banner -->
    	<section class="page-center page-time">
            <p>活动时间：{{date("Y年m月d日",$activityTime['start'])}}－{{date("m月d日",$activityTime['end'])}}</p>
    	</section>
    	<!-- End banner -->
        <div class="page-title1"></div>
        <p class="page-center page-font1">每个用户ID每日仅限领取一张优惠券</p>

        @include('wap.activity.coupon.bonus')
        <div class="page-wrap">
        @include('wap.activity.coupon.project')
        </div>
        <div class="page-title2">每日惊喜</div>
        <p class="page-center page-font2">每日投资优选项目即有机会获得惊喜奖</p>
        <div class="page-wrap wrap-1">
            @include('wap.activity.coupon.lottery')
        </div>
        <!-- rule -->
         <div class="page-rule">
              <h6>活动规则</h6>
              <p><span>1.</span>活动时间：{{date("Y年m月d日",$activityTime['start'])}}－{{date("m月d日",$activityTime['end'])}}；</p>
              <p><span>2.</span>活动期间内,每个用户ID每日仅限领取一张优惠券,而非每个不同优惠券各领取一张;<br>
                    <ins>•</ins>10元现金券，起投金额8000元<br>
                    <ins>•</ins>30元现金券，起投金额15000元<br>
                    <ins>•</ins>60元现金券，起投金额20000元<br>
                    <ins>•</ins>1%定期加息券，起投金额30000元<br>
                    <ins>•</ins>1.5%定期加息券，起投金额50000元<br>
                    <ins>•</ins>现金券和红包自发放之日起，有效期15天；<br>
                    <ins>•</ins>以上现金券和红包，仅限投资3、6、12月期及九安心项目；</p>
              <p><span>3.</span>活动期间内,<em class="yellow">每日在活动页面进行项目投资的投资者中</em>,随机抽取一名获奖者,获得当日对应的实物奖品;中奖信息将于下一个工作日11点开奖;</p>
              <p><span>4.</span>活动期间内,获得实物奖品者如提现金额≥10000元,则取消其领奖资格;</p>
              <p><span>5.</span>活动所得奖品以实物形式发放,将在2017年10月15日之前,与您沟通联系确定发放奖品。如联系用户无回应,视为自动放弃活动奖励;</p>
              <p><span>6.</span>活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服。</p>
              <p><span>7.</span>本活动最终解释权归九斗鱼所有。</p>
        </div>
</article>
        <!-- End rule -->
        <!-- pop  领取1%定期加息券-->
        <section class="pop-wrap coupon-alert">
            <div class="pop-mask"></div>
            <div class="pop">
                <span class="pop-close"></span>
                <p class="pop-text">确定领取 <br>30元现金券？</p>
                <a href="javascript:;" class="pop-btn receive">确 定</a>
                <p class="pop-text-desc">满3000元可用</p>
            </div>
        </section>
        <!-- End pop -->

        <!-- pop  登 录-->
        <section class="pop-wrap cash6">
            <div class="pop-mask"></div>
            <div class="pop">
                <span class="pop-close"></span>
                <p class="pop-text">客官，别急<br>还没登录呢</p>
                <a href="javascript:;" class="pop-btn userDoLogin">立即登录</a>
            </div>
        </section>
        <!-- End pop -->

        <!-- pop  领取成功,失败-->
        <section class="pop-wrap cash7 receive-coupon-result">
            <div class="pop-mask"></div>
            <div class="pop">
                <span class="pop-close"></span>
                <span class="receive-result">
                    <div class="c-fail"></div>
                    <p class="pop-text">请刷新页面重新领取</p>
                    <a href="javascript:;" class="pop-btn">我知道了</a>
                </span>
            </div>
        </section>

        <!-- End pop -->
@endsection

@section('jsScript')
    <script>
    $(function(){
        function alertpop(element,pop){
            $(element).click(function(e){
                e.preventDefault();
                var $this       =   $(this);
                var userStatus  =   "{{$userStatus}}";
                if( userStatus == true ){
                    alertCouponPop($this,pop) ;
                }else{
                    $('.cash6').show();
                }
            })
        }
        $(document).on("click", '.receive',function(event){
            event.stopPropagation();
            var $target =   $('.coupon-alert');
            var value   =   $(this).attr('attr-bonus-value');
            $target.hide()
            receiveBonusControl(value);
        })
        $(document).on("click", '.user-login-alert',function(event){
            event.stopPropagation();
            $(".cash6").show();
        })
        $(document).on('click','.pop-close,.pop-btn',function() {
            $('.pop-wrap').hide();
            $('#coupon-status').attr('attr-receive-lock','opened');
        })
        var alertCouponPop = function (obj,pop) {
            var target      =   obj.attr('attr-bonus-value');
            var $couponLock =   $('#coupon-status')
            var couponLock  =   $couponLock.attr('attr-receive-lock');
            if( couponLock  != 'opened'){
                return false
            }
            var couponCss   =   "c-"+target;
            var $target     =   $(pop);
            $(".receive").attr('attr-bonus-value',target);
            $target.find('.pop div').removeClass().addClass(couponCss);
            var desc = obj.attr('attr-used-desc');
            var value = obj.attr('attr-value-desc');
            $target.find(".pop-text").empty().html('确定领取</br>' + value)
            $target.find(".pop-text-desc").empty().html(desc)
            $couponLock.attr('attr-receive-lock','closed');
            $target.show();
        }
        var receiveBonusControl = function (value) {
            var userStatus = '{{$userStatus}}';
            if( userStatus == false ) {
                $('.cash6').show();
                return false
            }
            var $receiveBtn =  $(".receive");
            var lock        =   $receiveBtn.attr("lock-status");
            if( lock == 'closed'){
                return false;
            }
            $receiveBtn.attr("lock-status",'closed');
            $.ajax({
                url      :"/activity/receive",
                dataType :'json',
                data: {from:'app',custom_value:value,_token:'{{csrf_token()}}'},
                type     :'post',
                success : function(json){
                    var $targetLayer=$(".receive-coupon-result");

                    if( json.status==true || json.code==200){
                        var returnHtml = '<div class="c-success"></div>'+
                                        '<p class="pop-text">请在<span>[资产－我的优惠券] </span>中查看</p>';
                    } else if( json.status == false || json.code ==500 ){
                        var returnHtml  =   '<div class="c-fail"></div>'+
                                        '<p class="pop-text">'+json.msg+'</p>'
                    }
                    returnHtml  =   returnHtml + '<a href="javascript:;" class="pop-btn">我知道了</a>';
                    $targetLayer.find('.receive-result').html(returnHtml)
                    $targetLayer.show();
                    $receiveBtn.attr("lock-status",'opened');
                    $('#coupon-status').attr('attr-receive-lock','opened');
                    return false;
                },
                error : function(msg) {
                    //$(".layer-fail").show();
                    $receiveBtn.attr("lock-status",'opened');
                }
            })
        }

        alertpop(".coupon-btn-bonus",'.coupon-alert');
    	// 弹层关闭按钮
        $('.pop-close').click(function(){
            $('.pop-wrap').hide();
            $('#coupon-status').attr('attr-receive-lock','opened');
        })

        $(".userDoLogin").click(function () {
            if( client =='ios'){
                window.location.href = "objc:gotoLogin";
                return false;
            }
            if (client =='android'){
                window.jiudouyu.login();
                return false;
            }
            window.location.href='/login';
        })
    })
    </script>
@endsection
