@extends('wap.common.wapBaseNew')

@section('title', '修改登录密码成功')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('static/weixin/css/wap4/oldstyle.css') }}">
@endsection
@section('content')
    <article>
        <section class="wap2-dd-box clearfix">
            <div class="wap2-dd-info">
                <p class="wap2-success-txt">
                    修改成功</p>
                <p>
                    您的登录密码已修改成功!
                </p>
                <i class="wap2-arrow-2"></i>
            </div>
            <div class="wap-dd-block">
                <img src="{{assetUrlByCdn('/static/weixin/images/wap2/wap2-dd.png')}}" class="img">
            </div>
        </section>

        <section class="wap2-btn-wrap">
            <input type="hidden" name="returnUrl" value="{{ $returnUrl or null }}">
            <a class="wap2-btn wap2-btn-blue2" href="/user">确定</a>
        </section>
    </article>
@endsection
