<?php $__env->startSection('content'); ?>
    <script src="<?php echo e(assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js')); ?> "></script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index">控制台</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="javascript:void(0)">邀请管理</a></li>
    </ul>
    <form action="" method="get" name="user">
        <div class="control-group">
            <div class="span4">
                <label>
                    邀请人手机号：<input type="text" name="phone" style="width:200px;"  value="<?php echo e($phone); ?>" placeholder="手机号">
                    <?php /*手机号<input type="text" name="phone" style="width:100px;"  value="<?php echo e($search_form['phone']); ?>" placeholder="手机号">*/ ?>
                </label>
            </div>
            <div class="span1"><button type="get" class="btn btn-small btn-primary">点击查询</button></div>
        </div>
    </form>
    <div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header">
                <h2><i class="halflings-icon user"></i><span class="break"></span>邀请记录</h2>
            </div>
            <div class="box-content">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                    <th>邀请人</th>
                    <th>被邀请人</th>
                    <th>来源</th>
                    <th>类型</th>
                    <th>注册时间</th>
                     <th>操作</th>
                    </thead>
                    <?php if(!empty($inviteData)): ?>
                        <tbody>
                            <?php foreach($inviteData as $item): ?>
                                <tr>
                                    <td><?php echo e($phone); ?></td>
                                    <td><?php echo e(isset($item['phone']) ? $item['phone'] : ''); ?></td>
                                    <td><?php echo e($item['type_str']); ?></td>
                                    <td><?php echo e($item['user_type_str']); ?></td>
                                    <td><?php echo e(isset($item['register_time']) ? $item['register_time'] : ''); ?></td>
                                    <?php /*<td><a href="/admin/invite/doDel">解除邀请关系</a></td>*/ ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    <?php endif; ?>
                </table>
                <div class="pagination">
                <?php if(!empty($pageInfo)): ?>
                    <?php echo $__env->make('scripts/paginate', ['paginate'=>$pageInfo], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>