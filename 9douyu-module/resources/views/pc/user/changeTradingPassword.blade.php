@extends('pc.common.base')
@section('title', '修改交易密码')
@section('csspage')
    
@endsection

@section('content')
<div class="v4-account">
    <!-- account begins -->
    @include('pc.common/leftMenu')

    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">修改交易密码</h2>
        <div class="v4-custody-main v4-phone-main">
            <form action="/user/doTradingPassword" method="post" id="changeTradingPassword">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                 <dl class="v4-input-group">
                    <dt>
                        <label for="password"><span>*</span>原始密码</label>
                    </dt>
                    <dd>
                        <input value="" type="password" name="oldPassword" placeholder="请输入6~16位字母和数字的组合" id="password" data-pattern="password" class="v4-input">
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>

                    </dd>
                    <dt>
                        <label for="password2"><span>*</span>设置新密码</label>
                    </dt>
                    <dd>
                        <input value="" type="password" name="newPassword" placeholder="再次输入新密码" id="password2" data-pattern="password" class="v4-input">
                        <i class="v4-eye-icon v4-iconfont">&#xe6a1;</i>
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>
                    <dt>
                        &nbsp;
                    </dt>
                    <dd>
                        <div id="v4-input-msg" class="v4-input-msg">
                            @if(Session::has('errorMsg'))
                                {{ Session::get('errorMsg') }}
                            @endif
                        </div>
                        <input type="submit" class="v4-input-btn" value="下一步"  id="v4-input-btn">
                    </dd>
                </dl>
            </form>
        </div>
        
    </div>
</div>

@endsection
@section('jspage')
<script src="{{assetUrlByCdn('/assets/js/pc4/custodyAccount.js')}}" type="text/javascript"></script>
<script type="text/javascript">

(function($){
    $(function(){
        // 检验输入框内容
        $.validation('.v4-input');

        // 表单提交验证
        $("#changeTradingPassword").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#changeTradingPassword'
            })) return false;
        });

        //密码eye
        $(".v4-eye-icon").click(function(){
            if($(this).hasClass("open")){
               $(this).removeClass("open");
               $(this).html("&#xe6a1;");
               $(this).prev().attr("type","password");
            }else{
                $(this).addClass("open");
                $(this).prev().attr("type","text");
                 $(this).html("&#xe6a2;");
            }
        })

    })
})(jQuery);
</script>
@endsection
