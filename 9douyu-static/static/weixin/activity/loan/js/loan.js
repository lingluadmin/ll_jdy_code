
var LoanBonus   =   {

    bonusType:'percentile',
    loanObj  :'btn-loan-bonus',
    success_img  : '/static/weixin/activity/loan/images/pop-icon.png' ,
    default_img: '/static/weixin/activity/loan/images/pop-bonus.png',
    login_img: '/static/weixin/activity/loan/images/pop-login.png',
    LoanSuccess:function () {
        var _this       =   this;
        error_html      =   '<span class="pop-close"></span>'+
                            '<h1 class="pop-title">热烈庆祝耀盛网络小贷开业<br>1%加息券免费领！</h1>'+
                            '<div class="pop-text-success">'+
                            '<p><img class="pop-success-img" src="'+ _this.StaticBaseUrl() + _this.success_img +'" /></p>'+
                            '<p>领取成功！</p>'+
                            '<p>请在【资产-我的优惠券】中查看</p>'+
                            '<a href="javascript:;" class="pop-btn pop-btn-mask" >好的</a>' +
                            '</div>'
        return error_html ;
    },

    LoanError:function (msg) {
        var _this       =   this;
        error_html  =   '<span class="pop-close"></span>'+
                        '<h1 class="pop-title">热烈庆祝耀盛网络小贷开业<br>1%加息券免费领！</h1>'+
                        '<div class="pop-text-success">'+
                        '<p><img class="pop-success-img" src="'+ _this.StaticBaseUrl() + _this.default_img +'" /></p>'+
                        '<p>领取失败！</p>'+
                        '<p>'+ msg + '</p>'+
                        '<a href="javascript:;" class="pop-btn pop-btn-mask">知道了</a>'+
                        '</div>'
        return error_html
    },
    LoanErrorLogin:function () {
        var _this       =   this;
        error_html  =   '<span class="pop-close"></span>'+
                        '<h1 class="pop-title">热烈庆祝耀盛网络小贷开业<br>1%加息券免费领！</h1>'+
                        '<div class="pop-text-success">'+
                        '<p><img class="pop-success-img" src="'+ _this.StaticBaseUrl() + _this.login_img +'" /></p>'+
                        '<p>客官，别急</p>'+
                        '<p>还没登录呢！</p>'+
                        '<a href="javascript:;" class="pop-btn userDoLogin">知道了</a>'+
                        '</div>'

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
        var dialogPop   =   $('#pop-success');
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
                dialogPop.find('.pop').empty().html(dialog);
                dialogPop.show()
                _this.unlock();
            }, error : function() {
                dialog  =_this.LoanError('领取失败,请稍后重试');
                _this.unlock();
                dialogPop.find('.pop').empty().html(dialog);
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