<?php
$loginUser = isset($data['loginUser']) ? $data['loginUser'] : null;
$project   = isset($data['project']) ? $data['project'] : null;
$credit	   = isset($data['credit'][0]) ? $data['credit'][0] : null;
$credit	   = $credit == null && isset($data['credit']) ? $data['credit'] : $credit;
$signDay   = isset($data['signDay']) ? $data['signDay'] : null;
$principal   = isset($data['principal']) ? $data['principal'] : null;
$invested  = isset($data['invested']) ? $data['invested'] : null;
$investing = isset($data['investing']) ? $data['investing'] : null;
$refundTime= isset($data['refundTime']) ? $data['refundTime'] : null;
$refundPlan= isset($data['refundPlan']) ? $data['refundPlan'] : null;
$matchResult= isset($data['matchResult']) ? $data['matchResult'] : null;
?>
<div style="position:absolute;top:5%;right:5%;z-index:1;background-image: url('{{ env('APP_URL_PC') }}/static/img/seal_ebq.png'); background-repeat: no-repeat; height: 150px;width:150px; background-position: center center;background-size: cover;"></div>
<h2 style="text-align: center;">
	<span>借款协议</span>
</h2>
<p>
	<span>甲方（出借人）：{{ $loginUser['real_name'] or null }}</span>
</p>
<p>
	<span>身份证号：{{ $loginUser['identity_card'] or null }}</span>
</p>
<p>
	<span></span>
</p>
<p>
	<span>乙方（借款人）：见合同借款人详情 </span>
</p>
{{--<p>
	<span>证照号码：91110229MA0051RLOD</span>
</p>--}}
<p>
	<span></span>
</p>
<h2 style="text-align: center;">
	<span>第一部分: 借款明细</span>
</h2>
<?php
$loan_username = $loan_user_identity = [];
if(!empty($credit['loan_username']) && !empty($credit['loan_user_identity'])){
	$loan_username 		 = explode(',', $credit['loan_username']);

	$loan_user_identity  = explode(',', $credit['loan_user_identity']);

}?>
<table border="1">
	<tbody>
		<tr>
			<td colspan="3" align="center">出借人详情</td>
		</tr>
		<tr>
			<td align="center">姓名/名称</td>
			<td align="center">身份证号</td>
			<td align="center">出借本金金额</td>
		</tr>
		<tr>
			<td rowspan="" align="center">{{ $loginUser['real_name'] or null }}</td>
			<td align="center">
				{{ $loginUser['identity_card'] or null }}
			</td>
			<td align="center">
                <?php echo isset($refundPlan['principal']) ? \App\Tools\ToolMoney::moneyFormat($refundPlan['principal']) : null; ?>
           </td>
		</tr>
	</tbody>
</table>
<table class="ke-zeroborder" border="0">
	<tbody>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
