<?php $__env->startSection('title','九斗鱼app'); ?>

<?php $__env->startSection('css'); ?>
 <style>
     body{background-color: #fff;text-align: center;}
     .app-logo-9douyu{width: 4.05rem;margin:6.1rem auto 5.48rem;}
     .app-text{color: #9B9B9B;font-size: 0.725rem;}
     .app-btn{display: block;margin:0.853rem auto;width:80%;height: 1.813rem;line-height: 1.813rem;color: #fff;border-radius: 0.213rem;font-size: 0.64rem;box-sizing: border-box;}
     .app-btn-download{background-color: #4298FE;}
     .app-btn-open{background-color: #fff;color:#4298FE;border:1px solid #4298FE;}
     .app-mask{position: fixed;z-index:1;left:0;top:0;width: 100%;height: 100%;background: rgba(0,0,0,0.7);}
     .app-pop{position: fixed;z-index:2;left:1.173rem;right:1.173rem;top:50%;-webkit-transform: translate(0, -50%);
    transform: translate(0, -50%);background-color: #fff;color: #666;text-align: center;}
     .app-text-wrap{margin:2.709rem auto 2.437rem;}
     .app-text-wrap>p{font-size: 0.597rem;line-height: 0.853rem;}
     .app-btn-wrap{height: 2.027rem;line-height: 2.027rem;box-sizing: border-box;font-size: 0;background-color: #fff;}
     .app-btn-wrap>a{display: inline-block;width: 50%;font-size: 0.725rem;color: #666;vertical-align: top;}
     .app-btn-wrap>a:last-child{color: #4298FE;}
     @media(-webkit-device-pixel-ratio: 1.5),(device-pixel-ratio: 1.5){
        .border-top::after {
            -webkit-transform: scaleY(0.7);
            transform: scaleY(0.7);
        }
        .border-left::after {
            -webkit-transform: scaleX(0.7);
            transform: scaleX(0.7);
        }

    }
    @media(-webkit-device-pixel-ratio: 2),(device-pixel-ratio: 2){
        .border-top::after {
            -webkit-transform: scaleY(0.5);
            transform: scaleY(0.5);
        }
        .border-left::after {
            -webkit-transform: scaleX(0.5);
            transform: scaleX(0.5);
        }

    }
    @media(-webkit-device-pixel-ratio: 3.0),(device-pixel-ratio: 3.0){
        .border-top::after {
            -webkit-transform: scaleY(0.33);
            transform: scaleY(0.33);
        }
        .border-left::after {
            -webkit-transform: scaleX(0.33);
            transform: scaleX(0.33);
        }

    }
    .border-top,.border-left{
        position: relative;

    }

    .border-top::after {
        content: " ";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 1px;
        background-color: #eee;
        -webkit-transform-origin: left bottom;
        transform-origin: left bottom;
    }
    .border-left::after{
        content: " ";
        position: absolute;
        left: 0;
        top: 0.65rem;
        width: 1px;
        height: 0.853rem;
        background-color: #eee;
        -webkit-transform-origin: left bottom;
        transform-origin: left bottom;
    }
 </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<article>

<img src="<?php echo e(assetUrlByCdn('/static/weixin/images/wap4/apppage/logo-9douyu.png')); ?>" alt="" class="app-logo-9douyu">
<p class="app-text">江西银行直接存管</p>
<input  type="hidden" id="jumpUrl" value="<?php echo e($jumpUrl); ?>">
<input  type="hidden" id="downUrl" value="<?php echo e($downUrl); ?>">
<input  type="button" class="app-btn app-btn-download"   id="downApp"    value="下载客户端">
<input  type="button" class="app-btn app-btn-open"       id="openApp"    value="打开APP">
<br/>
<!-- pop -->
<div id="app-layer" style="display: none">
    <div class="app-mask"></div>
    <div class="app-pop">
        <div class="app-text-wrap">
            <p>在【九斗鱼】中打开此链接吗?</p>
        </div>
        <div class="app-btn-wrap border-top">
            <a href="javascript:;" id="close-layer">取消</a>
            <a href="javascript:;" class="border-left">打开</a>
        </div>
    </div>
</div>
</article>

<script type="text/javascript">

    var  jumpUrl    =  document.getElementById('jumpUrl').value
    var  downUrl    =  document.getElementById('downUrl').value

    window.onload   = function () {
        setTimeout(function(){
            try{
                window.location.href = jumpUrl
            }catch(e){

            }
        },0)
    }

    document.getElementById('openApp').onclick = function(e){

        if(navigator.userAgent.match(/(iPhone|iPod|iPad);?/i))
        {
            window.location.href = jumpUrl;    //ios app协议
//            window.setTimeout(function() {
//                window.location.href = downUrl;
//            }, 2000)
        }
        if(navigator.userAgent.match(/android/i))
        {
            window.location.href = jumpUrl;     //android app协议
//            window.setTimeout(function() {
//                window.location.href = downUrl; //android 下载地址
//            }, 2000)
        }
    };

    document.getElementById('downApp').onclick = function(e){

        if(navigator.userAgent.match(/(iPhone|iPod|iPad);?/i))
        {
            window.location.href= downUrl;

//            window.location.href    = jumpUrl;      //ios app协议
//            window.setTimeout(function() {
//
//            }, 2000)
        }
        if(navigator.userAgent.match(/android/i))
        {
            window.location.href= downUrl;

//            window.location.href    = jumpUrl;      //android app协议
//            window.setTimeout(function() {
//                //android 下载地址
//
//            }, 2000)
        }
    };


    // 关闭弹窗
    document.getElementById('close-layer').onclick = function(e){

        document.getElementById('app-layer').style.display = "none";
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('wap.common.wapBaseLayoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>