@extends('pc.common.layoutNew')
@section('title', $title)
@section('keywords', $keywords)
@section('description', $description)
@section('csspage')
    
@endsection

@section('content')
@include('pc.about/aboutMenu')
<div class="v4-custody-wrap v4-wrap">
    <!-- account begins -->

    <div class="v4-content v4-account-white">
    <div class="Js_tab_box" ms-controller="noticeCtrl">
            <!--tab-->
            <ul class="v4-tab Js_tab clearfix">
                <li ms-class="[@toggole==1 && 'cur']"  ms-mouseover="changeTab($event)" data-tab-id="1" >平台公告</li>
                <li ms-class="[@toggole==2 && 'cur']"  ms-mouseover="changeTab($event)" data-tab-id="2" >还款公告</li>
            </ul>
            {{--平台公告--}}
            <div class="js_tab_content">
                <div class="Js_tab_main v4-about-list-wrap v4-hidden-tabbox" ms-visible="@toggole==1">
                    <ul class="v4-about-list">
                        <li ms-for="(key, val) in @list">
                            <a ms-attr="{href:'/article/' + val.id}">
                                <span>{% @val.title %}
                                <i class="v4-list-first-icon" ms-visible="@val.is_top==1">置顶</i>
                                </span>
                                <ins>{% @val.publish_time | date("yyyy-MM-dd") %}</ins>
                            </a>
                        </li>

                    </ul>
                    <div class="v4-table-pagination">
                        <a ms-if="@pager1.current_page > 1" ms-attr="{'data-url':@pager1.prev_page_url}" class="turn" ms-click="getData($event, 1)">上一页</a>
                           <span ms-for="(k,v) in @pager1.view">
                               <a ms-if="@pager1.current_page==@v" href="javascript:void(0)" class="active">{% @pager1.current_page %}</a>
                               <a ms-if="@pager1.current_page!=@v" ms-attr="{'data-url':@pager1.page_url+@v}" ms-click="getData($event, 1)">{% @v %}</a>
                           </span>
                        <a ms-if="@pager1.current_page<@pager1.last_page" ms-attr="{'data-url':@pager1.next_page_url}" class="turn" ms-click="getData($event, 1)">下一页</a>
                    </div>

                </div><!--tabbox1-->
                {{--还款公告--}}
                <div class="Js_tab_main v4-about-list-wrap v4-hidden-tabbox" ms-visible="@toggole==2">
                    <ul class="v4-about-list">
                        <li ms-for="(key, val) in @records">
                            <a ms-attr="{href:'/article/' + val.id}">
                                <span>{% @val.title %}</span>
                                <ins>{% @val.publish_time | date("yyyy-MM-dd") %}</ins>
                            </a>
                        </li>
                    </ul>
                    <div class="v4-table-pagination">
                        <a ms-if="@pager2.current_page > 1" ms-attr="{'data-url':@pager2.prev_page_url}" class="turn" ms-click="getData($event, 2)">上一页</a>
                           <span ms-for="(k,v) in @pager2.view">
                               <a ms-if="@pager2.current_page==@v" href="javascript:void(0)" class="active">{% @pager2.current_page %}</a>
                               <a ms-if="@pager2.current_page!=@v" ms-attr="{'data-url':@pager2.page_url+@v}" ms-click="getData($event, 2)">{% @v %}</a>
                           </span>
                        <a ms-if="@pager2.current_page<@pager2.last_page" ms-attr="{'data-url':@pager2.next_page_url}" class="turn" ms-click="getData($event, 2)">下一页</a>
                    </div>
                </div><!--tabbox2-->

            </div><!--tabouterbox-->


      </div>

        
        
    </div>
</div>
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
<input type="hidden" id="q" value="{{ $q }}" />
@if($q != '')
    <input type="hidden" id="pages" value="{{$page}}" />
@else
    <input type="hidden" id="page" value="{{$page}}" />
@endif
<script type="text/javascript" src="{{assetUrlByCdn('/static/lib/biz/about-notic.js')}}"></script>
@endsection
@section('jspage')
<script type="text/javascript">

(function($){
    $(function(){

    })
})(jQuery);
</script>
@endsection
