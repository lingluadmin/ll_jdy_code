/**
 * Created by scofie on 2017/10/26.
 */
/**
 * Created by alpha on 2017/9/12.
 */
$(function(){
    avalon.config({
        interpolate: ["{%","%}"]
        //debug:false
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
        var param = {'ver':(new Date()).getTime()};
        mAjax('/activity/doubleEleven/asyncData', param, function(res){
            model.projectList   =  res.projectList;
            model.rankList      =  res.rankList;
        }, 'json');
    }
    var model = avalon.vmodels['activityHome'];
    if(!model){
        model = avalon.define({
            $id  : 'activityHome',
            projectList:{},
            rankList:{},
            toProjectDetail:function (id) {
                if( !id ){
                    return false;
                }
                RedirectUrl=   '/project/detail/' + id;
                window.location.href=RedirectUrl;
            }
        });
    }
    getAjaxData();
});

