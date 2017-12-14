<?php if( !empty($projectList['car'])): ?>
    <div class="v4-wrap-margin clearfix">
        <div class="v4-project-more more2">
            <h3>车辆贷</h3>
            <p>车辆质押&nbsp;安全放心</p>
            <a href="javascript:;" class="v4-btn v4-btn-more">更多项目</a>
        </div>
        <?php foreach($projectList['car'] as $car ): ?>
            <div class="v4-project-box">
                <?php if($car['after_rate'] !='0.00' ): ?>
                    <div class="v4-project-mark"></div>
                <?php endif; ?>
                <h4>消费贷款 XFD00<?php echo e($car['id']); ?></h4>
                <p><?php echo e((float)$car['base_rate']); ?><sub>%<?php if($car['after_rate'] !='0.00' ): ?>+<?php echo e((float)$car['after_rate']); ?>% <?php endif; ?></sub></p>
                <span>借款利率</span>
                <div class="v4-project-progress">
                    <div class="text clearfix"><span>募集进度</span><em><?php echo e($car['invest_speed']); ?>%</em></div>
                    <div class="bar">
                        <div class="step" style="width: <?php echo e($car['invest_speed']); ?>%"></div>
                    </div>
                </div>
                <label>借款期限&nbsp;<?php echo e($car['invest_time_note']); ?></label>
                <?php if( $car['status'] == \App\Http\Dbs\Project\ProjectDb::STATUS_REFUNDING ): ?>
                    <a href="/project/detail/<?php echo e($consumer['id']); ?>;" class="v4-btn"><?php echo e($car['status_note']); ?></a>
                <?php elseif( $car['status'] == \App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING ): ?>
                    <a href="/project/detail/<?php echo e($car['id']); ?>" class="v4-btn">立即投资</a>
                <?php else: ?>
                    <a href="/project/detail/<?php echo e($car['id']); ?>" class="v4-btn v4-btn-disabled"><?php echo e($car['status_note']); ?></a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

