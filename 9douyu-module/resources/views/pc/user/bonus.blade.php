@extends('pc.common.layoutNew')
@section('title', '优惠券')

@section('csspage')
<style>
</style>
@endsection
@section('content')
<div class="v4-account clearfix"  >
    <!-- account begins -->
    @include('pc.common/leftMenu')
    <div class="v4-content v4-account-white" ms-controller="userBonusList">
        <h2 class="v4-account-titlex">优惠券</h2>
        <div class="v4-list-bonus">
        	<div class="v4-bonus-status">
                <span>状态：</span>
                <a href="{{ url('/user/bonus/1') }}" @if($type == 1) class="active" @endif>未使用</a>
                <a href="{{ url('/user/bonus/2') }}" @if($type == 2) class="active" @endif>已使用</a>
                <a href="{{ url('/user/bonus/3') }}" @if($type == 3) class="active" @endif>已过期</a>
            </div>

            <!-- 现金券 -->
            <!-- 可用状态 -->
        @if(!empty($list))
         @foreach($list as $key=>$bonus)
            @if($type == 3 )
            <div class="v4-bonus-box v4-bonus-expired @if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH) v4-bonus-cash @else v4-bonus-rate  @endif" >
                <div class="v4-bonus-title">{{$bonus['name']}}</div>
                <div class="v4-bonus-amount">
                    @if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH )
                    <span>{{$bonus['bonus_value_note']}}</span><big>{{$bonus['bonus_value']}}</big>
                    @else
                    <big>{{$bonus['bonus_value']}}</big><span>{{$bonus['bonus_value_note']}}</span>
                    @endif
                </div>
                <div class="v4-bonus-use">{{$bonus['min_money_note']}}</div>
                <div class="v4-bonus-intro">
                    <p>{{$bonus['using_desc']}}</p>
                    <p>有效期：{{$bonus['use_start_time']}}~{{$bonus['use_end_time']}}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">@if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH)&#xe6ba; @else &#xe6ab;  @endif </i></div>
            </div>
        {{--已用的--}}
        @elseif($type == 2)
            <!--现金券-->
            <div class="v4-bonus-box  v4-bonus-used  @if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH) v4-bonus-cash @else v4-bonus-rate  @endif" >
                <div class="v4-bonus-title">{{$bonus['name']}}</div>
                <div class="v4-bonus-amount">
                    @if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH )
                    <span>{{$bonus['bonus_value_note']}}</span><big>{{$bonus['bonus_value']}}</big>
                    @else
                    <big>{{$bonus['bonus_value']}}</big><span>{{$bonus['bonus_value_note']}}</span>
                    @endif
                </div>
                <div class="v4-bonus-use">{{$bonus['min_money_note']}}</div>
                <div class="v4-bonus-intro">
                    <p>{{$bonus['using_desc']}}</p>
                    <p>有效期：{{$bonus['use_start_time']}}~{{$bonus['use_end_time']}}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">@if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH)&#xe6ba; @else &#xe6ab;  @endif</i></div>
                <div class="v4-bonus-iconused"><i class="v4-iconfont">&#xe6ad;</i></div>
            </div>

        {{--未使用的--}}
        @elseif($type == 1)
            <div class="v4-bonus-box  @if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH) v4-bonus-cash @else v4-bonus-rate  @endif" >
                <div class="v4-bonus-title">{{$bonus['name']}}</div>
                <div class="v4-bonus-amount">
                    @if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH )
                    <span>{{$bonus['bonus_value_note']}}</span><big>{{$bonus['bonus_value']}}</big>
                    @else
                    <big>{{$bonus['bonus_value']}}</big><span>{{$bonus['bonus_value_note']}}</span>
                    @endif
                </div>
                <div class="v4-bonus-use">{{$bonus['min_money_note']}}</div>
                <div class="v4-bonus-intro">
                    <p>{{$bonus['using_desc']}}</p>
                    <p>有效期：{{$bonus['use_start_time']}}~{{$bonus['use_end_time']}}</p>
                </div>
                <div class="v4-bonus-icon"><i class="v4-iconfont">@if($bonus['bonus_type'] == App\Http\Dbs\Bonus\BonusDb::TYPE_CASH)&#xe6ba; @else &#xe6ab;  @endif</i></div>
                <div class="v4-bonus-mask">
                    <a href="{{ url('/project/index')}}" target="_blank">立即使用</a>
                </div>
            </div>
        @endif
     @endforeach
     @else
        <div class="v4-bonus-none">暂无优惠券</div>
     @endif

        </div>
        <div class="clear"></div>
        @include('pc.common.paginate')
    </div>
</div>
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
@endsection

