 ;(function($){
    $(function(){
      $("h3.v4-help-head").click(function(){
        if(!$(this).hasClass("active")){
            $(this).addClass("active");
        }else{
             $(this).removeClass("active");
        };
        if($(window).height()>=($(document.body).height()+220)){
            $(".js-bottom").addClass("t-add-footer");
        }else{
            $(".js-bottom").removeClass("t-add-footer")

        };
        $(this).next("div.v4-help-body").slideToggle(300).siblings("div.v4-help-body").slideUp("slow");
    });

       function setFixed(){
            var $window = $(window);
            var $body = $('body');
            var $header = $('.v4-aboutMenu');
            var height1 = $('.v4-top').height();
            var height2 = $('.v4-header').height();
            var MARGIN = 0;


            $window.on('scroll', function(e) {
                var scrollTop = $(this).scrollTop();

                if (scrollTop > height1 + height2 + MARGIN) {
                    $header.addClass('v4-aboutMenu-fixed')
                } else {
                    $header.removeClass('v4-aboutMenu-fixed')
                };
            }).trigger('scroll');
        }

        setFixed();
 
    })
})(jQuery, window, document);