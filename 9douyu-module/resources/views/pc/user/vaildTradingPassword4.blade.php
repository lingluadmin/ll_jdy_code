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
            <form action="/user/doForgetTradingPassword" method="post" id="vaildTradingPassword">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="step" value="two" />

                <dl class="v4-input-group">
                    <dt>
                        <label for="name"><span>*</span>真实姓名</label>
                    </dt>
                    <dd>
                        <input name="realName" value="{{ old('realName') }}" placeholder="请输入实名用户姓名" id="name" data-pattern="name" class="v4-input">
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>
                    <dt>
                        <label for="idcard"><span>*</span>身份证号</label>
                    </dt>
                    <dd>
                        <input name="identityCard" value="{{ old('identityCard') }}" placeholder="请输入实名用户身份证号" id="idcard" data-pattern="idcard" class="v4-input">
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
<script type="text/javascript">

(function($){
    $(function(){
        // 检验输入框内容
        $.validation('.v4-input');

        // 表单提交验证
        $("#vaildTradingPassword").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#vaildTradingPassword'
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
