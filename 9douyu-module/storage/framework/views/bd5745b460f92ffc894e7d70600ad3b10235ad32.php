<?php $__env->startSection('title', '充值支付－九斗鱼'); ?>

<?php $__env->startSection('csspage'); ?>
<link rel="stylesheet" href="<?php echo e(assetUrlByCdn('/static/css/style.css')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

	<div class="wrap">
	  <div class="jump-message">
	    
	    <present name="message">
	      <h1>充值失败，请重试。</h1>
			<?php if($msg): ?>
			<p>失败原因：<?php echo e($msg); ?></p>
			<?php endif; ?>
			<p>现在就去：<a href="/jx/recharge">重新充值</a>，<a href="/user">我的账户</a> </p>
	      <span class="jump-error-icon"></span>
	    </present>
	    
	  </div>
   </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>