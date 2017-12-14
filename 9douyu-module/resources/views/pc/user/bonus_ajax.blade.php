@extends('pc.common.layoutNew')
@section('title', '优惠券')

@section('csspage')
<style>
</style>
@endsection
@section('content')
<div class="v4-account"  >
    <!-- account begins -->
    @include('pc.common/leftMenu')
    <div class="v4-content v4-account-white ms-controller" ms-controller="userBonusList">
        <h2 class="v4-account-titlex">{%@title%}</h2>
        <div class="v4-list-bonus">
        	<div class="v4-bonus-status">
                <span>状态：</span>
                <a href="{{ url('/user/bonus/1') }}" @if($type == 1) class="active" @endif>未使用</a>
                <a href="{{ url('/user/bonus/2') }}" @if($type == 2) class="active" @endif>已使用</a>
                <a href="{{ url('/user/bonus/3') }}" @if($type == 3) class="active" @endif>已过期</a>
            </div>

            <!-- 现金券 -->
            <!-- 可用状态 -->
         <div ms-if="@count>0"  ms-for="(key, val) in @list">
            @if($type == 3 )
            <div class="v4-bonus-box v4-bonus-cash v4-bonus-expired" ms-if='@val.bonus_type == 300'>
                <div class="v4-bonus-title">{% @val.name%}</div>
                <div class="v4-bonus-amount">
                    <span>{%@val.bonus_value_note%}</span><big>{%@val.bonus_value%}</big>
                </div>
                <div class="v4-bonus-use">{%@val.min_money_note%}</div>
                <div class="v4-bonus-intro">
                    <p>{%@val.using_desc%}</p>
                    <p>有效期：{%@val.use_start_time%}~{%@val.use_end_time%}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">&#xe6ac;</i></div>
            </div>
            <!--加息券-->
            <div class="v4-bonus-box v4-bonus-rate v4-bonus-expired" ms-if='@val.bonus_type != 300'>
                <div class="v4-bonus-title">{% @val.name%}</div>
                <div class="v4-bonus-amount">
                    <big>{%@val.bonus_value%}</big><span>{%@val.bonus_value_note%}</span>
                </div>
                <div class="v4-bonus-use">{%@val.min_money_note%}</div>
                <div class="v4-bonus-intro">
                    <p>{%@val.using_desc%}</p>
                    <p>有效期：{%@val.use_start_time%}~{%@val.use_end_time%}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">&#xe6ab;</i></div>

            </div>
        {{--已用的--}}
        @elseif($type == 2)
            <!--现金券-->
            <div class="v4-bonus-box v4-bonus-cash v4-bonus-used" ms-if='@val.bonus_type == 300'>
                <div class="v4-bonus-title">{% @val.name%}</div>
                <div class="v4-bonus-amount" >
                    <span>{%@val.bonus_value_note%}</span><big>{%@val.bonus_value%}</big>
                </div>
                <div class="v4-bonus-use">{%@val.min_money_note%}</div>
                <div class="v4-bonus-intro">
                    <p>{%@val.using_desc%}</p>
                    <p>有效期：{%@val.use_start_time%}~{%@val.use_end_time%}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">&#xe6ac;</i></div>
                <div class="v4-bonus-iconused"><i class="v4-iconfont">&#xe6ad;</i></div>
            </div>
            <!--已使用的加息券-->
            <div class="v4-bonus-box v4-bonus-rate v4-bonus-used" ms-if='@val.bonus_type != 300'>
                <div class="v4-bonus-title">{% @val.name%}</div>
                <div class="v4-bonus-amount" >
                    <big>{%@val.bonus_value%}</big><span>{%@val.bonus_value_note%}</span>
                </div>
                <div class="v4-bonus-use">{%@val.min_money_note%}</div>
                <div class="v4-bonus-intro">
                    <p>{%@val.using_desc%}</p>
                    <p>有效期：{%@val.use_start_time%}~{%@val.use_end_time%}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">&#xe6ab;</i></div>
                <div class="v4-bonus-iconused"><i class="v4-iconfont">&#xe6ad;</i></div>

            </div>
        {{--未使用的--}}
        @elseif($type == 1)
            <div class="v4-bonus-box v4-bonus-cash " ms-if='@val.bonus_type == 300'>
                <div class="v4-bonus-title">{% @val.name%}</div>
                <div class="v4-bonus-amount" >
                    <span>{%@val.bonus_value_note%}</span><big>{%@val.bonus_value%}</big>
                </div>
                <div class="v4-bonus-use">{%@val.min_money_note%}</div>
                <div class="v4-bonus-intro">
                    <p>{%@val.using_desc%}</p>
                    <p>有效期：{%@val.use_start_time%}~{%@val.use_end_time%}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">&#xe6ac;</i></div>
                <div class="v4-bonus-mask">
                    <a href="{{ url('/project/index')}}" target="_blank">立即使用</a>
                </div>
            </div>
            <div class="v4-bonus-box v4-bonus-rate" ms-if='@val.bonus_type != 300'>
                <div class="v4-bonus-title">{% @val.name%}</div>
                <div class="v4-bonus-amount" >
                    <big>{%@val.bonus_value%}</big><span>{%@val.bonus_value_note%}</span>
                </div>
                <div class="v4-bonus-use">{%@val.min_money_note%}</div>
                <div class="v4-bonus-intro">
                    <p>{%@val.using_desc%}</p>
                    <p>有效期：{%@val.use_start_time%}~{%@val.use_end_time%}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">&#xe6ab;</i></div>
                <div class="v4-bonus-mask">
                    <a href="{{ url('/project/index')}}" target="_blank">立即使用</a>
                </div>
            </div>
        @endif
        </div>
        <div ms-if="@count<=0" class="v4-bonus-none">暂无优惠券</div>
        <div class="clear"></div>
        </div>
        @include('pc.common.page')
    </div>
</div>
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
<input type="hidden" id="bonusType" value="{{ $type }}" />
<input type="hidden" id="page" value="{{$page}}" />
<script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/user-bonus-list.js')}}"></script>
@endsection

