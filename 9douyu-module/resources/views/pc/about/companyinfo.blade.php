@extends('pc.common.layoutNew')
@section('title','机构信息')
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/assets/css/pc4/jquery.fancybox-1.3.4.css')}}">
<style type="text/css">
 #fancybox-left,#fancybox-right{display: none !important;}
</style>
@endsection
@section('content')
   <div class="v4-wrap">
   <h2 class="v4-account-titlex v4-help-title v4-mt-plus-20">机构信息</h2>
      <div class="v4-company-wrap">
        <div class="v4-tabel-detail-wrap">
              <table class="v4-tabel-detail">
                <tr class="grey">
                  <td><label>企业名称及简称</label></td>
                  <td>星果时代信息技术有限公司</td>
                  <td><label>注册资本</label></td>
                  <td>6000万元</td>
                </tr>
                <tr>
                  <td><label>实缴资本</label></td>
                  <td>5880万元</td>
                  <td><label>注册地址</label></td>
                  <td>北京市海淀区厢黄旗2号楼2层X06-851室</td>
                </tr>
                <tr class="grey">
                  <td><label>成立时间</label></td>
                  <td>2015-11-27</td>
                  <td><label>法定代表人</label></td>
                  <td>郭鹏</td>
                </tr>
                <tr>
                  <td><label>联系方式</label></td>
                  <td>客服电话：400-6686-568</td>
                  <td><label>经营场所</label></td>
                  <td>北京市朝阳区郎家园6号郎园vintage2号楼A座2层</td>
                </tr>
                <tr class="grey">
                  <td valign="top"><label>经营范围</label></td>
                  <td colspan="3">软件开发；软件咨询；技术开发、技术推广、技术咨询、技术服务、技术转让；销售自行开发的产品；计算机系统服务；基础软件服务；应用软件服务；经济贸 易咨询；设计、制作、代理、发布广告。(企业依法自主选择经营项目，开展经 营活动;依法须经批准的项目，经相关部门批准后依批准的内容开展经营活动；不得从事本市产业政策禁止和限制类项目的经营活动。</span></td>
                </tr>
              </table>
            </div>
      </div>
      <h2 class="v4-account-titlex v4-help-title v4-mt-15">治理信息</h2>
      <div class="v4-company-wrap">
        
        <div class="v4-company-info">
          <h4>星果时代信息技术有限公司</h4>
          <div class="a-line"></div>
          <ul class="v4-company-line clearfix">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
          </ul>
          <ul class="v4-company-text clearfix">
            <li class="li1"><i class="v4-iconfont">&#xe6c3;</i>研发部</li>
            <li class="li2"><i class="v4-iconfont">&#xe6be;</i>产品部</li>
            <li class="li3"><i class="v4-iconfont">&#xe6c0;</i>运营部</li>
            <li class="li4"><i class="v4-iconfont">&#xe6bd;</i>客服部</li>
            <li class="li5"><i class="v4-iconfont">&#xe6bc;</i>财务部</li>
            <li class="li6"><i class="v4-iconfont">&#xe6c2;</i>风控部</li>
            <li class="li7"><i class="v4-iconfont">&#xe6bf;</i>法务部</li>
            <li class="li8"><i class="v4-iconfont">&#xe6c1;</i>人力资源部</li>
          </ul>
        </div>
        
      </div>
      <h2 class="v4-account-titlex v4-help-title v4-mt-15">平台信息</h2>
      <div class="v4-company-wrap">
        
        <div class="v4-tabel-detail-wrap">
              <table class="v4-tabel-detail">
                <tr class="grey">
                  <td><label>网站或平台名称</label></td>
                  <td>星果时代信息技术有限公司</td>
                  <td><label>电信业务经营许可证</label></td>
                  <td>京ICP证161222号&nbsp;&nbsp;&nbsp;&nbsp;京ICP备16011752号-1</td>
                </tr>
                <tr>
                  <td><label>平台运营时间</label></td>
                  <td>2014-6-1</td>
                  <td><label>移动APP应用</label></td>
                  <td>九斗鱼</td>
                </tr>
                <tr class="grey">
                  <td valign="top"><label>网站或平台地址</label></td>
                  <td>www.9douyu.com<br>www.jiudouyu.com</td>
                  <td valign="top"><label>公众号或服务号</label></td>
                  <td>微信订阅号:九斗鱼（jiudouyu）<br>微信服务号:九斗鱼（wx_jiudouyu）</td>
                </tr>
              </table>
            </div>
      </div>
      <h2 class="v4-account-titlex v4-help-title v4-mt-15">平台资质</h2>
      <div class="v4-company-wrap">
        <ul class="v4-company-aptitude clearfix">
          <li class="li1">
            <img src="{{assetUrlByCdn('/static/images/pc4/company/aptitude4.png')}}">
            <span></span>
            <p>ICP</p>
            <a href="{{assetUrlByCdn('/static/images/pc4/compliance/compliance-pic1.jpg')}}" rel='example_group' class="v4-btn v4-btn-primary">查看证书</a>
          </li>
          <li class="li2">
            <img src="{{assetUrlByCdn('/static/images/pc4/company/aptitude5.png')}}">
            <span></span>
            <p>AAA企业信用评级</p>
            <a  href="{{assetUrlByCdn('/static/images/pc4/compliance/compliance-pic4.jpg')}}" rel='example_group' class="v4-btn v4-btn-primary">查看证书</a>
          </li>
          <li class="li3">
            <img src="{{assetUrlByCdn('/static/images/pc4/company/aptitude1.png')}}">
            <span></span>
            <p>等保三级认证</p>
            <a href="{{assetUrlByCdn('/static/images/pc4/compliance/compliance-pic3.jpg')}}" rel='example_group' class="v4-btn v4-btn-primary">查看证书</a>
          </li>
        </ul>

       

      </div>
      
      
    </div><!--v4-account -->
    <div class="clear"></div>
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