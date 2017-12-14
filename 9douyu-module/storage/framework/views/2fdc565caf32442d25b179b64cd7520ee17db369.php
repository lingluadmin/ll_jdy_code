<?php if( isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'jiudouyu') === false ): ?>
    <?php echo $__env->make('pc.common.9douyuFooter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('pc.common.jiudouyuFooter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>
