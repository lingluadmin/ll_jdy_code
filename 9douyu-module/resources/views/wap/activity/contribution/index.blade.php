@extends('wap.common.wapBaseNew')

@section('title', '九斗鱼获得金融科技杰出贡献奖')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/activity/contribution/css/index.css')}}">
@endsection

@section('content')
<article>
    <img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/banner.png')}}" class="img">
    <div class="repeat-box">
	    <div class="contr-prize-box">
	    	<div class="contr-prize-img">
	    		<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/prize.png')}}">
	    	</div>
	    	<div class="contr-prize-txt">
	    		<p class="contr-prize-time">2017年11月16日</p>
	    		<p>在第九届金融科技与支付创新2017年度盛会上，九斗鱼凭借自身优秀金融科技创新能力，一举斩获“金融科技杰出贡献奖”。该奖项是金融科技领域的权威奖项，旨在表彰一年来在金融科技领域做出突出贡献的单位。</p>
	    	</div>
	    </div>
    	<div class="contr-title title2">大会回顾</div>
    	<ul class="contr-review">
    		<li>
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/img1.png')}}">
    			<p>原旭霖原总受邀参加大会</p>
    		</li>
    		<li class="moretext">
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/img2.png')}}">
    			<p>《21世纪商业评论》<br>记者专访原旭霖原总</p>
    		</li>
    		<li class="moretext">
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/img3.png')}}">
    			<p>《经济日报》上海办事处常务<br>副主任专访原旭霖原总</p>
    		</li>
    		<li class="moretext">
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/img4.png')}}">
    			<p>《华夏时报》上海站主任/主任记者<br>专访原旭霖原总</p>
    		</li>
    		<li>
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/img5.png')}}">
    			<p>会议现场</p>
    		</li>
    		<li>
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/img6.png')}}">
    			<p>会议现场</p>
    		</li>
    		<li>
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/img7.png')}}">
    			<p>九斗鱼赞助大会</p>
    		</li>
    		<li>
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/img8.png')}}">
    			<p>会议大屏幕</p>
    		</li>
    	</ul>
    	<div class="contr-title">金融科技与支付创新·大会简介</div>
    	<div class="contr-intro">
    		<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/intro.png')}}">
    	</div>
    	<div class="contr-block">
    		<div class="contr-block-img">
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/icon1.png')}}">
    			<p>领先</p>
    		</div>
    		<div class="contr-block-txt txt1">
    			<p>八年的探索和沉淀，金融科技与支付创1系列峰会现已成为业内首屈一指的致力于探索金融科技与支付领域上下游、全产业链最新话题、最先进技术和产品、最便捷交流洽谈的一站式会议平台。</p>
    		</div>
    	</div>
    	<div class="contr-block">
    		<div class="contr-block-img">
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/icon2.png')}}">
    			<p>权威</p>
    		</div>
    		<div class="contr-block-txt">
    			<p>1500+政府机构及协会、国内外知名银行、监管机构、支付平台、消费金融、大数据、云计算、风控、征信、P2P、区块链、人工智能及基金、保险等金融科技和支付领域大咖。</p>
    		</div>
    	</div>
    	<div class="contr-block">
    		<div class="contr-block-img">
    			<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/icon3.png')}}">
    			<p>专业</p>
    		</div>
    		<div class="contr-block-txt txt3">
    			<p>500+高级从业者深度解析业内关注的热点话题，共同探讨最新案例，寻求最佳实践。</p>
    		</div>
    	</div>

    	<div class="contr-title">什么是金融科技</div>
    	<div class="contr-what">
    		<p> 金融科技可以理解为利用大数据、人工智能、征信、区块链、云计算、移动互联等新科技手段，服务于金融效率提升的科技产业。</p>
    		<div class="contr-what-title">金融科技势在必行</div>
    		<span>传统金融服务仍然与国家发展和人民群众的金融需求相距甚远</span>
    		<span>金融科技变革是中国弯道超车重建国际金融新秩序的重要切入点</span>
    		<span>全球主要创新国家加速布局金融科技领域</span>
    		<span>信息技术发展为金融科技进步提供必要前提</span>
    	</div>
    	<div class="contr-title">IFPI系列指导机构和支持机构</div>
    	<div class="contr-ifpi">
    		<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/ifpi.png')}}">
    	</div>
    	<div class="contr-title">媒体报道</div>
    	<div class="contro-media">
    		<img src="{{assetUrlByCdn('/static/weixin/activity/contribution/images/media.png')}}">
    	</div>
    </div>
</article>
@endsection



