@extends('pc.common.activity')

@section('title', '耀盛互联网小贷完成工商注册')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="format-detection" content="telephone=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">  
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/loan/css/index.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/loan/css/jquery.fullPage.css')}}"> -->
    <script  type="text/javascript" src="{{assetUrlByCdn('/static/activity/loan/js/loan.js')}}"></script>

@endsection
@section('content')
<div id="dowebok">
    <div class="section section1">
   
        <h4>打破<span>地域瓶颈</span> 开启业务<span>新篇章</span></h4>
        <h5>耀盛互联网小贷完成<span>工商注册</span></h5>
        <p class="time">{{date('Y年m月d日' ,$activityTime['start'])}} - {{date('m月d日' ,$activityTime['end'])}}</p>
        <div class="box clearfix">
            <div class="fl textbox">
                <p class="text big">1%</p>
                <p class="text">活动期间用户每日都可领取一次</p>
                <p class="text">仅限投资3、6、12月期及九安心项目</p>
                <p class="text">自领取之日起有效期10天</p>
            </div>
            <div class="fr">
                <a href="javascript:;" class="loan-btn"  data-layer="layer-wrap" id='btn-loan-bonus' lottery-lock="open" attr-static-url="{{env('STATIC_URL_HTTPS')}}">立即领取</a>
                <input type="hidden" name="_token"  value="{{csrf_token()}}">
            </div>
        </div>
        
    </div>
    <div class="section section2">
        <div class="section2-img">
          <h2>广州耀盛网络小额贷款有限公司在穗开业</h2>
          <ul class="clearfix">
            <li>
                <img src="{{assetUrlByCdn('/static/activity/loan/images/img1.jpg')}}">
                <p>耀盛网络小贷<br>在广东开业剪彩</p>
            </li>
            <li>
                <img src="{{assetUrlByCdn('/static/activity/loan/images/img2.jpg')}}">
                <p>广东省中小企业服务中心<br>陈健主任在开业仪式上致辞</p>
            </li>
            <li>
                <img src="{{assetUrlByCdn('/static/activity/loan/images/img3.jpg')}}">
                <p>耀盛网络小贷<br>原旭霖总经理在开业仪式上致辞</p>
            </li>
          </ul>

          <div class="section2-content">
            <p class="indent">2017年9月6日,耀盛投资管理集团有限公司（以下简称“耀盛中国”）旗下的广州耀盛网络小额贷款有限公司（以下简称“耀盛网络小贷”）在广州正式开业，广东省中小企业服务中心、广州市金融局、广州市越秀区金融局、广州市越秀区民间金融街管委会、江西银行广东省分行、江西银行越秀支行、广州交易所集团等相关单位主管领导，以及耀盛中国总裁兼耀盛网络小贷总经理原旭霖出席了开业仪式，并进行开业剪彩。</p>
            <p class="indent">据悉，耀盛网络小贷于2017年7月28日完成工商注册，由耀盛中国100%持股，经营范围为货币金融服务。开业活动现场，广东省中小企业服务中心、广州市金融局、广州市越秀区金融局等与会领导对耀盛网络小贷落户广州市越秀区表示热烈祝贺，并寄予殷切厚望。</p>
            <p>广东省中小企业服务中心陈健主任表示：“耀盛网络小贷今天正式开业，这意味着耀盛中国将符合监管要求，合法合规地开展网络小贷业务。希望耀盛中国可以充分发挥集团多年服务中小企业的经验优势，针对中小企业‘短、小、频、急’的金融需求，真正将中小企业金融服务工作落到实处，做到细处，实现中小企业与集团自身的共赢发展。”</p>
            <h5>耀盛网络小贷“青眼”广州</h5>
            <p>据第一消费金融2017年8月31日最新发布的不完全统计数据称，目前市场上有214张网络小贷牌照，其中186张已经完成工商注册，在这186张牌照中，广州以39张的数量占据首位，占比约21%。</p>
            <p>“很显然，广州市，作为全国网络小贷的先行试验区，是众多网络小贷公司落户的首选之地。”原旭霖表示，“这与其市场大环境密不可分。首先，作为国家中心城市、国家移动互联网的起源地、国家电子商务示范城市和在全国具有重要影响力的区域金融中心，广州具有发展网络小贷的有利条件和坚实基础。其次，纵观各地网络小贷的现状，众多网络小贷企业云集广州，聚集效应明显。产业基础扎实，政府政策支持，因此，广州成为了耀盛网络小贷落户的不二之选。”</p>
            <h5>网络小贷“助推”耀盛中国跨区展业</h5>
            <p>近两年来，网络小贷迅速发展，网络小贷牌照已然是时下最受关注的焦点和众资本竞相追逐的对象。原旭霖表示：“但耀盛中国此次布局网络小贷却非对‘一牌难求’的盲目追捧，而是集团业务发展到一定阶段的必然行为。”</p>
            <p>耀盛中国，深耕中小企业金融生态圈11年，目前已全面布局小额信贷、商业保理、融资租赁、征信评价、智能支付、私募股权、电影金融、证券经纪、上市保荐、基金管理等业务，此外集团还进一步布局了金融科技领域，致力于服务中小企业从初创、成立到发展成熟的全生命周期。</p>
            <p>但是，即便如此，仍不乏有传统的线下小贷输送过来的有借贷需求的客户，抑或是在保理业务之外有小额贷款需求的保理客户，或是融资租赁部分有流动资金需求的企业，受困于“地域限制问题”。</p>
            <p>在这样的背景下，耀盛中国应势而谋、因势而动，布局网络小贷。“此次耀盛网络小贷的开业对于集团的业务发展具有重要的战略意义。”原旭霖表示，“网络小贷牌照这张‘通行证’打破了地域限制的‘紧箍咒’，依托这张牌照，耀盛中国将进军全国市场，有望为中小企业提供更快捷、更灵活、更高效的金融服务。”</p>
          </div>
                      
               
         
            
        </div>
   
    </div>
