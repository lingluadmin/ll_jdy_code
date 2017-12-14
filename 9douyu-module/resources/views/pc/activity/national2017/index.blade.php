@extends('pc.common.activity')

@section('title', '闪耀金秋 双节献礼')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('static/activity/national2017/css/index.css')}}">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div ms-controller="autumnNation" class="ms-controller">
    <div class="national-banner">
        <div class="national-wrap"><p><span>{{date('n.d',$activityTime['start']) }} - {{date('n.d',$activityTime['end'])}}</span></p></div>
    </div>
    <div class="national-wrap">
        <!-- 加息券 -->
        <div class="national-box">
            <div class="national-title">{%@nation_title%}</div>
            <div class="national-info">活动期间每位用户可领取国庆礼券一张，面值以领取时的实际注册时间为准。</div>
            <div class="national-rate">
                <a href="javascript:;" ms-for="(key,val) in @nation_bonus"  ms-click="getNationBonus(@user_id, @val.id, '/activity/getNationBonus', 1)" >
                    <div class="national-rate-num"><big>{%@val.rate%}</big>%</div>
                    <p>{%@val.bonusLevelNote%}</p>
                </a>
            </div>
        </div>
        <!-- End 加息券 -->

        <!-- 红包 -->
        <div class="national-box">
            <div class="national-title title2">{%@autumn_title%}</div>
            <div class="national-info">活动期间每日登录平台即可获得节日红包，请在以下红包中任选一个领取。</div>
            <div class="national-cash">
                <ul>
                    <li ms-for="(key, val) in @autumn_bonus" ms-click="getNationBonus(@user_id, @val.id, '/activity/getAutumnBonus', 2)">
                        <a href="javascript:;">
                            <p><big>{%@val.money%}</big>元</p>
                        </a>
                        <p class="national-cash-info">起投金额：{% @val.min_money%}元</p>
                    </li>
                    {{--<li>
                        <a href="javascript:;">
                            <p><big>30</big>元</p>
                        </a>
                        <p class="national-cash-info">起投金额：15000元</p>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <p><big>60</big>元</p>
                        </a>
                        <p class="national-cash-info">起投金额：20000元</p>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <p><big>100</big>元</p>
                        </a>
                        <p class="national-cash-info">起投金额：30000元</p>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <p><big>200</big>元</p>
                        </a>
                        <p class="national-cash-info">起投金额：60000元</p>
                    </li>--}}
                </ul>
            </div>
        </div>
        <!-- End 红包 -->

        <div class="national-pro">
            <div class="national-title title3">优选项目</div>
            <ul>
                <li ms-for="(key,project) in @project_list"   >
                    <div class="national-pro-title"><span>{% @project.name%}</span>{% @project.format_name%}</div>
                    <div class="national-pro-main">
                        <p class="p1"><strong><big>{%@project.profit_percentage%}</big>%</strong><span>期待年回报率</span></p>
                        <p class="p2"><em>{%@project.invest_time_note%}</em><span>项目期限</span></p>
                        <p class="p2"><em>{%@project.refund_type_note%}</em><span>还款方式</span></p>
                        <p class="p3" >
                          @if($userStatus==true)
                            <a ms-if="@project.status == 130" href="javascript:;" class="page-project-btn clickInvest"  ms-attr="{'attr-data-id':@project.id, 'attr-act-token':@project.act_token}">立即出借</a>
                            <a ms-if="@project.status != 130" href="javascript:;" class="page-project-btn clickInvest disable" ms-attr="{'attr-data-id':@project.id, 'attr-act-token':@project.act_token}">已售罄</a>
                          @else
                            <a  href="javascript:;" class="page-project-btn no-login-btn"  ms-attr="{'attr-data-id':@project.id, 'attr-act-token':@project.act_token}">立即出借</a>
                          @endif
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="national-rule">
        <div class="national-wrap">
            <div class="national-rule-main">
                <h3>- 活动规则 -</h3>
                <p>1、红包不可与加息券叠加使用，若投资时选择使用加息券，则该笔投资无法激活红包；</p>
                <p>2、红包和加息券自领取之日起，有效期15天；</p>
                <p>3、本活动仅限投资3、6、12月期项目及九安心项目；</p>
                <p>4、活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服；</p>
                <p>本活动最终解释权归九斗鱼所有。</p>
            </div>
        </div>
    </div>

    <div class="v4-layer_wrap pop-1" >
        <div class="Js_layer_mask national-pop-mask" data-toggle="mask" data-target="pop-1"></div>
        <div class="Js_layer v4-layer">
            <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="pop-1"></a>
            <div class="national-pop">
                <p><img src="{{assetUrlByCdn('static/activity/national2017/images/fail.png')}}" width="88" height="88"></p>
                <h5>领取失败</h5>
                <p id="error_message">您的注册时间为xx年x月x日，请领取对应条件的礼券。</p>
                <a href="javascript:;" class="v4-input-btn" data-toggle="mask" data-target="pop-1">确认</a>
            </div>
        </div>
    </div>

    <div class="national-pop-wrap pop-2" style="display: none;">
        <div class="national-pop-mask" data-toggle="mask" data-target="pop-2"></div>
        <div class="national-pop2">
            <span class="national-pop-close" data-toggle="mask" data-target="pop-2"></span>
            <h5>恭喜您获得</h5>
            <div class="national-pop-bonus">
                <div class="national-pop-rate-num"><big id='bonus_rate'>0.5</big>%</div>
                <p id='level_tip'>注册时间<1年</p>
            </div>
        </div>
    </div>

    <div class="national-pop-wrap pop-3" style="display: none;">
        <div class="national-pop-mask" data-toggle="mask" data-target="pop-3"></div>
        <div class="national-pop3">
            <span class="national-pop-close" data-toggle="mask" data-target="pop-3"></span>
            <h5>恭喜您获得</h5>
            <p class="national-pop3-txt"><big id="cash">200</big>元</p>
            <p id="success_tip">成功领取200元红包一个<br>请至“我的账户”中查看</p>
        </div>
    </div>

    <div class="v4-layer_wrap pop-4" >
        <div class="Js_layer_mask national-pop-mask" data-toggle="mask" data-target="pop-4"></div>
        <div class="Js_layer v4-layer">
            <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="pop-4"></a>
            <div class="national-pop">
                <p><img src="{{assetUrlByCdn('static/activity/national2017/images/fail.png')}}" width="88" height="88"></p>
                <h5>领取失败</h5>
                <p>您每天只能领取一次。</p>
                <a href="javascript:;" class="v4-input-btn" data-toggle="mask" data-target="pop-4">确认</a>
            </div>
        </div>
    </div>
