/**
 * Created by alpha on 2017/8/16.
 */
$(function(){
    avalon.config({
        interpolate: ['{%','%}']
    });
    var mAjax = [];
    window.mAjaxGet = function(url, data, fn, dataType, errorFn){
        if(mAjax[url]){
            //$.popover({content: '正在操作中...'});
            return;
        }
        mAjax[url] = true;
        errorFn = errorFn || function(flag){
                if(flag){
                    //$.popover({content: '系统繁忙，请重试!'})
                }
            };
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            dataType: dataType || 'json',
            success: function(res){
                mAjax[url] = null;
                if(res.ret==3025){
                    location.href="/";
                }else{
                    fn(res);
                }
            },
            error: function(){
                mAjax[url] = null;
                errorFn(true);
            }
        })
    };

    function getAjaxData(data){
        var params = data || {};
        mAjaxGet('/invest/project/confirm', params, function(res){
            if(res.status){
                //window.location.href='/invest/project/success';
                $('#investSuccess').layer();
            }else{
                model.code = res.code;
                model.jsMsg = res.msg;
            }
        }, 'json');
    }


    var model = avalon.vmodels['investConfirm'];
    if(!model){
        model = avalon.define({
            $id        : 'investConfirm',
            project_id : $('input[name="projectId"]').val(),
            cash       : $('input[name="cash"]').val(),
            cashNew    : $('input[name="cash"]').val(),
            fee        : $('input[name="fee"]').val(),
            _token     : $('input[name="token"]').val(),
            bonus_id   : '0',
            isCheck    : true,
            jsMsg      : '',
            bonus_it   : 0,
            trade_password  : '',
            code       : 0,
            doInvest: function(e){
                if(model.isCheck==false){
                    model.jsMsg = '请同意出借咨询与管理服务协议';
                    return;
                }
                var tradeLength = model.getStrlen(model.trade_password);
                if(!(tradeLength>=6 && tradeLength<=16)){
                    model.jsMsg = '密码格式不正确';
                    return;
                }
                var params = JSON.parse(JSON.stringify(model.$model));
                //console.log(params);
                $(e.target).attr('disabled',true).addClass('disable');
                getAjaxData(params);
            },
            cleanMsg:function(type){
                if(type=='tradePw'){
                    model.jsMsg = '';
                    if(model.code==500){
                        $('#submitBtn').attr('disabled',false).removeClass('disable');
                    }
                }else{
                    if(model.isCheck==false){
                        model.jsMsg = '';
                    }
                }
            },
            getStrlen: function(str){
                var len = 0;
                for (var i=0; i<str.length; i++) {
                  var c = str.charCodeAt(i);
                  if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
                     len++;
                   } else {
                     len+=2;
                   }
                }
                return len;
            },
            changeInterest:function(e){
                var bonusRate = $(e.target).find("option:selected").attr('data-rate');
                bonusRate = bonusRate.split('-');
                var calTarget   = $('input[name="cal"]');
                if(bonusRate[0]=='1'){
                    var bonusMoney = parseInt(bonusRate[1]);
                    var baseRate   = parseFloat($('input[name="rate"]').val());
                    var interestObj = new getProjectInterest(calTarget.attr('data-refund'),bonusMoney,baseRate, calTarget.attr('data-time'),calTarget.attr('data-publish'),calTarget.attr('data-end'));
                    var interestTotal = interestObj.interestTotal;
                    interestTotal = interestTotal.toFixed(2);

                    var investMoney = parseInt($('input[name="cash"]').val());
                    var newMoney = bonusMoney + investMoney;
                    interestObj = new getProjectInterest(calTarget.attr('data-refund'),newMoney,baseRate, calTarget.attr('data-time'),calTarget.attr('data-publish'),calTarget.attr('data-end'));
                    var totalFee = interestObj.interestTotal;
                    totalFee = totalFee.toFixed(2);

                    model.bonus_it = bonusMoney + parseFloat(interestTotal);
                    model.cashNew = parseInt($('input[name="cash"]').val()) + bonusMoney;
                    model.fee  = totalFee;
                }else{
                    var bonusRate     = bonusRate[1];
                    var investMoney   = parseInt($('input[name="cash"]').val());
                    var interestObj   = new getProjectInterest(calTarget.attr('data-refund'),investMoney,bonusRate, calTarget.attr('data-time'),calTarget.attr('data-publish'),calTarget.attr('data-end'));
                    var bonusInterest = interestObj.interestTotal;
                    bonusInterest     = bonusInterest.toFixed(2);
                    var totalFee      = parseFloat($('input[name="fee"]').val()) + parseFloat(bonusInterest);
                    totalFee = totalFee.toFixed(2);

                    model.bonus_it = bonusInterest;
                    model.cashNew  = investMoney;
                    model.fee  = totalFee;
                }
                if(model.code==500){
                    $('#submitBtn').attr('disabled',false).removeClass('disable');
                    model.jsMsg = '';
                }
            }
        });
    }

});


