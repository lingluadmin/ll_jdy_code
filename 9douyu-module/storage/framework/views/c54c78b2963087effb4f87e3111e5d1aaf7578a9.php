<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>

<form action="<?php echo e($jxReturn['url']); ?>" method="post" name="autoSubmit">

    <?php unset($jxReturn['url']); ?>

    <?php foreach( $jxReturn as $key => $item ): ?>
        <input type="hidden" name="<?php echo e($key); ?>"         value="<?php echo e($item); ?>">
    <?php endforeach; ?>
</form>

<script type="text/javascript">
    document.autoSubmit.submit();
</script>
</body>
</html>