/**
 * Created by alpha on 2017/9/12.
 */
$(function () {

    avalon.config({
        interpolate: ['{%', '%}']
    });

    window.mAjax = function (url, data, fn, dataType, errorFn) {
        if (mAjax[url]) {
            //$.popover({content: '正在操作中...'});
            return;
        }
        mAjax[url] = true;
        errorFn = errorFn || function (flag) {
                if (flag) {
                    //$.popover({content: '系统繁忙，请重试!'})
                }
            };
        $.ajax({
            url: url,
            type: 'get',
            data: data,
            dataType: dataType || 'json',
            success: function (res) {
                mAjax[url] = null;
                if (res.ret == 3025) {
                    location.href = "/";
                } else {
                    fn(res);
                }
            },
            error: function () {
                mAjax[url] = null;
                errorFn(true);
            }
        })
    };

    function getAjaxData(page) {

        $('.v4-load-more').html('加载中...').show();

        mAjax('/user/record/' + model.type + '?page=' + page, {}, function (res) {
            if (res && res.ret === 0) {
                investList = investList.concat(res.data.list.data);
                model.list = investList;
                model.pager++;

                $('.v4-load-more').hide();
            } else {
                if(parseInt(model.pager)>parseInt(res.data.page))
                {
                    $('.v4-load-more').html('没有更多了...').show();
                }
                setTimeout(function()
                {
                    $('.v4-load-more').html('加载中...').hide();
                },5000);

                //modal({isShowBtns: false, autoFadeOutTimes: 800,content: res ? res.msg : '系统繁忙，请重试！'});
            }
        }, 'json');
    }

    var investList = [];
    var model = avalon.vmodels['fundHistory'];
    if (!model) {
        model = avalon.define({
            $id: 'fundHistory',
            type: $('#fundHistory').attr('valType'),
            list: [],
            total: 0,
            pager: 1,
            swipeUp: function () {
                getAjaxData(model.pager);
            },
            swipeDown: function () {
                investList = [];
                model.pager = 1;
                getAjaxData(1);
            },
            changeM: function () {
                var myM = [];
                $('.v4-record-date').each(function (ind, elm) {
                    var m = $.trim($(elm).text());
                    if ($.inArray(m, myM) != -1) {
                        $(elm).hide();
                    } else {
                        myM.push(m);
                    }
                })
            }
        });
    }


    getAjaxData(1);
});