</div>

<!-- 领取成功弹窗 -->
 {{--<div class="pop-wrap  layer-wrap1" style="display: none;">--}}
    {{--<div class="pop-mask"></div>--}}
    {{--<div class="lantern-pop">--}}
        {{--<i class="pop-close" data-toggle="mask" data-target="layer-wrap1"></i>--}}
        {{--<div class="loan-icon"><img src="{{assetUrlByCdn('/static/activity/loan/images/sucess.png')}}" width="90" height="90"></div>--}}
        {{--<p class="text3">领取成功！</p>--}}
        {{--<p class="text6">请在【资产-我的优惠券】中查看</p>--}}
        {{--<a class="loan-btn1" href="javascript:;" data-toggle="mask" data-target="layer-8" >好　的</a>--}}
    {{--</div>--}}
 {{--</div>--}}

 

<!-- 确定领取加息券弹窗 -->
 <div class="pop-wrap  layer-wrap" style="display: none;">
    <div class="pop-mask"></div>
    <div class="lantern-pop">
        <i class="pop-close" data-toggle="mask" data-target="layer-wrap"></i>
        <div class="loan-icon1"><img src="{{assetUrlByCdn('/static/activity/loan/images/bouns.png')}}" width="208" height="143"></div>
        <p class="text4">确定领取1%定期加息券？</p>
        <a class="loan-btn1 " href="javascript:;"  id="lottery-loan-bonus">确定</a>
    </div>
 </div>


 <!-- 确定领取加息券弹窗 -->
 <div class="pop-wrap  layer-message" style="display: none;">
    <div class="pop-mask"></div>
    <div class="lantern-pop">
        <i class="pop-close" data-toggle="mask" data-target="layer-message"></i>
        <div class="loan-icon2"><img src="{{assetUrlByCdn('/static/activity/loan/images/login.png')}}" width="90" height="90"></div>
        <p class="text5">客官，别急 还没登录呢</p>
        <a class="loan-btn1" href="javascript:;" >登录</a>
    </div>
 </div>



@endsection
@section('jspage')
   

<script type="text/javascript">

$(document).on("click", '[data-layer]',function(event){

    event.stopPropagation();
    var $this = $(this);
    var target = $this.attr("data-layer");
    var $target = $("."+target);
    $target.show();
 })
$(document).on("click", '#lottery-loan-bonus',function(event){
    event.stopPropagation();
    var $target = $(".pop-wrap");
    $target.hide();
    LoanBonus.doLoanDraw(event);
});


</script>
@endsection