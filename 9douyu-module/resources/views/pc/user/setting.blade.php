@extends('pc.common.base')

@section('title', '账户设置')

@section('content')

<div class="v4-account">
    <!-- account begins -->
    @include('pc.common/leftMenu')

    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">账户设置</h2>
        <div class="v4-user-information">
        	<ul>
        		<!-- 风险评测等级 -->
				@if(!empty($user['assessment']))
					<li class="v4-info-been">
						<div class="v4-info-title">风险评测等级</div>
						<div class="v4-info-result v4-info-type">{{$user['assessment']}}</div>
						<div class="v4-info-operate"><a href="/user/riskAssessment" class="v4-btn">重新评测</a></div>
					</li>
				@else
					<li class="v4-info-not">
						<div class="v4-info-title">风险评测等级</div>
						<div class="v4-info-result">未评测</div>
						<div class="v4-info-operate"><a href="javascript:;" onclick="$('#lay_wrap3').layer();" class="v4-btn">开始评测</a></div>
					</li>
				@endif
        		<!-- End 风险评测等级 -->

        		<!-- 手机号 -->
        		<li class="v4-info-been">
        			<div class="v4-info-title">手机号</div>
        			<div class="v4-info-result">{{$user['phone']}}</div>
        			<div class="v4-info-operate"><a href="/user/setting/phone/stepOne" class="v4-btn">修改</a></div>
        		</li>
        		<!-- End 手机号 -->

        		<!-- 实名认证 -->
				@if(!empty($user['real_name']))
					<li class="v4-info-been">
						<div class="v4-info-title">实名认证</div>
						<div class="v4-info-result"><span>{{$user['real_name']}} </span>{{$user['id_card']}}</div>
					</li>
				@else
					<li class="v4-info-not">
						<div class="v4-info-title">实名认证</div>
						<div class="v4-info-result">未实名</div>
						<div class="v4-info-operate"><a href="/user/setting/verify" class="v4-btn">实名认证</a></div>
					</li>
				@endif
        		<!-- End 实名认证 -->

        		<!-- 登录密码 -->
        		<li class="v4-info-been">
        			<div class="v4-info-title">登录密码</div>
        			<div class="v4-info-result">已设置</div>
        			<div class="v4-info-operate"><a href="/user/password" class="v4-btn">修改</a></div>
        		</li>
        		<!-- End 登录密码 -->

        		<!-- 交易密码 -->
				@if(!empty($user['trading_password']))
					<li class="v4-info-been">
						<div class="v4-info-title">交易密码</div>
						<div class="v4-info-result">已设置</div>
						<div class="v4-info-operate"><a href="/user/modify/tradingPassword" class="v4-btn">修改</a></div>
					</li>
				@else
					<li class="v4-info-not">
						<div class="v4-info-title">交易密码</div>
						<div class="v4-info-result">未设置</div>
						@if(!empty($user['real_name']))
							<div class="v4-info-operate"><a href="/user/forgetTradingPassword" class="v4-btn">设置</a></div>
						@else
							<div class="v4-info-operate"><a href="/user/setting/verify" class="v4-btn">设置</a></div>
						@endif
					</li>
				@endif
        		<!-- End 交易密码 -->

        		<!-- 邮箱认证 -->
				@if(!empty($user['email']))
					<li class="v4-info-been">
						<div class="v4-info-title">邮箱认证</div>
						<div class="v4-info-result">{{$user['email']}}</div>
						<div class="v4-info-operate"><a href="/user/modify/email/stepOne" class="v4-btn">修改</a></div>
					</li>
				@else
					<li class="v4-info-not">
						<div class="v4-info-title">邮箱认证</div>
						<div class="v4-info-result">未设置</div>
						<div class="v4-info-operate"><a href="/user/setting/email" class="v4-btn">设置</a></div>
					</li>
				@endif
        		<!-- End 邮箱认证 -->

        		<!-- 紧急联系人 -->
				@if(!empty($user['urgent_man']))
					<li class="v4-info-been">
						<div class="v4-info-title">紧急联系人</div>
						<div class="v4-info-result">{{$user['urgent_man']}}</div>
						<div class="v4-info-operate"><a href="/user/modify/urgent/stepOne" class="v4-btn">修改</a></div>
					</li>
				@else
					<li class="v4-info-not">
						<div class="v4-info-title">紧急联系人</div>
						<div class="v4-info-result">未设置</div>
						<div class="v4-info-operate"><a href="/user/setting/urgentPhone" class="v4-btn">设置</a></div>
					</li>
				@endif
        		<!-- End 紧急联系人 -->

        		<!-- 联系地址 -->
				@if(!empty($user['address']))
					<li class="v4-info-been">
						<div class="v4-info-title">联系地址</div>
						<div class="v4-info-result">{{$user['address']}}</div>
						<div class="v4-info-operate"><a href="/user/setting/address" class="v4-btn">修改</a></div>
					</li>
				@else
					<li class="v4-info-not">
						<div class="v4-info-title">联系地址</div>
						<div class="v4-info-result">未设置</div>
						<div class="v4-info-operate"><a href="/user/setting/address" class="v4-btn">设置</a></div>
					</li>
				@endif
        		<!-- End 联系地址 -->
        	</ul>
        </div>

    </div>
	<!-- 风险提示书 -->
	<div id="lay_wrap3"  class="v4-layer_wrap js-mask" data-modul="modul3"  style="display:none;">
		<div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask-bak"></div>
		<div class="Js_layer v4-layer">
			<a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
			<div class="v4-layer_title">风险提示书<a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask" style='display:none;'></a>
			</div>
			<div class="v4-layer_con riskAssessment-con">
				<p><strong>重要提示：</strong></p>
				<p>1、由于相关风险因素可能导致您的本金及收益全部或部分损失，因此，在您选择投资本网站发布的项目前，请仔细阅读本风险提示、网站公示信息、项目信息、电子合同（注册协议、借款合同、债权转让合同、产品交易类合同等）、第三方保障机构提供的电子担保函、承诺函等公示信息等。本风险提示书未涵盖全部风险因素，您仍需对其他可能存在的风险因素自行进行了解与评估。<br>
					2、“九斗鱼”平台不保证您的本金及收益，您可能损失全部本金且无法取得任何收益。<br>3、请您谨慎投资，如果您无法接受，请立即停止后续注册、投资操作。如您通过网络操作确认等方式继续进行交易，则视为您已仔细阅读本风险提示书并愿意自行承担由此产生的本息损失及风险。<br>4、投资前，请您先进行风险承受能力评估，并根据您的评估结果选择您可以投资的项目。评级结果所对应的可投项目如下：<br>（1）保守型，对应网站上标示为“保守型”的产品；<br>（2）稳健型，对应网站上标示为“保守型”、“稳健型”的产品；<br>（3）平衡型，对应网站上标示为“保守型”、“稳健型”、“平衡型”的产品；<br>（4）积极型，对应网站上标示为“保守型”、“稳健型”、“平衡型”、“积极型”的产品；<br>（5）激进型，对应网站上标示为“保守型”、“稳健型”、“平衡型”、“积极型、激进型”的产品；</p><br>
				<p><strong>尊敬的用户：</strong></p>
				<p>1、在您成为“九斗鱼”平台注册出借人前，请确认您具备以下条件，<br>（1）拥有非保本类金融产品投资的经历并熟悉互联网；<br>（2）向网络借贷信息中介机构提供真实、准确、完整的身份等信息；<br>（3）出借资金为来源合法的自有资金；<br>（4）了解融资项目信贷风险，确认具有相应的风险认知和承受能力；<br>（5）自行承担借贷产生的本息损失；<br>
					2、若您不具备以上条件，请您立即停止注册，并勿通过“九斗鱼”平台开展网络借贷活动。如果您仍继续后续操作进行注册程序，则视为您已确认您具备上述条件并自愿履行上述义务。<br>
					3、在您在“九斗鱼”平台进行出借（投资）过程中，可能会面临多种风险因素，包括但不限于借款人违约风险、第三方担保或第三方保障机构风险、政策风险、延期风险、信息传递风险、不可抗力风险。请您认真阅读本风险提示书，并依据自身风险承受能力、财务状况及投资理财经验自行决定是否对 “九斗鱼”平台发布项目进行投资。鉴于风险因素存在多样性、不确定性，本风险提示未包括所有风险，仅供您参考，请您谨慎投资，独立判断。<br>
					4、借贷关系的第一个风险是，借款人/出让人可能违约，因其自身财务状况紧张、投资失败、经营恶化等各种可能因素导致借款人/出让人无法按时足额支付本息/回购款，并且该违约将可能导致您的投资本息无法得到偿还。<br>
					5、“九斗鱼”平台上发布的借款项目，通常会有第三方专业担保公司担保或第三方准入机构（以下统称“第三方保障机构”）提供债权回购/买断等方式保障出借人的资金安全。但是，“九斗鱼”平台不保证出借人的投资本息均能得到偿还。如借款人逾期还款，第三方保障机构破产、依法撤销或遭遇行业限制及因其他因素导致无法实现资金本息保障的，则出借人的投资本息将可能无法得到偿还。<br>
					6、“九斗鱼”平台仅为借贷项目参与各方的借贷、担保、资金安全保障提供居间服务。“九斗鱼”平台自身不提供任何担保。“九斗鱼”平台在出借人与借款人/出让人或其它债权参与方之间的债权债务关系中不担任任何担保人或者保证人的角色。“九斗鱼”平台在服务过程中，任何文件、声明、说明、规则等均不应解释为“九斗鱼”平台提供任何形式的担保。 <br>
					7、借款人/出让人提出融资申请后，“九斗鱼”平台会对借款人/出让人申请的拟发布融资信息进行审核。目前国内信用征信体系尚不完善，“九斗鱼”平台不能完全保证发布信息的真实性、有效性、完整性。平台网站提供的信息资料仅供参考，最终是否进行投资，需要出借人、出借人综合考虑自身投资经验、风险承受能力、相关法律法规、金融知识及对网络金融现状的了解，进行独立判断，并自行承担由此产生的风险。<br>
					8、鉴于网络金融的特殊性，因技术故障、支付故障（银行、网关运营商、电信运营商服务技术障碍）、网络数据传输故障、网络安全、有权机关管制或限制等因素或其他不可抗力因素有可能导致出借人的投资本息延迟或损失。“九斗鱼”平台不担保服务不会中断，也不担保服务的及时性和/或安全性。系统因相关状况无法正常运作，使会员无法使用任何“九斗鱼”平台服务或使用任何“九斗鱼”平台服务时受到任何影响或损失的，“九斗鱼”平台对会员或任何第三方均不负任何责任。<br>9、出借人有可能面临因国家法律政策的出台或重大变化而遭受本金及收益损失。<br>
					10、出借人在“九斗鱼”平台进行交易过程中，请确保<br>
					（1）投资资金来源合法且有权进行出借处分；<br>
					（2）未使用非法资金进行投资或在“九斗鱼”平台洗钱；<br>
					（3）未使用非自有资金（包括但不限于银行贷款、从他人处筹措的资金等）进行投资；<br>
					（4）与借款人/出让人串通进行虚假的融资和投资。否则，因此所引发的任何纠纷均由您自行负责解决并承担相应责任。<br>
					11、“九斗鱼”平台发布的借贷项目可提前还款，借款人可在借款期间任何时候通过“九斗鱼”平台的提前还款功能提前偿还全部剩余借款。请您认真阅读电子借款合同中的提前还款条款，以合理判断预期收益。</p><br>
				<p>星果时代信息技术有限公司</p>
			</div>
			<div class="v4-riskAssessment-tips">
				<p><input type="checkbox" name="checkbox" id="checkbox"><label for="checkbox">本人已经认真阅读，完全理解，认可并接受以上全部内容。</label></p>
				<p><a href="javascript:;" class="v4-input-btn disable" id="checkbox-link">开始评估</a></p>
			</div>
		</div>
	</div>
</div>


<!-- 交易密码设置弹窗 -->
<div class="v4-layer_wrap js-mask" data-modul="modul1"  style="display:none;" >
    <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
    <div class="Js_layer v4-layer v4-layer1">
        <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
        <div class="v4-layer_0 v4-layer_trun">
            <p class="v4-layer-normal-icon v4-layer-success-icon"><i class="v4-icon-20 fail v4-iconfont">&#xe69d;</i></p>
            <p class="v4-layer_text">请先设置交易密码</p>
            <a href="#" class="v4-input-btn" id="outRetBut">设置交易密码</a>
        </div>
    </div>
</div>	
@endsection

@section('jspage')
<script src="{{assetUrlByCdn('/assets/js/pc4/layer.js')}}" type="text/javascript"></script>
<script>
$(function(){
	// 评估
	$('#checkbox').click(function(){
		if($(this).prop('checked')){
			$('#checkbox-link').attr("href","/user/riskAssessment");
			$('#checkbox-link').removeClass('disable');
		}else{
			$('#checkbox-link').attr("href","javascript:;");
			$('#checkbox-link').addClass('disable');
		};

	})
})
</script>
@endsection
