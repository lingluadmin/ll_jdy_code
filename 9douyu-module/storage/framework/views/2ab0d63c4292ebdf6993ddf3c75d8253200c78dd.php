<?php $__env->startSection('title', '充值支付－九斗鱼'); ?>

<?php $__env->startSection('content'); ?>
<div class="v4-account">
    <!-- account begins -->
    <?php echo $__env->make('pc.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="v4-content v4-account-white">
        <div class="Js_tab_box">
            <!--tab-->
            <ul class="v4-user-tab clearfix">
                <?php if( $hasChannel == "Y" ): ?>
                    <li><a href="/recharge/index">快捷充值</a></li>
                <?php endif; ?>
                <li class="cur"><a href="/recharge/online">网银充值</a></li>
            </ul>
            <div class="js_tab_content">
                <form action="/recharge/submit" id="rapidFrom" method="post" target="_blank">
                <div class="Js_tab_main current_tab_main v4-hidden-tabbox">
                    <div class="v4-account-rapid-info-wrap">
                        <dl class="v4-input-group v4-mt-80">
                            <dt>
                                <label for="bankcard">充值金额</label>
                            </dt>
                            <dd>
                                <input name="recharge_cash" placeholder="请输入充值金额，最低100元" id="rechargeCash" data-pattern="amountrecharge" class="v4-input">
                                <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                            </dd>
                            <dt>
                                <label for="bankcard">选择银行</label>
                            </dt>
                            <dd class="clearfix">
                                <div class="v4-recharge-bank">
                                    <ul class="clearfix">
                                        <?php foreach($unionPay as $union): ?>
                                            <?php if( $union['bank_id'] == $bankId ): ?>
                                                <li bvalue="<?php echo e($union['bank_id']); ?>" data-alias="<?php echo e($union['alias']); ?>" class="active" ><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'.$union['bank_id'].'.gif')); ?>"/><span></span></li>
                                            <?php else: ?>
                                                <li bvalue="<?php echo e($union['bank_id']); ?>" data-alias="<?php echo e($union['alias']); ?>" ><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'.$union['bank_id'].'.gif')); ?>"/><span></span></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </dd>
                            <dt>
                                &nbsp;
                            </dt>
                            <dd>
                                <div id="v4-input-msg" class="v4-input-msg"><?php if(Session::has('errors')): ?> <?php echo e(Session::get('errors')); ?> <?php endif; ?></div>
                                <input type="hidden"    name="payType"  value="1" />
                                <input type="hidden"    name="bankId"   value="<?php echo e($bankId); ?>"  />
                                <input type="hidden"    name="bankCode" value="<?php echo e($bankCode); ?>"  />
                                <input type="hidden"    name="_token"   value="<?php echo e(csrf_token()); ?>" />
                                <input type="hidden"    name="minRecharge"  id="minRecharge" value="<?php echo e(isset($withholding_recharge_min_money) ? $withholding_recharge_min_money : 0); ?>" />
                                <input type="submit"    class="v4-input-btn" value="确认充值" >
                            </dd>
                        </dl>

                    </div>
                    <div class="v4-recharge-tip"><i class="v4-iconfont">&#xe6a9;</i>请确保已选择的银行已开通网上支付功能，不支持信用卡充值</div>
                </div><!--tabbox2-->
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
//        // 检验输入框内容
//        $.validation('#rapidFrom .v4-input');
//        $.validation('#bankFrom .v4-input',{
//            errorMsg:'#v4-input-msg1'
//        });
//
//        // 表单提交验证
//        $("#rapidFrom").bind('submit',function(){
//            if(!$.formSubmitF('.v4-input',{
//                fromT:'#rapidFrom',
//                fromErrorMsg:'#v4-input-msg',
//            })) return false;
//        });

        var minRecharge = $("#minRecharge").val();
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
            } else {
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

            var bankId = $("input[name=bankId]").val();
            if(!bankId ){
                $(".v4-input-msg").html("请选择银行");
                return false;
            }
            $("#rechargeShow").mask();
        });


        //充值方式 select效果
        $(".v4-recharge-bank li,.v4-recharge-channel").click(function(){
            if(!$(this).hasClass("active")){
                $(".v4-recharge-bank li,.v4-recharge-channel").removeClass("active");
                $(this).addClass("active");

                var selfBvalue  = $(this).attr("bvalue");
                var bankCode    = $(this).attr("data-alias");

                $("input[name=bankId]").val(selfBvalue);
                $("input[name=bankCode]").val(bankCode);
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