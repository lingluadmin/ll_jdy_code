<div class="v4-single clearfix v4-mt-plus-20 v4-smart">
        <div class="v4-single-left">
            <div class="v4-single-left-head clearfix">
                <h4>{{$project['name']}}&nbsp;&nbsp;{{$project['format_name']}}</h4>
                <span><i class="v4-iconfont">&#xe690;</i>本项目不支持使用优惠券</span>
            </div>
            <div class="v4-single-left-body">
                <table>
                    <tr>
                        <td>
                            <p class="rate"><big>{{number_format($project['base_rate'],1)}}%</big>
                            @if($project['after_rate']>0)
                                +{{ number_format($project['after_rate'],1) }}%
                                @endif</p>
                            <span>期待年回报率</span>
                        </td>
                        <td class="line">
                            <p>{{ $project['format_invest_time'] . $project['invest_time_unit']}}</p>
                            <span>锁定期限</span>
                        </td>
                        <td>
                            <p>{{ number_format($project['total_amount']) }}元</p>
                            <span>借款总额</span>
                        </td>
                    </tr>
                </table>
            </div>
            <ul class="v4-single-left-foot">
                <li><i class="v4-iconfont">&#xe6b3;</i>T+1日计息</li>
                <li class="line"><i class="v4-iconfont">&#xe6b5;</i>{{ $project['refund_type_note'] }}</li>
                <li><i class="v4-iconfont">&#xe6d4;</i>锁定期内不可赎回</li>
            </ul>
        </div>
        <!--left-->
        <div class="v4-single-right">
            <div class="v4-project-progress">
                <div class="text clearfix"><span>募集进度</span><em>{{ $project['invest_speed'] }}%</em></div>
                <div class="bar">
                    <div class="step" style="width:{{ $project['invest_speed'] }}%"></div>
                </div>
                <p class="des clearfix">
                    <span class="fl">剩余可投(元)</span>
                    <em class="fr" >{{number_format($project['left_amount'])}}</em>
                </p>
            </div>

            <div class="v4-single-input-wrap v4-pre" ms-controller="projectDetailRight">
                <input type="text" id="investMoney" class="v4-input v4-smart-9" placeholder="1000元起投，100整数倍增加" ms-keyup="checkMoney($event)" ms-blur="checkMoney($event)" data-left-value="{{$project['left_amount']}}" ms-focus="cleanMsg()">
<!--                 <a href="javascript:void(0)" class="v4-btn-text">全投</a>
 -->                <input type="hidden" id="calculator" data-time="{{$project['invest_time']}}" data-rate="{{$project['profit_percentage']}}" data-refund="{{$project['calculator_type']}}" data-publish="{{$project['publish_at']}}" data-end="{{$project['end_at']}}"/>
                <p class="des clearfix">
                     <span class="fl" id="showMsg"></span>
                     <em class="fr"><i title="实际收益将按照匹配债权的本金额度计算收益" class="v4-acc-icon v4-iconfont v4-smart-6" id="evaluate1">&#xe6dc;</i>
预期总收益：<span id="interestTotal">0.00</span>元</em>
                </p>
                @if( $project['status'] == 150 )
                    <input type="button" class="v4-input-btn disabled" value="已售罄">
                @elseif($project['status'] == 160)
                    <input type="button" class="v4-input-btn disabled" value="已完结">
                @else
                    @if ($project['raise_over'] == true)
                        <input type="button"  class="v4-input-btn disabled" value="募集期结束">
                    @else
                        <input type="button" ms-attr="{'data-user-id':{{$user['id']}},'data-user-balance':{{$user['balance']}},'smart_invest_type':1}" class="v4-input-btn" value="立即出借" ms-click="checkInvest($event)">
                    @endif
                @endif
                <div class="v4-input-agree v4-agree-1">
                    <label><input type="checkbox" name="aggreement" checked="checked" id="checkbox-1">
                    <span>我已阅读并同意<a href="" class="blue" target="_blank">《智投计划服务协议》、</a><a href="{{assetUrlByCdn('/static/pdf/InvestmentAndManagement.pdf')}}" class="blue" target="_blank">《九斗鱼投
                    资咨询与管理服务协议》</a>
                    </span>
                    </label>
                </div>
            </div>
            <form action="/invest/project/investConfirm/" method="post" id="investForm" :visible="false">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                <input type="hidden" value="{{$project['id']}}" id="projectId" name="projectId"/>
                <input type="hidden" value="{{$project['assets_platform_sign']}}" id="projectNo" name="projectNo"/>
                <input type="hidden" id="formInvestMoney" name="formInvestMoney"/>
            </form>
        </div>
        <!--right-->
    </div>