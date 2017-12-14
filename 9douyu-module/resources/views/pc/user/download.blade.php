@extends('pc.common.base')

@section('title', '出借记录')

@section('content')

    <div class="v4-account">
        <!-- account begins -->
        @include('pc.common.leftMenu')

        <div class="v4-content v4-account-white">
            <!-- <h2 class="v4-account-titlex">出借记录</h2> -->
            <div class="Js_tab_box">
                <!--tab-->
                <ul class="v4-user-tab Js_tab clearfix">
                    <li class="cur"><a href="javascript:;">优选项目</a></li>
                    <li><a href="javascript:;">智投计划</a></li>
                </ul>
                <div class="js_tab_content">
                    <div class="Js_tab_main">
                        
                        <div class="v4-query-nav">
                             <dl>
                                <dt>还款方式：</dt>
                                <dd><a href="{{$searchParam['baseUrl']['refund']}}" @if(!isset($params['refund_type']) || $params['refund_type'] =='all') class="active" @endif>全部</a></dd>
                                 @foreach( $searchParam['refundList'] as $refund )
                                     <dd><a href="{{$refund['url']}}" attr="{{$refund['type']}}" @if(isset($params['refund_type']) && $params['refund_type']==$refund['type']) class="active" @endif>{{$refund['name']}}</a></dd>
                                 @endforeach
                            </dl>
                            <dl>
                                <dt>交易状态：</dt>
                                <dd><a href="{{$searchParam['baseUrl']['status']}}" @if(!isset($params['status']) || $params['status'] =='all') class="active" @endif>全部</a></dd>
                                @foreach( $searchParam['statusList'] as $status )
                                    <dd><a href="{{$status['url']}}" attr="{{$status['type']}}" @if(isset($params['status']) && $params['status'] ==$status['type'])class="active" @endif>{{$status['name']}}</a></dd>
                                @endforeach
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
                           @if( !empty($list) )
                                @foreach( $list as $item)
                                    <tr>
                                        <td><a href="/user/invest/detail?record_id={{$item['id']}}" class="v4-btn-text v4-text-ellips">{{mb_substr($item['name'],0,6)}} {{$item['format_name']}}</a></td>
                                        <td>{{$item['base_rate']}}%@if($item['after_rate']>0)+{{$item['after_rate']}}%@endif</td>
                                        <td>{{number_format ($item['cash'])}}</td>
                                        <td>{{$item['refund_type_note']}}</td>
                                        <td>{{date('Y-m-d',strtotime ($item['created_at']))}}</td>
                                        <td>{{$item['end_at']}}</td>
                                        <td>{{$item['status_note']}}</td>
                                    @if($item['status'] !=\App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING )
                                    @if(isset($contract[$item['id']]))
                                        <td><a href="javascript:;" data-value="{{ $item['id'] }}" class="v4-btn-text link-active " contract_status='success' id="create_contract{{ $item['id'] }}">下载</a></td>
                                    @else
                                        <td><a href="javascript:;" data-value="{{ $item['id'] }}" class="v4-btn-text link-active" contract_status='doing'   id="create_contract{{ $item['id'] }}">生成</a></td>
                                    @endif
                                    @else
                                     <td> </td>
                                    @endif
                                    </tr>
                                @endforeach
                               @else
                               <tr><td colspan="8" class="v4-table-none">暂无记录</td></tr>
                           @endif
                               </tbody>
                           </table>
                        </div>
                        <div class="v4-table-pagination">
                            @if( !empty($list) )
                                @include('scripts/paginate', ['paginate'=>$paginate])
                            @endif
                        </div>
                        <form method="post" action="/contract/doCreateDownLoad" id="contractDown">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="invest_id" id="investId" value="">
                        </form>
                    </div>
                    <div class="Js_tab_main">
                        <div class="v4-query-nav">
                                <dl>
                                    <dt>交易状态：</dt>
                                    <dd><a href="javascript:;" class="active">全部</a></dd>
                                    <dd><a href="javascript:;">募集中</a></dd>
                                    <dd><a href="javascript:;">匹配中</a></dd>
                                    <dd><a href="javascript:;">锁定中</a></dd>
                                    <dd><a href="javascript:;">赎回中</a></dd>
                                    <dd><a href="javascript:;">已完结</a></dd>
                                    
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
                               @if( !empty($list) )
                                    @foreach( $list as $item)
                                        <tr>
                                            <td><a href="/user/invest/detail?record_id={{$item['id']}}" class="v4-btn-text v4-text-ellips">{{mb_substr($item['name'],0,6)}} {{$item['format_name']}}</a></td>
                                            <td>{{$item['base_rate']}}%@if($item['after_rate']>0)+{{$item['after_rate']}}%@endif</td>
                                            <td>{{number_format ($item['cash'])}}</td>
                                            <td>{{$item['refund_type_note']}}</td>
                                            <td>{{date('Y-m-d',strtotime ($item['created_at']))}}</td>
                                            <td>0.00</td>
                                            <td>{{$item['status_note']}}</td>
                                        @if($item['status'] !=\App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING )
                                        @if(isset($contract[$item['id']]))
                                            <td><a href="javascript:;" data-value="{{ $item['id'] }}" class="v4-btn-text link-active " contract_status='success' id="create_contract{{ $item['id'] }}">下载</a></td>
                                        @else
                                            <td><a href="javascript:;" data-value="{{ $item['id'] }}" class="v4-btn-text link-active" contract_status='doing'   id="create_contract{{ $item['id'] }}">生成</a></td>
                                        @endif
                                        @else
                                         <td> </td>
                                        @endif
                                        </tr>
                                    @endforeach
                                   @else
                                   <tr><td colspan="8" class="v4-table-none">暂无记录</td></tr>
                               @endif
                                   </tbody>
                               </table>
                            </div>
                            <div class="v4-table-pagination">
                                @if( !empty($list) )
                                    @include('scripts/paginate', ['paginate'=>$paginate])
                                @endif
                            </div>
                    </div>
                </div><!--tabouterbox-->
          </div>
          
      </div>
    </div>
