@extends('wap.common.wapBaseLayoutNew')
@section('title','出借记录')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/refundPlan.css')}}">
@section('content')
<block name="content">
<article>
    <nav class="v4-nav-top"><a href="javascript:;" onclick="window.history.go(-1);"></a>出借记录</nav>
        <div class="v4-lend">
            <table ms-controller="investRecord" ms-on-swipeup="swipeUp()" ms-on-swipedown="swipeDown()">

                <tr ms-repeat="list">
                    <td>
                        <h4>{% el.phone %}</h4>
                        <p>{% el.created_at %}</p>
                    </td>
                    <td>
                        {% el.cash|number(2) %}
                    </td>
                </tr>
            </table>
        </div>
      <div class="v4-load-more1"><i class="pull_icon"></i><span>加载中...</span></div>
      <input type="hidden" id="projectId"  value="{{$projectId}}" />
 </article>
    <script src="{{ assetUrlByCdn('/static/weixin/js/lib/biz/project-record.js') }}"></script>
</block>
@endsection

@section('jsScript')

@endsection


