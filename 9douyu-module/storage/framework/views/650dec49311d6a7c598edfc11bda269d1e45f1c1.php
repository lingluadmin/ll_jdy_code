<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>

<form action="<?php echo e($url); ?>" method="post" name="orderForm">
    <input name="accountId" type="hidden" id="accountId"    value="<?php echo e($accountId); ?>" />
    <input name="acqRes"    type="hidden" id="acqRes"       value="<?php echo e($acqRes); ?>" />
    <input name="bankCode"  type="hidden" id="bankCode"     value="<?php echo e($bankCode); ?>" />
    <input name="cardNo"    type="hidden" id="cardNo"       value="<?php echo e($cardNo); ?>" />
    <input name="channel"   type="hidden" id="channel"      value="<?php echo e($channel); ?>" />
    <input name="forgotPwdUrl" type="hidden" id="forgotPwdUrl" value="<?php echo e($forgotPwdUrl); ?>" />
    <input name="idNo"      type="hidden" id="idNo"         value="<?php echo e($idNo); ?>" />
    <input name="idType"    type="hidden" id="idType"       value="<?php echo e($idType); ?>" />
    <input name="instCode"  type="hidden" id="instCode"     value="<?php echo e($instCode); ?>" />
    <input name="mobile"    type="hidden" id="mobile"       value="<?php echo e($mobile); ?>" />
    <input name="name"      type="hidden" id="name"         value="<?php echo e($name); ?>" />
    <input name="notifyUrl" type="hidden" id="notifyUrl"    value="<?php echo e($notifyUrl); ?>" />
    <input name="retUrl"    type="hidden" id="retUrl"       value="<?php echo e($retUrl); ?>" />
    <input name="routeCode" type="hidden" id="routeCode"    value="<?php echo e($routeCode); ?>" />
    <input name="seqNo"     type="hidden" id="seqNo"        value="<?php echo e($seqNo); ?>" />
    <input name="txAmount"  type="hidden" id="txAmount"     value="<?php echo e($txAmount); ?>" />
    <input name="txCode"    type="hidden" id="txCode"       value="<?php echo e($txCode); ?>" />
    <input name="txDate"    type="hidden" id="txDate"       value="<?php echo e($txDate); ?>" />
    <input name="txFee"     type="hidden" id="txFee"        value="<?php echo e($txFee); ?>" />
    <input name="txTime"    type="hidden" id="txTime"       value="<?php echo e($txTime); ?>" />
    <input name="userIP"    type="hidden" id="userIP"       value="<?php echo e($userIP); ?>" />
    <input name="version"   type="hidden" id="version"      value="<?php echo e($version); ?>" />
    <input name="sign"      type="hidden" id="sign"         value="<?php echo e($sign); ?>" />
</form>

<script type="text/javascript">
    document.orderForm.submit();
</script>
</body>
</html>