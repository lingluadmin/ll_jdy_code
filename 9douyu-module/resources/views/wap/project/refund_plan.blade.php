@extends('wap.common.wapBaseNew')
@section('title','回款计划')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/refundPlan.css')}}">
@section('content')
<block name="content">
<article>
  <nav class="v4-nav-top"><a href="javascript:;" onclick="window.history.go(-1);"></a>回款计划</nav>
  <div class="v4-refund">
    <h4 class="v4-refund-1">
        <table>   
            <tr>
                <td>预期回款日</td>
                <td>回款类型</td>
                <td>回款金额</td>
            </tr>
        </table>
    </h4>
    <div class="v4-refund-2">
        <table>
            @foreach($plan as $item)
            <tr>
                <td>{{$item['refund_time']}}</td>
                <td>{{$item['refund_note']}}</td>
                <td>{{number_format($item['refund_cash'],2,'.',',')}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
<!-- loading more -->
<!-- <div class="v4-load-more1"><i class="pull_icon"></i><span>加载中...</span></div>  
 -->      
</article>

</block>
@endsection

@section('jsScript')

@endsection

