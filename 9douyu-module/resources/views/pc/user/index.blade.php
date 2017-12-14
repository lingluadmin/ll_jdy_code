@extends('pc.common.base')

@section('title','账户总览')
@section('csspage')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/assets/css/pc4/tip-yellow.css')}}">
@endsection
@section('content')

<div class="v4-account auto">
    <!-- account begins -->
    @include('pc.common/leftMenu')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="v4-content grayborder" id='user-content'>
        <div class="v4-account1 hidden">
            <dl class="v4-account-1">
                <dt><i class="v4-iconfont">&#xe6b2;</i></dt>
                <dd>
                    <h5 class="js-poshytip">
                        <em> Hi,{{ $user_info['phone'] }} </em>
                        @if(!empty($user_info['real_name']))
                        <span title="您已实名认证" class="v4-acc-icon v4-iconfont">&#xe6aa;</span>
                        @else
                            <span title="您还未实名认证 <a href='/user/setting/verify' style='color:#1468ec'>点击认证</a>" class="v4-acc-icon v4-iconfont v4-acc-grayicon">&#xe6aa;</span>
                        @endif

                         @if($user_info['password_hash'] == $user_info['trading_password'] || empty($user_info['trading_password']))
                        <span title="还未设置交易密码 " class="v4-acc-icon v4-iconfont v4-acc-grayicon">&#xe6af;</span>
                        @else
                        <span title="您已设置交易密码 " class="v4-acc-icon v4-iconfont">&#xe6af;</span>
                        @endif

                        <span title="您已绑定手机 " class="v4-acc-icon v4-iconfont">&#xe6d1;</span>

                        @if(!empty($user_info['assessment_type']))
                            <span title="" class="v4-acc-icon v4-iconfont" id="evaluate1">&#xe6b1;</span>
                        @else
                            <span title="" class="v4-acc-icon v4-iconfont v4-acc-grayicon" id="evaluate">&#xe6b1;</span>
                        @endif

                    </h5>
                    <p class="v4-account-risk-1">风险等级
                        @if(!empty($user_info['assessment_type']))
                            <span class="orange">{{$user_info['assessment_type']}}</span>
                            <a href="/user/riskAssessment" >重新测评</a>
                        @else
                            <span class="red">未测评</span>
                            <a href="javascript:;" onclick="$('#lay_wrap3').layer();">开始测评</a>
                        @endif
                    </p>
                </dd>
            </dl>
            <div class="v4-account-2">
                @if( !empty($user_bank) )
                    <dt> <a href="javascript:;" class="v4-btn v4-btn-disabled">已绑卡</a></dt>
                    <dd>银行卡号<span>{{ $user_bank['card_number'] }}</span></dd>
                @else
                    <dt><a href="/user/setting/verify" class="v4-btn v4-btn-primary">绑定银行卡</a></dt>
                    <dd> 为保障您的资金安全，请立即绑定银行卡</dd>
                @endif
            </div>


        </div>

        <div class="v4-account2">
            <h2 class="v4-account-titlex">资产总览</h2>

                <dl class="v4-account2-1">
                    <dt><i class="v4-iconfont">&#xe6b0;</i></dt>
                    <dd>
                        <p>预期总资产(元)</p>
                        <h5>{{ number_format($user_info['total_amount'],2) }}</h5>
                    </dd>
                </dl>

                <dl class="v4-account2-2">
                    <dt>
                        <p>可用余额(元)</p>
                        <h5>{{ number_format($user_info['balance'],2) }}</h5>
                    </dt>
                    <dd>
                         <a href="/recharge/index"  class="v4-btn v4-btn-primary">充值</a>
                         <a href="/pay/withdraw"    class="v4-btn">提现</a>
                    </dd>
                </dl>
        </div>

         <div class="v4-account3">
            <h2 class="v4-account-titlex">资产占比</h2>
            <div class="v4-account3-1">
                <div id="main" class="v4-pie"></div>
            </div>
            <div class="v4-account3-2">
                <p><i class="icon1"></i>可用余额(元) <span>{{ number_format($user_info['balance'],2) }}</span></p>
                <p><i class="icon2"></i>待收收益(元) <span>{{ number_format($project_account['total_amount_interest'],2) }}</span></p>
                <p><i class="icon3"></i>在投本金(元) <span>{{ number_format($project_account['total_amount_principal']+$current_account['cash'],2) }}</span></p>
            </div>
        </div>

        <div class="v4-account4">
            <h2 class="v4-account-titlex">资产分布</h2>
                <ul class="v4-asset-distribution">
                    <li>
                        <span class="v4-w152px">零钱计划</span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($current_account['cash'],2) }}</ins><br/>持有金额(元)
                        </span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($current_account['yesterday_interest'],2) }}</ins><br/>昨日收益(元)
                        </span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($current_account['interest'],2) }}</ins><br/>累计收益(元)
                        </span>
                        <span class="v4-w196px">
                            <a href="javascript:;" class="v4-btn v4-btn-primary" data-target="modul0">转出</a>
                            <em>仅APP支持转入功能</em>
                        </span>
                    </li>

                    <li>
                        <span class="v4-w152px">优选项目</span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($project_account['total_amount_principal'],2) }}</ins><br/>在投本金(元)
                        </span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($project_account['total_amount_interest'],2) }}</ins><br/>待收收益(元)
                        </span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($project_account['refund_interest'],2) }}</ins><br/>累计收益(元)
                        </span>
                        <span class="v4-w196px">
                            <a href="/user/investList" class="v4-btn">查看详情</a>
                        </span>
                    </li>
                    <li>
                        <span class="v4-w152px">智投计划</span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($smart_account['total_principal'],2) }}</ins><br/>在投本金(元)
                        </span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($smart_account['due_interest'],2) }}</ins><br/>待收收益(元)
                        </span>
                        <span class="v4-w184px">
                            <ins>{{ number_format($smart_account['total_interest'],2) }}</ins><br/>累计收益(元)
                        </span>
                        <span class="v4-w196px">
                            <a href="javascript:;" class="v4-btn">查看详情</a>
                        </span>
                    </li>
                </ul>           
        </div>
       
    </div>

   
    <!-- account ends -->
    <div class="clearfix"></div>
