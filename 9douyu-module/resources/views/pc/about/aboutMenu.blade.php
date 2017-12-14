<div class="v4-aboutMenu">
    <div class="v4-wrap">
    	<ul>
    	    <li class="@if(Request::path() == 'about')active @endif"><a href="{{ URL('/about') }}">公司介绍</a></li>
            <li class="@if(Request::path() == 'about/team') active @endif"><a href="{{ URL('/about/team') }}" >管理团队</a></li>
    	    <li class="@if(Request::path() == 'about/development')active @endif"><a href="{{ URL('/about/development') }}" ></i>发展历程</a></li>
    	    <li class="@if(Request::path() == 'about/honor') active @endif"><a href="{{ URL('/about/honor') }}" >企业荣誉</a></li>
    	    <li class="@if(Request::path() == 'about/partner' )active @endif"><a href="{{ URL('/about/partner') }}" >合作伙伴</a></li>
    	    <li class="@if(Request::path() == 'about/media' )active @endif"><a href="{{ URL('/about/media') }}" >媒体报道</a></li>
    	    <li class="@if(Request::path() == 'about/notice' )active @endif"><a href="{{ URL('/about/notice') }}" >网站公告</a></li>
    	    <li class="@if(Request::path() == 'about/contactus' )active @endif"><a href="{{ URL('/about/contactus') }}" >联系我们</a></li>
    	</ul>
    </div>
</div>
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/navfixed.js')}}"></script>
<script type="text/javascript">
(function($){
    $(function(){
        $('.v4-aboutMenu').navFixed();
    })
})(jQuery)
</script>