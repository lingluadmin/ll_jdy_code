/**
 * 
 * @param num 数值
 * @param length 位数，默认为2
 *
 * 用法:
 * $.toFixed(num,3)
 * 
 */

;(function($, window, document,undefined){
    $.extend({
		//四舍五入，引用js的toFixed函数
        toFixed: function(num, length) {
            num = parseFloat(num);
            if(isNaN(num)) num = 0;
            length = length || 2;
            var numStr = String(num);
            if(numStr.indexOf('.') != -1) {
                var parts = numStr.split('.');
                //强制后缀加1，解决2.555.toFixed(2) = 2.55的问题 2.555 => 2.5551
                if(parts[1].length >= length) {
                    num = parseFloat(numStr + "1");
                }
            }
            return parseFloat(num.toFixed(length));
        }
    })
})(jQuery, window, document);
