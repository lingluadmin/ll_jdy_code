<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <link href="{{ assetUrlByCdn('/static/images/favicon.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('static/weixin/css/wap4/reset.css')}}">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('static/weixin/css/wap4/sidenav.css')}}">
    <script type="text/javascript" src="{{ assetUrlByCdn('static/weixin/js/wap4/cssrem.js') }}"></script>
    <script src="{{ assetUrlByCdn('/static/weixin/js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{ assetUrlByCdn('/static/weixin/js/wap4/sidenav.js') }}"></script>
    <script src="{{ assetUrlByCdn('/static/weixin/js/lib/avalon.mobile.js') }}"></script>
    @yield('css')
    <style type="text/css">
        .ms-controller{  visibility: hidden  }
    </style>
</head>
<body>
    @include('wap.common.familyFrame')

    @yield('content')

    @yield('footer')

    @yield('jsScript')
</body>
</html>
