@extends('wap.common.wapBase')

@section('title','项目详情')
@section('css')
@endsection
@section('content')
    <article>
        <nav class="v4-nav-top">
            <a href="javascript:void(0)" onclick="window.history.go(-1);"></a>项目详情
        </nav>
        <section class=" mt1 mb1">
            <table class="wap2-table-5">
                    <tr>
                        <td width="20%" class="tc">项目介绍</td>
                        <td>零钱计划是九斗鱼平台为出借人推出的优质小额债权组合；出借人加入后，资金将分散匹配多个优质小额债权项目，每日结算的利息也将自动复投到零钱计划中，让您享受资金不站岗天天拿收益。</td>
                    </tr>
                    <tr>
                        <td class="tc">收益</td>
                        <td>出借当日开始计息，卖出当日不计息（次日0点结算当日收益）</td>
                    </tr>
                    <tr>
                        <td class="tc">转入限额</td>
                        <td>单人转入限额 {{$invest_max/10000}} 万元（包括回款本息自动转入部分） </td>
                    </tr>
                    <tr>
                        <td class="tc">转出限额</td>
                        <td>10万元+当日自动加入金额，且不超过当日转出总限额</td>
                    </tr>
                    <tr>
                        <td class="tc">收益计算</td>
                        <td>收益复投：例如您今天投资10000元，按{{$rate['rate'] or 7 }}%年化收益，次日0点将获得1.9元收益，次日将以10001.90元本金计算收益，如不进行转出，依次类推将享受利息复利收益。</td>
                    </tr>
                    <tr>
                        <td class="tc">持有限额</td>
                        <td>每个账户持有金额上限为 {{$invest_max/10000}} 万元</td>
                    </tr>
                </table>
        </section>
        <section class="wap2-current-info">
            <div class="wap2-current-info-title">
                常见问题？
            </div>
            <dl class="wap2-current-info-main">
                <dt>1.什么是零钱计划？</dt>
                <dd>
                    零钱计划是九斗鱼平台为出借人推荐优质债权组合，1元即可投资，出借人可随时申请加入转出。
                </dd>
                <dt>2.怎么加入零钱计划？</dt>
                <dd>
                    <p>2.1、登录九斗鱼账户，选择零钱计划并输入加入金额，可将账户余额（整数部分）转入到零钱计划中，享受资金不站岗天天拿收益。</p>
                    <p>2.2、九斗鱼会将您当日回款的本息（整数部分）自动加入零钱计划，可享受时时刻刻拿收益。</p>
                </dd>
                <dt>3.为什么我申请转出零钱计划的时候，可转出金额小于账户零钱计划总额？</dt>
                <dd>
                    <p>可能是由于以下两种情况造成的：</p>
                    <p>3.1、单人单日转出限额为“10万+当日自动加入零钱计划的金额“（例如：今日用户回款后自动加入零钱计划20万，则今日转出限额为10+20=30万元），当日累计转出金额达到当日限额后则需要在次日继续转出。</p>
                    <p>3.2、为避免平台发生流动性风险，系统设置每日转出总额度为“全部用户持有的零钱计划总额的20%＋当日全部用户自动加入零钱计划的金额”，一旦当日转出额度用尽，用户无法申请转出，在次日开放新的转出额度后可重新申请转出零钱计划。</p>
                </dd>
                <dt>4.可以设置自动加入零钱计划吗？</dt>
                <dd>每日回款金额（整数部分）自动加入零钱计划，账户余额暂不支持自动转入零钱计划。</dd>
                <dt>5. 什么时候开始计息？什么时候可以提取收益？</dt>
                <dd>加入当日计息，用户每日的收益在次日凌晨00:00计算并发放至零钱计划总额中，零钱计划总额大于0.01元时都可以申请转出，不受时间限制。</dd>
                <dt>6.我加入零钱计划的收益怎么计算？</dt>
                <dd><p>我们的收益每日计算，次日0点返还至零钱计划总额：</p>
                <p>当日收益＝当日零钱计划总额（每日24点结算）＊借款利率／365
注意：每日收益四舍五入后不足0.01元不计入零钱计划账户。</p></dd>
            </dl>
        </section>
        
    </article>
@endsection
@section('jsScript')
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                var client = getCookie('JDY_CLIENT_COOKIES');
                if(client == 'ios' || client == 'android'){
                    $(".v4-nav-top").hide();
                }
            });
        })(jQuery);
    </script>
@endsection