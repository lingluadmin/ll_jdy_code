@extends('pc.common.base')
@section('title', '修改手机号')
@section('csspage')

@endsection

@section('content')
<div class="v4-account">
    @include('pc.common/leftMenu')
    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">修改手机号</h2>
        <div class="v4-custody-main v4-phone-main">
            <form action="/user/setting/phone/doVerifyTransactionPassword" method="post" id="modifyPhoneStepOne">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <dl class="v4-input-group">
                    <dt>
                        <label for="password"><span>*</span> 交易密码</label>
                    </dt>
                    <dd>
                        <input value="" type="password" name="password" placeholder="请输入交易密码" id="password" data-pattern="passwordTradingOld" class="v4-input">
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
<script src="{{assetUrlByCdn('/assets/js/pc4/custodyAccount.js')}}" type="text/javascript"></script>
<script type="text/javascript">

$(function(){
 // 检验输入框内容
        $.validation('.v4-input');

    // 表单提交验证
         $("#modifyPhoneStepOne").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#modifyPhoneStepOne'
            })) return false;
        });


    
})

   
          
</script>
@endsection