@extends('wap.common.wapBaseLayoutNew')

@section('title','回款计划')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/record.css')}}">
@endsection

@section('content')
<style type="text/css">
    .ms-controller{  visibility: hidden  }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<article class="v4-calendar-page">
     <div class="v4-user-page-head">
        <nav class="v4-top flex-box box-align box-pack v4-page-head">
            <a href="javascript:;" class="v4-back" onclick="location.href='/user';">返回</a>
            <h5 class="v4-page-title">回款计划</h5>
            <div class="v4-user">
                    <!-- <a href="/login">登录</a> | <a href="/register">注册</a> -->
                    <a href="javascript:;" data-show="nav">我的</a>
            </div>
        </nav>
    </div>

    <div class="v4-calendar-year">
        <div class="inner">
            <input type="hidden" id="year" value="{{$year}}">
            <input type="hidden" id="month" value="{{$month}}">
            <a href="/refund/calendar?year={{$month-1>0 ? $year : $year-1}}&month={{sprintf("%02d",$month-1>0 ? $month-1 :12)}}" data-touch="false" class="date-reduce"></a>
            <span>{{$dateStr}}</span>
            <a href="/refund/calendar?year={{$month+1>12 ? $year+1 : $year}}&month={{sprintf("%02d",$month+1>12 ? 1 :$month+1)}}" data-touch="false" class="date-add"></a>
        </div>
    </div>
    <div class="v4-calendar-wrap">
        <table class="v4-calendar-day">
            <tr class="v4-calendar-week">
                <td class="weekend">日</td>
                <td>一</td>
                <td>二</td>
                <td>三</td>
                <td>四</td>
                <td>五</td>
                <td class="weekend">六</td>
            </tr>
            <?php
                $year = !empty($year) ? $year : date("Y");
                $month = !empty($month) ? $month : date("m");
                $start_weekday = date('w', mktime(0,0,0, $month, 1, $year));
                $days = date('t', mktime(0,0,0, $month, 1, $year));
                //上个月天数
                $last_days = date('t', strtotime('last month', strtotime($date)));
                $out = '<tr>';
                $j = $k = $end =  0;
                for($j=0;$j<$start_weekday;$j++){
                    $before = $last_days - $start_weekday+1+$j;
                    $out .= '<td class="disabled">'.$before.'</td>';
                }
                for($k=1; $k<=$days;$k++){
                    $j++;
                    $day = $date.'-'.sprintf('%02d', $k);
                    if (in_array($day, $refunded_date)){
                        $out .= '<td class="status2"><span>'.$k.'</span></td>';
                    }elseif (in_array($day, $refund_date)){
                        $out .= '<td class="status1"><span>'.$k.'</span></td>';
                    }else{
                        $out .= '<td>'.$k.'</td>';
                    }
                    if ($j % 7 ==0){
                        $out .= '</tr><tr>';
                    }
                }
                while($j%7 != 0){
                    $end++;
                    $out .='<td class="disabled">'.$end.'</td>';
                    $j++;
                }
                $out .= '</tr>';
                echo $out;
            ?>
        </table>

    </div>
    <div class="v4-calendar-item">
        <div class="v4-calendar-data flex-box box-align box-pack">
            <div class="status1"><span></span>{{$refund_amount_data['refund_cash_note']}}</div>
            <p>{{$refund_amount_data['refund_cash']}} {{$refund_amount_data['refund_amount_unit']}}</p>
        </div>
        <div class="v4-calendar-data flex-box box-align box-pack">
            <div class="status2"><span></span>{{$refund_amount_data['refunded_cash_note']}}</div>
            <p>{{$refund_amount_data['refunded_cash']}} {{$refund_amount_data['refund_amount_unit']}}</p>
        </div>
    </div>

    <div class="scroller-wrap ms-controller" ms-controller="refundMonth" ms-on-swipeup="swipeUp()">
        <div class="scroller">
            <div class="v4-calendar-project" ms-repeat="refund">
                <div ms-class="{% el.status==200 ? 'v4-calendar-data disabled' : 'v4-calendar-data' %}" data-touch="false">
                    <p class="clearfix"><span>{% el.project_name %} {% el.format_name %}</span><em class="v4-status-red">{% el.cash %}</em></p>
                    <p class="clearfix"><span>{% el.times  %}</span><em>{% el.type == 1 ? '加息奖励' : el.principal_amount == 0 ? '利息' : '本金+利息' %}</em></p>
                </div>
            </div>
            <div class="v4-load-more"><i class="pull_icon"></i><span>加载中...</span></div>
        </div>
    </div>

<script src="{{ assetUrlByCdn('/static/weixin/js/lib/biz/user-refund-data.js') }}"></script>
</article>

<!-- 侧边栏 -->
@include('wap.home.nav')


@endsection

@section('jsScript')



<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>

@endsection

