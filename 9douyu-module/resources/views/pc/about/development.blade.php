@extends('pc.common.layoutNew')
@section('title', '发展历程')
@section('csspage')

@endsection
@section('content')
@include('pc.about/aboutMenu')
<div class="v4-custody-wrap v4-wrap">
      <div class="">
          <ul class="v4-tab Js_tab clearfix">
                @if( $type == \App\Http\Dbs\Article\ArticleDb::JDYEVENT)
                  <li class="cur" ><a href="/about/development?type={{\App\Http\Dbs\Article\ArticleDb::JDYEVENT}}">九斗鱼大事记</a></li>
                  <li ><a href="/about/development?type={{\App\Http\Dbs\Article\ArticleDb::YSEVENT}}">耀盛大事记</a></li>
                @else
                  <li ><a href="/about/development?type={{\App\Http\Dbs\Article\ArticleDb::JDYEVENT}}">九斗鱼大事记</a></li>
                  <li class="cur" ><a href="/about/development?type={{\App\Http\Dbs\Article\ArticleDb::YSEVENT}}">耀盛大事记</a></li>
                @endif
          </ul>
          <div class="js_tab_content">
                @if( $type == \App\Http\Dbs\Article\ArticleDb::JDYEVENT )
                    <div class="Js_tab_main Js_tab_box2" style="display: block;">
                        <!-- 九斗鱼大事件 -->
                        {{-- @include('pc.about.development9douyu') --}}
                        <div class="v4-development-tab clearfix" data-tab="9douyu">

                            @if($data["yearArr"])
                                @foreach( $data["yearArr"] as $key=>$val)
                                    <a href="javascript:;" @if($val == date("Y",time())) class="active" @endif >{{$val}}</a>
                                @endforeach
                            @endif
                            {{--
                            <a href="javascript:;" class="active">2016</a>
                            <a href="javascript:;">2015</a>
                            <a href="javascript:;">2014</a>
                            --}}
                        </div>

                        <div class="v4-development-main">
                            @if($data["yearData"])
                                @foreach( $data["yearData"] as $key=>$val)
                                    <dl class="v4-development-1" >
                                        <dd>
                                            <!-- 不跳转时 加forbidden -->
                                            @foreach( $val as $kk=>$vv)
                                                <a href="javascript:;" class="forbidden"><em>{{ $vv["month"] }}</em><b></b><span>{{$vv["title"]}}</span></a>
                                            @endforeach
                                            {{--
                                            <a href="javascript:;" class="forbidden"><em>8月02日</em><b></b><span>九斗鱼获得国家公安部门颁发认证的“信息系统安全等级保护”三级备案证明</span></a>
                                            <a href="#"><em>9月30日</em><b></b><span>九斗鱼荣获消费日报社颁发的2017年度“中国互联网金融行业最具创新价值品牌</span></a>
                                            <a href="#"><em>9月19日</em><b></b><span>九斗鱼CEO郭鹏获选《2016中国极客大奖》“科技金融创客先锋”</span></a>
                                            <a href="#"><em>10月19日</em><b></b><span>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</span></a>
                                            <a href="#"><em>11月20日</em><b></b><span>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</span></a>
                                            <a href="#" class="last"><em>12月30日</em><b></b><span>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</span></a>
                                            --}}
                                        </dd>
                                    </dl>
                                @endforeach
                            @endif
                            {{--
                            <dl class="v4-development-1" >
                                <dd>
                                    <!-- 不跳转时 加forbidden -->
                                    <a href="javascript:;" class="forbidden"><em>8月02日</em><b></b><span>九斗鱼获得国家公安部门颁发认证的“信息系统安全等级保护”三级备案证明</span></a>
                                    <a href="#"><em>9月30日</em><b></b><span>九斗鱼荣获消费日报社颁发的2017年度“中国互联网金融行业最具创新价值品牌</span></a>
                                    <a href="#"><em>9月19日</em><b></b><span>九斗鱼CEO郭鹏获选《2016中国极客大奖》“科技金融创客先锋”</span></a>
                                    <a href="#"><em>10月19日</em><b></b><span>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</span></a>
                                    <a href="#"><em>11月20日</em><b></b><span>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</span></a>
                                    <a href="#" class="last"><em>12月30日</em><b></b><span>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</span></a>
                                </dd>
                            </dl>
                            --}}
                        </div>

                    </div>
                @else
                    <div class="Js_tab_main Js_tab_box3" style="display: block;">
                        <!-- 耀盛大事件 -->
                        {{-- @include('pc.about.developmentsunfund') --}}

                        <div class="v4-development-tab clearfix" data-tab="sunfund">
                            @if($data["yearArr"])
                                @foreach( $data["yearArr"] as $key=>$val)
                                    <a href="javascript:;" @if($val == date("Y",time())) class="active" @endif >{{$val}}</a>
                                @endforeach
                            @endif
                        </div>

                        <div class="v4-development-main">
                            @if($data["yearData"])
                                @foreach( $data["yearData"] as $key=>$val)
                                    <dl class="v4-development-1">
                                        <dd>
                                            <!-- 不跳转时 加forbidden -->
                                            @foreach( $val as $kk=>$vv)
                                                <a href="javascript:;" class="forbidden"><em>{{ $vv["month"] }}</em><b></b><span>{{$vv["title"]}}</span></a>
                                            @endforeach
                                            {{--
                                            <a href="javascript:;" class="forbidden"><em>8月02日</em><b></b><span>九斗鱼获得国家公安部门颁发认证的“信息系统安全等级保护”三级备案证明</span></a>
                                            <a href="#"><em>9月30日</em><b></b><span>九斗鱼荣获消费日报社颁发的2017年度“中国互联网金融行业最具创新价值品牌</span></a>
                                            <a href="#"><em>9月19日</em><b></b><span>九斗鱼CEO郭鹏获选《2016中国极客大奖》“科技金融创客先锋”</span></a>
                                            <a href="#"><em>10月19日</em><b></b><span>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</span></a>
                                            <a href="#"><em>11月20日</em><b></b><span>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</span></a>
                                            <a href="#" class="last"><em>12月30日</em><b></b><span>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</span></a>
                                            --}}
                                        </dd>
                                    </dl>
                                @endforeach
                            @endif
                            {{--
                            <dl class="v4-development-1">
                                <dd>
                                    <!-- 不跳转时 加forbidden -->
                                    <a href="javascript:;" class="forbidden"><em>8月02日</em><b></b><span>九斗鱼获得国家公安部门颁发认证的“信息系统安全等级保护”三级备案证明</span></a>
                                    <a href="#"><em>9月30日</em><b></b><span>九斗鱼荣获消费日报社颁发的2017年度“中国互联网金融行业最具创新价值品牌</span></a>
                                    <a href="#"><em>9月19日</em><b></b><span>九斗鱼CEO郭鹏获选《2016中国极客大奖》“科技金融创客先锋”</span></a>
                                    <a href="#"><em>10月19日</em><b></b><span>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</span></a>
                                    <a href="#"><em>11月20日</em><b></b><span>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</span></a>
                                    <a href="#" class="last"><em>12月30日</em><b></b><span>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</span></a>
                                </dd>
                            </dl>
                            --}}
                        </div>

                    </div>
                @endif
          </div>
      </div>
</div>
@endsection
@section('jspage')
<script type="text/javascript" src="{{assetUrlByCdn('/assets/js/pc4/tabs.js')}}"></script>
<script type="text/javascript">
 $(function(){
    

    $('.Js_tab_box2 .v4-development-1').hide().eq(0).show()
    $('.Js_tab_box3 .v4-development-1').hide().eq(0).show()



    $(".Js_tab_box2").tabs({
        tabList: "[data-tab='9douyu']>a",//tab list
        tabContent: ".v4-development-1",//内容box
        tabOn:"active"
    });
    $(".Js_tab_box3").tabs({
        tabList: "[data-tab='sunfund']>a",//tab list
        tabContent: ".v4-development-1",//内容box
        tabOn:"active"
    });
 })
</script>
@endsection