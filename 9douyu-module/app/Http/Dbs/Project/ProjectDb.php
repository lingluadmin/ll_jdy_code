<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/5/23
 * Time: 上午11:25
 * 项目数据类
 */
namespace App\Http\Dbs\Project;

use App\Http\Dbs\JdyDb;

class ProjectDb extends JdyDb{


    const
        //产品线
        PRODUCT_LINE_ONE_MONTH                  = 101,  //九省心一月期
        PRODUCT_LINE_THREE_MONTH                = 103,  //九省心三月期
        PRODUCT_LINE_SIX_MONTH                  = 106,  //九省心六月期
        PRODUCT_LINE_TWELVE_MONTH               = 112,  //九省心十二月期
        PRODUCT_LINE_FACTORING                  = 200,  //保理
        PRODUCT_LINE_LIGHTNING_SIX_MONTH        = 306,  //闪电付息六月期
        PRODUCT_LINE_LIGHTNING_TWELVE_MONTH     = 312,  //闪电付息十二月期
        PRODUCT_LINE_SMART_INVEST               = 400,  //智投计划


        //项目产品线
        PROJECT_PRODUCT_LINE_JSX    = 100,      //九省心
        PROJECT_PRODUCT_LINE_JAX    = 200,      //九安心
        PROJECT_PRODUCT_LINE_SDF    = 300,      //闪电付息
        PROJECT_PRODUCT_LINE_SMI    = 400,      //闪电付息

        //项目期限
        INVEST_TIME_MONTH_THREE     = 3,      //3月期
        INVEST_TIME_MONTH_SIX       = 6,      //6月期
        INVEST_TIME_MONTH_TWELVE    = 12,     //12月期
        INVEST_TIME_DAY_ONE         = 1,      //1月期
        INVEST_TIME_DAY             = 0,      //天

        PROJECT_INVEST_TYPE_CREDIT  = 1,       //定期产品
        PROJECT_INVEST_TYPE_CURRENT = 2,       //零钱计划产品

        REFUND_TYPE_BASE_INTEREST   = 10,       //到期还本息
        REFUND_TYPE_ONLY_INTEREST   = 20,       //按月付息，到期还本
        REFUND_TYPE_FIRST_INTEREST  = 30,       //投资当日付息，到期还本
        REFUND_TYPE_EQUAL_INTEREST  = 40,       //等额本息


        //项目状态
        STATUS_UNAUDITED            = 100,  //未审核
        STATUS_AUDITE_FAIL          = 110,  //未通过
        STATUS_UNPUBLISH            = 120,  //审核通过 未发布

        STATUS_INVESTING            = 130,   //投资中
        STATUS_REFUNDING            = 150,   //还款中
        STATUS_FINISHED             = 160,   //已完结

        STATUS_MATCHING             = 210,   //匹配中

        BEFORE_REFUND               = 1,    //提前还款标志


        //INTEREST_RATE_NOTE          = '借款利率',
        //INTEREST_RATE_NOTE_APP413   = '预期年化收益',
        INTEREST_RATE_NOTE          = '期待年回报率',
        INTEREST_RATE_NOTE_APP413   = '期待年回报率',

        LOAN_CATEGORY_CONSUME       = 1 , //消费贷
        LOAN_CATEGORY_CAR           = 2 , //车抵贷
        LOAN_CATEGORY_HOUSE         = 3 , //房抵贷
        LOAN_CATEGORY_COMPANY       = 4 ,  //企业贷

        LOAN_CATEGORY_TIME_SHORT    = 5,    // 短期项目
        LOAN_CATEGORY_TIME_MIDDLE   = 6,    // 中长期项目
        LOAN_CATEGORY_TIME_LONG     = 7,    // 长期项目

        LOAN_CATEGORY_TIME_SMART    = 8 , //智投计划

        //是否可转让
        CREDIT_ASSIGN_TRUE          = 1 , //可转让
        CREDIT_ASSIGN_FALSE         = 0 , //不可转让

        //不可转让默认天数
        ASSIGN_KEEP_DAYS            = 0,

        //智能出借-项目状态
        SMART_STATUS_INVESTING      = 130,  //募集中
        SMART_STATUS_LOCKING_0      = 150,  //匹配中
        SMART_STATUS_LOCKING_1      = 150,  //锁定中
        SMART_STATUS_FINISHED       = 160,  //已完结

        SMART_INVEST_MATCH_NO       = 0,    // 智能出借-未匹配
        SMART_INVEST_MATCH_YES      = 1,    // 智能出借-已匹配

        SMART_STATUS_NORMAL         = 1,    // 智能出借状态-正常
        SMART_STATUS_REDEMPTION     = 2,    // 智能出借状态-赎回
        SMART_STATUS_FAILURE        = 3,    // 智能出借状态-提前赎回
        SMART_STATUS_UNMATCHED      = 4,    // 智能出借状态-到期未匹配
        SMART_STATUS_MATURES        = 5,    // 智能出借状态-到期已匹配

        RANSOM_STATUS_APPLY         = 100,  // 智能出借-赎回状态-申请中
        RANSOM_STATUS_RANSOMING     = 200,  // 智能出借-赎回状态-赎回中
        RANSOM_STATUS_RANSOMED      = 300,  // 智能出借-赎回状态-已赎回

        END=true;

}