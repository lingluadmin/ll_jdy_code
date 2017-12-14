@extends('wap.common.wapBaseNew')

@section('title','项目详情')
@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/project.css')}}">
@endsection

@section('content')
 
<article class="v4-detail-page">
    <div lass="v4-detail-page-head">
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">{{ $project['name'].' '.$project['format_name'] }}</h5>
        <div class="v4-user">
                <!-- <a href="/login">登录</a> | <a href="/register">注册</a> -->
                {{--<a href="javascript:;" data-show="nav">我的</a>--}}
            @if($status['is_login'] == 'on')
                <a href="javascript:;" data-show="nav">我的</a>
            @else
                <a href="/login">登录</a> | <a href="/register">注册</a>
            @endif
        </div>
    </nav>
    <header class="v4-detail-head">
        <div class="rate">
            @if($project['after_rate'] > 0)
                <big>{{ number_format($project['base_rate'],1) }}</big><span>%+{{ number_format($project['after_rate'],1) }}%</span>
            @else
                <big>{{ number_format($project['profit_percentage'],1) }}</big><span>%</span>
            @endif
        </div>
        <p class="text">期待年回报率</p>
        <div class="flag">
            <span>
                @if( $project['calculator_type'] != 'equalInterest' && $project['is_credit_assign'] == 1 &&  $project['assign_keep_days']>0)
                    持有{{$project['assign_keep_days']}}天后可转让
                @else
                    不可转让
                @endif
            </span>
            @if(!$ableBonus)
                <span>不支持优惠券</span>
            @endif
        </div>

        <div class="progress">
            <div class="bar" style="width:{{ $project['invest_speed'] }}%;" data-length="bar">
            </div>
            <p class="txt" data-offset="auto">可投金额{{ number_format($project['left_amount'],2) }}元</p>
        </div>

        <ul class="v4-detail-box flex-box box-align box-pack">
            <li>
                <p>项目期限</p>
                <span>{{$project['format_invest_time'].$project['invest_time_unit']}}</span>
            </li>
            <li>
                <p>还款方式</p>
                <span>{{$project['refund_type_note']}}</span>
            </li>
            <li>
                <p>起投金额</p>
                <span>100元</span>
            </li>
        </ul>
    </header>
