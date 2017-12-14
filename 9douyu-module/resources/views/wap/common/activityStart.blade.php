<style type="text/css">
	/* activity start  add by xialili 20170216 */
.pop-mask{position:fixed; top: 0; z-index: 999; bottom:0; left: 0; right:0; background-color: rgba(0,0,0,.8)}
.pop-start{width:100%; z-index: 9999; height: 18.95rem; position:fixed; top:0; left: 0;background: url("{{ assetUrlByCdn('/static/weixin/activity/activity-start.png') }}") center top no-repeat;background-size: 100%;}
.pop-close-a{width: 1.425rem; height: 1.425rem;position: fixed; z-index: 9999999; top: 3rem; right: 1.5rem; background: url("{{ assetUrlByCdn('/static/weixin/activity/activity-close.png') }}") 0 0 no-repeat; background-size: 100%; }
</style>
<div class="pop-mask"></div>
<div class="pop-start">
	<span class="pop-close-a"></span>
</div>
<script src="{{ assetUrlByCdn('/static/weixin/js/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript">
(function($){
	$(function(){
		
		$('.pop-close-a,.pop-mask').on('touchend',function(){
			$('.pop-mask,.pop-start').hide();
		})
	})
})(jQuery)
</script>