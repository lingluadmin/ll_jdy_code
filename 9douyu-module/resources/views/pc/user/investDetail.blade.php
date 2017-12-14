@extends('pc.common.layout')

@section('title', '出借记录')

@section('csspage')
    <script type="text/javascript" src="{{assetUrlByCdn('static/angular/angular.min.js')}}"></script>
    <script type="text/javascript" src="{{ assetUrlByCdn('/static/lib/biz/investDetail.min.js')}}"></script>
@endsection

@section('content')

    <div class="v4-account" >
        <!-- account begins -->
        @include('pc.common.leftMenu')

        <div class="v4-content v4-account-white" ng-app="jdyApp" ng-controller="investDetailCtrl">
            <h2 class="v4-account-titlex">出借记录</h2>
            <span class="none" ng-style="isBlock(pageShow)">
                <h4 class="v4-section-title"><span></span>出借详情</h4>
                <div class="v4-tabel-detail-wrap" ng-style="isBlock(!status)" >
                    <h4 class="v4-section-title" ng-bind="investDetail.error"></h4>
                </div>
                <div class="v4-tabel-detail-wrap" ng-style="isBlock(isDisplay)" >
                  <table class="v4-tabel-detail">
                    <tr class="grey">
                      <td><label>项目名称</label><span ng-bind="investDetail.project_name +'  '+investDetail.format_name"></span></td>
                      <td><label>回款方式</label><span ng-bind="investDetail.refund_type_text"></span></td>
                    </tr>
                    <tr>
                        <td><label>出借金额</label><span ng-bind="investDetail.invest_cash|number:2"></span></td>
                      <td><label>优惠券</label><span ng-bind="investDetail.coupon_text"></span></td>
                    </tr>
                    <tr class="grey">
                        <td><label>借款利率</label><span ng-bind="investDetail.profit_percentage"></span>%</td>
                      <td><label>加息奖励</label><span ng-bind="investDetail.doing_coupon | number:2"></span></td>
                    </tr>
                    <tr>
                      <td><label>已收利息</label><span ng-bind="investDetail.ownInterest |number:2"></span></td>
                      <td><label>交易日期</label> <span ng-bind="investDetail.invest_time"></span></td>
                    </tr>
                    <tr class="grey">
                      <td><label>预期待收利息</label><span ng-bind="investDetail.ingInterest+investDetail.doing_coupon+investDetail.ownInterest |number:2"></span></td>
                      <td><label>到期日期</label><span ng-bind="investDetail.refund_end_time"></span></td>
                    </tr>
                  </table>
                </div>
            </span>
            <span class="none" ng-style="isBlock(isDisplay)">
                <h4 class="v4-section-title v4-mt-plus-20"><span></span>预期回款记录</h4>
                <div class="v4-tabel-detail-wrap " >
                   <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-48">
                       <thead>
                           <tr>
                               <td>回款期数</td>
                               <td>本金</td>
                               <td>利息</td>
                               <td>回款时间</td>
                               <td>回款状态</td>
                           </tr>
                       </thead>
                       <tbody>
                           <tr ng-repeat="plan in refundList">
                               <td ng-bind="plan.time_periods">第01/04期</td>
                               <td ng-bind="plan.principal | number:2">0.00</td>
                               <td ng-bind="plan.interest | number:2">1,140.00</td>
                               <td ng-bind="plan.refund_time">2017-04-09</td>
                               <td ng-bind="plan.refund_status">已回款</td>
                           </tr>
                       </tbody>
                   </table>
                </div>
            </span>
      </div>
    </div>
<!-- account ends -->
<div class="clear"></div>
@endsection
