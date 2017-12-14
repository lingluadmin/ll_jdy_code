<div class="v4-leftNav">
    <ul>
        {{--<li class="@if(Request::path() == 'about')active checked @endif"><a href="{{ URL('/about') }}"><i class="v4-iconfont v4-left-nav-icon">&#xe691;</i>公司介绍</a></li>--}}
        {{--<li class="@if(Request::path() == 'about/development')active checked @endif"><a href="{{ URL('/about/development') }}" ><i class="v4-iconfont v4-left-nav-icon">&#xe699;</i>发展历程</a></li>--}}
        {{--<li class="@if(Request::path() == 'about/team') active checked @endif"><a href="{{ URL('/about/team') }}"   ><i class="v4-iconfont v4-left-nav-icon">&#xe6bb;</i>管理团队</a></li>--}}
        {{--<li class="@if(Request::path() == 'about/partner' )active checked @endif"><a href="{{ URL('/about/partner') }}"   ><i class="v4-iconfont v4-left-nav-icon">&#xe694;</i>合作伙伴</a></li>--}}
        <li class="@if(Request::path() == 'about/media' )active checked @endif"><a href="{{ URL('/about/media') }}"   ><i class="v4-iconfont v4-left-nav-icon">&#xe695;</i>媒体报道</a></li>
        <li class="@if(Request::path() == 'about/notice' )active checked @endif"><a href="{{ URL('/about/notice') }}"   ><i class="v4-iconfont v4-left-nav-icon">&#xe697;</i>平台公告</a></li>
        <li class="@if(Request::path() == 'about/contactus' )active checked @endif"><a href="{{ URL('/about/contactus') }}"   ><i class="v4-iconfont v4-left-nav-icon v4-icon-1">&#xe692;</i>联系我们</a></li>
    </ul>
</div>
