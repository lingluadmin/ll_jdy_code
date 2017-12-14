<div class="v4-project-content">
    <div class="v4-tabel-detail-wrap">
       <div class="v4-list-tab-wrap" ms-visible="!@isLoad">
            <div class="v4-loading-wrap">
                <img src="{{assetUrlByCdn('/static/images/pc4/v4-loading.png')}}" width="47" height="47" class="loading">
            </div>
       </div>
       <table class="v4-table-list v4-thead-bg v4-td-border v4-td-left-115" ms-visible="@isLoad">
           <thead>
               <tr>
                   <td>回款期数</td>
                   <td>回款类型</td>
                   <td>回款金额</td>
                   <td>预期回款日</td>
               </tr>
           </thead>
           <tbody>
               <tr ms-if="@planCount>0" ms-for="(k, v) in @extra.Plan">
                   <td>第{% @k+1 %}/{% @planCount %}期</td>
                   <td>{% @v.refund_note %}</td>
                   <td>{% @v.refund_cash|number(2) %}</td>
                   <td>{% @v.refund_time %}</td>
               </tr>
           </tbody>
       </table>
    </div>
</div>