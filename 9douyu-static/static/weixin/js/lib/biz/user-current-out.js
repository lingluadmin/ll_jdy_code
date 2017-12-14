/**
 * Created by jinzhuotao on 2017/11/8.
 */
$(function(){
    avalon.config({
        interpolate: ['{%','%}']
    });
    function doAjax(data){
        var params = data || {};
        $.ajax({
            url: '/invest/current/doCurrentOut',
            type: 'post',
            data: params,
            dataType: 'json',
            success: function(res){
                if(res.status && res.code==200){
                    $('#v5-pop').css('display','block');
                }else{
                    model.ajaxMsg  = res.msg;
                }
                $('#doInvestOut').attr('disabled',false).removeClass('disabled');
            },
            error: function(){
                model.ajaxMsg  = '未知错误';
            }
        })
    };
    var model    = avalon.vmodels['investOutConfirm'];
    model = avalon.define({
        $id         : 'investOutConfirm',
        ajaxMsg     : '',
        doInvestOut : function(e){
            $(e.target).attr('disabled',true).addClass('disabled');
            var params = {
                _token     : $('input[name="_token"]').val(),
                cash       : $('input[name="cashInput"]').val(),
            };
            $(e.target).attr('disabled',true).addClass('disabled');
            doAjax(params);
        },
        checkMoney:function(e){
            var investOutMoneyStr = e.target.value;
            var maxMoney = $('input[name="investOutMax"]').val();       //最大可转出金额
            var currentCash = $('input[name="currentCash"]').val();     //持有金额
            var lastMoney = 0;
            var isFloatFlag = false;
            var floatNum = 0;

            investOutMoneyStr  = investOutMoneyStr.replace(/[^\d.]/g,"").replace(/\.{2,}/g, ".");
            var investOutMoney = '';
            if(investOutMoneyStr.length>0 && investOutMoneyStr!='.'){
                if(investOutMoneyStr.indexOf(".")>0){
                    investOutMoney = investOutMoneyStr.substring(0,investOutMoneyStr.indexOf(".") + 3);
                    floatNum = investOutMoneyStr.substring(investOutMoneyStr.indexOf(".")+1);
                    isFloatFlag = true;
                }else{
                    investOutMoney = parseInt(investOutMoneyStr);
                }
            }

            if(isFloatFlag && floatNum==0){
                e.target.value = investOutMoney;
            }else{
                lastMoney = Math.min.apply(Math, [investOutMoney,maxMoney,currentCash]);
                e.target.value = lastMoney;
            }

        },
        jumpToCurrent:function(e){
            location.href='/current';
        }
    });
    var ua = navigator.userAgent;
    var isiOS = !!ua.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    if(isiOS){
        document.getElementById('cashInput').addEventListener('input', function(e){
            model.checkMoney(e);
        });
    }
});
