@extends('wap.common.activity')

@section('title', '11.11理财节')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/activity/doubleEleven/css/index.css')}}">
@endsection

@section('content')
<article class="eleven-bg">
     <div class="eleven-time">活动时间：{{date('m.d',$activityTime['start'])}}~{{date('m.d',$activityTime['end'])}}</div>
     <!-- 签到领现金 -->
     <div class="eleven-sign">
         <!-- <div class="eleven-sign-title"></div> -->

         <!-- 已签到 -->
         <div class="eleven-sign-title signed"><span id="sign_num">{{$signData['sign_continue_num'] or 0}}</span></div>
         <p>在九斗鱼投资过的老用户，连续签到<strong>{{$signTimesAward}}</strong>天可获得一次抽奖<br>机会！每日分享活动页面可随机获得现金奖励！</p>
         <ul class="eleven-sign-list">
            @if(!empty($signData['date_list']))
            @foreach($signData['date_list'] as $date)
             <li @if(isset($date['sign_status']) && $date['sign_status'] == 1) class='signed' @endif class="{{$date['date']}}">{{(int)$date['format_date']}}日</li>
             @endforeach
            @endif
         </ul>
         <a class="eleven-btn" href="javascript:;" data-touch="false">立即签到</a>
         <p class="eleven-rule-btn"><a href="javascript:;" data-target="layer8" data-touch="false">活动规则></a></p>
     </div>
     <!-- End 签到领现金 -->

    <!-- 充值红包雨 -->
    <div class="eleven-redrain">
        <div class="eleven-title redrain"></div>
        <div class="eleven-intro">净充值金额=充值金额-提现金额</div>
        <ul class="eleven-redrain-list">
        @foreach($rechargeBonusList as $key =>$bonus)
            <li id="bonus_{{$bonus['bonus_id']}}" data-bonus="{{$bonus['bonus_id']}}" data-cash="{{$bonus['money']}}" @if(isset($bonus['is_get']) && $bonus['is_get'] == 1) class="received" @endif data-touch="false">
                <div class="eleven-redrain-box">
                    <p><big>{{$bonus['money']}}</big>{{$bonus['unit']}}</p>
                </div>
                <div class="eleven-redrain-receive">
                    <p class="num"><big>{{$bonus['money']}}</big>{{$bonus['unit']}}</p>
                    <p>恭喜您已领取</p>
                </div>
                @if($bonus === $endBonusData)
                <p>累计净充值金额≥{{$netRechargeConfig[$key]}}元</p>
                @else
                <p>{{$netRechargeConfig[$key]}}元≤累计净充值金额＜{{$netRechargeConfig[$key+1]}}元</p>
                @endif
            </li>
        @endforeach
        </ul>
    </div>
    <!-- End 充值红包雨 -->
    <section ms-controller="activityHome" >
    <!-- 理财节富豪榜 -->
    <div class="eleven-ranking">
        <div class="eleven-title ranking"></div>
        <div class="eleven-ranking-intro">
            活动期间，累计投资金额<span>排名前五</span>且≥50万元的用户<br>
            可分别获得现金大奖<br>
            <span>2000元、1000元、500元、300元、200元</span>
        </div>
        <div class="eleven-ranking-list">
            <div class="eleven-ranking-list-title">-富豪榜排名-</div>
            <ul class="eleven-ranking-main" ms-if="rank">
                <li ms-for="(k,v) in @rank"><ins>NO.{% @k+1%}</ins><span>{% @v.phone%} 累计投资额{% @v.invest_cash%}元</span></li>
            </ul>
            <ul class="eleven-ranking-main" ms-if="!rank">
                <li><ins></ins><span>暂无投资排名</span></li>
            </ul>
        </div>
    </div>
    <!-- End 理财节富豪榜 -->

    <!-- 优选项目 -->

    <div class="eleven-project">
        <div class="eleven-title project"></div>
        <div class="page-project" data-touch="false" ms-for="(k,v) in @project">
            <h2>{% @v.product_line_note %} {% @v.format_name %} </h2>
            <table>
                <tbody>
                    <tr>
                        <td class="td1"><p><big>{% @v.profit_percentage | number(1) %}</big>%</p><span>借款利率</span></td>
                        <td class="td2"><p>{% @v.format_invest_time %}{% @v.invest_time_unit %}</p><span>项目期限</span></td>
                        <td class="td3"><p>{% @v.refund_type_note %}</p><span>还款方式</span></td>
                        <td>
                            <a ms-if="@v.status==130"   href="javascript:;" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}" class="page-project-btn doInvest">立即出借</a>
                            <a ms-if="@v.status==150"   href="javascript:;" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}" class="page-project-btn doInvest disable">已售罄</a>
                            <a ms-if="@v.status==160"   href="javascript:;" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}" class="page-project-btn doInvest disable">已完结</a>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </section>
    <!-- End 优选项目 -->

    <!-- 活动规则 -->
    <div class="eleven-rule">
        <h2>- 活动规则-</h2>
        <p>1、活动时间：{{date('Y年m月d日',$activityTime['start']) }} - {{date('m月d日',$activityTime['end'])}}；<p>
        <p class="yellow">2、仅限在活动页面进行项目投资的金额，才可参与富豪榜累计；</p>
        <p>3、富豪榜现金奖励于活动结束后20个工作日内发放，如出现累计投资金额相同，则按用户最后一笔投资的时间先后排序；</p>
        <p>4、活动期间提现金额≥50000元的用户，将取消富豪榜的获奖资格；</p>
        <p>5、活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服。</p>
        <p>本活动最终解释权归九斗鱼所有。</p>
    </div>
    <!-- End 活动规则 -->
