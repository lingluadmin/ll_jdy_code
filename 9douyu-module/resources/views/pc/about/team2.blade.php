@extends('pc.common.layoutNew')
@section('title', '管理团队')
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/css/pc4/about.css')}}">
@endsection
@section('content')
@include('pc.about/aboutMenu')
<div class="v4-team2-banner"></div>
<div class="v4-team2-wrap">
  <div class="v4-about-title">
      <h2>管理团队</h2>
      <p class="v4-about-line"></p>
  </div>
  <div class="v4-wrap-team2">
    <div class="v4-team2-main">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img1.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>郭 鹏</h3>
        <h4>九斗鱼 CEO</h4>
        <p>毕业于首都师范大学，信息数学学士学位；</p>
        <p>拥有11年以上金融、支付行业资深经验，曾任职钱袋宝支付，先后担任互联网事业部总监、产品运营中心总经理、商务合作中心总经理；还曾任职天机移联营销总监，并成功将天机移联打造为全国最大的数字产品分销商；</p>
        <p>曾荣获中国财经峰会“最佳青年榜样”奖项；入选美国著名商业杂志《Fast Company》中文版 “中国商业最具创意人物100”。</p>
      </div>
    </div>
    <div class="v4-team2-main v4-team2-second">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img2.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>王春乾</h3>
        <h4>九斗鱼 COO</h4>
        <p>毕业于南京工业大学，管理学学士学位；</p>
        <p>拥有12年以上互联网金融行业资深经验，曾任职宜信等多家互联网金融行业上市公司、持牌机构，作为业务负责人主持过多个大型IT系统的建设工作，并主导过各类金融牌照的申请工作；</p>
        <p>任职宜信期间，作为业务负责人主导过宜信惠民平台及其信贷产品的产品设计、研发和运营推广工作，具备行业领先的互联网金融产品设计及运营推广经验。</p>
      </div>
    </div>
    <div class="v4-team2-main">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img3.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>王懿</h3>
        <h4>九斗鱼 CTO</h4>
        <p>毕业于哈尔滨工业大学，计算机信息管理专业；</p>
        <p>拥有10年以上互联网行业资深经验，曾任职乐视网、宜信等多家互联网行业上市公司，担任研发总监；</p>
        <p>任职宜信期间，作为研发负责人主持过宜信惠民平台、宜信普惠惠农平台、投米网、宜信支付结算系统等数十个项目的研发工作，并深度参与了由政府监管机构发起的中国互金协会产品登记系统的产品设计、研发工作，具备丰富的互联网金融领域业务分析及研发经验。</p>
      </div>
    </div>
    <div class="v4-team2-main v4-team2-second">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img4.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>孔令珍</h3>
        <h4>九斗鱼 CFO</h4>
        <p>毕业于对外经济贸易大学，财务管理专业；</p>
        <p>拥有20年以上大中型企业财务管理经验，曾任职嘉信保险、崇高妈妈，担任财务总监；</p>
        <p>精通集团企业的财务管理体系建设，善于健全公司内部核算、财务管理等规范化制度，并具有丰富的财务管理、资本运营和投融资管理经验。</p>
      </div>
    </div>
    <div class="v4-team2-main">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img5.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>肖可</h3>
        <h4>九斗鱼 风控总监</h4>
        <p>毕业于中国人民大学，经济学学士学位；澳大利亚麦考利大学，金融学硕士学位；持有美国特许金融分析师资格证书；</p>
        <p>拥有20年以上金融行业资深经验，曾任职中信银行总行、中国中化集团公司、普华永道会计师事务所，担任信贷风控负责人、财务负责人、高级审计师职务；</p>
        <p>精通集团企业及上市公司的财务管理体系、内控体系构建优化，对企业经营风险管理、财务管理等具备丰富的经验。</p>
      </div>
    </div>
    
    <div class="v4-team2-main  v4-team2-second">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img6.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>李毅凤</h3>
        <h4>九斗鱼 法务总监</h4>
        <p>毕业于北京大学，法律学硕士学位；持有法律职业资格证书、律师执业证、基金从业资格证书；</p>
        <p>拥有10年以上互联网及金融行业资深经验，曾任职千橡互动集团、英泰格瑞投资有限公司，担任法务负责人职务；</p>
        <p>任职千橡互动集团期间，曾负责集团互联网金融、基金、投融资及并购业务的法律工作；任职英泰格瑞投资有限公司期限，曾深度参与过多个基金和其他金融产品的设计、发行工作，并负责投融资方案设计及法律工作。</p>
      </div>
    </div>
    
      
    <div class="v4-about-title">
      <h2>专家团队</h2>
      <p class="v4-about-line"></p>
    </div>

    <div class="v4-team2-main">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img7.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>原旭霖</h3>
        <h4>耀盛中国 总裁</h4>
        <p>毕业于北京大学中国经济研究中心，数学与应用数学、经济学双学士学位，管理学硕士学位；耀盛（亚洲）投资控股有限公司中国区首席代表；中国中小企业协会常务理事；深圳商业保理协会常务副会长；</p>
        <p>中国中小企业信用评级标准——RISKCALC标准制定者，中小企业信用评级模型——DSR算法创立者，业界著名的中小企业信用评级专家。他创立的RISKCALC中小企业信用评级标准，受到印尼政府、中国银行业协会、中国金融会计学会、中国中小企业协会等政府及行业组织的好评。</p>
      </div>
    </div>
    
    <div class="v4-team2-main  v4-team2-second">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img8.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>陈贤伟</h3>
        <h4>耀盛亚洲 执行董事</h4>
        <p>毕业于美国纽约哥伦比亚大学，土木工程学士学位；香港会计师公会会员；拥有英格兰及威尔士特许会计师协会资格；</p>
        <p>拥有25年以上金融行业工作经验，过往管理资产超过100亿元。曾任香港交易所上市公司董事及策略委员会成员、领盛投资管理公司大中华区董事、麦格理亚洲房地产有限公司董事总经理、盈科集团房地产部亚太区副总裁、百富勤融资有限公司联席董事、帝杰投资银行副总裁及CP CAPITAL INC.创始人；曾获年度十大中国房地产金融杰出推动力人物奖。</p>
        <p>历史主要业绩：</p>
        <p class="v4-team2-dot">收购于大中华区内约3.8亿美元的地产项目</p>
        <p class="v4-team2-dot">负责DLJ投资银行亚太区业务，为区内科技公司募集资金超过3亿美元</p>
        <!-- <p class="v4-team2-dot">负责DLJ投资银行亚太区业务，为区内科技公司募集资金超过3亿美元</p> -->
        <!-- <p class="v4-team2-dot">帮助DLJ Asia Technology Ventures获得7500万美元投资</p> -->
      </div>
    </div>

    <div class="v4-team2-main">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img9.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>杜国健</h3>
        <h4>耀盛基金 执行董事</h4>
        <p>毕业于香港中文大学，中国商业法律硕士学位；加拿大西安大略大学经济学硕士学位；</p>
        <p>拥有15年以上风险投资基金及对冲基金管理经验，涉及金额超过60亿元。曾担任BNP百富勤计量分析师、法兴证券经济分析师、日本上市券商AKATSUKI FG高级顾问。</p>
        <p>历史主要业绩：</p>
        <p class="v4-team2-dot">管理软银集团私募基金，规模5亿元</p>
        <p class="v4-team2-dot">管理中国皇龙资产“中国多策略基金”，规模8亿元</p>
        <p class="v4-team2-dot">管理“软库中华金融并购基金”，规模2亿元</p>
      </div>
    </div>
    
    <div class="v4-team2-main  v4-team2-second">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img10.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>梁晋华</h3>
        <h4>耀盛基金 联席董事</h4>
        <p>毕业于香港理工大学，屋宇设备工程学学士学位；</p>
        <p>拥有17年以上金融行业经验，管理投资组合经验超10年；曾任职华泰证券、台湾元富证券等证券机构，为亚洲地区高净值客户提供委托资产管理服务；</p>
        <p>具备丰富的亚洲地区投资市场操作经验，尤其擅长港股、A股及债劵市场，管理单只基金资产超过2亿元。</p>
        
      </div>
    </div>

    <div class="v4-team2-main">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img11.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>关文杰</h3>
        <h4>耀盛资本 行政总裁</h4>
        <p>毕业于香港科技大学，工商管理硕士学位；美国加州大学洛杉机分校，商业及经济学学士学位；美国执业会计师公会会员；香港会计师公会会员。</p>
        <p>拥有20年以上投资银行业工作经验，参与保荐上市、并购重组的项目超过50个，涉及金额超过200亿元。曾任职香港交易所上市科、海通国际企业融资部董事总经理、新鸿基金融的企业融资部、美资国际投资银行派杰亚洲、TOM集团企业融资部及毕马威会计师事务所；其中任职香港交易所期间，负责审阅公司上市申请项目超过30个。</p>
        <p>历史主要业绩：</p>
        <p class="v4-team2-dot v4-team2-half">K W NELSON GP（08411.HK）上市</p>
        <p class="v4-team2-dot v4-team2-half">顺泰控股（01335.HK）上市</p>
        <p class="v4-team2-dot v4-team2-half">国投集团控股（原“盈进集团”，01386.HK）上市 </p>
        <p class="v4-team2-dot v4-team2-half">朗生医药（00503.HK）上市</p>
        <p class="v4-team2-dot v4-team2-half">微创医疗（00853.HK）上市</p>
        <p class="v4-team2-dot v4-team2-half">琥珀能源（00090.HK）上市</p>
      </div>
    </div>
    
    <div class="v4-team2-main  v4-team2-second">
      <div class="v4-team2-img">
        <img src="{{ assetUrlByCdn('/static/images/pc4/team2/team2-img12.jpg')}}">
      </div>
      <div class="v4-team2-txt">
        <h3>邢紫君</h3>
        <h4>耀盛资本 执行董事</h4>
        <p>毕业于加拿大不列颠哥伦比亚大学，工商管理硕士学位；美国注册会计师协会（AICPA）成员；</p>
        <p>拥有16年以上投资银行及金融服务业工作经验，成功领导完成上市、收购合并、财务顾问及融资的项目超过20个，涉及金额超过50亿元。曾任职RaffAello Capital Ltd公司董事、海通国际企业融资部副总裁、Tak Fook资本及安永会计师事务所。</p>
        <p>历史主要业绩：</p>
        <p class="v4-team2-dot v4-team2-half">巨星医疗控股（02393.HK）上市</p>
        <p class="v4-team2-dot v4-team2-half">荣丰联合控股（03683.HK）上市</p>
        <p class="v4-team2-dot v4-team2-half">粤海投资（00270.HK）收购财务顾问</p>
        <p class="v4-team2-dot v4-team2-half">华润置地（01109.HK）收购财务顾问</p>
      </div>
    </div>

  </div>
</div>
@endsection
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/tabs.js')}}"></script>
<script type="text/javascript">
  $(function(){
    $('.Js_tab_box1').tabs({action: "click" });
  })
</script>
@endsection