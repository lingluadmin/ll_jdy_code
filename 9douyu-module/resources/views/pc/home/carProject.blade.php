<div class="v4-wrap-margin clearfix" ms-if="@counter.len2 > 0">
    <div class="v4-project-more middle">
        <h3>中长期项目</h3>
        <p>优质资产&nbsp;安全放心</p>
        <a href="/project/index" class="v4-btn v4-btn-more">更多项目</a>
    </div>
    <div class="v4-project-box" ms-for="(k,v) in @project.carProjectList" ms-click="@redirectDetail(@v.id)">
        <div class="v4-listitem-icon right" ms-if="@v.after_rate !='0.00'"><span>限时加息</span></div>
        <div class="v4-listitem-icon right" ms-if="@v.pledge ==2"><span>灵活转让</span></div>
        <div class="v4-listitem-icon right" ms-if="@v.act_type !=0"><span>{% @v.act_note %}</span></div>
        <h4>{% @v.name+' '+ @v.format_name %}</h4>
        <p ms-if="@v.after_rate =='0.00'" ><bt>{% @v.base_rate|number(1) %}</bt><sub>%</sub></p>
        <p ms-if="@v.after_rate !='0.00'" ><bt>{% @v.base_rate|number(1) %}</bt><sub>+{% @v.after_rate|number(1) %}%</sub></p>
        <span>期待年回报率</span>
        <div class="v4-project-progress" >
            <div class="text clearfix"><span>募集进度</span><em>{% @v.invest_speed %}%</em></div>
            <div class="bar">
                <div class="step" ms-css="{'width':@v.invest_speed+'%'}"></div>
            </div>
        </div>
        <label>项目期限&nbsp;{%@v.format_invest_time%}&nbsp;{% @v.invest_time_unit%}</label>
        <a ms-if="@v.status==130" ms-attr="{'href':'/project/detail/'+@v.id}"  class="v4-btn">立即出借</a>
        <a ms-if="@v.status==150" ms-attr="{'href':'/project/detail/'+@v.id}"  class="v4-btn v4-btn-disabled">已售罄</a>
        <a ms-if="@v.status==160" ms-attr="{'href':'/project/detail/'+@v.id}"  class="v4-btn v4-btn-disabled">已完结</a>
    </div>

</div>
