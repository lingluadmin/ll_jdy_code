<ul class="clearfix mother-coupon">
    <li class="mother-300 page-li1" data-layer="layer-coupon" attr-bonus-value="ten">
        <p class="mother-coupon-txt"><big attr-used-desc ='{%couponBonus.ten.using_desc%}' attr-value-desc ='{%couponBonus.ten.money | number%}元现金券' ng-bind="couponBonus.ten.money | number">10</big>元</p>
        <p><small ng-bind="couponBonus.ten.using_desc">投资满8000元可用</small></p>
    </li>
    <li class="mother-300 page-li2" data-layer="layer-coupon" attr-bonus-value="thirty">
        <p class="mother-coupon-txt"><big attr-used-desc ='{%couponBonus.thirty.using_desc%}' attr-value-desc ='{%couponBonus.thirty.money | number%}元现金券' ng-bind="couponBonus.thirty.money | number">30</big>元</p>
        <p><small ng-bind="couponBonus.thirty.using_desc">投资满15000元可用</small></p>
    </li>
    <li class="mother-300 page-li3" data-layer="layer-coupon" attr-bonus-value="fifty">
        <p class="mother-coupon-txt"><big attr-used-desc ='{%couponBonus.fifty.using_desc%}' attr-value-desc ='{%couponBonus.fifty.money | number%}元现金券' ng-bind="couponBonus.fifty.money | number">60</big>元</p>
        <p><small ng-bind="couponBonus.fifty.using_desc">投资满20000元可用</small></p>
    </li>
    <li class="mother-100 page-li1" data-layer="layer-coupon" attr-bonus-value="point5">
        <p class="mother-coupon-txt2"><big attr-value-desc ='{%couponBonus.point5.rate | number%}%加息券' attr-used-desc ='{%couponBonus.point5.using_desc%}' ng-bind="couponBonus.point5.rate | number">1</big>%定期</p>
        <p><small ng-bind="couponBonus.point5.using_desc">起投金额30000元可用</small></p>
    </li>
    <li class="mother-100 page-li5" data-layer="layer-coupon" attr-bonus-value="per1">
        <p class="mother-coupon-txt2"><big attr-value-desc ='{%couponBonus.per1.rate | number%}%加息券' attr-used-desc ='{%couponBonus.per1.using_desc%}' ng-bind="couponBonus.per1.rate | number">1.5</big>%定期</p>
        <p><small ng-bind="couponBonus.per1.using_desc">起投金额50000元可用</small></p>
    </li>
</ul>