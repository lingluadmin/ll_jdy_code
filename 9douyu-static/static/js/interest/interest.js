/**
 * Created by liuqiuhui on 17/1/6.
 */
(function($){

    /**
     * 初始化信息
     * @param refundType    还款方式
     * @param cash          金额
     * @param profit        利率
     * @param type          期限
     * @param publishTime   发布时间
     * @param endDate       结束时间
     * @returns {*|Array}
     */

    getProjectInterest =  function(refundType, cash, profit, limitTimes, publishTime, endDate){

        this.cash           = cash;             //投资金额
        this.profit         = profit;           //项目利率
        this.limitTimes     = parseInt(limitTimes);       //投资期限,月/天
        this.publish        = this.getDateStr(publishTime.substr(0,10));      //发布时间
        this.endDate        = this.getDateStr(endDate);          //结束时间
        this.refundType     = refundType;       //回款类型
        this.yearDay        = 365;
        this.yearMonth      = 12;
        this.basePercentage = 100;
        this.investTimes    = this.getDateStr('');      //投资日期
        this.interestTotal  = this.init().interestTotal;
        this.refundList     = this.init().refundList;

    };

    getProjectInterest.prototype = {

        /*初始方法*/
        init:function(type){

            var funName = this.refundType;

            var interestObj = this[funName]();

            return interestObj;

        },

        /*调用的方法名称*/
        getFunName:function(){

            var funNameObj = {
                10:'baseInterest',
                20:'onlyInterest',
                30:'firstInterest',
                40:'equalInterest'
            };

            return funNameObj[this.refundType];

        },

        /*到期还本期*/
        baseInterest:function(){

            //投资日期与到期日期相差天数
            var days = this.getDateDiff(this.investTimes, this.endDate, 'day');

            var interestCash = this.getInterestByDay(days);



            return {interestTotal:this.toFixed(interestCash,2), refundList:[]};

        },

        /*投资当日付息,到期还本*/
        firstInterest:function(){

            return this.baseInterest();


        },

        /*先息后本*/
        onlyInterest:function(){

            this.getRefundPlan();

            var interestCash = this.getInterestByMonth();
            var firstRefund=0, refundDate, diffDays, interestTotal=0;
            var limitTimes = this.limitTimes;

            for(var i= 0; i<this.limitTimes; i++){

                refundDate = this.refundPlan[i];

                diffDays   = this.getDateDiff(this.investTimes, refundDate,'day');

                //投资时间大于回款时间节点
                if(diffDays <= 0){
                    limitTimes--;
                    continue;
                }

                firstRefund++; //首次回款

                if(firstRefund == 1){

                    var preMonthDate = (i==0) ? this.publish : this.refundPlan[i-1];

                    var firstInterestCash = this.getFirstMonthInterest(preMonthDate, this.refundPlan[i], interestCash);

                }

                break;

            }

            var interestTotals = interestCash * (limitTimes-1)+firstInterestCash;


            return {interestTotal:this.toFixed(interestTotals,2), refundList:[]};

        },

        /*等额本息*/
        equalInterest:function(){
            var _this = this;

            this.getRefundPlan();

            var firstRefund=0, refundDate, diffDays, interestTotal= 0, i, monthInterest, principalTotal=0;
            var limitTimes = this.limitTimes;

            //统计等额本息利息列表
            for(i=0; i<this.limitTimes; i++){

                refundDate = this.refundPlan[i];

                diffDays   = this.getDateDiff( this.investTimes, this.getDateStr(refundDate.replace(/\-/gm, "/")), 'day');

                if(diffDays <= 0){

                    limitTimes--;

                    continue;

                }

                if(this.profit > 0){
                    //月利率
                    var monthPercent = this.getMonthPercent();
                    //每月还款额
                    var equalCash    = this.getEqualRefundCash(monthPercent);

                    var noEqualCash  = this.getNoEqualRefundCash(monthPercent);
                }

                break;
            }

            var ta = [];

            //统计等额本息利息列表
            for(i=0; i<this.limitTimes; i++){

                refundDate = this.refundPlan[i];

                diffDays   = this.getDateDiff(this.investTimes, refundDate.replace(/\-/g, "/"),'day');

                if(diffDays <= 0){

                    continue;

                }

                firstRefund++; //首次回款

                monthInterest = this.getMonthPercentInterest(monthPercent, noEqualCash, firstRefund);

                principalTotal += (equalCash - this.toFixed( monthInterest, 2));

                //首月利息
                if(firstRefund == 1){

                    var preMonthDate = (i==0) ? this.publish : this.refundPlan[i-1];

                    monthInterest = this.getFirstMonthInterest(preMonthDate, this.refundPlan[i], monthInterest);

                }

                if((this.cash - principalTotal) > -0.05 && i+1==this.limitTimes){
                    monthInterest = monthInterest - (this.cash-principalTotal);
                }

                ta[i] = {
                    principal :  equalCash - monthInterest,
                    interest  :  monthInterest,
                    cash      :  equalCash
                };

                interestTotal += this.toFixed(monthInterest,2);

            }

            return {interestTotal:this.toFixed(interestTotal,2), refundList:ta};

        },

        /**
         * 等额本息月利息
         * @param monthPercent
         * @param equalCash
         * @param refundNum
         * @returns {number}
         */
        getMonthPercentInterest:function(monthPercent, equalCash, refundNum){

            var monthInterest=0;
            //月利息计算
            monthInterest = (this.cash * monthPercent - equalCash) * Math.pow((1+monthPercent),refundNum-1) + equalCash;

            //monthInterest = monthInterest;

            return monthInterest;

        },

        /**
         * desc 月利率
         * @param per
         * @returns {number}
         */
        getMonthPercent:function (){

            return (parseFloat(this.profit)/100)/12;

        },

        /**
         * desc 获取等额本息每个月的还款额
         * @param cash 投资金额
         * @param monthPercent 月利率
         * @param timeLimit 投资期限
         * @returns {*|Number|string}
         */
        getEqualRefundCash:function (monthPercent){

            var baseOne   = this.cash * monthPercent * Math.pow((1+monthPercent), this.limitTimes);
            var baseTwo   = Math.pow((1+monthPercent),this.limitTimes)-1;
            var equalCash = baseOne/baseTwo;

            return this.toFixed(equalCash,2);

        },

        /**
         * desc 获取等额本息每个月的还款额
         * @param cash 投资金额
         * @param monthPercent 月利率
         * @param timeLimit 投资期限
         * @returns {*|Number|string}
         */
        getNoEqualRefundCash:function (monthPercent){

            var baseOne   = this.cash * monthPercent * Math.pow((1+monthPercent), this.limitTimes);
            var baseTwo   = Math.pow((1+monthPercent),this.limitTimes)-1;
            var equalCash = baseOne/baseTwo;

            return equalCash;

        },

        /*首月利息*/
        getFirstMonthInterest:function(preMonthDate, nextMonthDate, interestCash){

            var days 	   = this.getDateDiff(this.investTimes, nextMonthDate.replace(/\-/g, "/"), 'day');

            var diffDay    = this.getDateDiff( preMonthDate.replace(/\-/g, "/"), nextMonthDate.replace(/\-/g, "/"), 'day' );

            return this.toFixed(interestCash * (days / diffDay),2);

        },

        /*根据投资天数，返回利息金额*/
        getInterestByDay:function(days){

            return this.toFixed((this.cash*(this.profit / this.basePercentage ) * days / this.yearDay),2);

        },

        /*根据投资月数,返回利息金额*/
        getInterestByMonth:function(){

            return this.toFixed( this.cash * (this.profit / this.basePercentage ) / this.yearMonth );

        },

        /*获取日期*/
        getDateStr:function(dateStr){

            var myDate = (dateStr == '' || dateStr == '0000-00-00') ?  new Date() : new Date(dateStr);

            return myDate.getFullYear()+'/'+(myDate.getMonth()+1)+'/'+myDate.getDate();

        },

        /**
         * desc 获取回款计划的时间列表
         * @param type
         * @returns {string}
         */
        getRefundPlan:function(){

            var timeArr = [];
            var endTime = '';
            var nextMonthDate = '';

            for(var i= 0; i < this.limitTimes; i++) {

                endTime = this.delMonth(this.endDate, i);

                nextMonthDate = this.getNextMonthDate(this.endDate, this.getDateStr(endTime));

                timeArr.push(nextMonthDate);

            }

            this.refundPlan = timeArr.reverse();
        },

        /**
         * desc: 减少月数
         * @param d
         * @param m
         * @returns {string}
         */
        delMonth:function (d,m){
            var ds=d.split('/');

            d=new Date( ds[0],ds[1]-m-1,ds[2]);
		
	        var dStr = d.toLocaleDateString().replace(/年|月/g, "/").replace(/日/g,"");

            return dStr ;
        },

        /**
         * desc 获取下一个回款日
         * @param startTime
         * @param endTime
         * @returns {*}
         */
        getNextMonthDate:function (startTime, endTime){

            var e=endTime.split('/');

            var s=startTime.split('/');


            if(parseInt(s[2]) != parseInt(e[2])){

                endTime = this.getTheDate(endTime,-parseInt(e[2]));

            }

            return endTime;
        },

        /**
         * desc 获取当前时间加几天或者减几天
         * @param date
         * @param day
         * @returns {string}
         */
        getTheDate:function (date,day){
            //可以加上错误处理
            var a = new Date(date)
                a = a.valueOf()
                a = a + day * 24 * 60 * 60 * 1000
                a = new Date(a);
            var m = a.getMonth() + 1;
            var d = a.getDate();

            return this.getDateStr(a.getFullYear() + "/" + m + "/" + d);

        },

        getDateDiff:function(startTime, endTime, diffType){
            //将xxxx-xx-xx的时间格式，转换为 xxxx/xx/xx的格式
            startTime = startTime.replace(/\-/g, "/");
            endTime   = endTime.replace(/\-/g, "/");
            //将计算间隔类性字符转换为小写
            //diffType  = diffType.toLowerCase();
            var sTime = new Date(startTime);      //开始时间git
            var eTime = new Date(endTime);  //结束时间
            //作为除数的数字
            var divNum = 1;
            switch (diffType) {
                case "second":
                    divNum = 1000;
                    break;
                case "minute":
                    divNum = 1000 * 60;
                    break;
                case "hour":
                    divNum = 1000 * 3600;
                    break;
                case "day":
                    divNum = 1000 * 3600 * 24;
                    break;
                case "month":
                    divNum = 1000 * 3600 * 24 * 30;
                    break;
                default:
                    break;
            }

            var getVal = parseInt((eTime.getTime() - sTime.getTime()) / parseInt(divNum));

            return getVal;
        },
        
        toFixed: function(num, length) {
            num = parseFloat(num);
            if(isNaN(num)) num = 0;
            length = length || 2;
            var numStr = String(num);
            if(numStr.indexOf('.') != -1) {
                var parts = numStr.split('.');
                //强制后缀加1，解决2.555.toFixed(2) = 2.55的问题 2.555 => 2.5551
                if(parts[1].length >= length) {
                    num = parseFloat(numStr + "1");
                    num = num + 0.0000001;
                }
            }
            return parseFloat(num.toFixed(length));
        },

    };

})(jQuery);
