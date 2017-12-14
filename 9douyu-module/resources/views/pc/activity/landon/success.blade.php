@extends('pc.common.layout')

@section('title', '注册送888元红包')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/landon/css/index.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body{background: #eaeaea;}
    </style>
@endsection
@section('content')
<!-- head -->
@section('header')
    <div class="landon-header">
        <div class="landon-reg">
            <h1 class="landon-header-logo">
                <a href="/"></a>
                <div class="landon-header-subhead">
                    耀盛中国
                    <p>旗下互联网金融平台</p>
                </div>
           </h1>
           <div class="landon-user-info">
            <span class="customer">客服电话：400-6686-568</span>
           </div>
        </div>
    </div>
@endsection
<div class="landon-success">
    <h1>注册成功，<span>888</span>元红包已到账<br>即刻投资赚收益吧！</h1>
    <p>扫码下载手机App，体验新手专享项目</p>
    <a href="/project/index" class="register-input-btn">立即投资</a>
</div>

@endsection

@section('jspage')


@endsection