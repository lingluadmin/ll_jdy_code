@extends('pc.common.layout')
@section('title',$info['title'])
@section('content')
    <div class="v4-wrap v4-custody-wrap">
        <div class="v4-account-titlex article"><a href="/">九斗鱼</a> > <a href="{{ $url }}">{{ $info['category']['name'] }}</a> > <span>文章内容</span>
            <div class="v4-project-list-tip">
                @include('pc.common.index.sharemore')
            </div>
        </div>
        <div class="v4-article-title">
            <h1>{{ $info['title'] }}</h1>
            <div class="v4-article-time">发布时间：<span>{{ $info['publish_time'] }}</span></div>
        </div>
        <div class="v4-article-main">
            

            <!-- 正文开始 -->
            {!! htmlspecialchars_decode($info['content']) !!}
            <!-- 正文结束 -->
        </div>


        <div class="clear"></div>
    </div>
@endsection

