<p class="twe-1">活动期间每日登录平台可领取双12投资红包，请在以下中任选一个领取</p>
<section ms-for="(k,v) in @bonusList" >
    <dl ms-if="@v.receive_status==10"   class="twe-bouns received ">
        <dt class="receive-bonus" ms-attr="{'attr-bonus-id':@v.name, 'attr-bonus-note':@v.note,'attr-bonus-position':@v.position}" attr-bonus-status="received">
            <p><span>{%@v.position%}</span>{%@v.unit%}</p>
        </dt>
        <dd>起投金额{%@v.min_money%}元</dd>
    </dl>

    <dl ms-if="@v.receive_status==20"   class="twe-bouns" >
        <dt class="receive-bonus" ms-attr="{'attr-bonus-id':@v.name, 'attr-bonus-note':@v.note,'attr-bonus-position':@v.position}" attr-bonus-status="open">
            <p><span>{%@v.position%}</span>{%@v.unit%}</p>
        </dt>
        <dd>起投金额{%@v.min_money%}元</dd>
    </dl>
</section>