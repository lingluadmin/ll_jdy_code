
var LoanBonus   =   {

    bonusType:'percentile',
    loanObj  :'btn-loan-bonus',
    success_img  : '/static/activity/loan/images0915/pop-success.png' ,
    default_img: '/static/activity/loan/images0915/pop-bonus.png',
    login_img: '/static/activity/loan/images0915/pop-login.png',
    LoanSuccess:function () {
        var _this       =   this;
        error_html      =   '<div class="loan-pop-title"><p>热烈庆祝耀盛网络小贷开业<br>1%加息券免费领！</p></div>' +
                            ' <i class="pop-close" data-toggle="mask" data-target="layer-message"></i>' +
                                '<div class="loan-icon"><img src='+ _this.StaticBaseUrl() + _this.success_img +' width="71" height="71"></div>' +
                                    '<p class="text3">领取成功！</p>' +
                                '<p class="text6">请在【资产-我的优惠券】中查看</p>' +
                                '<a class="loan-btn1" href="javascript:;" data-toggle="mask" data-target="layer-message" >好　的</a>';
        return error_html ;
    },

    LoanError:function (msg) {
        var _this       =   this;
        error_html  =   '<div class="loan-pop-title"><p>热烈庆祝耀盛网络小贷开业<br>1%加息券免费领！</p></div>' +
                                '<i class="pop-close" data-toggle="mask" data-target="layer-message"></i>' +
                                '<div class="loan-icon"><img src="'+ _this.StaticBaseUrl() + _this.default_img +'" width="145" height="103"></div>' +
                                '<p class="text4">' + msg +' </p>' +
                                '<a class="loan-btn1 " href="javascript:;" data-toggle="mask" data-target="layer-message">确定</a>';
        return error_html
    },
    LoanErrorLogin:function () {
        var _this   =   this;
        error_html  =   '<div class="loan-pop-title"><p>热烈庆祝耀盛网络小贷开业<br>1%加息券免费领！</p></div>' +
                        '<i class="pop-close" data-toggle="mask" data-target="layer-message"></i>' +
                        '<div class="loan-icon"><img src="'+ _this.StaticBaseUrl() + _this.login_img +'" width="71" height="71"></div>' +
                        '<p class="text5">客官别急，还没登录呢！</p>' +
                        '<a class="loan-btn1" href="/login" >登 录</a>';

        return error_html;
    },
    StaticBaseUrl:function() {
        var btnObj  =   $('#' + this.loanObj);
        var url =   btnObj.attr('attr-static-url');
        if( !url ) {
            url=    'https://static.9douyu.com';
        }
        return url ;
    },
    doLoanDraw:function (event) {
        var _this = this;
        var dialogPop   =   $('.layer-message');
        event.preventDefault();

        var btnObj  =   $('#' + this.loanObj);

        if ( btnObj.attr('lottery-lock') != 'open' ) {
            return false;
        }
        _this.lock();
        var _token  = $("input[name='_token']").val();
        $.ajax({
            url      :"/activity/LoanBonus",
            data     :{custom:this.bonusType,_token:_token},
            dataType :'json',
            type     :'post',
            success : function(response) {
                console.log(response)
                if( response.status == true ){
                   dialog   =    _this.LoanSuccess();
                }
                if( response.status == false) {

                    if( response.data.code == 'login'){
                        dialog= _this.LoanErrorLogin();
                    } else {
                        dialog =_this.LoanError(response.msg)
                    }
                }
                dialogPop.find('.lantern-pop').empty().html(dialog);
                dialogPop.show()
                _this.unlock();
            }, error : function() {
                dialog  =_this.LoanError('领取失败,请稍后重试');
                _this.unlock();
                dialogPop.find('.lantern-pop').empty().html(dialog);
                dialogPop.show()
            }
        });

    },
    lock:function () {
        $('#btn-loan-bonus').attr('lottery-lock','close');
    },
    unlock:function () {
        $('#btn-loan-bonus').attr('lottery-lock','open');
    },
}