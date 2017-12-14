@extends('admin/layouts/default')
@section('content')
    <script src="{{ assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js') }} "></script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">控制台</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="javascript:void(0)">自动对账提现订单</a></li>
    </ul>
    <!-- start: Content -->
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon edit"></i><span class="break"></span>上传对账订单</h2>
            </div>

            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>  <i class="icon fa fa-check"></i> 提示: {{ Session::get('message') }}</h4>

                </div>
            @endif

            <div class="box-content">

                <div class="control-group error">
                    <span class="help-inline">{{ Session::get('success') }}</span>
                </div>

                <form class="form-horizontal" enctype="multipart/form-data" action="{{ URL('admin/withdraw/uploadBill') }}" method="post">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="fileInput">选择文件</label>
                            <div class="controls">
                                <input class="input-file uniform_on" id="fileInput" type="file" name="billFile" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">支付类型</label>
                            <div class="controls">
                                {{--
                                <label class="radio">
                                    <span class=""><input name="payChannel" value="jd" type="radio" >网银付款</span>
                                </label>
                                --}}
                                {{--
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class=""><input name="payChannel" value="suma" type="radio">丰付付款</span>
                                </label>
                                <div style="clear:both"></div>
                                --}}

                                <label class="radio">
                                    <span class=""><input name="payChannel" value="ucf" type="radio" checked>先锋付款</span>
                                </label>

                            </div>
                        </div>

                        <div class="form-actions">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div><!--/span-->
    </div><!--/row-->


    <div class="row-fluid sortable ui-sortable">
        <div class="box">
            <div class="box-header">
                <h2><i class="halflings-icon align-justify"></i><span class="break"></span>提现对账记录</h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
                </div>
            </div>


            <div class="box-content">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>文件名称</th>
                        <th>类别</th>
                        <th>备注</th>
                        <th>创建时间</th>
                        <th>完成时间</th>
                        <th>附件内容</th>
                        <th>添加人</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( !empty($list) )
                        @foreach( $list as $info )
                            <tr>
                                <td>{{ $info['id']      }}</td>
                                <td>{{ $info['name']    }}</td>
                                <td class="center">
                                    <button class="btn btn-mini btn-primary">{{ "先锋提现对账" }}</button>
                                </td>
                                <td>{{ $info['note']        }}</td>
                                <td>{{ $info['created_at']  }}</td>
                                <td>{{ $info['updated_at']  }}</td>
                                <td>
                                    <a href="{{ $info['file_path'] }}" title="点击查看" target="_blank" >{{ $info['file_path'] }}</a>
                                </td>
                                <td>{{ $info['admin_id']    }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">暂无信息</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="pagination pagination-centered" id="pagination-ajax">
                @include('scripts/paginate', ['paginate'=>$paginate])
            </div>
        </div><!--/span-->
    </div>

    {{--
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon edit"></i><span class="break"></span>当日上传文件列表,方便操作人员核对,防止漏传!!!</h2>
            </div>
<p></p>
            @if( !empty($uploadData) )
                @foreach( $uploadData as $fileName)
                    <div class="alert alert-success alert-dismissable">
                        <h4>  <i class="icon fa fa-check"></i> 文件名: 【{{ $fileName }}】</h4>
                    </div>
                @endforeach
            @endif
        </div><!--/span-->
    </div>

    --}}
@stop