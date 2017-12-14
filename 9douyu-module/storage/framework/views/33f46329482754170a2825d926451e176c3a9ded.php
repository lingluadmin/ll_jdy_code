<?php $__env->startSection('content'); ?>
    <script src="<?php echo e(assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js')); ?> "></script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/admin">资金管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">交易记录</a></li>
    </ul>


    <?php if(Session::has('message')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>  <i class="icon fa fa-check"></i> 提示！</h4>
            <?php echo e(Session::get('message')); ?>

        </div>
    <?php endif; ?>

    <form action="" method="get" name="user">
        <div class="control-group">
            <div class="span6">
                <label>
                    用户:   <input style="width:120px;" name="phone" value="<?php echo e(@isset($params['phone']) ?$params['phone'] :""); ?>" placeholder="输入手机号" type="text">&nbsp;&nbsp;
                    类型:   <select id="selectSource" name="type" style="width:120px;">
                            <option value="">请选择类型</option>
                            <?php foreach($transactionType as $key=> $name): ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(@isset($params['type'])&&$params['type'] ==$key ? "selected" : ''); ?> ><?php echo e($name); ?></option>
                            <?php endforeach; ?>
                            </select>
                    时间: <input name="start_time" style="width:120px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo e(@isset($params['start_time']) ?$params['start_time'] :""); ?>" placeholder="开始时间" type="text"> － <input name="end_time" style="width:120px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" id="date02" value="<?php echo e(@isset($params['end_time']) ?$params['end_time'] :""); ?>" placeholder="结束时间" type="text">
                </label>
            </div>
            <div class="span3">
                <button type="submit" class="btn btn-small btn-primary">点击查询</button> &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="export" value="1">勾选导出
            </div>
        </div>
    </form>
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon user"></i><span class="break"></span>交易记录</h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
                </div>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户ID</th>
                        <th>手机号</th>
                        <th>姓名</th>
                        <th>时间</th>
                        <th>类型</th>
                        <th>变前的账户金额</th>
                        <th>变更金额</th>
                        <th>变更后账户金额</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($list)): ?>
                            <tr><td class="center" colspan="9">暂无信息</td>
                        <?php else: ?>
                            <?php foreach($list as $key => $item): ?>
                                <tr>
                                    <td class="center"><?php echo e($item['id']); ?> </td>
                                    <td class="center"><?php echo e($item['user_id']); ?></td>
                                    <td class="center"><?php echo e($item['phone']); ?></td>
                                    <td class="center"><?php echo e($item['name']); ?></td>
                                    <td class="center"><?php echo e($item['created_at']); ?></td>
                                   <?php /* <td class="center"><?php echo e($item['note']); ?></td>*/ ?>
                                    <td class="center"><?php echo e($item['event_id_label']); ?></td>
                                    <td class="center"><?php echo e($item['balance_before']); ?></td>
                                    <td class="center"><?php echo e($item['balance_change']); ?></td>
                                    <td class="center"><?php echo e($item['balance']); ?> </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td class="center" colspan="7"></td>
                                <td class="center">资金变动合计:</td>
                                <td class="center"><?php echo e($summary['balance_change_summary']); ?></td>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="pagination pagination-centered" id="pagination-ajax">
                    <?php echo $__env->make('scripts/paginate', ['paginate'=>$paginate], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div><!--/span-->

    </div><!--/row-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>