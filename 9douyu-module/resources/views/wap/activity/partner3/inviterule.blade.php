@extends('wap.common.wapBase')

@section('title', '九斗鱼合伙人计划')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
    <meta name="format-detection" content="telephone=yes">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn ('/static/weixin/activity/partner3/css/invite.css') }}">
@endsection

@section('content')
    <article>
    	<div class="partner-rule-box partner-rule-time">
    		<h3 class="rule-title rule-time">活动时间</h3>
    		<p>2017年12月1日-2018年3月31日</p>
    	</div>

		<h3 class="rule-title">邀请方式</h3>
    	<div class="partner-rule-box">
    		<p>1、好友通过分享链接完成注册；</p>
    		<p>2、好友注册时填写您的邀请码（即手机号）；</p>
    		<p>新邀请的好友，可在好友注册完成24小时以内，通过app查看相关邀请信息。</p>
    	</div>
		
    	<h3 class="rule-title">活动内容</h3>
    	<div class="partner-rule-box">
    		<p>邀请好友完成注册且好友注册成功后投资优选项目<em>（不包含零钱计划）</em>，邀请人可获得佣金收益。</p>
    		<div class="partner-rule-icon">
    			<p><label>佣金收益率计算公式：</label></p>
    			<p><em>佣金收益率=1%+投资好友人数×0.1%</em></p>
    		</div>
    		<p><mark class="markorange">举例</mark>  以您邀请3个好友为例，如果全部好友的当前在投本金为100万元。</p>
    		<p><mark class="markblue">每日您可获得的佣金收益</mark></p>
    		<p>100万元×（1%+3×0.1%）÷365天=35.62元</p>
    		<p><mark class="markblue">若您的好友连续投资1年，您可获得的佣金</mark></p>
    		<p>35.62元×365天=13001.3元。</p>
    	</div>

    	<h3 class="rule-title">佣金规则</h3>
    	<div class="partner-rule-box">
    		<p>1、佣金收益率：1%+投资好友人数×0.1%，最高上限为<em>3%</em>；</p>
    		<p>2、每日23点前发放前一日的佣金收益，今日返佣金额=昨日好友在投本金×昨日佣金收益率÷365天；</p>
    		<p>3、好友在投本金：好友投资优选项目的本金<em>（不包括零钱计划）</em>；</p>
    		<p>4、每日获得的佣金，将发放至您的佣金余额中。</p>
    	</div>
		<h3 class="rule-title rule-title-longer">不能获得佣金的情况（以下任意一种）</h3>
		<div class="partner-rule-box partner-rule-null">
			<p><i>1</i>好友未通过分享链接完成注册；</p>
			<p><i>2</i>好友注册时未填写您的邀请码（即手机号）；</p>
			<p><i>3</i>好友投资零钱计划或债权转让。</p>
		</div>
		<footer class="partner-rule-footer">
			<p>
				※本活动最终解释权归九斗鱼所有<br>
			如有疑问请咨询客服电话：400-6686-568（9:00~18:00）
			</p>
		</footer>
    </article>

@endsection
@section('jsScript')
<script>
</script>
@endsection



