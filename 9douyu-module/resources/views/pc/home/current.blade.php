<div class="v4-wrap-margin clearfix">
    <a href="javascript:;" class="v4-novice-banner">
        <img src="{{assetUrlByCdn('/static/images/pc4/index/v4-novice-banner.jpg')}}">
    </a>
    <div class="v4-current-container">
        <h4><span ng-bind="current.name">零钱计划</span><sub ng-bind="current.note">灵活存取</sub></h4>
        <div class="v4-current-inner clearfix">
            <div class="inner inner1">
                <p class="big"><bt ng-bind="current.latest_interest_rate" >12.5</bt><sub>%</sub></p>
                <span>借款利率</span>
            </div>
            <div class="inner inner2">
                <div class="line line1"></div>
                <p><bt ng-bind="(current.total_amount - current.invested_amount)/10000 |number"></bt><sub>万元</sub></p>
                <span>开放额度</span>
                <div class="line line2"></div>
            </div>
            <div class="inner inner3">
                <a href="javascript:;" class="v4-btn v4-btn-min">立即出借</a>
            </div>
        </div>
    </div>
    <a href="javascript:;" class="v4-AD">
        <img src="{{assetUrlByCdn('/static/images/pc4/index/v4-AD.jpg')}}">
    </a>
</div>
