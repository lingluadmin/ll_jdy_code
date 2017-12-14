/**
 * 
 * @authors xia.lili
 * @param  element    点击元素
 * @param  content    切换内容
 * @param  className  当前选中样式，默认为active
 * 
 */

;(function($){
	$.fn.toggleContent = function(content,className){
		var	cont    = content;
		 	classN  = className || 'active',
		this.each(function(){
			$(this).click(function(){
		        if(!$(this).hasClass(classN)){
		            $(this).addClass(classN);
		        }else{
		             $(this).removeClass(classN);
		        };
		        
		        $(this).next(cont).slideToggle(300).siblings(cont).slideUp("slow");
		    });
		});
	}
})(jQuery, window, document);