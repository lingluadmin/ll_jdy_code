
<div class="v4-leftNav" data-nav="help">
    <ul>
        <?php foreach( $helpList as $key => $help ): ?>
            <?php if( $help['id'] == $current['id'] ): ?>
                <li class="active"><a href="<?php echo e(App\Tools\ToolUrl::getUrl("/help/".$help['id'])); ?>"><i class="v4-iconfont v4-left-nav-icon"><?php echo $iconList[$key]; ?></i><?php echo e($help["title"]); ?></a></li>
            <?php else: ?>
                <li><a href="<?php echo e(App\Tools\ToolUrl::getUrl("/help/".$help['id'])); ?>"><i class="v4-iconfont v4-left-nav-icon"><?php echo $iconList[$key]; ?></i><?php echo e($help["title"]); ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>