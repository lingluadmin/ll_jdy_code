<?php $__env->startSection('title', '发展历程'); ?>
<?php $__env->startSection('csspage'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pc.about/aboutMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="v4-custody-wrap v4-wrap">
      <div class="">
          <ul class="v4-tab Js_tab clearfix">
                <?php if( $type == \App\Http\Dbs\Article\ArticleDb::JDYEVENT): ?>
                  <li class="cur" ><a href="/about/development/<?php echo e(\App\Http\Dbs\Article\ArticleDb::JDYEVENT); ?>">九斗鱼大事记</a></li>
                  <li ><a href="/about/development/<?php echo e(\App\Http\Dbs\Article\ArticleDb::YSEVENT); ?>">耀盛大事记</a></li>
                <?php else: ?>
                  <li ><a href="/about/development/<?php echo e(\App\Http\Dbs\Article\ArticleDb::JDYEVENT); ?>">九斗鱼大事记</a></li>
                  <li class="cur" ><a href="/about/development/<?php echo e(\App\Http\Dbs\Article\ArticleDb::YSEVENT); ?>">耀盛大事记</a></li>
                <?php endif; ?>
          </ul>
          <div class="js_tab_content">
                <?php if( $type == \App\Http\Dbs\Article\ArticleDb::JDYEVENT ): ?>
                    <div class="Js_tab_main Js_tab_box2" style="display: block;">
                        <!-- 九斗鱼大事件 -->
                        <?php /* <?php echo $__env->make('pc.about.development9douyu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>
                        <div class="v4-development-tab clearfix" data-tab="9douyu">

                            <?php if($data["yearArr"]): ?>
                                <?php foreach( $data["yearArr"] as $key=>$val): ?>
                                    <a href="javascript:;" <?php if($val == date("Y",time())): ?> class="active" <?php endif; ?> ><?php echo e($val); ?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php /*
                            <a href="javascript:;" class="active">2016</a>
                            <a href="javascript:;">2015</a>
                            <a href="javascript:;">2014</a>
                            */ ?>
                        </div>

                        <div class="v4-development-main">
                            <?php if($data["yearData"]): ?>
                                <?php foreach( $data["yearData"] as $key=>$val): ?>
                                    <dl class="v4-development-1" >
                                        <dd>
                                            <!-- 不跳转时 加forbidden -->
                                            <?php foreach( $val as $kk=>$vv): ?>
                                                <a href="javascript:;" class="forbidden"><em><?php echo e($vv["month"]); ?></em><b></b><span><?php echo e($vv["title"]); ?></span></a>
                                            <?php endforeach; ?>
                                            <?php /*
                                            <a href="javascript:;" class="forbidden"><em>8月02日</em><b></b><span>九斗鱼获得国家公安部门颁发认证的“信息系统安全等级保护”三级备案证明</span></a>
                                            <a href="#"><em>9月30日</em><b></b><span>九斗鱼荣获消费日报社颁发的2017年度“中国互联网金融行业最具创新价值品牌</span></a>
                                            <a href="#"><em>9月19日</em><b></b><span>九斗鱼CEO郭鹏获选《2016中国极客大奖》“科技金融创客先锋”</span></a>
                                            <a href="#"><em>10月19日</em><b></b><span>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</span></a>
                                            <a href="#"><em>11月20日</em><b></b><span>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</span></a>
                                            <a href="#" class="last"><em>12月30日</em><b></b><span>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</span></a>
                                            */ ?>
                                        </dd>
                                    </dl>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php /*
                            <dl class="v4-development-1" >
                                <dd>
                                    <!-- 不跳转时 加forbidden -->
                                    <a href="javascript:;" class="forbidden"><em>8月02日</em><b></b><span>九斗鱼获得国家公安部门颁发认证的“信息系统安全等级保护”三级备案证明</span></a>
                                    <a href="#"><em>9月30日</em><b></b><span>九斗鱼荣获消费日报社颁发的2017年度“中国互联网金融行业最具创新价值品牌</span></a>
                                    <a href="#"><em>9月19日</em><b></b><span>九斗鱼CEO郭鹏获选《2016中国极客大奖》“科技金融创客先锋”</span></a>
                                    <a href="#"><em>10月19日</em><b></b><span>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</span></a>
                                    <a href="#"><em>11月20日</em><b></b><span>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</span></a>
                                    <a href="#" class="last"><em>12月30日</em><b></b><span>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</span></a>
                                </dd>
                            </dl>
                            */ ?>
                        </div>

                    </div>
                <?php else: ?>
                    <div class="Js_tab_main Js_tab_box3" style="display: block;">
                        <!-- 耀盛大事件 -->
                        <?php /* <?php echo $__env->make('pc.about.developmentsunfund', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>

                        <div class="v4-development-tab clearfix" data-tab="sunfund">
                            <?php if($data["yearArr"]): ?>
                                <?php foreach( $data["yearArr"] as $key=>$val): ?>
                                    <a href="javascript:;" <?php if($val == date("Y",time())): ?> class="active" <?php endif; ?> ><?php echo e($val); ?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="v4-development-main">
                            <?php if($data["yearData"]): ?>
                                <?php foreach( $data["yearData"] as $key=>$val): ?>
                                    <dl class="v4-development-1">
                                        <dd>
                                            <!-- 不跳转时 加forbidden -->
                                            <?php foreach( $val as $kk=>$vv): ?>
                                                <a href="javascript:;" class="forbidden"><em><?php echo e($vv["month"]); ?></em><b></b><span><?php echo e($vv["title"]); ?></span></a>
                                            <?php endforeach; ?>
                                            <?php /*
                                            <a href="javascript:;" class="forbidden"><em>8月02日</em><b></b><span>九斗鱼获得国家公安部门颁发认证的“信息系统安全等级保护”三级备案证明</span></a>
                                            <a href="#"><em>9月30日</em><b></b><span>九斗鱼荣获消费日报社颁发的2017年度“中国互联网金融行业最具创新价值品牌</span></a>
                                            <a href="#"><em>9月19日</em><b></b><span>九斗鱼CEO郭鹏获选《2016中国极客大奖》“科技金融创客先锋”</span></a>
                                            <a href="#"><em>10月19日</em><b></b><span>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</span></a>
                                            <a href="#"><em>11月20日</em><b></b><span>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</span></a>
                                            <a href="#" class="last"><em>12月30日</em><b></b><span>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</span></a>
                                            */ ?>
                                        </dd>
                                    </dl>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php /*
                            <dl class="v4-development-1">
                                <dd>
                                    <!-- 不跳转时 加forbidden -->
                                    <a href="javascript:;" class="forbidden"><em>8月02日</em><b></b><span>九斗鱼获得国家公安部门颁发认证的“信息系统安全等级保护”三级备案证明</span></a>
                                    <a href="#"><em>9月30日</em><b></b><span>九斗鱼荣获消费日报社颁发的2017年度“中国互联网金融行业最具创新价值品牌</span></a>
                                    <a href="#"><em>9月19日</em><b></b><span>九斗鱼CEO郭鹏获选《2016中国极客大奖》“科技金融创客先锋”</span></a>
                                    <a href="#"><em>10月19日</em><b></b><span>九斗鱼首批接入中国支付清算协会小微金融风险信息共享平台</span></a>
                                    <a href="#"><em>11月20日</em><b></b><span>九斗鱼被收入《金融蓝皮书》百家主流平台并获BB+级评级</span></a>
                                    <a href="#" class="last"><em>12月30日</em><b></b><span>九斗鱼首批接入中关村互联网金融行业协会互联网金融信用信息共享系统</span></a>
                                </dd>
                            </dl>
                            */ ?>
                        </div>

                    </div>
                <?php endif; ?>
          </div>
      </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jspage'); ?>
<script type="text/javascript">
 $(function(){
    

    $('.Js_tab_box2 .v4-development-1').hide().eq(0).show()
    $('.Js_tab_box3 .v4-development-1').hide().eq(0).show()



    $(".Js_tab_box2").tabs({
        tabList: "[data-tab='9douyu']>a",//tab list
        tabContent: ".v4-development-1",//内容box
        tabOn:"active"
    });
    $(".Js_tab_box3").tabs({
        tabList: "[data-tab='sunfund']>a",//tab list
        tabContent: ".v4-development-1",//内容box
        tabOn:"active"
    });
 })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>