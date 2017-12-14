@extends('pc.common.activity')

@section('title', '11.11理财节')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="format-detection" content="telephone=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/doubleEleven/css/index.css')}}">
@endsection
@section('content')
<div class="page-banner">
    <p class="page-time">活动时间：{{date('n.d',$activityTime['start']) }} - {{date('n.d',$activityTime['end'])}}</p>
</div>

<div class="page-signIn">
    <!-- 未签到状态 -->
    <h2 class="page-section-title1"></h2>
    <!-- 有签到状态 -->
    <!-- <h2 class="page-sign-hold">01</h2> -->

    <p class="text">在九斗鱼投资过的老用户，连续签到<big>{{$signTimesAward}}</big>天可获得一次抽奖机会！ <br>APP端每日成功分享活动页面可随机获得现金奖励！</p>
    <div class="page-signIn-btn-group clearfix">
        @if(!empty($signData['date_list']))
        @foreach($signData['date_list'] as $date)
         <a @if(isset($date['sign_status']) && $date['sign_status'] == 1) class='active' @endif class="{{$date['date']}}"><span></span>{{(int)$date['format_date']}}日</a>
         @endforeach
        @endif
    </div>
    <!-- <a href="javascript:;" class="page-btn-sign disable">立即签到</a> -->
    <a href="javascript:;" class="page-btn-sign">立即签到</a>

    <a href="javascript:;" class="page-sign-rule" data-layer="layer5">活动规则></a>
</div>

<h2 class="page-section-title2"></h2>
<p class="page-luckMoney-des"><span>净充值金额=充值金额-提现金额</span></p>
<div class="page-luckMoney">
    <ul class="clearfix">
    @foreach($rechargeBonusList as $key =>$bonus)
        <li data-bonus="{{$bonus['bonus_id']}}" data-cash="{{$bonus['money']}}">
            <a id="bonus_{{$bonus['bonus_id']}}" href="javascript:;" @if(isset($bonus['is_get']) && $bonus['is_get'] == 1) class="open" @endif ><big>{{$bonus['money']}}</big>{{$bonus['unit']}}
            <span>恭喜您已领取</span></a>
        </li>
    @endforeach
    </ul>
    <p class="page-luckMoney-limit">
        <span>{{$netRechargeConfig[0] or null}}元≤累计净充值金额＜{{$netRechargeConfig[1] or null}}元</span>
        <span>{{$netRechargeConfig[1] or null}}元≤累计净充值金额＜{{$netRechargeConfig[2] or null}}元</span>
        <span>{{$netRechargeConfig[2] or null}}元≤累计净充值金额＜{{$netRechargeConfig[3] or null}}元</span>
        <span>累计净充值金额≥{{$netRechargeConfig[3] or null}}元</span>
    </p>
</div>
<section ms-controller="activityHome" class="ms-controller">
<h2 class="page-section-title3"></h2>
<p class="page-luckMoney-des">活动期间，累计投资金额<span>排名前五</span>且≥50万元的用户，可分别获得<span>现金大奖：2000元、1000元、500元、300元、200元。</span></p>
<div class="page-ranking">
    <h1>-富豪榜排名-</h1>
    <div class="page-ranking-list" ms-if="rankList">
        <ul>
            <li ms-for="(key,invest) in @rankList" ms-if="@key <=4"><em></em><i>NO.{%@key+1%}</i>{%@invest.phone%} 累计投资额{%@invest.invest_cash%}元</li>
        </ul>
        <ul>
            <li ms-for="(key,invest) in @rankList" ms-if="@key >=5"><em></em><i>NO.{%@key+1%}</i>{%@invest.phone%} 累计投资额{%@invest.invest_cash%}元</li>
        </ul>
    </div>
    <div class="page-ranking-list" ms-if="!rankList">
        <ul>
            <li>暂无投资排名</li>
        </ul>
        <ul>
            <li>暂无投资排名</li>
        </ul>
    </div>
