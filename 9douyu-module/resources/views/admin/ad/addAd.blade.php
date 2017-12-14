@extends('admin/layouts/default')

@section('content')
    <script src="{{ assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js') }} "></script>

    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/admin">首页</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <i class="icon-eye-open"></i>
            <a href="#">添加广告</a>
        </li>
    </ul>

    @if(Session::has('fail'))
        <div class="alert alert-error alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>  <i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('fail') }}
        </div>
    @endif

    <div class="row-fluid sortable ui-sortable">
        <div class="box">
            <div class="box-header">
                <h2><i class="halflings-icon align-justify"></i><span class="break"></span>添加广告</h2>
            </div>


            <div class="box-content">
                <form class="form-horizontal" method="post" action="/admin/ad/doAddAd" enctype="multipart/form-data">
                    <input type="hidden" name="position_id" value="{{ $positionInfo['id'] }}">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="disabledInput">广告位</label>
                            <div class="controls">
                                <input class="input-xlarge disabled" id="disabledInput" type="text" placeholder="{{ $positionInfo['name'] }}" disabled="">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">广告描述</label>
                            <div class="controls">
                                <input type="text" class="span4 typeahead" name="title" >
                                <span class="help-inline">请尽量写清楚介绍</span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">显示类型</label>
                            <div class="controls">
                                <select name="show_type">
                                    <option value="{{ \App\Http\Dbs\Ad\AdDb::SHOW_TYPE_PIC }}">图片</option>
                                    <option value="{{ \App\Http\Dbs\Ad\AdDb::SHOW_TYPE_WORD }}">文字</option>
                                </select>                                ( 方便列表查看 )

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="fileInput">图片</label>
                            <div class="controls">
                                <div class="uploader" id="uniform-fileInput">
                                    <input class="input-file uniform_on" id="fileInput" type="file" name="display_img">
                                    <span class="filename" style="-webkit-user-select: none;">No file selected</span>
                                    <span class="action" style="-webkit-user-select: none;">Choose File</span>
                                </div> ( 选择上传图片,必填项 )
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">文字</label>
                            <div class="controls">
                                <input type="text" class="span4 typeahead" name="word" > @todo 需要完善成js切换显示的
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">点击跳转</label>
                            <div class="controls">
                                <select name="jump_to_type"  data-rel="chosen" id="jump_to_type">
                                    @foreach($jump_to_type as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <input type="text" class="input-xlarge span4" name="url" value="" placeholder='请填写点击跳转链接'>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">发布时间</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge span4" name="publish_at" id="publish_at" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'})" value="{{ Input::old('publish_at') }}"> (留空示为发布后【立即显示】)

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputError">下线时间</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge span4" name="end_at" id="end_at" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'})" value="{{ Input::old('end_at') }}"> (必填项)

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">分组</label>
                            <div class="controls">
                                <input type="text" class="span4 typeahead" name="group_sort" value=""> ( 用于app资产按钮分组,非必填 )
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">排序</label>
                            <div class="controls">
                                <input type="text" class="span4 typeahead" name="sort" value="1"> ( 1-99,数字越小,显示在前面 )
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">分享标题</label>
                            <div class="controls">
                                <input type="text" class="span4 typeahead" name="share_title" >

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">分享描述</label>
                            <div class="controls">
                                <input type="text" class="span4 typeahead" name="share_desc" >

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="typeahead">分享链接</label>
                            <div class="controls">
                                <input type="text" class="span4 typeahead" name="share_url" >

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="fileInput">分享图片</label>
                            <div class="controls">
                                <div class="uploader" id="uniform-fileInput">
                                    <input class="input-file uniform_on" id="fileInput" type="file" name="share_image">
                                    <span class="filename" style="-webkit-user-select: none;">No file selected</span>
                                    <span class="action" style="-webkit-user-select: none;">Choose File</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="reset" class="btn">Cancel</button>
                        </div>
                    </fieldset>
                </form>

            </div>



        </div><!--/span-->
    </div>


<script>
    $(function(){
        $('#jump_to_type').on('change',function(){
            var type = $(this).val();
            var url = {{ \App\Http\Dbs\Ad\AdDb::JUMP_TO_URL}};
            if(type != url){
                $("input[name=url]").css('display','none')
            }else{
                $("input[name=url]").css('display','')
            }
        })
    })
</script>


@stop
