@extends('pc.common.layoutNew')

@section('title', '安全保障')
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/css/pc4/security.css')}}">
@endsection

@section('content')
 <div class="security-banner">
 	<div class="security-wrap">
 		<div class="security-title">
 			<h2>权威风控系统</h2>
 			<p class="security-line"><span></span><i></i><span></span></p>
 			<p>严守风控防线，构建高标准风控体系</p>
 		</div>
 		<dl class="security-riskcalc">
 			<dt>
 				<img src="{{ assetUrlByCdn('/static/images/pc4/security/security-logo.png')}}" width="155" height="55">
 			</dt>
 			<dd>
 				<p>九斗鱼以RISKCALC中小企业信用风险评价技术全面考察借款方，进行超过260项定性、定量指标的审核与评估，以科学的计算结果判断企业的还款能力，预估逾期风险。</p>
 				<p>RISKCALC中小企业风险评价技术融合了耀盛中国过去11年服务中小微企业的丰富经验，已获国家技术专利认可，使得耀盛中国信贷业务连续三年不良率低于0.8%，实力处于行业领先地位。</p>
 			</dd>
 		</dl>
 		<!-- 基本风控流程 -->
 		<div class="security-progerss">
 			<h3>基本风控流程</h3>
 			<div class="security-progerss-icon">
 				<p><i class="v4-iconfont">&#xe6ca;</i></p>
 				<p>申请借款</p>
 			</div>
 			<div class="security-progerss-txt">
 				<p>提交资料</p>
 				<p><i class="v4-iconfont">&#xe626;</i></p>
 			</div>
 			<div class="security-progerss-icon">
 				<p><i class="v4-iconfont">&#xe6cc;</i></p>
 				<p>资料核实</p>
 			</div>
 			<div class="security-progerss-txt">
 				<p>递交资料</p>
 				<p><i class="v4-iconfont">&#xe626;</i></p>
 			</div>
 			<div class="security-progerss-icon">
 				<p><i class="v4-iconfont">&#xe6cd;</i></p>
 				<p>风控初审</p>
 			</div>
 			<div class="security-progerss-txt">
 				<p>通过初审</p>
 				<p><i class="v4-iconfont">&#xe626;</i></p>
 			</div>
 			<div class="security-progerss-icon">
 				<p><i class="v4-iconfont">&#xe6cb;</i></p>
 				<p>系统审核</p>
 			</div>
 			<div class="security-progerss-txt">
 				<p>审核报告</p>
 				<p><i class="v4-iconfont">&#xe626;</i></p>
 			</div>
 			<div class="security-progerss-icon">
 				<p><i class="v4-iconfont">&#xe6c6;</i></p>
 				<p>尽职调查</p>
 			</div>
 			<div class="security-progerss-txt">
 				<p>风控报告</p>
 				<p><i class="v4-iconfont">&#xe626;</i></p>
 			</div>
 			<div class="security-progerss-icon">
 				<p><i class="v4-iconfont">&#xe6c8;</i></p>
 				<p>风控复审</p>
 			</div>
 			<div class="security-progerss-txt">
 				<p>出具风险评级</p>
 				<p><i class="v4-iconfont">&#xe626;</i></p>
 			</div>
 			<div class="security-progerss-icon">
 				<p><i class="v4-iconfont">&#xe6c7;</i></p>
 				<p>发布项目</p>
 			</div>
 			
 		</div>
 		<!-- End 基本风控流程 -->


 		
 	</div>
 </div>
<!-- 专业云服务商 -->
 <div class="security-wrap">
 	<div class="security-title">
		<h2>专业云服务商</h2>
		<p class="security-line2"></p>
	</div>
	<div class="security-cloud-intro">九斗鱼接入阿里巴巴集团旗下的阿里云服务，为平台用户提供更安全的网络服务。阿里云创立于2009年，是全球领先的云计算及人工智能科技公司，为200多个国家和地区的企业、开发者和政府机构提供服务。</div>
	<ul class="security-cloud">
		<li class="security-cloud-1">
			<p><span class="security-cloud-icon security-cloud-icon1"></span></p>
			<p><strong>数据安全</strong></p>
			<p class="security-cloud-txt">拥有全球最大网络攻击防御经验，三层防火墙隔离系统的访问层、应用层和数据层，有效的入侵防范及容灾备份，确保交易数据安全。</p>
		</li>
		<li class="security-cloud-2 active">
			<p><span class="security-cloud-icon security-cloud-icon2"></span></p>
			<p><strong>访问安全</strong></p>
			<p class="security-cloud-txt">对外端口检测，安全风险评估，消除安全隐患，开放相应访问控制权限。通过各类安全组配置工具，提升安全级别。</p>
		</li>
		<li class="security-cloud-3">
			<p><span class="security-cloud-icon security-cloud-icon3"></span></p>
			<p><strong>灾难备份</strong></p>
			<p class="security-cloud-txt">两地三中心灾备系统，保障平台业务连续性、稳定性。通过灵活的备份机制及回滚策略，可根据业务情况进行数据恢复。</p>
		</li>
	</ul>
 </div>
<!-- End 专业云服务商 -->

<!-- 稳固安全防护 -->
<div class="security-protect">
	<div class="security-wrap">
		<div class="security-title security-title2">
			<h2>稳固安全防护</h2>
			<p class="security-line3"></p>
		</div>
		<ul class="security-protect-list">
			<li class="security-protect-bg1">
				<div class="security-protect-main">
					<p><i class="v4-iconfont">&#xe6c5;</i></p>
					<p><big>抗D保</big></p>
					<p>恶意流量清洗服务</p>
				</div>
				<div class="security-protect-info">
					九斗鱼接入知道创宇“抗D保产品”，通过其独创的智能攻击识别引擎，防止平台遭受DDoS攻击、Web请求欺诈等恶意流量清洗。
				</div>
			</li>
			<li class="security-protect-bg2">
				<div class="security-protect-main">
					<p><i class="v4-iconfont">&#xe6c4;</i></p>
					<p><big>创宇盾</big></p>
					<p>Web业务系统防入侵服务</p>
				</div>
				<div class="security-protect-info">
					九斗鱼接入知道创宇“创宇盾”防入侵服务系统，通过其军工级Web业务系统防护服务，实现平台网页防篡改、防拖库窃密、防挂马。
				</div>
			</li>
			<li class="security-protect-bg3">
				<div class="security-protect-main">
					<p><i class="v4-iconfont">&#xe6c9;</i></p>
					<p><big>SSL证书</big></p>
					<p>全球唯一身份认证标准</p>
				</div>
				<div class="security-protect-info">
					九斗鱼获得Symantec颁发的EVSSL级证书，并通过Norton Secured Seal（诺顿安全认证签章），为用户提供256位网站内容加密及漏洞扫描，保障交易安全。
				</div>
			</li>
		</ul>
	</div>
</div>
<!-- End 稳固安全防护 -->

@endsection
@section('jspage')
<script type="text/javascript">
(function($){
	$(function(){
		$('.security-cloud li').each(function() {
			$(this).hover(function(){
				$(this).addClass('active').siblings('.security-cloud li').removeClass('active');
			})
		});
	})
})(jQuery)
</script>
@endsection
