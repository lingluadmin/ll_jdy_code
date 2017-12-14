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

    function getAjaxData(page){
        var param = {'ver':(new Date()).getTime()};
        mAjax('/project/home_more/'+page, param, function(res){
            if(res && res.ret===0){
                projectList = projectList.concat(res.data.list);
                model.project = projectList;
                model.pager++;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }

    var projectList = [];
    var model = avalon.vmodels['projectHome'];
    if(!model){
        model = avalon.define({
            $id  : 'projectHome',
            project : [],
            total   : 0,
            pager   : 1,
            changeTab:function(e){
                model.currentTab = $(e.target).attr('data-tab');
            },
            swipeUp:function(){
                getAjaxData(model.pager);
            },
            swipeDown:function(){
                projectList = [];
                model.pager = 1;
                getAjaxData(1);
            }
        });
    }

    getAjaxData(1);
});