</div>
    {{--<a href="javascript:;" class="v4-detail-link">--}}
       {{--<span class="tag">活动</span>--}}
       {{--爱情银行，长存的不只有时光--}}
       {{--<span class="arrow"></span>--}}
    {{--</a>--}}

    <section class="v4-detail-content">
        <h3>交易须知</h3>
        <!-- <table>
            <tr>
                <td class="td1">计息方式</td>
                <td class="td2">出借当日计息</td>
            </tr>
            <tr>
                <td class="td1">预期回款日</td>
                <td class="td2">2017-12-08</td>
            </tr>
            <tr>
                <td class="td1">借款总额</td>
                <td class="td2">910,000元</td>
            </tr>
            <tr>
                <td class="td1">风险等级</td>
                <td class="td2">稳定型</td>
            </tr>
            <tr valign="top">
                <td class="td1">赎回方式</td>
                <td class="td2">持有项目债权30天以上可申请债权转让，仅支持一次性全额转让</td>
            </tr>
            <tr valign="top">
                <td class="td1">费用</td>
                <td class="td2">买入费用:0.00%，退出费用:0.00%提前赎回费用:0.00%</td>
            </tr>
        </table> -->
        <div>
            <dl class="clearfix">
                <dt class="td1">计息方式</dt>
                <dd class="td2">@if( $project['new'] == 0 ) 出借当日计息 @else 满标当日计息 @endif</dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">预期回款日</dt>
                <dd class="td2">{{ $project['end_at'] }}</dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">借款总额</dt>
                <dd class="td2">{{ number_format($project['total_amount']) }}元</dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">风险等级</dt>
                <dd class="td2">稳定型</dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">赎回方式</dt>
                <dd class="td2">持有项目债权30天以上可申请债权转让，仅支持一次性全额转让</dd>
            </dl>
            <dl class="clearfix">
                <dt class="td1">费用</dt>
                <dd class="td2">买入费用:0.00%，退出费用:0.00%提前赎回费用:0.00%</dd>
            </dl>
        </div>
        
    </section>

    <section class="v4-detail-content">
        <a href="/project/companyDetail/{{$project['id']}}" class="v4-detail-link">
            项目详情<span class="arrow"></span>
        </a>
        <h6 class="intro">项目介绍</h6>
        <div class="v4-mult-ellipsis">
            <p>
            @if($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_THIRD_CREDIT) <!--第三方-->

            {!! $creditDetail['companyView']['project_desc'] or '' !!}

            @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_FACTORING) <!--保理-->
                {{isset($creditDetail['companyView']['factor_summarize']) ? htmlspecialchars_decode($creditDetail['companyView']['factor_summarize']) : '九安心产品是保理公司将应收账款收益权转让给出借人；原债权企业多为国企及上市公司，切负有连带责任，借款期限一般为30~90天，适合偏好短期，且稳定的出借人。'}}

            @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_CREDIT_LOAN)<!--信贷-->

                {{!empty($creditDetail['companyView']) && !empty($creditDetail['companyView']['founded_time']) && isset($creditDetail['companyView']['background']) ? $creditDetail['companyView']['background'] : ' 债权借款人均为工薪精英人群，该人群有较高的教育背景、稳定的经济收入及良好的信用意识。'}}

            @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_HOUSING_MORTGAGE)<!--房抵-->

                {{isset($creditDetail['companyView']['credit_desc']) ? $creditDetail['companyView']['credit_desc'] : '借款人因资金周转需要，故以个人名下房产作为抵押进行借款。此类借款人有稳定的经济收入及良好的信用意识。'}}

            @else
                九安心产品是保理公司将应收账款收益权转让给出借人；原债权企业多为国企及上市公司，切负有连带责任，借款期限一般为30~90天，适合偏好短期，且稳定的出借人。
            @endif
            </p>
        </div>
        
    </section>
    <a href="/project/refund_plan/{{$project['id']}}" class="v4-detail-link v4-detail-link-single">
            回款计划<span class="arrow"></span>
    </a>
    <a href="/project/invest_record/{{$project['id']}}" class="v4-detail-link v4-detail-link-single">
            出借记录<span class="arrow"></span>
    </a>
    <!-- 出借 -->
    @if($status['is_login'] == 'on')
        @if($project['status'] == 130 )
            @if($status['name_checked'] != 'on')
                <a href="/user/verify" class="v4-invset-btn">立即实名</a>
            @else
                @if($project['pledge']==1)
                    @if($isNovice)
                       <a href="/invest/project/confirm/{{$project['id']}}" class="v4-invset-btn">立即出借</a>
                    @else
                       <a href="javascript:;" class="v4-invset-btn disabled">仅限新用户出借</a>
                    @endif
                @else
                    <a href="/invest/project/confirm/{{$project['id']}}" class="v4-invset-btn">立即出借</a>
                @endif
            @endif
        @elseif($project['status'] == 150)
            <a href="javascript:;" class="v4-invset-btn disabled">已售罄</a>
        @elseif($project['status'] == 160)
            <a href="javascript:;" class="v4-invset-btn disabled">已完结</a>
        @endif

    @else
        <a href="/login" class="v4-invset-btn">请先登录</a>
    @endif



</article>
<!-- 侧边栏 -->
@include('wap.home.nav') 


@endsection
@section('jsScript')

<script>
  
    //判断进度条上文字的偏移位置 
    $(function(){
        var bar = $('[data-length="bar"]');
        var txtOffset = $('[data-offset="auto"]');

        var w = txtOffset.width()/46.875;
        var l = (bar.width())/46.875;
        txtOffset.css({"left":bar.width()-txtOffset.width()/2});
        // alert(bar.width());
        var w = parseInt(bar[0].style.width);
        if(w>86 && w<=100){
            txtOffset.css({"left":"12rem",});
        }
        if(w<=20){
            txtOffset.css({"left":"0.2rem"});
        }
    })

</script>

@endsection
