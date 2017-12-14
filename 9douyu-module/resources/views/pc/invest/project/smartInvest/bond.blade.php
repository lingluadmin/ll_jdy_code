<div class="v4-project-content v4-smart-7">
    <div class="v4-tabel-detail-wrap">
       <div class="v4-list-tab-wrap" ms-visible="!@isLoad">
            <div class="v4-loading-wrap">
                <img src="{{assetUrlByCdn('/static/images/pc4/v4-loading.png')}}" width="47" height="47" class="loading">
            </div>
       </div>
       <p class="v4-smart-tip" ms-visible="@isLoad"><span class="v4-iconfont">&#xe6a9;</span>为了保护借款人信息，仅展示部分标的，投资后可在用户中心查看全部投资记录</p>
       <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-115 v4-smart-2" ms-visible="@isLoad">
           <thead>
               <tr>
                   <td>编号</td>
                   <td>借款人姓名</td>
                   <td>身份证号</td>
                   <td>借款用途</td>
                   <td>期限</td>
                   <td>借款金额</td>
                   <td>还款方式</td>
                   <td>逾期次数</td>
               </tr>
           </thead>
           <tbody>

               <tr  ms-for="(k,v) in @credit.creditList">
                   <td>{%@v.contractNo%}</td>
                   <td>{%@v.hide_loan_name%}</td>
                   <td>{%@v.hide_loan_card%}</td>
                   <td>{%@v.loanPurpose%}</td>
                   <td>{%@v.loanTerm%}</td>
                   <td>{%@v.loanAmount%}元</td>
                   <td>{%@v.repayment_type_note%}</td>
                   <td>{%@v.overdueNumber%}</td>
               </tr>
               <tr ms-if="@creditCount<=0"><td colspan="8" class="v4-table-none">暂无数据</td></tr>
           </tbody>
       </table>
       <div class="v4-table-pagination" ms-if="@creditCount>0">
           <a ms-if="@pager1.current_page > 1" ms-attr="{'data-url':@pager1.prev_page_url}" class="turn" ms-click="getCredit($event)" href="javascript:void(0)">上一页</a>
           <span ms-for="(k,v) in @pager1.view">
               <a ms-if="@pager1.current_page==@v" href="javascript:void(0)" class="active">{% @pager1.current_page %}</a>
               <a ms-if="@pager1.current_page!=@v" ms-attr="{'data-url':@pager1.page_url+@v}" ms-click="getCredit($event)" href="javascript:void(0)">{% @v %}</a>
           </span>
           <a ms-if="@pager1.current_page<@pager1.last_page" ms-attr="{'data-url':@pager1.next_page_url}" class="turn" ms-click="getCredit($event)" href="javascript:void(0)">下一页</a>
       </div>
    </div>
</div>
