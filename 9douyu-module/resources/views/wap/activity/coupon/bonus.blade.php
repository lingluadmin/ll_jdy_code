<ul class="page-center page-coupons set-bonus-message" id="coupon-status" attr-receive-lock = 'opened'>
    <li class="cash coupon-btn-bonus" data-layer="page-layer" data-touch="false" attr-bonus-value="ten" attr-used-desc ='{%couponBonus.ten.using_desc%}' attr-value-desc ='{%couponBonus.ten.money | number%}元现金券'>
        <p><span ng-bind="couponBonus.ten.money | number">10</span>元</p>
        <p ng-bind="couponBonus.ten.using_desc">投资满8000元可用</p>
    </li>
    <li class="cash coupon-btn-bonus" data-layer="page-layer" data-touch="false" attr-bonus-value="thirty" attr-used-desc ='{%couponBonus.thirty.using_desc%}' attr-value-desc ='{%couponBonus.thirty.money | number%}元现金券'>
        <p><span ng-bind="couponBonus.thirty.money | number">30</span>元</p>
        <p ng-bind="couponBonus.thirty.using_desc">投资满15000元可用</p>
    </li>
    <li class="cash coupon-btn-bonus" data-layer="page-layer" data-touch="false" attr-bonus-value="fifty" attr-used-desc ='{%couponBonus.fifty.using_desc%}' attr-value-desc ='{%couponBonus.fifty.money | number%}元现金券'>
        <p><span ng-bind="couponBonus.fifty.money | number">60</span>元</p>
        <p ng-bind="couponBonus.fifty.using_desc">投资满20000元可用</p>
    </li>
    <li class="interest coupon-btn-bonus" data-layer="page-layer" data-touch="false" attr-bonus-value="point5" attr-value-desc ='{%couponBonus.point5.rate | number%}%加息券' attr-used-desc ='{%couponBonus.point5.using_desc%}'>
        <p><span ng-bind="couponBonus.point5.rate | number">1</span>%定期</p>
        <p ng-bind="couponBonus.point5.using_desc">起投金额30000元</p>
    </li>
    <li class="interest coupon-btn-bonus" data-layer="page-layer" data-touch="false" attr-bonus-value="per1" attr-value-desc ='{%couponBonus.per1.rate | number%}%加息券' attr-used-desc ='{%couponBonus.per1.using_desc%}'>
        <p><span ng-bind="couponBonus.per1.rate | number">1.5</span>%定期</p>
        <p ng-bind="couponBonus.per1.using_desc">起投金额50000元</p>
    </li>
</ul>