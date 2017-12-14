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
                if(res.code=='302'){
                    location.href="/login";
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

    function getAjaxData(url,type){
        var param = {'ver':(new Date()).getTime()};
        mAjax(url, {}, function(res){
            if(res && res.ret===0){
                if(type=='common'){
                    model.firstList = res.data.list;
                    model.firstPager = res.data.pager;
                    model.firstCurrentPage = res.data.pager.current_page;
                }else{
                    model.secondList = res.data.list;
                    model.secondPager = res.data.pager;
                    model.secondCurrentPage = res.data.pager.current_page;
                }
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }

    function getCommonInvestingData(){
        getAjaxData('/user/ajaxCommonInvestList/'+model.firstTabRepayType+"/"+model.firstTabRepayStatus+"/"+model.firstCurrentPage,'common');
    }


    function getSmartInvestingData(){
        getAjaxData('/user/ajaxSmartInvestList/'+model.secondTabRepayStatus+"/"+model.secondCurrentPage,'smart');
    }

    var model = avalon.vmodels['investList'];
    if(!model){
        model = avalon.define({
            $id  : 'investList',
            currentTab : 1,
            firstTabRepayType:'all',
            firstTabRepayStatus:'all',
            secondTabRepayStatus:'all',
            firstList:[],
            firstPager:{},
            firstCurrentPage:1,
            secondList:[],
            secondPager:{},
            secondCurrentPage:1,
            changeMenuTab:function(tid){
                if(this.currentTab != tid){
                    this.currentTab = tid;
                    if(this.currentTab==2){
                        if(this.secondList.length==0){
                            getSmartInvestingData();
                        }
                    }
                }
            },
            changeFirstTab:function(type,status){
                this.firstTabRepayType = type;
                this.firstTabRepayStatus = status;
                this.firstCurrentPage = 1;
                console.log(type+'==='+status);
                getCommonInvestingData();
            },
            changeSecondTab:function(status){
                this.secondTabRepayStatus = status;
                this.secondCurrentPage = 1;
                console.log(status);
                getSmartInvestingData();
            },
            getInvestData:function(e){
                var url = $(e.target).attr('data-url');
                getAjaxData(url,'common');
            },
            getSmartInvestData:function(e){
                var url = $(e.target).attr('data-url');
                getAjaxData(url,'smart');
            }
        });
    }
    getCommonInvestingData();
});

