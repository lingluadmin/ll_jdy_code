@extends('wap.common.wapBaseNew')

@section('title', '首页')
@section('keywords', "{{env('META_KEYWORD')}}")

@section('description', "{{env('META_DESCRIPTION')}}")
@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/index.css')}}">
@endsection
@section('content')
        <!--top-->
        @include('wap.home.top')
        @if(!empty($view_user))
        <!--已登录 banner-->
        @include('wap.home.adBanner')
        @else
        <!--未登录 注册引导 register guide-->
        @include('wap.home.guide')
        @endif
        <!-- about nav-->
        @include('wap.home.about9douyu')
        <!-- 新手 -->
        @include('wap.home.novice')
        <!-- 项目 -->
        @include('wap.home.project')
        <!-- 头条 -->
        @include('wap.home.news')
        <!-- 侧边栏 -->
        @include('wap.home.nav')
        <!-- downloadapp -->
        @include('wap.home.downloadapp')
@endsection



@section('jsScript')

<script type="text/javascript" src="{{assetUrlByCdn('static/weixin/js/swiper3.1.0.jquery.min.js') }}"></script>
<script>
$(function(){
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay: 2000,
        loop: true
    });
})      
</script>
@endsection
