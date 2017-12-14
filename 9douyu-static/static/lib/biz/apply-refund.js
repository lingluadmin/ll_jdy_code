/**
 * Created by alpha on 2017/8/16.
 */
$(function(){
    avalon.config({
        interpolate: ['{%','%}']
    });
    var mAjax = [];
    window.mAjaxGet = function(url, data, fn, dataType, errorFn){
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

    function getAjaxData(data){
        var params = data || {};
        mAjaxGet('/smart/invest/doApply', params, function(res){
            console.log(res);
            if(res.status){
                //window.location.href='/invest/project/success';
                $('#investSuccess').layer();
            }else{
                model.code = res.code;
                model.jsMsg = res.msg;
            }
        }, 'json');
    }


    var model = avalon.vmodels['investConfirm'];
    if(!model){
        model = avalon.define({
            $id        : 'investConfirm',
            invest_id  : $('input[name="invest_id"]').val(),
            project_id : $('input[name="project_id"]').val(),
            cash       : $('input[name="cash"]').val(),
            fee        : $('input[name="fee"]').val(),
            _token     : $('input[name="token"]').val(),
            bonus_id   : '0',
            isCheck    : true,
            jsMsg      : '',
            trade_password  : '',
            code       : 0,
            doApply: function(e){
                if(model.isCheck==false){
                    model.jsMsg = '请同意出借咨询与管理服务协议';
                    return;
                }
                var tradeLength = model.getStrlen(model.trade_password);
                if(!(tradeLength>=6 && tradeLength<=16)){
                    model.jsMsg = '密码格式不正确';
                    return;
                }
                var params = JSON.parse(JSON.stringify(model.$model));
                console.log(params);
                $(e.target).attr('disabled',true).addClass('disable');
                getAjaxData(params);
            },
            cleanMsg:function(type){
                if(type=='tradePw'){
                    model.jsMsg = '';
                    if(model.code==500){
                        $('#submitBtn').attr('disabled',false).removeClass('disable');
                    }
                }else{
                    if(model.isCheck==false){
                        model.jsMsg = '';
                    }
                }
            },
            getStrlen: function(str){
                var len = 0;
                for (var i=0; i<str.length; i++) {
                  var c = str.charCodeAt(i);
                  if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
                     len++;
                   } else {
                     len+=2;
                   }
                }
                return len;
            },
        });
    }

});


