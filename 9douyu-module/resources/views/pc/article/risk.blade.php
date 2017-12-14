@extends('pc.common.layoutNew')
@section('title',$current['title'])
@section('content')
    <div class="v4-account">
        @include('pc.article.risknav')
        {{--<div class="v4-content v4-account-white">
            <h2 class="v4-account-titlex v4-help-title">{{ $current['title'] }}</h2>
            {!! $current['content'] !!}
        </div>--}}
        {!! $current['content'] !!}

    </div><!--v4-account -->
    <div class="clear"></div>
@endsection
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/toggleContent.js')}}"></script>
<script type="text/javascript">
  $(function(){
    $('h3.v4-help-head').toggleContent('div.v4-help-body');
  })
</script>
@endsection