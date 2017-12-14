@extends('wap.common.wapBaseNew')

@section('title', '九斗鱼理财')

@section('css')
<link rel="stylesheet" type="text/css" href="{{assetUrlByCdn('/static/weixin/css/wap4/project.css')}}">
@endsection

@section('content')
    
   
<article>
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">项目列表</h5>
        <div class="v4-user">
                <!-- <a href="/login">登录</a> | <a href="/register">注册</a> -->
                <a href="javascript:;" data-show="nav">我的</a>
        </div>
    </nav>

    <div id="wrapper" url="{{$paper['next_page_url']}}">
        <div class="scroller">
            @if(!empty($list))
                @foreach($list as $project)
                    @if($project['pledge'] == 1)
                        <div class="v4-section-head flex-box box-align box-pack">
                            <img src="{{ assetUrlByCdn('static/weixin/images/wap4/index/icon-title2.png')}}" alt="新手专享" class="title" />
                            <a href="/project/detail/{{$project['id']}}" class="v4-btn-arrow">仅限首次投资</a>
                        </div>
                        <a href="/project/detail/{{$project['id']}}" class="v4-project-list {{$project['status'] > 130 ? 'disabled' : ''}}" data-touch="false">
                            <ul class="flex-box box-align box-pack">
                                <li>
                                    <p class="big v4-text-red">{{$project['base_rate']}}<span>%</span>+{{$project['after_rate']}}<span>%</span></p>
                                    <span>借款利率</span>
                                </li>
                                <li>
                                    <p>项目期限 <em class="v4-text-red">{{$project['invest_time_note']}}</em></p>
                                    <span>{{$project['refund_type_note']}}</span>
                                </li>
                            </ul>
                        </a>
                    @else
                        <a href="/project/detail/{{$project['id']}}" class="v4-project-list {{$project['status'] > 130 ? 'disabled' : ''}}" data-touch="false">
                            <header class="clearfix"><h5 class="title">{{$project['name']}} <em>{{$project['format_name']}}</em></h5>{{--<span class="flag">国庆节活动</span>--}}</header>
                            <ul class="flex-box box-align box-pack">
                                <li>
                                    <p class="big v4-text-red">{{$project['profit_percentage']}}<span>%</span></p>
                                    <span>借款利率</span>
                                </li>
                                <li>
                                    <p>项目期限 <em class="v4-text-red">{{$project['invest_time_note']}}</em></p>
                                    <span>{{$project['refund_type_note']}}</span>
                                </li>
                            </ul>
                        </a>
                    @endif
                @endforeach
            @endif

            <!-- loading more -->
          <div class="v4-load-more"><i class="pull_icon"></i><span>上拉加载...</span></div>
       </div>

    </div>
</article>
    <!-- fixed footer -->
    @include('wap.home.downloadapp')
    <!-- 侧边栏 -->
    @include('wap.home.nav')
 
@endsection


@section('jsScript')

    <script src="{{ assetUrlByCdn('static/weixin/js/wap4/iscroll.js')}}"></script>
    <script>
        var myscroll = new iScroll("wrapper",{
            onScrollMove:function(){
                if (this.y<(this.maxScrollY)) {
                    $('.pull_icon').addClass('flip');
                    $('.pull_icon').removeClass('loading');
                    $('.v4-load-more span').text('释放加载...');
                }else{
                    $('.pull_icon').removeClass('flip loading');
                    $('.v4-load-more span').text('上拉加载...')
                }
            },
            onScrollEnd:function(){
                if ($('.pull_icon').hasClass('flip')) {
                    $('.pull_icon').addClass('loading');
                    $('.v4-load-more span').text('加载中...');
                    pullUpAction();
                }
                
                
            },
            onRefresh:function(){
                $('.v4-load-more').removeClass('flip');
                $('.v4-load-more span').text('上拉加载...');
            }
            
        });
        
        function pullUpAction(){
            setTimeout(function(){
                var url = $('#wrapper').attr('url');
                $.ajax({
                    url:url,
                    type:'get',
                    dataType:'json',
                    success:function(result){
                        var resultData = result.data.list;
                        var url = result.data.paper.next_page_url;
                        for (var i = 0; i < resultData.length; i++) {
                            if(resultData[i].status > 130){
                                var is_disabled = 'disabled';
                            }else{
                                var is_disabled = '';
                            }
                            var template =  '<a href="/project/detail/'+resultData[i].id+'" class="v4-project-list '+is_disabled+'" data-touch="false">'+
                                                '<header class="clearfix"><h5 class="title">'+resultData[i].name+' '+resultData[i].format_name+'</h5><!--<span class="flag">国庆节活动</span>--></header>'+
                                                    '<ul class="flex-box box-align box-pack">'+
                                                        ' <li>'+
                                                            ' <p class="big v4-text-red">'+resultData[i].profit_percentage+'<span>%</span></p>'+
                                                            '<span>借款利率</span>'+
                                                        '</li>'+
                                                        '<li>'+
                                                            '<p>项目期限 <em class="v4-text-red">'+resultData[i].invest_time_note+'</em></p>'+
                                                            '<span>'+resultData[i].refund_type_note+'</span>'+
                                                        '</li>'+
                                                    '</ul>'+
                                            ' </a>';
                            $('.v4-load-more').before(template);
                        }
                        $('#wrapper').attr('url',url);
//                        $('.scroller ul').append(template);
                    },
                    error:function(){
                        console.log('error');
                    },
                })
                myscroll.refresh();
            }, 1000)
        }
        if ($('.scroller').height()<$('#wrapper').height()) {
            $('.v4-load-more').hide();
            myscroll.destroy();
        }

    </script>

@endsection

