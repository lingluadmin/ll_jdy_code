// JavaScript Document

// 右滑侧边栏
$(function(){

  function sidenav(sideMask,sideWrap,touchTarget){
    var evclick = "ontouchend" in window ? "touchend" : "click";
   // show
   $("[data-show='nav']").on(evclick,function(){
       sideMask.show();
       sideWrap.addClass("show");
       $("html,body").removeClass("html-auto").addClass("html-hidden");
   });
   // hide
   sideMask.on(evclick,function(){
       sideMask.hide();
       sideWrap.removeClass("show");
       $("html,body").removeClass("html-hidden").addClass("html-auto");
       //禁止鼠标穿透底层
       touchTarget.removeClass("pointer-auto").addClass("pointer-none");
       setTimeout(function(){touchTarget.removeClass("pointer-none").addClass("pointer-auto");}, 400);

   })
  }
  
  sideMask = $("[data-show='sidemask']"),
  sideWrap = $("[data-show='sidewrap']"),
  dataTouch = $("[data-touch='false']");

  sidenav(sideMask,sideWrap,dataTouch);
   
})







       