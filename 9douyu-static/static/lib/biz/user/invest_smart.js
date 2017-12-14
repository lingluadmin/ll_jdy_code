/**
 * Created by alpha on 2017/8/16.
 */
$(function(){
    avalon.config({
        interpolate: ['{%','%}']
    });
    window.mAjax= function(url, data, fn, dataType, errorFn){
        if(mAjax[url]){
            //$.popover({content: '正在操作中...'});
            return;
        }
        mAjax[url]  = true;
        errorFn = errorFn || function(flag){
                if(flag){
                    //$.popover({content: '系统繁忙，请重试!'})
                }
            };
        $.ajax({
            url:        url,
            type:       'get',
            data:       data,
            dataType:   dataType || 'json',
            success:    function(res){
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

    function getAjaxData(url){
        mAjax(url, { 'record_id': $("#investId").val() }, function(res){
            if(res && res.ret===0){
                //console.log(res.data)
                model.investId  = res.data.investId;
                model.list      = res.data.list;
                model.pager     = res.data.pager;
                model.count     = res.data.count;
                model.investDetail  = res.data.investDetail;
                model.orderInterest = res.data.orderInterest;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }


    var model = avalon.vmodels['InvestSmart'];
    if(!model){
        model = avalon.define({
            $id  :  'InvestSmart',
            page :  1,
            title: '出借详情',
            list : [],
            pager: {},
            count: 1,
            investId:'',
            investDetail:'',
            orderInterest:'',
            getInvestSmartData:function(e){
                var url = $(e.target).attr('data-url');
                getAjaxData(url);
            }
        });
    }

    getAjaxData('/user/invest/smartDetailAjax');

});

