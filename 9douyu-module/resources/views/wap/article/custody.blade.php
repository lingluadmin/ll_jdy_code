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
        <li class="cur"><a href="/article/security">银行存管</a></li>
        <li><a href="/article/compliance">平台合规</a></li>
        <li><a href="/article/riskManagement">权威风控</a></li>
    </ul>
    <div class="custody-banner"></div>
    <div class="custody-1">
        <h4 class="custody-title">资金由江西银行全面存管</h4>
        <p class="antwo-sum">拥抱监管 合规升级</p> 
        <p class="custody-text">2017年7月10日，九斗鱼正式与江西银行达成资金存管合作，即日起双方开始启动系统技术对接，存管系统上线后，“鱼客”的资金将全部迁移至银行存管系统开设的对应独立账户，由江西银行对资金进行全面监督管理，交易流程更加真实、“鱼客”资金更加安全。</p>   
    </div>
    <div class="security-box">
        <h4 class="custody-title1">坚守“工匠精神” 不忘初心</h4>
        <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="custody-title2">一起回顾那些平淡但不平凡的历程</div>
                        <div class="custody-bg">
                            <p>“心安财有余”，从2014年平台上线至今，九斗鱼用“匠人”精神雕琢产品，用“敬畏”心理衡量风险，用“融合”理念牵手银行，只为打造一个属于“鱼客”的安全的、可信的、合规的平台。</p>
                        </div>
                        <dl class="custody-history">
                            <dt>2017年7月</dt>
                            <dd>九斗鱼牵手江西银行达成资金存管合作</dd>
                            <dt>2017年3月</dt>
                            <dd>九斗鱼荣获2017中国消费市场影响力品牌“最具创新价值品牌”大奖</dd>
                            <dt>2017年1月</dt>
                            <dd>九斗鱼CEO郭鹏获选“科技金融创客先锋”</dd>
                        </dl>
                    </div>
                    <div class="swiper-slide">
                        <dl class="custody-history">
                            <dt>2016年12月</dt>
                            <dd>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</dd>
                            <dt>2016年12月</dt>
                            <dd>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</dd>
                            <dt>2016年11月</dt>
                            <dd>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</dd>
                            <dt>2016年10月</dt>
                            <dd>九斗鱼取得《中华人民共和国电信与信息服务业务经营许可证》以及ICP备案证</dd>
                            <dt>2016年8月</dt>
                            <dd>九斗鱼CEO郭鹏入选《快公司》“中国商业最具创意人物100”</dd>
                            <dt>2016年5月</dt>
                            <dd>九斗鱼荣获中国金融博物馆“2015互联网金融创新季度新秀”</dd>
                            <dt>2016年3月</dt>
                            <dd>九斗鱼成为中关村互联网金融行业协会（北京中关村管委会旗下）副会长单位</dd>
                        </dl>
                    </div>
                    
                    <div class="swiper-slide">
                        <dl class="custody-history less">
                            <dt>2015年12月</dt>
                            <dd>九斗鱼入选《投资者报》“2015互联网金融公司社会责任榜十强”</dd>
                            <dt>2015年12月</dt>
                            <dd>九斗鱼接入央行旗下中国支付清算协会互联网金融委员会风险信息共享系统</dd>
                            <dt>2015年9月</dt>
                            <dd>九斗鱼入选第九届中国中小企业节创新百强企业</dd>
                            <dt>2015年7月</dt>
                            <dd>九斗鱼CEO郭鹏荣获“2015最佳青年榜样”；九斗鱼荣获“2015互联网金融最佳品牌奖”</dd>
                            <dt>2015年7月</dt>
                            <dd>九斗鱼入选《中国企业家》“未来之星”2015最具成长性的新兴企业TOP100</dd>
                            <dt>2015年5月</dt>
                            <dd>九斗鱼接入上海资信有限公司NFCS网络金融征信系统</dd>
                            <dt>2015年2月</dt>
                            <dd>九斗鱼荣获互联网金融领军榜“年度创新品牌”大奖</dd>
                            <dt>2015年1月</dt>
                            <dd>九斗鱼与东亚银行达成风险准备金资金管理协议</dd>
                        </dl>
                    </div>
                    <div class="swiper-slide">
                        <dl class="custody-history less">
                            <dt>2014年11月</dt>
                            <dd>九斗鱼荣获易观之星“互联网金融创新奖”</dd>
                            <dt>2014年9月</dt>
                            <dd>九斗鱼的风控技术瑞思科雷RISKCALC获得国家版权局颁发的计算机软件著作权登记证书</dd>
                            <dt>2014年8月</dt>
                            <dd>九斗鱼与CFCA达成战略合作</dd>
                            <dt>2014年6月27日</dt>
                            <dd>九斗鱼正式上线推广</dd>
                        </dl>
                    </div>
                </div>
                <!-- 分页器 -->
                <div class="swiper-pagination"></div>
                
                <!-- 导航按钮 -->
                <!-- <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div> -->
            </div>
    </div>
    <div class="security-box security-content">
        <h4 class="custody-title1">恪守规则 安全护航 携手江西银行</h4>
        <dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/img1.png')}}" class="img"></dt>
            <dd>
                <h4>实力雄厚 强强联合</h4>
                <p>江西银行是2015年12月3日经中国银行业监督管理委员会批复，由南昌银行吸收合并景德镇市商业银行而成，注册资本23.82亿元，在英国《银行家》(The Banker)杂志2016年全球1000家大银行榜单中，江西银行位居全球308位，一级资本增速在在全球银行排名第六。</p>
            </dd>
        </dl>
        <dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/img2.png')}}" class="img"></dt>
            <dd>
                <h4>存管系统成熟 体验更加完美</h4>
                <p>江西银行对九斗鱼平台的资金将采取银行直接存管模式，会为“鱼客”、借款人开设独立存管账户，就充值、提现等支付结算和资金流向进行监管。因为资金并不流向平台，将平台资金和“鱼客”资金有效隔离，阻断平台触碰资金，保障交易流程的真实和“鱼客”的资金安全。</p>
            </dd>
        </dl>
        <dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/img3.png')}}" class="img"></dt>
            <dd>
                <h4>交易透明 资金安全</h4>
                <p>资金存管上线后，江西银行为“鱼客”和借款人开设独立的资金存管账户，所有涉及资金变动的操作都由“鱼客”发出的授权交易码为准，平台无权动用资金，保障资金安全。</p>
            </dd>
        </dl>
        <dl>
            <dt><img src="{{assetUrlByCdn('/static/weixin/activity/security/images/img4.png')}}" class="img"></dt>
            <dd>
                <h4>接入存管 全方位提升投资安全等级</h4>
                <p>资金的全面隔离：为“鱼客”设立独立账户，并与平台运营账户分离，实现平台自有资金和“鱼客”资金全面隔离。</p>
                <p>信息更加真实透明：“鱼客”发起的所有涉及资金的操作，均由存管系统根据“鱼客”指令进行操作，同时对资金流水及交易过程相关信息进行存档，“鱼客”可通过存管账户进行查询了解，信息更加真实透明。</p>
                <p>用户授权交易：“鱼客”在开通江西银行存管账户时，需设置独立的交易密码。所有涉及资金变动的操作，均需进行交易密码授权，方可由江西银行存管系统进行操作。</p>
            </dd>
        </dl>
    </div>
</article>
<script type="text/javascript" src="{{assetUrlByCdn('/static/weixin/js/jquery-1.9.1.min.js')}}"></script>
<script type="text/javascript" src="{{assetUrlByCdn('/static/weixin/js/swiper3.1.0.jquery.min.js')}}"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        // nextButton: '.swiper-button-next',
        // prevButton: '.swiper-button-prev',
        loop:false,  
       mode: 'horizontal',  
       freeMode:false,  
       touchRatio:0.5,  
       longSwipesRatio:0.1,  
       threshold:50,  
       followFinger:false,  
       observer: true,//修改swiper自己或子元素时，自动初始化swiper  
       observeParents: true,//修改swiper的父元素时，自动初始化swiper  
    });

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
