<div class="v4-project-content nopadbot">
    <div class="v4-tabel-detail-wrap">
    <!-- loading加载 -->
       <div class="v4-list-tab-wrap" ms-visible="!@isLoad">
           <div class="v4-loading-wrap">
            <img src="{{assetUrlByCdn('/static/images/pc4/v4-loading.png')}}" width="47" height="47" class="loading">
          </div>
       </div>
       <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-115" ms-visible="@isLoad">
           <thead>
               <tr>
                   <td>出借人</td>
                   <td>金额(元)</td>
                   <td>出借时间</td>
               </tr>
           </thead>
           <tbody>
               <tr ms-if="@investCount>0" ms-for="(k,v) in @extra.investList">
                   <td>{% @v.phone %}</td>
                   <td>{% @v.cash|number(2) %}</td>
                   <td>{% @v.created_at %}</td>
               </tr>
               <tr ms-if="@investCount<=0"><td colspan="3" class="v4-table-none">暂无数据</td></tr>
           </tbody>
       </table>  
       

    </div>
    <div class="v4-table-pagination" ms-if="@investCount>0">

        <a ms-if="@pager.current_page > 1" ms-attr="{'data-url':@pager.prev_page_url}" class="turn" ms-click="getInvestData($event)" href="javascript:void(0)">上一页</a>
           <span ms-for="(k,v) in @pager.view">
               <a ms-if="@pager.current_page==@v" href="javascript:void(0)" class="active">{% @pager.current_page %}</a>
               <a ms-if="@pager.current_page!=@v" ms-attr="{'data-url':@pager.page_url+@v}" ms-click="getInvestData($event)" href="javascript:void(0)">{% @v %}</a>
           </span>
        <a ms-if="@pager.current_page<@pager.last_page" ms-attr="{'data-url':@pager.next_page_url}" class="turn" ms-click="getInvestData($event)" href="javascript:void(0)">下一页</a>
    </div>
</div>