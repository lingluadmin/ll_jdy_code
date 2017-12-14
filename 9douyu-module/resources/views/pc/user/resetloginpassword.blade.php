@extends('pc.common.layout')
@section('title', '找回登录密码')
@section('csspage')

@endsection

@section('content')
<div class="v4-wrap v4-custody-wrap">
        <h2 class="v4-account-titlex">找回登录密码</h2>
        <div class="v4-custody-main">
            <form action="/doForgetPassword" method="post" id="resetloginpassword">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="step" value="three" />

                <dl class="v4-input-group">
                    <dt>
                        <label for="password"><span>*</span> 设置新密码</label>
                    </dt>
                    <dd>
                        <input value="" type="password" name="password" placeholder="请输入6~16位字母和数字的组合" id="password" data-pattern="password" class="v4-input">
                        <i class="v4-eye-icon v4-iconfont">&#xe6a1;</i>
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>

                    </dd>
                    <dt>
                        <label for="passwordSec"><span>*</span> 确认新密码</label>
                    </dt>
                    <dd>
                        <input value="" type="password" name="passwordSec" placeholder="再次输入新密码" id="passwordSec" data-pattern="passwordSec" class="v4-input">
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

@endsection
@section('jspage')
<script type="text/javascript">
$(function(){

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
       

    // 检验输入框内容
        $.validation('.v4-input');

    // 表单提交验证
         $("#resetloginpassword").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#resetloginpassword'
            })) return false;
        });
          
          $.checkPassword({
                errorMsg:'#v4-input-msg', //错误提示信息
                password:'#password', //密码
                passwordSec:'#passwordSec' //确认密码
            })

          
})
</script>
@endsection