@extends('pc.common.base')

@section('title','风险承受能力评测')

@section('content')

<div class="v4-account">
    <!-- account begins -->
        <div class="v4-riskA-box">
            <div class="v4-riskA-title">风险承受能力评测</div>
            <div class="v4-riskA-main">
                <div class="v4-riskA-info">
                    <h4>评估结果仅供参考，请结合实际情况进行选择</h4>
                    <p>尊敬的鱼客：</p>
                    <p>风险测试问卷能够帮助出借人准确的对自我风险承受能力，投资理念，投资性格等进行专业的认知测试，综合评估您的风险承受能力高低，是出借人进行投资理财之前重要的准备工作。</p><br>
                    <p class="red">本测评表共8题，涉及内容仅供九斗鱼平台评测出借人风险承受能力，为客户提供适当的产品和服务时使用，九斗鱼平台将履行保密义务。请认真选择以下问题：</p>
                </div>
                <form id="riskAForm" method="post" action="/user/riskAssessmentSecond">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                <dl class="v4-riskA-block">
                    <dt>1. 您的年龄在以下哪个范围内？ <i>*</i><span>请选择</span></dt>
                    <dd class="inline">
                        <input type="radio" name="question1" id="1" value="a"><label for="1">A. 29岁以下</label>
                        <input type="radio" name="question1" id="2" value="b"><label for="2">B. 30-39岁</label>
                        <input type="radio" name="question1" id="3" value="c"><label for="3">C. 40-49岁</label>
                        <input type="radio" name="question1" id="4" value="d"><label for="4">D. 50-59岁</label>
                        <input type="radio" name="question1" id="5" value="e"><label for="5">E. 60岁以上</label>
                    </dd>
                    <dt>2. 您有过几年的投资经验？<i>*</i><span>请选择</span></dt>
                    <dd class="inline">
                        <input type="radio" name="question2" id="6" value="a"><label for="6">A. 10年以上</label>
                        <input type="radio" name="question2" id="7" value="b"><label for="7">B. 6-10年</label>
                        <input type="radio" name="question2" id="8" value="c"><label for="8">C. 3-5年</label>
                        <input type="radio" name="question2" id="9" value="d"><label for="9">D. 1-2年</label>
                        <input type="radio" name="question2" id="10" value="e"><label for="10">E. 1年以下 </label>
                    </dd>
                    <dt>3. 您是否有过投资经验？<i>*</i><span>请选择</span></dt>
                    <dd>
                        <input type="radio" name="question3" id="11" value="a"><label for="11">A. 有投资贵金属、外汇、期货、期权等高风险衍生品经验</label><br>
                        
                        <input type="radio" name="question3" id="12" value="b"><label for="12">B. 有投资股票、股票型基金的经验</label><br>
                        
                        <input type="radio" name="question3" id="13" value="c"><label for="13">C. 有购买过银行的理财产品、债券基金、分红型、投连险</label><br>
                        
                        <input type="radio" name="question3" id="14" value="d"><label for="14">D. 有购买过保本基金、货币基金（如余额宝）、信托等低风险产品</label><br>
                        
                        <input type="radio" name="question3" id="15" value="e"><label for="15">E. 从未有过投资经历，只存银行的定期或活期</label>
                    </dd>
                    <dt>4. 您的家庭目前全年收入状况如何？<i>*</i><span>请选择</span></dt>
                    <dd class="inline">
                        <input type="radio" name="question4" id="16" value="a"><label for="16">A. 50万元以上</label>
                        <input type="radio" name="question4" id="17" value="b"><label for="17">B. 30-50万元</label>
                        <input type="radio" name="question4" id="18" value="c"><label for="18">C. 15-30万元</label>
                        <input type="radio" name="question4" id="19" value="d"><label for="19">D. 5-15万元</label>
                        <input type="radio" name="question4" id="20" value="e"><label for="20">E. 5万元以下</label>
                    </dd>
                    <dt>5.当您进行投资时（例如基金、股票），您能接受一年内损失多少？<i>*</i><span>请选择</span></dt>
                    <dd>
                        <input type="radio" name="question5" id="21" value="a"><label for="21">A. 我能承受25％以上亏损</label><br>
                        
                        <input type="radio" name="question5" id="22" value="b"><label for="22">B. 我能承受10-20％的亏损</label><br>
                        
                        <input type="radio" name="question5" id="23" value="c"><label for="23">C. 我最多只能承受5-10%的亏损</label><br>
                        
                        <input type="radio" name="question5" id="24" value="d"><label for="24">D. 我最多只能承受5%以下的亏损</label><br>
                        
                        <input type="radio" name="question5" id="25" value="e"><label for="25">E. 我几乎不能承受任何亏损</label>
                    </dd>
                    <dt>6. 目前您的投资主要是哪一品种？<i>*</i><span>请选择</span></dt>
                    <dd>
                        <input type="radio" name="question6" id="26" value="a"><label for="26">A. 外汇、期货、现货贵金属 等超高风险资产</label><br>
                        
                        <input type="radio" name="question6" id="27" value="b"><label for="27">B. 股票、股票基金、私募股权基金 等高风险资产</label><br>
                        
                        <input type="radio" name="question6" id="28" value="c"><label for="28">C. 混合基金、指数基金、结构类产品 等较高风险资产</label><br>
                        
                        <input type="radio" name="question6" id="29" value="d"><label for="29">D. 银行理财产品、信托、固定收益类基金(有限合伙基金)、货币基金(如余额宝）</label><br>
                        
                        <input type="radio" name="question6" id="30" value="e"><label for="30">E. 活期、定期存款、国债、保险</label>
                    </dd>
                    <dt>7. 长期风险承受水平：下面哪一种描述最符合您可接受的价值波动程度？<i>*</i><span>请选择</span></dt>
                    <dd>
                        <input type="radio" name="question7" id="31" value="a"><label for="31">A. 希望赚取最高回报潜力，能接受3年以上的负面波动，包括损失本金</label><br>
                        
                        <input type="radio" name="question7" id="32" value="b"><label for="32">B. 希望赚取较高回报潜力，能接受3年以上的负面波动</label><br>
                        
                        <input type="radio" name="question7" id="33" value="c"><label for="33">C. 寻求资金较高收益，可接受3年内负面波动，使回报显著高于定期存款</label><br>
                        
                        <input type="radio" name="question7" id="34" value="d"><label for="34">D. 保守投资，但愿意在2年内接受少许负面波动，使回报高于定期存款</label><br>
                        
                        <input type="radio" name="question7" id="35" value="e"><label for="35">E. 不希望投资本金承担风险。我愿意接受的回报大约与定期存款一样</label>
                    </dd>
                    <dt>8. 假设现有以下几个投资品种，那您会选择哪一个？<i>*</i><span>请选择</span></dt>
                    <dd>
                        <input type="radio" name="question8" id="36" value="a"><label for="36">A. 收益率在30%以上，同时本金也有可能亏损20%以上</label><br>
                        
                        <input type="radio" name="question8" id="37" value="b"><label for="37">B. 本金不保证，收益率在20%以内，同时本金也有可能亏损10%以内</label><br>
                        
                        <input type="radio" name="question8" id="38" value="c"><label for="38">C. 本息保证，收益率在10%左右</label><br>
                        
                        <input type="radio" name="question8" id="39" value="d"><label for="39">D. 本息保证，收益率在4-6%之间</label><br>
                        
                        <input type="radio" name="question8" id="40" value="e"><label for="40">E. 银行定期存款，收益率在3%</label>
                    </dd>
                </dl>
                <div class="tc">
                    <input type="button" value="确认提交" id="doSubmit" class="v4-input-btn" >
                </div>
                </form>
            </div>
        </div>

    <div class="clear"></div>
</div>


<div class="v4-layer_wrap js-mask" data-modul="modul3" style="display: none;">
    <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
    <div class="v4-layer Js_layer ">
        <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
        <div class="v4-layer_0 v4-layer_risk">
            <p class="v4-layer_text">亲爱的九斗鱼用户，风险评测结果<br>您的风险承受能力为：</p>
            <p class="v4-layer_text1" id="assessmentType"></p>
            <a href="/project/index" class="v4-input-btn" id="v4-btn-1">立即出借</a>
        </div>
    </div>
</div>
@endsection

@section('jspage')
<script src="{{assetUrlByCdn('/assets/js/pc4/layer.js')}}" type="text/javascript"></script>
<script type="text/javascript">
(function($){

    $('.v4-layer_mask,.v4-layer_close').click(function(){
        window.location.href = '/user/setting'
    });

    $(function(){
        $('#doSubmit').on('click',function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var arr = [];
            var val;
            $('#riskAForm input[type=radio]').each(function(){
                if($(this).prop("checked")){
                    val = $(this).val()
                    arr.push(val);
                    $(this).parent('dd').prev('dt').find('span').remove();
                }else{
                    $(this).parent('dd').prev('dt').find('span').addClass('error');
                }
            })

            if(arr.length<8){
                return false;
            }else{
                $(this).addClass('disabled');
                $.ajax({
                    url : '/user/assessment',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'question1': arr[0],
                        'question2': arr[1],
                        'question3': arr[2],
                        'question4': arr[3],
                        'question5': arr[4],
                        'question6': arr[5],
                        'question7': arr[6],
                        'question8': arr[7]
                    },
                    success : function(result) {
                        if(result.status){
                            $('#assessmentType').html(result['data']);
                            $('.v4-layer_wrap').layer();
                        }else{
                            alert(result.msg);
                            window.location.href='/user/riskAssessment';
                        }
                    },
                });
                $('#doSubmit').removeClass('disabled');
            }

        })
    })
})(jQuery)
</script>
@endsection

