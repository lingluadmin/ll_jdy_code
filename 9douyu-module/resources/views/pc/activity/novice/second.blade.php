@extends('pc.common.layout')

@section('title', '注册送888元红包')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/novice/css/index.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
<!-- content -->
@section('content')

<div class="page-banner"></div>

<div class="landon-box">
    <h1 class="title">新手操作流程</h1>
    <div class="landon-flow"></div>
    <ul class="landon-flow-text clearfix">
        <li class="li1">注册<br>送<span>888</span>元红包</li>
        <li class="li2">账户<br>实名认证</li>
        <li class="li3">账户<br>充值</li>
        <li class="li4">投资<br>新手专享项目</li>
        <li class="li5">坐等<br>收益到账</li>
    </ul>
</div>

<div class="landon-outer">
<div class="landon-box">
    <h1 class="title">新手888元红包</h1>
    <div class="sub"></div>
    <div class="landon-lucky"></div>
    @if($userStatus == true)
        <a href="javascript:;" class="landon-btn-oth disable">已领取</a>
    @else
        <a href="{{$registerUrl}}" class="landon-btn">一键领取888元</a>
    @endif
</div>
</div>


<!-- project -->
<div class="landon-box">
    <h1 class="title">新手专享项目</h1>
    <div class="landon-project">
        <table>
            <tr>
                <td class="td1">
                    <p class="text-color-red">{{$project['base_rate'] or 9}}<em>%@if( isset($project['after_rate']) && $project['after_rate']>0)+{{$project['after_rate'] or 2}}%@endif</em></p>
                    <span>借款利率</span>
                </td>
                <td class="td2">
                    <p>5<em>万元</em></p>
                    <span>单人限额</span>
                </td>
                <td class="td3">
                    <p>{{$project['format_invest_time'] or 30}}<em>{{$project['invest_time_unit'] or '天'}}</em></p>
                    <span>借款期限</span>
                </td>
                <td class="td4">
                    <p>100<em>元</em></p>
                    <span>起投金额</span>
                </td>
                <td align="right">
                    @if( $isNovice == true)
                        <a href="/redirect/noviceProject" class="landon-btn landon-btn-invest">立即投资</a>
                    @else
                        <a href="javascript:;" class="landon-btn landon-btn-invest disable">立即投资</a>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page-box clearfix">
    <div class="page-calculator">
        <div class="page-des">
            <p class="invest_rate_note">预期年利率：{{$project['base_rate'] or 9}}%@if($project['after_rate'] >0)+{{$project['after_rate'] or 2}}% @endif</p>
            <p>预期总收益：<span class="invest_cash_profit">91.67</span>元</p>
        </div>
        <p class="page-text">选择投资周期</p>
        <div class="page-calculator-btn invest_time_unit">
            <a href="javascript:;" class="active" attr-invest-type='100' attr-invest-time="{{$project['format_invest_time'] or 30}}" attr-invest-rate="{{$project['base_rate'] or 9}} +{{$project['after_rate'] or 2}} ">新手专享项目</a>
            <a href="javascript:;" attr-invest-type='200' attr-invest-time="3" attr-invest-rate="11">3个月</a>
            <a href="javascript:;" attr-invest-type='200' attr-invest-time="6" attr-invest-rate="11.5">6个月</a>
            <a href="javascript:;" attr-invest-type='200' attr-invest-time="12" attr-invest-rate="12">12个月</a>
        </div>
        <p class="page-text">输入投资金额</p>
        <div class="page-textarea">
            <input type="text" name="invest_cash" value="10000" placeholder="10000">
        </div>
         <input type="hidden" name="invest_time" value="{{$project['format_invest_time'] or 30}}">
         <input type="hidden" name="invest_rate" value="{{$project['profit_percentage'] or 11}}">
         <input type="hidden" name="invest_type" value="100">
         <a href="javascript:;" class="landon-btn landon-btn-invest">开始计算</a>
    </div>

    <div class="page-scroll">
        <h2><span></span>大家都在投资</h2>
        <div style="overflow: hidden;" id="messageList">

            <ul>
            @if( !empty($investList) )
                @foreach($investList as $key => $invest)
            <li><p><span>{{date('m/d',$invest['time'])}}</span>{{$invest['username']}} 投资了<em>{{$invest['invest_cash']}}</em>元</p></li>
                @endforeach
            @endif
            </ul>

        </div>

    </div>
