
  <div class="v4-section-head flex-box box-align box-pack">
    <h6 class="title">九斗鱼头条</h6>
    <a href="/Article/getAppV4ArticleList" class="v4-btn-arrow">查看全部</a>
  </div>
  <div class="v4-home-news">
    @if(!empty($article))
      @foreach($article as $val)
        <a href="/Article/index/{{$val['id']}}" data-touch="false">
          <ul class="flex-box box-align box-pack">
            <li>
              <h5 class="title">{{$val['title']}}</h5>
              <p class="date">{{$val['publish_time']}}</p>
            </li>
            <li>
              @if(!empty($val['path']))
                <img src="{{ assetUrlByCdn('resources/'.$val['path']) }}" alt="">
              @else
                <img src="{{ assetUrlByCdn('static/weixin/images/wap4/index/news-img.png')}}" alt="">
              @endif
            </li>
          </ul>
        </a>
      @endforeach
    @endif
  </div>