<table border="1">
	<tbody>
		<tr>
			<td colspan="4" align="center">借款人详情</td>
		</tr>
		<tr>
			<td align="center">序号</td>
			<td align="center">姓名/名称</td>
			<td align="center">身份证号</td>
			<td align="center">借款本金金额</td>
		</tr>
	    @foreach($matchResult as $key => $value)
			<tr>
				<td align="center">{{ $key+1 }}</td>
				<td align="center">{{ $value['name'] }}</td>
				<td align="center">{{ $value['id_card'] }}</td>
				<td align="center">@if(!empty($value['used_amount'])) {{ \App\Tools\ToolMoney::moneyFormat($value['used_amount']) }} @endif</td>
			</tr>
		@endforeach
		<tr>
			<td colspan="1" align="center">共计</td>
			<td colspan="3" align="center">
                <?php echo isset($refundPlan['principal']) ? \App\Tools\ToolMoney::moneyFormat($refundPlan['principal']) : null; ?>
 元</td>
		</tr>
	    <tr>
			<td colspan="1" align="center">借款用途</td>
			<td colspan="1" align="center">个人消费</td>
			<td colspan="1" align="center">借款利率</td>
			<td colspan="1" align="center"><?php echo isset($project['profit_percentage']) ? $project['profit_percentage'] : null; ?> %/年</td>
		</tr>
	    <tr>
			<td colspan="1" align="center">借款期限</td>
			<td colspan="1" align="center"><?php echo isset($project['invest_time_note']) ? $project['invest_time_note'] : null; ?></td>
			<td colspan="1" align="center">还款方式</td>
			<td colspan="1" align="center"><?php echo isset($project['refund_type_note']) ? $project['refund_type_note'] : null; ?></td>
		</tr>
		<tr>
			<td colspan="1" align="center">起息日</td>
			<td colspan="3" align="center">{{$signDay or null}}</td>
		</tr>
		<tr>
			<td colspan="1" align="center">还款日</td>
			<td colspan="3" align="center">每月<?php echo date('d 日', strtotime($refundTime)); ?>(16:00之前）</td>
		</tr>
	</tbody>
</table>
{{--<table border="1">
	<tbody>
	<tr>
		<td>每月还款金额</td>
		<td>
			<table>
				<tr>
					@foreach()

				</tr>
				<tr>

				</tr>
			</table>
		</td>
	</tr>
	</tbody>
</table>--}}

<h2 style="text-align: center;">
	<span>第二部分: 借款的一般性条款、条件</span>
</h2>
<p>
	<span>一、 协议各方</span>
</p>
<p>
	<span>1.《借款协议》（"本协议"）由两部分组成：第一部分为"借款明细"；第二部分为"借款的一般性条款、条件"。</span>
</p>
<p>
	<span>2. 借款人，指"借款明细"中列明的借款人，为符合中华人民共和国法律（"中国法律"，仅为本协议之目的，不包括香港特别行政区、澳门特别行政区和台湾 省的法律法规）规定的具有完全民事权利能力和民事行为能力，独立行使和承担本协议项下权利义务的自然人或企业、实体。借款人为星果时代信息技术有限公司（以下简称“星果时代”）网络借贷平台（本协议中简称“九斗鱼平台”）的注册用户。
；</span>
</p>
<p>
	<span>3. 出借人，指"借款明细"中列明的出借人，为符合中国法律规定的具有完全民事权利能力和民事行为能力，独立承担本协议项下权利义务的自然人或根据中国法律依法审理的公司、企业或其它组织（包括但不限于经济组织）。出借人亦为九斗鱼的注册用户。
</span>
</p>
<p>
	<span>4. 本协议项下借款人和出借人单独称"一方"，合称"各方"。</span>
</p>
<p>
	<span>二、 借款</span>
</p>
<p>
	<span>1. 本次借款的相关要素见第一部分“借款明细”。
</span>
</p>
<p>
	<span>2. 出借人通过九斗鱼以网络在线点击确认的方式接受本协议后，即不可撤销地授权九斗鱼或九斗鱼委托的第三方公司将金额等同于"借款明细"中列明的借款本金金额的资金由出借人九斗鱼用户名项下账户（"出借人九斗鱼账户"）划转至借款人九斗鱼用户名项下账户（"借款人九斗鱼账户"）中，划转完毕即视为借款发放成功。</span>
</p>
<p>
	<span> 三、还款</span>
</p>
<p>
	<span>1. 借款人应承担如下还款义务：<br/>
		(1)	借款人应按时足额向出借人支付本金和利息；<br/>
        (2)	如发生逾期还款，借款人需按本协议约定向出借人支付逾期罚息；借款人应归还的上述款项统称为"应付款项"。
</span>
</p>
<p>
	<span>2. 本协议项下借款的还款方式及计算公式如下：<br/>
		  1)等额本息：等额本息还款法是一种被广泛采用的还款方式，还款期内，借款人每月按相等的金额偿还借款本息，其中每月利息按上月结算剩余本金计算，并逐月结清，借款人每月还款额中的本金比重逐月递增、利息比重逐月递减。<br/>

          计算公式： 每月还款额=[贷款本金×月利率×（1+月利率）^还款总期数]÷[（1+月利率）^还款总期数-1]<br/>

          2)先息后本：本义为先还利息再还本金。还款方式是指每月按期归还当期利息，最后一期归还当期利息和所有本金的还款方式<br/>
          计算公式：到期收益=（出借本金*出借利率）×期限（月）/12个月<br/>

		  因计算中存在四舍五入，最后一期还款金额与之前略有不同。
</span>
</p>
<p>
	<span>3. 借款人应在还款日支付当期应付款项。

本协议下借款人款方式及金额见第一部分借款明细。 </span>
</p>
<p>
	<span>四、 逾期还款 </span>
</p>
<p>
	<span>1. 还款日24点前，借款人未足额支付应付款项的，则视为逾期。</span>
</p>
<p>
    <span>2. 本协议项下还款方式为等额本息，借款人逾期的，逾期款项中的借款本金部分(指的是逾期当期应还未还本金)自逾期之日起按本协议约定的借款利率的0.1%按日计收逾期罚息直至清偿完毕之日止(不含清偿完毕之日)。逾期罚息不计复利。</span>
