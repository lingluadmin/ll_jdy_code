@extends('wap.common.wapBaseLayoutNew')


@section('title','交易记录')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/record.css')}}">
    <style type="text/css">
        .ms-controller{
            visibility: hidden;
        }
    </style>
@endsection

@section('content')

    <article>
        <div class="v4-user-page-head">

            <nav class="v4-top flex-box box-align box-pack v4-page-head">
                <a href="java  script:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
                <a href="javascript:;" class="v4-filter" data-touch="false" data-layer="layer-entry">筛选</a>
                <h5 class="v4-page-title">交易记录</h5>
                <div class="v4-user">
                    <!-- <a href="/login">登录</a> | <a href="/register">注册</a> -->
                    <a href="javascript:;" data-show="nav">我的</a>
                </div>
            </nav>
        </div>
        <?php $type = isset($data['type']) ? $data['type'] : 'all'; ?>

        <div id="fundHistory" class="ms-controller" ms-controller="fundHistory" valType="{{ $type }}" ms-on-swipeup="swipeUp()" ms-on-swipedown="swipeDown()">

            <div class="scroller" ms-repeat="list" data-repeat-rendered='changeM'>

                <p class="v4-record-date">{% el.m %}</p>

                <div class="v4-record-list" >
                    <section ms-repeat='el.data'>
                        <p class="clearfix"><span class="type"> {% el.note %}</span><em class="total v4-status-red">{% el.balance_change %}</em></p>
                        <p class="clearfix"><span class="date"> {% el.created_at_note %}</span><em class="balance">可用余额 {% el.balance %}</em></p>
                    </section>
                </div>
            </div>

            <div class="v4-load-more"><i class="pull_icon"></i><span></span></div>
        </div>
    </article>

    <section class="v4-record-filter layer-entry">
        <div class="mask"></div>
        <div class="main">
            <a href="/user/record/all" class="<?php echo ($type == 'all') ? 'active' : ''; ?>">全部</a>
            <a href="/user/record/recharge" class="<?php echo ($type == 'recharge') ? 'active' : ''; ?>">充值</a>
            <a href="/user/record/withdraw" class="<?php echo ($type == 'withdraw') ? 'active' : ''; ?>">提现</a>
            <a href="/user/record/reward" class="<?php echo ($type == 'reward') ? 'active' : ''; ?>">活动奖励</a>
            <a href="/user/record/invest" class="<?php echo ($type == 'invest') ? 'active' : ''; ?>">定期投资</a>
            <a href="/user/record/refund" class="<?php echo ($type == 'refund') ? 'active' : ''; ?>">定期回款</a>
            <a href="/user/record/investCurrent" class="<?php echo ($type == 'investCurrent') ? 'active' : ''; ?>">买入</a>
            <a href="/user/record/outCurrent" class="<?php echo ($type == 'outCurrent') ? 'active' : ''; ?>">卖出</a>
        </div>
    </section>
    <!-- 侧边栏 -->
    @include('wap.home.nav')
@endsection

@section('jsScript')
    <script type="text/javascript" src="{{assetUrlByCdn('/static/weixin/js/lib/biz/user-fund-history.js')}}"></script>
    <script src="{{ assetUrlByCdn('static/weixin/js/pop.js')}}"></script>
@endsection

