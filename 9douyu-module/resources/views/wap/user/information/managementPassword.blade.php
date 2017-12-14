@extends('wap.common.wapBaseNew')

@section('title', '密码管理')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('static/weixin/css/wap4/information.css') }}">
@endsection
@section('content')
<article>
    <nav class="v4-nav-top"><a href="javascript:;" onclick="window.history.go(-1);"></a>密码管理</nav>
    <a href="/user/modifyLoginPassword" class="v4-management">修改登录密码</a>
    @if ($isSetTradingPassword)
       <a href="/user/modifyTradingPassword" class="v4-management">修改交易密码</a>
    @else
       <a href="/user/setTradingPassword" class="v4-management">设置交易密码</a>
    @endif
</article>
@endsection

@section('jsScript')
@endsection
