@extends('wap.common.activity')

@section('title', '闪耀金秋，双节献礼')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/activity/national2017/css/national.css')}}">
@endsection

@section('content')
    <article class ="ms-controller" ms-controller="autumnNation">
     <div class="page-banner">
         <div class="page-time">{{date('n.d',$activityTime['start']) }} - {{date('n.d',$activityTime['end'])}}</div>
     </div>
     <div class="page-box box1">
         <h1 class="page-title title1">{%nation_title%}</h1>
         <p class="page-des">活动期间每位用户可领取国庆礼券一张，面值以领取时的实际注册时间为准。</p>
         <div class="page-coupons clearfix">
             <a href="javascript:;" class="clearfix" data-touch="false" data-target="layer2" ms-for="(key,val) in @nation_bonus" ms-click="getNationBonus(@user_id, @val.id, '/activity/getNationBonus', 1)">
                 <div class="text1">
                     <p><big>{% @val.rate %}</big>%</p>
                     <span>{% @val.bonusLevelNote %}</span>
                 </div>
                 <span class="text2">立即领取</span>
             </a>

         </div>

     </div>
     <div class="page-box">
         <h1 class="page-title title2">{%autumn_title%}</h1>
         <p class="page-des">活动期间每日登录平台即可获得节日红包，请在以下红包中任选一个领取。</p>
         <div class="page-lucky-money">
             <a href="javascript:;" data-touch="false" data-target="layer2" ms-for="(key,val) in @autumn_bonus" ms-click="getNationBonus(@user_id, @val.id, '/activity/getAutumnBonus', 2)">
                 <div class="par"><big>{% @val.money %}</big>元</div>
                 <p>起投金额：{% @val.min_money%}元</p>
             </a>
         </div>
     </div>


     <h1 class="page-title title3">优选项目</h1>
     <div class="page-project" href="javascript:;" data-touch="false" ms-for="(key,project) in @project_list">
         <h2>{%@project.name%}  {%@project.format_name%}</h2>
         <table>
             <tr>
                 <td class="td1">
                     <p><big>{%@project.profit_percentage%}</big>%</p>
                     <span>借款利率</span>
                 </td>
                 <td class="td2">
                     <p>{%@project.invest_time_note%}</p>
                     <span>项目期限</span>
                 </td>
                 <td class="td3">
                     <p>{%@project.refund_type_note%}</p>
                     <span>还款方式</span>
                 </td>
                 <td>
                    @if($userStatus == true)
                     <a ms-if="@project.status == 130" href="javascript:;" ms-attr="{'attr-data-id':@project.id, 'attr-act-token':@project.act_token}" class="page-project-btn doInvest">立即出借</a>
                     <a ms-if="@project.status != 130" href="javascript:;" ms-attr="{'attr-data-id':@project.id, 'attr-act-token':@project.act_token}" class="page-project-btn doInvest disabled">已售罄</a>
                    @else
                     <a  href="javascript:;" ms-attr="{'attr-data-id':@project.id, 'attr-act-token':@project.act_token}" class="page-project-btn userDoLogin">立即出借</a>
                    @endif
                 </td>

             </tr>
         </table>
     </div>


    <section class="page-rule">
        <h2>- 活动规则- </h2>
        <p><span>1、</span>红包不可与加息券叠加使用，若投资时选择使用加息券，则该笔投资无法激活红包；</p>
        <p><span>2、</span>红包和加息券自领取之日起，有效期15天；</p>
        <p><span>3、</span>本活动仅限投资3、6、12月期项目及九安心项目；</p>
        <p><span>4、</span>活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服；</p>
        <p>本活动最终解释权归九斗鱼所有。</p>
    </section>


</article>
<div class="page-layer pop-2" data-modul="layer1">
    <div class="page-mask"></div>
    <div class="page-pop page-pop-lucky">
        <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer1">close</a>
        <p class="text1">恭喜您获得</p>
        <p class="text2"><big id="cash">200</big>元</p>
    </div>
</div>

