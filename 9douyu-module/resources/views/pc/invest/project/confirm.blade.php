@extends('pc.common.layoutNew')

@section('title','付款确认')

@section('content')
<div class="v4-wrap v4-confirm-wrap">
    <h2 class="v4-account-titlex">付款确认</h2>
    <div class="v4-confirm-1">
        <h4 class="v4-confirm-title"><span></span>出借信息</h4>
        <table class="v4-confirm-table">
            <thead>
                <tr>
                    <td class="pl150px">项目名称</td>
                    <td>期待年回报率</td>
                    <td>出借期限</td>
                    <td>还款方式</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="pl150px"><a href="/project/detail/{{$project['id']}}">{{$project['name']}}&nbsp;&nbsp;{{$project['format_name']}}</a></td>
                    <td>{{(float)$project['base_rate']}}%
                        @if($project['after_rate']>0)
                            +{{ (float)$project['after_rate'] }}%
                        @endif
                    <td>{{ $project['format_invest_time'] . $project['invest_time_unit'] }}</td>
                    <td>{{ $project['refund_type_note'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="v4-confirm-2">
        <div class="v4-confirm-content" ms-controller="investConfirm">
               <dl class="v4-input-group">
                   <dt>
                       出借金额(元)
                       <input type="hidden" name="projectId" value="{{ $project['id'] }}" />
                       <input type="hidden" name="cash"  value="{{ $cash }}" />
                       <input type="hidden" name="fee"   value="{{ $fee }}" />
                       <input type="hidden" name="rate"  value="{{ $project['profit_percentage'] }}" />
                       <input type="hidden" name="token" value="{{ csrf_token() }}" />
                       <input type="hidden" name="cal"   data-time="{{$project['invest_time']}}" data-refund="{{$project['calculator_type']}}" data-publish="{{$project['publish_at']}}" data-end="{{$project['end_at']}}" />
                   </dt>
                   <dd>
                       <p><span class="v4-confirm-red">{% @cashNew|number(2) %}</span><span class="v4-confirm-re1"> 预期总收益：<strong>{% @fee|number(2) %}</strong>元</span></p>
                   </dd>
                   <dt>
                       可用余额(元)
                   </dt>
                   <dd>
                       <p>
                           <span class="v4-confirm-cash">{{number_format($user['balance'],2,'.',',')}}</span>
                           @if($user['balance'] < $cash)
                               <span class="v4-confirm-re1"><em>您的可用余额不足，请充值</em><a href="/recharge/index">充值</a></span>
                           @endif
                       </p>
                   </dd>


                   <!-- 未实名认证 -->
                   @if($status == 'noNameCheck')
                       <dt>&nbsp;</dt>
                       <dd>
                           <div id="v4-input-msg" class="v4-input-msg">
                               <span>投资前请先实名认证<a href="/user/setting/verify" >立即设置</a></span>
                           </div>
                       </dd>
                   @endif

                   <!-- 未设置交易密码 -->
                   @if($status == 'noSetTrade')
                       <dt>&nbsp;</dt>
                       <dd>
                           <div id="v4-input-msg" class="v4-input-msg">
                               <span>投资请先设置交易密码并实名认证<a href="/user/setting/tradingPassword" >立即设置</a></span>
                           </div>
                       </dd>
                   @endif

                   <!-- 项目未开始 -->
                   @if($status == 'notStart')
                       <dt>&nbsp;</dt>
                       <dd>
                           <div id="v4-input-msg" class="v4-input-msg">
                               <span>投标未开始，您还可以<a href="/project/index" >关注其它项目</a></span>
                           </div>
                       </dd>
                   @endif

                   <!-- 已经投满 -->
                   @if($status == 'refund')
                       <dt>&nbsp;</dt>
                       <dd>
                           <div id="v4-input-msg" class="v4-input-msg">
                               <span>投标已完成，您还可以<a href="/project/index" >关注其它项目</a></span>
                           </div>
                       </dd>
                   @endif

                   <!-- 已经还款 -->
                   @if($status == 'finished')
                       <dt>&nbsp;</dt>
                       <dd>
                           <div id="v4-input-msg" class="v4-input-msg">
                               <span>投标已完成，您还可以<a href="/project/index" >关注其它项目</a></span>
                           </div>
                       </dd>
                   @endif

                   <!-- 可以投资 -->
                   @if(($status == 'canInvest') && ($user['balance'] >= $cash))
                       <dt>
                           优惠券
                       </dt>
                       <dd>
                           <select name="userBonusId" class="v4-select-bonus" ms-duplex-string="@bonus_id" ms-change="changeInterest($event)">
                               @if( $bonusFlag > 0 )
                                   <option value="0" data-rate="1-0">请选择要使用的优惠券</option>
                               @else
                                   <option value="0" data-rate="1-0">暂无可使用的优惠券</option>
                               @endif
                               @foreach($bonus as $v)
                                   @if($cash >= $v['min'])
                                       <option value="{{ $v['user_bonus_id'] }}" data-min="{{ $v['min'] }}" data-using="{{ $v['using_range'] }}" data-rate="{{ $v['cash']>0 ? $v['bonus_type'].'-'.$v['cash'] : $v['bonus_type'].'-'.$v['rate'] }}">
                                           {{ $v['name'] }}{{ $v['nameTile'] }} ({{ $v['using_range'] }},截止日期:{{ date("Y-m-d",strtotime($v["end_time"])) }})
                                       </option>
                                   @endif
                               @endforeach
                           </select>
                           <p class="v4-confirm-bouns1" ms-if="@bonus_it > 0">优惠券奖励：<span>{% @bonus_it | number(2)%}元</span></p>
                       </dd>
                       <dt>
                           <label for="password">交易密码</label>
                       </dt>
                       <dd>
                           <input type="password" name="password" placeholder="请输入6~16位字母和数字的组合"  data-pattern="password" class="v4-input" ms-duplex="@trade_password" ms-focus="cleanMsg('tradePw')">
                           <a href="/user/forgetTradingPassword" class="v4-confirm-pwd">忘记密码？</a>
                           <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                       </dd>
                       <dt>
                           &nbsp;
                       </dt>
                       <dd>
                           <div id="v4-input-msg" class="v4-input-msg">
                                {% @jsMsg %}
                           </div>
                           <input type="button" class="v4-input-btn" value="确认出借" ms-click="doInvest($event)" id="submitBtn">
                           <div class="v4-input-agree">
                               <label><input type="checkbox" checked="checked" ms-duplex-checked="@isCheck" ms-click="cleanMsg('agree')">我已阅读并同意<a href="{{assetUrlByCdn('/static/pdf/InvestmentAndManagement.pdf')}}" class="blue" target="_blank">《出借咨询与管理服务协议》</a></label>
                           </div>
                       </dd>
                   @endif
               </dl>
        </div>
    </div>

</div>  

<!--恭喜您，出借成功！弹窗 -->
<div class="v4-layer_wrap js-mask1"  style="display:none;" id="investSuccess">
<div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
<div class="Js_layer v4-layer v4-layer-confirm">
        <a href="/project/index" class="v4-layer_close Js_layer_close"></a>
        <div class="v4-layer_0 v4-layer_trun">
            <p class="v4-layer-normal-icon v4-layer-success-icon"><i class="v4-icon-20 v4-iconfont">&#xe69f;</i></p>
            <p class="v4-layer_text">恭喜您，出借成功！</p>
            <div class="v4-confirm-btn">
                <a href="/project/index" class="v4-input-btn" id="">继续出借</a>
                <a href="/user/" class="v4-input-btn" id="">返回我的账户</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/layer.js')}}"></script>
<script type="text/javascript" src="{{assetUrlByCdn('/static/js/interest/interest.js')}}"></script>
<script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/invest-confirm.js')}}"></script>
@endsection

