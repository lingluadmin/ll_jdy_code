<ul class="page-red-packet clearfix" id='bonus_list' attr-bonus-status='open'>
    <li ms-for="(k,v) in @bonusList">
        <a  ms-if="@v.receive_status==10" href="javascript:;" class="receive-bonus active" ms-attr="{'attr-bonus-id':@v.name, 'attr-bonus-note':@v.note,'attr-bonus-position':@v.position}" attr-bonus-status="received">
            <p class="in1 bonus-value"><big>{%@v.position%}</big>{%@v.unit%}</p>
            <span class="des">恭喜您已领取</span>
        </a>
        <a  ms-if="@v.receive_status==20" href="javascript:;" class="receive-bonus " ms-attr="{'attr-bonus-id':@v.name, 'attr-bonus-note':@v.note,'attr-bonus-position':@v.position}" attr-bonus-status="open">
            <p class="in2 bonus-value"><big>{%@v.position%}</big>{%@v.unit%}</p>
        </a>
        <p class="limit" ms-if="@v.receive_status">起投金额{%@v.min_money%}元</p>
    </li>

</ul>
