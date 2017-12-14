
<a href="/project/detail/{%project.id%}" ng-repeat="project in projectList">
    <table>
        <tr>
            <th colspan="5"><span ng-bind="project.product_line_note + project.format_invest_time + project.invest_time_unit"></span></th>
        </tr>
        <tr>
            <td>

                <p class="mother-red"><big ng-bind="project.profit_percentage | number:1"></big>%</p>
                <p><small>借款利率</small></p>
            </td>
            <td>

                <p ng-bind="project.format_invest_time + project.invest_time_unit"></p>
                <p><small>期限</small></p>
            </td>
            <td>

                <p ng-bind="project.refund_type_note"></p>
                <p><small>还款方式</small></p>
            </td>
            <td>
                <p><span ng-bind="project.left_amount | number" ></span> 元 </p>
                <p><small>剩余可投</small></p>
            </td>
            <td>
                <p ng-if="userStatus == true">
                    <a ng-if="project.status ==130" href="javascript:;" attr-data-id="{%project.id%}" class="mother-btn clickInvest" attr-act-token="{%project.act_token%}">立即出借</a>
                    <a ng-if="project.status !=130" href="javascript:;" attr-data-id="{%project.id%}" class="mother-btn clickInvest disable" attr-act-token="{%project.act_token%}" ng-bind="project.status_note">立即出借</a>
                </p>
                <p ng-if="userStatus != true">
                    <a href="javascript:;" class="mother-btn" data-layer="layer-login" attr-bonus-value="login">立即出借</a>
                </p>
            </td>
        </tr>
    </table>
</a>