<div class="page-layer pop-3" data-modul="layer2">
    <div class="page-mask"></div>
    <div class="page-pop page-pop-coupon">
        <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="layer2">close</a>
        <p class="text1">恭喜您获得</p>
        <div class="info">
            <p class="text2"><big id='bonus_rate'>0.5</big>%</p>
            <p class="text3" id='level_tip'>注册时间>1年</p>
        </div>

    </div>
</div>

<div class="page-layer pop-1" data-modul="layer3">
    <div class="page-mask"></div>
    <div class="page-pop page-pop-fail">
        <p class="text1">领取失败</p>
        <p class="text2" id="error_message">您的注册时间为xx年x月x日<br>请领取对应条件的礼券</p>
        <a href="javascript:;" class="pop-btn-confrim" data-toggle="mask" data-target="layer3">确认</a>
    </div>
</div>

<div class="page-layer login" data-modul="layer4">
    <div class="page-mask"></div>
    <div class="page-pop page-pop-fail">
        <a href="javascritp:;" class="page-pop-close1" data-toggle="mask" data-target="layer4">close</a>
        <p class="text1"></p>
        <p class="text2" >还没有登录, 请登录后参与活动</p>
        <a href="javascript:;" class="pop-btn-confrim userDoLogin">登录</a>
    </div>
</div>

<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
@endsection

{{--@section('footer')

@endsection--}}
    <!-- End prize pop -->
@section('jsScript')
<script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/activity-page.js')}}"></script>
    <script>
        var evclick = "ontouchend" in window ? "touchend" : "click";
        // 显示弹窗
        $(document).on(evclick, '[data-target]',function(event){
            event.stopPropagation();
            var $this = $(this);
            var target = $this.attr("data-target");
            var $target = $("div[data-modul="+target+"]");
         //   $target.show();
            //禁止鼠标穿透底层
            $target.css('pointer-events', 'none');
            setTimeout(function(){
                $target.css('pointer-events', 'auto');
            }, 400);
          //  $("body,html").css({"overflow":"hidden","height":"100%"});


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

    $(function(){
        function getAjaxData(url,data){
            mAjax(url, data, function(res){
                if(res && res.ret===0){
                    model.user_id = res.data.user_id;
                    model.nation_bonus = res.data.nation_bonus;
                    model.autumn_bonus = res.data.autumn_bonus;
                    model.project_list = res.data.projectList;
                }else{
                    //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
                }
            }, 'json');
        }

        var data = {'_token':$('#csrf_token').val()};
        getAjaxData('/activity/getActivityData', data)
    });

    //执行红包领取
    function doGetBonus(url, data, type)
    {
        $.ajax({
            url      :url,
            dataType :'json',
            data: data,
            type     :'post',
            success : function(res){
                if(res.status == true){
                    //国庆
                    if(type==1){
                        $("#bonus_rate").html(res.data.rate);
                        $("#level_tip").html(res.data.bonusLevelNote);
                        $('.pop-3').show();
                    }else{
                        $("#cash").html(res.data.money);
                        $('.pop-2').show();
                    }
                }else if(res.status ==false){
                    $("#error_message").html(res.msg);
                    $('.pop-1').show();
                }
            },
            error : function(msg) {
                alert('服务器链接错误');
            }
        })
    }
    //avalon js
    var model = avalon.vmodels['autumnNation'];
    if(!model){
        model = avalon.define({
            $id  :  'autumnNation',
            user_id: 0,
            nation_title: '星光闪耀迎国庆',
            autumn_title: '盛世好礼庆中秋',
            nation_bonus : [],
            autumn_bonus : [],
            project_list : [],
            getNationBonus: function(user_id, bonus_id, url, type){
                var data = {'user_id': user_id, 'bonus_id':bonus_id,'_token':$('#csrf_token').val()};
                var userStatus = '{{$userStatus}}';
                if(userStatus == false){
                    $(".login").show();
                    return false;
                }
                doGetBonus(url, data, type);
            }
        });
    }

    </script>
@endsection

