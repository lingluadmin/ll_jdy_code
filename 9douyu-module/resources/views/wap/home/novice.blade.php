<section class="v4-project-wrap">
  @if(!empty($novice_project))
  @foreach($novice_project as $item)
  <div class="v4-section-head flex-box box-align box-pack">
    <img src="{{ assetUrlByCdn('static/weixin/images/wap4/index/icon-title2.png')}}" alt="新手专享" class="title" />
    <a href="/project/detail/{{$item["id"]}}" class="v4-btn-arrow">{{$item['invest_tip']}}</a>
  </div>
  <div class="v4-table-project">
    <a href="/project/detail/{{$item["id"]}}" class="v4-project" data-touch="false">
      <ul class="flex-box box-align box-pack">
        <li>
          <p class="big v4-text-red">{{$item['base_rate']}}<span>%@if($item['after_rate']>0)+{{$item['after_rate']}}%@endif</span></p>
            <span>期待年回报率</span>
        </li>
        <li>
           <p>{{$item['project_time_note']}} <em class="v4-text-red">{{$item['invest_time_note']}}</em></p>
           <span>{{$item['refund_type_note']}}</span>
        </li>
      </ul>
    </a>
  </div>
  @endforeach
  @endif
</section>