<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>" />
    <meta name="description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <link href="<?php echo e(assetUrlByCdn('/static/images/favicon.ico')); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('static/weixin/css/wap4/reset.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('static/weixin/css/wap4/sidenav.css')); ?>">
    <script src="<?php echo e(assetUrlByCdn('/static/weixin/js/jquery-1.9.1.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('/static/weixin/js/wap4/sidenav.js')); ?>"></script>
    <script src="<?php echo e(assetUrlByCdn('/static/weixin/js/lib/avalon.mobile.js')); ?>"></script>
    <?php echo $__env->yieldContent('css'); ?>
    <style type="text/css">
        .ms-controller{  visibility: hidden  }
    </style>
</head>
<body>
    <script type="text/javascript">
        //ready 函数
        var readyRE = /complete|loaded|interactive/;
        var ready = window.ready = function (callback) {
            if (readyRE.test(document.readyState) && document.body) callback()
            else document.addEventListener('DOMContentLoaded', function () {
                callback()
            }, false)
        }
        //rem方法
        function ready_rem() {
            var view_width = document.getElementsByTagName('html')[0].getBoundingClientRect().width;
            var _html = document.getElementsByTagName('html')[0];
            if (view_width > 750) {
                _html.style.fontSize = 750 / 16 + 'px'
            } else {
                _html.style.fontSize = view_width / 16 + 'px';
            }
        }
        ready(function () {
            ready_rem();
        });
    </script>

    <?php echo $__env->make('wap.common.familyFrame', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->yieldContent('footer'); ?>

    <?php echo $__env->yieldContent('jsScript'); ?>
</body>
</html>
