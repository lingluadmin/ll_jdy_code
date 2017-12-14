<section class="v4-voice v4-project-wrap">
  <div class="v4-section-head flex-box box-align box-pack">
    <img src="<?php echo e(assetUrlByCdn('static/weixin/images/wap4/index/icon-title1.png')); ?>" alt="新手专享" class="title" />
    <a href="/project/lists" class="v4-btn-arrow">查看全部</a>
  </div>
  <div class="v4-table-project">
      <?php if(!empty($invest_project)): ?>
        <?php foreach($invest_project as $items): ?>
              <a href="/project/detail/<?php echo e($items['id']); ?>" class="v4-project" data-touch="false">
                  <ul class="flex-box box-align box-pack">
                      <li>
                          <p class="big v4-text-red"><?php echo e($items['base_rate']); ?><span>%<?php if($items['after_rate']>0): ?>+<?php echo e($items['after_rate']); ?>%<?php endif; ?></span></p>
                          <span>期待年回报率</span>
                      </li>
                      <li>
                          <p><?php echo e($items['project_time_note']); ?> <em class="v4-text-red"><?php echo e($items['invest_time_note']); ?></em></p>
                          <span><?php echo e($items['refund_type_note']); ?></span>
                      </li>
                  </ul>
              </a>
        <?php endforeach; ?>
      <?php endif; ?>
  </div>
  
</section>