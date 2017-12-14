<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title>耀盛互联网小贷完成工商注册</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/reset12.css')}}" />
    <script>
        var readyRE = /complete|loaded|interactive/;
        var ready = window.ready = function (callback) {
            if (readyRE.test(document.readyState) && document.body) callback()
            else document.addEventListener('DOMContentLoaded', function () {
                callback()
            }, false)
        }
        //rem方法
        function ready_rem() {
            var view_width = document.getElementsByTagName('html')[0].getBoundingClientRect().width;
            var _html = document.getElementsByTagName('html')[0];


            if (view_width > 750) {
                _html.style.fontSize = 750 / 16 + 'px'
            } else if(screen.height>500){
                _html.style.fontSize = view_width / 18 + 'px';
                if(screen.height==1280&&screen.width==800){
                    _html.style.fontSize = view_width / 22 + 'px';
                }
            }else{

                _html.style.fontSize = 15 + 'px'
            }

        }
        ready(function () {
            ready_rem();
        });

    </script>
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/activity/loan/css/index.css')}}"  id="sc" />
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/animations.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/animate.min.css')}}" />
        
</head>
<body>


            <div class="first-swiper-slide">
               
                <div class="page1-text pt-page-scaleUp">
                    <p class="page1-text-1">打破<span>地域瓶颈</span> 开启业务<span>新篇章</span></p>
                    <p class="page1-text-2">耀盛互联网小贷完成<span>工商注册</span></p>
                    <p class="page1-text-3">{{date('Y年m月d日' ,$activityTime['start'])}} - {{date('m月d日' ,$activityTime['end'])}}</p>

                </div>
                <div class="page1-bonus animated fadeInLeft pt-page-delay300">
                    <div class="page1-info animated fadeInRight pt-page-delay500">
                        <h6>1%加息券</h6>
                        <p>活动期间用户每日都可领取一次</p>
                        <p>仅限投资3、6、12月期及九安心项目</p>
                        <p>自领取之日起有效期10天</p>
                    </div>

                    <a href="javascript:;" class="page1-bonus-btn" id="btn-loan-bonus" lottery-lock="open" attr-static-url="{{env('STATIC_URL_HTTPS')}}">立即领取</a>
                    <input type="hidden" name="_token"  value="{{csrf_token()}}">

                </div>
                

            </div>

            <div class="second-swiper-slide">
              
                <div class="inner-title animated fadeInLeft">广州耀盛网络小额贷款有限公司在穗开业</div>
                <div class="swiper-container swiper-container-v">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img  src="{{assetUrlByCdn('/static/weixin/activity/loan/images/index-img1.jpg')}}" />
                            <p>耀盛网络小贷<br>在广东开业剪彩</p>
                        </div>
                        <div class="swiper-slide">
                            <img  src="{{assetUrlByCdn('/static/weixin/activity/loan/images/index-img2.jpg')}}" />
                            <p>广东省中小企业服务中心<br>陈健主任在开业仪式上致辞</p>
                        </div>
                        <div class="swiper-slide">
                            <img  src="{{assetUrlByCdn('/static/weixin/activity/loan/images/index-img3.jpg')}}" />
                            <p>耀盛网络小贷<br>原旭霖总经理在开业仪式上致辞</p>
                        </div>
                    </div>

                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="inner-main animated fadeInRight">
                    <p class="indent">2017年9月6日,耀盛投资管理集团有限公司（以下简称“耀盛中国”）旗下的广州耀盛网络小额贷款有限公司（以下简称“耀盛网络小贷”）在广州正式开业，广东省中小企业服务中心、广州市金融局、广州市越秀区金融局、广州市越秀区民间金融街管委会、江西银行广东省分行、江西银行越秀支行、广州交易所集团等相关单位主管领导，以及耀盛中国总裁兼耀盛网络小贷总经理原旭霖出席了开业仪式，并进行开业剪彩。</p>
                    <p class="indent">据悉，耀盛网络小贷于2017年7月28日完成工商注册，由耀盛中国100%持股，经营范围为货币金融服务。开业活动现场，广东省中小企业服务中心、广州市金融局、广州市越秀区金融局等与会领导对耀盛网络小贷落户广州市越秀区表示热烈祝贺，并寄予殷切厚望。</p>
                    <p>广东省中小企业服务中心陈健主任表示：“耀盛网络小贷今天正式开业，这意味着耀盛中国将符合监管要求，合法合规地开展网络小贷业务。希望耀盛中国可以充分发挥集团多年服务中小企业的经验优势，针对中小企业‘短、小、频、急’的金融需求，真正将中小企业金融服务工作落到实处，做到细处，实现中小企业与集团自身的共赢发展。”</p>
                    <p class="bold">耀盛网络小贷“青眼”广州</p>
                    <p>据第一消费金融2017年8月31日最新发布的不完全统计数据称，目前市场上有214张网络小贷牌照，其中186张已经完成工商注册，在这186张牌照中，广州以39张的数量占据首位，占比约21%。</p>
                    <p>“很显然，广州市，作为全国网络小贷的先行试验区，是众多网络小贷公司落户的首选之地。”原旭霖表示，“这与其市场大环境密不可分。首先，作为国家中心城市、国家移动互联网的起源地、国家电子商务示范城市和在全国具有重要影响力的区域金融中心，广州具有发展网络小贷的有利条件和坚实基础。其次，纵观各地网络小贷的现状，众多网络小贷企业云集广州，聚集效应明显。产业基础扎实，政府政策支持，因此，广州成为了耀盛网络小贷落户的不二之选。”</p>
                    <p class="bold">网络小贷“助推”耀盛中国跨区展业</p>
                    <p>近两年来，网络小贷迅速发展，网络小贷牌照已然是时下最受关注的焦点和众资本竞相追逐的对象。原旭霖表示：“但耀盛中国此次布局网络小贷却非对‘一牌难求’的盲目追捧，而是集团业务发展到一定阶段的必然行为。”</p>
                    <p>耀盛中国，深耕中小企业金融生态圈11年，目前已全面布局小额信贷、商业保理、融资租赁、征信评价、智能支付、私募股权、电影金融、证券经纪、上市保荐、基金管理等业务，此外集团还进一步布局了金融科技领域，致力于服务中小企业从初创、成立到发展成熟的全生命周期。</p>
                    <p>但是，即便如此，仍不乏有传统的线下小贷输送过来的有借贷需求的客户，抑或是在保理业务之外有小额贷款需求的保理客户，或是融资租赁部分有流动资金需求的企业，受困于“地域限制问题”。</p>
                    <p>在这样的背景下，耀盛中国应势而谋、因势而动，布局网络小贷。“此次耀盛网络小贷的开业对于集团的业务发展具有重要的战略意义。”原旭霖表示，“网络小贷牌照这张‘通行证’打破了地域限制的‘紧箍咒’，依托这张牌照，耀盛中国将进军全国市场，有望为中小企业提供更快捷、更灵活、更高效的金融服务。”</p>
                </div>
            </div>



            



