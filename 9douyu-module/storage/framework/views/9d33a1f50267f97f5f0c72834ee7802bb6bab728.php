<?php $__env->startSection('title', '身份证认证'); ?>

<?php $__env->startSection('keywords', env('META_KEYWORD')); ?>

<?php $__env->startSection('description', env('META_DESCRIPTION')); ?>

<?php $__env->startSection('content'); ?>
    <article>
        <!--<if condition="$isPartner eq 'partner'">-->
        <!--<div class="wap2-verify-success"><p>注册成功<br>完成实名认证即可免费领取100元</p></div>-->
        <!--</if>-->
        <form action="/user/doVerify" method="POST" id="identity-verify">
            <section class="wap2-input-group mt1">

                <!-- <div class="wap2-verify-img">
                    <if condition="$isPartner eq 'partner'">
                        <img src="__PUBLIC2__/weixin/images/wap2/x-verify-img_100.png">
                    <else/>
                        <img src="__PUBLIC2__/weixin/images/wap2/x-verify-img_100.png">
                    </if>
                </div> -->
                <div class="wap2-input-box bbd3">
                    <span class="wap2-input-icon wap2-input-icon1"></span>
                    <input type="text" name="name" id="real_name" class='require' placeholder="您的真实姓名" value="<?php echo e(isset($realName) ? $realName : Input::old('name')); ?>">
                </div>
                <div class="wap2-input-box bbd3">
                    <span class="wap2-input-icon wap2-input-icon2"></span>
                    <input type="text" name="id_card" class="require wapForm-check-identityCard" placeholder="您的身份证号" value="<?php echo e(isset($identityCard) ? $identityCard : Input::old('id_card')); ?>">
                </div>
                <div class="wap2-input-box">
                    <span class="wap2-input-icon wap2-input-icon8"></span>
                    <input type="text" name="card_no" class="require wapForm-check-identityCard" placeholder="您的银行卡号" value="<?php echo e(Input::old('card_no')); ?>">
                </div>
                <!--<div class="wap2-input-box">-->
                <!--<span class="wap2-input-icon wap2-input-icon3"></span>-->
                <!--<input type="password" name="tradepassword" class="require wapForm-check-checkPassword" placeholder="设置交易密码 6-16位的字母及数字组合">-->
                <!--</div>-->
            </section>
            <section class="wap2-tip error">
                <p id="error_tip"><?php if(Session::has('errors')): ?> <?php echo e(Session::get('errors')); ?> <?php endif; ?></p>
            </section>
            <section class="wap2-btn-wrap">
                <input type="hidden" name="_token"      value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" name="verifyType"  value="<?php echo e($verifyType); ?>">
                <input type="submit" class="wap2-btn wap2-btn-blue2" value="完成">
            </section>
                <div class="wap2-verify-txt">
                    <p>温馨提示：为保证您的正常使用，在快捷充值的时需要开通银联无卡支付功能，如未开通请联系银行客服开通。</p>
                </div>
        </form>
    </article>


<?php $__env->stopSection(); ?>
<!--<script type="text/javascript">-->
<!--(function($){-->

<!--$(document).ready(function(){-->
<!--$(".wap2-btn").click(function(){-->
<!--$(".wap2-pop-wrap").attr();-->
<!--});-->

<!--});-->
<!--})(jQuery);-->

<!--</script>-->

<?php echo $__env->make('wap.common.wapBase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>