<div class="v4-leftNav">
    <ul>
        <li class="@if(Request::path() == 'user')active checked @endif"><a href="{{ URL('/user') }}"  class="checkeda"><i class="v4-iconfont v4-left-nav-icon">&#xe698;</i>账户总览</a></li>
        <li class="@if(Request::path() == 'user/investList' || Request::path() == 'user/invest/detail')active checked @endif"><a href="{{ URL('/user/investList') }}" ><i class="v4-iconfont v4-left-nav-icon">&#xe693;</i>出借记录</a></li>
       {{-- <li class="@if(Request::path() == '')active checked @endif"><a href="{{ URL('/') }}" ><i class="v4-iconfont v4-left-nav-icon">&#xe697;</i>转让记录</a></li>--}}
        <li class="@if(strstr(Request::path(), 'user/fundhistory'))active checked @endif"><a href="{{ URL('/user/fundhistory') }}" ><i class="v4-iconfont v4-left-nav-icon">&#xe693;</i>交易记录</a></li>
        <li class="@if(Request::path() == 'user/refundPlan')active checked @endif"><a href="{{ URL('/user/refundPlan') }}" ><i class="v4-iconfont v4-left-nav-icon">&#xe695;</i>回款日历</a></li>
        <li class="@if(strstr(Request::path() , 'user/bonus'))active checked @endif"><a href="{{ URL('/user/bonus') }}" ><i class="v4-iconfont v4-left-nav-icon">&#xe68b;</i>优惠券<span class="v4-nav-red">({{$view_bonus['ableUserBonusCount']}})</span></a></li>
        <li class="@if(Request::path() == 'user/setting')active checked @endif"><a href="{{ URL('/user/setting') }}"   ><i class="v4-iconfont v4-left-nav-icon">&#xe69a;</i>账户设置</a></li>
        <li class="@if(Request::path() == 'user/message')active checked @endif"><a href="{{ URL('/user/message') }}" ><i class="v4-iconfont v4-left-nav-icon v4-icon-1">&#xe692;</i>消息中心 @if($view_notice['ableUserUnreadNotice'] > 0)<em class="v4-nav-red">•</em>@endif</a></li>
    </ul>
</div>
