<div class="v4-wrap v4-wrap-margin v4-news clearfix">
    <div class="v4-media">
   		<a href="#"><img src="<?php echo e(assetUrlByCdn('/static/images/pc4/v4-media-cover.jpg')); ?>" width="282" height="218"></a>
      	<div class="v4-media-list">
          <h4><a href="/about/media" target="_blank"><span class="v4-right-arrow">媒体报道</span></a></h4>
          <ul>
              <?php if( !empty($article['media'])): ?>
                <?php foreach( $article['media'] as $key => $media ): ?>
                    <li><a href="/article/<?php echo e($media['id']); ?>.html" target="_blank"><span><?php echo e(date ('m.d',strtotime ($media['publish_time']))); ?></span><em>|</em>【<?php echo e(str_limit(strip_tags(stripslashes(htmlspecialchars_decode($media['title']))), $limit=70, $end='...')); ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                  <li><a href="#" ><span><?php echo e(date ('m.d',time ())); ?></span><em>|</em>暂无最新媒体报道</a></li>
              <?php endif; ?>
            </ul>
      	</div> 
    </div>
            
 
    <div class="v4-notice">
            <ul class="v4-notice-tab js-footer-tab">
                <div class="v4-footer-line">
                    <div class="v4-footer-blue"></div>
                </div>

                <li class="selected"><a href="/about/notice" target="_blank" class="v4-right-arrow">平台公告</a></li>
                <li class="last"><a href="/about/notice?q=records" target="_blank" class="v4-right-arrow">还款公告</a>
                    <div></div> </li>
            </ul>

            <div class="v4-notice-tabbox js-footer-tabbox">

                <?php if( !empty($article['notice']) ): ?>
                    <div >
                        <ul>
                            <?php foreach($article['notice'] as $notice): ?>
                                <li><a  href="/article/<?php echo e($notice['id']); ?>.html" target="_blank" rel="<?php echo e($notice['title']); ?>"><?php echo e(str_limit($notice['title'], $limit = 26, $end = '...')); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div>
                        <ul>
                            <li>暂无平台公告信息</li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if( !empty($article['refund']) ): ?>
                    <div class="none">
                        <ul>
                            <?php foreach($article['refund'] as $refund): ?>
                                <li><a  href="/article/<?php echo e($refund['id']); ?>.html" target="_blank" rel="<?php echo e($refund['title']); ?>"><?php echo e(str_limit($refund['title'], $limit = 26, $end = '...')); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="none">
                        <ul>
                            <li>暂无还款公告信息</li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
    </div>
</div>
