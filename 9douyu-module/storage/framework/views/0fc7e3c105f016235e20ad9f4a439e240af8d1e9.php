<div class="v4-leftNav">
    <ul>
        <li class="active <?php if(Request::path() == 'user'): ?> checked <?php endif; ?>"><a href="<?php echo e(URL('/user')); ?>"  class="checkeda"><i class="v4-iconfont v4-left-nav-icon">&#xe698;</i>账户总览</a></li>
        <li class="<?php if(Request::path() == 'user/fundhistory'): ?> checked <?php endif; ?>"><a href="<?php echo e(URL('/user/fundhistory')); ?>" ><i class="v4-iconfont v4-left-nav-icon">&#xe69c;</i>资金记录</a></li>
        <li class="<?php if(Request::path() == 'user/investList'): ?> checked <?php endif; ?>"><a href="<?php echo e(URL('/user/investList')); ?>"   ><i class="v4-iconfont v4-left-nav-icon">&#xe69b;</i>合同下载</a></li>
        <li class="<?php if(Request::path() == 'user/investList'): ?> checked <?php endif; ?>"><a href="<?php echo e(URL('/user/investList')); ?>"   ><i class="v4-iconfont v4-left-nav-icon">&#xe69a;</i>账户设置</a></li>
    </ul>
</div>
