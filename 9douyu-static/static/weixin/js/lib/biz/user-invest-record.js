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

    function getInvestDetailData(investId){
        var param = {'investId':investId};
        mAjax('/user/getInvestDetail', param, function(res){
            if(res && res.ret===0){
                if( res.data.status == true ){
                    model.investDetail  = res.data.data;
                    model.refundList    = res.data.data.refund_list;
                    console.log(model.investDetail)
                }
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }

    var model = avalon.vmodels['investRecordDetail'];
    if(!model){
        model = avalon.define({
            $id  : 'investRecordDetail',
            investId  : $('#investRecordId').val(),
            investDetail:[],
            refundList  :[],
        });

        getInvestDetailData(model.investId);
    }


});

