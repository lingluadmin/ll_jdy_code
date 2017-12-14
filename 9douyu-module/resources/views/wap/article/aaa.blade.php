@extends('wap.common.wapBaseNew')

@section('title', 'AAA信用企业评级')
@section('keywords', "{{env('META_KEYWORD')}}")

@section('description', "{{env('META_DESCRIPTION')}}")

@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/aaa.css')}}">

@endsection
@section('content')
<div class="aaa-banner">
    <div class="aaa-title">
        <span><i class="aaa-left"></i>什么是<em>AAA</em>信用评级<i class="aaa-right"></i></span>
    </div>
</div>
<div class="aaa-bg">
    <div class="aaa-wrap">
        <div class="aaa-info">
            <p>随着我国互联网产业的快速发展，依托于互联生存、业务运营及业务推广的互联网金融企业越来越多。与此同时，该行业信用体系的缺失，也成为制约行业持续发展的重大瓶颈，因此，互联网金融信用认证itrust应运而生。itrust成立于2007年，为Internet Trust 简称，中文名为“互联网信用认证”。</p>
            <p>itrust以第三方专业机构身份验证企业官方网站及其经营主体的真实性和有效性，客观评价和揭示企业信用状况和客户满意度，定期向公众发布客户满意品牌排行榜，并对诚信企业在“名牌导航”网站上进行集中展示和宣传，从而增加客户对企业、品牌和官网的信任度。</p>
        </div>
        <div class="aaa-info-img">
            <p>九斗鱼AAA评级证书</p>
            <img src="{{assetUrlByCdn('/static/weixin/images/wap4/aaa/aaa.png')}}"  >
        </div>

        <div class="aaa-title">
            <span><i class="aaa-left"></i><em>AAA</em>信用企业评定<i class="aaa-right"></i></span>
        </div>
        <div class="aaa-intro">
            <p>AAA评级是市场对企业的最高评级，是企业荣誉与实力的象征，企业信用等级一般分为AAA优秀、AA优良、A良好，BBB行业平均水平、BB欠佳、B较差，CCC很差、CC极差、C无信用。信用评级越高，代表企业在市场内商业信用越高、安全性能越强、积极性越高。</p>
        </div>
        <div class="aaa-complex">
            <h3>
                <span><i></i><em>全方位综合评定</em></span>
            </h3>
            <ul class="aaa-complex-box">
                <li>
                    <img src="{{assetUrlByCdn('/static/weixin/images/wap4/aaa/complex1.png')}}"  >
                    <p>信用记录</p>
                </li>
                <li>
                    <img src="{{assetUrlByCdn('/static/weixin/images/wap4/aaa/complex2.png')}}"  >
                    <p>经营水平</p>
                </li>
                <li>
                    <img src="{{assetUrlByCdn('/static/weixin/images/wap4/aaa/complex3.png')}}"  >
                    <p>财务状况</p>
                </li>
                <li>
                    <img src="{{assetUrlByCdn('/static/weixin/images/wap4/aaa/complex4.png')}}"  >
                    <p>企业素质</p>
                </li>
                <li>
                    <img src="{{assetUrlByCdn('/static/weixin/images/wap4/aaa/complex5.png')}}"  >
                    <p>发展前景</p>
                </li>
                <li>
                    <img src="{{assetUrlByCdn('/static/weixin/images/wap4/aaa/complex6.png')}}"  >
                    <p>风险评估</p>
                </li>
            </ul>
        </div>
        <div class="aaa-title">
            <span><i class="aaa-left"></i>九斗鱼成功获评<em>AAA级</em>信用企业<i class="aaa-right"></i></span>
        </div>
        <ul class="aaa-9dy">
            <li>
                <h3>成功获评3A信用企业</h3>
                <p>2017年9月8日，经过层层审核，九斗鱼荣获3A信用评级，获得3A信用等级证书。此次获评彰显了九斗鱼的实力和发展前景，进一步提升其在金融市场的知名度与美誉度，也对开拓市场、参与激烈的市场竞争起到积极的促进作用。</p>
            </li>
            <li>
                <h3>积极践行合规</h3>
                <p>九斗鱼自成立以来不断完善风控体系，优化安全结构，积极践行合规，与投资者紧密合作，致力于提供安全便捷的互联网金融服务，为公司信用评级的不断提升奠定了坚实的基础。</p>
            </li>
            <li>
                <h3>九斗鱼COO王春乾表示</h3>
                <p>“此次获得3A评级是对我们努力的肯定，我们会继续将互联网金融安全作为重中之重，严守风控体系，加大金融科技的投研力度，让技术连接人与金融，保障安全，降低风险，使互联网金融真正服务大众，实现普惠金融。”</p>
            </li>
        </ul>
        <div class="aaa-title">
            <span><i class="aaa-left"></i>拥抱<em>监管&nbsp;&nbsp;合规</em>升级<i class="aaa-right"></i></span>
        </div>
        <ul class="aaa-compliance">
            <li>
                <div class="aaa-compliance-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/compliance1.png')}}" ></div>
                <div class="aaa-compliance-main">
                    <h3>ICP许可证</h3>
                    <p>电信与信息服务业务<br>经营许可证</p>
                </div>
            </li>
            <li>
                <div class="aaa-compliance-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/compliance2.png')}}" ></div>
                <div class="aaa-compliance-main">
                    <h3>信用企业</h3>
                    <p>AAA级企业信用认证</p>
                </div>
            </li>
            <li>
                <div class="aaa-compliance-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/compliance3.png')}}" ></div>
                <div class="aaa-compliance-main">
                    <h3>银行存管</h3>
                    <p>江西银行资金存管</p>
                </div>
            </li>
            <li>
                <div class="aaa-compliance-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/compliance4.png')}}" ></div>
                <div class="aaa-compliance-main">
                    <h3>权威风控体系</h3>
                    <p>瑞思科雷权威风控体系</p>
                </div>
            </li>
            <li>
                <div class="aaa-compliance-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/compliance5.png')}}" ></div>
                <div class="aaa-compliance-main">
                    <h3>SSL证书</h3>
                    <p>诺顿安全认证签章<br>SSL证书</p>
                </div>
            </li>
            <li>
                <div class="aaa-compliance-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/compliance6.png')}}" ></div>
                <div class="aaa-compliance-main">
                    <h3>专业云服务商</h3>
                    <p>阿里云专业服务商</p>
                </div>
            </li>
        </ul>
        <div class="aaa-title">
            <span><i class="aaa-left"></i>信用评级企业展示<i class="aaa-right"></i></span>
        </div>
        <ul class="aaa-enterprise">
            <li>
                <div class="aaa-enterprise-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/enterprise1.png')}}" ></div>
                <div class="aaa-enterprise-main">
                    <h3>陆金所</h3>
                    <p><i></i><span>AAA级</span></p>
                </div>
            </li>
            <li>
                <div class="aaa-enterprise-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/enterprise2.png')}}" ></div>
                <div class="aaa-enterprise-main">
                    <h3>九斗鱼</h3>
                    <p><i></i><span>AAA级</span></p>
                </div>
            </li>
            <li>
                <div class="aaa-enterprise-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/enterprise3.png')}}" ></div>
                <div class="aaa-enterprise-main">
                    <h3>携程</h3>
                    <p><i></i><span>AAA级</span></p>
                </div>
            </li>
            <li>
                <div class="aaa-enterprise-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/enterprise4.png')}}" ></div>
                <div class="aaa-enterprise-main">
                    <h3>亚马逊</h3>
                    <p><i></i><span>AAA级</span></p>
                </div>
            </li>
            <li>
                <div class="aaa-enterprise-img"><img src="{{assetUrlByCdn('/static/images/pc4/aaa/enterprise5.png')}}" ></div>
                <div class="aaa-enterprise-main">
                    <h3>京东金融</h3>
                    <p><i></i><span>AA级</span></p>
                </div>
            </li>
        </ul>
    </div>
</div>
    

   
@endsection
@section('jspage')
<script type="text/javascript" href="{{assetUrlByCdn('/assets/js/pc4/compliance/jquery.fancybox-1.3.1.pack.js')}}"></script>
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

