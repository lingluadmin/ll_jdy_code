<?php $__env->startSection('title', '媒体报道'); ?>
<?php $__env->startSection('csspage'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pc.about/aboutMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="v4-custody-wrap v4-wrap">
    <!-- account begins -->

    <div class="v4-content">
        <div class="v4-about-list-wrap">
            <ul class="v4-about-list">
                <?php if( !empty($list['list']) ): ?>
                    <?php foreach( $list['list'] as $k => $article ): ?>
                        <li <?php if($article['is_top'] == 1): ?> class="v4-list-first" <?php endif; ?>>
                            <a href="/article/<?php echo e($article['id']); ?>">
                                <span><?php echo e($article['title']); ?></span>
                                <ins><?php echo e(date('Y-m-d',strtotime($article['publish_time']))); ?></ins>
                            </a>
                        </li>
                    <?php endforeach; ?>

                <?php endif; ?>
            </ul>

        </div>
        <div class="v4-table-pagination">
            <?php echo $__env->make('scripts.paginate', ['paginate'=>$paginate], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('jspage'); ?>
<script type="text/javascript">

(function($){
    $(function(){
        // 检验输入框内容
        $.validation('.v4-input');

        // 表单提交验证
        $("#vaildTradingPassword").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#vaildTradingPassword'
            })) return false;
        });

        //密码eye
        $(".v4-eye-icon").click(function(){
            if($(this).hasClass("open")){
               $(this).removeClass("open");
               $(this).html("&#xe6a1;");
               $(this).prev().attr("type","password");
            }else{
                $(this).addClass("open");
                $(this).prev().attr("type","text");
                 $(this).html("&#xe6a2;");
            }
        })

    })
})(jQuery);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>