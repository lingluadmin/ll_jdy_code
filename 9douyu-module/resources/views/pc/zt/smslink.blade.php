@extends('pc.common.layout')
@section('title',   '短信长链接')
@section('csspage')

@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="v4-wrap v4-custody-wrap">
        <h2 class="v4-account-titlex">短信长链接</h2>
        <div class="v4-custody-main">
            <form action="/smslink"     method="get">
                <dl class="v4-input-group">
                    <dt>
                        <label for="open_type"><span>*</span>跳转类型</label>
                    </dt>
                    <dd>
                        <select name="open_type" >
                            <option value="1" @if( $open_type == 1 ) selected @endif>首页</option>
                            <option value="2" @if( $open_type == 2 ) selected @endif>项目详情</option>
                            <option value="3" @if( $open_type == 3 ) selected @endif>红包</option>
                            <option value="4" @if( $open_type == 4 ) selected @endif>H5活动</option>
                            <option value="5" @if( $open_type == 5 ) selected @endif>理财列表</option>
                        </select>
                    </dd>

                    <dt>
                        <label for="project_id">项目ID</label>
                    </dt>
                    <dd>
                        <input name="project_id" class="v4-input v4-input-short"    value="{{ $project_id }}" >
                    </dd>
                    <dt>
                        <label for="project_invest_type">项目类型</label>
                    </dt>
                    <dd>
                        <input name="project_invest_type"  class="v4-input v4-input-short" value="{{ $project_invest_type }}" >
                    </dd>
                    <dt>
                        <label for="url">活动地址</label>
                    </dt>
                    <dd>
                        <input name="url" class="v4-input v4-input-short"   value="{{ $url }}">
                    </dd>
                    <dt>
                        <label for="smsurl">长连接地址</label>
                    </dt>
                    <dd>
                        <input name="smsurl" value="{{ $smsurl }}" class="v4-input v4-input-long" id="smsurl"> <button id="copyBT">复制</button>
                    </dd>

                    <dt>
                        <label for="smsurl">新浪短连接</label>
                    </dt>
                    <dd>
                        <a href="http://dwz.wailian.work/index.php" target="_blank">http://dwz.wailian.work/index.php</a>
                    </dd>

                    <dt>
                    </dt>
                    <dd>
                        <input  type="hidden" name="type"   value="2">
                        <input type="submit" class="v4-input-btn" value="生成" id="v4-input-btn">
                    </dd>
                </dl>
            </form>
        </div>
    </div>
    <script>
        function copyArticle(event) {
            const range     = document.createRange();
            range.selectNode(document.getElementById('smsurl'));

            const selection = window.getSelection();
            if(selection.rangeCount > 0) selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand('copy');
            alert("复制成功！");
        }

        document.getElementById('copyBT').addEventListener('click', copyArticle, false);
    </script>
@endsection

