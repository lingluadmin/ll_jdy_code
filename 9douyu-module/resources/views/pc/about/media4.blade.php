@extends('pc.common.layoutNew')
@section('title', '媒体报道')
@section('csspage')
    
@endsection

@section('content')
@include('pc.about/aboutMenu')
<div class="v4-custody-wrap v4-wrap">
    <!-- account begins -->

    <div class="v4-content">
        <div class="v4-about-list-wrap">
            <ul class="v4-about-list">
                @if( !empty($list['list']) )
                    @foreach( $list['list'] as $k => $article )
                        <li @if($article['is_top'] == 1) class="v4-list-first" @endif>
                            <a href="/article/{{$article['id']}}">
                                <span>{{ $article['title'] }}</span>
                                <ins>{{ date('Y-m-d',strtotime($article['publish_time'])) }}</ins>
                            </a>
                        </li>
                    @endforeach

                @endif
            </ul>

        </div>
        <div class="v4-table-pagination">
            @include('scripts.paginate', ['paginate'=>$paginate])
        </div>
        
    </div>
</div>

@endsection
@section('jspage')
<script type="text/javascript">

(function($){
    $(function(){
        // 检验输入框内容
        $.validation('.v4-input');

        // 表单提交验证
        $("#vaildTradingPassword").bind('submit',function(){
            if(!$.formSubmitF('.v4-input',{
                fromT:'#vaildTradingPassword'
            })) return false;
        });

        //密码eye
        $(".v4-eye-icon").click(function(){
            if($(this).hasClass("open")){
               $(this).removeClass("open");
               $(this).html("&#xe6a1;");
               $(this).prev().attr("type","password");
            }else{
                $(this).addClass("open");
                $(this).prev().attr("type","text");
                 $(this).html("&#xe6a2;");
            }
        })

    })
})(jQuery);
</script>
@endsection
