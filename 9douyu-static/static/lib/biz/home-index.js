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
        var param = {'ver':(new Date()).getTime()};
        mAjax(url, param, function(res){
            if(res && res.ret===0){
                model.article = res.data.articleList;
                model.project = res.data.projectList;
                model.noviceProject = res.data.projectList.noviceList;
                statModel.data = res.data.homeStat;
                statModel.user = res.data.userData;
                statModel.view = res.data.viewUser;
                statModel.button = res.data.indexButton;

                var num =new NumerBeat('.data');
                num.init();

                model.counter.len1 = model.project.shortProjectList.length;
                model.counter.len2 = model.project.middleProjectList.length;
                model.counter.len3 = model.project.longProjectList.length;
                model.counter.len4 = model.project.assignProjectList.length;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }
    var model = avalon.vmodels['homeIndex'];
    if(!model){
        model = avalon.define({
            $id  : 'homeIndex',
            article : {},
            project : {},
            noviceProject:{'base_rate':0,'after_rate':0,'status':0,'status_note':'还款中'},
            currentTab : 1,
            counter : {'len1':0,'len2':0,'len3':0,'len4':0},
            changeTab:function(e){
                model.currentTab = $(e.target).attr('data-tab');
            },
            redirectDetail:function (id) {
                if( !id ){
                    return false;
                }
                RedirectUrl=   '/project/detail/' + id;
                window.location.href=RedirectUrl;
            }
        });
    }
    var statModel = avalon.vmodels['headerIndex'];
    if(!statModel){
        statModel = avalon.define({
            $id  : 'headerIndex',
            data : {},
            user : {},
            view : {},
            button:{},
        });
    }
    //Init Data
    getAjaxData('/home/getPacket');
});

