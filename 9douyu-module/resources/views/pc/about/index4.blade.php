@extends('pc.common.base')
@section('title', $title)
@section('keywords', $keywords)
@section('description', $description)
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/assets/css/pc4/jquery.fancybox-1.3.4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/css/pc4/about.css')}}">
@endsection
@section('content')
@include('pc.about/aboutMenu')
<div class="v4-about-banner">
    <h2>安全  智能  稳健  高效</h2>
    <p>互联网金融平台</p>
</div>
<!-- 公司介绍 -->
<div class="v4-about-company">
    <div class="v4-about-title">
        <h2>公司介绍</h2>
        <p class="v4-about-line"></p>
    </div>
    <div class="v4-about-company-txt v4-wrap">
        <p>九斗鱼(www.jiudouyu.com)由星果时代信息技术有限公司负责运营，于2014年6月上线，是一个安全、智能、稳健、高效的互联网金融平台。九斗鱼运营公司注册资本金6000万元，注册用户数超过百万。凭借创新的产品设计、卓越的用户体验、严谨的风控体系，九斗鱼迅速成长为行业领先、用户满意的互联网新金融品牌。</p>
        <p>九斗鱼始终坚持金融信息中介的定位，积极落实央行《关于促进互联网金融健康发展的指导意见》精神，已于2017年8月成功完成合规化运营。一直以来，九斗鱼在互联网金融生态圈建设、互联网服务优化、大数据征信发展、云计算能力提升、风险控制智能化等方向全面发展，潜心帮助每一位用户与小微业主持续提供金融服务，在收获财富的道路上保驾护航，推动普惠金融的落地生根。</p>
        <p>截至2017年7月，九斗鱼已成功为3000多家优质中小微企业和个人实现了“一站式”融资，累计成交额已超过50亿大关。</p>
    </div>
</div>
<!-- End 公司介绍 -->

