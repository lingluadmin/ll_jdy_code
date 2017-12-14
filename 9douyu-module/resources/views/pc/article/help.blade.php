@extends('pc.common.layoutNew')
@section('title',$current['title'])
@section('content')
   <div class="v4-account">
        @include('pc.article.helpnav')
       {!! $current['content'] !!}
        {{--<div class="v4-content v4-account-white">
            <h2 class="v4-account-titlex v4-help-title">{{ $current['title'] }}</h2>

        </div>--}}
    </div><!--v4-account -->
    <div class="clear"></div>
@endsection
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/toggleContent.js')}}"></script>
<script type="text/javascript">
  $(function(){
    $('h3.v4-help-head').toggleContent('div.v4-help-body');
  })
</script>
@endsection

{{--
<div class="v4-content v4-account-white">
    <h2 class="v4-account-titlex v4-help-title">九斗鱼平台</h2>
    <div class="v4-help-wrap">
        <div class="v4-help-content">
            <h3 class="v4-help-head">九斗鱼平台是什么？</h3>
            <div class="v4-help-body">
               <p>九斗鱼（www.9douyu.com）是耀盛中国旗下的互联网金融平台，依托耀盛强大的集团实力和11年的金融行业经验，为出借人提供安全、有保障的互联网金融服务平台。</p>
            </div>
        </div>
        <div class="v4-help-content">
            <h3 class="v4-help-head">九斗鱼有哪些产品，投资门槛高吗？</h3>
            <div class="v4-help-body">
               <p>A：九斗鱼（www.9douyu.com）是耀盛中国旗下的互联网金融平台，依托耀盛强大的集团实力和11年的金融行业经验，为出借人提供安全、有保障的互联网金融服务平台。</p>
               <p>目前我们共有二类产品：<br>
               1）零钱计划：1元起投，灵活变现，随时申请转出，借款利率6%；<br>
               2）优选项目：借款期限1~12个月，借款利率9~12%。</p>
            </div>
        </div>
        <div class="v4-help-content">
            <h3 class="v4-help-head">如何在九斗鱼投资？</h3>
            <div class="v4-help-body">
               <p>简单五步，玩转九斗鱼<br>
               第一步，注册九斗鱼账号：填写手机号、设置密码、填写手机验证码，完成注册；<br>
               第二步，身份认证：填写姓名、身份证号、银行卡信息，设置交易密码（交易密码不同于银行卡交易密码），完成认证；<br>
               第三步，充值：选择网上银行充值或快捷支付充值，输入金额，填写银行验证信息，确认支付；<br>
               第四步：投资与回款：选择可投资产品，输入投资金额，确认交易信息，确认投资，坐等收益到账；<br>
               第五步，提现：当可用余额大于100元即可提现，输入提现金额，确认提现手续费（每月有四次免费提现，超出四次，每笔收取5元提现手续费），申请提现；款项将于下一个工作日到账。

               </p>
            </div>
        </div>
        <div class="v4-help-content">
            <h3 class="v4-help-head">九斗鱼如何保障风险？</h3>
            <div class="v4-help-body">
               <p>平台上所有的借款项目都经过严格的风控体系筛选:<br>
               1）在借款人申请借款时，通过对借款人提交的多个维度数据信息（主要包括：身份信息，工作单位，家庭信息，信用记录、财产情况等）使用大数据挖掘技术进行反欺诈和信用评分；<br>
               2）同时使用国内先进的风控体系来核查企业征信，在大数据公司进行数据共享的基础上，利用丰富的数据源和成熟的征信工具，实现对借款人更精准的信用评级及更合理的风险定价。
               </p>
            </div>
        </div>
        <div class="v4-help-content">
            <h3 class="v4-help-head">什么是电子签章？</h3>
            <div class="v4-help-body">
               <p>合同保全是为金融及类金融企业量身定制的一款保全产品，解决了网上交易客户的身份识别问题， 加密传输并保全电子合同内容，可以防止内容泄露及篡改。</p>
            </div>
        </div>
        <div class="v4-help-content">
            <h3 class="v4-help-head">什么是合同保全？</h3>
            <div class="v4-help-body">
               <p>合同保全是为金融及类金融企业量身定制的一款保全产品，解决了网上交易客户的身份识别问题， 加密传输并保全电子合同内容，可以防止内容泄露及篡改。</p>
            </div>
       </div>
    </div>
</div>
             --}}