</div>
<h2 class="page-section-title4"></h2>
<div class="page-project-wrap" >
    <div class="page-project" ms-for="(k,v) in @projectList">
        <h1 class="title">{%@v.name%}  {%@v.format_name%}</h1>
        <table>
            <tr>
                <td class="td1">
                    <p><big>{%@v.profit_percentage%}</big>%</p>
                    <span>期待年回报率</span>
                </td>
                <td class="td2">
                    <p>{%@v.format_invest_time%}{%@v.invest_time_unit%}</p>
                    <span>项目期限</span>
                </td>
                <td class="td3">
                    <p>{%@v.refund_type_note%}</p>
                    <span>还款方式</span>
                </td>
                <td>
                    <a ms-if="@v.status==130" href="javascript:;" class="page-btn-project clickInvest" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}">立即出借</a>
                    <a ms-if="@v.status==150" href="javascript:;" class="page-btn-project  disable clickInvest" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}">已售罄</a>
                    <a ms-if="@v.status==160" href="javascript:;" class="page-btn-project disable clickInvest" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}">已完结</a>
                </td>
            </tr>
        </table>
    </div>
</div>
</section>
<div class="page-rule">
    <div class="inner">
        <h2>- 活动规则- </h2>
        <p>1、活动时间：{{date('Y年m月d日',$activityTime['start']) }} - {{date('m月d日',$activityTime['end'])}}；</p>
        <p>2、仅限在活动页面进行项目投资的金额，才可参与富豪榜累计；</p>
        <p>3、富豪榜现金奖励于活动结束后20个工作日内发放，如出现累计投资金额相同，则按用户最后一笔投资的时间先后排序；</p>
        <p>4、活动期间提现金额≥50000元的用户，将取消富豪榜的获奖资格；</p>
        <p>5、活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服。</p>
        <p>本活动最终解释权归九斗鱼所有。</p>
    </div>
</div>

<div class="page-layer layer1" >
    <div class="page-mask"></div>
    <div class="page-pop">
        <div class="page-pop-inner">
            <div class="page-pop-pos"></div>
            <h1 class="page-pop-title1"><a href="javascript:;" class="page-pop-close" id="quit_lottery" >close</a></h1>
            <div class="page-pop-content">
                 <p class="page-pop-text1">恭喜您已连续签到<font class="continue_num">{{$signTimesAward}}</font>天</p>
                 <p class="page-pop-text2-1">扫码抽奖，否则将放弃本次抽奖机会!</p>
            </div>

            <div class="page-pop-qcode">
                <img src="{{assetUrlByCdn('/static/activity/doubleEleven/images/page-pop-qcode-1.png')}}" alt="">
            </div>
        </div>
    </div>
</div>

<div class="page-layer layer2" >
    <div class="page-mask"></div>
    <div class="page-pop">
        <div class="page-pop-inner">
            <div class="page-pop-pos"></div>
            <h1 class="page-pop-title1"><a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer2">close</a></h1>
            <div class="page-pop-content">
                 <p class="page-pop-text3">距离抽奖还有</p>
                 <p class="page-pop-text4"><big class='left_day'>3</big>天</p>
                 <p class="page-pop-text5 sign_note">-您已连续签到4天-</p>
            </div>
        </div>
    </div>
</div>


<div class="page-layer layer3">
    <div class="page-mask"></div>
    <div class="page-pop">
        <div class="page-pop-inner">
            <div class="page-pop-pos"></div>
            <h1 class="page-pop-title2"><a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer3">close</a></h1>
            <p class="page-pop-text">您的净充值金额还不够哦~<br>快去充值吧！</p>
            <a href="javascript:location.href='/recharge/index';" class="page-pop-btn">去充值</a>
        </div>
    </div>
</div>

<div class="page-layer layer4">
    <div class="page-mask"></div>
    <div class="page-pop-luckyMoney">
        <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer4">close</a>
        <p class="page-pop-luckyMoney-text1"><big id="bonus_cash">60</big>元</p>
        <p class="page-pop-luckyMoney-text2">恭喜您!</p>
        <p class="page-pop-luckyMoney-text3"><font class="receive_success">成功领取60元红包一个</font><br>请至<a href="javascript:location.href='/user';">“我的账户”</a>中查看</p>
    </div>
</div>

