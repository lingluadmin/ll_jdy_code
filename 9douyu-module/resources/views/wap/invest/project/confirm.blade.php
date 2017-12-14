@extends('wap.common.wapBaseLayoutNew')

@section('title','付款确认')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/confirm.css')}}">
  <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/bonus.css')}}">
@endsection
@section('content')
<article>

<nav class="v4-nav-top">
    <a href="/project/detail/{{$project["id"]}}" onclick="window.history.go(-1);"></a>付款确认
</nav>
    <div class="v4-confirm-1">项目剩余金额：{{ number_format($project['left_amount'],2) }}元</div>
    <form action="/invest/project/doInvest" method="post" id="investConfirm" ms-controller="investConfirm">
        <div class="v4-confirm-2">
            <input type="text" placeholder="100元起投" name="cashInput"  class="v4-input-1 m-input" id="cashInput" value="0" ms-keyup="checkMoney($event)">
            <input type="hidden" name="projectId" value="{{ $project["id"] }}">
            <input type="hidden" name="left_amount" value="{{ $project["left_amount"] }}">
            <input type="hidden" name="novice_invest_max" value="{{ $novice_invest_max }}">
            <input type="hidden" name="refund_type" value="{{ $project["refund_type"] }}" />
            <input type="hidden" name="projectRate" value="{{ $project["profit_percentage"] }}"/>
            <input type="hidden" name="pledge" value="{{ $project["pledge"] }}"/>
            <input type="hidden" name="balance"     value="{{ $balance }}">
            <input type="hidden" name="bonusCount"     value="{{ count($bonus) }}">
            <input type="hidden" name="calculator" id="calculator"  data-time="{{$project['invest_time']}}" data-refund="{{$project['calculator_type']}}" data-publish="{{$project['publish_at']}}" data-end="{{$project['end_at']}}" data-rate="{{$project['profit_percentage']}}"/>
            <div class="v4-confirm-cash">
                <span>可用余额：{{ number_format($balance,2) }}元</span> <a href="/pay/index">充值</a>
            </div>
            <input type="hidden" name="token" value="{{ csrf_token() }}">
        </div>
        <p class="v4-confirm-3">预期总收益：<span>{% fee|number(2) %}元</span><span ms-if="addFee>0"> + {% addFee|number(2)%}元</span></p>
        <section>
            <a class="v4-confirm-4">
                <dl>
                    <dt>优惠券</dt>
                    <dd>
                        <span class="v4-select-span" ms-click="chooseBonus()">{% bonusTxt%}</span>
                    </dd>
                </dl>
            </a>
        </section>

        <section class="v4-tip error">
            <p>{% jsMsg %}</p>
        </section>

        <section class="v4-confirm-5">
            <input type="button" class="v4-btn next" id="subInvestProject" value="确认" ms-click="doInvestCheck($event)">
            <p class="v4-confirm-6"><input type="checkbox" id="checkbox_a1" ms-duplex-checked="isCheck"  class="chk_1" ms-click="cleanMsg('agree')" /><label for="checkbox_a1"></label><a href="{{assetUrlByCdn('/static/pdf/InvestmentAndManagement.pdf')}}">《投资咨询与管理服务协议》</a></p>
        </section>


        <!-- 交易密码弹层开始 -->
        <section class="v4-pop layer-10" style="display:none;" id="v4-pop">
            <div class="v4-pop-mask"></div>
            <div class="v4-pop-main">
                <div class="v4-pop-tpw-title">
                    <ins>交易密码</ins>
                    <a href="javascript:void(0)" class="v4-pop-close" ms-click="closePwInput()"></a>
                </div>
                <div class="v4-pop-tpw-box clearfix">
                    <p class="v4-confirm-text1">{{$project['name'].' '.$project['format_name']}}</p>
                    <p class="v4-confirm-text2">￥{% cash|number(2)%}</p>
                    <p class="v4-confirm-text3">余额支付{% cash %}元</p>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="password" name="trade_password" placeholder="请输入交易密码" class="v4-input-2" ms-duplex="tradePwd" ms-click="cleanMsg('tradePwd')">
                    <section class="v4-tip v4-pop-tip error">
                        <p id="invest-sum1">{% ajaxMsg %}</p>
                    </section>
                    @if($status['password_checked'] != 'on')
                        <input type="button" value="设置交易密码" class="v4-btn" onclick="location.href='/user/setTradingPassword'">
                    @else
                        <input type="button" id="sub" value="确定" class="v4-btn" ms-click="doInvest()">
                    @endif
                </div>
            </div>
        </section>
        <!-- 交易密码弹层结束 -->

         <!-- 交易成功弹层开始 -->
            <section class="v4-pop layer-11" style="display:none;" id="v5-pop">
                <div class="v4-pop-mask"></div>
                <div class="v4-pop-main">
                    <div class="v4-pop-sucess clearfix">
                        <p class="v4-pop-icon"><span></span></p>
                        <p class="v4-pop-text1">交易成功</p>
                        <p class="v4-pop-text2">完成</p>
                    </div>
                </div>
            </section>
        <!-- 交易成功结束 -->

        <!--   coupons -->
        <section class="v4-pop v4-pop-coupons">
            <div class="v4-pop-mask" ms-visible="bonusVis"></div>
            <div class="v4-pop-main" ms-class="show:bonusVis">
                <div class="v4-pop-tpw-title">
                    <ins>选择优惠券</ins>
                    <a href="javascript:void(0)" class="v4-pop-close" ms-click="chooseBonus()"></a>
                </div>
                <div class="v4-select-coupons">
                    <div class="v4-pop-tpw-box clearfix">
                        @if(!empty($bonus))
                            @if($bonusNum>0)
                                @foreach($bonus as $v)
                                    @if($v['bonus_type'] == 300)
                                        <!-- 红包 -->
                                        <div class="v4-bonus-box cash" id="bonus_id_{{ $v['id'] }}" data-rate="{{ $v['bonus_type'].'-'.$v['bonus_value'] }}" data-min="{{ $v['min_money'] }}" data-name="已选 {{$v['bonus_value_note']}}{{$v['bonus_value']}} 红包" ms-click="selectBonus({{ $v['id'] }})">
                                            <div class="v4-bonus-num">
                                                <p><big>{{$v['bonus_value_note']}}{{$v['bonus_value']}}</big></p>
                                                <p>{{$v['min_money_note']}}</p>
                                            </div>
                                            <div class="v4-bonus-info">
                                                <h3>{{$v['name']}}</h3>
                                                <p>{{$v['using_desc']}}<br>有效期：{{$v['use_start_time']}}~{{$v['use_end_time']}}</p>
                                            </div>
                                            <i class="v4-bonus-icon"></i>
                                            <div class="v4-bonus-select" ms-class="selected:(bonus_id=='{{$v['id']}}')"></div>
                                        </div>
                                    @else
                                        <!-- 加息券 -->
                                        <div class="v4-bonus-box rate" id="bonus_id_{{ $v['id'] }}" data-rate="{{ $v['bonus_type'].'-'.$v['bonus_value'] }}" data-min="{{ $v['min_money'] }}" data-name="已选 {{$v['bonus_value']}}{{$v['bonus_value_note']}} 加息券" ms-click="selectBonus({{ $v['id'] }})">
                                            <div class="v4-bonus-num">
                                                <p><big>{{$v['bonus_value']}}{{$v['bonus_value_note']}}</big></p>
                                                <p>{{$v['min_money_note']}}</p>
                                            </div>
                                            <div class="v4-bonus-info">
                                                <h3>{{$v['name']}}</h3>
                                                <p>{{$v['using_desc']}}<br>有效期：{{$v['use_start_time']}}~{{$v['use_end_time']}}</p>
                                            </div>
                                            <i class="v4-bonus-icon"></i>
                                            <div class="v4-bonus-select"  ms-class="selected:(bonus_id=='{{$v['id']}}')"></div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                   </div>
                   @if(!empty($bonus))
                    <span ms-visible="bonusVis && bonusNum">
                        <a href="javascript:;" class="v4-bonus-btn" ms-click="selectBonus(0)" id="bonus_id_0" data-name="暂不使用优惠券">暂不使用优惠券</a>
                    </span>
                   @endif
                </div>
            </div>
        </section>

    </form>
    <script type="text/javascript" src="{{assetUrlByCdn('/static/js/interest/interest.js')}}"></script>
    <script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/lib/biz/project-invest.js') }}"></script>
</article>
@endsection