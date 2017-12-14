<h4 class="twe-title2"></h4>
<div class="twe-box-1 twe-box-2">
    <div class="page-project" ms-for="(k,v) in @projectList">
        <h1 class="title">{%@v.name%}  {%@v.format_name%}</h1>
        <table>
            <tbody>
            <tr>
                <td class="td1"><p class="red"><big>{%@v.profit_percentage%}</big>%</p><span>期待年回报率</span></td>
                <td class="td2"><p>{%@v.format_invest_time%}{%@v.invest_time_unit%}</p><span>项目期限</span></td>
                <td class="td3"><p>{%@v.refund_type_note%}</p><span>还款方式</span></td><td>
                    <a ms-if="@v.status==130" href="javascript:;" class="page-btn-project clickInvest" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}">立即出借</a>
                    <a ms-if="@v.status==150" href="javascript:;" class="page-btn-project  disable clickInvest" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}">已售罄</a>
                    <a ms-if="@v.status==160" href="javascript:;" class="page-btn-project disable clickInvest" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}">已完结</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>