<?php $__env->startSection('content'); ?>
    <script src="<?php echo e(assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js')); ?> "></script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">控制台</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="javascript:void(0)">投资记录</a></li>
    </ul>
    <form action="" method="get" name="user">
        <div class="control-group">
            <div class="span4">
                <label>
                    手机号码: <input type="text" name="phone" style="width:100px;"  value="<?php echo e($search_form['phone']); ?>" placeholder="手机号">
                </label>
                <label>
                    投资时间: <input type="text" name="startTime" style="width:100px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo e($search_form['startTime']); ?>" placeholder="开始时间"> － <input type="text" name="endTime" style="width:100px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" id="date02" value="<?php echo e($search_form['endTime']); ?>" placeholder="结束时间">
                </label>
            </div>
            <div class="span1"><button type="submit" class="btn btn-small btn-primary">点击查询</button></div>
        </div>
    </form>
    <div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header">
                <h2><i class="halflings-icon user"></i><span class="break"></span>投资记录</h2>
            </div>
            <div class="box-content">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                    <th>序号</th>
                    <th>用户id</th>
                    <th>手机号</th>
                    <th>姓名</th>
                    <th>项目编号</th>
                    <th>项目名称</th>
                    <th>债转项目编号</th>
                    <th>投资类型</th>
                    <th>合同编号</th>
                    <th>项目来源</th>
                    <th>真实名称</th>
                    <th>状态</th>
                    <th>出借金额</th>
                    <th>利率</th>
                    <th>项目期限</th>
                    <th>回款方式</th>
                    <th>投资时间</th>
                    <th>投资端</th>
                    <th>红包金额</th>
                    <th>加息券</th>
                   <?php /* <th>操作</th>*/ ?>
                    </thead>
                    <?php if(!empty($investData)): ?>
                        <?php foreach($investData as $invest): ?>
                            <tbody>
                            <td><?php echo e($invest['id']); ?></td>
                            <td><?php echo e($invest['user_id']); ?></td>
                            <td><?php if(!empty($invest['userInfo']['phone'])): ?><?php echo e($invest['userInfo']['phone']); ?><?php endif; ?></td>
                            <td><?php if(!empty($invest['userInfo']['real_name'])): ?><?php echo e($invest['userInfo']['real_name']); ?><?php endif; ?></td>
                            <td><?php echo e($invest['project_id']); ?></td>
                            <td><?php echo e(isset($invest['projectInfo']['name']) ? $invest['projectInfo']['name'] : null); ?></td>
                            <td><?php echo e(isset($invest['assign_project_id']) ? $invest['assign_project_id'] : null); ?></td>
                            <td><?php echo e(isset($invest['invest_type']) ? $invest['invest_type'] : null); ?></td>
                            <td><?php if(isset($invest['creditInfo'][0]['contract_no']) && !empty($invest['creditInfo'][0]['contract_no'])): ?><?php echo e($invest['creditInfo'][0]['contract_no']); ?><?php endif; ?></td>
                            <td><?php if(isset($invest['creditInfo']['source']) && !empty($creditSource[$invest['creditInfo']['source']])): ?><?php echo e($creditSource[$invest['creditInfo']['source']]); ?><?php endif; ?></td>
                            <td><?php echo e(isset($invest['creditInfo']['name']) ? $invest['creditInfo']['name'] : null); ?></td>
                            <td><?php echo e(isset($invest['projectInfo']['status_note']) ? $invest['projectInfo']['status_note'] : null); ?></td>
                            <td><?php echo e($invest['cash']); ?></td>
                            <td><?php if(!empty($invest['projectInfo']['profit_percentage'])): ?><?php echo e($invest['projectInfo']['profit_percentage']); ?>%<?php endif; ?></td>
                            <td><?php echo e(isset($invest['projectInfo']['invest_time_note']) ? $invest['projectInfo']['invest_time_note'] : null); ?></td>
                            <td><?php echo e(isset($invest['projectInfo']['refund_type_note']) ? $invest['projectInfo']['refund_type_note'] : null); ?></td>
                            <td><?php echo e($invest['created_at']); ?></td>
                            <td><?php echo e($invest['app_request']); ?></td>
                            <td><?php if($invest['bonus_type'] == \App\Http\Dbs\Bonus\BonusDb::TYPE_CASH): ?><?php echo e($invest['bonus_value']); ?> <?php endif; ?></td>
                            <td><?php if($invest['bonus_type'] != \App\Http\Dbs\Bonus\BonusDb::TYPE_CASH): ?><?php echo e($invest['bonus_value']); ?>% <?php endif; ?></td>
                            </tbody>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
                <?php echo $__env->make('admin.common.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>