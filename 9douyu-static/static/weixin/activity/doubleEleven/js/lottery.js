var lottery={
    index:-1,    //当前转动到哪个位置，起点位置
    count:0,    //总共有多少个位置
    timer:0,    //setTimeout的ID，用clearTimeout清除
    speed:20,    //初始转动速度
    times:0,    //转动次数
    cycle:3,    //转动基本次数：即至少需要转动多少次再进入抽奖环节
    prize:-1,    //中奖位置
    init:function(id){
        if ($("#"+id).find(".lottery-unit").length>0) {
            $lottery = $("#"+id);
            $units = $lottery.find(".lottery-unit");
            this.obj = $lottery;
            this.count = $units.length;
            $lottery.find(".lottery-unit-"+this.index).find(".sp-bg").addClass("active");
        };
    },
    roll:function(){
        var index = this.index;
        var count = this.count;
        var lottery = this.obj;
        $(lottery).find(".lottery-unit-"+index).find(".sp-bg").removeClass("active");
        index += 1;
        if (index>count-1) {
            index = 0;
        };
        $(lottery).find(".lottery-unit-"+index).find(".sp-bg").addClass("active");
        this.index=index;
        return false;
    },
    stop:function(index){
        this.prize=index;
        return false;
    }
};

function roll(){
    lottery.times += 1;
    lottery.roll();//转动过程调用的是lottery的roll方法，这里是第一次调用初始化
    if (lottery.times > lottery.cycle+10 && lottery.prize==lottery.index) {
        lotteryEvent.showLat();
        lotteryEvent.unlock();
        clearTimeout(lottery.timer);
        lottery.prize=-1;
        lottery.times=0;
        click=false;
    }else{
        if (lottery.times<lottery.cycle) {
            lottery.speed -= 10;
        }else if(lottery.times==lottery.cycle) {
            lottery.prize  =   $('#btn-lottery-vip').attr('lottery-active-prize') ;
        }else{
            if (lottery.times > lottery.cycle+10 && ((lottery.prize==0 && lottery.index==7) || lottery.prize==lottery.index+1)) {
                lottery.speed += 110;
            }else{
                lottery.speed += 20;
            }
        }
        if (lottery.speed<40) {
            lottery.speed=40;
        };

        if( !lottery.prize ) {
            setTimeout(function () {
                lottery.prize  =   $('#btn-lottery-vip').attr('lottery-active-prize') ;
            },100)
        }
        lottery.timer = setTimeout(roll,lottery.speed);//循环调用
    }
    return false;
}
    //执行抽奖的js 方法
