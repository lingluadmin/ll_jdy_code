<div class="v4-table-pagination">
        @if($pager['current_page'] > 1)
        <a href="{{$pager['prev_page_url']}}" class="turn">上一页</a>
        @endif
        @foreach($pager['view'] as $key => $page)
        <a  @if($page == $pager['current_page']) href="javascript:void(0)" class="active" @else href='{{ $pager['page_url'].$page }}' @endif>{{$page}}</a>
        @endforeach
        @if($pager['current_page'] < $pager['last_page'])
        <a href="{{$pager['next_page_url']}}" class="turn">下一页</a>
        @endif
</div>
