@extends('pc.common.layoutNew')

@section('title', '我要出借')

@section('content')
    <div class="wrap" ms-controller="projectList">
        <div class="web-project-tab">
            <ul class="clearfix">
                <li @if( $type == 'Preferred' ) class="on" @endif style="height:54px;"><a href="/project/index">{%@title.invest%}</a><i></i></li>
                <li style="height:54px;"><a href="/project/current/detail">{%@title.debt%}</a><i></i></li>
            </ul>
        </div>
        <div class="web-project-main">
            <!--九省心-->
            <ul class="web-project-listitem">
                <li ms-for="(k, v) in @list">
                    <div class="web-listitem-title">
                            <span ms-if="@v.product_line==100"><strong>{% @v.name %} · </strong>{% @v.id %} </span>
                            <span ms-if="@v.product_line!=100"><strong>{% @v.product_line_note %} · </strong>{% @v.id %} </span>
                    </div>
                    <div class="web-listitem-box web-listitem-rate">
                        <p>
                            <strong>{% @v.profit_percentage %}</strong>%
                        </p>
                        <span>期待年回报率</span>
                    </div>
                    <div class="web-listitem-box web-listitem-date">
                        <p>{% @v.format_invest_time %} {% @v.invest_time_unit %}</p>
                        <span>期限</span>
                    </div>
                    <div class="web-listitem-box web-listitem-sum">
                        <p>
                            <ins>{% @v.refund_type_note %}</ins>
                        </p>
                        <span>还款方式</span>
                    </div>
                    <div class="web-listitem-box web-listitem-profit">
                        <p><em>{% @v.left_amount %}</em>元</p>
                        <span>剩余可投</span>
                    </div>
                    <div class="web-listitem-box web-listitem-btn">
                        <a class="btn btn-red disabled" ms-if="@v.status==160">已还款</a>
                        <a class="btn btn-red disabled" ms-if="@v.status==150">还款中</a>
                        <a ms-if="@v.status==130" class="btn btn-red" ms-attr="{href:'/project/detail/' + v.id}" >立即出借</a>
                    </div>
                    <div class="clear"></div>
                </li>
            </ul>


        </div>
        <div class="web-project-sidebar">
            
                <div class="web-sidebar-box">
                    <div class="web-listitem-summary web-listitem-jsx">
                        <h3>优选项目</h3>
                        <p>一款拥有固定还款期限的产品，借款期限1~12个月，借款利率9~12%，出借人可根据自己的实际情况分散投资。</p>
                    </div>
                    

                </div>
                <a ms-for="(k, v) in @ad"  target="_blank" ms-attr="{href:@v.param.url}">
                    <img alt="九斗鱼闪电付息项目" ms-attr="{src: @v.param.file}" class="ad-img-right">
                </a>
                <div class="web-sidebar-title">
                    <p>出借风云榜</p>
                </div>
                <div class="web-sidebar-box">
                    <dl class="web-ranking">
                        <dt>
                            <div class="num">排名</div>
                            <div class="name">手机号</div>
                            <div class="sum">出借金额</div>
                        </dt>
                        <dd ms-for="(k, v) in @winList" class="web-ranking-bg">
                            <div class="num" ms-if="@k==0"><img ms-attr="{src:@config.staticHost + 'static/images/new/web-ranking-1.png'}"></div>
                            <div class="num" ms-if="@k==1"><img ms-attr="{src:@config.staticHost + 'static/images/new/web-ranking-2.png'}"></div>
                            <div class="num" ms-if="@k==2"><img ms-attr="{src:@config.staticHost + 'static/images/new/web-ranking-3.png'}"></div>
                            <div class="num" ms-if="@k>2"><span>{% @k+1 %}</span></div>
                            <div class="name">{% @v.phone %}</div>
                            <div class="sum">{% @v.cash %}元</div>
                        </dd>

                    </dl>

                </div>

        </div>
    </div>
    <div class="clear"></div>
    <input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
    <script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/project-index.js')}}"></script>
@endsection


