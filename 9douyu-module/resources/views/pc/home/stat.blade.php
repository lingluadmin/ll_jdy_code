<div class="v4-web-static" id="datamove2">
    <ul class="v4-wrap clearfix">

    	<li class="li1"><em>稳定运营时间</em><span class="data" ms-attr="{'data-rel':@data.created_time_y }"></span>年<span class="data" ms-attr="{'data-rel':@data.created_time_m }"></span>个月<span class="data" ms-attr="{'data-rel':@data.created_time_d }" ></span>天</li>
    	<li class="li2"><em>累计交易金额</em><span class="data" ms-attr="{'data-rel':@data.total_invest_amount.y }"></span>亿<span class="data" ms-attr="{'data-rel':@data.total_invest_amount.w }"></span>万元</li>
    	<li class="li3"><em>累计出借人数</em><span ms-if=" @data.borrow_user_count.w > 0 " class="data" ms-attr="{'data-rel':@data.borrow_user_count.w }"></span><span ms-if=" @data.borrow_user_count.w > 0 ">万</span><span class="data" ms-if=" @data.borrow_user_count.no_w > 0 " ms-attr="{'data-rel':@data.borrow_user_count.no_w }"></span><span ms-if=" @data.borrow_user_count.no_w > 0 ">人</span><span class="data" ms-if=" @data.borrow_user_count < 10000 " ms-attr="{'data-rel':@data.borrow_user_count }"></span><span ms-if=" @data.borrow_user_count < 10000 ">人</span></li>
    </ul>
</div>
