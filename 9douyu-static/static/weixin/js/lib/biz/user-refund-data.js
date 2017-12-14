/**
 * Created by jinzhuotao on 2017/9/21.
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

    function getAjaxData(page,year,month){
        var param = {
            'ver':(new Date()).getTime(),
            'page':page,
            'year':year,
            'month':month
        };
        // console.log(param);
        mAjax('/refund/calendar/ajax', param, function(res){
            // console.log(res)
            if(res && res.ret===0){
                refundList = refundList.concat(res.data.list.data);
                // console.log(refundList)
                model.refund = refundList;
                model.pager++;
                model.year  = year;
                model.month = month;
                $('.v4-load-more').hide();
            }else{
                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }

    var refundList = [];
    var year = $("#year").val();
    var month = $("#month").val();
    var model = avalon.vmodels['refundMonth'];
    if(!model){
        model = avalon.define({
            $id  : 'refundMonth',
            refund : [],
            total   : 0,
            pager   : 1,
            changeTab:function(e){
                model.currentTab = $(e.target).attr('data-tab');
            },
            swipeUp:function(){
                $('.v4-load-more').show();
                getAjaxData(model.pager,model.year,model.month);
            },
        });
    }

    getAjaxData(1,year,month);
});

