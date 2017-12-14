<?php $__env->startSection('title', '账户设置'); ?>

<?php $__env->startSection('content'); ?>

<div class="v4-account">
    <!-- account begins -->
    <?php echo $__env->make('pc.common/leftMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">账户设置</h2>
        <div class="v4-user-information">
        	<ul>
        		<!-- 风险评测等级 -->
        		<li class="v4-info-not">
        			<div class="v4-info-title">风险评测等级</div>
        			<div class="v4-info-result">未评测</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">开始评测</a></div>
        		</li>
        		<li class="v4-info-been">
        			<div class="v4-info-title">风险评测等级</div>
        			<div class="v4-info-result v4-info-type">保守型</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">重新评测</a></div>
        		</li>
        		<!-- End 风险评测等级 -->

        		<!-- 手机号 -->
        		<li class="v4-info-been">
        			<div class="v4-info-title">手机号</div>
        			<div class="v4-info-result">152***7459</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">修改</a></div>
        		</li>
        		<!-- End 手机号 -->

        		<!-- 实名认证 -->
        		<li class="v4-info-been">
        			<div class="v4-info-title">实名认证</div>
        			<div class="v4-info-result"><span>**涵 </span>130**********0722</div>
        			
        		</li>
        		<!-- End 实名认证 -->

        		<!-- 登录密码 -->
        		<li class="v4-info-been">
        			<div class="v4-info-title">登录密码</div>
        			<div class="v4-info-result">已设置</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">修改</a></div>
        		</li>
        		<!-- End 登录密码 -->

        		<!-- 交易密码 -->
        		<li class="v4-info-not">
        			<div class="v4-info-title">交易密码</div>
        			<div class="v4-info-result">未设置</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">设置</a></div>
        		</li>
        		<li class="v4-info-been">
        			<div class="v4-info-title">交易密码</div>
        			<div class="v4-info-result">已设置</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">修改</a></div>
        		</li>
        		<!-- End 交易密码 -->

        		<!-- 邮箱认证 -->
        		<li class="v4-info-not">
        			<div class="v4-info-title">邮箱认证</div>
        			<div class="v4-info-result">未设置</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">设置</a></div>
        		</li>
        		<li class="v4-info-been">
        			<div class="v4-info-title">邮箱认证</div>
        			<div class="v4-info-result">152***7459@111.com</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">修改</a></div>
        		</li>
        		<!-- End 邮箱认证 -->

        		<!-- 紧急联系人 -->
        		<li class="v4-info-not">
        			<div class="v4-info-title">紧急联系人</div>
        			<div class="v4-info-result">未设置</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">设置</a></div>
        		</li>
        		<li class="v4-info-been">
        			<div class="v4-info-title">紧急联系人</div>
        			<div class="v4-info-result">122****4545</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">修改</a></div>
        		</li>
        		<!-- End 紧急联系人 -->

        		<!-- 联系地址 -->
        		<li class="v4-info-not">
        			<div class="v4-info-title">联系地址</div>
        			<div class="v4-info-result">未设置</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">设置</a></div>
        		</li>
        		<li class="v4-info-been">
        			<div class="v4-info-title">联系地址</div>
        			<div class="v4-info-result">北京市朝阳区</div>
        			<div class="v4-info-operate"><a href="javascript:;" class="v4-btn">修改</a></div>
        		</li>
        		<!-- End 联系地址 -->
        	</ul>
        </div>
        
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jspage'); ?>
<script>
$(function(){
    
})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pc.common.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>