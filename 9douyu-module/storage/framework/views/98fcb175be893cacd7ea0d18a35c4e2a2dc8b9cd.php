<?php $__env->startSection('content'); ?>

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

    </div><!-- contentpanel -->
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.admin-app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>