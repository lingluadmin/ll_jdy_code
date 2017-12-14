<div class="v4-wrap-margin clearfix">
    <a href="<?php echo e(!empty($ad['noviceLeft']['url']) ? $ad['noviceLeft']['url'] : '/Novice/extension'); ?>" class="v4-novice-banner">
        <img src="<?php echo e(!empty($ad['noviceLeft']['purl']) ? $ad['noviceLeft']['purl'] : assetUrlByCdn('/static/images/pc4/index/v4-novice-banner.jpg')); ?>" width="200" height="200">
    </a>
    <div class="v4-current-container v4-relative">
    <div class="v4-listitem-icon right"><span>新手专享</span></div>
        <h4>新手专享<sub>仅限首次出借用户 限购5万</sub></h4>
        <div class="v4-current-inner clearfix" ms-click="@redirectDetail(@noviceProject.id)">
            <div class="inner inner1">
                <p class="big" ms-if="@noviceProject.after_rate =='0.00'"><bt>{% @noviceProject.base_rate|number(1)%}</bt><sub>%</sub></p>
                <p class="big" ms-if="@noviceProject.after_rate !='0.00'"><bt>{% @noviceProject.base_rate|number(1)%}</bt><sub>%+{% @noviceProject.after_rate|number(1)%}%</sub></p>
                <span>期待年回报率</span>
            </div>
            <div class="inner inner2">
                <div class="line line1"></div>
                <p><sub>{% @noviceProject.format_invest_time + @noviceProject.invest_time_unit %}</sub></p>
                <span>项目期限</span>
                <div class="line line2"></div>
            </div>
            <div class="inner inner3">
                <a ms-if="@noviceProject.status==130" ms-attr="{'href':'/project/detail/'+@noviceProject.id}" class="v4-btn v4-btn-min ">立即出借</a>
                <a ms-if="@noviceProject.status==150" ms-attr="{'href':'/project/detail/'+@noviceProject.id}" class="v4-btn v4-btn-disabled">已售罄</a>
                <a ms-if="@noviceProject.status==160" ms-attr="{'href':'/project/detail/'+@noviceProject.id}" class="v4-btn v4-btn-disabled">已完结</a>
            </div>
        </div>
    </div>
    <a href="javascript:;" class="v4-AD">
        <img src="<?php echo e(!empty($ad['noviceRight']['purl']) ? $ad['noviceRight']['purl'] : assetUrlByCdn('/static/images/pc4/index/v4-AD.jpg')); ?>" width="290" height="200">
    </a>
</div>