</article>

<!-- 分享提示图片 -->
<div class="page-layer pop-7" data-modul="layer7">
    <div class="page-mask" data-toggle="mask" data-target="layer7"></div>
    <div class="eleven-share-img"></div>
</div>
<!-- End 分享提示图片 -->

<!-- 分享成功 -->
<div class="page-layer pop-6" data-modul="layer6">
    <div class="page-mask"></div>
    <div class="page-pop page-pop-share">
        <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer6">close</a>
        <div class="pop-share-title"></div>
        <p class="text1">恭喜您获得现金</p>
        <p class="text2"><big id="shareCash">10</big>元</p>
        <p class="text3">每日分享只可获得一次现金奖励<br>请至“我的账户”中查看</p>
        <i class="pop-icon"></i>
    </div>
</div>
<!-- End 分享成功 -->

<!-- 连续签到7天 -->
 <div class="page-layer pop-2" data-modul="layer1" >
    <div class="page-mask"></div>
    <div class="page-pop page-pop-success">
        <div class="pop-success-title"></div>
        <p class="text4">恭喜您已连续签到<font class="continue_num">{{$signTimesAward}}</font>天</p>
        <p class="text5">获得一次抽奖机会</p>
        <div class="page-box" >
        <a href="javascript:location.href='/activity/doubleEleven/lottery';" class="pop-btn-1">去抽奖</a>
        <a href="javascript:;" class="pop-btn-1 quit-lottery" data-toggle="mask-bak" data-target="layer1" >放弃抽奖</a>
        </div>
        <p class="pop-tips">提示：点击放弃抽奖将失去本次抽奖机会</p>
        <i class="pop-icon"></i>
    </div>
</div>
<!-- End 连续签到7天 -->

<!-- 签到成功 -->
<div class="page-layer pop-5" data-modul="layer5">
    <div class="page-mask"></div>
    <div class="page-pop page-pop-success">
        <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer5">close</a>
        <div class="pop-success-title"></div>
        <p class="text1">距离抽奖还有</p>
        <p class="text2"><big class='left_day'>3</big>天</p>
        <p class="text3 sign_note">-您已连续签到4天-</p>
        <i class="pop-icon"></i>
    </div>
</div>
<!-- End 签到成功 -->

<!-- 红包领取成功 -->
<div class="page-layer pop-3" data-modul="layer2">
    <div class="page-mask" data-toggle="mask" data-target="layer2"></div>
    <div class="page-pop page-pop-coupon">
        <a href="javascript:;" class="page-pop-close2" data-toggle="mask" data-target="layer2">close</a>
        <p class="text2"><big id="bonus_cash">60</big>元</p>
        <p class="text1">恭喜您!</p>
        <p class="text3">成功领取<span class="receive_success">60</span>元红包一个<br>请至“资产-优惠券”中查看</p>
    </div>
</div>
<!-- End 红包领取成功 -->

<!-- 红包领取失败 -->
<div class="page-layer pop-1" data-modul="layer3">
    <div class="page-mask"></div>
    <div class="page-pop page-pop-fail">
        <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer3">close</a>
        <div class="pop-fail-title"></div>
        <p class="text2" id="error_message">您的净充值金额还不够哦~<br>快去充值吧！</p>
        <p><a href="javascript:;" class="pop-btn recharge-btn">去充值</a></p>
        <i class="pop-icon"></i>
    </div>
</div>
<!-- End 红包领取失败 -->

<!-- 用户未登录 -->
<div class="page-layer login" data-modul="layer4" >
    <div class="page-mask"></div>
    <div class="page-pop page-pop-login">
        <a href="javascript:;" class="page-pop-close2" data-toggle="mask" data-target="layer4">close</a>
        <p class="text1"></p>
        <p class="text2" >还没有登录, 请登录后参与活动</p>
        <a href="javascript:;" class="pop-btn-confrim userDoLogin">登录</a>
    </div>
</div>
<!-- End 用户未登录 -->

<!-- 公用的失败信息弹框 -->
<div class="page-layer error-tips" data-modul="layer-error" >
    <div class="page-mask"></div>
    <div class="page-pop page-pop-login">
        <a href="javascript:;" class="page-pop-close2" data-toggle="mask" data-target="layer-error">close</a>
        <p class="text1"></p>
        <p class="text2" id='error_message_common'>错误信息提示</p>
        <a href="javascript:;" class="pop-btn-confrim " data-toggle="mask" data-target="layer-error">关闭</a>
    </div>
</div>
<!-- End 共用的信息失败弹框 -->