<!--登录-->
    <div class="v4-layer_wrap login" >
        <div class="Js_layer_mask national-pop-mask" data-toggle="mask" data-target="pop-4"></div>
        <div class="Js_layer v4-layer">
            <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="login"></a>
            <div class="national-pop">
                <p><img src="{{assetUrlByCdn('static/activity/national2017/images/fail.png')}}" width="88" height="88"></p>
                <h5></h5>
                <p>还没有登录, 请登录后参与活动</p>
                <a href="/login" class="v4-input-btn" data-toggle="mask" data-target="login">登录</a>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/activity-page.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function(){
        $('.national-rate a').each(function() {
            $(this).click(function() {
                $('.pop-2').show();
            });
        });

        $('.national-cash li').each(function() {
            $(this).click(function() {
                $('.pop-3').show();
            });
        });

    $(document).on("click", '.no-login-btn',function(event){
        $(".login").show();
        return false;
    })

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
    })

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
                        $('.pop-2').mask();
                        return false;
                    }else{
                        $("#cash").html(res.data.money);
                        $("#success_tip").html(res.data.success_tip);
                        $('.pop-3').mask();
                        return false;
                    }
                }else if(res.status ==false){
                    $("#error_message").html(res.msg);
                    $('.pop-1').mask();
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
                    $(".login").mask();
                    return false;
                }
                doGetBonus(url, data, type);
            }
        });
    }

</script>
@endsection
