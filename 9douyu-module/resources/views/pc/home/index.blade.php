@extends('pc.common.layoutNew')
@section('title', '耀盛中国旗下金融科技平台 提供一站式金融服务【安全|智能|稳健|高效】')
@section('content')

    <!-- banner -->
    @include('pc.home.banner')

    <!-- 平台优势 -->
    @include('pc.home.chooseJdy')

    <div class="index-activity-theme ms-controller" ms-controller="homeIndex">
        <div class="v4-wrap">
            <!-- current -->
            @include('pc.home.novice')
            <!-- 智投计划 -->
            @include('pc.home.projectSmart')
            <!-- 短期项目 -->
            @include('pc.home.projectShort')
            <!-- 中长期项目 -->
            @include('pc.home.projectMiddle')
            <!-- 长期项目 -->
            @include('pc.home.projectLong')

            <!-- credit 债权转让 -->
            @include('pc.home.assignProject')
        </div>
        <!-- 媒体报道 -->
        @include('pc.home.mediaReport')
        <!-- 合作伙伴 -->
        @include('pc.home.cooper')
    </div>
   

    <div class="index-activity-layer">
        <!-- index 活动弹窗 -->
        @include('pc.home.pop')
    </div>

    <script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/home-index.js')}}"></script>
    <script type="text/javascript" src="{{ assetUrlByCdn('assets/js/pc4/nummove.js')}}"></script>

    <script src="{{ assetUrlByCdn('assets/js/pc4/jquery.slides.js') }} "></script>

@endsection