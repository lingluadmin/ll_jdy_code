@extends('pc.common.layoutNew')

@section('title', '平台合规')
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/assets/css/pc4/jquery.fancybox-1.3.4.css')}}">
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/css/pc4/compliance.css')}}">
<style type="text/css">
 #fancybox-left,#fancybox-right{display: none !important;}
</style>
@endsection
@section('content')
    <div class="v4-compliance-banner">
        <h4>江西银行资金存管</h4>
        <span class="line"></span>
        <h5>为安全把关，让信赖升级</h5>
        <p>2017年7月，九斗鱼正式携手江西银行达成资金存管合作，双方启动系统技术对接。存管系统上线后，用户资金将全部迁移至银行存管系统开设的对应独立账户，交易流程更真实，用户资金更安全。</p>
        <div class="security-three2" id="sec-three2">
            <div class="security-three2-out sec-three-ani">
                <span class="security-out-hoop"></span>
                <span class="security-out-circle"></span>
            </div>
            <div class="security-three2-inside sec-three-ani" ></div>
            <div class="v4-security-img one1-circle">
                <span class="v4-security-img1 earth-blue-small1"></span>
                <span class="v4-security-img2 earth-blue-small2"></span>
                <span class="v4-security-img3 earth-blue-small3"></span>
                <span class="v4-security-img4 earth-blue-small4"></span>
            </div>
        </div>

    </div>

    <div class="v4-compliance">
        <div class="v4-wrap">
            <h4>行业权威机构认证</h4>
            <span class="line"></span>
            <h5>已获多个国家级金融协会认证资质</h5>
            <div class="v4-compliance-1">
                <dl>
                    <dt><img src="{{assetUrlByCdn('/static/images/pc4/compliance/img1.jpg')}}" width="170" height="160" ></dt>
                    <dd>
                        <h6>ICP</h6>
                        <p>工信部核发《中国人民共和国电信与信息服务业务经营许可证》</p>
                        <a href="{{assetUrlByCdn('/static/images/pc4/compliance/compliance-pic1.jpg')}}" rel='example_group'>查看证书</a>
                    </dd>
                </dl>
                <dl>
                    <dt><img src="{{assetUrlByCdn('/static/images/pc4/compliance/img2.jpg')}}" width="160" height="160" ></dt>
                    <dd>
                        <h6>AAA企业信用评级</h6>
                        <p>《企业信用评级证书》</p>
                        <a href="{{assetUrlByCdn('/static/images/pc4/compliance/compliance-pic4.jpg')}}" rel='example_group'>查看证书</a>
                    </dd>
                </dl>
                <dl>
                    <dt><img src="{{assetUrlByCdn('/static/images/pc4/compliance/img3.jpg')}}" width="160" height="160" ></dt>
                    <dd>
                        <h6>等保三级认证</h6>
                        <p>公安部核发《信息系统安全等级保护三级》认证</p>
                        <a href="{{assetUrlByCdn('/static/images/pc4/compliance/compliance-pic3.jpg')}}" rel='example_group'>查看证书</a>
                    </dd>
                </dl>
            </div>
            
        </div>
    </div>

    <div class="v4-compliance1">
        <div class="v4-compliance-title">
            <h4>完备法律保障机制</h4>
            <span class="line"></span>
        </div>
        <div class="v4-compliance-box">
            <dl>
                <dt><img src="{{assetUrlByCdn('/static/images/pc4/compliance/img4.jpg')}}" width="130" height="131" ></dt>
                <dd>
                    <h5>法律保障</h5>
                    <p>九斗鱼与盈科律师事务所建立战略合作，为九斗鱼提供行业合规相关的法律支持工作，并向监管部门出具法律意见，保障平台业务流程及所有法律合同合法合规，并受法律保护。</p>
                </dd>
            </dl>
            <dl class="v4-compliance-2">
                <dd>
                    <h5>电子签章</h5>
                    <p>九斗鱼与易保全建立合作，为平台交易电子合同提供电子签章服务。电子签章是基于数字证书的应用，数字证书具备唯一性，无法被篡改、被仿造，可以解决电子合同的有效性问题。</p>
                </dd>
                <dt><img src="{{assetUrlByCdn('/static/images/pc4/compliance/img5.jpg')}}" width="130" height="131" ></dt>
            </dl>
            <dl>
                <dt><img src="{{assetUrlByCdn('/static/images/pc4/compliance/img6.jpg')}}" width="130" height="131" ></dt>
                <dd>
                    <h5>合同保全</h5>
                    <p>九斗鱼与易保全建立合作，为平台交易电子合同提供合同保全服务。合同保全是为金融相关企业量身定制的一款保全产品，解决了网上交易客户的身份识别问题， 提供加密传输，并保全电子合同内容，可以防止内容泄露及篡改。</p>
                </dd>
            </dl>
        </div>
    </div>
@endsection
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/jquery.fancybox-1.3.1.pack.js')}}"></script>
<script type="text/javascript">
(function($){
    $(function(){
        $("a[rel=example_group]").fancybox({
                'transitionIn'      : 'none',
                'transitionOut'     : 'none',
                'titlePosition'     : 'over',
                'titleFormat'       : null
            });
    })
})(jQuery)
</script>
@endsection

