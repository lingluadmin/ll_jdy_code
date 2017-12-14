<div class="m-navlist">
    <ul>
        <li class="m-firstnav <?php if( $class == '' || $class == 'index' ): ?>  graycolor <?php endif; ?>">
            <a href="<?php echo e(App\Tools\ToolUrl::getUrl('/about')); ?>">
                <span>公</span>
                <div><p>司介绍</br>
                        <em style="font-size: 12px;">Company Profile</em></p></div>
            </a>
        </li>
        <li <?php if( $class == 'sunholding' ): ?> class='graycolor' <?php endif; ?>>
            <a href="<?php echo e(App\Tools\ToolUrl::getUrl('/about/sunholding')); ?>">
                <span>耀</span>
                <div><p>盛中国</br>
                        <em style="font-size: 12px;">SunFund China</em></p></div>
            </a>
        </li>
        <li <?php if( $class == 'partner' ): ?> class='graycolor'<?php endif; ?>>
            <a href="<?php echo e(App\Tools\ToolUrl::getUrl('/about/partner')); ?>">
                <span>合</span>
                <div><p>作伙伴<br>
                        <em style="font-size: 12px;">Partner</em></p></div>
            </a>
        </li>
        <li <?php if( $class == 'media' ): ?> class='graycolor'<?php endif; ?>>
            <a href="<?php echo e(App\Tools\ToolUrl::getUrl('/about/media')); ?>">
                <span>媒</span>
                <div><p>体报道<br>
                        <em style="font-size: 12px;">Media Reports</em></p></div>
            </a>
        </li>
        <li <?php if( $class == 'notice' ): ?> class='graycolor'<?php endif; ?>>
            <a href="<?php echo e(App\Tools\ToolUrl::getUrl('/about/notice')); ?>" >
                <span>网</span>
                <div><p>站公告<br>
                        <em style="font-size: 12px;">Notice</em></p></div>
            </a>
        </li>
        <?php /* <li <?php if( $class == 'joinus' ): ?> class='graycolor'<?php endif; ?>>
            <a href="<?php echo e(App\Tools\ToolUrl::getUrl('/about/joinus')); ?>">
                <span>加</span>
                <div><p>入我们<br>
                        <em style="font-size: 12px;">Join Us</em></p></div>
            </a>
        </li> */ ?>
        <li class="m-lastnav <?php if( $class == 'branch' ): ?> graycolor <?php endif; ?>">
            <a href="<?php echo e(App\Tools\ToolUrl::getUrl('/about/branch')); ?>">
                <span>分</span>
                <div><p>支机构<br>
                        <em style="font-size: 12px;">Branch</em></p></div>
            </a>
        </li>
    </ul>
</div>