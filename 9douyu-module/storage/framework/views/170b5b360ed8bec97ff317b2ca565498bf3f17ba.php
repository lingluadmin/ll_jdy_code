<?php $__env->startSection('content'); ?>
    <script src="<?php echo e(assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js')); ?> "></script>
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

            <?php if(Session::has('message')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>  <i class="icon fa fa-check"></i> 提示: <?php echo e(Session::get('message')); ?></h4>

                </div>
            <?php endif; ?>

            <div class="box-content">

                <div class="control-group error">
                    <span class="help-inline"><?php echo e(Session::get('success')); ?></span>
                </div>

                <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo e(URL('admin/withdraw/uploadBill')); ?>" method="post">
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
                                <?php /*
                                <label class="radio">
                                    <span class=""><input name="payChannel" value="jd" type="radio" >网银付款</span>
                                </label>
                                */ ?>
                                <?php /*
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class=""><input name="payChannel" value="suma" type="radio">丰付付款</span>
                                </label>
                                <div style="clear:both"></div>
                                */ ?>

                                <label class="radio">
                                    <span class=""><input name="payChannel" value="ucf" type="radio" checked>先锋付款</span>
                                </label>

                            </div>
                        </div>

                        <div class="form-actions">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
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
                    <?php if( !empty($list) ): ?>
                        <?php foreach( $list as $info ): ?>
                            <tr>
                                <td><?php echo e($info['id']); ?></td>
                                <td><?php echo e($info['name']); ?></td>
                                <td class="center">
                                    <button class="btn btn-mini btn-primary"><?php echo e("先锋提现对账"); ?></button>
                                </td>
                                <td><?php echo e($info['note']); ?></td>
                                <td><?php echo e($info['created_at']); ?></td>
                                <td><?php echo e($info['updated_at']); ?></td>
                                <td>
                                    <a href="<?php echo e($info['file_path']); ?>" title="点击查看" target="_blank" ><?php echo e($info['file_path']); ?></a>
                                </td>
                                <td><?php echo e($info['admin_id']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">暂无信息</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination pagination-centered" id="pagination-ajax">
                <?php echo $__env->make('scripts/paginate', ['paginate'=>$paginate], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div><!--/span-->
    </div>

    <?php /*
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon edit"></i><span class="break"></span>当日上传文件列表,方便操作人员核对,防止漏传!!!</h2>
            </div>
<p></p>
            <?php if( !empty($uploadData) ): ?>
                <?php foreach( $uploadData as $fileName): ?>
                    <div class="alert alert-success alert-dismissable">
                        <h4>  <i class="icon fa fa-check"></i> 文件名: 【<?php echo e($fileName); ?>】</h4>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div><!--/span-->
    </div>

    */ ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>