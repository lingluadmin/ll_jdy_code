<?php if( !empty($article['newest']) ): ?>
    <div class="web-notice">
        <div class="wrap">
            <div class="t1-icon4 iconfont">&#xe604;</div>
            <div class="web-notic-title"><span>最新动态</span>|</div>
            <div class="web-notice-txt">
                <ul>
                    <?php foreach($article['newest'] as $newest): ?>
                    <li>
                        <a href="/article/<?php echo e($newest['id']); ?>" target="_blank" title="<?php echo e($newest['title']); ?>">
                            <span><?php echo e($newest['title']); ?></span>
                            <i>【<?php echo e(date('m-d', strtotime($newest['publish_time']))); ?>】</i>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="clear"></div>
            </div>
            <div class="web-notice-more">
                <a href="/about/notice">更多动态</a>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php endif; ?>