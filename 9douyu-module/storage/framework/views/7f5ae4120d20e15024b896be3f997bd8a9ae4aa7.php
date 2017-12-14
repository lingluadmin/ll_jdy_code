<?php $__env->startSection('content'); ?>
    <script src="<?php echo e(assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js')); ?> "></script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">控制台</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="javascript:void(0);">合伙人活动</a></li>
    </ul>
    <div class="alert alert-danger" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <ul>
            <li></li>
        </ul>
    </div>
    <div>

        <?php if(Session::has('message')): ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4>  <i class="icon icon fa fa-warning"></i> 提示! </h4>
                <?php echo e(Session::get('message')); ?>

            </div>
        <?php endif; ?>

    </div>
    <!-- start: Content -->
    <div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header" data-original-title="">
                <h2><i class="halflings-icon edit"></i><span class="break"></span>活动奖励导出(目前支持财务部需求数据导出)</h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
                </div>
            </div>
            <div class="box-content" style="display:none;">
                <form class="form-horizontal" method="get" action="/admin/partner/rewardExport">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="typeahead">查询时间</label>
                            <div class="controls">
                                <input type="text" class="span2" name="start_time" id="start_time" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" placeholder="开始时间" />
                                ——
                                <input type="text" class="span2" name="end_time" id="end_time" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" placeholder="结束时间" /> &nbsp;&nbsp;&nbsp;
                                <button type="submit" class="btn btn-small btn-primary">导出数据</button>
                            </div>
                        </div>

                    </fieldset>
                </form>

            </div>
        </div><!--/span-->

    </div>
    <h3 style="color:red;">说明:列表数据截止到今日零点,实时数据请查看详情</h3>

    <div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header">
                <h2><i class="halflings-icon credit-card"></i><span class="break"></span>合伙人管理</h2>
            </div>
            <div class="box-content">
                <form action="" method="get">
                <div class="control-group">
                    <div class="span3">手机号&nbsp;&nbsp;<input name="phone" style="width: 140px;" type="text" value="<?php if(!empty($search['phone'])): ?><?php echo e($search['phone']); ?><?php endif; ?>" placeholder="手机号"></div>
                    <div class="span5">加入合伙人时间&nbsp;&nbsp;<input type="text" name="startTime" style="width: 120px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php if(!empty($search['startTime'])): ?><?php echo e($search['startTime']); ?><?php endif; ?>" placeholder="开始时间"> － <input type="text" name="endTime" style="width: 120px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" id="date02" value="<?php if(!empty($search['endTime'])): ?><?php echo e($search['endTime']); ?><?php endif; ?>" placeholder="结束时间"></div>
                    <div class="span3"><button type="submit" class="btn btn-small btn-primary">点击查询</button></div>
                </div>
                </form>
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>账户余额</th>
                    <th>邀请合伙人数</th>
                    <th>邀请合伙人待收本金</th>
                    <th>昨日佣金率</th>
                    <th>昨日收益</th>
                    <th>累计佣金收益</th>
                    <th>参与时间</th>
                    <th>计息时间</th>
                    <th>注册时间</th>
                    <th>操作</th>
                    </thead>
                    <?php if(!empty($partnerInfo)): ?>
                        <?php foreach($partnerInfo as $partner): ?>
                          <tbody>
                          <td><?php echo e($partner['real_name']); ?></td>
                          <td><?php echo e($partner['phone']); ?></td>
                          <td><?php echo e($partner['balance']); ?></td>
                          <td><?php echo e($partner['invite_num']); ?></td>
                          <td><?php echo e($partner['yesterday_cash']); ?></td>
                          <td><?php echo e($partner['rate']); ?>%</td>
                          <td><?php echo e($partner['yesterday_interest']); ?></td>
                          <td><?php echo e($partner['interest']); ?></td>
                          <td><?php echo e($partner['created_at']); ?></td>
                          <td><?php echo e($partner['interest_time']); ?></td>
                          <td><?php echo e($partner['register_time']); ?></td>
                          <td><a href="/admin/partner/detail?userId=<?php echo e($partner['user_id']); ?>&interest=<?php echo e($partner['interest']); ?>">详情</a></td>
                          </tbody>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
                <?php if(!empty($pageInfo)): ?>
                    <?php echo $__env->make('admin/common/page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>