/**
 * Created by liuqiuhui on 2017/8/25.
 * Date: 17/08/22
 * Desc: 用户中心加息券列
 */
/**
 * Created By lgh-dev
 * Date: 17/08/22
 * Desc: 用户中心加息券列表
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

    function getAjaxData(){
        var data = {'page':$("#page").val(), 'q':$("#q").val(),'_token':$('#csrf_token').val()};
        mAjax('/ajax/about/notice', data, function(res){
            //console.log(res);
            if(res && res.ret===0){
                model.list = res.data.list.list;
                model.pager1 = res.data.paginate;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }

    function getAjaxDataRefund(){
        var data = {'page':$("#pages").val(), 'q':'records','_token':$('#csrf_token').val()};
        mAjax('/ajax/about/refund', data, function(res){
            //console.log(res);
            if(res && res.ret===0){
                model.records = res.data.list.list;
                model.pager2 = res.data.paginate;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }


    var model = avalon.vmodels['noticeCtrl'];
    if(!model){
        model = avalon.define({
            $id  :  'noticeCtrl',
            page: 1,
            title: '平台公告',
            list : [],
            records: [],
            p : '',
            pager1:{},
            pager2:{},
            toggole:1,
            changeTab:function(e){
                model.toggole = parseInt($(e.target).attr('data-tab-id'));
            },
            getData:function(e, type){
                var url = $(e.target).attr('data-url');
                var data = {};
                mAjax(url, data, function(res){
                    if(res && res.ret===0){
                        if(type == 2){
                            model.records = res.data.list.list;
                            model.pager2 = res.data.paginate;
                        }else{
                            model.list = res.data.list.list;
                            model.pager1 = res.data.paginate;
                        }
                    }else{
                        //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
                    }
                }, 'json');
            }
        });
    }else{

    }

    getAjaxData();
    getAjaxDataRefund();

});

