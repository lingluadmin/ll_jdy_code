/**
 * Created by alpha on 2017/9/12.
 */
$(function(){
    avalon.config({
        interpolate: ['{%','%}']
    });
    window.mAjax = function(url, data, fn, dataType, errorFn){
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

    function getAjaxData(page,type){
        var param = {'ver':(new Date()).getTime(),'page':page,'holdType':type};

        mAjax('/user/invest/getPreferredItem', param, function(res){

            if(res && res.ret===0){
                investList      = investList.concat(res.data.record);
                model.invest    = investList;
                //if (pager < model.pagerTotal){
                model.pager++;
                $('.v4-load-more').hide();
                if(type == "assignment"){
                    $("#assignment_note").html(res.data.assignment_note)
                    $("#assignment_cash").html(res.data.assignment_cash)
                }else{
                    $("#user_principal_note").html(res.data.user_principal_note)
                    $("#user_principal").html(res.data.user_principal)
                    $("#user_interest_note").html(res.data.user_interest_note)
                    $("#user_interest").html(res.data.user_interest)
                }
                //}
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }
    var holdType    = $("#holdType").val()
    var investList  = [];
    var model = avalon.vmodels['investHome'];
    if(!model){
        model = avalon.define({
            $id     : 'investHome',
            invest  : [],
            total   : 0,
            pager   : 1,
            //pagerTotal:$('#investHomeTotal').attr('invest_total_page') ,
            changeTab:function(e){
                model.currentTab = $(e.target).attr('data-tab');
            },
            swipeUp:function(){
                getAjaxData(model.pager, holdType);
            },
            swipeDown:function(){
                investList  = [];
                model.pager = 1;
                getAjaxData(1,holdType);
            }
        });
    }

    getAjaxData(1, holdType);

});

