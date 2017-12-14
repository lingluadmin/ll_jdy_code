<?php if(!empty($LogList['data'])): ?>
<?php foreach( $LogList['data'] as $list ): ?>
    <div class="w-b-list bb-1px w-ye-pr15px">
        <p class="font14px"><span class="fl"><?php echo e($list["note"]); ?></span><span class="fr w-red-color"><?php echo e($list["balance_change"]); ?></span></p>
        <div class="clear"></div>
        <p class="w-8c-color"><span class="fl"><?php echo e($list["created_at"]); ?></span><span class="fr"> <?php echo e(isset($list['note_other']) ? $list['note_other'] : null); ?></span></p>
        <div class="clear"></div>
    </div>
<?php endforeach; ?>
<?php endif; ?>