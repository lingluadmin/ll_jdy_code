/**
 * @param    pattern 正则表达式
 * 
 * @用法
 * $("#cash").formatInput(/^\d*$/)
 * 保持连贯操作性，如：$("#cash").formatInput(/^\d*$/).addClass('error');
 * 
 */

;(function($){
    $.fn.extend({
    	formatInput:function(pattern) {
            if(typeof pattern == "undefined") return true;

            if($.trim(pattern) == "") return true;
            
            if($.trim($(this).val()) == "") return true;
            
            if($.trim($(this).val()).match(pattern)) {
                $(this).data("preValue", $(this).val());
            } else {
                $(this).val($(this).data("preValue"));
            }

            return this; 
        }
    })
})(jQuery,document,window);
