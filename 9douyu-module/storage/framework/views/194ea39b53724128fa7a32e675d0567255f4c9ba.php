<?php if( !empty($projectList['consumer']) ): ?>
<div class="v4-wrap-margin clearfix">
    <div class="v4-project-more more1">
        <h3>消费贷</h3>
        <p>居民消费&nbsp;小额分散</p>
        <a href="javascript:;" class="v4-btn v4-btn-more">更多项目</a>
    </div>
    <?php foreach($projectList['consumer'] as $consumer ): ?>
    <div class="v4-project-box">
        <?php if($consumer['after_rate'] !='0.00' ): ?>
        <div class="v4-project-mark"></div>
        <?php endif; ?>
        <h4>消费贷款 XFD00<?php echo e($consumer['id']); ?></h4>
        <p><?php echo e((float)$consumer['base_rate']); ?><sub>%<?php if($consumer['after_rate'] !='0.00' ): ?>+<?php echo e((float)$consumer['after_rate']); ?>% <?php endif; ?></sub></p>
        <span>借款利率</span>
        <div class="v4-project-progress">
            <div class="text clearfix"><span>募集进度</span><em><?php echo e($consumer['invest_speed']); ?>%</em></div>
            <div class="bar">
                <div class="step" style="width: <?php echo e($consumer['invest_speed']); ?>%"></div>
            </div>
        </div>
        <label>借款期限&nbsp;<?php echo e($consumer['invest_time_note']); ?></label>
        <?php if( $consumer['status'] == \App\Http\Dbs\Project\ProjectDb::STATUS_REFUNDING ): ?>
            <a href="/project/detail/<?php echo e($consumer['id']); ?>;" class="v4-btn"><?php echo e($consumer['status_note']); ?></a>
        <?php elseif( $consumer['status'] == \App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING ): ?>
            <a href="/project/detail/<?php echo e($consumer['id']); ?>" class="v4-btn">立即投资</a>
        <?php else: ?>
            <a href="/project/detail/<?php echo e($consumer['id']); ?>" class="v4-btn v4-btn-disabled"><?php echo e($consumer['status_note']); ?></a>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>