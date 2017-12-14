<div class="v4-aboutMenu">
    <div class="v4-wrap">
    	<ul>
    	    <li class="<?php if(Request::path() == 'about'): ?>active <?php endif; ?>"><a href="<?php echo e(URL('/about')); ?>">公司介绍</a></li>
            <li class="<?php if(Request::path() == 'about/team'): ?> active <?php endif; ?>"><a href="<?php echo e(URL('/about/team')); ?>" >管理团队</a></li>
    	    <li class="<?php if(Request::path() == 'about/development'): ?>active <?php endif; ?>"><a href="<?php echo e(URL('/about/development')); ?>" ></i>发展历程</a></li>
    	    <li class="<?php if(Request::path() == 'about/honor'): ?> active <?php endif; ?>"><a href="<?php echo e(URL('/about/honor')); ?>" >企业荣誉</a></li>
    	    <li class="<?php if(Request::path() == 'about/partner' ): ?>active <?php endif; ?>"><a href="<?php echo e(URL('/about/partner')); ?>" >合作伙伴</a></li>
    	    <li class="<?php if(Request::path() == 'about/media' ): ?>active <?php endif; ?>"><a href="<?php echo e(URL('/about/media')); ?>" >媒体报道</a></li>
    	    <li class="<?php if(Request::path() == 'about/notice' ): ?>active <?php endif; ?>"><a href="<?php echo e(URL('/about/notice')); ?>" >网站公告</a></li>
    	    <li class="<?php if(Request::path() == 'about/contactus' ): ?>active <?php endif; ?>"><a href="<?php echo e(URL('/about/contactus')); ?>" >联系我们</a></li>
    	</ul>
    </div>
</div>
<script type="text/javascript" src="<?php echo e(assetUrlByCdn('/assets/js/pc4/navfixed.js')); ?>"></script>
<script type="text/javascript">
(function($){
    $(function(){
        $('.v4-aboutMenu').navFixed();
    })
})(jQuery)
</script>