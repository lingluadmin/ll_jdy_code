@extends('pc.common.layoutNew')
@section('title', '收益计算器')
@section('csspage')
@endsection
@section('content')
<div class="v4-wrap ms-controller" ms-controller="calculatorCtl">
    <div class="v4-wrap v4-calculator-wrap2">
        <h2 class="v4-account-titlex">收益计算器</h2>
        <div class="v4-calculator-main">
            <dl class="v4-input-group">
                <dt>
                    <label>计算方式</label>
                </dt>
                <dd>
                    <p>
                        <label class="v4-input-label"><input type="radio"  value="onlyInterest"  ms-duplex-string="@type" ms-click="changeType('onlyInterest')"/>先息后本</label>
                        <label class="v4-input-label"><input type="radio"  value="equalInterest" ms-duplex-string="@type" ms-click="changeType('equalInterest')"/>等额本息</label>
                        <label class="v4-input-label"><input type="radio"  value="baseInterest"  ms-duplex-string="@type" ms-click="changeType('baseInterest')"/>到期还本息</label>
                    </p>
                </dd>
                <dt>
                    <label>预期出借金额</label>
                </dt>
                <dd>
                    <input type="text" class="v4-input" ms-duplex="@cash" ms-keyup="checkInput($event,'cash')"/>
                    <ins class="v4-input-unit">元</ins>
                </dd>
                <dt>
                    <label>借款期限</label>
                </dt>
                <dd>
                    <input type="text" class="v4-input" ms-duplex="@times" ms-keyup="checkInput($event,'time')"/>
                    <ins class="v4-input-unit" ms-if="@unit=='month'">月</ins>
                    <ins class="v4-input-unit" ms-if="@unit=='day'">天</ins>
                </dd>
                <dt>
                    <label>借款利率</label>
                </dt>
                <dd>
                    <input type="text" class="v4-input" ms-duplex="@inter" ms-keyup="checkInter($event)"/>
                    <ins class="v4-input-unit">%</ins>
                </dd>
                <dt>
                    <label>预期总收益</label>
                </dt>
                <dd>
                    <p>{% @rest|number(2) %}</p>
                </dd>
            </dl>
            <div class="v4-input-msg"></div>
            <div class="v4-calculator-btn">
                <input type="reset" class="v4-input-btn2" value="重置" ms-click="restParam()">
                <span  id="curDate" ms-visible="0">{% @curDate|date("yyyy-MM-dd HH:mm:ss") %}</span><br/>
                <span  id="endDate" ms-visible="0">{% @endDate|date("yyyy-MM-dd")  %}</span>
            </div>
        </div>
    </div>
    <div class="v4-wrap">
        <div class="v4-project-content">
            <div class="v4-tabel-detail-wrap">
                <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-115">
                <thead>
                    <tr>
                        <td>期数</td>
                        <td>应收利息</td>
                        <td>应收本金</td>
                        <td>应收总额</td>
                    </tr>
                </thead>
                <tbody>
                    <tr ms-for="(k, v) in @plan">
                        <td>第{% @v.time %}/{% @v.times %}期</td>
                        <td>{% @v.interest|number(2) %}</td>
                        <td>{% @v.capital|number(2) %}</td>
                        <td>{% @v.total|number(2) %}</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/about-calculator.js')}}"></script>
    <script type="text/javascript" src="{{assetUrlByCdn('/static/js/interest/interest.js')}}"></script>
</div>
@endsection

