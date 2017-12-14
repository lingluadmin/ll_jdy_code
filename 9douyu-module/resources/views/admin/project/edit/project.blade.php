@extends('admin/layouts/default')

@section('content')
    <script src="{{ assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js') }} "></script>

    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/admin/project/lists">{{$home}}</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">{{$title}}</a></li>
    </ul>
    <!-- start: Content -->
    <form role="form" action="/admin/project/doUpdate" method="post">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div>
            @if(Session::has('message'))
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>  <i class="icon icon fa fa-warning"></i> 提示! </h4>
                    {{ Session::get('message') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="row-fluid sortable">
            <div class="box span12">
                <div class="box-header" data-original-title>
                    <h2><i class="halflings-icon edit"></i><span class="break"></span>项目要素</h2>
                    <div class="box-icon">
                        {{--<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>--}}
                        <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                        {{--<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>--}}
                    </div>
                </div>

                <div class="box-content form-horizontal">
                    <fieldset>
                        <input type="hidden" name="id" value="{{ $projectInfo['id'] }}">
                        <input type="hidden" name="assets_platform_sign" value="{{ $projectInfo['assets_platform_sign'] }}">
                        {{--产品线--}}
                        <div class="control-group">
                            <label class="control-label" for="selectProductLine"> 产品线 </label>
                            <input type="hidden" name="product_line" value="{{$productId}}">
                            <div class="controls">
                                <select id="productLine" name="product_line" data-rel="chosen" disabled>
                                    @foreach($productLine as $key => $title){
                                        @if ($productId == $key)
                                        <option value="{{ $key }}" selected>{{ $title }}</option>";
                                        @endif
                                        <option value="{{ $key }}">{{ $title }}</option>";
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="name"> 项目名称 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge focused" id="name" type="text" name="name" value="{{ Input::old('name',$projectInfo['name']) }}">
                                </div>
                            </div>
                        </div>
                        {{--融资时间--}}
                        <div class="control-group">
                            <label class="control-label" for="date02"> 融资时间 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge focused" id="date02" type="text" name="invest_days" value="{{ Input::old('invest_days', $projectInfo['invest_days']) }}" placeholder="期限不能大于20天"><span class="add-on"> 天 </span>
                                </div>
                            </div>
                        </div>
                        {{--预计年利率--}}
                        <div class="control-group">
                            <label class="control-label" for="selectError"> 预计年利率 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge " id="focusedInput" type="text" name="base_rate" value="{{ Input::old('base_rate', $projectInfo['base_rate']) }}"><span class="add-on"> + </span>
                                    <input class="input-xlarge " id="a" type="text" name="after_rate" value="{{ Input::old('after_rate', $projectInfo['after_rate']) }}"><span class="add-on"> % </span>
                                </div>
                            </div>
                        </div>
                        {{--还款方式--}}
                        <div class="control-group">
                            <label class="control-label" for="selectProductLine"> 还款方式 </label>
                            <div class="controls">
                                <select id="refund_type" name="refund_type" data-rel="chosen">
                                    @foreach($refundType as $key => $title){
                                        @if($projectInfo['refund_type'] == $key)
                                        <option value="{{ $key }}" selected>{{ $title }}</option>";
                                            @else
                                        <option value="{{ $key }}">{{ $title }}</option>";
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--借款类型--}}
                        <div class="control-group">
                            <label class="control-label" for="selectProductLine"> 借款类型 </label>
                            <div class="controls">
                                <select id="category" name="category" data-rel="chosen">
                                    @foreach($categoryList as $key => $category)
                                        @if( $projectInfo['category'] == $key)
                                        <option value="{{ $key }}" selected>{{ $category }}</option>
                                        @else
                                        <option value="{{ $key }}" >{{ $category }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--发布时间--}}
                        <div class="control-group">
                            <label class="control-label" for="publish_time">发布时间</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" name="publish_time" id="publish_time" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'})" value="{{ Input::old('publish_time', $projectInfo['publish_at']) }}">
                            </div>
                        </div>
                        {{--项目期限--}}
                        <div class="control-group">
                            <label class="control-label" for="date02"> 项目期限 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge focused" id="date02" type="text" name="invest_time" value="{{ Input::old('invest_time', $projectInfo['invest_time']) }}"><span class="add-on"> {{$investNote}} </span>
                                </div>
                            </div>
                        </div>
                        {{--到期日期--}}
                        <div class="control-group">
                            <label class="control-label" for="date01">到期日期</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge datepicker" id="end_at" name="end_at" value="{{ Input::old('end_at', $projectInfo['end_at']) }}">
                            </div>
                        </div>
                        {{--项目金额--}}
                        <div class="control-group">
                            <label class="control-label" for="date02"> 项目金额 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge focused" id="date02" type="text" name="total_amount" value="{{ Input::old('total_amount', $projectInfo['total_amount']) }}"><span class="add-on"> 元 </span>
                                </div>
                            </div>
                        </div>
                        {{--普付宝专享--}}
                        {{--<div class="control-group">
                            <label class="control-label" for="date02"> 是否可质押 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge focused" id="date02" type="checkbox" name="pledge" value="1" @if( $projectInfo['pledge'] )checked="true"@endif />
                                    <span class="add-on"> (普付宝) </span>
                                </div>
                            </div>
                        </div>--}}
                        {{--活动标志--}}
                        <div class="control-group">
                            <label class="control-label" for="date02"> 活动标识 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <select id="category" name="newcomer" data-rel="chosen">
                                        <option value="">请选择活动标识</option>
                                        @foreach($activityList as $key => $activity)
                                            <option value="{{ $key }}" @if( isset($activityNote['type']) && $activityNote['type'] == $key ) selected @endif>{{ $activity }}</option>
                                        @endforeach
                                    </select>
                                    <span class="add-on"> 项目活动标识 </span>
                                </div>
                            </div>
                        </div>
                        {{--普付宝专享--}}
                        <div class="control-group">
                            <label class="control-label" for="date02"> 项目标识 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <label>
                                        <input class="input-xlarge focused" type="radio" name="pledge" @if(Input::old('pledge') == 1 || $projectInfo['pledge'] == 1) checked @endif value="1">
                                        <span class="add-on"> 新手专享 </span>
                                    </label>
                                    <label>
                                        <input class="input-xlarge focused" type="radio" name="pledge" @if(Input::old('pledge') == 2 || $projectInfo['pledge'] == 2) checked @endif value="2">
                                        <span class="add-on"> 灵活转让 </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{--是否可转让--}}
                        <div class="control-group">
                            <label class="control-label" for="selectIsCreditAssign"> 借款类型 </label>
                            <div class="controls">
                                <select id="" name="is_credit_assign" data-rel="chosen" @if($projectInfo['product_line'] == 400) disabled @endif>
                                    @if($projectInfo['is_credit_assign'] === 1)
                                        <option value="1" selected>可转让</option>
                                        <option value="0" >不可转让</option>
                                    @else
                                        <option value="1" >可转让</option>
                                        <option value="0" selected>不可转让</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        {{--转让持有时间--}}
                        <div class="control-group">
                            <label class="control-label" for="date02"> 可转让持有天数 </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge focused" id="date02" type="text" name="assign_keep_days" value="{{ Input::old('assign_keep_days', $projectInfo['assign_keep_days']) }}" @if($projectInfo['product_line'] == 400) disabled @endif><span class="add-on"> 天 </span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

            </div><!--/span-->
        </div><!--/row-->

        <div class="row-fluid sortable" @if($projectInfo['product_line'] == 400) style="display: none;" @endif >
            <div class="box span12">
                <div class="box-header" data-original-title>
                    <h2><i class="halflings-icon edit"></i><span class="break"></span>债权列表</h2>
                    <div class="box-icon">
                        {{--<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>--}}
                        <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                        {{--<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>--}}
                    </div>
                </div>
                <div class="box-content">
                    <table class="table table-striped table-bordered bootstrap-datatable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>序号</th>
                            <th>来源</th>
                            <th>样式</th>
                            <th>企业名称/计划名称</th>
                            <th>债权金额</th>
                            <th>年利率</th>
                            <th>期限</th>
                            <th>到期日期</th>
                            <th>剩余时间</th>
                            <th>还款方式</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(is_array($creditList) && !empty($creditList))
                                @foreach($creditList as $key => $info)
                                    <?php $checkBoxType = ''; ?>
                                    @foreach($projectInfo['credit_id'] as $creditId)
                                        @if($info['id'] == $creditId)
                                            <?php
                                                $checkBoxType            = 'checked';
                                            ?>
                                        @endif
                                    @endforeach
                                    <tr>
                                    <td><input type="checkbox" name="credit_id[{{$info['id']}}]" value="{{$info['id']}}" {{ $checkBoxType }}></td>
                                    <td>{{ $info['id'] }}</td>
                                    <td>{{ $source[$info['source']] }}</td>
                                    <td>{{ $type[$info['type']] }}</td>
                                    <td>{{ $info['company_name'] }}</td>
                                    <td>{{ $info['loan_amounts'] }}</td>
                                    <td>{{ $info['interest_rate'] }}%</td>
                                    <td>{{ $info['loan_deadline'] }}
                                        @if($info['repayment_method'] == 10)
                                            天
                                        @else
                                            月
                                        @endif
                                    </td>
                                    <td>{{ $info['expiration_date'] }}</td>
                                    <td>{{ $info['remaining_day'] }} 天</td>
                                    <td>{{ $refundType[$info['repayment_method']] }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
            </div><!--/span-->
        </div><!--/row-->

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">保存</button>
            <button type="reset" class="btn">重置</button>
        </div>

    </form>
    <script>
        $(function(){
            $('#date02').on('blur',function(){
                var investDays = $(this).val();
                if(investDays > 20){
                    alert('融资时间不能大于20天');
                }
            })
        })
    </script>
@stop

