<div class="v4-table-pagination">
        <?php if($pager['current_page'] > 1): ?>
        <a href="<?php echo e($pager['prev_page_url']); ?>" class="turn">上一页</a>
        <?php endif; ?>
        <?php foreach($pager['view'] as $key => $page): ?>
        <a  <?php if($page == $pager['current_page']): ?> href="javascript:void(0)" class="active" <?php else: ?> href='<?php echo e($pager['page_url'].$page); ?>' <?php endif; ?>><?php echo e($page); ?></a>
        <?php endforeach; ?>
        <?php if($pager['current_page'] < $pager['last_page']): ?>
        <a href="<?php echo e($pager['next_page_url']); ?>" class="turn">下一页</a>
        <?php endif; ?>
</div>
