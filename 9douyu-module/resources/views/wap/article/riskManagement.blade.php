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
        <li><a href="/article/compliance">平台合规</a></li>
        <li class="cur"><a href="/article/riskManagement">权威风控</a></li>
    </ul>
    <div class="risk-banner"></div>
    <div class="risk-1">
        <img src="{{assetUrlByCdn('/static/weixin/activity/security/images/logo.png')}}" class="img">
        <p class="custody-text">九斗鱼以RISKCALC中小企业信用风险评价技术全面考察借款方，进行超过260项定性、定量指标的审核与评估，以科学的计算结果判断企业的还款能力，预估逾期风险。</p>   
        <p class="custody-text">RISKCALC中小企业风险评价技术融合了耀盛中国过去11年服务中小微企业的丰富经验，已获国家技术专利认可，使得耀盛中国信贷业务连续三年不良率低于0.8%，实力处于行业领先地位。</p>   
    </div>
    <div class="security-box risk-2">
        <h4 class="custody-title1">基本风控流程</h4>
        <img src="{{assetUrlByCdn('/static/weixin/activity/security/images/img5.png')}}" class="img">
    </div>
    <div class="security-box compliance-2 risk-3">
        <h4 class="custody-title1">专业云服务商</h4>
        <div class="risk-bg">
            <p>九斗鱼接入阿里巴巴集团旗下的阿里云服务，为平台用户提供更安全的网络服务。阿里云创立于2009年，是全球领先的云计算及人工智能科技公司，为200多个国家和地区的企业、开发者和政府机构提供服务。</p>
        </div>
        <dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon7.png')}}"></dt>
            <dd>
                <h4>数据安全</h4>
                <p>拥有全球最大网络攻击防御经验，三层防火墙隔离系统的访问层、应用层和数据层，有效的入侵防范及容灾备份，确保交易数据安全。</p>
            </dd>
        </dl>
        <dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon8.png')}}"></dt>
            <dd>
                <h4>访问安全</h4>
                <p>对外端口检测，安全风险评估，消除安全隐患，开放相应访问控制权限。通过各类安全组配置工具，提升安全级别。</p>
            </dd>
        </dl><dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon9.png')}}"></dt>
            <dd>
                <h4>灾难备份</h4>
                <p>两地三中心灾备系统，保障平台业务连续性、稳定性。通过灵活的备份机制及回滚策略，可根据业务情况进行数据恢复。</p>
            </dd>
        </dl>
    </div>
    <div class="security-box risk-4">
        <h4 class="custody-title1">稳固安全防护</h4>
        <dl>
            <dt>
                <img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon10.png')}}" class="img">
                <p>抗D保</p>
            </dt>
            <dd>
                <h4>恶意流量清洗服务</h4>
                <p>九斗鱼接入知道创宇“抗D保产品”，通过其独创的智能攻击识别引擎，防止平台遭受DDoS攻击、Web请求欺诈等恶意流量清洗。</p>
            </dd>
        </dl>
        <dl>
            <dt>
                <img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon11.png')}}" class="img">
                <p>创宇盾</p>
            </dt>
            <dd>
                <h4>Web业务系统防入侵服务</h4>
                <p>九斗鱼接入知道创宇“创宇盾”防入侵服务系统，通过其军工级Web业务系统防护服务，实现平台网页防篡改、防拖库窃密、防挂马。</p>
            </dd>
        </dl>
        <dl>
            <dt>
                <img src="{{assetUrlByCdn('/static/weixin/activity/security/images/icon12.png')}}" class="img">
                <p>SSL证书</p>
            </dt>
            <dd>
                <h4>全球唯一身份认证标准</h4>
                <p>九斗鱼获得Symantec颁发的EVSSL级证书，并通过Norton Secured Seal（诺顿安全认证签章），为用户提供256位网站内容加密及漏洞扫描，保障交易安全。</p>
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
