@extends('pc.common.layout')
@section('title', '找回密码')
@section('csspage')
    
@endsection


@section('content')
<div class="v4-wrap v4-custody-wrap">
        <h2 class="v4-account-titlex">找回登录密码</h2>
        <div class="v4-custody-main">
            <form action="/doResetLoginPasswordIdCard" method="post" id="identityPasswordForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="phone" value="{{$phone}}">
                <input type="hidden" name="code" value="{{$code}}">
                <dl class="v4-input-group">
                    <dt>
                        <label for="name"><span>*</span>姓名</label>
                    </dt>
                    <dd>
                        <input name="realName" value="{{!empty($realName)?$realName:''}}" placeholder="请输入实名用户姓名" id="name" data-pattern="name" class="v4-input">
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>
                    <dt>
                        <label for="idcard"><span>*</span>身份证号</label>
                    </dt>
                    <dd>
                        <input name="identityCard" value="{{!empty($identityCard)?$identityCard:''}}" placeholder="请输入实名用户身份证号" id="idcard" data-pattern="idcard" class="v4-input">
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

@endsection
@section('jspage')
<script type="text/javascript" src="{{ assetUrlByCdn('/assets/js/pc4/custodyAccount.js') }}"></script>
<script type="text/javascript">
$(function(){
    

    // 检验输入框内容
        $.validation('.v4-input');

    // 表单提交验证
         $("#identityPasswordForm").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#identityPasswordForm'
            })) return false;
        });
})
</script>
@endsection