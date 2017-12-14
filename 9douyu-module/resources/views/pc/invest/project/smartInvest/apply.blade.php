@extends('pc.common.layoutNew')

@section('title','赎回申请')

@section('content')
<div class="v4-wrap v4-confirm-wrap" ms-controller="investConfirm">
  <h2 class="v4-account-titlex">赎回申请</h2>
    <div class="v4-confirm-1">
      <h4 class="v4-confirm-title"><span></span>项目信息</h4>
      <table class="v4-confirm-table">
        <thead>
          <tr>
            <td class="pl62px" width="284">项目名称</td>
            <td>期待年回报率</td>
            <td>锁定期限</td>
            <td>已锁定天数</td>
            <td>还款方式</td>
            <td>赎回类型</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="pl60px" width="284"><a href="/project/detail/{{$project['id']}}">{{$project['name']}}&nbsp;&nbsp;{{$project['format_name']}}</a></td>
            <td>{{(float)$project['base_rate']}}% @if($project['after_rate']>0) +{{ (float)$project['after_rate'] }}%@endif</td>
            <td>{{ $project['format_invest_time'] . $project['invest_time_unit'] }}</td>
            <td>{{ $lock_days }}天</td>
            <td>{{ $project['refund_type_note'] }}</td>
            <td>提前赎回</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="v4-confirm-2">
      <div class="v4-confirm-content">
        <dl class="v4-input-group">
          <dt>到账金额(元)</dt>
          <dd><p><span class="v4-confirm-red">{{number_format($refund_cash,2)}}</span></p></dd>
        </dl>

        <div class="v4-apply-detail">
          <ul>
            <li>
              <p><span>赎回本金(元)</span>{{number_format($cash,2)}}</p>
            </li>
            <li>
              <p><span>已赚收益(元)</span>{{number_format($interest,2)}}</p>
            </li>
            <li>
              <p><span>赎回手续费(元)</span>{{number_format($fee,2)}}</p>
            </li>
          </ul>
        </div>

        <dl class="v4-input-group">
          <dt><label for="password">交易密码</label></dt>
          <dd>
              {{--<input type="password" name="trade_password" placeholder="请输入6~16位字母和数字的组合" data-pattern="password" class="v4-input">--}}
            <input type="password" name="password" placeholder="请输入6~16位字母和数字的组合"  data-pattern="password" class="v4-input" ms-duplex="@trade_password" ms-focus="cleanMsg('tradePw')">
              <input type="hidden" name="invest_id" value="{{$investId}}" />
              <input type="hidden" name="project_id" value="{{$project['id']}}" />
              <input type="hidden" name="cash" value="{{$cash}}" />
              <input type="hidden" name="fee" value="{{$fee}}" />
              <input type="hidden" name="token" value="{{ csrf_token() }}" />


            <a href="/user/forgetTradingPassword" class="v4-confirm-pwd">忘记密码？</a>
              <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
          </dd>
          <dt></dt>
          <dd>
            <div id="v4-input-msg" class="v4-input-msg">
              {% @jsMsg %}
            </div>
            <input type="button" class="v4-input-btn" value="确认赎回" ms-click="doApply($event)" id="submitBtn">

            <div class="v4-input-agree">
              <label><input type="checkbox" checked="checked" ms-duplex-checked="@isCheck" ms-click="cleanMsg('agree')">我已阅读并同意<a href="{{assetUrlByCdn('/static/pdf/InvestmentAndManagement.pdf')}}" class="blue" target="_blank">《出借咨询与管理服务协议》</a></label>
            </div>
          </dd>
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
      <p class="v4-layer_text">恭喜您，申请赎回成功！</p>
      <div class="v4-confirm-btn">
        <a href="/project/index" class="v4-input-btn" id="">继续出借</a>
        <a href="/user/" class="v4-input-btn" id="">返回我的账户</a>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/layer.js')}}"></script>
<script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/apply-refund.js')}}"></script>
@endsection

