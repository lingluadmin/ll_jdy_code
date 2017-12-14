<?php if( !empty($jsxProject) ): ?>

    <div class="web-product4">
        <div class="new-flex-cash">
            <div class="new-flex-img" onclick=window.location.href="/project/index">
                <h4>优选项目</h4>
                <p>年年省心  月月返息</p>
                <a href="#"></a>
                <span>查看更多</span>
            </div>

            <div class="new-flex-project">
                <!-- 九安心 -->
                <?php echo $__env->make('pc.home/jax', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="new-flex-project-2">

                    <ul class="new-web-project-list clearfix">
                        <?php foreach( $jsxProject as $project ): ?>
                            <?php if( empty($project['id']) ): ?>
                                <?php continue; ?>
                            <?php endif; ?>
                            <li onclick="window.location.href='/project/detail/<?php echo e($project['id']); ?>'" class="on">
                                <div class="web-project-title">
                                    <h3><?php echo e($project['product_line_note']); ?>

                                        <?php if($project['product_line'] == \App\Http\Dbs\Project\ProjectDb::PROJECT_PRODUCT_LINE_JSX): ?>
                                            <?php if($project['type'] == 1): ?>
                                                1月期
                                            <?php else: ?>
                                                <?php echo e($project['invest_time_note']); ?>

                                            <?php endif; ?>
                                        <?php endif; ?></h3>
                                </div>
                                <div class="web-project-rate">
                                    <div class="web-project-rate-1">
                                        <p class="new-web-date"><strong><?php echo e((float)$project['profit_percentage']); ?></strong><span>%</span></p>
                                        <p class="new-web-text">借款利率</p>
                                    </div>
                                </div>
                                <div class="web-project-progress-box">
                                    <div class="web-project-progress"><p style="width: <?php echo e(number_format($project['invested_amount']/$project['total_amount'],2)*100); ?>%;"></p></div>
                                </div>
                                <div class="web-project-date">
                                    <p class="web-pro-mb"><strong><?php echo e($project['invest_time_note']); ?></strong></p>
                                    <p><span>期限</span></p>
                                </div>
                                <div class="web-project-sum">
                                    <p class="web-pro-mb">
                                        <strong><?php echo e(\App\Http\Models\Common\IncomeModel::getInterestPlan($project['profit_percentage'], $project['invest_time'],$project['refund_type'])); ?></strong>
                                    </p>
                                    <p><span>万元收益（元）</span></p>
                                </div>
                                <?php if( $project['status'] == \App\Http\Dbs\Project\ProjectDb::STATUS_REFUNDING ): ?>
                                    <a class="btn btn-blue disabled">已售罄</a>
                                <?php elseif( $project['status'] == \App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING && $project['publish_at'] > \App\Tools\ToolTime::dbNow() ): ?>
                                    <a class="btn btn-blue disabled">敬请期待</a>
                                <?php else: ?>
                                    <a class="btn btn-blue ">立即出借</a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
