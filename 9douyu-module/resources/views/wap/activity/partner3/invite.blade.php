@extends('wap.common.wapBaseNew')

@section('title', '九斗鱼合伙人计划')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn ('/static/weixin/activity/partner3/css/invite.css') }}">
@endsection

@section('content')
    <article class="page-share-auto">
		<section class="partner-share-banner">
			<a href="/activity/invite/rule" class="rule">活动规则</a>
		</section>
		<section class="partner-section-wrap">
			<h6 class="partner-tag">赚钱攻略</h6>
			<div class="partner-step">
				<ul class="partner-flex-box partner-box-align">
					<li><span>1.</span>
						分享<br>
						邀请链接
					</li>
					<li><span>2.</span>
						好友<br>
						注册投资
					</li>
					<li><span>3.</span>
						每天<br>
						&nbsp;收到佣金
					</li>
				</ul>
			</div>
			@if(!empty($uid))
				<a href="javascript:;" class="partner-btn-money" data-layer="modul3">分享赚钱</a>
			@else
				<a href="javascript:;" class="partner-btn-money" id="loginBtn">登录后分享</a>
			@endif
			<p class="partner-rate">每日佣金收益=全部好友在投本金×佣金收益率÷365<br>如有疑问？点击右上角 <a href="/activity/invite/rule">活动规则</a></p>
		</section>
		<section class="partner-ranking">
			<h6>邀请排行榜</h6>
			<table class="partner-inviation border-bottom">
					@if(!empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td width="10%">
									<img src="{{assetUrlByCdn('/static/weixin/activity/partner3/images/partner-pk-icon'.($k+1).'.png')}}">
								</td>
								<td width="15%">NO.{{ $k+1 }} </td>
								<td width="30%">{{ $v['phone'] }}</td>
								<td>已赚  <span>¥{{ number_format($v['interest'], 2) }}</span></td>
							</tr>
						@endforeach
					@endif
			</table>
		</section>
		<section class="partner-totaly">
			<a href="javascript:void(0)">累计佣金收益(元)：{{ isset($partner_info['interest']) ? number_format($partner_info['interest'], 2) : '0.00' }}<img src="{{assetUrlByCdn('/static/weixin/activity/partner3/images/partner-arrow-icon.png')}}"></a>
		</section>

		<!--邀请好友 浏览器打开提示弹窗 -->
		<div class="partner-share-layer modul3">
			<div class="partner-mask" data-toggle="mask" data-target="modul3"></div>
			<div class="partner-pop"><img src="{{assetUrlByCdn('/static/weixin/activity/partner3/images/partner-share-img.png')}}" class="partner-share-img"  data-toggle="mask" data-target="modul3"></div>
		</div>
    </article>

	@include('wap.common.partnershare')

@endsection
@section('jsScript')
<script type="text/javascript" src="{{assetUrlByCdn('/static/weixin/js/pop.js')}}"></script>
<script type="text/javascript">
	//ready 函数
	var readyRE = /complete|loaded|interactive/;
	var ready = window.ready = function (callback) {
		if (readyRE.test(document.readyState) && document.body) callback()
		else document.addEventListener('DOMContentLoaded', function () {
			callback()
		}, false)
	}
	//rem方法
	function ready_rem() {
		var view_width = document.getElementsByTagName('html')[0].getBoundingClientRect().width;
		var _html = document.getElementsByTagName('html')[0];
		if (view_width > 640) {
			_html.style.fontSize = 750 / 16 + 'px'
		} else {
			_html.style.fontSize = view_width / 16 + 'px';
		}
	}
	//OverLoad ready
	ready(function () {
		ready_rem();
	});

	//For page biz
	function getCookie(c_name){
		if (document.cookie.length>0){
			c_start=document.cookie.indexOf(c_name + "=")
			if (c_start!=-1){
				c_start=c_start + c_name.length+1
				c_end=document.cookie.indexOf(";",c_start)
				if (c_end==-1) c_end=document.cookie.length
				return unescape(document.cookie.substring(c_start,c_end))
			}
		}
		return "";
	}

	var client = getCookie('JDY_CLIENT_COOKIES');
	if( client == '' || !client ){
		var client  =   '{{$client or "wap"}}';
	}
	var version =   getCookie('version');
	if( version=='' || !version ) {
		var version = '{{$version or ""}}'
	}

	$(document).delegate("#loginBtn","click",function () {
		if( client =='ios'){
			if(version =='4.1.2') {
				window.location.href='/login';
				return false
			} else {
				window.location.href = "objc:gotoLogin";
				return false;
			}
		}
		if (client =='android'){
			window.jiudouyu.login();
			return false;
		}
		window.location.href='/login';
	});
</script>

@endsection



