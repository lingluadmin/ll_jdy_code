<div class="v4-margin clearfix" ms-if="@counter.len4 > 0">
    <div class="v4-project-more more4">
        <h3>转让专区</h3>
        <p>资金使用&nbsp;更灵活</p>
        <!-- <a href="javascript:;" class="v4-btn v4-btn-more">更多项目</a> -->
    </div>
    <div class="v4-assignment">
        <ul class="v4-assignment-inner" ms-for="(k,v) in @project.assignProjectList">
            <li class="li1"><span>转让</span>变现宝&nbsp;<bt>{% @v.format_name %}</bt></li>
            <li class="li2">
                <p>{% @v.percentage_float_one %}<sub>%</sub></p>
                <span>期待年回报率</span>
            </li>
            <li class="li3">
                <p>{% @v.left_day +@v.invest_time_unit %}</p>
                <span>项目期限</span>
            </li>
            <li class="li4">
                <div class="v4-scan-code">
                    <p class="p1">该功能仅支持移动端APP</p>
                    <p class="p2">下载体验更多服务</p>
                </div>
                <a ms-if="@v.project_type == 'investing'" href="javascript:;" class="v4-btn v4-btn-min">立即出借</a>
                <a ms-if="@v.project_type == 'fullscale'" href="javascript:;" class="v4-btn v4-btn-min v4-btn-disabled">已转让</a>
                <a ms-if="@v.project_type != 'fullscale' && @v.project_type != 'investing'" href="javascript:;" class="v4-btn v4-btn-min v4-btn-disabled" ng-bind="assign.project_type_note">已转让</a>
            </li>
        </ul>
    </div>
</div>