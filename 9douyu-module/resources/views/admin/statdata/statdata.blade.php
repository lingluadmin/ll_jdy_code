@extends('layouts.admin-app')
<link href="{{ assetUrlByCdn('css/admin/morris.css') }}"    rel="stylesheet">
@section('content')
    <script src="{{ assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js') }} "></script>
    <div class="pageheader">
        <h2><i class="fa fa-home"></i> Dashboard <span>Subtitle goes here...</span></h2>
        <div class="breadcrumb-wrapper">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li class="active">Dashboard</li>
            </ol>
        </div>
    </div>

    <div class="contentpanel">
        <div class="row">

            <div class="col-sm-6 col-md-3">
                <div class="panel panel-success panel-stat">
                    <div class="panel-heading">

                        <div class="stat">
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="{{ assetUrlByCdn('images/admin/is-user.png') }}" alt="" />
                                </div>
                                <div class="col-xs-8">
                                    <small class="stat-label">用户注册总数</small>
                                    <h3>{{ $userTotalNum }}</h3>
                                </div>
                            </div><!-- row -->

                            <div class="mb15"></div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label">昨日注册</small>
                                    <h4>{{ $userYesterDay }}</h4>
                                </div>

                                <div class="col-xs-6">
                                    <small class="stat-label">今日注册</small>
                                    <h4>{{ $userToday }}</h4>
                                </div>
                            </div><!-- row -->
                        </div><!-- stat -->

                    </div><!-- panel-heading -->
                </div><!-- panel -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6 col-md-3">
                <div class="panel panel-danger panel-stat">
                    <div class="panel-heading">

                        <div class="stat">
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="{{ assetUrlByCdn('images/admin/is-money.png') }}" alt="" />
                                </div>
                                <div class="col-xs-8">
                                    <small class="stat-label">今日充值额</small>
                                    <h3>{{ $todayRecharge }}</h3>
                                </div>
                            </div><!-- row -->

                            <div class="mb15"></div>

                            <small class="stat-label">今日提现额</small>
                            <h4>{{ $todayWithdraw }}</h4>

                        </div><!-- stat -->

                    </div><!-- panel-heading -->
                </div><!-- panel -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6 col-md-3">
                <div class="panel panel-primary panel-stat">
                    <div class="panel-heading">

                        <div class="stat">
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="{{ assetUrlByCdn('images/admin/is-money.png') }}" alt="" />
                                </div>
                                <div class="col-xs-8">
                                    <small class="stat-label">今日定期投资额</small>
                                    <h3>{{ $invertToday }}</h3>
                                </div>
                            </div><!-- row -->

                            <div class="mb15"></div>

                            <small class="stat-label">当前活期账户总额</small>
                            <h4>{{ $currentCash }}</h4>

                        </div><!-- stat -->

                    </div><!-- panel-heading -->
                </div><!-- panel -->
            </div><!-- col-sm-6 -->
            <div class="col-sm-6 col-md-3">
                <div class="panel panel-dark panel-stat">
                    <div class="panel-heading">

                        <div class="stat">
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="{{ assetUrlByCdn('images/admin/is-money.png') }}" alt="" />
                                </div>
                                <div class="col-xs-8">
                                    <small class="stat-label">今日回款额</small>
                                    <h3>{{ $todayRefundCash }}</h3>
                                </div>
                            </div><!-- row -->

                            <div class="mb15"></div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label">明日回款额</small>
                                    <h4>{{ $tomorrowRefundCash }}</h4>
                                </div>

                                <div class="col-xs-6">
                                    <small class="stat-label">未来三天回款额</small>
                                    <h4>{{ $threeDayRefundCash }}</h4>
                                </div>
                            </div><!-- row -->

                        </div><!-- stat -->

                    </div><!-- panel-heading -->
                </div><!-- panel -->
            </div><!-- col-sm-6 -->

        </div><!-- row -->

        <div class="row">
            <div class="col-sm-8 col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <h5 class="subtitle mb5">近15日投资额/回款额走势图</h5>
                                <div id="basicflot" style="width: 100%; height: 300px; margin-bottom: 20px"></div>
                            </div><!-- col-sm-8 -->
                            <div class="col-sm-4">
                                <h5 class="subtitle mb5">平台投资来源占比图</h5>
                                <span class="sublabel">PC端-({{ $investSourceArr['sourcePc'] }})</span>
                                <div class="progress progress-sm">
                                    <div style="width: {{$investSourceArr['sourcePc']}}" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-primary"></div>
                                </div><!-- progress -->

                                <span class="sublabel">IOS ({{ $investSourceArr['sourceIos'] }})</span>
                                <div class="progress progress-sm">
                                    <div style="width: {{$investSourceArr['sourceIos']}}" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                                </div><!-- progress -->

                                <span class="sublabel">Android ({{ $investSourceArr['sourceAndroid'] }})</span>
                                <div class="progress progress-sm">
                                    <div style="width: {{$investSourceArr['sourceAndroid']}}" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger"></div>
                                </div><!-- progress -->

                                <span class="sublabel">WAP ({{ $investSourceArr['sourceWap'] }})</span>
                                <div class="progress progress-sm">
                                    <div style="width: {{$investSourceArr['sourceWap']}}" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning"></div>
                                </div><!-- progress -->
                                {{--
                                <span class="sublabel">Domains (2/10)</span>
                                <div class="progress progress-sm">
                                    <div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                                </div><!-- progress -->

                                <span class="sublabel">Email Account (13/50)</span>
                                <div class="progress progress-sm">
                                    <div style="width: 26%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                                </div><!-- progress -->
                                --}}

                            </div><!-- col-sm-4 -->
                        </div><!-- row -->
                    </div><!-- panel-body -->
                </div><!-- panel -->
            </div><!-- col-sm-9 -->

            <div class="col-sm-4 col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <h5 class="subtitle mb5">注册用户来源占比</h5>
                        <div id="donut-chart2" class="ex-donut-chart"></div>
                    </div><!-- panel-body -->
                </div><!-- panel -->

            </div><!-- col-sm-3 -->

        </div><!-- row -->

        <div class="row">
            <div class="col-sm-8 col-md-12">
                <div class="span9">
                    {{-- <label>--}}
                    查询日期: <input type="text" name="startTime" style="width:100px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" id="date01" value="{{ $startTime or date('Y-m-d', strtotime('-14 day')) }}" placeholder="开始时间"> － <input type="text" name="endTime" style="width:100px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" id="date02" value="{{ $endTime or date('Y-m-d') }}" placeholder="结束时间">
                    <button  id="orderStatDate" class="btn btn-small btn-primary" onclick="orderStatDate();">点击查询</button>
                    {{--</label>--}}
                </div>


                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 class="subtitle mb5">近十五天充值/提现走势图</h5>
                                <div id="area-chart" class="body-chart"></div>
                            </div><!-- col-sm-8 -->

                        </div><!-- row -->
                    </div><!-- panel-body -->
                </div><!-- panel -->
            </div><!-- col-sm-9 -->

        </div><!-- row -->



        <div style="display: none">
            <input id="maxVal"          value="{{ $maxVal }}">
            <input id="fiftenDateStr"   value="{{ $fiftenDateStr }}">
            <input id="fiftenDayInvest" value="{{ $fiftenDayInvest }}">
            <input id="fiftenDayRefund" value="{{ $fiftenDayRefund }}">
            <input id="fiftenDayOrder"  value="{{ $fiftenDayOrder }}">
            <input id="fiftenDayOrderDate"  value="">
            <input id="chart2_pc"      value="{{ $userSourceArr['sourcePc'] }}">
            <input id="chart2_ios"     value="{{ $userSourceArr['sourceIos']  }}">
            <input id="chart2_android" value="{{ $userSourceArr['sourceAndroid'] }}">
            <input id="chart2_wap"     value="{{ $userSourceArr['sourceWap'] }}">
        </div>
    </div><!-- contentpanel -->

    <script>

        function orderStatDate() {
            var stime   = $("#date01").val()
            var etime   = $("#date02").val()

            if( stime == "" || etime =="" ){

                alert("请选择开始日期，结束日期")
                return false;
            }else {
                var startNum= parseInt(stime.replace(/-/g, ''), 10);
                var endNum  = parseInt(etime.replace(/-/g, ''), 10);
                if (startNum > endNum) {
                    alert("结束日期不能在开始日期之前！")
                    return false;
                }else{
                    var diffDay = DateDiff(stime, etime)
                    if(diffDay > 60){
                        alert("最大时间间隔2个月")
                        return false;
                    }
                }
            }
            window.location.href='/admin/statData?startTime='+stime+'&endTime='+etime
        }

        function DateDiff(sDate1, sDate2) {         //sDate1和sDate2是yyyy-MM-dd格式

            var aDate, oDate1, oDate2, iDays;
            aDate = sDate1.split("-");
            oDate1 = new Date(aDate[1] + '-' + aDate[2] + '-' + aDate[0]);      //转换为yyyy-MM-dd格式
            aDate = sDate2.split("-");
            oDate2 = new Date(aDate[1] + '-' + aDate[2] + '-' + aDate[0]);
            iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24);  //把相差的毫秒数转换为天数

            return iDays;  //返回相差天数
        }

    </script>

@endsection

