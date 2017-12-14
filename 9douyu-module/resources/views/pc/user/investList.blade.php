@extends('pc.common.layoutNew')

@section('title', '出借记录')

@section('content')
    <div class="v4-account">
        <!-- account begins -->
        @include('pc.common.leftMenu')
        <div class="v4-content v4-account-white" ms-controller="investList">
            <div class="Js_tab_box">
                <ul class="v4-user-tab Js_tab clearfix">
                    <li ms-class="[@currentTab==1 && 'cur']"><a href="javascript:;" ms-click="changeMenuTab(1)">优选项目</a></li>
                    <li ms-class="[@currentTab==2 && 'cur']"><a href="javascript:;" ms-click="changeMenuTab(2)">智投计划</a></li>
                </ul>
                <div class="js_tab_content">
                    <div class="Js_tab_main" ms-visible="@currentTab==1">
                        <div class="v4-query-nav">
                             <dl>
                                 <dl>
                                     <dt>还款方式：</dt>
                                     <dd><a href="javascript:;" ms-class="[@firstTabRepayType=='all' && 'active']"   attr="all" ms-click="changeFirstTab('all',firstTabRepayStatus)">全部</a></dd>
                                     <dd><a href="javascript:;" ms-class="[@firstTabRepayType=='base' && 'active']"  attr="base" ms-click="changeFirstTab('base',firstTabRepayStatus)">到期还本息</a></dd>
                                     <dd><a href="javascript:;" ms-class="[@firstTabRepayType=='only' && 'active']"  attr="only" ms-click="changeFirstTab('only',firstTabRepayStatus)">先息后本</a></dd>
                                     <dd><a href="javascript:;" ms-class="[@firstTabRepayType=='equal' && 'active']" attr="equal" ms-click="changeFirstTab('equal',firstTabRepayStatus)">等额本息</a></dd>
                                     <dd><a href="javascript:;" ms-class="[@firstTabRepayType=='first' && 'active']" attr="first" ms-click="changeFirstTab('first',firstTabRepayStatus)">投资当日付息到期还本</a>
                                     </dd>
                                 </dl>
                            </dl>
                            <dl>
                                <dl>
                                    <dt>交易状态：</dt>
                                    <dd><a href="javascript:;" ms-class="[@firstTabRepayStatus=='all' && 'active']" attr="all" ms-click="changeFirstTab(firstTabRepayType,'all')">全部</a></dd>
                                    <dd><a href="javascript:;" ms-class="[@firstTabRepayStatus=='investing' && 'active']" attr="investing" ms-click="changeFirstTab(firstTabRepayType,'investing')">募集中</a></dd>
                                    <dd><a href="javascript:;" ms-class="[@firstTabRepayStatus=='refunding' && 'active']" attr="refunding" ms-click="changeFirstTab(firstTabRepayType,'refunding')">还款中</a></dd>
                                    <dd><a href="javascript:;" ms-class="[@firstTabRepayStatus=='finished'  && 'active']" attr="finished" ms-click="changeFirstTab(firstTabRepayType,'finished')">已完结</a></dd>
                                </dl>
                            </dl>
                        </div>

                        <div class="v4-table-wrap v4-mt-20">
                           <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left">
                               <thead>
                                   <tr>
                                       <td>项目名称</td>
                                       <td>期待年回报率</td>
                                       <td>出借金额</td>
                                       <td>还款方式</td>
                                       <td>交易日期</td>
                                       <td>到期日期</td>
                                       <td>交易状态</td>
                                       <td>查看合同</td>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr ms-for="(k, v) in @firstList">
                                       <td><a ms-attr="{href:'/user/invest/detail?record_id=' + v.id}" class="v4-btn-text v4-text-ellips">{% @v.name|truncate(10,'...') %}{% @v.format_name %}</a></td>
                                       <td>{% @v.base_rate %}%</td>
                                       <td>{% @v.cash|number(2) %}</td>
                                       <td>{% @v.refund_type_note %}</td>
                                       <td>{% @v.created_at|date("yyyy-MM-dd") %}</td>
                                       <td>{% @v.end_at|date("yyyy-MM-dd") %}</td>
                                       <td>{% @v.status_note %}</td>
                                       <td>--</td>
                                   </tr>
                               </tbody>
                           </table>
                        </div>
                        <div class="v4-table-pagination">
                            <a ms-if="@firstPager.current_page > 1" href="javascript:void(0)" ms-attr="{'data-url':@firstPager.prev_page_url}" class="turn" ms-click="getInvestData($event)">上一页</a>
                            <span ms-for="(k,v) in @firstPager.view">
                               <a ms-if="@firstPager.current_page==@v" href="javascript:void(0)" class="active">{% @firstPager.current_page %}</a>
                               <a ms-if="@firstPager.current_page!=@v" href="javascript:void(0)" ms-attr="{'data-url':@firstPager.page_url+@v}" ms-click="getInvestData($event)">{% @v %}</a>
                            </span>
                            <a ms-if="@firstPager.current_page<@firstPager.last_page" href="javascript:void(0)" ms-attr="{'data-url':@firstPager.next_page_url}" class="turn" ms-click="getInvestData($event)">下一页</a>
                        </div>


                        <form method="post" action="/contract/doCreateDownLoad" id="contractDown">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="invest_id" id="investId" value="">
                        </form>
                    </div>
                    <div class="Js_tab_main" ms-visible="@currentTab==2">
                        <div class="v4-query-nav">
                            <dl>
                                <dt>交易状态：</dt>
                                <dd><a href="javascript:;" ms-class="[@secondTabRepayStatus=='all' && 'active']" attr="all" ms-click="changeSecondTab('all')">全部</a></dd>
                                <dd><a href="javascript:;" ms-class="[@secondTabRepayStatus=='investing' && 'active']" attr="investing" ms-click="changeSecondTab('investing')">募集中</a></dd>
                                <dd><a href="javascript:;" ms-class="[@secondTabRepayStatus=='matching'  && 'active']" attr="matching"  ms-click="changeSecondTab('matching')">匹配中</a></dd>
                                <dd><a href="javascript:;" ms-class="[@secondTabRepayStatus=='locking'   && 'active']" attr="locking"   ms-click="changeSecondTab('locking')">锁定中</a></dd>
                                <dd><a href="javascript:;" ms-class="[@secondTabRepayStatus=='finished'  && 'active']" attr="finished"  ms-click="changeSecondTab('finished')">已完结</a></dd>
                            </dl>
                            </div>
                            <div class="v4-table-wrap v4-mt-20">
                               <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left">
                                   <thead>
                                       <tr>
                                           <td>项目名称</td>
                                           <td>锁定期限</td>
                                           <td>出借金额</td>
                                           <td>还款方式</td>
                                           <td>交易日期</td>
                                           <td>已赚收益(元)</td>
                                           <td>交易状态</td>
                                           <td>查看合同</td>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       <tr ms-for="(k, v) in @secondList">
                                           <td><a ms-attr="{href:'/user/invest/smartDetail?record_id=' + v.id}" class="v4-btn-text v4-text-ellips">{% @v.name|truncate(10,'...') %}{% @v.format_name %}</a></td>
                                           <td>{% @v.invest_time %}天</td>
                                           <td>{% @v.cash|number(2) %}</td>
                                           <td>{% @v.refund_type_note %}</td>
                                           <td>{% @v.created_at|date("yyyy-MM-dd") %}</td>
                                           <td>{% @v.interest_info|number(2) %}</td>
                                           <td>{% @v.status_note %}</td>
                                           <td>--</td>
                                       </tr>
                                   </tbody>
                               </table>
                            </div>
                            <div class="v4-table-pagination">
                                <a ms-if="@secondPager.current_page > 1" href="javascript:void(0)" ms-attr="{'data-url':@secondPager.prev_page_url}" class="turn" ms-click="getSmartInvestData($event)">上一页</a>
                                <span ms-for="(k,v) in @secondPager.view">
                                   <a ms-if="@secondPager.current_page==@v" href="javascript:void(0)" class="active">{% @secondPager.current_page %}</a>
                                   <a ms-if="@secondPager.current_page!=@v" href="javascript:void(0)" ms-attr="{'data-url':@secondPager.page_url+@v}" ms-click="getSmartInvestData($event)">{% @v %}</a>
                                </span>
                                <a ms-if="@secondPager.current_page<@secondPager.last_page" href="javascript:void(0)" ms-attr="{'data-url':@secondPager.next_page_url}" class="turn" ms-click="getSmartInvestData($event)">下一页</a>
                            </div>
                    </div>
                </div>
          </div>
      </div>
    </div>
<!-- account ends -->
<div class="clear"></div>
<script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/user/invest-list.js')}}"></script>
@endsection