</p>
<p>
	<span>3. 各方确认并同意，自借款人逾期之日起  日的期间为逾期宽限期（"宽限期"）。在宽限期内，若借款人成功还款，则免除借款人应缴纳的逾期罚息；若借款人 超过宽限期还款的，除应支付本金、利息外，借款人应支付自逾期之日起起至清偿完毕之日（不含清偿完毕之日）止期间的逾期罚息。
</span>
</p>
<p>
	<span>4. 借款人在发生逾期后又进行还款的，如借款人的还款金额不足以足额清偿全部到期应付款项的，借款人应按如下顺序支付应付款项：<br/>

(1)	单期还款：当借款人仅有一期应付款项未按时全额支付时，其还款资金支付顺序依次为：A. 截止到该还款日的逾期罚息； B. 利息； C. 本金。<br/>
(2)	多期还款：当借款人存在多期应付款项未按时全额支付时，其还款资金从拖欠时间最长的应付款项开始支付，依次（期）偿还；同一期应付款项的支付顺序均为：A. 截止到该还款日的逾期罚息； B. 利息； C. 本金。<br/>

在借款人采用"委托还款"功能还款时，星果时代或其委托的第三方应按照上述支付顺序划转（代扣）借款人的还款资金。

</span>
</p>
<p>
	<span>5. 逾期款项中的利息、逾期罚息不计利息。


</span>
</p>
<p>
	<span>6. 借款人不可撤销地授权星果时代或星果时代委托的第三方在借款人未能按时足额支付应付款项的情况下，在借款人全部到期应付款项的范围内，随时划扣借款人九斗鱼账户及其指定银行账户中的资金用于归还借款人到期应付款项，该等划扣无需借款人另行同意。

</span>
</p>
<p>
	<span>7. 若借款人对任何一期应付款项逾期满20日的，则本协议项下全部借款于该期应付款项逾期第21日当日全部提前到期；该期借款逾期未满21日但已届最终到期日的，仍以最终到期日为全部借款到期日。


</span>
</p>
<p>
	<span>8. 若借款人任何一期应付款项逾期超过20日（含）的，经催讨后依然未还的，借款人明确理解并同意，星果时代有权向公众披露其逾期情况和相关信息，包括但不限于姓名、性别、身份证号（生日部分以星号代替）、剩余未还本金、逾期天数等信息，对因披露前述信息可能造成的损失，九斗鱼不承担任何责任。


</span>
</p>
<p>
	<span>五、管理及代偿 </span>
</p>
<p>
	<span>1.	本协议各方同意，在此不可撤销地授权星果时代对本协议项下交易的管理权，包括但不限于：（1）作为出借方的合法代理人，采取措施促成本协议项下借款偿还等相关事宜；（2）在借款人违约时或依其判断可能违约时，采取措施依法催收；和（3）对借款人偿还的款项采取依其判断合适的措施进行管理。由此保证出借方借款债权以及资金安全，促成本协议如期履行。
	</span>
</p>
<p>
	<span>2.	本协议各方同意，在此不可撤销地授权星果时代,在借款人未按时偿还债务或依其独立判断（任何情况下均不需对其判断的合理性和依据提供证明）可能不能偿还债务时，可全权代理本协议各方与任何第三方立刻达成代偿协议，由第三方承担代偿责任。如在约定还款日借款人未按时还款，该承担代偿义务的第三方应在约定还款日次日立即向出借人的账户转入等同于借款人当期应还的借款本息的金额。此后，该第三方受让出借人对借款人当期的债权。</span>
</p>
<p>
	<span>3. 该第三方根据上述规定承担代偿责任后，本协议各方在本协议项下当期的所有权利视为已经得到满足和实现，出借人不得就当期借款本息再对借款人提出请求或主张。出借人在本协议下所享的关于当期债权的全部权利和主张，包括但不限于对借款本息、补偿金、综合服务费等所享有权利和主张，均由该第三方享有。同时，该第三方有权向借款人进行追偿，本协议各方应提供合理及必要的协助。该第三方有权以诉讼、债权转让等方式处理出借人对借款人的债权。</span>
</p>
<p>
	<span>六、借款的转让</span>
</p>
<p>
	<span>1. 经星果时代同意，出借人可将本协议项下的全部或部分借款债权（"借款债权"）转让予第三人，但该等第三人必须为在九斗鱼的注册用户（《中华人民共和国继承法》另有规定的除外）。
