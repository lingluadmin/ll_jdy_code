<?php $__env->startSection('content'); ?>
    <script src="<?php echo e(assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js')); ?> "></script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">控制台</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="javascript:void(0)">用户列表</a></li>
    </ul>
    <div class="alert alert-danger" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <ul>
            <li></li>
        </ul>
    </div>
    <!--start Content-->
    <!--搜索表单-->
    <form action="" method="get" name="user">
        <div class="control-group">
            <div class="span9">
               <?php /* <label>*/ ?>
                手机号:   <input type="text" style="width:120px;" name="phone" value="<?php echo e($search_form['phone']); ?>" placeholder="选择手机号">&nbsp;&nbsp;
                身份证号:   <input type="text" style="width:120px;" name="identity_card" value="<?php echo e($search_form['identity_card']); ?>" placeholder="输入身份证号">&nbsp;&nbsp;
                姓名:   <input type="text" style="width:100px;" name="real_name" value="<?php echo e($search_form['real_name']); ?>" placeholder="输入姓名">&nbsp;&nbsp;
                注册时间: <input type="text" name="startTime" style="width:100px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo e($search_form['startTime']); ?>" placeholder="开始时间"> － <input type="text" name="endTime" style="width:100px;" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" id="date02" value="<?php echo e($search_form['endTime']); ?>" placeholder="结束时间">
                <?php /*</label>*/ ?>
            </div>
            <div class="span1"><button type="submit" class="btn btn-small btn-primary">点击查询</button></div>
        </div>
    </form>
    <div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header">
                <h2><i class="halflings-icon user"></i><span class="break"></span>用户列表</h2>
            </div>
            <div class="box-content">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                    <th>用户ID</th>
                    <th>手机</th>
                    <th>邮箱</th>
                    <th>姓名</th>
                    <th>身份证号</th>
                    <th>注册时间</th>
                    <th>状态</th>
                    <th>来源</th>
                    <th>操作</th>
                    </thead>
                    <?php if(!empty($user_list)): ?>
                    <?php foreach($user_list as $usrInfo): ?>
                    <tbody>
                    <td><?php echo e($usrInfo['id']); ?></td>
                    <td><?php echo e($usrInfo['phone']); ?></td>
                    <td><?php if(!empty($usrInfo['user_info']['email'])): ?><?php echo e($usrInfo['user_info']['email']); ?><?php endif; ?></td>
                    <td><?php echo e($usrInfo['real_name']); ?></td>
                    <td><?php echo e($usrInfo['identity_card']); ?></td>
                    <td><?php echo e($usrInfo['created_at']); ?></td>
                    <td id="status<?php echo e($usrInfo['id']); ?>"><?php echo e($usrInfo['status']); ?></td>
                    <td><?php if(!empty($usrInfo['user_info']['source_code'])): ?><?php echo e(\App\Http\Logics\RequestSourceLogic::$clientSource[$usrInfo['user_info']['source_code']]); ?><?php endif; ?></td>
                    <td>
                        <a class="label label-success" href="/admin/user/info/<?php echo e($usrInfo['id']); ?>">详情</a>
                        <?php if($usrInfo['status_code'] != \App\Http\Models\User\UserModel::CORE_STATUS_BLOCK): ?>
                            <a data-value="<?php echo e($usrInfo['id']); ?>" data-status= "300" class="label label-warning lock">锁定</a>
                        <?php elseif($usrInfo['status_code'] == \App\Http\Models\User\UserModel::CORE_STATUS_BLOCK): ?>
                            <a data-value="<?php echo e($usrInfo['id']); ?>" data-status= "200" class="label label-warning unlock">解锁</a>
                        <?php endif; ?>

                        <?php if($usrInfo['status_code'] == \App\Http\Models\User\UserModel::CORE_STATUS_ACTIVE): ?>
                            <a data-value="<?php echo e($usrInfo['id']); ?>" data-status="<?php echo e($usrInfo['status_code']); ?>" class="label label-delete frozen" href="javascript:void(0)">冻结</a>
                        <?php elseif($usrInfo['status_code'] == \App\Http\Models\User\UserModel::CORE_STATUS_FROZEN): ?>
                            <a data-value="<?php echo e($usrInfo['id']); ?>" data-status="<?php echo e($usrInfo['status_code']); ?>" class="label label-info unFrozen" href="javascript:void(0)">解冻</a>
                        <?php endif; ?>
                        <a class="label label-alert" href="/admin/user/loginInfo?user_id=<?php echo e($usrInfo['id']); ?>">登录信息</a>
                    </td>
                    </tbody>
                    <?php endforeach; ?>
                        <?php else: ?>
                        <tbody>
                        <td colspan="9" style="text-align: center">暂无数据 </td>
                        </tbody>
                    <?php endif; ?>
                </table>
                <?php echo $__env->make('admin/common/page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jsScript'); ?>
    <script type="text/javascript">
        $(document).ready(function(){

            $(".lock, .unlock").on('click',function(){
                var user_id = $(this).attr('data-value');
                var status = $(this).attr('data-status');
                $.ajax({
                    url  : '/admin/user/doUserStatusBlock',
                    type : 'post',
                    dataType : 'json',
                    data : {'user_id' : user_id, status: status},
                    async: true,
                    success:function(result){
                        if(result.status){
                            $('.alert-danger').addClass('alert-success');
                            $('.alert-success').show();
                            $("#status"+user_id).html('已锁定');
                            $('.alert-success').html('锁定账户成功').show(300).delay(2000).hide(300);
                            location.reload();
                        }else{
                            $('.alert-danger').slideDown();
                            $('.alert-danger ul li').html(result.msg);
                        }

                    },
                    error:function(result){
                        $('.alert-danger').slideDown();
                        $('.alert-danger ul li').html(result.msg);
                    }
                });
            });

            //冻结
            $(".frozen").on('click', function(){

                var user_id = $(this).attr('data-value');
                var status = $(this).attr('data-status');

                if( status == 400){

                    $('.alert-danger').slideDown();
                    $('.alert-danger ul li').html('账户已被冻结');

                    return false;

                }

                if(!confirm('确定要冻结ID为'+user_id+'的账户吗？')){
                    return false;
                }

                $.ajax({
                    url  : '/admin/user/doUserStatusFrozen',
                    type : 'post',
                    dataType : 'json',
                    data : {'user_id' : user_id,},
                    async: true,
                    success:function(result){
                        if(result.status){
                            $('.alert-danger').addClass('alert-success');
                            $('.alert-success').show();
                            $("#status"+user_id).html('已冻结');
                            $('.alert-success').html('ID为'+ user_id +'账户冻结成功').show(30000).delay(2000).hide(300);
                            location.reload();
                        }else{
                            $('.alert-danger').slideDown();
                            $('.alert-danger ul li').html(result.msg);
                        }

                    },
                    error:function(result){
                        $('.alert-danger').slideDown();
                        $('.alert-danger ul li').html(result.msg);
                    }
                });
            });

            //解冻
            $(".unFrozen").on('click', function(){

                var user_id = $(this).attr('data-value');
                var status = $(this).attr('data-status');

                if( status == 200){

                    $('.alert-danger').slideDown();
                    $('.alert-danger ul li').html('账户已解冻');

                    return false;

                }

                if(!confirm('确定要解冻ID为'+user_id+'的账户吗？')){
                    return false;
                }

                $.ajax({
                    url  : '/admin/user/doUserStatusUnFrozen',
                    type : 'post',
                    dataType : 'json',
                    data : {'user_id' : user_id,},
                    async: true,
                    success:function(result){
                        if(result.status){
                            $('.alert-danger').addClass('alert-success');
                            $('.alert-success').show();
                            $('.alert-success').html('ID为'+ user_id +'账户解冻成功').show(30000).delay(2000).hide(300);
                            location.reload();
                        }else{
                            $('.alert-danger').slideDown();
                            $('.alert-danger ul li').html(result.msg);
                        }

                    },
                    error:function(result){
                        $('.alert-danger').slideDown();
                        $('.alert-danger ul li').html(result.msg);
                    }
                });


            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>