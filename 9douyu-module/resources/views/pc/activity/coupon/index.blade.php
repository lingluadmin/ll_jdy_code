@extends('pc.common.activity')

@section('title', '爱情银行长存的不只有时光')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/tanabata/css/index.css')}}">
    <script type="text/javascript" src="{{ assetUrlByCdn('/static/angular/angular.min.js')}}"></script>
    <script type="text/javascript" src="{{ assetUrlByCdn('/static/angular/angular-route.js')}}"></script>
    <script type="text/javascript" src="{{ assetUrlByCdn('/static/angular/angular-animate.min.js')}}"></script>
    <script type="text/javascript" src="{{ assetUrlByCdn('/static/activity/coupon/js/coupon.js')}}"></script>
@endsection
@section('content')
    <div class="page-banner">
        <div class="wrap">
            <input type="hidden" name="_token"  value="{{csrf_token()}}">
            <p class="page-time">{{date("Y年m月d日",$activityTime['start'])}}——{{date('m月d日',$activityTime['end'])}}</p>
        </div>
    </div>
 
    <div class="page-wrap" ng-controller="dataPacketCtrl">
        <h2 class="page-title large">好礼随心意</h2>
        <p class="mother-info">每个用户 ID每日仅限领取一张优惠券</p>
        <div id="coupon-status" attr-receive-lock='opened'>
            @include('pc.activity.coupon.bonus')
        </div>
        <div class="mother-pro">
        @include('pc.activity.coupon.project')
          <div class="mother-cloud3"></div>
         </div>
        <div class="mother-day">
             <h2 class="page-title">每日惊喜</h2>
             <p>每日投资定期项目即有机会获得惊喜奖</p>
         </div>
         <div class="mother-pro">
            <div class="mother-day-wrap clearfix">
                @include('pc.activity.coupon.lottery')
            </div>
         </div>
    </div>
  
    <!-- 活动规则 -->
    <div class="mother-rule-bg">
        <div class="page-wrap">
            <div class="mother-rule">
                <h4>活动规则:</h4>
                <p>1.活动时间:{{date("Y年m月d日",$activityTime['start'])}}——{{date('m月d日',$activityTime['end'])}};</p>
                <p>2.活动期间内,每个用户ID每日仅限领取一张优惠券,而非每个不同优惠券各领取一张;<br>
                    <ins>•</ins>10元现金券，起投金额8000元<br>
                    <ins>•</ins>30元现金券，起投金额15000元<br>
                    <ins>•</ins>60元现金券，起投金额20000元<br>
                    <ins>•</ins>1%定期加息券，起投金额30000元<br>
                    <ins>•</ins>1.5%定期加息券，起投金额50000元<br>
                    <ins>•</ins>现金券和红包自发放之日起，有效期15天；<br>
                    <ins>•</ins>以上现金券和红包，仅限投资3、6、12月期及九安心项目；
                </p>
                <p>3.活动期间内,<em class="yellow">每日在活动页面进行项目投资的投资者中</em>,随机抽取一名获奖者,获得当日对应的实物奖品;中奖信息将于下一个工作日11点开奖;</p>
                <p>4.活动期间内,获得实物奖品者如提现金额≥10000元,则取消其领奖资格;</p>
                <p>5.活动所得奖品以实物形式发放,将在2017年10月15日之前,与您沟通联系确定发放奖品。如联系用户无回应,视为自动放弃活动奖励;</p>
                <p>6.活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服;</p>
                <p>7.本活动最终解释权归九斗鱼所有。</p>
            </div>
        </div>
        <!-- 定位的云朵 -->
        <div class="mother-cloud2"></div>
    </div>
    <!-- 定位的云朵 -->
    <div class="mother-cloud1"></div>
  
    @if( $userStatus == false)
    <!-- 弹窗 -->
    <div class="page-layer layer-login">
        <div class="page-mask"></div>
        <div class="page-pop page-pop-login">
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer-login">关闭</a>
            <p class="page-pop-text2">您还未登录</p>
            <a href="/login" class="mother-btn">立即登录</a>
        </div>
    </div>
    @endif
    <div class="page-layer layer-coupon">
        <div class="page-mask"></div>
        <div class="page-pop" id="page-bonus-alert">
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer-coupon">关闭</a>
            <p class="page-pop-text">确定领取<br>30元现金券？</p>
            <a href="javascript:;" class="mother-btn" id="receive">确定</a>
            <p class="page-pop-text-desc">满5000元可用</p>
        </div>
    </div>
    <!-- 领取成功 -->
    <div class="page-layer layer-success">
        <div class="page-mask"></div>
        <div class="page-pop page-pop-success">
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer-success">关闭</a>
            <p class="page-pop-text1">领取成功!<br>请在<span>[资产－我的优惠券]</span>中查看</p>
            <a href="javascript:;" class="mother-btn mother-btn-close" >确定</a>
        </div>
    </div>

    <!-- 领取失败 -->
    <div class="page-layer layer-fail" >
        <div class="page-mask"></div>
        <div class="page-pop page-pop-fail">
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer-fail">关闭</a>
            <p class="page-pop-text2">请刷新页面重新领取</p>
            <a href="javascript:;" class="mother-btn mother-btn-close">确定</a>
        </div>
    </div>
    <script>

    //显示弹窗
    $(document).on("click", '[data-layer]',function(event){
        event.stopPropagation();
        var $this   = $(this);
        var target  = $this.attr("data-layer");
        var layer_value=$this.attr("attr-bonus-value");
        var userStatus = '{{$userStatus}}';
        if( userStatus == false ) {
            $(".layer-login").show();
            return false
        }
        var $target = $("."+target);
        if( layer_value !='login' ){
            $target.attr('attr-bonus-value',layer_value);
            var used_value = $this.find('big').attr('attr-value-desc');
            var used_desc = $this.find('big').attr('attr-used-desc');
            $("#page-bonus-alert").removeClass().addClass('page-pop page-pop-'+layer_value);
            if(used_desc !='' || used_value !=''){
                $("#page-bonus-alert").find('.page-pop-text').empty().html('确定领取<br>' + used_value)
                $("#page-bonus-alert").find('.page-pop-text-desc').empty().html(used_desc)
            }
            var $couponLock =   $('#coupon-status')
            var couponLock  =   $couponLock.attr('attr-receive-lock');
            if( couponLock  != 'opened'){
                return false
            }
            $couponLock.attr('attr-receive-lock','closed');
        }
        $target.show();
    })
    $(document).on("click", '.page-pop-close,.mother-btn-close',function(event){
        event.stopPropagation();
        $('.page-bonus-alert').hide();
        $('.page-layer').hide();
        $('#coupon-status').attr('attr-receive-lock','opened');
    })
    $(document).on("click", '#receive',function(event){
        event.stopPropagation();
        var $target =   $('.layer-coupon');
        var value   =   $target.attr('attr-bonus-value');
        $target.hide()
        receiveBonusControl(value);
    })
    var receiveBonusControl = function (value) {
        var userStatus = '{{$userStatus}}';
        if( userStatus == false ) {
            $(".layer-login").show();
            return false
        }
        var $receiveBtn =   $("#receive");
        var lock        =   $receiveBtn.attr("lock-status");
        if( lock == 'closed'){
            return false;
        }
        $receiveBtn.attr("lock-status",'closed');
        $.ajax({
            url      :"/activity/receive",
            dataType :'json',
            data: {custom_value:value,_token:'{{csrf_token()}}'},
            type     :'post',
            success : function(json){
                if( json.status==true || json.code==200){
                    $(".layer-success").show();
                } else if( json.status == false || json.code ==500 ){
                    var $targetLayer=$(".layer-fail");
                    $targetLayer.find('.page-pop-text2').html(json.msg)
                    $targetLayer.show();
                }
                $receiveBtn.attr("lock-status",'opened');
                $('#coupon-status').attr('attr-receive-lock','opened');
                return false;
            },
            error : function(msg) {
                $(".layer-fail").show();
                $receiveBtn.attr("lock-status",'opened');
                $('#coupon-status').attr('attr-receive-lock','opened');
            }
        })
    }
    </script>
@endsection


