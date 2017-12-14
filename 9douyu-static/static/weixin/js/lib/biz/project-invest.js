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
        mAjaxGet('/invest/project/doInvest', params, function(res){
            if(res.status && res.code==200){
                $('#v4-pop').hide();
                $('#v5-pop').show();
                setTimeout(function(){
                    window.location.href='/user/asset';
                },700);
            }else{
                model.ajaxMsg  = res.msg;
                model.ajaxCode = res.code;
                model.tradePwd = '';
            }
        }, 'json');
    }


    var model    = avalon.vmodels['investConfirm'];
    var bonusNum = parseInt($('input[name="bonusCount"]').val());
    if(!model){
        model = avalon.define({
            $id        : 'investConfirm',
            cash       : 0,
            fee        : 0,
            addFee     : 0,
            isCheck    : true,
            jsMsg      : '',
            tradePwd   : '',
            ajaxMsg    : '',
            ajaxCode   : 0,
            bonus_id   : '0',
            bonusNum   : bonusNum,
            bonusTxt   : bonusNum>0?'请选择要使用的优惠券':'暂无可用优惠券',
            bonusVis   : 0,
            doInvestCheck: function(e){
                if(model.isCheck==false){
                    model.jsMsg = '请同意出借咨询与管理服务协议';
                    $('#subInvestProject').attr('disabled',true).addClass('disabled');
                    return;
                }
                var investMoneyString = $('#cashInput').val();
                investMoneyString = investMoneyString.replace(/[^\d]/g,'');
                if(investMoneyString.length==0){
                    model.jsMsg = '投资金额有误';
                    $('#subInvestProject').attr('disabled',true).addClass('disabled');
                    return;
                }
                var investMoney = parseInt(investMoneyString);
                var investLeftMoney = parseInt($('input[name="left_amount"]').val());
                var noviceInvestMax = parseInt($('input[name="novice_invest_max"]').val());
                var pledge = parseInt($('input[name="pledge"]').val());

                if(investMoney < 100){
                    model.jsMsg = '最小投资金额为100';
                    $('#subInvestProject').attr('disabled',true).addClass('disabled');
                    return;
                }
                if(pledge == 1 && noviceInvestMax != 0 && investMoney > noviceInvestMax){
                    model.jsMsg = '投资新手专享最高限额'+noviceInvestMax+'元';
                    $('#subInvestProject').attr('disabled',true).addClass('disabled');
                    return;
                }
                if(investMoney > investLeftMoney){
                    model.jsMsg = '投资金额超出项目剩余可投金额';
                    $('#subInvestProject').attr('disabled',true).addClass('disabled');
                    return;
                }
                if((investLeftMoney-investMoney)>0 && (investLeftMoney-investMoney)<100){
                    model.jsMsg = '投资金额有误';
                    $('#subInvestProject').attr('disabled',true).addClass('disabled');
                    return;
                }
                var userBalance = parseInt($('input[name="balance"]').val());
                if(investMoney>userBalance){
                    model.jsMsg = '账户余额不足,请先充值';
                    $('#subInvestProject').attr('disabled',true).addClass('disabled');
                    return;
                }
                var bonusId = model.bonus_id;
                if(bonusId>0){
                    var bonusMin  = $('#bonus_id_'+bonusId).attr('data-min');
                    if(investMoney < bonusMin){
                        model.jsMsg = '投资金额不符合该优惠券使用条件';
                        $('#subInvestProject').attr('disabled',true).addClass('disabled');
                        return;
                    }
                }
                model.cash = investMoney;
                $('#v4-pop').show();
            },
            doInvest: function(e){
                var tradeLength = model.getStrlen(model.tradePwd);
                if(!(tradeLength>=6 && tradeLength<=16)){
                    model.ajaxMsg  = '密码格式不正确';
                    model.ajaxCode = 100;
                    $(e.target).attr('disabled',true).addClass('disabled');
                    return;
                }
                var params = {
                    project_id : $('input[name="projectId"]').val(),
                    _token     : $('input[name="token"]').val(),
                    cash       : model.cash,
                    bonus_id   : model.bonus_id,
                    trade_password  : model.tradePwd,
                };
                $(e.target).attr('disabled',true).addClass('disabled');
                getAjaxData(params);
            },
            cleanMsg:function(type){
                if(type=='tradePwd'){
                    if(model.ajaxCode>0){
                        model.ajaxMsg = '';
                        $('#sub').attr('disabled',false).removeClass('disabled');
                    }
                }else if(type=='agree'){
                    if(model.isCheck==true){
                        model.jsMsg = '';
                        $('#subInvestProject').attr('disabled',false).removeClass('disabled');
                    }
                }else{
                    model.jsMsg = '';
                    $('#subInvestProject').attr('disabled',false).removeClass('disabled');
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
            checkMoney:function(e){
                model.cleanMsg('common');
                var investMoney = e.target.value;
                if(!investMoney.match(/^[1-9]\d*$/)){
                    if(investMoney==0){
                        e.target.value = '';
                    }else{
                        var realMoney  = investMoney.replace(/[^\d]/g,'');
                        realMoney = realMoney.replace(/^0*/,'');
                        e.target.value = realMoney;
                        investMoney = realMoney;
                    }
                }
                var investLeftMoney = parseInt($('input[name="left_amount"]').val());
                if(investMoney > investLeftMoney ){
                    e.target.value = investLeftMoney;
                    investMoney = investLeftMoney;
                }
                investMoney = parseInt(investMoney);
                var calTarget = $('#calculator');
                var interestObj = new getProjectInterest(calTarget.attr('data-refund'),investMoney,calTarget.attr('data-rate'),
                    calTarget.attr('data-time'),calTarget.attr('data-publish'),calTarget.attr('data-end'));
                model.fee = interestObj.interestTotal;
                model.changeInterest();
            },
            changeInterest:function(){
                model.cleanMsg('common');
                var bonusId = model.bonus_id;
                var investMoney = parseInt($('#cashInput').val());
                var calTarget   = $('#calculator');
                var projectRate = parseFloat($('input[name="projectRate"]').val());
                if(bonusId==0){
                    model.addFee = 0;
                }else{
                    var bonusRate = $('#bonus_id_'+bonusId).attr('data-rate');
                    var bonusMin  = $('#bonus_id_'+bonusId).attr('data-min');
                    if(investMoney < bonusMin){
                        model.addFee = 0;
                        return;
                    }
                    bonusRate = bonusRate.split('-');
                    // 1红包  2加息券
                    if(bonusRate[0]=='300'){
                        var bonusMoney = parseInt(bonusRate[1]);
                        var interestObj   = new getProjectInterest(calTarget.attr('data-refund'),bonusMoney,projectRate, calTarget.attr('data-time'),calTarget.attr('data-publish'),calTarget.attr('data-end'));
                        var interestTotal = interestObj.interestTotal;
                        model.addFee = bonusMoney+interestTotal;
                    }else{
                        var bonusRate     = parseFloat(bonusRate[1]);
                        var interestObj   = new getProjectInterest(calTarget.attr('data-refund'),investMoney,bonusRate, calTarget.attr('data-time'),calTarget.attr('data-publish'),calTarget.attr('data-end'));
                        model.addFee = interestObj.interestTotal;
                    }
                }
            },
            closePwInput:function(){
                $('#v4-pop').hide();
                model.ajaxMsg = '';
                model.tradePwd = '';
            },
            chooseBonus:function(){
                if(model.bonusNum>0){
                    model.bonusVis = !model.bonusVis;
                }
            },
            selectBonus:function(id){
                model.bonus_id = id;
                var bonusName  = $('#bonus_id_'+id).attr('data-name');
                model.bonusTxt = bonusName;
                model.changeInterest();
                setTimeout(function(){
                    model.chooseBonus();
                },100);
            }
        });
    }

    //Init the input cash value
    $('#cashInput').val('');

});


