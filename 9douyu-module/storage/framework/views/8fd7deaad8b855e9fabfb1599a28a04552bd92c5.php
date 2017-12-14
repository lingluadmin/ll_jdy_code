<div class="v4-banner">
        <?php if(!empty($wapBannerList)): ?>
            <!-- banner -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach($wapBannerList as $banner): ?>
                        <div class="swiper-slide">
                            <a href="<?php echo e($banner['param']['url']); ?>" data-touch="false"><img src="<?php echo e($banner['param']['file']); ?>" /></a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        <?php endif; ?>
</div>