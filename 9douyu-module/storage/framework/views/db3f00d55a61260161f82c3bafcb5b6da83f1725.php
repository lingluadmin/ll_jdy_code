
  <div class="v4-section-head flex-box box-align box-pack">
    <h6 class="title">九斗鱼头条</h6>
    <a href="/Article/getAppV4ArticleList" class="v4-btn-arrow">查看全部</a>
  </div>
  <div class="v4-home-news">
    <?php if(!empty($article)): ?>
      <?php foreach($article as $val): ?>
        <a href="/Article/index/<?php echo e($val['id']); ?>" data-touch="false">
          <ul class="flex-box box-align box-pack">
            <li>
              <h5 class="title"><?php echo e($val['title']); ?></h5>
              <p class="date"><?php echo e($val['publish_time']); ?></p>
            </li>
            <li>
              <?php if(!empty($val['path'])): ?>
                <img src="<?php echo e(assetUrlByCdn('resources/'.$val['path'])); ?>" alt="">
              <?php else: ?>
                <img src="<?php echo e(assetUrlByCdn('static/weixin/images/wap4/index/news-img.png')); ?>" alt="">
              <?php endif; ?>
            </li>
          </ul>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
