
@extends('pc.common.layout')
@section('title','系统升级维护中...')
@section('csspage')
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no"/>
<link rel="stylesheet" href="{{ assetUrlByCdn('/static/css/pc4/upgrade.css') }}" type="text/css" />
@endsection
@section('content')
<div class="v4-upgrade">
    <h2>系统升级维护中...</h2>
    <p>给您带来不便，请谅解！</p>
</div>
@endsection

@section('footer')
@endsection
