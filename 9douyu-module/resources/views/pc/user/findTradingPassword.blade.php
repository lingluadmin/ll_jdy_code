@extends('pc.common.layout')
@section('title', '交易密码')
@section('csspage')
    
@endsection

@section('content')
<div class="v4-account">
    <!-- account begins -->
    @include('pc.common/leftMenu')

    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">{{!empty($view_user['trading_password']) ? '找回' : '设置'}}交易密码</h2>
        <div class="v4-custody-main v4-phone-main">
            <form action="/user/doForgetTradingPassword" method="post" id="findTradingPassword">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="step" value="three" />

                 <dl class="v4-input-group">
                    <dt>
                        <label for="password"><span>*</span>设置{{!empty($view_user['trading_password']) ? '新' : '支付'}}密码</label>
                    </dt>
                    <dd>
                        <input name="password" id="password" value="" placeholder="请输入{{!empty($view_user['trading_password']) ? '新' : '支付'}}密码" data-pattern="password" class="v4-input">
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
                        <input type="submit" class="v4-input-btn" value="确认"  id="v4-input-btn">
                    </dd>
                </dl>
            </form>
        </div>
        
    </div>
</div>

@endsection
@section('jspage')
<script type="text/javascript">

(function($){
    $(function(){
        // 检验输入框内容
        $.validation('.v4-input');

        // 表单提交验证
        $("#findTradingPassword").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#findTradingPassword'
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
