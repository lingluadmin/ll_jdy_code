<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<span system="<?php echo e($system); ?>" id="touch"></span>
<div style="text-align: center;margin-top: 100px;">
    <button  style="width: 100px;height: 48px;" onclick="closeBtn()">关闭</button>
</div>

<input type="hidden" id="txCode" value="<?php echo e($txCode); ?>">
</body>
<script src="<?php echo e(assetUrlByCdn('/static/js/jquery-1.9.1.min.js')); ?>"></script>
<script type="text/javascript">
     $(function(){
         var system = $('span').attr('system');
         var txCode = $("#txCode").val()

         $("#touch").on('click',function(){
             if(txCode == 'withdraw'){
                 if(system == 'android'){
                     window.jiudouyu.withdrawSuccess();
                 }else if(system == 'ios'){
                     window.location.href="objc:withdrawSuccess";
                 }
             }else{
                 if(system == 'android'){
                     window.jiudouyu.setTradePasswordSuccess();
                 }else if(system == 'ios'){
                     window.location.href="objc:setTheTradePasswordSuc";
                 }
             }
             setTimeout('closeBtn()', 3000);
         });

         setTimeout(function(){
             $("#touch").trigger('click');
         },1000);

     });



    function closeBtn(){
        var system = $('span').attr('system');
        if(system == 'android'){
            window.jiudouyu.hideBackArrow();
        }else if(system == 'ios'){
            window.location.href="objc:gotoOrige";
        }
    }

</script>
</html>

