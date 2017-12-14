<section class="v4-project-wrap">
  <?php if(!empty($novice_project)): ?>
  <?php foreach($novice_project as $item): ?>
  <div class="v4-section-head flex-box box-align box-pack">
    <img src="<?php echo e(assetUrlByCdn('static/weixin/images/wap4/index/icon-title2.png')); ?>" alt="新手专享" class="title" />
    <a href="/project/detail/<?php echo e($item["id"]); ?>" class="v4-btn-arrow"><?php echo e($item['invest_tip']); ?></a>
  </div>
  <div class="v4-table-project">
    <a href="/project/detail/<?php echo e($item["id"]); ?>" class="v4-project" data-touch="false">
      <ul class="flex-box box-align box-pack">
        <li>
          <p class="big v4-text-red"><?php echo e($item['base_rate']); ?><span>%<?php if($item['after_rate']>0): ?>+<?php echo e($item['after_rate']); ?>%<?php endif; ?></span></p>
            <span>期待年回报率</span>
        </li>
        <li>
           <p><?php echo e($item['project_time_note']); ?> <em class="v4-text-red"><?php echo e($item['invest_time_note']); ?></em></p>
           <span><?php echo e($item['refund_type_note']); ?></span>
        </li>
      </ul>
    </a>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>
</section>