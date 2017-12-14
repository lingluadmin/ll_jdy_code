<section class="v4-voice v4-project-wrap">
  <div class="v4-section-head flex-box box-align box-pack">
    <img src="{{ assetUrlByCdn('static/weixin/images/wap4/index/icon-title1.png')}}" alt="新手专享" class="title" />
    <a href="/project/lists" class="v4-btn-arrow">查看全部</a>
  </div>
  <div class="v4-table-project">
      @if(!empty($invest_project))
        @foreach($invest_project as $items)
              <a href="/project/detail/{{$items['id']}}" class="v4-project" data-touch="false">
                  <ul class="flex-box box-align box-pack">
                      <li>
                          <p class="big v4-text-red">{{$items['base_rate']}}<span>%@if($items['after_rate']>0)+{{$items['after_rate']}}%@endif</span></p>
                          <span>期待年回报率</span>
                      </li>
                      <li>
                          <p>{{$items['project_time_note']}} <em class="v4-text-red">{{$items['invest_time_note']}}</em></p>
                          <span>{{$items['refund_type_note']}}</span>
                      </li>
                  </ul>
              </a>
        @endforeach
      @endif
  </div>
  
</section>