</span>
</p>
<p><span>
		2. 各方同意并确认，若出借人转让其借款债权的，出借人授权九斗鱼平台视情况(在星果时代认为必要时)将借款债权转让交易通知借款人。星果时代应当以书面形式（包括但不限于电子邮件等方式）作出关于借款债权转让交易的通知，该等通知构成合法、有效的债权转让通知；且一经作出，相关债权转让即对借款人发生法律效力。
	</span>
</p>
<p><span>
		3. 出借人根据本协议转让借款债权的，本协议项下其他条款不受影响，且变更内容对借款人仍有约束力：
	</span>
</p>
<p><span>
		4. 各方同意并确认：借款债权必须通过九斗鱼的"债权转让"功能进行转让或委托九斗鱼通过其他方式进行。
	</span>
</p>
<p>
	<span>七、违约 </span>
</p>
<p>
	<span>1. 借款人违反本协议"借款的一般性条款、条件"的，或未经出借人同意，擅自转让本协议借款债务的，借款人应向出借人支付借款本金金额10%的款项作为不如实告知违约金。
	</span>
</p>
<p>
	<span>2. 发生下列任何一项或几项情形的，视为借款人违约：<br/>
a )	借款人违反其在本协议所做的任何承诺和保证的；<br/>
b )	借款人的任何财产遭受没收、征用、查封、扣押、冻结等可能影响其履约能力的不利事件，且不能及时提供有效补救措施的；<br/>
c )	借款人的财务状况出现影响其履约能力的不利变化，且不能及时提供有效补救措施的。<br/>
</span>
</p><p>
	<span>3. 若借款人违约或根据出借人合理判断借款人可能发生违约事件的，出借人（委托九斗鱼）有权采取下列任何一项或几项救济措施：<br/>
a )	立即暂缓、取消发放全部或部分借款；<br/>
b )	宣布已发放借款全部提前到期，借款人应立即偿还所有应付款项；<br/>
c )	解除本协议；<br/>
d )采取法律、法规以及本协议约定的其他救济措施。</span>
</p>
<p>
    <span></span>
</p>
<p>
	<span>八、证据和计算
</span>
</p>
<p>
	<span>本协议各方确认并同意，委托九斗鱼对本协议项下的任何金额进行计算；在无明显错误的情况下，九斗鱼对本协议项下任何金额的任何证明或确定，应作为该金额有关事项的终局证明。
 </span>
</p>
<span>九、信息传递和保密条款
 </span>
</p>
<p>
	<span>1.	借款人兹不可撤销地授权九斗鱼将其信息，包括但不限于姓名/名称、有效证件号码等所有与本次借款相关的材料，为本协议项下之目的提供给出借人。
	</span>
</p>
<p>
	<span>2.	出借人不可撤销地授权九斗鱼将其信息，包括但不限于姓名/名称、有效证件号码等，为本协议项下之目的提供给借款人。</span>
</p>
<p>
	<span>3.	本协议项下各方同意并承诺，本协议项下各方提供的信息均应在提供给本协议其他各方的同时提供给九斗鱼。本协议各方授权九斗鱼根据本协议任意一方的合理要求向其提供本协议各方向九斗鱼提供的所有信息。</span>
</p>
<p>
	<span>
		4.	根据本协议所作的任何通知和信息传递，均可通过出借人和借款人在九斗鱼平台网站注册时填写的邮箱发送和传递。信息传递和通知在发送到借款人和/或者出借人邮箱时即视为通知已经送达。出借人和/或者借款人不得以未接到通知为由拒绝履行本协议下的任何义务。
	</span>
</p>
<p>
	<span>
		5.	本协议签署后, 除非事先得到另两方的书面同意, 本协议各方均应承担以下保密义务：<br/>
(1)	任何一方不得向非本协议方（九斗鱼除外）披露本协议以及本协议内容以及与本协议内容有关的任何文件、资料或信息（"保密信息"）；<br/>
(2)	除了将保密信息和其内容用于本协议所约定的目的外, 不得将其用于任何其他目的。为执行本协议的目的，本款的约定不适用于下列信息：<br/>
&nbsp;&nbsp;&nbsp;&nbsp;A. 从披露方获得时，已是公开的；<br/>
&nbsp;&nbsp;&nbsp;&nbsp;B. 从披露方获得前，接受方已经获知的；<br/>
&nbsp;&nbsp;&nbsp;&nbsp;C. 从有正当权限并不受保密义务制约的第三方获得的；或者<br/>
&nbsp;&nbsp;&nbsp;&nbsp;D. 非依靠披露方披露或提供的信息独自开发的信息。<br/>
	</span>
