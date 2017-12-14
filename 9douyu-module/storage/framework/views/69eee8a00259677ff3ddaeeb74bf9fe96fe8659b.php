<?php $__env->startSection('title', '充值支付－九斗鱼'); ?>

<?php $__env->startSection('content'); ?>
       

<div class="v4-account">
    <!-- account begins -->
   <?php echo $__env->make('pc4.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="v4-content v4-account-white">
        <ul class="v4-user-tab clearfix"> 
              <li><a href="/jx/recharge">快捷充值</a></li>
              <li class="active"><a href="/jx/transfer">转账充值</a></li>
        </ul>
        <div class="v4-account-transfer-info-wrap">
            <p class="v4-account-info"><span>账户余额(元)</span><big><?php echo e(isset($user['balance']) ? $user['balance'] : 0); ?>元</big></p>
            <div class="v4-account-holder">
                <p><label>开户人姓名</label><?php echo e(isset($user['real_name']) ? $user['real_name'] : null); ?></p>
                <p class="v4-relative"><label>电子账户</label><img src="<?php echo e(assetUrlByCdn('/static/images/pc4/bank-img/bank-01.png')); ?>" class="v4-bank-icon"><span id="bankcard"><?php echo e(isset($user['jx_account_id']) ? $user['jx_account_id'] : null); ?></span><em class="v4-copy-success">复制成功</em><a href="javascript:;" class="v4-btn-copy" data-clipboard-action="copy" data-clipboard-target="#bankcard">复制</a></p>
                <p><label>开户行</label>江西银行</p>
                <p><label>开户支行</label>江西银行</p>
            </div> 
        </div>
       

        <div class="v4-user-warm-tip">
            <h6>网银转账：</h6>
            <p>您可以向您的江西银行帐户转帐，实现帐户充值。建议转帐方式包括：银行柜台转账、网银转账、手机银行转账。转账时所需填写信息如下：</p>
            <p>收款方户名：陈雨涵</p>
            <p>收款方帐号：6212461510000330766</p>
            <p>收款方开户行：城市商业银行／江西银行／南昌银行</p>
            <p>收款银行所在省市：江西省 南昌市</p>
            <p>收款方开户行（网点）：江西银行股份有限公司／江西银行股份有限公司总行营业部</p>
            <h6>支付宝转账:</h6>
            <p>您可以使用您的银行卡，通过支付宝转账的方式将资金充值到您的江西银行存管帐户（支付宝APP更方便），转帐时所需填写信息如下：</p>
            <p>收款方户名：陈雨涵</p>
            <p>收款方帐号：6212461510000330766</p>
            <p>收款方开户行：江西银行股份有限公司总行营业部</p>
            <h6>温馨提示：</h6>
            <p>选择收款银行后，对应选择省市及开户行（网点）信息，如选择收款银行后，发现无对应省市或开户行（网点）信息时，请更改收款银行，例如：使用中国农业银行网上银行进行转账，选择“江西银行”时，发现无对应的开户行（网点）“江西银行股份有限公司／江西银行股份有限公司总行营业部” ，此时请将收款银行变更为“城市商业银行”。</p>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('jspage'); ?>
<script>
    var clipboard = new Clipboard('.v4-btn-copy');
    clipboard.on('success', function(e) {
        $(".v4-copy-success").fadeIn();
        setTimeout(function(){
              $(".v4-copy-success").fadeOut();
        },2000)
    });

    // clipboard.on('error', function(e) {
    //     console.log(e);
    // });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc4.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>