</div>

 <!-- 零钱计划转出确认 -->
    <div class="v4-layer_wrap js-mask" data-modul="modul0"  style="display:none;" id="currentOut">
        <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
        <div class="Js_layer v4-layer">
        <div class="v4-layer_title red">零钱计划转出确认<a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask" ></a></div>     
                   <dl class="v4-input-group v4-turn">
                       <dt>
                           零钱计划总额
                       </dt>
                       <dd>
                           <p>{{ number_format($current_account['cash'],2) }}</p>
                       </dd>
                       <dt> 
                           <label for="turnout">转出金额</label>
                       </dt>
                       <dd>
                           <input value="" type="text" name="turnout" placeholder="请输入转出金额" id="turnout" data-pattern="turnout" class="v4-input">
                           <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                       </dd>
                      <dt>
                           <label for="password">交易密码</label>
                       </dt>
                       <dd>
                           <input type="password" name="password"  style="display: none;"/>
                           <input value="" type="password" name="password" placeholder="请输入交易密码" id="password" data-pattern="passwordTradingOld" class="v4-input">
                           {{--<input value="" type="password" name="password" placeholder="请输入6~16位字母和数字的组合" id="password" data-pattern="password" class="v4-input">--}}
                           <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>

                       </dd>

                       <dt>
                           &nbsp;
                       </dt>
                       <dd>
                           <div id="v4-input-msg" class="v4-input-msg">
                           </div>
                           <input type="hidden" name="balance" value="{{ $current_account['cash'] }}">
                           <input type="hidden" name="maxOut" value="100000">
                           <input type="button" class="v4-input-btn" value="确认转出"   id="v4-input-btn">
                       </dd>
                   </dl>
        </div>
    </div>

    <!--转出成功 -->
    <div class="v4-layer_wrap js-mask1" data-modul="modul2"  style="display:none;" id="currentOutRet">
    <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
    <div class="Js_layer v4-layer v4-layer1">
            <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask1"></a>
            <div class="v4-layer_0 v4-layer_trun">
                <p class="v4-layer-normal-icon v4-layer-success-icon"><i class="v4-icon-20 v4-iconfont">&#xe69f;</i></p>
                <p class="v4-layer_text">转出成功</p>
                <a href="/user" class="v4-input-btn" id="outRetBut" data-toggle="mask" data-target="js-mask1">关闭</a>
            </div>
        </div>
    </div>

    <!-- 风险提示书 -->
    <div id="lay_wrap3"  class="v4-layer_wrap js-mask" data-modul="modul3"  @if($user_info['assessment']==1) style="display:block;" @else style="display:none;" @endif>
        <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask-bak"></div>
        <div class="Js_layer v4-layer">
            <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
            <div class="v4-layer_title">风险提示书<a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask" style='display:none;'></a>
            </div>
            <div class="v4-layer_con riskAssessment-con">
                <p><strong>重要提示：</strong></p>
                <p>1、由于相关风险因素可能导致您的本金及收益全部或部分损失，因此，在您选择投资本网站发布的项目前，请仔细阅读本风险提示、网站公示信息、项目信息、电子合同（注册协议、借款合同、债权转让合同、产品交易类合同等）、第三方保障机构提供的电子担保函、承诺函等公示信息等。本风险提示书未涵盖全部风险因素，您仍需对其他可能存在的风险因素自行进行了解与评估。<br>
                    2、“九斗鱼”平台不保证您的本金及收益，您可能损失全部本金且无法取得任何收益。<br>3、请您谨慎投资，如果您无法接受，请立即停止后续注册、投资操作。如您通过网络操作确认等方式继续进行交易，则视为您已仔细阅读本风险提示书并愿意自行承担由此产生的本息损失及风险。<br>4、投资前，请您先进行风险承受能力评估，并根据您的评估结果选择您可以投资的项目。评级结果所对应的可投项目如下：<br>（1）保守型，对应网站上标示为“保守型”的产品；<br>（2）稳健型，对应网站上标示为“保守型”、“稳健型”的产品；<br>（3）平衡型，对应网站上标示为“保守型”、“稳健型”、“平衡型”的产品；<br>（4）积极型，对应网站上标示为“保守型”、“稳健型”、“平衡型”、“积极型”的产品；<br>（5）激进型，对应网站上标示为“保守型”、“稳健型”、“平衡型”、“积极型、激进型”的产品；</p><br>
                <p><strong>尊敬的用户：</strong></p>
                <p>1、在您成为“九斗鱼”平台注册出借人前，请确认您具备以下条件，<br>（1）拥有非保本类金融产品投资的经历并熟悉互联网；<br>（2）向网络借贷信息中介机构提供真实、准确、完整的身份等信息；<br>（3）出借资金为来源合法的自有资金；<br>（4）了解融资项目信贷风险，确认具有相应的风险认知和承受能力；<br>（5）自行承担借贷产生的本息损失；<br>
                    2、若您不具备以上条件，请您立即停止注册，并勿通过“九斗鱼”平台开展网络借贷活动。如果您仍继续后续操作进行注册程序，则视为您已确认您具备上述条件并自愿履行上述义务。<br>
                    3、在您在“九斗鱼”平台进行出借（投资）过程中，可能会面临多种风险因素，包括但不限于借款人违约风险、第三方担保或第三方保障机构风险、政策风险、延期风险、信息传递风险、不可抗力风险。请您认真阅读本风险提示书，并依据自身风险承受能力、财务状况及投资理财经验自行决定是否对 “九斗鱼”平台发布项目进行投资。鉴于风险因素存在多样性、不确定性，本风险提示未包括所有风险，仅供您参考，请您谨慎投资，独立判断。<br>
                    4、借贷关系的第一个风险是，借款人/出让人可能违约，因其自身财务状况紧张、投资失败、经营恶化等各种可能因素导致借款人/出让人无法按时足额支付本息/回购款，并且该违约将可能导致您的投资本息无法得到偿还。<br>
                    5、“九斗鱼”平台上发布的借款项目，通常会有第三方专业担保公司担保或第三方准入机构（以下统称“第三方保障机构”）提供债权回购/买断等方式保障出借人的资金安全。但是，“九斗鱼”平台不保证出借人的投资本息均能得到偿还。如借款人逾期还款，第三方保障机构破产、依法撤销或遭遇行业限制及因其他因素导致无法实现资金本息保障的，则出借人的投资本息将可能无法得到偿还。<br>
                    6、“九斗鱼”平台仅为借贷项目参与各方的借贷、担保、资金安全保障提供居间服务。“九斗鱼”平台自身不提供任何担保。“九斗鱼”平台在出借人与借款人/出让人或其它债权参与方之间的债权债务关系中不担任任何担保人或者保证人的角色。“九斗鱼”平台在服务过程中，任何文件、声明、说明、规则等均不应解释为“九斗鱼”平台提供任何形式的担保。 <br>
                    7、借款人/出让人提出融资申请后，“九斗鱼”平台会对借款人/出让人申请的拟发布融资信息进行审核。目前国内信用征信体系尚不完善，“九斗鱼”平台不能完全保证发布信息的真实性、有效性、完整性。平台网站提供的信息资料仅供参考，最终是否进行投资，需要出借人、出借人综合考虑自身投资经验、风险承受能力、相关法律法规、金融知识及对网络金融现状的了解，进行独立判断，并自行承担由此产生的风险。<br>
                    8、鉴于网络金融的特殊性，因技术故障、支付故障（银行、网关运营商、电信运营商服务技术障碍）、网络数据传输故障、网络安全、有权机关管制或限制等因素或其他不可抗力因素有可能导致出借人的投资本息延迟或损失。“九斗鱼”平台不担保服务不会中断，也不担保服务的及时性和/或安全性。系统因相关状况无法正常运作，使会员无法使用任何“九斗鱼”平台服务或使用任何“九斗鱼”平台服务时受到任何影响或损失的，“九斗鱼”平台对会员或任何第三方均不负任何责任。<br>9、出借人有可能面临因国家法律政策的出台或重大变化而遭受本金及收益损失。<br>
                    10、出借人在“九斗鱼”平台进行交易过程中，请确保<br>
                    （1）投资资金来源合法且有权进行出借处分；<br>
                    （2）未使用非法资金进行投资或在“九斗鱼”平台洗钱；<br>
                    （3）未使用非自有资金（包括但不限于银行贷款、从他人处筹措的资金等）进行投资；<br>
                    （4）与借款人/出让人串通进行虚假的融资和投资。否则，因此所引发的任何纠纷均由您自行负责解决并承担相应责任。<br>
                    11、“九斗鱼”平台发布的借贷项目可提前还款，借款人可在借款期间任何时候通过“九斗鱼”平台的提前还款功能提前偿还全部剩余借款。请您认真阅读电子借款合同中的提前还款条款，以合理判断预期收益。</p><br>
                <p>星果时代信息技术有限公司</p>
            </div>
            <div class="v4-riskAssessment-tips">
                <p><input type="checkbox" name="checkbox" id="checkbox"><label for="checkbox">本人已经认真阅读，完全理解，认可并接受以上全部内容。</label></p>
                <p><a href="javascript:;" class="v4-input-btn disable" id="checkbox-link">开始评估</a></p>
            </div>
        </div>
    </div>

