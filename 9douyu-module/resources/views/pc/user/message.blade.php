@extends('pc.common.base')
@section('title', '消息中心')
@section('csspage')
    
@endsection

@section('content')
<div class="v4-account clearfix">
    <!-- account begins -->
    @include('pc.common/leftMenu')

    <div class="v4-content v4-account-white">
        <h2 class="v4-account-titlex">消息中心</h2>
        <div class="v4-list-box">
        	<!-- 消息操作区 -->
			@if($isHasUnRead == true)
        	<div class="v4-message-operate">
        		<a href="javascript:;" onclick="setUserNoticeToRead('{{$isHasUnRead}}', 0)">全标为已读</a>
        	</div>
			@endif
        	<div class="v4-message-title">
        		<span class="v4-message-topic">消息主题</span>
        		<span class="v4-message-source">消息来源</span>
        		<span class="v4-message-date">发送时间</span>
        	</div>

        	<!-- 内容区 -->

@if( !empty($list) )
	@foreach($list as  $item)
				<div class="v4-message-main @if($item['is_read'] == \App\Http\Dbs\Notice\NoticeDb::UNREAD)v4-unread @endif ">
					<span class="v4-message-topic">{{$item['title_note']}}</span>
					<span class="v4-message-source">{{$item['type_note']}}</span>
					<span class="v4-message-date">{{$item['created_at']}}</span>
					@if($item['is_read'] == \App\Http\Dbs\Notice\NoticeDb::UNREAD)
					<span class="v4-message-fn" onclick="setUserNoticeToRead(true,'{{$item['id']}}')">查看<i></i></span>
					@else
					<span class="v4-message-fn">查看<i></i></span>
					@endif
					<div class="v4-message-content">{{$item['message']}}</div>
				</div>
	@endforeach
    @else
        <div class="v4-message-none">暂无消息</div>
@endif
        </div>
        <!-- pagination -->
        <div class="v4-table-pagination">
			@if( !empty($list) )
				@include('scripts/paginate', ['paginate'=>$paginate])
			@endif
        </div>
        
    </div>
</div>

@endsection
@section('jspage')
<script type="text/javascript">

(function($){
    $(function(){

	    // 查看消息内容
	    $('.v4-message-fn').each(function() {
	    	$(this).click(function() {

		    	if(!$(this).hasClass('up')){
		    		$(this).addClass('up').siblings('.v4-message-content').slideDown();
		    	}else{
		    		$(this).removeClass('up').siblings('.v4-message-content').slideUp();
		    	}
                if($(this).parent('div').has('v4-unread') ){

                    $(this).parent('div').removeClass('v4-unread')
                }
	    	});
	    });

    });

})(jQuery);
function setUserNoticeToRead( status,noticeId) {
    if( status== false ) {
        return false;
    }
    var _token	=	'{{csrf_token()}}';
    $.ajax({
        url: "/user/setNoticeRead",
        data: {_token: _token,notice_id:noticeId},
        dataType: "json",
		type: "post",
        success: function (json) {
			if(noticeId == 0){
                if(json.status==true ){
                    console.log('站内信全部设置已阅读状态');
                } else if( json.starts == false){
                    console.log('站内信全部设置已阅读状态失败');
                }
				$('.v4-message-operate').hide();
                $('.v4-message-main').each(function () {
					if( $(this).hasClass('v4-unread') ) {
                        $(this).removeClass('v4-unread')
					}
                })
            } else {
                if(json.status==true ){
                    console.log('站内信：'+noticeId +'，已经阅读');
                    return false
                } else if( json.starts == false){
                    console.log('站内信：'+noticeId +'，设置阅读状态失败');
                }
			}
		}
    });
}
</script>
@endsection
