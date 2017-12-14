<!-- pagination -->
    <div class="v4-table-pagination">
       <a ms-if="@pager.current_page > 1" ms-attr="{'data-url':@pager.prev_page_url}"  ms-click="getBonusData($event)" class="turn">上一页</a>
       <span ms-for="(k,v) in @pager.view">
           <a ms-if="@pager.current_page==@v" href="javascript:void(0)" class="active">{% @pager.current_page %}</a>
           <a ms-if="@pager.current_page!=@v" ms-attr="{'data-url':@pager.page_url+@v}" ms-click="getBonusData($event)" >{% @v %}</a>
       </span>
       <a ms-if="@pager.current_page<@pager.last_page" href="javascript:void(0)" ms-attr="{'data-url':@pager.next_page_url}" ms-click="getBonusData($event)" class="turn">下一页</a>
    </div>
