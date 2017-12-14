@extends('pc.common.base')
@section('title', '设置紧急联系人')
@section('csspage')

@endsection

@section('content')
<div class="v4-account">
    @include('pc.common/leftMenu')
    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">设置紧急联系人</h2>
        <div class="v4-custody-main v4-phone-main">
            <form action="{{url('/user/setting/doUrgentPhone')}}" method="post"  id="setUrgentPhone">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input name='setting' value="set" type="hidden"/>
                <dl class="v4-input-group">
                    <dt>
                        <label for="phone"><span>*</span> 紧急联系人</label>
                    </dt>
                    <dd>
                        <input type="text"  name="urgent_phone" id="phone" placeholder="请输入11位手机号" data-pattern="registerphone"  class="v4-input"/>
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
         $("#setUrgentPhone").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#setUrgentPhone'
            })) return false;
        });

})
</script>
@endsection
