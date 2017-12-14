<?php $__env->startSection('title', '资金流水'); ?>

<?php $__env->startSection('content'); ?>

    <div class="m-myuser">
        <!-- account begins -->
        <?php echo $__env->make('pc.common.leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="m-content mb30">
            <!--选项卡1导航-->
            <ul class="m-tabnav1">
                <li class="m-addstyle"><a href="/jx/fundhistory">资金明细</a></li>
                <?php /*<li class="ml-1"><a href="/user/bankcard">银行卡管理</a></li> */ ?>
            </ul>
            <div class="m-showbox pt40">
                <!--选项卡1内容1-->
                <div class="m-tabtitle">

                    <div class="m-tabbox">
                        <div>
                            <table class="table table-theadbg table-textcenter mb26px">
                                <thead>
                                <tr>
                                    <td>交易描述</td>
                                    <td>收支</td>
                                    <td>可用余额</td>
                                    <td>时间</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if( !empty($list) ): ?>
                                    <?php foreach( $list as $fund ): ?>
                                        <tr>
                                            <td><?php echo e($fund['note']); ?></td>
                                            <td class="m-bluefont"><?php echo e($fund['balance_change']); ?></td>
                                            <td><?php echo e($fund['balance']); ?></td>
                                            <td><?php echo e($fund['created_at']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td>暂无信息</td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>

                            <div class="web-page">
                                <?php echo $__env->make('scripts/paginate', ['paginate'=>$paginate], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- account ends -->
        <div class="clearfix"></div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>