</div>


<!-- 优势 -->
<div class="landon-advantage">
    <div class="landon-box">
        <h1 class="title">九斗鱼优势</h1>
        <div class="landon-advantage-img"></div>
        <ul class="landon-advantage-text clearfix">
            <li class="li1">
                <h5>集团实力</h5>
                <p>母公司耀盛中国为中港两地持牌金融机构，涵盖网络小贷、企业征信、私募基金、香港证券经纪等9张金融牌照</p>
            </li>
            <li class="li2">
                <h5>安全合规</h5>
                <p>平台稳定运营超3年，累计投资人数超17万，江西银行资金存管，全程交易签署具有法律效力的电子合同</p>
            </li>
             <li class="li3">
                <h5>收益稳健</h5>
                <p>预期年化利率7%~12%，项目期限1~12个月灵活可选，100元起投，无额外开户费用及交易费用</p>
            </li>
        </ul>
    </div>
</div>

<!-- 背景图定位 -->
<div class="pos1"></div>
<div class="pos2"></div>
@endsection

<!-- js -->
@section('jspage')
<script>

    $(document).ready(function() {
        setInterval(function () {
            $('#messageList').find("ul:first").animate({
                marginTop: "-35px"
            }, 1200, function() {
                $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
            });
        }, 2000);
    });
    $(document).ready(function () {
        $('.invest_time_unit a').on('click',function () {
            var _this   =   $(this);
            $('.invest_time_unit').find('a').removeClass('active');
            _this.addClass('active');
            var invest_time =   _this.attr('attr-invest-time');
            var invest_rate =   _this.attr('attr-invest-rate');
            var invest_reg  =   /\+/;
            var invest_rate_note = '预期年利率：'+invest_rate+'%';
            if( invest_reg.exec(invest_rate)){
                var  rateArr=   invest_rate.split('+');
                invest_rate =   parseInt(rateArr[0])+parseInt(rateArr[1]);
                invest_rate_note    =   '预期年利率：'+rateArr[0]+'%';
                if(rateArr['1'] >0){
                    invest_rate_note = invest_rate_note + '+'+rateArr['1']+"%";
                }
            }
            var invest_type =   _this.attr('attr-invest-type');
            $("input[name='invest_time']").val(invest_time);
            $("input[name='invest_rate']").val(invest_rate);
            $("input[name='invest_type']").val(invest_type);
            var invest_cash =   $("input[name='invest_cash']").val();
            var invest_profit = getInvestProfit(invest_time , invest_cash , invest_rate , invest_type);
            $('.invest_rate_note').html(invest_rate_note);
            $('.invest_cash_profit').html(invest_profit);

        })
        getInvestProfit = function (time , cash , rate,type) {
            if( time == '') {
                time = 30;
            }
            if( cash == '' ){
                cash = 10000;
            }
            if (rate =='') {
                rate = 11;
            }
            if( type == 100 ){
                return ((cash * rate / 100 /365 ) * time ) .toFixed(2);
            }
            return ((cash * rate / 100 /12 ) * time ) .toFixed(2);
        }
        loadInvestProfit  =   function(){
            var invest_cash =   $("input[name='invest_cash']").val();
            var invest_time =   $("input[name='invest_time']").val();
            var invest_type =   $("input[name='invest_type']").val();
            var invest_rate =   $("input[name='invest_rate']").val();
            var invest_profit = getInvestProfit(invest_time , invest_cash , invest_rate ,invest_type);
            $('.invest_cash_profit').html(invest_profit);
        }
        $('.landon-btn-invest').on('click' , function () {
            loadInvestProfit();
        });
        loadInvestProfit();
    })
</script>
@endsection
