/**
 * Created by alpha on 17/09/30.
 * Date: 17/10/10
 * Desc: 计算器
 */
$(function(){
    avalon.config({
        interpolate: ['{%','%}'],
    });
    var model = avalon.vmodels['calculatorCtl'];
    if(!model){
        model = avalon.define({
            $id  :  'calculatorCtl',
            cash :  1000,
            times:  3,
            unit :  'month',
            inter:  11,
            type :  'onlyInterest',
            endDate: new Date()-0,
            curDate: new Date()-0,
            plan : [],
            rest : 0,
            checkInput:function(e,type){
                var val     = e.target.value;
                var realVal = val;
                if(!val.match(/^[1-9]\d*$/)){
                    if(val==0){
                        e.target.value = '';
                        return;
                    }else{
                        realVal  = val.replace(/[^\d]/g,'');
                    }
                }
                if(type=='time'){
                    if(model.unit=='month'){
                        realVal = Math.min(realVal,36);
                    }else{
                        realVal = Math.min(realVal,36*30);
                    }

                }else{
                    realVal = Math.min(realVal,9999999);
                }
                e.target.value = realVal;
                this.genInterest();
            },
            changeEndDate:function(){
                var tempDate = new Date();
                var newDate  = new Date();
                if(model.unit=='month'){
                    var newMonth = tempDate.getMonth() + parseInt(model.times);
                    var t1 = 11 - tempDate.getMonth();
                    if(t1 < model.times){
                        var t2 = parseInt(model.times)-t1;
                        var t3 = t2%12;
                        if(t3 == 0){
                            t3=12;
                        }
                        var y1 = Math.ceil(t2/12);
                        var y2 = tempDate.getFullYear()+y1;
                    }else{
                        var t3 = newMonth+1;
                        var y2 = tempDate.getFullYear();
                    }
                    newDate.setMonth(t3-1);
                    newDate.setYear(y2);
                }else{
                    var a = tempDate - 0;
                    a = a + model.times * 24 * 60 * 60 * 1000;
                    newDate = new Date(a);
                }
                model.endDate = newDate-0;
            },
            checkInter:function(e){
                var val     = e.target.value;
                var realVal = val;
                if(!val.match(/^[1-9](\d|\.)*$/)){
                    if(val==0){
                        e.target.value = '';
                        return;
                    }else{
                        realVal  = val.replace(/[^\d.]/g,'');
                    }
                }
                if(!realVal.match(/\.$/)){
                    realVal = Math.min(realVal,100);
                }
                e.target.value = realVal;
                this.genInterest();
            },
            changeType:function(e){
                model.type = e;
                if(model.type=='baseInterest'){
                    model.unit = 'day';
                    model.times = 30;
                }else{
                    model.unit = 'month';
                    model.times = 3;
                }
                this.genInterest();
            },
            genInterest:function(){
                this.changeEndDate();
                var curDate = $('#curDate').html();
                var endDate = $('#endDate').html();
                var interestObj = new getProjectInterest(model.type,model.cash,model.inter, model.times,curDate,endDate);
                var interestTotal = interestObj.interestTotal;
                interestTotal = interestObj.toFixed(interestTotal,2);
                model.rest = interestTotal;
                if(model.type=='onlyInterest'){
                    var averageInterest = interestTotal/model.times;
                    var p = {};
                    model.plan = [];
                    for(var i=1;i<=model.times;i++){
                         if(i==model.times){
                             p = {'time':i,'times':model.times,'interest':averageInterest,'capital':model.cash,'total':(parseInt(model.cash)+averageInterest)};
                         }else{
                             p = {'time':i,'times':model.times,'interest':averageInterest,'capital':0,'total':averageInterest};
                         }
                         model.plan.push(p);
                    }
                }else if(model.type=='equalInterest'){
                    var refundList = interestObj.refundList;
                    model.plan = [];
                    var p = {};
                    for(var i=0;i<model.times;i++){
                        p = {'time':i+1,'times':model.times,'interest':refundList[i]['interest'],'capital':refundList[i]['principal'],'total':refundList[i]['cash']};
                        model.plan.push(p);
                    }
                }else{
                    model.plan = [];
                    var p = {'time':1,'times':1,'interest':interestTotal,'capital':model.cash,'total':(parseInt(model.cash)+interestTotal)};
                    model.plan.push(p);
                }
            },
            restParam:function(){
                model.cash  = 1000;
                model.times = 3;
                model.unit  = 'month';
                model.inter = 11;
                model.type  = 'onlyInterest';
                model.endDate = new Date()-0;
                this.genInterest();
            }
        });
    }
    setTimeout(function(){
        model.genInterest();
    },500);
});