<section class="pop-wrap" id="pop-receive">
    <div class="pop-mask"></div>
    <div class="pop">
        <span class="pop-close"></span>
        <div class="pop-text-receive">
            <p><img class="pop-receive-img" src="{{assetUrlByCdn('/static/weixin/activity/loan/images/pop-bonus.png')}}" /></p>
            <p>确定领取1%定期加息券？</p>
        </div>
        <a href="javascript:;" class="pop-btn" id="lottery-loan-bonus">确 定</a>
    </div>
</section>

<section class="pop-wrap" id="pop-success" >
    <div class="pop-mask"></div>
    <div class="pop">
        <span class="pop-close"></span>
        <div class="pop-text-success">
            <p><img class="pop-success-img" src="{{assetUrlByCdn('/static/weixin/activity/loan/images/pop-success.png')}}" /></p>
            <p>领取成功！</p>
            <p>请在【资产-我的优惠券】中查看</p>
        </div>
        <a href="javascript:;" class="pop-btn">好 的</a>
    </div>
</section>

<section class="pop-wrap" id="pop-success1">
    <div class="pop-mask"></div>
    <div class="pop">
        <span class="pop-close"></span>
        <div class="pop-text-success">
            <p><img class="pop-success-img" src="{{assetUrlByCdn('/static/weixin/activity/loan/images/pop-login.png')}}" /></p>
            <p>领取成功！</p>
            <p>请在【资产-我的优惠券】中查看</p>
        </div>
        <a href="javascript:;" class="pop-btn">好 的</a>
    </div>
</section>


<script src="{{assetUrlByCdn('/static/weixin/js/jquery-1.9.1.min.js')}}"></script>
<script  type="text/javascript" src="{{assetUrlByCdn('/static/weixin/activity/loan/js/loan.js')}}"></script>
<script src="{{ assetUrlByCdn('/static/weixin/activity/zt315/js/swiper3.1.0.jquery.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

  
    var swiperV = new Swiper('.swiper-container-v', {
        pagination: '.swiper-pagination-v',
        paginationClickable: true,
        // direction: 'vertical',
        spaceBetween: 50,
        autoplay: 3000,
        loop: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
    });
</script>
<script type="text/javascript">

(function($){

    $(function(){
        var evclick = "ontouchend" in window ? "touchend" : "click";
        // 弹层关闭按钮
        $(document).on(evclick,'.pop-close,.pop-mask,.pop-btn-mask',function() {
            $('#btn-loan-bonus').attr('lottery-lock','open');
            $('.pop-wrap').hide();
        })

        $(document).on(evclick,'#btn-loan-bonus',function() {
            $('#pop-receive').show();
        })
        $(document).on(evclick, '#lottery-loan-bonus',function(event){
            event.stopPropagation();
            var $target = $("#pop-receive");
            $target.hide();
            LoanBonus.doLoanDraw(event);
        });
        $(document).delegate(".userDoLogin","click",function () {
            var client = getCookie('JDY_CLIENT_COOKIES');
            if( client == '' || !client ){
                client  =   '{{$client or "wap"}}';
            }
            if( client =='ios'){
                if(version =='4.1.2') {
                    window.location.href='/login';
                    return false
                } else {
                    window.location.href = "objc:gotoLogin";
                    return false;
                }
            }
            if (client =='android'){
                window.jiudouyu.login();
                return false;
            }
            window.location.href='/login';
        })

    })
})(jQuery)
function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=")
        if (c_start!=-1){
            c_start=c_start + c_name.length+1
            c_end=document.cookie.indexOf(";",c_start)
            if (c_end==-1) c_end=document.cookie.length
            return unescape(document.cookie.substring(c_start,c_end))
        }
    }
    return ""
}
</script>
{{--@include('wap.common.sharejs')--}}
</body>
</html>
