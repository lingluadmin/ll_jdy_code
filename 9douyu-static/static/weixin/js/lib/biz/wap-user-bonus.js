/**
 * Desc:wap优惠券列表
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
            type: 'post',
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

    function getAjaxData(url, type,page){
        mAjax(url, {'page':page, 'type': type, '_token':$('#csrf_token').val()}, function(res){
            if(res && res.ret===0){
              bonusList = bonusList.concat(res.data.list);
              if(type == 1){
                model.list1 = bonusList;
              }else if(type ==2 ){
                model.list2 = bonusList;
              }else if(type==3){
                model.list3 = bonusList;
              }
            if(parseInt(model.pager)>parseInt(res.data.page_total)){
              $("#load-more").html('没有更多了...');
            }
            setTimeout(function(){
                $('#load-more').html('');
            },5000);
            model.pager++;
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }


    var bonusList = [];
    var model = avalon.vmodels['wapBonusList'];
    if(!model){
        model = avalon.define({
            $id  : 'wapBonusList',
            title: '优惠券',
            toggole: 1,
            list1 : [],
            list2 : [],
            list3 : [],
            pager : 1,
            changeTab: function(e){
              var type = parseInt($(e.target).attr('data-tab-id'));
              $('#load-more').html('加载中...');
              model.pager = 1;
              bonusList = [];
              model.toggole = type;
              getAjaxData('/bonus/getAjaxData', type);
            },
            swipeUp: function(){
              $('#load-more').html('加载中...');
              getAjaxData('/bonus/getAjaxData',model.toggole, model.pager);
            },
            swipeDown: function(e){
              model.pager = 1;
              bonusList = [];
              getAjaxData('/bonus/getAjaxData',model.toggole, model.pager);
            },
        });
    }

    getAjaxData('/bonus/getAjaxData', model.toggole, model.pager);
});
