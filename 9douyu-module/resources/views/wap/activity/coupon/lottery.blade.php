<div class="page-project page-center page-surprise">
		<div class="page-title3">今日礼品</div>
        <img ng-src="{{assetUrlByCdn("/static/weixin/activity/Tanabata/images/prize4.png")}}">
        <p ng-bind="'LANEIGE水库套装'">惊喜奖品！</p>
</div>
<div class="page-title3 page-title3-1">获奖名单</div>
<div class="page-winner-list">
    <p ng-repeat="record in recordList"><span ng-bind="record.lottery_time"></span><span  ng-bind="record.hide_phone"></span><span  ng-bind="record.award_name"></span>
</div>
