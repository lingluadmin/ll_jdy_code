<div class="page-box">
    <div class="inner">
        <div class="page-project" ms-for="(k,v) in @projectList">
            <h1 class="title">{% @v.product_line_note %} {% @v.format_name %}</h1>
            <table>
                <tbody>
                <tr>
                    <td class="td1"><p><big>{% @v.profit_percentage | number(1) %}</big>%</p><span>借款利率</span></td>
                    <td class="td2"><p>{% @v.format_invest_time %}{% @v.invest_time_unit %}</p><span>项目期限</span></td>
                    <td class="td3"><p>{% @v.refund_type_note %}</p><span>还款方式</span></td>
                    <td>
                        <a ms-if="@v.status==130"   href="javascript:;" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}" class="page-btn-project doInvest">立即出借</a>
                        <a ms-if="@v.status==150"   href="javascript:;" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}" class="page-btn-project doInvest disable">已售罄</a>
                        <a ms-if="@v.status==160"   href="javascript:;" ms-attr="{'attr-data-id':@v.id, 'attr-act-token':@v.act_token}" class="page-btn-project doInvest disable">已完结</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>