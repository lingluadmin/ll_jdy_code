@extends('wap.common.wapBase')

@section('title','项目详情')

@section('content')

    <article>
        <nav class="v4-nav-top">
            <a href="javascript:void(0)" onclick="window.history.go(-1);"></a>项目详情
        </nav>
        <!-- style one -->
        <section class="w-box-show">
            <table class="App4-project-detail">
                <tr>
                    <td>项目名称</td>
                    <td>{{ $project['name'].' '.$project['format_name'] }}  </td>
                </tr>
                <tr>
                    <td>期待年回报率</td>
                    <td>{{ (float)$project['profit_percentage'] }}%</td>
                </tr>
                <tr>
                    <td>借款期限</td>
                    <td>{{ $project['invest_time_note'] }}</td>
                </tr>
                <tr>
                    <td>还款方式</td>
                    <td>{{ $project['refund_type_note'] }}</td>
                </tr>
                <tr>
                    <td>到期还款日</td>
                    <td>{{ $project['end_at'] }}</td>
                </tr>
                <tr>
                    <td>借款总额</td>
                    <td>{{ number_format($project['total_amount'],2) }}元</td>
                </tr>
                <tr>
                    <td>募集开始时间</td>
                    <td>{{ date('Y-m-d', strtotime($project['publish_at'])) }}（募集时间最长不超过20天）</td>
                </tr>
                <tr>
                    <td>风险等级</td>
                    <td>稳定型</td>
                </tr>
                <tr>
                    <td>出借条件</td>
                    <td>最低100元起投，最高不超过剩余项目总额</td>
                </tr>
                <tr>
                    <td>提前赎回方式</td>
                    @if( $project['refund_type'] != 40 && $project['is_credit_assign'] == 1 &&  $project['assign_keep_days']>0)
                        @if( $project['pledge'] == 2 )
                            <td>持有项目{{$project['assign_keep_days']}}天后可转让，仅支持单笔出借金额一次性全额转让；每日15点为转让结息时间，如在15点前（不含）出借成功，隔日转让成功后，计算1天收益；如15点后（含）出借成功，隔日15点前转让成功，将不计算利息，只返还本金；如隔日15点后转让成功，将计算1天收益。</td>
                        @else
                            <td>持有项目{{$project['assign_keep_days']}}天及以上，可申请转让变现（本金回款当日不可转让），仅支持单笔出借金额一次性全额转让</td>
                        @endif
                    @else
                        <td>不支持转让</td>
                    @endif
                    {{--<td>持有债权项目30天（含）即可申请债权转让，赎回时间以实际转让成功时间为准</td>--}}
                </tr>
                <tr>
                    <td>费用</td>
                    <td>买入费用：0.00%<br>退出费用：0.00%<br>提前赎回费率：0.00%</td>
                </tr>
                <tr>
                    <td>项目介绍</td>

                    <td>{{isset($company['factor_summarize']) ? htmlspecialchars_decode($company['factor_summarize']) : '九安心产品是保理公司将应收账款收益权转让给出借人；原债权企业多为国企及上市公司，切负有连带责任，借款期限一般为30~90天，适合偏好短期，且稳定的出借人。'}}</td>
                </tr>
                {{--<tr>
                    <td>协议范本</td>
                    <td><a href="javascript:;">【点击查看】</a></td>
                </tr>--}}
            </table>

            <div class="App4-company-detail">
                <h6>借款人信息</h6>
                <table>
                    <tr>
                        <td>债权企业名称：{{isset($company['credit_company']) ? $company['credit_company'] : null}}</td>
                    </tr>
                    <tr>
                        <td>企业证件号：{{isset($company['loan_user_identity']) && !empty($company['loan_user_identity']) ? substr($company['loan_user_identity'] ,0,4) .'******' : null}}</td>
                    </tr>
                    <tr>
                        <td>{{isset($company['family_register']) ? '经营地址：' .$company['family_register'] . '' : null}}</td>
                    </tr>
                    <tr>
                        <td>借款用途：资金周转</td>
                    </tr>
                </table>

            </div>
        </section>
    </article>

@endsection
@section('jsScript')
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                var client = getCookie('JDY_CLIENT_COOKIES');
                if(client == 'ios' || client == 'android'){
                    $(".v4-nav-top").hide();
                }
            });
        })(jQuery);
    </script>
@endsection