<div class="page-layer layer5" >
    <div class="page-mask"></div>
    <div class="page-pop-rule">
        <h1>-活动规则-<a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer5">close</a></h1>
        <p>1、老用户即在九斗鱼投资过的用户；</p>
        <p>2、签到时间{{date('Y年m月d日',$activityTime['start'])}}~{{date('m月d日',$activityTime['end'])}}；</p>
        <p>3、连续签到7天可获得1次抽奖机会，抽奖次数不可累计；</p>
        <p>4、APP端每日成功分享活动页面给好友可随机获得现金奖励，请更新为最新版本客户端；</p>
        <p>5、中途漏签需重新开始计算时间。</p>
    </div>
</div>
{{--用户未登录--}}
<div class="page-layer login">
    <div class="page-mask"></div>
    <div class="page-pop">
        <div class="page-pop-inner">
            <div class="page-pop-pos"></div>
            <h1 class="page-pop-title2-1"><a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="login">close</a></h1>
            <p class="page-pop-text">您还没有登录,请登录后参与活动</p>
            <a href="javascript:location.href='/login';" class="page-pop-btn">去登录</a>
        </div>
    </div>
</div>
{{--end 用户未登录--}}

{{--公共错误提示信息--}}
<div class="page-layer error-tips" >
    <div class="page-mask"></div>
    <div class="page-pop">
    <div class="page-pop-inner">
        <h1 class="page-pop-title"><a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="login">close</a></h1>
        <p class='page-pop-text' id="error_message_common">您还没有登录，登录后参与活动</p>
        <a href="javascript:;" class="page-pop-btn" data-toggle="mask" data-target="error-tips">关闭</a>
    </div>
    </div>
</div>
{{--end 用户未登录--}}

<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
<script type="text/javascript" src="{{ assetUrlByCdn('/static/activity/doubleEleven/js/activity-double.js')}}"></script>
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

//签到信息
$(".page-btn-sign").click(function(){
    if ("{{$userStatus}}" == false) {
        $(".login").show();
        return false;
    }
    $.ajax({
        url: '/activity/doubleEleven/doSign',
        type: 'post',
        dataType:'json',
        data:{'_token':$('#csrf_token').val()},
        async:false,
        success: function(res){
           if (res.status == true) {
               $("."+res.data.last_sign_day).addClass('active');
               if (res.data.sign_continue_num >= '{{$signTimesAward}}') {
                   $(".continue_num").html(res.data.sign_continue_num);
                   $('.layer1').show();
               } else {
                   $('.left_day').html(res.data.left_day);
                   $('.sign_note').html(res.data.sign_note);
                   $('.layer2').show();
               }
            }else {
                $('#error_message_common').html(res.msg);
                $(".error-tips").mask();
            }
        }

})
});

//放弃抽奖操作
$(document).on('click', '[id="quit_lottery"]', function (event) {
    $.ajax({
        url: '/activity/doubuleEleven/quitLottery',
        type: 'post',
        dataType:'json',
        data:{'_token':$('#csrf_token').val(),},
        async:false,
        success: function(res){
            $(".layer1").hide();
        }

    });

});


$(".clearfix li").click(function(){
    if ("{{$userStatus}}" == false) {
        $(".login").mask();
        return false;
    }
    var bonus_id = $(this).attr('data-bonus');
    var bonus_cash = $(this).attr('data-cash');

    $.ajax({
        url: '/activity/doubleEleven/doGetBonus',
        type: 'post',
        dataType:'json',
        data:{'_token':$('#csrf_token').val(),'bonus_id':bonus_id,'bonus_cash':bonus_cash},
        async:false,
        success: function(res){
           if (res.status == true) {
               $('#bonus_'+res.data.bonus_id).addClass('open');
               $("#bonus_cash").html(res.data.bonus_cash);
               $(".receive_success").html(res.data.bonus_note);
               $('.layer4').mask();
            } else {
                //净充值金额不够
                if (res.code == "{{\App\Http\Logics\Activity\DoubleElevenLogic::ERROR_RECHARGE_NOT_ENOUGH}}") {
                    $(".layer3").mask();
                }else {
                    $('#error_message_common').html(res.msg);
                    $(".error-tips").mask();
                }
            }
        }

})

});
</script>
@endsection