<!-- 平台优势 -->
<div class="v4-about-advantage v4-wrap">
    <div class="v4-about-title">
        <h2>平台优势</h2>
        <p class="v4-about-line"></p>
    </div>
    <div class="v4-about-advantage-main">
        <h3>综合性、全牌照金融集团实力</h3>
        <p>耀盛集团拥有中、港两地九大金融牌照</p>
        <img src="{{ assetUrlByCdn('/static/images/pc4/about/about-icon1.png')}}" class="v4-about-advantage-icon">
        <div class="v4-about-advantage-txt">
            <p>九斗鱼隶属的集团企业—耀盛中国，成立于2006 年，拥有强大的综合金融服务体系，并得到了各级监管机构的充分认可，集团持有小额贷款、网络小贷、商业保理、融资租赁、私募股权、企业征信、证券经纪、上市保荐、基金管理九大金融牌照。所有金融业务均处于监管机构的监督管理之下。依法、合规、透明、稳健构成了耀盛中国各项金融业务健康发展的重要基础。</p>
        </div>
    </div>
    <div class="v4-about-advantage-main">
        <h3>深耕中小企业金融服务11年</h3>
        <p>耀盛中国金融业务体系稳健发展</p>
        <img src="{{ assetUrlByCdn('/static/images/pc4/about/about-icon2.png')}}" class="v4-about-advantage-icon">
        <div class="v4-about-advantage-txt">
            <p>耀盛中国多年来深耕“中小企业金融生态圈”，依托十一年发展经验，已形成“点、线、面”相结合的中小企业金融服务体系，涉及行业涵盖信息技术、医疗健康、餐饮酒店等多个行业。同时借助于互联网、大数据、云计算等多种科技手段，力争做到多接触点、一站式金融服务，切实解决中国中小企业融资难、融资贵的问题。在金融服务领域，耀盛中国目前已全面布局小额信贷、商业保理、网络小贷、融资租赁、征信评级、私募股权投资、电影金融等业务。截止2017年累计服务超8万家中小企业，年均创造经济总产值逾3000亿元。</p>
        </div>
    </div>
    <div class="v4-about-advantage-main">
        <h3>严守风控防线，构建高标准风控标准</h3>
        <p>国家专利认可的RISKCALC权威风控体系</p>
        <img src="{{ assetUrlByCdn('/static/images/pc4/about/about-icon3.png')}}" class="v4-about-advantage-icon">
        <div class="v4-about-advantage-txt">
            <p>九斗鱼以RISKCALC中小企业信用风险评价技术全面考察借款方，进行超过260项定性、定量指标的审核与评估。以科学的计算结果判断企业的还款能力，预估逾期风险。RISKCALC中小企业风险评价技术融合了耀盛中国过去11年服务中小微企业的丰富经验，已获国家技术专利认可，使得耀盛中国信贷业务连续三年不良率低于0.8%，实力处于行业领先地位。</p>
        </div>
    </div>
    <div class="v4-about-advantage-main">
        <h3>为安全把关，让信赖升级</h3>
        <p>与用户体验优秀的江西银行合作资金存管</p>
        <img src="{{ assetUrlByCdn('/static/images/pc4/about/about-icon4.png')}}" class="v4-about-advantage-icon">
        <div class="v4-about-advantage-txt">
            <p>2017年7月，九斗鱼正式携手江西银行达成资金存管合作，双方启动系统技术对接。存管系统上线后，江西银行为“鱼客”和借款人开设独立的资金存管账户，所有涉及资金变动的操作都由“鱼客”发出的授权交易码为准，平台无权动用资金，保障资金安全。</p>
        </div>
    </div>
    <div class="v4-about-advantage-main">
        <h3>走在合规前列，互金行业资优生</h3>
        <p>已获多个国家级金融协会认证资质</p>
        <img src="{{ assetUrlByCdn('/static/images/pc4/about/about-icon5.png')}}" class="v4-about-advantage-icon">
        <div class="v4-about-advantage-txt">
            <p>九斗鱼长期致力于打造完善的合规发展体系，亦积极响应监管提出的每一个合规要求。目前，九斗鱼已完成多项合规工作，包括接入上海咨信“NFCS网络金融征信系统”及中国支付清算协会主导的“小微金融风险信息共享平台”，获工信部颁发《中国人民共和国电信与信息服务业务经营许可证》，获公安部颁发“国家信息系统安全等级保护三级备案”证明。九斗鱼于2016年正式成为中关村互联网金融行业协会“副会长单位”，并被收入《金融蓝皮书》百家主流平台获BB+评级。</p>
        </div>
    </div>
    <div class="v4-about-advantage-main">
        <h3>诸多行业权威媒体关注报道</h3>
        <p>九斗鱼出色表现荣获多项大奖</p>
        <img src="{{ assetUrlByCdn('/static/images/pc4/about/about-icon6.png')}}" class="v4-about-advantage-icon">
        <div class="v4-about-advantage-txt">
            <p>九斗鱼凭借出色的行业表现和品牌影响力，荣获多项大奖。2014年，九斗鱼荣获易观之星“互联网金融创新奖”；2015年，九斗鱼荣获互联网金融领军榜“年度创新品牌大奖”、《中国企业家》“未来之星”最具成长性新兴企业TOP100、“互联网金融最佳品牌奖”、《投资者报》“2015互联网金融公司社会责任榜十强”等6项奖项；2016年，九斗鱼荣获中国金融博物馆“2015互联网金融创新季度新秀”、CEO郭鹏入选《快公司》“中国商业最具创意人物100”；2017年，CEO郭鹏获选“科技金融创客先锋”、中国互联网金融行业最具创新价值品牌、移动应用质量体验基准体系认证书。</p>
        </div>
    </div>
</div>
<!-- End 平台优势 -->

