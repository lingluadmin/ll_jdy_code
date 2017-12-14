@extends('wap.common.wapBaseNew')

@section('title','交易记录')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/record.css')}}">

@endsection

@section('content')

    <article>
        <div class="v4-user-page-head">
            <nav class="v4-top flex-box box-align box-pack v4-page-head">
                <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
                <h5 class="v4-page-title">交易记录</h5>
                <div class="v4-user">
                    <a href="javascript:;" data-filter="entry">筛选</a>
                </div>
            </nav>

        </div>
        <div id="wrapper">
            <div class="scroller">

                <?php
                $type = isset($data['type']) ? $data['type'] : 'all';
                ?>

                @if( !empty($list) )
                    <?php
                    $monthData = [];
                    ?>
                    @foreach( $list as $fund )
                        <?php
                        $month = date('Y年m月', strtotime($fund['created_at']));

                        if (!isset($monthData[$month])) {
                            $monthData[$month] = true;
                            echo '<p class="v4-record-date">' . $month . '</p>';
                        }
                        ?>
                        <div class="v4-record-list">
                            <section>
                                <p class="clearfix"><span
                                            class="type">{{ empty($fund['note']) ? $fund['event_id_label'] : $fund['note'] }}</span><em
                                            class="total v4-status-red"> {{ number_format($fund['balance_change'] ,2,'.',',') }} </em>
                                </p>
                                <p class="clearfix"><span
                                            class="date">{{ date('Y年m月d日 H:i', strtotime($fund['created_at'])) }}</span><em
                                            class="balance">可用余额 {{ number_format($fund['balance'] ,2,'.',',') }}</em>
                                </p>
                            </section>
                        </div>
                    @endforeach
                    <div class="v4-load-more"><i class="pull_icon"></i><span>上拉加载...</span></div>
                @else
                    <p class="v4-record-date" style="text-align: center;">暂无记录</p>
                @endif


            </div>
        </div>

    </article>

    <section class="v4-record-filter" data-filter="layer">
        <div class="mask" data-toggle="mask" data-target="v4-record-filter"></div>
        <div class="main" data-filter="btn">
            <a href="/user/record/all" class="<?php echo ($type == 'all') ? 'active' : ''; ?>">全部</a>
            <a href="/user/record/recharge" class="<?php echo ($type == 'recharge') ? 'active' : ''; ?>">充值</a>
            <a href="/user/record/withdraw" class="<?php echo ($type == 'withdraw') ? 'active' : ''; ?>">提现</a>
            <a href="/user/record/reward" class="<?php echo ($type == 'reward') ? 'active' : ''; ?>">活动奖励</a>
            <a href="/user/record/invest" class="<?php echo ($type == 'invest') ? 'active' : ''; ?>">定期投资</a>
            <a href="/user/record/refund" class="<?php echo ($type == 'refund') ? 'active' : ''; ?>">定期回款</a>
            <a href="/user/record/investCurrent"
               class="<?php echo ($type == 'investCurrent') ? 'active' : ''; ?>">买入</a>
            <a href="/user/record/outCurrent" class="<?php echo ($type == 'outCurrent') ? 'active' : ''; ?>">卖出</a>
        </div>
    </section>


@endsection

@section('jsScript')

    <script src="{{ assetUrlByCdn('static/weixin/js/pop.js')}}"></script>
    <script src="{{ assetUrlByCdn('static/weixin/js/wap4/iscroll.js')}}"></script>
    <script>

        // show
        $("[data-filter='entry']").on("click touched", function (event) {
            $('[data-filter="layer"]').show();
        });

        //select
        $("[data-filter='btn']>a").on("click touched", function (event) {
            event.stopPropagation()
            var $this = $(this);
            $this.addClass("active").siblings().removeClass("active");
        });

        // pulldown
        var myscroll = new iScroll("wrapper", {
            onScrollMove: function () {
                if (this.y < (this.maxScrollY)) {
                    $('.pull_icon').addClass('flip');
                    $('.pull_icon').removeClass('loading');
                    $('.v4-load-more span').text('释放加载...');
                } else {
                    $('.pull_icon').removeClass('flip loading');
                    $('.v4-load-more span').text('上拉加载...')
                }
            },
            onScrollEnd: function () {
                if ($('.pull_icon').hasClass('flip')) {
                    $('.pull_icon').addClass('loading');
                    $('.v4-load-more span').text('加载中...');
                    pullUpAction();
                }


            },
            onRefresh: function () {
                $('.v4-load-more').removeClass('flip');
                $('.v4-load-more span').text('上拉加载...');
            }
        });

        function pullUpAction() {
            setTimeout(function () {
                $.ajax({
                    url: '',
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        for (var i = 0; i < 5; i++) {
                            $('.scroller ul').append(data);
                        }
                        myscroll.refresh();
                    },
                    error: function () {
                        console.log('error');
                    },
                });

                var template = '<p class="v4-record-date">2017年03月</p>' +
                    '<div class="v4-record-list">' +
                    '<section>' +
                    '<p class="clearfix"><span class="type">充值</span><em class="total v4-status-red">+10000.00元</em></p>' +
                    '<p class="clearfix"><span class="date">2017年09月01日 12:01</span><em class="balance">可用余额 100.00</em></p>' +
                    '</section>' +
                    '</div> ';
                for (var i = 0; i < 5; i++) {
                    $('.v4-load-more').before(template);
                }
                myscroll.refresh();
            }, 1000)
        }
        if ($('.scroller').height() < $('#wrapper').height()) {
            $('.v4-load-more').hide();
            myscroll.destroy();
        }

    </script>


@endsection