var lotteryEvent    =   {
    error_img: '/static/weixin/activity/iphone8/images/pop-error.png',
    baseObj:    'iphone8-lottery-main',

    staticBaseUrl:function() {
        var _this   =   this;
        var btnObj  =   $('.' + _this.baseObj);
        var url =   btnObj.attr('http_static_url');
        if( !url ) {
            url=    'https://static.9douyu.com';
        }
        return url ;
    },
    doLottery:function(id,activity){
        var _this   =   this;
        var btnObj  =   $('#lottery-btn'+id);
        lock    =   btnObj.attr('lottery-lock');

        if ( lock != 'start' && lock ) {
            return false;
        }
        _this.doLock(id);
        roll();
        var _token  = $("input[name='_token']").val();
        $.ajax({
            url      :'/activity/' + activity + '/luckDraw',
            data     :{_token:_token},
            dataType :'json',
            type     :'post',
            success : function(json) {
                if( json.status == false ){
                    var errorType   =   json.data.type ? json.data.type : 'error'
                    $('.' + _this.baseObj).attr('user_traffic_status',errorType);
                    dialogHtml  =   _this.dialogLayer(errorType, json.msg);
                    _this.errorLet(errorType, dialogHtml);
                    $('#btn-lottery-vip').attr('lottery-active-prize',0);
                    _this.unlock();
                    click=true;
                    return false;
                }
                if( json.status == true ) {

                    var index   =   json.data.order_num-1;
                    var name    =   json.data.name;
                    console.log(index)
                    var lotteryType   =   json.data.type ? json.data.type : ''
                    _this.successLet(name,lotteryType,index);
                    $('.' + _this.baseObj).attr('user_traffic_status','luckLottery');
                    click=true;
                    return false
               }

            }, error : function() {
                dialogHtml  =   _this.dialogLayer('error', '请稍后重试！');
                _this.errorLet('error',dialogHtml);
                _this.unlock();
            }
        });

    },
    successLet:function (traffic,phone,index) {
        var lotteryObj      =   $('#btn-lottery-vip');
        lotteryObj.attr('lottery-active-prize',index);
        var _this   =   this;
        var html    =  _this.toSuccessDialog(traffic);
        $('.page-layer-lottery .page-pop-content').html(html);
    },
    errorLet:function(errorType, dialogHtml) {
        $('.page-layer-error .page-pop-content').html(dialogHtml);
    },
    dialogLayer:function ( type,information ) {
        var _this       =   this;
        var dialogHtml  =   '';
        switch (type){
            case 'notLogged':
                dialogHtml  =   _this.toLoginDialog(_this);
                break;
            case 'notInTime':
                dialogHtml  =   _this.toInTimeDialog(information);
                break;
            case 'sign':
                dialogHtml  =   _this.toSignDialog(_this,information);
                break;
            default:
                dialogHtml  =   _this.toDefaultDialog(_this,information);
                break;
        }
        return  dialogHtml;
    },
    toLoginDialog:function (_this) {
        dialogHtml     =   '<p><img src="'+_this.staticBaseUrl() + _this.error_img+ '" class="pop-error-img"></p>'+
                        '<p>抽奖失败</p>' +
                        '<p>还未登录,请登录后进行抽奖！</p>'+
                        '<a href="javascript:;" data-toggle="mask" data-target="page-layer-error" class="page-pop-btn2 userLogin">马上登录</a>';
        return  dialogHtml;
    },
    toDefaultDialog:function (_this, information) {
        dialogHtml     ='<p><img src="'+_this.staticBaseUrl() + _this.error_img+ '" class="pop-error-img"></p>'+
                        '<p>抽奖失败!</p>' +
                        '<p>'+information+'</p>'+
                        '<a href="javascript:;" data-toggle="mask" data-target="page-layer-error" class="page-pop-btn2">知道了</a>';
        return  dialogHtml;
    },
    toSignDialog:function (_this,msg) {
        dialogHtml  =   '<p><img src="'+_this.staticBaseUrl() + _this.error_img+ '" class="pop-error-img"></p>'+
                        '<h4>十分抱歉</h4>' +
                        '<p>'+msg+'</p>' +
                        '<a href="/activity/doubleEleven?from=app" data-toggle="mask" class="page-pop-btn">立即去签到</a>'
        return dialogHtml
    },
    toSuccessDialog:function (name) {
        dialogHtml  =   '<h4>恭喜啦</h4>'+
                        '<p>抽中'+name+'</p>'+
                        '<div class="pop-bonus">'+name+'</div>';
        return dialogHtml;
    },
    doLock:function (id) {
        $('.page-lottery-btn').attr('lottery-lock','close');
        $('#lottery-btn'+id).addClass('disable');
    },
    unlock:function () {
        $('.page-lottery-btn').removeClass("disable").attr('lottery-lock','start');
    },
    showLat:function() {
        var _this   =   this;
        var errorType   =   $('.' + _this.baseObj).attr('user_traffic_status') ;
        switch (errorType){
            case 'notLogged':
                $(".page-layer-login").show();
                break;
            case 'notInTime':
            case 'sign':
            case 'error':
                $(".page-layer-error").show();
                break;
            default:
                $(".page-layer-lottery").show();
                break;
        }
    }
}
