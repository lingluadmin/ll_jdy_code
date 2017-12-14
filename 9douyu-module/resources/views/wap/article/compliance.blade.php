@extends('wap.common.wapBaseNew')

@section('title', '安全保障')

@section('keywords', "{{env('META_KEYWORD')}}")

@section('description', "{{env('META_DESCRIPTION')}}")
@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/activity/security/css/index.css')}}">
@endsection

@section('content')
<article class="security-wap">
    <nav class="v4-nav-top">
        <a href="javascript:void(0)" onclick="window.history.go(-1);"></a>安全保障
    </nav>
    <ul class="security-nav">
        <li><a href="/article/security">银行存管</a></li>
        <li class="cur"><a href="/article/compliance">平台合规</a></li>
        <li><a href="/article/riskManagement">权威风控</a></li>
    </ul>
    <div class="compliance-banner"></div>
    <div class="compliance-1">
        <img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon.png')}}" class="img">
        <p class="compliance-text">2017年7月，九斗鱼正式携手江西银行达成资金存管合作，双方启动系统技术对接。存管系统上线后，用户资金将全部迁移至银行存管系统开设的对应独立账户，交易流程更真实，用户资金更安全。</p>   
    </div>
    <div class="security-box compliance-2">
        <h4 class="custody-title1">行业权威机构认证</h4>
        <p class="compliance-title1">已获多个国家级金融协会认证资质</p>
        <dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon1.png')}}"></dt>
            <dd>
                <h4>ICP</h4>
                <p>工信部核发《中国人民共和国电信与信息服务业务经营许可证》</p>
            </dd>
        </dl>
        <dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon2.png')}}"></dt>
            <dd>
                <h4>AA企业信用评级</h4>
                <p>《企业信用评级证书》</p>
            </dd>
        </dl><dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon3.png')}}"></dt>
            <dd>
                <h4>等保三级认证</h4>
                <p>公安部核发《信息系统安全等级保护三级》认证</p>
            </dd>
        </dl>
    </div>
        <div class="security-box security-content compliance-contant">
                <h4 class="custody-title1">完备法律保障机制</h4>
                <dl>
                    <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon4.png')}}" class="img"></dt>
                    <dd>
                        <h4>法律保障</h4>
                        <p>九斗鱼与盈科律师事务所建立战略合作，为九斗鱼提供行业合规相关的法律支持工作，并向监管部门出具法律意见，保障平台业务流程及所有法律合同合法合规，并受法律保护。</p>
                    </dd>
                </dl>
                <dl>
                    <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon5.png')}}" class="img"></dt>
                    <dd>
                        <h4>电子签章</h4>
                        <p>九斗鱼与易保全建立合作，为平台交易电子合同提供电子签章服务。电子签章是基于数字证书的应用，数字证书具备唯一性，无法被篡改、被仿造，可以解决电子合同的有效性问题。</p>
                    </dd>
                </dl>
                <dl>
                    <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon6.png')}}" class="img"></dt>
                    <dd>
                        <h4>合同保全</h4>
                        <p>资金存管上线后，江西银行为“鱼客”和借款人开设独立的资金存管账户，所有涉及资金变动的操作都由“鱼客”发出的授权交易码为准，平台无权动用资金，保障资金安全。</p>
                    </dd>
                </dl>
        </div>

</article>
<script type="text/javascript" src="{{assetUrlByCdn('/static/weixin/js/jquery-1.9.1.min.js')}}"></script>
<script>
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
