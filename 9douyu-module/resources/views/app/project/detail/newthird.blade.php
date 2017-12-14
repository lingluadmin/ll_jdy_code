@extends('wap.common.appBase')
@section('title','项目详情')
@section('content')
	<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/css/wap.css') }}">
	<article>
		<div class="t-coupon">
			<h3 class="t-detail"><span class="t-icon1"></span>{{ $project["name"] }} {{$project['format_name']}}</h3>
			<div class="t-detail-2">
				<table class="t-detail-1">
					<tr>
						<td width="36%">期待年回报率</td>
						<td>{{ $project["percentage_float_one"] }}%</td>
					</tr>
					<tr>
						<td>期限</td>
						<td>{{ $project["format_invest_time"] }}{{ $project["invest_time_unit"] }}</td>
					</tr>
					<tr>
						<td>预计到期日</td>
						<td>{{ $project["refund_end_time"] }}</td>
					</tr>
					<tr>
						<td>起购金额</td>
						<td>{{ $project["invest_min_cash"] }}元起投</td>
					</tr>
					<tr>
						<td>还款方式</td>
						<td>{{ $project["refund_type_text"] }}</td>
					</tr>
					<tr>
						<td>赎回</td>
						@if( $project['refund_type'] != 40 && $project['is_credit_assign'] == 1 &&  $project['assign_keep_days']>0)
							@if( $project['pledge'] == 2 )
								<td><p>持有项目{{$project['assign_keep_days']}}天后可转让，仅支持单笔出借金额一次性全额转让；每日15点为转让结息时间，如在15点前（不含）出借成功，隔日转让成功后，计算1天收益；如15点后（含）出借成功，隔日15点前转让成功，将不计算利息，只返还本金；如隔日15点后转让成功，将计算1天收益。</p></td>
							@else
								<td><p>持有项目{{$project['assign_keep_days']}}天及以上，可申请转让变现（本金回款当日不可转让），仅支持单笔出借金额一次性全额转让</p></td>
							@endif
						@else
							<td><p>不支持转让</p></td>
						@endif
						{{--<td>
							<p>到期后本金和利息自动返还至账户余额，申请提现即可转入绑定的银行卡中</p>
						</td>--}}
					</tr>

				</table>
			</div>
		</div>

		<div class="t-coupon">
			<h3 class="t-coupon-1"><span class="t-icon1"></span>项目描述</h3>
			<div class="t-coupon-2">
				{!! $company['project_desc'] or '' !!}
				<p>
					点击<a href="/app/project/credit/detail/{{$project['id']}}" class="w-bule-color">借款人详情</a>可以查看部分借款人信息，如需查看全部，需进行投资。
				</p>
			</div>

		</div>
		<div class="t-coupon">
			<h3 class="t-coupon-1"><span class="t-icon1"></span>风险控制</h3>
			<div class="t-coupon-2">
				<p class="t-detail-14">
					{!! $company['risk_control'] or '' !!}
				</p>
			</div>

		</div>
	</article>

@endsection
@section('jsPage')
	<script type="text/javascript">
		$(document.body).css("background","#f4f4f4");
	</script>
@endsection
