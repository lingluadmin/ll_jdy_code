/**
 * 
 * @authors xia.lili
 * @param  heightEleOne    顶部元素一
 * @param  heightEleSec    顶部元素二,没有则为空''
 * @param  className  	   元素固定位置样式，默认为v4-aboutMenu-fixed
 * @param  marginNum       距离顶部元素距离，默认为0
 * $("element").navFixed() 固定元素样式
 */

;(function($){
	
	$.fn.navFixed = function(options){
		var settings = {
			heightEleOne:'.v4-top',
			heightEleSec:'.v4-header',
			marginNum:0,
			className:'v4-aboutMenu-fixed'
		};
		if (options) $.extend(settings, options);
		var $window = $(window),
			$navFixed = $(this),
			height1 = $(settings.heightEleOne).height() || 0,
			height2 = $(settings.heightEleSec).height() || 0;

		$window.on('scroll', function(e) {
            var scrollTop = $(this).scrollTop();
            if (scrollTop > height1 + height2 + settings.marginNum) {
                $navFixed.addClass(settings.className)
            } else {
                $navFixed.removeClass(settings.className)
            };
        }).trigger('scroll');
		
	}
})(jQuery, window, document);

