<!DOCTYPE html>
<html>
    <head>
        <title>九斗鱼 - @yield('title')</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="{{ env('META_KEYWORD') }}" />
        <meta name="description" content="{{ env('META_DESCRIPTION') }}" />
        <meta name="renderer" content="webkit" />
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" />
        <link href="{{ assetUrlByCdn('/static/images/favicon.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link rel="stylesheet" href="{{ assetUrlByCdn('/static/css/pc4.css') }}" type="text/css" />
        {{--<link rel="stylesheet" href="{{ assetUrlByCdn('/static/theme/spring/css/theme.css') }}" />--}}
        @if( \App\Http\Logics\SystemConfig\SystemConfigLogic::getConfig('SKIN_CSS') )
            <link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/theme/'.\App\Http\Logics\SystemConfig\SystemConfigLogic::getConfig('SKIN_CSS').'/css/theme.css') }}">
        @endif
        @yield('csspage')


    </head>
<body>

<!-- 注册流程优化弹层 -->
<script type="text/javascript" src="{{assetUrlByCdn('static/js/jquery-1.9.1.min.js')}}"></script>


    @section('header')
        @include('pc.common/header')
    @show

    @yield('content')

    @section('footer')
        @include('pc.home/about')
        @include('pc.common/footer')
    @show

    @include('pc.common/qqService')

    @yield('jspage')

</body>


</html>