<!-- account ends -->
<div class="clear"></div>
@endsection
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/tabs.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        (function($){
            $(".Js_tab_box").tabs();
            $(document).delegate(".link-active",'click',function(){
                var lock    =   $(this).attr('contract_status')
                if( lock =='lock') return false
                if( lock =='fail') {

                    alert('合同下载失败，请联系客服！')
                    return false;
                }
                var investId = $(this).attr('data-value');
                if( lock =='success'){
                    $('#investId').val(investId);
                    $('#contractDown').submit();
                    return false;
                }

                var _token   =   $("input[name='_token']").val();
                $(this).attr('contract_status','lock')
                $.ajax({
                    url      :"/contract/doCreateDownLoad",
                    data     :{invest_id:investId,_token:_token,dataType:'json'},
                    dataType :'json',
                    type     :'post',
                    success : function(json) {

                        if( json.status == true ){
                            $("#create_contract" + investId).html('生成中').removeClass('create_contract');
                            checkContract(investId);
                            alert('您的合同正在生成中，请耐心等待');
                        }else {
                            alert(json.msg)
                        }
                    }, error : function() {
                        alert('网络异常，清稍后再试')
                    }
                });
            })
            var checkContract   =   function (investId) {

                status      =   $("#create_contract" + investId).attr('contract_status');

                if( status == 'success' ) return false;

                var obj     =   $("#create_contract" + investId);

                var time2   =   20;

                var time_s  =   setInterval(function () {
                    time2--;
                    var _token      =   $("input[name='_token']").val();
                    $.ajax({
                        url      :"/contract/checkContractStatus",
                        data     :{invest_id:investId,_token:_token},
                        dataType :'json',
                        type     :'post',
                        success : function(json) {
                            if( json.status == true){
                                clearInterval(time_s);
                                obj.html('下载')
                                obj.attr('contract_status','success');
                            }
                        }
                    });
                    if( time2 <0 ){
                        obj.html('生成失败');
                        obj.attr('contract_status','fail');
                        clearInterval(time_s);
                    }
                },3000);
            }
        })(jQuery);
    </script>
@endsection
