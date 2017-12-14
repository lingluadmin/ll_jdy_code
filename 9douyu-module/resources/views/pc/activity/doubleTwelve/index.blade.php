@extends('pc.common.activity')

@section('title', '12•12狂欢嘉年华')
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('static/activity/doubleTwelve/css/index.css')}}">
@endsection
@section('content')
<div class="page-wrap">
    <div class="twe-banner">
        <p>活动时间：{{date('Y年m月d日',$activityTime['start'])}}~{{date('Y年m月d日',$activityTime['end'])}}</p>
    </div>

    <div class="twe-bg">
        <div class="twe-wrap ms-controller" ms-controller="activityHome" >
            <div class="twe-box">
                <h4 class="twe-title"></h4>
                <div class="twe-box-1">
                @include('pc.activity.doubleTwelve.bonus')
                </div>
            </div>
            <div class="twe-box">
                <h4 class="twe-title1 "></h4>
                <div class="twe-box-1">
                    <div class="money-box">
                        <div class="money-return">
                            <p>用户在活动页面投资九安心、3月、6月、12月期项目，累积投资总金额≥1万元，除正常投资收益外，用户还可额外获得累计投资总金额*2‰的返现奖励。</p>
                        </div>
                        <div class="money-return-case">
                            <p>投资九省心3月期项目3万元，投资九省心6月期项目7万元，累积总投资金额=<span>3</span>万元+<span>7</span>万元</p>
                            <p class="end">小王可获得返现金额为:<big>10</big>万元*<big>2‰</big>=<big>200</big>元</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="twe-box">
            @include('pc.activity.doubleTwelve.project')
            </div>
            <div class="twe-rule">
                <h4>活动规则：</h4>
                <p>1、活动时间：{{date('Y年m月d日',$activityTime['start'])}}~{{date('Y年m月d日',$activityTime['end'])}}；</p>
                <p>2、双12投资红包有效期截止到{{date('Y年m月d日',$activityTime['end'])}}；</p>
                <p>3、请将app升级至4.2.2及以上版本，方可参与活动；</p>
                <p>4、活动期间累积提现金额≥5万元，将取消获得返现奖励的资格；</p>
                <p>5、仅限在活动页面投资项目才可计入累积投资金额，返现奖励将于2018年2月28日前发放；</p>
                <p>6、活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服；</p>
                <p>本活动最终解释权归九斗鱼所有。</p>
            </div>
        </div>
    </div>
</div>
<div class="page-layer login">
    <div class="page-mask"></div>
    <div class="page-pop">
        <div class="page-pop-inner">
            <div class="page-pop-pos">很抱歉</div>
            <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="login">close</a>
            <img src="{{assetUrlByCdn('static/activity/doubleTwelve/images/img4.png')}}" width="59" height="59"  class="twe-img1" />
            <p class="page-pop-text">请登录后参加活动～</p>
            <a href="/login" class="winter-btn1">去登录</a>
        </div>
    </div>
</div>

 <div class="page-layer receive" >
    <div class="page-mask"></div>
    <div class="page-pop page-pop1">
        <div class="page-pop-inner">
            <div class="page-pop-pos">恭喜您</div>
            <a href="javascript:;" class="page-pop-close close-receive"  data-toggle="mask" data-target="receive" >close</a>
            <p class="page-pop-text1 receive_success">成功领取XX元双12投资红包一个<br/>请至“我的账户”中查看</p>
            <div class="page-bouns"><p><span id=bonus-value>30</span>元</p></div>
            <a href="javascript:;" class="winter-btn1" data-toggle="mask" data-target="receive" >我知道了</a>
        </div>
    </div>
</div>
 <div class="page-layer error">
     <div class="page-mask"></div>
     <div class="page-pop">
         <div class="page-pop-inner">
             <div class="page-pop-pos">很抱歉</div>
             <a href="javascript:;" class="page-pop-close" data-toggle="mask" data-target="error">close</a>
             <img src="{{assetUrlByCdn('static/activity/doubleTwelve/images/img4.png')}}" width="59" height="59"  class="twe-img1" />
             <p class="page-pop-text error_message_common">您已经领取过红包了~</p>
             <a href="javascript:;" class="winter-btn1" data-toggle="mask" data-target="error">我知道了</a>
         </div>
     </div>
 </div>

<input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
<script type="text/javascript" src="{{ assetUrlByCdn('/static/activity/doubleTwelve/js/activity-double.js')}}"></script>
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

        $(document).on("click", ".receive-bonus", function(event){
            var _this = $(this);
            event.stopPropagation();
            if ("{{$userStatus}}" == false) {
                $(".login").mask();
                return false;
            }
            var status = _this.attr('attr-bonus-status');
            if(status =='received'){
                $('.error_message_common').html('您已经领取过红包了');
                $(".error").mask();
                return false;
            }
            var bonus_id =  _this.attr('attr-bonus-id');
            var position =   _this.attr('attr-bonus-position');

            $.ajax({
                url: '/activity/doubleTwelve/doGetBonus',
                type: 'post',
                dataType:'json',
                data:{'_token':$('#csrf_token').val(),'receive_bonus':bonus_id},
                async:false,
                success: function(res){
                    if (res.status == true) {
                        _this.parents('.twe-bouns').addClass('received');
                        $(".receive_success").html('成功领取'+position+'元双12投资红包一个<br/>请至“我的账户”中查看');
                        $("#bonus-value").html(position);
                        $('.receive').mask();
                    } else {
                        $('.error_message_common').html(res.msg);
                        $(".error").mask();
                    }
                }

            })

        });
    </script>
@endsection

