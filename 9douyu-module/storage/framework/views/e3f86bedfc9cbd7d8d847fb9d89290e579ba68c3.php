<?php $__env->startSection('title', '九斗鱼理财'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/project.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<article>
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">项目列表</h5>
        <div class="v4-user">
                <?php if($userId>0): ?>
                    <a href="javascript:;" data-show="nav">我的</a>
                <?php else: ?>
                    <a href="/login">登录</a> | <a href="/register">注册</a>
                <?php endif; ?>
        </div>
    </nav>

    <div class="scroller-wrap" ms-controller="projectHome" ms-on-swipeup="swipeUp()" ms-on-swipedown="swipeDown()">
        <div class="scroller">
            <?php if(!empty($novice)): ?>
                <div class="v4-section-head flex-box box-align box-pack">
                    <img src="<?php echo e(assetUrlByCdn('static/weixin/images/wap4/index/icon-title2.png')); ?>" alt="新手专享" class="title" />
                    <a href="/project/detail/<?php echo e($novice['id']); ?>" class="v4-btn-arrow">仅限首次投资</a>
                </div>

                <a href="/project/detail/<?php echo e($novice['id']); ?>" class="v4-project-list" data-touch="false">
                    <ul class="flex-box box-align box-pack">
                      <li>
                          <p class="big v4-text-red"><?php echo e(number_format($novice['base_rate'],1)); ?><span>%</span><?php if($novice['after_rate']>0): ?><span>+<?php echo e(number_format($novice['after_rate'],1)); ?>%</span><?php endif; ?></p>
                          <span>借款利率</span>
                      </li>
                      <li>
                          <p>项目期限 <em class="v4-text-red"><?php echo e($novice['format_invest_time'].$novice['invest_time_unit']); ?></em></p>
                          <span><?php echo e($novice['refund_type_note']); ?></span>
                      </li>
                    </ul>
                </a>
            <?php endif; ?>

            <a ms-repeat="project" ms-attr-href="/project/detail/{%el.id%}"  ms-class="{% el.status==130? 'v4-project-list':'v4-project-list disabled'%}">
                <header class="clearfix"><h5 class="title">{% el.name %}<em>&nbsp;{% el.format_name %}</em></h5></header>
                <ul class="flex-box box-align box-pack">
                  <li>
                      <?php /*<p class="big v4-text-red">{% el.profit_percentage|number(1) %}%</p>*/ ?>
                      <p class="big v4-text-red">{% el.base_rate|number(1) %}%<span ms-if="el.after_rate>0">+{% el.after_rate|number(1) %}%</span></p>
                      <span>借款利率</span>
                  </li>
                  <li>
                      <p>项目期限 <em class="v4-text-red">{% el.format_invest_time+''+el.invest_time_unit %}</em></p>
                      <span>{% el.refund_type_note %}</span>
                  </li>
                </ul>
            </a>

            <!-- loading more -->
          <div class="v4-load-more"><i class="pull_icon"></i><span>加载中...</span></div>
       </div>

    </div>
    <script src="<?php echo e(assetUrlByCdn('/static/weixin/js/lib/biz/project-home.js')); ?>"></script>
</article>
    <!-- fixed footer -->
    <?php echo $__env->make('wap.home.downloadapp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- 侧边栏 -->
    <?php echo $__env->make('wap.home.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('wap.common.wapBaseLayoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>