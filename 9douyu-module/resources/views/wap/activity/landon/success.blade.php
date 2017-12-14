@extends('wap.common.wapBase')

@section('title', '注册送888元红包')

@section('keywords', env('META_KEYWORD'))

@section('description', env('META_DESCRIPTION'))

@section('css')
<meta name="format-detection" content="telephone=yes">
<link rel="stylesheet" type="text/css" href="{{ assetUrlByCdn('/static/weixin/activity/landon/css/index.css')}}">
<style type="text/css">
	body{background-color: #fff;}
</style>
@endsection

@section('content')
<div class="landon-success">
	<p>注册成功，888元红包已到账</p>
	<p>即刻投资赚收益吧！</p>
	<p><img src="{{ assetUrlByCdn('/static/weixin/activity/landon/images/success.png')}}"></p>
	<p><a href="/project/lists" class="v4-block-btn">立即投资</a></p>
</div>



<div class="landon-fixed">
	<span>下载APP，领新手福利</span>
	<a href="{{$package}}" class="landon-fixed-btn">下载APP</a>
</div>

@endsection
@section('jsScript')
<script type="text/javascript" src="{{ assetUrlByCdn('/static/weixin/js/account.js')}}"></script>
<script type="text/javascript">
(function($){
	$(function(){
		var evclick = "ontouchend" in window ? "touchend" : "click";
	  // 密码的eye开关
	  $(".v4-reg-icon").on(evclick,function(){
	        if($(this).hasClass("open")){
	           $(this).removeClass("open");
	           $(this).prev().attr("type","password");
	        }else{
	            $(this).addClass("open");
	            $(this).prev().attr("type","text");
	        };
		});

		$.checkedBox('#checkbox','#v4-input-btn');
		$.validation('#registerForm .v4-reg-input',{
            errorMsg:'#v4-input-msg',
        });
        // 表单提交验证
         $("#registerForm").bind('submit',function(){
            if(!$.formSubmitF('#registerForm .v4-reg-input',{
                fromT:'#registerForm'
            })) return false;
        });

         $('#bonus-btn,#project-btn').on(evclick,function(){
         	var topH = $('.landon-top').height();
         	var bannerH = $('.landon-banner').height();
         	$('html,body').animate({scrollTop: (topH+bannerH-30)}, 500);

         })

	})
})(jQuery)

 
</script>
@endsection

