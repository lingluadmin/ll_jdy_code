@extends('pc.common.activity')

@section('title', '相约在冬季 遇见Xing福')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('static/activity/winter/css/index.css')}}">
@endsection
@section('content')
        <div class="winter-wrap">
            <p class="winter-date">活动时间：{{date('n.d',$activityTime['start']) }} - {{date('n.d',$activityTime['end'])}}</p>
        </div>
        <div class="wrap">
            <img src="{{assetUrlByCdn('/static/activity/winter/images/cash.png')}}" alt="" width="737" height="124" class="winter-cash">
            <div class="winter-box ms-controller" ms-controller="activityHome" >
                <div class="winter-1">
                    <h3>浓情冬日 火热加息</h3>
                    <p class="winter-text">活动期间净充值金额<span>（净充值金额=新充值金额-提现金额）</span>满10000元，即可领取冬日礼包。<br/>内含1%加息券，100元红包，300元红包。</p>
                    <div class="winter-receive">
                        <span class="receive-package" ms-if="@package== true"><!-- 未领取 -->
                        <img src="{{assetUrlByCdn('/static/activity/winter/images/img.png')}}" alt="" width="328" height="213" class="winter-gift">
                        <a href="javascript:;" ms-click="@doReceivePackage" class="winter-btn">立即领取</a>
                        </span>
                        <!-- 已领取 -->
                        <ul class="winter-coupon" ms-if="@package== false">
                            <li class="winter-first">
                                <h4>加息<span>1</span>%</h4>
                                <p>恭喜您已领取</p>
                            </li>
                            <li>
                                <h4><span>300</span>元</h4>
                                <p>恭喜您已领取</p>
                            </li>
                            <li>
                                <h4><span>100</span>元</h4>
                                <p>恭喜您已领取</p>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="winter-1 winter-2">
                    <h3>好事成双 惊喜升级</h3>
                @include('pc.activity.winter.reward')
                </div>
                <div class="winter-1 winter-2">
                     <h3>优选项目</h3>
                @include('pc.activity.winter.project')
                </div>
            </div>

        </div>
        <div class="winter-rule">
            <div class="wrap1">
                <h5>－ 活动规则 - </h5>
                <p>1、活动时间：{{date('Y年m月d日',$activityTime['start']) }} - {{date('m月d日',$activityTime['end'])}}；</p>
                <p class="color">2、仅限在活动页面投资6月期或12月期项目，可获得对应奖励，奖励只可获得一次，按累积最高投资金额计算；</p>
                <p class="color">3、所有在活动页面进行的投资，在项目周期内不可进行债权转让；</p>
                <p>4、在活动页面投资6月期或12月期项目，使用红包或加息券投资的项目金额不计入累积金额；</p>
                <p>5、现金奖励及iPhoneX奖励获得者，若活动期间提现金额≥50000元，将取消其领奖资格；</p>
                <p>6、现金奖励将于2018年1月31日前发放至账户余额中；</p>
                <p>7、iPhoneX以实物形式发放，由于库存及发货时间的特殊性，客服将于活动结束后5个工作日内与获得iPhoneX的用户沟通确定奖品发放事宜，在此期间联系未果视为用户自动放弃奖品；</p>
                <p>8、红包和加息券有效期截止至2017年12月31日；</p>
                <p>9、活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服。</p>
                <p>本活动最终解释权归九斗鱼所有。</p>
            </div>
        </div>

   <div class="page-layer login">
       <div class="page-mask"></div>
       <div class="page-pop">
           <div class="page-pop-inner">
               <div class="page-pop-pos"></div>
               <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="login">close</a>
               <p class="page-pop-text">还没有登录哦~<br/>请登录后参加活动</p>
               <a href="/login" class="winter-btn1">去登录</a>
           </div>
       </div>
   </div>

    <div class="page-layer receive">
       <div class="page-mask"></div>
       <div class="page-pop page-pop1">
           <div class="page-pop-inner">
               <div class="page-pop-pos"></div>
               <a href="javascript:;" class="page-pop-close close-receive">close</a>
               <h4>恭喜您</h4>
               <h5>已经<span>成功领取</span>冬日礼包</h5>
               <ul class="winter-coupon1">
                    <li class="winter-first">
                        <h4>加息<span>1</span>%</h4>
                        <p>已领取</p>
                    </li>
                    <li>
                        <h4><span>300</span>元</h4>
                        <p>已领取</p>
                    </li>
                    <li>
                        <h4><span>100</span>元</h4>
                        <p>已领取</p>
                    </li>
                </ul>
                <p class="page-pop-text1">请至“我的账户”中查看</p>
               <a href="javascript:;" class="winter-btn1 winter-receive" >我知道了</a>
           </div>
       </div>
   </div>
    <div class="page-layer error">
        <div class="page-mask"></div>
        <div class="page-pop">
            <div class="page-pop-inner">
                <div class="page-pop-pos"></div>
                <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="error">close</a>
                <p class="page-pop-text"></p>
                <a href="javascript:;" class="winter-btn1" data-toggle="mask" data-target="error">我知道了</a>
            </div>
        </div>
    </div>
<input type="hidden" name='_token' id="csrf_token" value="{{ csrf_token() }}" />
<script type="text/javascript" src="{{ assetUrlByCdn('/static/activity/winter/js/activity-winter.js')}}"></script>
@endsection
@section('jspage')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on("click", '[data-layer]',function(event){
        event.stopPropagation();
        var $this = $(this);
        var target = $this.attr("data-layer");
        $("."+target).show();
    })
    $(document).on("click", '.close-receive,.winter-receive',function(event){
        event.stopPropagation();
        window.location.reload();
    })
</script>
@endsection


