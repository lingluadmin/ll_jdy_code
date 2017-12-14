<?php if(!empty($pageInfo) && $pageInfo['last_page'] >1): ?>
    <div class="">
        <ul class="pagination">
            <li><a href="<?php echo e($pageInfo['url'].(strpos($pageInfo['url'],'?') ? '&' : '?')); ?>page=1">首页</a></li>
            <li><a href="<?php echo e($pageInfo['url'].(strpos($pageInfo['url'],'?') ? '&' : '?')); ?> page=<?php echo e($pageInfo['current_page']-1); ?>">上一页</a></li>
            <?php for($i=1;$i<=$pageInfo['last_page'];$i++): ?>
                <?php if($i==$pageInfo['current_page']): ?>
                    <li class="active"><a href="<?php echo e($pageInfo['url'].(strpos($pageInfo['url'],'?') ? '&' : '?')); ?>page=<?php echo e($i); ?>"><?php echo e($i); ?></a></li>
                <?php elseif( ($i<$pageInfo['current_page'] && ($i+4)>$pageInfo['current_page']) || ($i > $pageInfo['current_page'] && ($i-4)<$pageInfo['current_page']) ): ?>
                    <li><a href="<?php echo e($pageInfo['url'].(strpos($pageInfo['url'],'?') ? '&' : '?')); ?>page=<?php echo e($i); ?>"><?php echo e($i); ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>
            <li><a href="<?php echo e($pageInfo['url'].(strpos($pageInfo['url'],'?') ? '&' : '?')); ?>page=<?php echo e(($pageInfo['current_page']+1)>$pageInfo['last_page']?$pageInfo['last_page']:($pageInfo['current_page']+1)); ?>">下一页</a></li>
            <li><a href="<?php echo e($pageInfo['url'].(strpos($pageInfo['url'],'?') ? '&' : '?')); ?>page=<?php echo e($pageInfo['last_page']); ?>">尾页</a></li>
            <li><a>共<?php echo e($pageInfo['last_page']); ?>页</a></li>
        </ul>
    </div>
<?php endif; ?>