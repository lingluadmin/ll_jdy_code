<?php $__env->startSection('title', '联系我们'); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pc.about/aboutMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="v4-custody-wrap v4-wrap">
    <div class="v4-content clearfix">
        <div class="v4-contactus-1">
          <h4 class="v4-section-title"><span></span>公司地址</h4>
          <p>公司地址：北京市朝阳区郎家园6号郎园vintage 2号楼A座2层</p>

          <div class="v4-contactus-map">
            <img src="<?php echo e(assetUrlByCdn('static/images/pc4/v4-map.jpg')); ?>" width="1020" height="436">
          </div>
          <div class="v4-contactus-box">
            <h4 class="v4-section-title"><span></span>客户服务</h4>
            <p>客服电话：400-6686-568（服务时间：9:00~18:00）</p>
            <p>客服邮箱：customer@9douyu.com</p>
          </div>
          <div class="v4-contactus-box">
            <h4 class="v4-section-title"><span></span>商务合作</h4>
            <p>合作邮箱：business@9douyu.com</p>
          </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>