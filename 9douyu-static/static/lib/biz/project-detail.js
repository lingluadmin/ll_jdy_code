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
            type: 'get',
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

    function getAjaxData(projectId){
        var data = {'ver':new Date().getTime()};
        mAjaxGet('/project/getDetail/'+projectId, data, function(res){
            if(res && res.ret==0){
                modelBottom.isLoad = 1;
                modelBottom.extra  = res.data;
                modelBottom.planCount = res.data.Plan.length;
                modelBottom.investCount = res.data.investList.length;
                modelBottom.pager = res.data.pager;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }

    //项目详情债权列表信息
    function getCreditList(url) {

        mAjaxGet(url, {}, function (res) {
            if(res && res.ret==0){
                modelBottom.isLoad = 1;
                modelBottom.credit.creditList=res.data.creditList;
                modelBottom.creditCount=res.data.creditCount;
                modelBottom.pager1=res.data.pager;
            }else{

            }
        },'json');
    }

    function getInvestList(url){
        mAjaxGet(url, {}, function(res){
            if(res && res.ret==0){
                modelBottom.extra.investList  = res.data.investList;
                modelBottom.isLoad = 1;
                modelBottom.pager = res.data.pager;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }


    var modelRight  = avalon.vmodels['projectDetailRight'];
    if(!modelRight){
        modelRight = avalon.define({
            $id        : 'projectDetailRight',
            //investMoney: 100,
            cleanMsg   : function(e){
                $('#showMsg').html('');
            },
            investAll   :function(e){
                var userId     = parseInt($(e.target).attr('data-user-id'));
                var finalMoney = 0;
                if(userId>0){
                    var userBalance  = parseFloat($(e.target).attr('data-user-balance'));
                    userBalance = Math.floor(userBalance);
                    var investLeftMoney = parseInt($('#investMoney').attr('data-left-value'));
                    if(userBalance >= investLeftMoney){
                        finalMoney = investLeftMoney;
                    }else{
                        if((investLeftMoney-userBalance)>=100){
                            finalMoney = userBalance;
                        }else{
                            finalMoney =investLeftMoney-100;
                        }
                    }
                }else{
                    finalMoney = 1000;
                }

                $('#investMoney').val(finalMoney);
                var calTarget = $('#calculator');
                var interestObj = new getProjectInterest(calTarget.attr('data-refund'),finalMoney,calTarget.attr('data-rate'),
                    calTarget.attr('data-time'),calTarget.attr('data-publish'),calTarget.attr('data-end'));
                var interestTotal = interestObj.interestTotal;
                interestTotal = interestTotal.toFixed(2);
                $('#interestTotal').html(interestTotal);
            },
            checkInvest: function(e){
                var userId = $(e.target).attr('data-user-id');
                var userBalance = parseFloat($(e.target).attr('data-user-balance'));
                var smartInvestType = parseFloat($(e.target).attr('smart_invest_type'));
                userBalance = Math.floor(userBalance);
                if(userId>0){
                    var investMoney = 0;
                    if($('#investMoney').val()==''){
                        $('#showMsg').html('请输入投资金额');
                        return;
                    }else{
                        investMoney = parseInt($('#investMoney').val());
                    }
                    var investLeftMoney = parseInt($('#investMoney').attr('data-left-value'));
                    /*
                    if(userBalance < investMoney){
                        $('#showMsg').html('账户余额不足');
                        return;
                    }
                    */

                    //判断是否智投计划
                    if (smartInvestType == 1) {
                        if(investMoney < 1000){
                            $('#showMsg').html('1000元起投');
                            return;
                        }

                        if (investMoney % 100 != 0) {
                            $('#showMsg').html('投资金额必须是100整数倍');
                            return;
                        }
                    } else {
                        if(investMoney < 100){
                            $('#showMsg').html('起投金额必须大于等于100');
                            return;
                        }
                    }

                    if(investMoney > investLeftMoney){
                        $('#showMsg').html('投资金额超出项目剩余可投金额');
                        return;
                    }
                    if((investLeftMoney-investMoney)>0 && (investLeftMoney-investMoney)<100){
                        $('#showMsg').html('投资金额有误');
                        return;
                    }
                    $('#formInvestMoney').val(investMoney);
                    $('#investForm').submit();
                }else{
                    window.location.href="/login";
                }
            },
            checkMoney:function(e){
                var investMoney = e.target.value;
                if(!investMoney.match(/^[1-9]\d*$/)){
                    if(investMoney==0){
                        e.target.value = '';
                    }else{
                        var realMoney  = investMoney.replace(/[^\d]/g,'');
                        e.target.value = realMoney;
                        investMoney = realMoney;
                    }
                }
                var investLeftMoney = parseInt($('#investMoney').attr('data-left-value'));
                if(investMoney > investLeftMoney ){
                    e.target.value = investLeftMoney;
                    investMoney = investLeftMoney;
                }
                var calTarget = $('#calculator');
                var interestObj = new getProjectInterest(calTarget.attr('data-refund'),investMoney,calTarget.attr('data-rate'),
                    calTarget.attr('data-time'),calTarget.attr('data-publish'),calTarget.attr('data-end'));
                var interestTotal = interestObj.interestTotal;
                interestTotal = interestTotal.toFixed(2);
                $('#interestTotal').html(interestTotal);

            },
        });
    }



    var modelBottom = avalon.vmodels['projectDetailBottom'];
    if(!modelBottom){
        modelBottom = avalon.define({
            $id       :  'projectDetailBottom',
            tabId     :   1,
            isLoad    :   0,
            extra     :   {},
            credit:  {'creditList': []},
            planCount :   0,
            investCount:  0,
            creditCount:  0,
            pager     :   {},
            pager1     :   {},
            changeTab:function(e){
                var currentId = $(e.target).attr('data-tab-id');
                modelBottom.tabId = parseInt(currentId);
                var projectId = $('#projectId').val();
                var projectNo = $('#projectNo').val();
                if(currentId==3 || currentId==4 || currentId ==5){
                    if(modelBottom.isLoad==0){
                        getAjaxData(projectId);
                        getCreditList('/smartInvest/project/credit/'+projectNo+'/1');
                    }
                }
            },
            getInvestData:function(e){
                 var url = $(e.target).attr('data-url');
                getInvestList(url);
            },
            getCredit:function (e) {
                var url = $(e.target).attr('data-url');
                getCreditList(url)
            }
        });
    }

});


