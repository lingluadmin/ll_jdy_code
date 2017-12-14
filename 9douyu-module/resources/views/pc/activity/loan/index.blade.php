@extends('pc.common.activity')

@section('title', '耀盛互联网小贷完成工商注册')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('csspage')
    <meta name="format-detection" content="telephone=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">  
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/activity/loan/css/index0915.css')}}">
    <script  type="text/javascript" src="{{assetUrlByCdn('/static/activity/loan/js/loan.js')}}"></script>

@endsection
@section('content')
<div class="loan-banner"></div>
<div class="v4-wrap">
    <div class="loan-title title1"></div>
    <div class="loan-preface">
        <p>2017年9月6日,耀盛投资管理集团有限公司（以下简称“耀盛中国”）旗下的广州耀盛网络小额贷款有限公司（以下简称“耀盛网络小贷”）在广州正式开业，广东省中小企业服务中心、广州市金融局、广州市越秀区金融局、广州市越秀区民间金融街管委会、江西银行广东省分行、江西银行越秀支行、广州交易所集团等相关单位主管领导，以及耀盛中国总裁兼耀盛网络小贷总经理原旭霖出席了开业仪式，并进行开业剪彩。开业活动现场，广东省中小企业服务中心、广州市金融局、广州市越秀区金融局等与会领导对耀盛网络小贷落户广州市越秀区表示热烈祝贺，并寄予殷切厚望。</p>
    </div>
    <div class="loan-title title2"></div>
    <div class="loan-block">
        <div class="loan-block-main main1">
            <i></i>
            <p>全国仅<span>214家</span>公司获批<br>耀盛网络小贷成功入选</p>
            <ins></ins>
        </div>
        <div class="loan-block-main main2">
            <i></i>
            <p>耀盛集团已获<span>9大</span>牌照<br>产业布局再添浓墨一笔</p>
            <ins></ins>
        </div>
        <div class="loan-block-main main3">
            <i></i>
            <p><span>省、市、区领导</span>首肯<br>成就金融创新、合规之路</p>
            <ins></ins>
        </div>
        <div class="loan-block-main main4">
            <i></i>
            <p>公司注册资本<span>1亿元</span><br>凸显耀盛网络小贷实力</p>
            <ins></ins>
        </div>
    </div>
    <div class="loan-title title3"></div>
    <ul class="loan-leader">
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/img1.jpg')}}" alt="广东省中小企业服务中心 陈健主任">
            <div class="loan-leader-txt">
                <h3 class="loan-mt1">广东省中小企业服务中心 陈健主任</h3>
                <p>“耀盛网络小贷今天正式开业，这意味着耀盛中国将符合监管要求，合法合规地开展网络小贷业务。希望耀盛中国可以充分发挥集团多年服务中小企业的经验优势，针对中小企业‘短、小、频、急’的金融需求，真正将中小企业金融服务工作落到实处，做到细处，实现中小企业与集团自身的共赢发展。”</p>
            </div>
        </li>
        <li class="loan-leader-right">
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/img2.jpg')}}" alt="耀盛中国总裁兼耀盛网络小贷 原旭霖总经理">
            <div class="loan-leader-txt">
                <h3 class="loan-mt2">耀盛中国总裁兼耀盛网络小贷 原旭霖总经理</h3>
                <p>“耀盛网络小贷的开业对于集团的业务发展具有重要的战略意义，耀盛中国此次布局网络小贷是集团业务发展到一定阶段的必然行为。网络小贷打破了地域限制的‘紧箍咒’，耀盛中国将进军全国市场，有望为中小企业提供更快捷、更灵活、更高效的金融服务。”</p>
            </div>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/img3.jpg')}}" alt="广州市越秀区金融局办公室 方兴锋主任">
            <div class="loan-leader-txt">
                <h3>广州市越秀区金融局办公室 方兴锋主任</h3>
                <p>方兴锋主任在耀盛网络小贷公司开业仪式上致辞，肯定了耀盛中国在广州落地网络小贷业务及对金融创新做出的贡献。同时，原旭霖表示，“广州市作为国家中心城市、国家移动互联网的起源地、国家电子商务示范城市和在全国具有重要影响力的区域金融中心，广州具有发展网络小贷的有利条件和坚实基础。纵观各地网络小贷的现状，众多网络小贷企业云集广州，聚集效应明显。产业基础扎实，政府政策支持，因此，广州成为了耀盛网络小贷落户的不二之选。”</p>
            </div>
        </li>
        <li class="loan-leader-right">
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/img4.jpg')}}" alt="江西银行广东省分行 胡锦岚行长">
            <div class="loan-leader-txt">
                <h3 class="loan-mt1">江西银行广东省分行 胡锦岚行长</h3>
                <p>胡锦岚行长在耀盛网络小贷公司开业仪式上致辞，肯定了耀盛中国旗下互联网金融平台——九斗鱼在行业合规、自律方面做出的工作。2017年7月10日，九斗鱼正式与江西银行达成资金存管合作。“这无论对于九斗鱼平台、还是对于鱼客来说，都是具有里程碑级意义的事件”，九斗鱼CEO郭鹏如此表示。</p>
            </div>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/img5.jpg')}}" alt="各界领导出席剪彩仪式">
            <div class="loan-leader-txt">
                <h3 class="loan-mt2">各界领导出席剪彩仪式</h3>
                <p>（从左往右，排名不分先后）江西银行越秀支行朱倩影行长、耀盛网络小贷原旭霖总经理、广东省中小企业服务中心陈健主任、广州市越秀区金融局办公室方兴锋主任、广州市金融局地方金融处郭超群科长、江西省银行广东省分行胡锦岚行长。</p>
            </div>
        </li>
        <li class="loan-leader-right">
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/img6.jpg')}}" alt="广州市越秀区金融局领导出席剪彩仪式">
            <div class="loan-leader-txt">
                <h3 class="loan-mt3">广州市越秀区金融局领导出席剪彩仪式</h3>
                <p>（从左往右，排名不分先后）广州市越秀区金融局廖检文局长、耀盛网络小贷原旭霖总经理、广州市越秀区金融局刘中副局长。</p>
            </div>
        </li>
    </ul>
    <div class="loan-title title4"></div>
    <ul class="loan-license">
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license1.jpg')}}">
            <p><strong>北京市金融工作局颁发</strong></p>
            <p>北京耀盛小额贷款有限公司<br>小额贷款牌照</p>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license2.jpg')}}">
            <p><strong>天津市自由贸易试验区颁发</strong></p>
            <p>耀江融资租赁有限公司<br>融资租赁牌照</p>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license3.jpg')}}">
            <p><strong>广州市越秀区金融工作局颁发</strong></p>
            <p>广州耀盛网络小额贷款有限公司<br>网络小额贷款牌照</p>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license4.jpg')}}">
            <p><strong>中国证券投资基金业协会颁发</strong></p>
            <p>北京汉泰基金管理中心(有限合伙）<br>私募基金牌照</p>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license5.jpg')}}">
            <p><strong>中国人民银行颁发</strong></p>
            <p>瑞思科雷征信有限公司<br>企业征信牌照</p>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license6.jpg')}}">
            <p><strong>香港证监会颁发</strong></p>
            <p>耀盛资本有限公司<br>机构融资上市保荐牌照</p>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license7.jpg')}}">
            <p><strong>香港证监会颁发</strong></p>
            <p>耀盛基金管理有限公司<br>资产管理牌照</p>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license8.jpg')}}">
            <p><strong>香港证监会颁发</strong></p>
            <p>耀盛证券有限公司<br>证券交易牌照</p>
        </li>
        <li>
            <img src="{{assetUrlByCdn('/static/activity/loan/images0915/license9.jpg')}}">
            <p><strong>香港东区法院颁发</strong></p>
            <p>亚洲信贷有限公司<br>放债人牌照</p>
        </li>
    </ul>
    <div class="loan-title title5"></div>
    <div class="loan-media">
        <img src="{{assetUrlByCdn('/static/activity/loan/images0915/media1.jpg')}}">
        <img src="{{assetUrlByCdn('/static/activity/loan/images0915/media2.jpg')}}">
        <img src="{{assetUrlByCdn('/static/activity/loan/images0915/media3.jpg')}}">
        <img src="{{assetUrlByCdn('/static/activity/loan/images0915/media4.jpg')}}">
    </div>
</div>
{{--<div class="loan-right-bonus">
    <a href="javascript:;" class="loan-right-btn" data-layer="layer-wrap" id='btn-loan-bonus' lottery-lock="open" attr-static-url="{{$schema}}">领1%加息券</a>
    <input type="hidden" name="_token"  value="{{csrf_token()}}">
</div>--}}


{{--
<!-- 领取成功弹窗 -->
 <div class="pop-wrap  layer-wrap1" style="display: none;">--}}
    {{--<div class="pop-mask"></div>--}}
    {{--<div class="lantern-pop">--}}
        {{--<i class="pop-close" data-toggle="mask" data-target="layer-wrap1"></i>--}}
        {{--<div class="loan-icon"><img src="{{assetUrlByCdn('/static/activity/loan/images/sucess.png')}}" width="90" height="90"></div>--}}
        {{--<p class="text3">领取成功！</p>--}}
        {{--<p class="text6">请在【资产-我的优惠券】中查看</p>--}}
        {{--<a class="loan-btn1" href="javascript:;" data-toggle="mask" data-target="layer-8" >好　的</a>--}}
    {{--</div>--}}
 {{--</div>--}}

 {{--

<!-- 确定领取加息券弹窗 -->
 <div class="pop-wrap  layer-wrap" style="display: none;">
    <div class="pop-mask"></div>
    <div class="lantern-pop">
        <div class="loan-pop-title">
            <p>热烈庆祝耀盛网络小贷开业<br>1%加息券免费领！</p>
        </div>
        <i class="pop-close" data-toggle="mask" data-target="layer-wrap"></i>
        <div class="loan-icon1"><img src="{{assetUrlByCdn('/static/activity/loan/images0915/pop-bonus.png')}}" width="145" height="103"></div>
        <a class="loan-btn1 " href="javascript:;"  id="lottery-loan-bonus">确定领取</a>
        <div class="loan-pop-info">
            <dl>
                <dt>领取时间：</dt>
                <dd>{{date('Y年m月d日' ,$activityTime['start'])}} 至 {{date('m月d日' ,$activityTime['end'])}}</dd>
                <dt>活动说明：</dt>
                <dd>活动期间用户每日均可领取一次，自领取之日起有效期10天，仅限投资3、6、12月期及九安心项目。</dd>
            </dl>
        </div>
    </div>
 </div>

 <!-- 确定领取加息券弹窗 -->
 <div class="pop-wrap  layer-message" style="display: none;">
    <div class="pop-mask"></div>
    <div class="lantern-pop">
        <div class="loan-pop-title">
            <p>热烈庆祝耀盛网络小贷开业<br>1%加息券免费领！</p>
        </div>
        <i class="pop-close" data-toggle="mask" data-target="layer-message"></i>
        <div class="loan-icon"><img src="{{assetUrlByCdn('/static/activity/loan/images0915/pop-login.png')}}" width="71" height="71"></div>
        <p class="text5">客官别急，还没登录呢！</p>
        <a class="loan-btn1" href="javascript:;" >登 录</a>
    </div>
 </div>

--}}

@endsection
@section('jspage')
   

{{--<script type="text/javascript">

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


</script>--}}
@endsection