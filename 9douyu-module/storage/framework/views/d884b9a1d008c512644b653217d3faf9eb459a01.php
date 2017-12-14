<link href="<?php echo e(assetUrlByCdn('css/admin/morris.css')); ?>"    rel="stylesheet">
<?php $__env->startSection('content'); ?>
    <script src="<?php echo e(assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js')); ?> "></script>
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
                                    <img src="<?php echo e(assetUrlByCdn('images/admin/is-user.png')); ?>" alt="" />
                                </div>
                                <div class="col-xs-8">
                                    <small class="stat-label">用户注册总数</small>
                                    <h3><?php echo e($userTotalNum); ?></h3>
                                </div>
                            </div><!-- row -->

                            <div class="mb15"></div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label">昨日注册</small>
                                    <h4><?php echo e($userYesterDay); ?></h4>
                                </div>

                                <div class="col-xs-6">
                                    <small class="stat-label">今日注册</small>
                                    <h4><?php echo e($userToday); ?></h4>
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
                                    <img src="<?php echo e(assetUrlByCdn('images/admin/is-money.png')); ?>" alt="" />
                                </div>
                                <div class="col-xs-8">
                                    <small class="stat-label">今日充值额</small>
                                    <h3><?php echo e($todayRecharge); ?></h3>
                                </div>
                            </div><!-- row -->

                            <div class="mb15"></div>

                            <small class="stat-label">今日提现额</small>
                            <h4><?php echo e($todayWithdraw); ?></h4>

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
                                    <img src="<?php echo e(assetUrlByCdn('images/admin/is-money.png')); ?>" alt="" />
                                </div>
                                <div class="col-xs-8">
                                    <small class="stat-label">今日定期投资额</small>
                                    <h3><?php echo e($invertToday); ?></h3>
                                </div>
                            </div><!-- row -->

                            <div class="mb15"></div>

                            <small class="stat-label">当前活期账户总额</small>
                            <h4><?php echo e($currentCash); ?></h4>

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
                                    <img src="<?php echo e(assetUrlByCdn('images/admin/is-money.png')); ?>" alt="" />
                                </div>
                                <div class="col-xs-8">
                                    <small class="stat-label">今日回款额</small>
                                    <h3><?php echo e($todayRefundCash); ?></h3>
                                </div>
                            </div><!-- row -->

                            <div class="mb15"></div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label">明日回款额</small>
                                    <h4><?php echo e($tomorrowRefundCash); ?></h4>
                                </div>

                                <div class="col-xs-6">
                                    <small class="stat-label">未来三天回款额</small>
                                    <h4><?php echo e($threeDayRefundCash); ?></h4>
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
                                <span class="sublabel">PC端-(<?php echo e($investSourceArr['sourcePc']); ?>)</span>
                                <div class="progress progress-sm">
                                    <div style="width: <?php echo e($investSourceArr['sourcePc']); ?>" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-primary"></div>
                                </div><!-- progress -->

                                <span class="sublabel">IOS (<?php echo e($investSourceArr['sourceIos']); ?>)</span>
                                <div class="progress progress-sm">
                                    <div style="width: <?php echo e($investSourceArr['sourceIos']); ?>" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                                </div><!-- progress -->

                                <span class="sublabel">Android (<?php echo e($investSourceArr['sourceAndroid']); ?>)</span>
                                <div class="progress progress-sm">
                                    <div style="width: <?php echo e($investSourceArr['sourceAndroid']); ?>" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger"></div>
                                </div><!-- progress -->

                                <span class="sublabel">WAP (<?php echo e($investSourceArr['sourceWap']); ?>)</span>
                                <div class="progress progress-sm">
                                    <div style="width: <?php echo e($investSourceArr['sourceWap']); ?>" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning"></div>
                                </div><!-- progress -->
                                <?php /*
                                <span class="sublabel">Domains (2/10)</span>
                                <div class="progress progress-sm">
                                    <div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                                </div><!-- progress -->

                                <span class="sublabel">Email Account (13/50)</span>
                                <div class="progress progress-sm">
                                    <div style="width: 26%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
                                </div><!-- progress -->
                                */ ?>

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
                    <?php /* <label>*/ ?>
                    查询日期: <input type="text" name="startTime" style="width:100px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" id="date01" value="<?php echo e(isset($startTime) ? $startTime : date('Y-m-d', strtotime('-14 day'))); ?>" placeholder="开始时间"> － <input type="text" name="endTime" style="width:100px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" id="date02" value="<?php echo e(isset($endTime) ? $endTime : date('Y-m-d')); ?>" placeholder="结束时间">
                    <button  id="orderStatDate" class="btn btn-small btn-primary" onclick="orderStatDate();">点击查询</button>
                    <?php /*</label>*/ ?>
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
            <input id="maxVal"          value="<?php echo e($maxVal); ?>">
            <input id="fiftenDateStr"   value="<?php echo e($fiftenDateStr); ?>">
            <input id="fiftenDayInvest" value="<?php echo e($fiftenDayInvest); ?>">
            <input id="fiftenDayRefund" value="<?php echo e($fiftenDayRefund); ?>">
            <input id="fiftenDayOrder"  value="<?php echo e($fiftenDayOrder); ?>">
            <input id="fiftenDayOrderDate"  value="">
            <input id="chart2_pc"      value="<?php echo e($userSourceArr['sourcePc']); ?>">
            <input id="chart2_ios"     value="<?php echo e($userSourceArr['sourceIos']); ?>">
            <input id="chart2_android" value="<?php echo e($userSourceArr['sourceAndroid']); ?>">
            <input id="chart2_wap"     value="<?php echo e($userSourceArr['sourceWap']); ?>">
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

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin-app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>