<!-- 集团实力 -->
<div class="v4-about-strength">
    <div class="v4-wrap">
        <div class="v4-about-title">
            <h2>集团实力</h2>
            <p class="v4-about-line"></p>
        </div>
        <div class="v4-about-strength-info">
            <p>耀盛投资管理集团有限公司（以下简称：耀盛中国）成立于2006年，多年来深耕“中小企业金融生态圈”，依托十年的发展经验，已经形成“点、线、面”相结合的中小企业金融服务体系，同时借助于互联网、大数据、云计算等多种科技手段，力争做到多接触点、一站式金融服务，切实解决中国中小企业融资难、融资贵的问题。</p>
            <p>自2006年成立以来，耀盛中国一直致力于为中小企业提供综合金融解决方案。涉及行业涵盖信息技术、医疗健康、餐饮酒店等多个行业，累计服务超过8万余家中小企业，年均创造经济总产值逾3000亿元</p>
        </div>
        <ul class="v4-about-strength-main">
            <li>
                <i class="v4-iconfont">&#xe6d0;</i><br>
                <h3>产业布局<a href="{{assetUrlByCdn('/static/images/pc4/about/about-structure-3.jpg')}}" rel='example_group'>查看</a></h3>
                <p>在金融服务领域，耀盛中国目前已全面布局小额信贷、商业保理、网络小贷、融资租赁、征信评级、私募股权投资、电影金融等业务。耀盛中国直接控股、参股的机构有北京耀盛小额贷款有限公司、耀盛商业保理有限公司、耀江融资租赁有限公司、北京汉泰基金管理中心（有限合伙）、北京耀盛商业发展有限公司、北京耀汉网络科技有限公司、耀盛影业有限公司、星果科技有限公司。</p>
            </li>
            <li>
                <i class="v4-iconfont">&#xe6cf;</i><br>
                <h3>业务特色</h3>
                <p>耀盛中国在中小企业金融服务领域有着悠久的历史、丰富的经验，同时拥有面向中小企业群体的完整的评价、投资、管理工具，可根据中小企业的多层次需求提供定制化的综合金融服务，能够针对中小企业发展的不同阶段，为其提供相匹配的一站式金融解决方案。</p>
            </li>
            <li>
                <i class="v4-iconfont">&#xe6ce;</i><br>
                <h3>技术优势</h3>
                <p>耀盛中国研发了拥有自主知识产权的瑞思科雷（Riskcalc）信用评级技术，获得国家颁发的软件著作权证书，并于2014年成立了瑞思科雷征信有限公司，实现融资评价服务的专业化运营，以融资评价服务为基础，带动企业征信发展，同时以征信业务反哺信贷审批服务，提高信审服务效率及质量。</p>
            </li>
        </ul>
    </div>
</div>
<!-- End 集团实力 -->

