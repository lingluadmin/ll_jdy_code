<div class="v4-leftNav">
    <ul>
        <li class="<?php if(Request::path() == 'user'): ?>active checked <?php endif; ?>"><a href="<?php echo e(URL('/user')); ?>"  class="checkeda"><i class="v4-iconfont v4-left-nav-icon">&#xe698;</i>账户总览</a></li>
        <li class="<?php if(Request::path() == 'user/investList' || Request::path() == 'user/invest/detail'): ?>active checked <?php endif; ?>"><a href="<?php echo e(URL('/user/investList')); ?>" ><i class="v4-iconfont v4-left-nav-icon">&#xe693;</i>出借记录</a></li>
       <?php /* <li class="<?php if(Request::path() == ''): ?>active checked <?php endif; ?>"><a href="<?php echo e(URL('/')); ?>" ><i class="v4-iconfont v4-left-nav-icon">&#xe697;</i>转让记录</a></li>*/ ?>
        <li class="<?php if(strstr(Request::path(), 'user/fundhistory')): ?>active checked <?php endif; ?>"><a href="<?php echo e(URL('/user/fundhistory')); ?>" ><i class="v4-iconfont v4-left-nav-icon">&#xe693;</i>交易记录</a></li>
        <li class="<?php if(Request::path() == 'user/refundPlan'): ?>active checked <?php endif; ?>"><a href="<?php echo e(URL('/user/refundPlan')); ?>" ><i class="v4-iconfont v4-left-nav-icon">&#xe695;</i>回款日历</a></li>
        <li class="<?php if(strstr(Request::path() , 'user/bonus')): ?>active checked <?php endif; ?>"><a href="<?php echo e(URL('/user/bonus')); ?>" ><i class="v4-iconfont v4-left-nav-icon">&#xe68b;</i>优惠券<span class="v4-nav-red">(<?php echo e($view_bonus['ableUserBonusCount']); ?>)</span></a></li>
        <li class="<?php if(Request::path() == 'user/setting'): ?>active checked <?php endif; ?>"><a href="<?php echo e(URL('/user/setting')); ?>"   ><i class="v4-iconfont v4-left-nav-icon">&#xe69a;</i>账户设置</a></li>
        <li class="<?php if(Request::path() == 'user/message'): ?>active checked <?php endif; ?>"><a href="<?php echo e(URL('/user/message')); ?>" ><i class="v4-iconfont v4-left-nav-icon v4-icon-1">&#xe692;</i>消息中心 <?php if($view_notice['ableUserUnreadNotice'] > 0): ?><em class="v4-nav-red">•</em><?php endif; ?></a></li>
    </ul>
</div>
