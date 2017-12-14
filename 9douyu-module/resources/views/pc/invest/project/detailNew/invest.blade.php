<div class="v4-single clearfix v4-mt-plus-20">
        <div class="v4-single-left">
            <div class="v4-single-left-head clearfix">
                @if( $project['pledge'] == 1 )
                    <div class="v4-listitem-icon"><span>新手专享</span></div>
                @elseif(isset($activityNote['type']) && !empty($activityNote['type']))
                    <div class="v4-listitem-icon"><span>{{$activityNote['note']}}</span></div>
                @elseif( $project['pledge'] == 2 )
                    <div class="v4-listitem-icon"><span>灵活转让</span></div>
                @endif
                <h4>{{$project['name']}}&nbsp;&nbsp;{{$project['format_name']}}</h4>
                @if( !$useBonus )
                    <span><i class="v4-iconfont">&#xe690;</i>本项目不支持使用优惠券</span>
                @endif
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
                            <span>项目期限</span>
                        </td>
                        <td>
                            <p>{{ number_format($project['total_amount']) }}元</p>
                            <span>借款总额</span>
                        </td>
                    </tr>
                </table>
            </div>
            <ul class="v4-single-left-foot">
                <li><i class="v4-iconfont">&#xe6b3;</i>
                @if( $project['new'] == 0 )
                    出借当日计息
                @else
                    满标当日计息
                @endif
                </li>
                <li class="line"><i class="v4-iconfont">&#xe6b5;</i>{{ $project['refund_type_note'] }}</li>
                <li>
                    @if( $project['calculator_type'] != 'equalInterest' && $project['is_credit_assign'] == 1 &&  $project['assign_keep_days']>0)
                        <i class="v4-iconfont">&#xe6d4;</i>持有 {{$project['assign_keep_days']}} 天后可转让
                    @else
                        不可转让
                    @endif
                </li>
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

            <div class="v4-single-input-wrap" ms-controller="projectDetailRight">
                <input type="text" id="investMoney" class="v4-input" placeholder="100元起投" ms-keyup="checkMoney($event)" ms-blur="checkMoney($event)" data-left-value="{{$project['left_amount']}}" ms-focus="cleanMsg()">
                <a href="javascript:void(0)" class="v4-btn-text" ms-click="investAll($event)" data-user-balance="{{$user['balance']}}" data-user-id="{{$user['id']}}">全投</a>
                <input type="hidden" id="calculator"  data-time="{{$project['invest_time']}}" data-rate="{{$project['profit_percentage']}}" data-refund="{{$project['calculator_type']}}" data-publish="{{$project['publish_at']}}" data-end="{{$project['end_at']}}" />
                <p class="des clearfix">
                     <span class="fl" id="showMsg"></span>
                     <em class="fr">预期总收益：<span id="interestTotal">0.00</span>元</em>
                </p>
                @if( $project['status'] == 150 )
                    <input type="button" class="v4-input-btn disabled" value="已售罄">
                @elseif($project['status'] == 160)
                    <input type="button" class="v4-input-btn disabled" value="已完结">
                @elseif( $project['pledge']==1 && !empty($user['id']) && $user['not_novice'])
                    <input type="button" class="v4-input-btn disabled" value="仅限新用户出借">
                @else
                    <input type="button" ms-attr="{'data-user-id':{{$user['id']}},'data-user-balance':{{$user['balance']}}}" class="v4-input-btn" value="立即出借" ms-click="checkInvest($event)">
                @endif
            </div>
            <form action="/invest/project/investConfirm/" method="post" id="investForm" :visible="false">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                <input type="hidden" value="{{$project['id']}}" id="projectId" name="projectId"/>
                <input type="hidden" id="formInvestMoney" name="formInvestMoney"/>
            </form>
        </div>
        <!--right-->
    </div>