<!-- 集团牌照 -->
<div class="v4-wrap">
    <div class="v4-about-title">
        <h2>集团牌照</h2>
        <p class="v4-about-line"></p>
    </div>
    <div class="v4-about-license">
        <ul class="loan-license">
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img1-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img1.jpg')}}"></a>
                <p><strong>北京市金融工作局颁发</strong></p>
                <p>北京耀盛小额贷款有限公司<br>小额贷款牌照</p>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img2-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img2.jpg')}}"></a>
                <p><strong>天津市自由贸易试验区颁发</strong></p>
                <p>耀江融资租赁有限公司<br>融资租赁牌照</p>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img3-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img3.jpg')}}"></a>
                <p><strong>广州市越秀区金融工作局颁发</strong></p>
                <p>广州耀盛网络小额贷款有限公司<br>网络小额贷款牌照</p>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img4-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img4.jpg')}}"></a>
                <p><strong>中国证券投资基金业协会颁发</strong></p>
                <p>北京汉泰基金管理中心(有限合伙）<br>私募基金牌照</p>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img5-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img5.jpg')}}"></a>
                <p><strong>中国人民银行颁发</strong></p>
                <p>瑞思科雷征信有限公司<br>企业征信牌照</p>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img6-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img6.jpg')}}"></a>
                <p><strong>香港证监会颁发</strong></p>
                <p>耀盛资本有限公司<br>机构融资上市保荐牌照</p>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img7-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img7.jpg')}}"></a>
                <p><strong>香港证监会颁发</strong></p>
                <p>耀盛基金管理有限公司<br>资产管理牌照</p>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img8-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img8.jpg')}}"></a>
                <p><strong>香港证监会颁发</strong></p>
                <p>耀盛证券有限公司<br>证券交易牌照</p>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/images/pc4/license/license-img9-big.jpg')}}" rel='example_group'><img src="{{assetUrlByCdn('/static/images/pc4/license/license-img9.jpg')}}"></a>
                <p><strong>香港东区法院颁发</strong></p>
                <p>亚洲信贷有限公司<br>放债人牌照</p>
            </li>
        </ul>
    </div>
</div>

<!-- End 集团牌照 -->


<!-- 办公环境 -->
<div class="v4-team-wrap clearfix">
    <div class="v4-wrap">
        <div class="v4-about-title">
            <h2>办公环境</h2>
            <p class="v4-about-line"></p>
        </div>
        <div class="v4-office clearfix">
            <ul class="v4-piclist">
                <li>
                    <a href="{{assetUrlByCdn('/static/images/pc4/office/office1-sizeX.jpg')}}" rel='example_group'>
                        <p>
                            <img alt="" src="{{assetUrlByCdn('/static/images/pc4/office/office1.jpg')}}" />
                            <span></span>
                        </p>
                    </a>
                   
                </li>
                <li>
                    <a href="{{assetUrlByCdn('/static/images/pc4/office/office2-sizeX.jpg')}}" rel='example_group'>
                        <p><img alt="" src="{{assetUrlByCdn('/static/images/pc4/office/office2.jpg')}}" /><span></span></p>
                    </a>
                    
                </li>
                <li>
                    <a href="{{assetUrlByCdn('/static/images/pc4/office/office3-sizeX.jpg')}}" rel='example_group'>
                        <p><img alt="" src="{{assetUrlByCdn('/static/images/pc4/office/office3.jpg')}}" /><span></span></p>
                    </a>
                    
                </li>
                <li>
                    <a href="{{assetUrlByCdn('/static/images/pc4/office/office4-sizeX.jpg')}}" rel='example_group'>
                        <p><img alt="" src="{{assetUrlByCdn('/static/images/pc4/office/office4.jpg')}}"/><span></span></p>
                    </a>
                    
                </li>
                <li>
                    <a href="{{assetUrlByCdn('/static/images/pc4/office/office5-sizeX.jpg')}}" rel='example_group'>
                        <p><img alt="" src="{{assetUrlByCdn('/static/images/pc4/office/office5.jpg')}}" /><span></span></p>
                    </a>
                   
                </li>
                <li>
                    <a href="{{assetUrlByCdn('/static/images/pc4/office/office6-sizeX.jpg')}}" rel='example_group'><p>
                        <img alt="" src="{{assetUrlByCdn('/static/images/pc4/office/office6.jpg')}}"/><span></span>
                    </p></a>
                    
                </li>
                <li>
                    <a href="{{assetUrlByCdn('/static/images/pc4/office/office7-sizeX.jpg')}}" rel='example_group'>
                        <p><img alt="" src="{{assetUrlByCdn('/static/images/pc4/office/office7.jpg')}}" /><span></span></p>
                    </a>
                   
                </li>
                <li>
                    <a href="{{assetUrlByCdn('/static/images/pc4/office/office8-sizeX.jpg')}}" rel='example_group'>
                        <p><img alt="" src="{{assetUrlByCdn('/static/images/pc4/office/office8.jpg')}}"/><span></span></p>
                    </a>
                    
                </li>
            </ul>
        </div>
    </div>
</div>


{{--@include('pc.about.team')--}}
@endsection
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/jquery.fancybox-1.3.1.pack.js')}}"></script>
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/layer.js')}}"></script>
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
