<div class="mother-day-prize">
    <h3 class="mother-prize-title">今日礼品</h3>
    <p class="mother-prize-bg">
        <img ng-src="{{assetUrlByCdn("/static/activity/tanabata/images/mother-prize-4.png")}}" alt="">
    </p>
    <p class="name" ng-bind=" 'LANEIGE水库套装' ">惊喜奖品！</p>
</div>

<div class="mother-list">
	<h3 class="mother-prize-title">获奖者名单</h3>
	<div class="mother-list-scroll">
    	<p ng-repeat="record in recordList"><span ng-bind="record.lottery_time"></span><span  ng-bind="record.hide_phone"></span><span  ng-bind="record.award_name"></span></p>
    </div>
</div>