</p>
<p>
	<span>
		6.	本协议各方有权向本协议各方的董事、监事、高级管理人员和雇员及其聘请的会计师、律师、咨询公司披露保密信息，不因此承担违约责任。
	</span>
</p>
<p>
	<span>
		7.	本协议各方兹确认，除法律有另外规定除外，借款人和出借人提供给九斗鱼的信息及借款人和出借人享受九斗鱼服务产生的信息（包括本协议签署之前提供和产生的），可由星果时代永久享有。

各方在本条项下的权利和义务应在本协议终止或到期后继续有效。
	</span>
</p>
<p>
<span>十、法律适用和管辖 </span>
</p>
<p>
	<span>本协议的效力、解释、变更、执行与争议解决均适用中华人民共和国法律。凡因本合同引起的或与本合同有关的任何争议，均应提交九斗鱼所在地的法院解决。在争议解决期间，本协议不涉及争议的部分且实际可以履行的条款仍须继续履行。
	</span>
</p>
<p>
	<span>
		十一、	其他
	</span>
</p>
<p>
	<span>
		1.	九斗鱼借款人和出借人均同意并确认，借款人和出借人通过其九斗鱼账户和银行账户采取的行为所产生的法律效果和法律责任归属于借款人和出借人本身；借款人和出借人授权和委托九斗鱼和九斗鱼委托的第三方根据本协议所采取的全部行动和措施的法律后果均归属于借款人和出借人本身，与九斗鱼或九斗鱼委托的第三方无关，九斗鱼或九斗鱼委托的第三方也不因此承担任何责任。借款人和出借人同意，九斗鱼有权就其为借款人和出借人提供的平台服务收取服务费。
</span>
</p><p>
	<span>
		2.	出借人和借款人为资金托管之目的，双方将各自姓名、身份证号码及名下任一在用银行卡账号不可撤销地授权星果时代提交给资金托管银行，以便为其开设账户，供资金托管使用。
	</span>
</p><p>
	<span>
		3.	借款人在此不可撤销地同意星果时代委托合作的支付机构直接从借款人帐户扣划相应金额用于支付借款人应付的平台管理费、利息、违约金及其他费用。出借人在此不可撤销地同意委托星果时代合作的支付机构从借款人支付的利息中扣划本协议第一部分列明的平台服务费给星果时代。
	</span>
</p><p>
	<span>
		4.	借款人在申请及实现借款的全过程中，必须如实向星果时代提供所要求提供的个人信息及材料；借款人同意星果时代可以通过任何第三方渠道验证借款人所提供信息的真实性，且借款人应在所提供信息被认定为虚假时承担所有后果和法律责任。
	</span>
</p><p>
	<span>
		5.	自本协议成立之日起至所有本息、本协议列明的各项服务费用、平台服务费、及违约金（如有）全部清偿前，出借人和借款人及双方的本人、家庭联系人及紧急联系人的工作单位、居住地址、住所电话、手机号码、账户信息如出现变更的，应在变更后三日内通过九斗鱼向其他各方提供变更后的最新信息。若因任何一方未及时提供最新信息或提供虚假信息而导致其自身和/或任何其他方遭受的损失均由该未及时提交真实信息的一方承担。
	</span>
</p><p>
	<span>
		6.	本协议经出借人和借款人通过九斗鱼以网络在线点击确认的方式书面确认的方式订立。本协议各方委托九斗鱼保管所有与本协议有关的书面文件或电子信息；本协议各方确认并同意由九斗鱼提供的与本协议有关的书面文件或电子信息在无明显错误的情况下应作为本协议有关事项的终局证明。
	</span>
</p>
<p>
	<span>
		<br />
	</span>
</p>

<p>
	<span>甲方（债权购买人）：{{ $loginUser['real_name'] or null }}</span>
</p>
{{--<div style="background-image: url('{{ env('APP_URL_PC') }}/static/img/seal_xiaodai.png'); background-repeat: no-repeat; height: 170px; background-position: 50px 0px;">--}}

<p>
	<span>乙方（债权出让人）：见合同借款人详情</span>
</p>
</div>
<div style="background-image: url('{{ assetUrlByCdn('static/img/seal_xingguo.png') }}'); background-repeat: no-repeat; height: 100px; background-position: 30px 0px;">

<p>
	<span>丙方（平台服务方）：星果时代信息技术有限公司 </span>
</p>
</div>
