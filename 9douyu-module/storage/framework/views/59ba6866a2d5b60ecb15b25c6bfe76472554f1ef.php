<?php $__env->startSection('content'); ?>
    <script src="<?php echo e(assetUrlByCdn('theme/metro/My97DatePicker/WdatePicker.js')); ?> "></script>

    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/admin/project/lists"><?php echo e($home); ?></a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#"><?php echo e($title); ?></a></li>
    </ul>
    <!-- start: Content -->
    <form role="form" action="/admin/system_config/doUpdate" method="post">

        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
        <input type="hidden" name="config_type" value="<?php echo e($configType); ?>" />
        <div>
            <?php if(Session::has('message')): ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>  <i class="icon icon fa fa-warning"></i> 提示! </h4>
                    <?php echo e(Session::get('message')); ?>

                </div>
            <?php endif; ?>

            <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <ul>
                        <?php foreach($errors->all() as $error): ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="row-fluid sortable">
            <div class="box span12">
                <div class="box-header" data-original-title>
                    <h2><i class="halflings-icon edit"></i><span class="break"></span>配置</h2>
                    <div class="box-icon">
                        <?php /*<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>*/ ?>
                        <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                        <?php /*<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>*/ ?>
                    </div>
                </div>

                <div class="box-content form-horizontal">
                    <fieldset>
                        <input type="hidden" name="id" value="<?php echo e($info['id']); ?>">
                        <div class="control-group">
                            <label class="control-label" for="date02"> 描述: </label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge focused not_null" type="text" name="name" required="required" value="<?php echo e(Input::old('name',  $info['name'])); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="selectProductLine"> 状态 </label>
                            <div class="controls">
                                <select name="status">
                                    <option value="0" <?php if($info['status'] == 0): ?> selected <?php endif; ?> >关闭</option>
                                    <option value="1" <?php if($info['status'] == 1): ?> selected <?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="selectProductLine"> 键名 </label>

                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input class="input-xlarge focused not_null" type="text" name="key" required="required" value="<?php echo e(Input::old('key', $info['key'])); ?>"><span class = "add-on " id="appendConfigButton">添加二级配置</span>
                                </div>
                            </div>
                        </div>

                        <?php if(!is_array($info['value'])): ?>
                        <div class="control-group value_area" >
                            <label class="control-label value_area" for="value">值：</label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <input type="text" class="input-xxlarge value_area not_null" required="required" name="value" value="<?php echo e(Input::old('value', $info['value'])); ?>">
                                </div>
                            </div>
                        </div>
                            <?php else: ?>
                            <div class="control-group value_area" style="display: none;" >
                                <label class="control-label value_area" for="value">值：</label>
                                <div class="controls">
                                    <div class="input-prepend input-append">
                                        <input type="text" class="input-xxlarge value_area " name="value" value="<?php echo e(Input::old('value')); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(is_array($info['value'])): ?>
                            <?php foreach( $info['value'] as $key => $item): ?>
                                <div class="control-group append_config_div">
                                    <div class="controls">
                                        <div class="input-prepend input-append">
                                            <label class="control-label" for="second_key">键名：</label>
                                            <input type="text" class="input-xxlarge focused not_null"  name="second_key[]" required="required" value="<?php echo e($key); ?>">
                                            </div>
                                        </div><br/>
                                    <div class="controls">
                                        <div class="input-prepend input-append">
                                            <label class="control-label" for="second_value">值：</label>
                                            <input type="text" class="input-xxlarge focused not_null"  name="second_value[]" required="required" value="<?php echo e($item['value']); ?>">
                                            </div>
                                        </div><br/>
                                    <div class="controls">
                                        <div class="input-prepend input-append">'
                                            <label class="control-label" for="second_des">描述：</label>
                                            <input type="text" class="input-xxlarge focused not_null"  name="second_des[]" value="<?php echo e($item['second_des']); ?>">
                                            <span class="add-on deleteConfigButton">删除二级配置</span>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <div id="lastDiv"></div>

                    </fieldset>
                </div>

            </div><!--/span-->
        </div><!--/row-->

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">保存</button>
            <button type="reset" class="btn">重置</button>
        </div>

    </form>
    <script>
        //jQuery
        (function(){
            $(document).ready(function(){
                //动态追加html
                config_html =
                        '<div class="control-group append_config_div">' +
                            '<div class="controls">' +
                                '<div class="input-prepend input-append">' +
                                    '<label class="control-label" for="second_key">键名：</label>' +
                                    '<input type="text" class="input-xxlarge focused not_null"  name="second_key[]" required="required" value="">' +
                                '</div>' +
                            '</div><br/>' +
                            '<div class="controls">' +
                                '<div class="input-prepend input-append">' +
                                    '<label class="control-label" for="second_value">值：</label>' +
                                    '<input type="text" class="input-xxlarge focused not_null"  name="second_value[]" required="required" value="">' +
                                '</div>' +
                            '</div><br/>' +
                            '<div class="controls">' +
                                '<div class="input-prepend input-append">' +
                                    '<label class="control-label" for="second_des">描述：</label>' +
                                    '<input type="text" class="input-xxlarge focused not_null"  name="second_des[]" value="">' +
                                    '<span class="add-on deleteConfigButton">删除二级配置</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

                //删除二级配置
                $('body').on('click', '.deleteConfigButton', function(){
                    $(this).parent().parent().parent().remove();
                    if($('.append_config_div').length < 1){
                        $('.value_area').addClass('not-null').show();
                    }
                });

                //添加二级配置
                $('#appendConfigButton').click(function(){
                    $('.value_area').removeClass('not-null').hide();
                    $('#lastDiv').before(config_html);
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>