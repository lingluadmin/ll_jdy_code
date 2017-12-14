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
        mAjax('/activity/winter/asyncData', param, function(res){
            model.projectList   =  res.projectList;
            if( res.package.status == false &&  res.package.data.type =='joined'){
                model.package    =  false;
            } else {
                model.package    =  true;
            }

        }, 'json');
    }
    var model = avalon.vmodels['activityHome'];
    if(!model){
        model = avalon.define({
            $id  : 'activityHome',
            projectList:{},
            package:{},
            doReceivePackage:function () {
                $.ajax({
                    url: '/activity/winter/receive',
                    type: 'post',
                    dataType:'json',
                    data:{'_token':$('#csrf_token').val()},
                    async:false,
                    success: function(res){

                        if(res.status == true){
                           $('.layer1').show();
                        } else if (res.status == false && res.data.type=="notLogged"){
                            $('.layer2').show();
                        } else {
                            $(".layer3").find('.page-pop-text').html("十分抱歉</br>"+res.msg).show();
                            $(".layer3").show();
                        }
                    }

                })
                return false;
            }
        });
    }
    getAjaxData();
});

