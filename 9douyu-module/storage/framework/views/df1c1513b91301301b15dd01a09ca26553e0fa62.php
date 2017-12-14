<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(env('TITLE_SUFFIX')); ?></title>
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>" />
    <meta name="description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link href="<?php echo e(assetUrlByCdn('/static/images/favicon.ico')); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <meta name="format-detection" content="email=no">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/animations.css')); ?>"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/index.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/sidenav.css')); ?>">

    <script>
        //cnzz统计的api接口初始化
        var _czc = _czc || [];
        _czc.push(["_setAccount", "1259206554"]);
    </script>
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
</head>
<body>
<?php echo $__env->yieldContent('css'); ?>
<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->yieldContent('footer'); ?>

<?php echo $__env->yieldContent('downloadApp'); ?>

<?php echo $__env->yieldContent('jsScript'); ?>
</body>
</html>