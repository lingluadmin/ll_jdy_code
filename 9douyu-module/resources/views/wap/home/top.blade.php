<nav class="v4-top flex-box box-align box-pack">
    <img  class="v4-top-logo" src="{{ assetUrlByCdn('static/weixin/images/wap4/index/logo-top.png')}}"/>
    <div class="v4-user">
        @if(!empty($view_user))
            <a href="javascript:;" data-show="nav">我的</a>
        @else
            <a href="/login">登录</a> | <a href="/register">注册</a>
        @endif

    </div>
</nav>