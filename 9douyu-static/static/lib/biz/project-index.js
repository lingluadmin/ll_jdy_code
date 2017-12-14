/**
 * Created by alpha on 2017/8/16.
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

    function getAjaxData(url){
        mAjax(url, {}, function(res){
            if(res && res.ret===0){
                model.list = res.data.list;
                model.pager = res.data.pager;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }

    //智投计划项目列表
    function getAjaxDataSmart(url){
        mAjax(url, {}, function(res){
            if(res && res.ret===0){
                model.smart_list = res.data.list;
                model.smart_pager = res.data.pager;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }


    var model = avalon.vmodels['projectList'];
    if(!model){
        model = avalon.define({
            $id  :  'projectList',
            page :  1,
            title: {'invest':'优选项目', 'smart': '智投计划', 'debt':'变现专区'},
            list : [],
            smart_list : [],
            pager: {},
            smart_pager: {},
            toggle: 1,
            changeTab:function (e) {
              model.toggle = parseInt($(e.target).attr('data-li-id'));
            },
            getProjectData:function(e){
                var url = $(e.target).attr('data-url');
                getAjaxData(url);
            },
            getProjectSmartData: function(e){
                var url = $(e.target).attr('data-url');
                getAjaxDataSmart(url);
            },
        });
    }
    getAjaxData('/project/list/1');
    getAjaxDataSmart('/project/smartList/1');
});

