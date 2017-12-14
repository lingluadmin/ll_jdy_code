<?php $__env->startSection('title', '九斗鱼理财'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/confirm.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(assetUrlByCdn('/static/weixin/css/wap4/recharge.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<article>
    <nav class="v4-top flex-box box-align box-pack v4-page-head">
        <a href="javascript:;" class="v4-back" onclick="window.history.go(-1);">返回</a>
        <h5 class="v4-page-title">提现</h5>
        <div class="v4-user">
                <!-- <a href="/login">登录</a> | <a href="/register">注册</a> -->
                <a href="javascript:;" data-show="nav">我的</a>
        </div>
    </nav>
    <form action="#">
        <div class="recharge-bank">
            <img src="<?php echo e(assetUrlByCdn('/static/app/images/bank/'.$withdrawCard[0]['bank_id'].'.png')); ?>">
            <span><?php echo e(App\Http\Models\Bank\CardModel::getBankName($withdrawCard[0]['bank_id'])); ?></span>
            <span>尾号<?php echo e(substr($withdrawCard[0]['card_no'],-4)); ?></span>
        </div>
        
        <div class="recharge-main">
            <span id="minMoney"         data-value="<?php echo e(isset($minMoney) ? $minMoney : 0); ?>"></span>
            <span id="freeAmount"       data-value="<?php echo e(isset($userInfo['balance']) ? $userInfo['balance'] : 0); ?>"></span>
            <span id="needHandling"     data-value="<?php echo e(isset($commission) ? $commission : 5); ?>"></span>
            <span id="withDrawNum"      data-value="<?php echo e(isset($withDrawNum['total']) ? $withDrawNum['total'] : 0); ?>"></span>
            <span id="withDrawFreeNum"  data-value="<?php echo e(isset($maxFreeNum) ? $maxFreeNum : 0); ?>"></span>
            <p>提现金额</p>
            <div class="recharge-main-input">
                <span>￥</span><input type="text" placeholder="最小提现金额100元" class="recharge-input" id="withdraw" name="withdraw_cash"><ins id="allCash">全部提现</ins>
            </div>
        </div>
        <div class="recharge-info">账户可提金额<span id="cash"><?php echo e($userInfo['balance']); ?></span>元</div>
        <input type="hidden"    name="_token"   value="<?php echo e(csrf_token()); ?>">
        <input type="hidden"    name="from"     value="wap"     id="from">
        <input type="hidden"    name="version"  value=""        id="version">
        <input type="hidden"    name="card_no"  value="<?php echo e(isset($withdrawCard[0]['card_no']) ? $withdrawCard[0]['card_no'] : null); ?>" id="cardNo">
        <input type="hidden"    name="bank_id"  value="<?php echo e(isset($withdrawCard[0]['bank_id']) ? $withdrawCard[0]['bank_id'] : null); ?>" id="bankId">

        <div id="v4-input-msg" class="v4-input-msg"><?php if(Session::has('errors')): ?><?php echo e(Session::get('errors')); ?><?php endif; ?></div>
        <input type="button" class="v4-btn" id="withdrawBtn"    value="确认">
    </form>
</article>
<section class="v4-pop layer-1" id="preWithdrawShow">
    <div class="v4-pop-mask" data-toggle="mask" data-target="layer-1"></div>
    <div class="v4-pop-main">
        <div class="v4-pop-recharge-title">
            温馨提示
        </div>
        <div class="v4-pop-recharge-box">
            <p><big>提现金额 <span  id="showCash">0</span>元</big></p>
            <p>提现手续费 <span id="showHandleFee">0</span>元</p>
            <p>剩余免费提现次数<span id="showFreeNum">0</span>次</p>
            <p><small>实际到账<span id="showRealCash">0</span>元</small></p>
        </div>
        <div class="v4-pop-btn">
            <a href="javascript:;" id="carryOn">继续提现</a>
            <a href="/project/lists">马上投资</a>
        </div>
    </div>
</section>



<!-- 交易密码弹层开始 -->
<section class="v4-pop layer-10" id="payPassword">
    <div class="v4-pop-mask"></div>
    <div class="v4-pop-main">
        <div class="v4-pop-tpw-title">
            <ins>交易密码</ins>
            <a href="javascript:void(0)" class="v4-pop-close" data-toggle="mask" data-target="layer-10"></a>
        </div>
        <div class="v4-pop-tpw-box clearfix">
            <p class="v4-confirm-text1">提现</p>
            <p class="v4-confirm-text2">￥<span id="showCash1"></span></p>
            <input type="password" placeholder="请输入交易密码" id="trading_password"  name="trading_password" class="v4-input-2">
            <section class="v4-tip v4-pop-tip error">
                <p id="v4-password-msg"></p>
            </section>
            <div class="">
                 <a href="javascript:;" id="confirmSubmit" class="v4-btn v4-confirm-btn">确认</a>
            </div>
           
            
        </div>
    </div>
</section>
<!-- 交易密码弹层结束 -->

<!-- 交易成功弹层开始 -->
<section class="v4-pop layer-11"  id="withdrawResult">
    <div class="v4-pop-mask"></div>
    <div class="v4-pop-main">
        <div class="v4-pop-sucess clearfix">
            <p class="v4-pop-icon"><span></span></p>
            <p class="v4-pop-text1">提现申请成功</p>
            <p class="v4-pop-text2"><a href="/user">完成</a></p>
        </div>
    </div>
</section>
<!-- 交易成功结束 -->

    <!-- 侧边栏 -->
    <?php echo $__env->make('wap.home.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 
<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsScript'); ?>
<script src="<?php echo e(assetUrlByCdn('static/weixin/js/pop.js')); ?>"></script>
<script>
(function($){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function(){
        var needHandling    = parseInt($("#needHandling").attr('data-value'));
        var minMoney        = $("#minMoney").attr("data-value");
        var freeAmount      = $("#freeAmount").attr("data-value");

        var withDrawNum     = parseInt($("#withDrawNum").attr('data-value'));
        var withDrawFreeNum = parseInt($("#withDrawFreeNum").attr('data-value'));


        var evclick = "ontouchend" in window ? "touchend" : "click";

        // TODO:全部提现
        $('#allCash').on(evclick,function(){
            var cashNum = $('#cash').text();
            $('#withdraw').val(cashNum)
        });

        // TODO： 预览信息
        $('#withdrawBtn').on(evclick,function(){
            //TODO: 验证提现信息
            if( cashValitate() ){
                //TODO: 预览提现信息
                var cash        = $("#withdraw").val();
                var real_cash   = cash - needHandling;

                // 剩余免费次数
                var surplus_num = withDrawFreeNum-withDrawNum;
                if( surplus_num <= 0 ){
                    surplus_num = 0;
                }

                $("#showCash,#showCash1").html(cash);
                $("#showHandleFee").html(needHandling);
                $("#showRealCash").html(real_cash);
                $("#showFreeNum").html(surplus_num);

                $("#preWithdrawShow").show();
                // $('.v4-pop').show();

            }
        });

        // TODO： 交易密码
        $('#carryOn').on(evclick,function(){
            $('#payPassword').show();
            $('#preWithdrawShow').hide();
        })


        $("#withdraw").blur(function() {
            // $(this).formatInput(/^[1-9]+([.][0-9]{0,2})?$/);
            //var cashPatten  = /^[1-9]+([.][0-9]{0,2})?$/;
            var cashPatten  = /^[1-9]\d{1,}(\.\d{1,2})?$/;
            var cashV       = $.trim($(this).val())
            // alert(cashPatten.test(cashV))
            if( !cashPatten.test(cashV)){
                $(".v4-input-msg").html("请输入有效提现金额");
                $(this).val("")
                return false;
            }
            cashValitate()
        });

        // check data
        function  cashValitate() {

            var cash    = $("#withdraw").val();
            cash        = parseInt(cash);

            if( !cash ) {
                $(".v4-input-msg").html(minMoney + "元起提现，请输入提现金额");
                return false;
            } else if( Number(cash) < minMoney ){
                $('.v4-input-msg').html("提现不小于" + minMoney +"元");
                return false;
            } else if( Number(cash) > freeAmount ) {
                $(".v4-input-msg").html("可用余额不足");
                return false;
            } else {
                $(".v4-input-msg").html("");
                return true;
            }
        }

        $("#trading_password").blur(function() {
            passwordValitate()
        })

        function passwordValitate() {
            var password= $("#trading_password").val();
            var pattern = /^(?![0-9]+$)(?![a-z]+$).{6,16}$/i;
            //var pattern = /^[0-9]{6}$/i;
            if(!password) {
                $("#v4-password-msg").html("请输入交易密码");
                return false;
            } else if(password.length < 6){
                $("#v4-password-msg").html("交易密码不少于6位");
                return false;
            } else if(!password.match(pattern)){
                $("#v4-password-msg").html("交易密码错误");
                return false;
            } else {
                $("#v4-password-msg").html("");
                return true;
            }
        }


        $("#confirmSubmit").click(function(){
            var  withdraw_cash      = $.trim($("#withdraw").val());
            var  trading_password   = $.trim($("#trading_password").val());
            var  card_no    = $.trim($("#cardNo").val());
            var  bank_id    = $.trim($("#bankId").val());
            var  from       = $.trim($("#from").val());
            var  version    = $.trim($("#version").val());

            if(passwordValitate()){
                $.ajax({
                    url : '/withdraw/ajaxSubmit',
                    type: 'POST',
                    dataType: 'json',
                    data: {'withdraw_cash': withdraw_cash,'trading_password':trading_password,'bank_id':bank_id, 'card_no':card_no,'from':from,'version':version},
                    success : function( result ) {
                        $("#preWithdrawShow").hide();
                        if( result.status == 'success') {
                            $("#withdrawResult").show();
                            $("#payPassword").hide();
                            return true;
                        } else {
                            $("#v4-input-msg").html(result.msg);
                            $("#payPassword").hide();
                            return false;
                        }
                    },
                    error : function(msg) {
                        $("#v4-input-msg").html("服务器端错误，请重新操作");
                        return false;
                    }
                });
            }
        });


    })
})(jQuery)
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('wap.common.wapBaseLayoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>