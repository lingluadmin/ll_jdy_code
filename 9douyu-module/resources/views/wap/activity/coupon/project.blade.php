<div class="page-project" ng-repeat="project in projectList">
    <p class="title" > {%project.product_line_note%} <span>•  {%project.format_invest_time%}{%project.invest_time_unit%}</span></p>
    <table>
        <tr>
            <td width="28%"><span ng-bind="project.profit_percentage | number">10</span><em>％</em></td>
            <td width="30%" ><span ng-bind="project.left_amount | number " ></span>元</td>
            <td rowspan="2">
                <a ng-if="userStatus != true" href="javascript:;" class="btn user-login-alert">立即出借</a>
                <a ng-if="userStatus == true && project.status==130" href="javascript:;" class="btn doInvest" attr-act-token="{%project.act_token%}" attr-data-id="{%project.id%}">立即出借</a>
                <a ng-if="userStatus == true && project.status!=130" href="javascript:;" class="btn disable doInvest" attr-act-token="{%project.act_token%}" attr-data-id="{%project.id%}" ng-bind="project.status_note">立即出借</a>
            </td>
        </tr>
        <tr><td>借款利率</td><td>剩余可投</td> </tr>
    </table>
</div>
