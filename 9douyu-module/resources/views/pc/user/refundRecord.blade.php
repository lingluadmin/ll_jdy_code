@extends('pc.common.base')

@section('title', '回款日历')

@section('content')

<div class="v4-account">
    <!-- account begins -->
    @include('pc.common/leftMenu')

    <div class="v4-content">
        <div class="v4-account-white">
            <h2 class="v4-account-titlex">回款日历</h2>

            <form action="{{url('/user/refundPlan')}}" method="post"  id="calendar-form">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="month" value="{{ $month }}">
              <div class="v4-calendar-caption clearfix">
                  {{--<span class="date">{{$dateStr}}</span>
                  <div class="select-wrap">
                      <select name="year" id="">
                      @for($y=date('Y')+1;$y>=2014;$y--)
                          <option value="{{$y}}" @if($y==$year) selected @endif>{{$y}}</option>
                      @endfor
                      </select>
                      <select name="month" id="">
                      @for($m=12;$m>=1;$m--)
                          <option value="{{ sprintf('%02d', $m)}}" @if($m==$month) selected @endif>{{ sprintf('%02d', $m) }}月</option>
                      @endfor
                      </select>
                      <input type='submit' class="v4-btn-text" value='查询'/>
                  </div>--}}
                    <div class="v4-calendar-time">
                      <span class="v4-calendar-time-left" data-year="{{$prev_year}}" data-month="{{$prev_month}}"></span><em>{{$dateStr}}</em><span class="v4-calendar-time-right" data-year="{{$next_year}}" data-month="{{$next_month}}"></span>
                      <a href="javascript:;" class="v4-calendar-btn" data-year="{{date('Y')}}" data-month="{{date('m')}}">返回今天</a>
                    </div>
              </div>
            </form>

@include('pc.common.calendar')
           <ul class="v4-calendar-footer clearfix">
               <li>
                   <span class="active-incomplete">•</span>{{$refund_amount_data['refunded_cash_note']}}<em>{{$refund_amount_data['refunded_cash']}} {{$refund_amount_data['refund_amount_unit']}}</em>
               </li>
                <li>
                   <span class="active-uncomplete">•</span>{{$refund_amount_data['refund_cash_note']}}<em>{{$refund_amount_data['refund_cash']}} {{$refund_amount_data['refund_amount_unit']}}</em>
               </li>
           </ul>
       </div>

       <div class="v4-account-white v4-mt-15">
           <div class="v4-table-wrap">
               <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-48">
                   <thead>
                       <tr>
                           <td>回款日期</td>
                           <td>项目名称</td>
                           <td>回款状态</td>
                           <td>回款金额</td>
                           <td>回款期数</td>
                           <td>交易状态</td>
                       </tr>
                   </thead>
                   <tbody>
                    @if(!empty($month_refund_list))
                    @foreach($month_refund_list as $key=>$value)
                       <tr>
                           <td>{{$value['times']}}</td>
                           <td><span class="v4-text-ellips">{{ \App\Tools\ToolStr::hideStr( $value['project_name'], 15, '...') }} {{ $value['format_name']}} </span></td>
                           <td>{{ $value['type'] == 1 ? '加息奖励' : ($value['principal'] == 0 ? '利息' : '本金+利息') }}</td>
                           <td>{{ \App\Tools\ToolMoney::moneyFormat($value['cash'])}}</td>
                           <td>第{{$value['current_periods']}}/{{$value['periods']}}期</td>
                           <td>@if($value['status'] == 200) 已回款 @else 未回款 @endif</td>
                       </tr>
                    @endforeach
                    @else
                    <tr><td colspan="6" class="v4-table-none">暂无数据</td></tr>
                    @endif
                   </tbody>
               </table>
            </div>
        @include('pc.common.paginate')
       </div>

</div>
    <div class="clearfix"></div>
</div>
@endsection

@section('jspage')
<script>
        (function($){
            $(document).ready(function(){

               $("#datetimepicker3").on("click",function(e){
                    e.stopPropagation();
                    $(this).lqdatetimepicker({
                        css : 'datetime-day',
                        dateType : 'D',
                        selectback : function(){

                        }
                    });

                });
            $('.v4-calendar-time-left, .v4-calendar-time-right, .v4-calendar-btn').on("click",function(e){
                    var year = $(this).attr('data-year');
                    var month = $(this).attr('data-month');
                    $("input[name=year]").val(year);
                    $("input[name=month]").val(month);
                    $("#calendar-form").submit();
            });

            });
        })(jQuery);
    </script>
@endsection