<script src="{{assetUrlByCdn('/assets/js/pc4/echarts.common.min.js')}}" type="text/javascript"></script>
<script src="{{assetUrlByCdn('/assets/js/pc4/jquery.poshytip.min.js')}}" type="text/javascript"></script>
<script src="{{assetUrlByCdn('/assets/js/pc4/custodyAccount.js')}}" type="text/javascript"></script>
<script src="{{assetUrlByCdn('/assets/js/pc4/layer.js')}}" type="text/javascript"></script>
<script src="{{assetUrlByCdn('/assets/js/pc4/toFixed.js')}}" type="text/javascript"></script>

<script type="text/javascript">

    $(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /*左边导航*/
          $(".v4-leftNav ul li").click(function(){
              if($(this).index()>0){
                  $(this).addClass("active").siblings().removeClass("active");
              }
          });

        $("#outRetBut").click(function(){
            var retMsg = $(this).html();
            if(retMsg == "转出成功"){
                window.location.href="/user";
            }
        });

        $(".js-poshytip span:not(#evaluate)").poshytip({
            alignY: 'bottom',
            showTimeout: 100
        });

        $('#evaluate1').poshytip({
            content:'您已参与评估',
            alignY: 'bottom',
            showTimeout: 100
        })

        $('#evaluate').poshytip({
            content:'您还未进行<a href="javascript:;" data-target="modul3" class="blue">风险评估</a>',
            alignY: 'bottom',
            showTimeout: 100
        })

        // 评估
        $('#checkbox').click(function(){
            if($(this).prop('checked')){
                $('#checkbox-link').attr("href","/user/riskAssessment");
                $('#checkbox-link').removeClass('disable');
            }else{
                $('#checkbox-link').attr("href","javascript:;");
                $('#checkbox-link').addClass('disable');
            };

        })
         // 检验输入框内容
    $.validation('.v4-input');

    // 表单提交验证
         $("#v4-input-btn").bind('click',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#turnoutCash'
            })){
                return false;
            }else{
                var cash               = $.toFixed($.trim($("input[name=turnout]").val()));
                var balance            = $.toFixed($.trim($("input[name=balance]").val()));
                var tradingPassword    = $.trim($("#password").val());
                var maxOut             = $.toFixed($.trim($("input[name=maxOut]").val()));

                if( cash<0 || cash==''){
                    $("#v4-input-msg").html("请输入正确金额！");
                    $("#turnout").data('error','error').siblings('.v4-input-status').find('i').addClass('error').html('&#xe69d;');
                    return false;
                }

                if( cash>balance ){
                    $("#v4-input-msg").html("转出金额不能超过零钱计划总资产！");
                    $("#turnout").data('error','error').siblings('.v4-input-status').find('i').addClass('error').html('&#xe69d;');
                    return false;
                }
                var pattern = /^(?![0-9]+$)(?![a-z]+$).{6,16}$/i;
                if( tradingPassword.length == 0 ) {
                    $("#v4-input-msg").html("请输入交易密码！");
                    $("#password").data('error','error').siblings('.v4-input-status').find('i').addClass('error').html('&#xe69d;');

                    return false;
                }
                if( !tradingPassword.match(pattern) ){
                    $("#v4-input-msg").html("请输入正确格式的交易密码！");
                    $("#password").data('error','error').siblings('.v4-input-status').find('i').addClass('error').html('&#xe69d;');
                    return false;
                }

                $.ajax({
                    url     : '/invest/current/doInvestOut',
                    type    : 'POST',
                    dataType: 'json',
                    data    : {cash:cash,trading_password:tradingPassword},
                    success : function(data) {
                        if(data.status) {
                            $("#currentOut").hide();
                            $("#currentOutRet").layer();
                            if($(".v4-icon-20").hasClass("fail")){
                                $(".v4-icon-20").removeClass("fail").html("&#xe69f;");
                            }
                        } else {
                            $("#v4-input-msg").html(data.msg);
                            if(data.msg.indexOf('密码') > 0 ){
                                $("#password").data('error','error').siblings('.v4-input-status').find('i').addClass('error').html('&#xe69d;');
                            }else{
                                $("#turnout").data('error','error').siblings('.v4-input-status').find('i').addClass('error').html('&#xe69d;');
                            }
                            return false;
                        }
                    },
                    error   : function(msg) {

                        $("#currentOut").hide();
                        $("#currentOutRet").layer();
                        $(".v4-layer_text").html("操作失败，请重试！");
                        $("#outRetBut").html("操作失败，请重试！");
                        $(".v4-icon-20").addClass("fail").html("&#xe69d;");

                    }
                });
            }

        });

    });


    /*饼状图*/
    var myChart = echarts.init(document.getElementById('main'));
     // 指定图表的配置项和数据
    var option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            color:['#b9cbdf', '#50a9f5','#505cf5'],
            legend: {
                show:false,
                orient: 'vertical',
                x: 'right',
                data:['可用余额','待收收益','在投本金']
            },
            series: [
                {
                    name:'资产占比',
                    type:'pie',
                    radius: ['40%', '55%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '16',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:[
                        {value:'{{$user_info['balance']}}', name:'可用余额'},
                        {value:'{{$project_account['total_amount_interest']}}', name:'待收收益'},
                        {value:'{{$project_account['total_amount_principal']+$current_account['cash']}}', name:'在投本金'}
                      
                    ]
                }
            ]
        };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

    var assessment={{$user_info['assessment']}};
    if(assessment==1){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/user/assessmentOff',
            type: 'POST',
        });
    }
</script>

@endsection