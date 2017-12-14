<?php $__env->startSection('title', '银行卡管理'); ?>

<?php $__env->startSection('content'); ?>

    <div class="m-myuser">
        <!-- account begins -->

        <?php echo $__env->make('pc.common.leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="m-content mb30">
            <!--选项卡1导航-->
            <ul class="m-tabnav1">
                <li class="ml-1"><a href="/user/fundhistory">资金明细</a></li>
                <li class="m-addstyle"><a href="/user/bankcard">银行卡管理</a></li>
            </ul>
            <div class="m-showbox pt40">
                <!--银行卡管理-->
                <div>
                    <!--
                    <div class="system-message form-tips text-" style="color: red;"></div>
                    -->
                    <ul class="m-tocashbox clearfix">
                        <?php if(!empty($cards['list'][0])): ?>
                            <?php foreach($cards['list'] as $card): ?>
                                <li>
                                    <p class="m-tobank"><?php if( isset($card['bank_id']) ): ?><img src="<?php echo e(assetUrlByCdn('/static/images/bank-img/'. $card['bank_id'].'.gif')); ?>"><?php endif; ?> 提现银行卡</p>
                                    <div class="m-tocashcon pr">
                                        <p><label>卡号</label><?php if( isset($card['crad_number_web']) ): ?><?php echo e($card['crad_number_web']); ?><?php endif; ?></p>
                                        <p><label>户名</label><?php if( isset($cards['user_name']) ): ?><?php echo e($cards['user_name']); ?><?php endif; ?></p>
                                        <p><label>开户行</label>-</p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="pr m-blueborder">
                                <a href="/user/bankcard/add"><img src="<?php echo e(assetUrlByCdn('/static/images/new/m-addcard.png')); ?>" class="addpic"/></a>
                                <p class="pa m-bindcard">绑定提现银行卡</p>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </div>

        <!-- account ends -->
        <div class="clearfix"></div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>