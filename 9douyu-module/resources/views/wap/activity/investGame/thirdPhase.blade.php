@extends('wap.common.activity')

@section('title', '新春伊始 如鱼得水')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/investGame3/css/thirdPhase.css') }}">
@endsection

@section('content')
<div class="first-bg">
<p>{{date("m.d",$activityTime['start'])}}-{{date("m.d",$activityTime['end'])}}</p>
</div>

<div class="first-bg1">
	<div class="first-title"></div>
@if( $activityStatus ==\App\Http\Logics\Activity\InvestGameLogic::ACTIVITY_PADDING )
	<section class="first-mg">
@if(!empty($projectList))
            @foreach($projectList as $key=> $project)
		<div class="first-box">
			<div class="first-title1">{{$project['product_line_note']}} • {{$project['invest_time_note']}}</div>
			<table class="first-table">
				<tr>
					<td width="35%"><span>{{(float)$project['profit_percentage']}}</span>％</td>
					<td width="32%">{{$project['left_amount']}}元</td>
					<td rowspan="2">
@if($project['status'] == \App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING && \App\Tools\ToolTime::getUnixTime($project['publish_at'],'default') >= time())
                        <a href="javascript:;"  attr-data-id="{{$project['id']}}" class="first-btn ">待售</a>
@elseif($project['status'] == \App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING)
                        <a href="javascript:;"  attr-data-id="{{$project['id']}}" class="first-btn investProject">投资</a>
@else
                        <a href="javascript:;"  attr-data-id="{{$project['id']}}" class="first-btn disable investProject">售罄</a>
@endif
                </td>
				</tr>
				<tr>
					<td>借款利率</td>
					<td>剩余可投</td>
				</tr>
			</table>
		</div>
        @endforeach
                @endif
	</section>
@endif
</div>
<div class="first-time">
@if( $activityStatus ==\App\Http\Logics\Activity\InvestGameLogic::ACTIVITY_NOT_OPEN)
    <p class="antwo-sum">活动未开始</p>
@elseif($activityStatus ==\App\Http\Logics\Activity\InvestGameLogic::ACTIVITY_IS_OVER)
    <p class="antwo-sum">活动已经结束</p>
@else
    <p class="antwo-sum">距离今日争夺战结束还有</p>
    <p class="antwo-num server-spike-time" attr-spike-time="{{ date("Y/m/d H:i:s",time()) }}">{!! $lastSecond !!}</p>
@endif
</div>
<div class="first-title-2"></div>
@if($nowDay['statistics'] && $activityStatus!=\App\Http\Logics\Activity\InvestGameLogic::ACTIVITY_NOT_OPEN && !empty($nowDay['user']))
    @foreach( $nowDay['statistics'] as $key => $statistic)
    <!-- <p class="first-title2">暂无排名数据</p> -->
    <p class="first-title2">九安心PK排名</p>
    @if(empty($statistic))
    <p class="first-title2">暂无排名数据</p>
    @else
    <div class="first-ranking">
    @foreach($statistic as $id  => $info )
    <p><span>{{\App\Tools\ToolStr::hidePhone($nowDay['user'][$info['user_id']]['phone'])}}</span><span>{{ \App\Tools\ToolMoney::moneyFormat($info['total'])}}元</span></p>
    @endforeach
     </div>
     @endif
     @endforeach
     @else
         <p class="first-title2">暂无投资排名数据</p>
@endif
    <p class="first-up" ><a href="javascript:window.location.reload()">点我更新最新投资数据</a></p>
<div class="first-title-1"></div>
<div class="first-gift">
    <p class="gift-title">九安心奖品</p>
</div>
<section class="first-mg first-j">
	<p class="antwo-sum antwo1" style="margin-top: 1.5rem;">中奖记录</p>
     <div class="first-record">

         <div class="first-date1">
             @if(!empty($everyDay))
                 @foreach( $everyDay as $key=> $every)
                     <p class="first-date">{{date("m月d日",strtotime($key))}}</p>
                     @foreach( $every['statistics'] as $k => $statistics )
                         <p>九安心</p>
                         <ul>
                             @if( empty($statistics) )
                                 <li>
                                     <p><span></span><span>暂无中奖数据</span><span></span></p>
                                 </li>
                             @else
                                 @foreach( $statistics as $num => $info)
                                     @if(isset($every['user'][$info['user_id']]['phone']) && !empty($every['user'][$info['user_id']]['phone']))
                                         <li>
                                             <p><span>{{\App\Tools\ToolStr::hidePhone($every['user'][$info['user_id']]['phone'])}}</span><span>{{$info['total']}}元</span><span>{{$lotteryList['lottery'][$num+1]['name']}}</span></p>
                                         </li>
                                     @endif
                                 @endforeach
                             @endif

                        </ul>
                     @endforeach
                 @endforeach
             @else
                 <ul>
                     <li>
                         <p><span></span><span>暂无中奖数据</span><span></span></p>
                     </li>
                 </ul>
             @endif
         </div>
     </div>

</section>
<div class="kill-tip"><span></span><a href="javascript:;">查看活动规则</a></div>
<!-- 弹窗 -->
    <div class="kill-pop-wrap">
        <div class="mask3"></div>
        <div class="kill-pop" id="kill-pop">
            <i></i>
            <h3>活动规则</h3>
            <p>1、本次投资PK活动仅限投资九安心项目。</p>
            <p>2、活动期间内，每日各选取九安心累计出借金额第一名，获得对应奖品；以用户投资PK项目金额进行排序，用户出借金额出现并列时，则按照用户投资  时间的先后进行名次排序。</p>
            <p>3、参与领取奖品者，活动期间提现金额≥10000元，取消其领奖资格。</p>
            <p>4、活动所得奖品以实物形式发放，将在2017年5月30日之前，与您沟通联系确定发放奖品。</p>
            <p>5、活动期间如有任何疑问请致电九斗鱼官方客服：400-6686-568，或登录九斗鱼咨询在线客服。</p>
        </div>
    </div>

@endsection

@section('footer')

@endsection
@section('jsScript')
    <script type="text/javascript" src="{{assetUrlByCdn('/static/weixin/activity/investGame/js/countDown.js')}}"></script>
    <script type="text/javascript">
        $(".kill-tip a").click(function(){
            $(".kill-pop-wrap").show();
            var h = $("#kill-pop").outerHeight();
            var mt = parseInt(-h/2) + 'px';
            $("#kill-pop").css("margin-top",mt);
        });
        $(".kill-pop i,.mask3").click(function(){
            $(".kill-pop-wrap").hide();
        });

        $('.investProject').click(function () {

            var  client     =   "{{ $client }}"
            var  projectId  =   $(this).attr("attr-data-id");
            if( !projectId ||projectId==0){
                return false;
            }
            if( client =='ios'){

                window.location.href="objc:certificationOrInvestment("+projectId+",1)";
                return false;
            }
            if (client =='android'){
                window.jiudouyu.fromNoviceActivity(projectId,1);
                return false;
            }
            window.location.href='/project/detail/'+projectId;

        })

        $(function(){
            var status      =   '{{ $activityStatus }}';
            if(status == 3){
                setInterval(function(){countDown.getRTime('server-spike-time','{{ date("Y/m/d H:i:s",$lastTime) }}')},1000);
            }
        })
    </script>
@endsection

