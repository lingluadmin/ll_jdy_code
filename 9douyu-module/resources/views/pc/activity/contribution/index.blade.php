@extends('pc.common.layout')

@section('title', '金融科技杰出贡献奖')
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/assets/css/pc4/jquery.fancybox-1.3.4.css')}}">
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('static/activity/contribution/css/index.css')}}">
<style type="text/css">
 #fancybox-left,#fancybox-right{display: none !important;}
</style>
@endsection
@section('content')
<div class="con-banner"></div>
<div class="con-bg">
    <div class="con-wrap">
        <dl class="con-info">
            <dt>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img-big.png')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img.png')}}" width="54" height="150">
                </a>
            </dt>
            <dd>
                <h4><span></span>2017年11月16日</h4>
                <p>在第九届金融科技与支付创新2017年度盛会上，九斗鱼凭借自身优秀金融科技创新能力，一举斩获“金融科技杰出贡献奖”。该奖项是金融科技领域的权威奖项，旨在表彰一年来在金融科技领域做出突出贡献的单位。</p>
            </dd>
        </dl>
        <div class="con-title">大会回顾</div>
        <ul class="con-img">
            <li>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img1-1.jpg')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img1.jpg')}}" width="230" height="152">
                    <p class="lh">原旭霖原总受邀参加大会</p>
                </a>
            </li>
             <li>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img2-1.jpg')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img2.jpg')}}" width="230" height="152" >
                    <p>《21世纪商业评论》<br/>记者专访原旭霖原总</p>
                </a>
            </li>
             <li>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img3-1.jpg')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img3.jpg')}}" width="230" height="152" >
                    <p>《经济日报》上海办事处常务<br/>副主任专访原旭霖原总</p>
                </a>
            </li>
             <li>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img4-1.jpg')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img4.jpg')}}" width="230" height="152" >
                    <p>《华夏时报》上海站主任/<br/>主任记者专访原旭霖原总</p>
                </a>
            </li>
             <li>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img5-1.jpg')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img5.jpg')}}" width="230" height="152" >
                    <p  class="lh">会议现场</p>
                </a>
            </li>
             <li>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img6-1.jpg')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img6.jpg')}}" width="230" height="152" >
                    <p  class="lh">会议现场</p>
                </a>
            </li>
             <li>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img7-1.jpg')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img7.jpg')}}" width="230" height="152" >
                    <p  class="lh">九斗鱼赞助大会</p>
                </a>
            </li>
            <li>
                <a href="{{assetUrlByCdn('/static/activity/contribution/images/img8-1.jpg')}}" rel='example_group'>
                    <img src="{{assetUrlByCdn('/static/activity/contribution/images/img8.jpg')}}" width="230" height="152" >
                    <p  class="lh">会议大屏幕</p>
                </a>
            </li>
        </ul>
        <div class="con-title1">金融科技与支付创新·大会简介</div>
        <img src="{{assetUrlByCdn('/static/activity/contribution/images/text.png')}}" width="716" height="94" class="con-text">
        <ul class="con-list">
            <li>
                <img src="{{assetUrlByCdn('/static/activity/contribution/images/icon.png')}}" width="89" height="89" >
                <h4>领先</h4>
                <p>八年的探索和沉淀，金融科技与支付创新系列峰会现已成为业内首屈一指的致力于探索金融科技与支付领域上下游、全产业链最新话题、最先进技术和产品、最便捷交流洽谈的一站式会议平台。</p>
            </li>
            <li>
                <img src="{{assetUrlByCdn('/static/activity/contribution/images/icon1.png')}}" width="89" height="89" >
                <h4>权威</h4>
                <p>1500+政府机构及协会、国内外知名银行、监管机构、支付平台、消费金融、大数据、云计算、风控、征信、P2P、区块链、人工智能及基金、保险等金融科技和支付领域大咖。</p>
            </li>
            <li>
                <img src="{{assetUrlByCdn('/static/activity/contribution/images/icon2.png')}}" width="89" height="89" >
                <h4>专业</h4>
                <p>500+高级从业者深度解析业内关注的热点话题，共同探讨最新案例，寻求最佳实践。</p>
            </li>

        </ul>
        <div class="con-title1">什么是金融科技</div>
        <div class="con-text1">
            <p> 金融科技可以理解为利用大数据、人工智能、征信、区块链、云计算、移动互联等新科技手段，服务于金融效率提升的科技产业。</p>
            <h5><span>金融科技势在必行</span></h5>
            <ul class="con-text-1">
                <li>
                    <span>传统金融服务仍然与国家发展和人民群众的金融需求相距甚远</span>
                </li>
                <li>
                    <span>金融科技变革是中国弯道超车重建国际金融新秩序的重要切入点</span>
                </li>
                <li>
                    <span class="con-pt">全球主要创新国家加速布局金融科技领域</span>
                </li>
                <li>
                    <span class="con-pt">信息技术发展为金融科技进步提供必要前提</span>
                </li>
            </ul>
        </div>
        <div class="con-title1">IFPI系列指导机构和支持机构</div>
        <img src="{{assetUrlByCdn('/static/activity/contribution/images/img-1.png')}}" width="1010" height="140" class="con-img-1" >

        <div class="con-title1">媒体报道</div>
        <img src="{{assetUrlByCdn('/static/activity/contribution/images/img-2.png')}}" width="1010" height="290" class="con-img-2" >
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

