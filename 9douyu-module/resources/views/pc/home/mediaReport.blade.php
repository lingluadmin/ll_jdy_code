<div class="v4-wrap v4-wrap-margin v4-news clearfix" >
    <div class="v4-media">
   		<a href="{{!empty($ad['mediaShow']['url']) ? $ad['mediaShow']['url'] : 'https://www.sunholding.com.cn/article/202.html'}}" title="{{!empty($ad['mediaShow']['word']) ? $ad['mediaShow']['word'] : '耀盛中国Fintech“业务协同” 打造新型“金融独角兽'}}">
            <img src="{{!empty($ad['mediaShow']['purl']) ? $ad['mediaShow']['purl'] : assetUrlByCdn('/static/images/pc4/v4-media-cover.jpg')}}" width="282" height="218">
        </a>
      	<div class="v4-media-list">
         <a href="/about/media" target="_blank"><span class="v4-right-arrow">媒体报道</span></a>
            <ul>
                <li ms-for="(k,v) in @article.media">
                    <a ms-attr="{'href':'/article/'+ v.id+'.html'}"><span>{% @v.publish_time|date("MM.dd") %}</span><em>|</em><span>{% @v.title %}</span></a>
                </li>
            </ul>
      	</div>
    </div>

 
    <div class="v4-notice">
        <ul class="v4-notice-tab js-footer-tab">
            <li ms-class="[@currentTab==1 && 'selected']"><a href="/about/notice" target="_blank" class="v4-right-arrow" ms-mouseover="changeTab($event)" data-tab="1">平台公告</a></li>
            <li class="last" ms-class="[@currentTab==2 && 'selected']"><a href="/about/notice?q=records" target="_blank" class="v4-right-arrow" ms-mouseover="changeTab($event)" data-tab="2">还款公告</a><div></div> </li>
        </ul>
        <div class="v4-notice-tabbox js-footer-tabbox">
            <div :visible="@currentTab==1">
                <ul>
                    <li ms-for="(k,v) in @article.notice">
                        <a ms-attr="{'href':'/article/'+ v.id+'.html'}"  target="_blank">{% @v.title |truncate(16,'...')%}</a></li>
                    </li>
                </ul>
            </div>
            <div :visible="@currentTab==2">
                <ul>
                    <li ms-for="(k,v) in @article.refund">
                        <a ms-attr="{'href':'/article/'+ v.id+'.html'}"  target="_blank"><span>{% @v.title |truncate(20,'...')%}</span></a></li>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
