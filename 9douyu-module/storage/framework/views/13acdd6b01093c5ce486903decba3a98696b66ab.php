<?php $__env->startSection('title', '充值支付－九斗鱼'); ?>

<?php $__env->startSection('content'); ?>
<div class="v4-account">
    <!-- account begins -->
    <?php echo $__env->make('pc.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="v4-content v4-account-white">
        <div class="Js_tab_box">
            <!--tab-->
            <ul class="v4-user-tab clearfix">
                <li class="cur"><a href="/recharge/index">快捷充值</a></li>
                <li><a href="/recharge/online">网银充值</a></li>
            </ul>
            <div class="js_tab_content">
                <form action="/recharge/submit" id="rapidFrom" method="post" target="_blank">
                <div class="Js_tab_main current_tab_main v4-hidden-tabbox" style="display:block;">
                    <div class="v4-account-rapid-info-wrap">

                         <div class="v4-account-info">
                            <span>绑定银行卡</span>
                            <div class="v4-account-card">
                                <p class="cardNum"><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'.$authCard['info']['bank_id'].'.png')); ?>" class="v4-bank-icon"><?php echo e($authCard['info']['bank_name']); ?> <?php echo e(substr($authCard['info']['card_no'],0,4)); ?>****<?php echo e(substr($authCard['info']['card_no'],-4)); ?></p>
                                <?php /* <p class="limited">限额：5万/笔，20万/日</p> */ ?>
                            </div>
                        </div>
                        <dl class="v4-input-group">
                            <dt>
                                <label for="bankcard">充值金额</label>
                            </dt>
                            <dd>
                                <input class="v4-input" placeholder="请输入充值金额，最低100元" id="rechargeCash" data-pattern="amountrecharge"  name="recharge_cash">
                                <span  class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                            </dd>
                            <dt>
                                <label for="paychannel">支付渠道</label>
                            </dt>
                            <dd class="clearfix">
                                <div class="v4-recharge-channel-wrap clearfix">
                                    <?php foreach($authCard['list'] as $val): ?>
                                    <ul class="v4-recharge-channel" bvalue="<?php echo e($val['pay_type']); ?>" data-cash="<?php echo e($val['real_limit']); ?>">
                                        <li class="v4-recharge-channel-bt"><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'.$val['pay_type'].'.png')); ?>" width="72" alt="<?php echo e($typeList[$val['pay_type']]['name']); ?>"><?php echo e($typeList[$val['pay_type']]['name']); ?><span></span></li>
                                        <li class="v4-recharge-channel-txt clearfix"><span class="fl">单笔限额</span><em class="fr"><?php echo e(isset($val['limit']) ? $val['limit'] : 0); ?>元</em></li>
                                        <li class="v4-recharge-channel-txt clearfix"><span class="fl">当日限额剩余</span><em class="fr"><?php echo e(isset($val['day_free_limit']) ? $val['day_free_limit'] : 0); ?>元</em></li>
                                    </ul>
                                    <?php endforeach; ?>
                                </div>
                            </dd>
                            <dt>
                                &nbsp;
                            </dt>
                            <dd>
                                <div id="v4-input-msg" class="v4-input-msg"><?php if(Session::has('errors')): ?> <?php echo e(Session::get('errors')); ?> <?php endif; ?></div>
                                <input type="hidden"    name="card_no"  value="<?php echo e($authCard['info']['card_no']); ?>">
                                <input type="hidden"    name="channel"  />
                                <input type="hidden"    name="realLimit"/>
                                <input type="hidden"    name="isBind"   value="1"   />
                                <input type="hidden"    name="payType"  value="2"   />
                                <input type="hidden"    name="bankId"   value="<?php echo e($authCard['info']['bank_id']); ?>"/>
                                <input type="hidden"    name="_token"   value="<?php echo e(csrf_token()); ?>" />
                                <input type="hidden"    name="minRecharge"  id="minRecharge" value="<?php echo e(isset($withholding_recharge_min_money) ? $withholding_recharge_min_money : 0); ?>" />
                                <input type="hidden"    name="maxRecharge"  id="maxRecharge" value="<?php echo e(isset($authCard['limit']['cash']) ? $authCard['limit']['cash'] : 0); ?>" />
                                <input type="submit" class="v4-input-btn"   value="确认充值" >
                            </dd>
                        </dl>
                    </div>
                    <div class="v4-user-warm-tip">
                        <h6>充值须知：</h6>
                        <p><span>1.</span>在支付页面完成充值后，请点击"返回商户"连接，不要直接关闭支付页面窗口，否则可能会造成充值金额延后到账；<br>若充值金额未及时到账，请联系客服。</p>
                        <p><span>2.</span>单笔充值金额100元起，每日的充值限额依据各银行限额为准。</p>
                        <p><span>3.</span>严禁利用充值功能进行信用卡套现、转账、洗钱等行为，一经发现，资金将退回原卡并封停账号30天。</p>
                        <p><span>4.</span>账户资金每自然月有4次免费提现机会，超过4次以后的每笔提现将收5元手续费。</p>
                        <p><span>5.</span>点击充值按钮，表示您已经仔细阅读并同意以上资金管理规定条款。</p>
                     </div>
                </div><!--tabbox1-->
                </form>
            </div><!--tabouterbox-->


      </div><!--tab box 最大容器-->
  </div> <!--right box-->
</div><!--v4-account 最外层容器-->

<!-- 快速充值弹窗 -->
<div class="v4-layer_wrap js-mask" data-modul="modul0"  style="display:none;" id="rechargeShow">
    <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
    <div class="Js_layer v4-layer">
        <a href="javascript:;" class="v4-layer_close Js_layer_close" data-toggle="mask" data-target="js-mask"></a>
        <div class="v4-layer_0">
            <p class="v4-layer-normal-icon"><i class="v4-icon-20 v4-iconfont">&#xe696;</i></p>
            <p class="v4-layer_text">请您在新打开的页面完成充值</p>
            <p class="v4-layer-withdraw-tip">充值完成前请不要关闭此窗口</p>
            <a href="/user" class="v4-input-btn" id="">查看结果</a>
            <div  class="v4-layer-withdraw-question"><a href="http://www.sobot.com/chat/pc/index.html?sysNum=54037ae382a141c8b7fa69f402a99b7c" target="_blank">充值遇到问题？</a></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jspage'); ?>
<script>
(function($){
    $(document).ready(function(){
        // 检验输入框内容
//        $.validation('#rapidFrom .v4-input',{
//            errorMsg:'#v4-input-msg'
//        });

        // 表单提交验证
//        $("#rapidFrom").bind('submit',function(){
//            if(!$.formSubmitF('.v4-input',{
//                fromT:'#rapidFrom',
//                fromErrorMsg:'#v4-input-msg',
//            })) return false;
//        });
        var maxRecharge = $("#maxRecharge").val();
        var minRecharge = $("#minRecharge").val();
        maxRecharge     = parseInt(maxRecharge);
        minRecharge     = parseInt(minRecharge);

        $("#rechargeCash").blur(function() {

            $(this).formatInput(/^[0-9]{1,}$/);

            cashValitate();

        });

        // check data
        function  cashValitate() {

            var cash    = $("#rechargeCash").val();
            cash        = parseInt(cash);

            if( !cash ) {
                $(".v4-input-msg").html(minRecharge + "元起充，请输入充值金额");
                return false;
            } else if( Number(cash) < minRecharge ){
                $('.v4-input-msg').html("最小充值金额为" + minRecharge +"元");
                return false;
            } else if( Number(cash) > maxRecharge ) {
                $(".v4-input-msg").html("最大充值金额为"+maxRecharge+"元");
                return false;
            } else if( maxRecharge <=0 ){
                $(".v4-input-msg").html("今日已达限额，请明日再来");
                return false;
            }else {
                $(".v4-input-msg").html("");
                return true;
            }
        }

        // 表单提交验证
        $("#rapidFrom").bind('submit',function(){
            // if(!$.formSubmitF('.v4-input',{
            //    fromT:'#rapidFrom'
            // })) return false;
            if( !cashValitate() ) return false;

            var channel = $("input[name=channel]").val();
            if(!channel){
                $(".v4-input-msg").html("请选择支付渠道");
                return false;
            }

            var cash    = $("#rechargeCash").val();
            cash        = parseInt(cash);
            var realLimit   = $("input[name=realLimit]").val();
            realLimit       = parseInt(realLimit);

            if( cash > realLimit ){
                $(".v4-input-msg").html("该通道最多可充值"+realLimit+'元');
                return false;
            }

            $("#rechargeShow").mask();
        });


        //充值方式 select效果
        $(".v4-recharge-bank li,.v4-recharge-channel").click(function(){
            if(!$(this).hasClass("active")){
                $(".v4-recharge-bank li,.v4-recharge-channel").removeClass("active");
                $(this).addClass("active");

                $("input[name=channel]").val($(this).attr("bvalue"));
                $("input[name=realLimit]").val($(this).attr("data-cash"));
                $(".v4-input-msg").html("");
            }else{
                $(this).removeClass("active");
            }

        });
    });
})(jQuery);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>