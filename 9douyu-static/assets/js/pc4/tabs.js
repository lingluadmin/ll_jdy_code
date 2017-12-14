/**
 * 
 * @param  tabList  tab切换标签，默认 .Js_tab li
 * @param  tabContent  tab切换内容，默认 .Js_tab_main
 * @param  tabOn  tab切换标签选中样式，默认 cur
 * @param  action  tab切换方式，默认 mouseover
 *
 * 
 * 调用方式:
 * 
 * $(".Js_tab_box").tabs(); 事件，默认mouseover
 * $(".Js_tab_box").tabs({action: "click" });  事件，action mouseover或者click
 * $(".Js_tab_box").tabs({tabList:'',tabContent:'',tabOn:'',action:''})
 *
 * 
 */


;(function($, window, document,undefined) {
    $.fn.tabs = function (options) {
        var settings = {
            tabList: ".Js_tab li",//tab list
            tabContent: ".Js_tab_main",//内容box
            tabOn:"cur",//当前tab类名
            action: "mouseover"//事件，mouseover或者click
        };
        var _this = $(this);
        if (options) $.extend(settings, options);
        _this.find(settings.tabContent).eq(0).show(); //第一栏目显示
        _this.find(settings.tabList).eq(0).addClass(settings.tabOn);
            _this.find(settings.tabList).each(function (i) {
            	$(this).on(settings.action,function(){
            		$(this).addClass(settings.tabOn).siblings().removeClass(settings.tabOn);
                    var _tCon = _this.find(settings.tabContent).eq(i);
                    _tCon.show().siblings().hide();
            	})
            });
    };
})(jQuery, window, document);