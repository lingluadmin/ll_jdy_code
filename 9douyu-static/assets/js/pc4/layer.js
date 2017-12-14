/**
 * 
 * @param  layerCon  弹窗内容标签，默认 .Js_layer
 * @param  layerWidth  弹窗内容宽度，默认 640
 * 
 * @param  a[data-target] 事件为打开弹窗
 * @param  若有data-toggle="mask"属性，data-target属性值为关闭目标弹窗的class样式名称
 * 
 * 调用方式:
 * 
 * <a href="javascript:;" data-target="module"></a>
 * 
 * <div data-toggle="mask" data-target="js-mask"></div>
 * <div class="js-mask"></div>
 *
 */



;(function($, window, document,undefined) {

    $(function(){

        //弹窗关闭隐藏
        $(document).on('click', '[data-toggle="mask"]', function (event) {
            event.stopPropagation();
            var target = $(this).attr("data-target");
            $("."+target).hide();

        });

        // 弹窗调用
        $(document).on('click', 'a[data-target]',function(event){
            event.stopPropagation();
            var target = $(this).attr("data-target");
                $("div[data-modul="+target+"]").layer();
        });

    });

    $.fn.layer = function(options){
        var settings = {
            layerCon:'.Js_layer',
            layerWidth:'640'
        };
        if (options) $.extend(settings, options);
        
        var jsLayer = this.find(settings.layerCon);
        this.show();
        jsLayer.css({
            "margin-left":-(settings.layerWidth/2)+"px",
            "margin-top":(jsLayer.height())== 0 ? -240+"px" : -(jsLayer.height()/2)-15+"px",
            "top":'50%',
            "width":settings.layerWidth+"px"
        });
    }


})(jQuery, window, document);