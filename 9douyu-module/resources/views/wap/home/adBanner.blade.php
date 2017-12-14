<div class="v4-banner">
        @if(!empty($wapBannerList))
            <!-- banner -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($wapBannerList as $banner)
                        <div class="swiper-slide">
                            <a href="{{$banner['param']['url']}}" data-touch="false"><img src="{{$banner['param']['file']}}" /></a>
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        @endif
</div>