@extends('pc.common.base')
@section('title', '设置/修改联系地址')
@section('csspage')

@endsection

@section('content')
<div class="v4-account">
    @include('pc.common/leftMenu')
    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">{{ $title }}</h2>
        <div class="v4-custody-main v4-phone-main">
            <form action="{{ url('user/setting/modifyAddress') }}" method="post"  id="setUserAddress">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <dl class="v4-input-group">
                    <dt>
                        <label for="address"><span>*</span> 联系地址</label>
                    </dt>
                    <dd>
                        <textarea name="address" id="address" rows="5" cols="60" maxlength="50" placeholder="请填写详细地址，如省市区、街道名称、小区名称、门牌号码、楼层等信息。" class="v4-address-texta">{{ $address }}</textarea>
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
                        <input type="submit" class="v4-input-btn" value="保存"  id="v4-input-btn">
                    </dd>
                    <dt>
                        &nbsp;
                    </dt>
                    <dd>
                        <p class="v4-address-tip"><i class="v4-iconfont v4-icon-light">&#xe6a9;</i>温馨提示：地址用于邮寄资料和礼品，请认真填写！</p>
                    </dd>
                </dl>
            </form>
        </div>

    </div>


</div>
@endsection
@section('jspage')
<script type="text/javascript">
$(function(){


})
</script>
@endsection
