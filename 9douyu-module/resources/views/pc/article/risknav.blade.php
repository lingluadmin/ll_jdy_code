

<div class="v4-leftNav" data-nav="risk">
    <ul>
        @foreach ( $helpList as $key => $help )
            @if ( $help['id'] == $current['id'] )
                <li class="active"><a href="{{ App\Tools\ToolUrl::getUrl("/risk/".$help['id']) }}"><i class="v4-iconfont v4-left-nav-icon">{!! $iconList[$key] !!}</i>{{ $help["title"] }}</a></li>
            @else
                <li><a href="{{ App\Tools\ToolUrl::getUrl("/risk/".$help['id']) }}"><i class="v4-iconfont v4-left-nav-icon">{!! $iconList[$key] !!}</i>{{ $help["title"] }}</a></li>
            @endif
        @endforeach
    </ul>
</div>