<div class="page-layer pop-8" data-modul="layer8">
    <div class="page-mask"></div>
    <div class="page-pop page-pop-rule">
        <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer8">close</a>
        <div class="pop-rule-title">-活动规则-</div>
        <p>1、老用户即在九斗鱼投资过的用户；</p>
        <p>2、签到时间{{date('Y年m月d日',$activityTime['start'])}}~{{date('m月d日',$activityTime['end'])}}；</p>
        <p>3、连续签到7天可获得1次抽奖机会，抽奖次数不可累计；</p>
        <p>4、每日成功分享活动页面给好友可随机获得现金奖励，请更新为最新版本客户端；</p>
        <p>5、中途漏签需重新开始计算时间。</p>
    </div>
</div>
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
@endsection


@section('jsScript')
@include('wap.common.wechatShare');
    <script type="text/javascript" src="{{ assetUrlByCdn('static/weixin/activity/doubleEleven/js/avtivity-double.js')}}"></script>
    <script>
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
            }, 400);
           $("body,html").css({"overflow":"hidden","height":"100%"});


        })
         // 关闭弹窗
        $(document).on(evclick, '[data-toggle="mask"]', function (event) {
            event.stopPropagation();
            var target = $(this).attr("data-target");
            $("div[data-modul="+target+"]").hide();

            //禁止鼠标穿透底层
            $('[data-touch="false"]').css('pointer-events', 'none');
            setTimeout(function(){
                $('[data-touch="false"]').css('pointer-events', 'auto');
            }, 400);
            $("body,html").css({"overflow":"auto","height":"auto"});

         })

//签到操作
        $(".eleven-btn").click(function(){
            if ("{{$userStatus}}" == false) {
                $(".login").show();
                return false;
            }
            $.ajax({
                url: '/activity/doubuleEleven/doSign',
                type: 'post',
                dataType:'json',
                data:{'_token':$('#csrf_token').val()},
                async:false,
                success: function(res){
                   if (res.status == true) {
                       $("#sign_num").html(res.data.sign_continue_num);
                       $("."+res.data.last_sign_day).addClass('signed');
                       if (res.data.sign_continue_num >= '{{$signTimesAward}}') {
                           $(".continue_num").html(res.data.sign_continue_num);
                           $('.pop-2').show();
                       } else {
                           $('.left_day').html(res.data.left_day);
                           $('.sign_note').html(res.data.sign_note);
                           $('.pop-5').show();
                       }
                    }else {
                        $('#error_message_common').html(res.msg);
                        $(".error-tips").show();
                    }
                }

        })
        });

//充值红包雨
        $(".eleven-redrain-list li").click(function(){
            if ("{{$userStatus}}" == false) {
                $(".login").show();
                return false;
            }

            var bonus_id = $(this).attr('data-bonus');
            var bonus_cash = $(this).attr('data-cash');

            $.ajax({
                url: '/activity/doubuleEleven/doGetBonus',
                type: 'post',
                dataType:'json',
                data:{'_token':$('#csrf_token').val(),'bonus_id':bonus_id,'bonus_cash':bonus_cash},
                async:false,
                success: function(res){
                   if (res.status == true) {
                       $('#bonus_'+res.data.bonus_id).addClass('received');
                       $("#bonus_cash").html(res.data.bonus_cash);
                       $(".receive_success").html(res.data.bonus_cash);
                       $('.pop-3').show();
                    } else {
                        //净充值金额不够
                        if (res.code == "{{\App\Http\Logics\Activity\DoubleElevenLogic::ERROR_RECHARGE_NOT_ENOUGH}}") {
                            $(".pop-1").show();
                        }else {
                            $('#error_message_common').html(res.msg);
                            $(".error-tips").show();
                        }
                    }
                }

        })

        });

//取消奖励操作
        $(document).on(evclick, '[data-toggle="mask-bak"]', function (event) {
           event.stopPropagation();
           var target = $(this).attr("data-target");
            $.ajax({
                url: '/activity/doubuleEleven/quitLottery',
                type: 'post',
                dataType:'json',
                data:{'_token':$('#csrf_token').val(),},
                async:false,
                success: function(res){
                    $("#sign_num").html(res.data.sign_continue_num);
                    $("div[data-modul="+target+"]").hide();
                }

            });

            //禁止鼠标穿透底层
            $('[data-touch="false"]').css('pointer-events', 'none');
            setTimeout(function(){
                $('[data-touch="false"]').css('pointer-events', 'auto');
            }, 400);
            $("body,html").css({"overflow":"auto","height":"auto"});
         });

        //分享成功后回调
        function shareCallback(shareUrl)
        {
            $.ajax({
                url: shareUrl,
                type: 'post',
                dataType:'json',
                data:{'_token':$('#csrf_token').val(),},
                async:true,
                success: function(res){
                   if (res.status == true) {
                       $("#shareCash").html(res.data.cash);
                       $('.pop-6').show();
                    }else {
                        if ("{{$userStatus}}" == false) {
                            $(".login").show();
                            return false;
                        }
                       $('#error_message_common').html(res.msg);
                       $(".error-tips").show();
                    }
                }

            });
        }
    </script>
@endsection

