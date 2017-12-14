<?php /*<?php $__env->startSection('css'); ?>
<style type="text/css">
    table tr>td{word-break:break-all; word-wrap:break-word;white-space:normal;}
</style>
<?php $__env->stopSection(); ?>*/ ?>

<?php $__env->startSection('content'); ?>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="#"><?php echo e($home); ?></a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#"><?php echo e($title); ?></a></li>
    </ul>
    <!-- start: Content -->


    <div>

        <?php if(Session::has('message')): ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4>  <i class="icon icon fa fa-warning"></i> 提示： <?php echo e(Session::get('message')); ?> </h4>

            </div>
        <?php endif; ?>

    </div>
    <div class="row-fluid sortable ui-sortable">

        <div class="box span12">
            <div class="box-content">


                <form name="form1" action="" method="get">
                    <div class="control-group">
                         <label class="" for="">键名KEY:
                             <input type="text" class=" typeahead" name="key_word">
                             <input style="margin-left: 30px;margin-bottom: 5px;" type="submit" class="btn btn-small btn-primary" value="点击搜索">
                             <a style="margin-left: 50px;margin-bottom: 5px;"class="btn btn-small btn-success" href="/admin/system_config/create">添加配置</a>

                         </label>
                    </div>
                    <a class="btn btn-small btn-success" href="/admin/system_config">模块配置列表</a>
                    <a style="margin-left: 30px;" class="btn btn-small btn-danger" href="/admin/system_config?config_type=core">核心配置列表</a>
                    <a style="margin-left: 30px;" class="btn btn-small btn-warning" href="/admin/system_config?config_type=service">服务配置列表</a>
                </form>

                <div class="row-fluid sortable ui-sortable">
                    <div class="box span12">
                        <div class="box-header">
                            <h2><i class="halflings-icon align-justify"></i><span class="break"></span><?php echo e($title); ?></h2>
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
                                    <th>操作</th>
                                    <th>ID</th>
                                    <th>描述</th>
                                    <th>键名</th>
                                    <th width="30%">键值</th>
                                    <th width="200">状态</th>
                                    <th>修改时间</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach( $list as $key => $item ): ?>
                                    <tr>
                                        <td class="center">
                                            <a href="/admin/system_config/update?id=<?php echo e($item['id']); ?>&config_type=<?php echo e($configType); ?>"><span class="label label-warning">编辑</span></a>
                                            <?php /*<a href="#"><span class="label label-important">删除</span></a>*/ ?>
                                        </td>
                                        <td class="center"><?php echo $item['id'];?></td>
                                        <td class="center"><?php echo $item['name'];?></td>
                                        <td class="center"><?php echo $item['key'];?></td>
                                        <td class="center">
                                            <?php
                                                $vtr = '';
                                                $v = unserialize($item['value']);
                                                if(is_array($v)){
                                                    foreach($v as $sonk=>$sonv){
                                                        $vtr.=(string)$sonk.'=>'.(string)$sonv.'<br>';
                                                    }
                                                }else {
                                                    $vtr = $v;
                                                }
                                                echo $vtr;
                                            ?>
                                        </td>
                                        <td class="center"><?php if($item['status']){echo '开启';}else{echo '关闭';} ?></td>
                                        <td class="center"><?php echo $item['updated_at'];?></td>

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php echo $__env->make('scripts/paginate', ['paginate'=>$paginate], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div><!--/span-->
                </div>


        </div><!--/span-->
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>