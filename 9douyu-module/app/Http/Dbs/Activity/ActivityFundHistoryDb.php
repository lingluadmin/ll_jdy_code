<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/8/3
 * Time: 下午2:42
 * Desc: 活动资金明细
 */

namespace App\Http\Dbs\Activity;

use App\Http\Dbs\JdyDb;

class ActivityFundHistoryDb extends JdyDb{

    protected $table = "activity_fund_history";

    CONST TYPE_IN               = 1;    //增加
    CONST TYPE_OUT              = 2;    //减少

    //来源
    CONST SOURCE_INVITE             = 1;    //邀请
    CONST SOURCE_PARTNER            = 2;    //合伙人
    CONST SOURCE_YIMAFU             = 3;    //一码付
    CONST SOURCE_ADMIN_ADD_BALANCE  = 4;    //后台给用户加扣款

    const
        SOURCE_ACTIVITY         =  100,    //加息奖励  (加息奖励的默认标示)
        SOURCE_ACTIVITY_NATIONAL=  101,     //国庆活动标示
        SOURCE_ACTIVITY_HALLOWEEN=  102,    //万圣节活动
        SOURCE_ACTIVITY_VOTE    =   103,    //蓝筹投票
        SOURCE_ACTIVITY_DOUBLE_FESTIVAL=    104,    //双诞活动
        SOURCE_ACTIVITY_SPRING_FESTIVAL=    105,    //春节活动
        SOURCE_ACTIVITY_SPRING_COUPON  =    106,    //春风十里活动
        SOURCE_ACTIVITY_INVEST_GAME    =    108,        //全面争霸赛
        SOURCE_ACTIVITY_INVEST_MATCH   =    110,        //投资PK活动
        ACTIVITY_SPRING_TOUR_CONFIG    =    109,    //春游活动
        SOURCE_ACTIVITY_LABOR_DAY      =    111,    //五一活动
        SOURCE_ACTIVITY_INVEST_FOURTH  =    112,        //投资pk第四期
        SOURCE_ACTIVITY_MOTHER_DAY     =    117,        //母亲节活动

        SOURCE_ACTIVITY_GRADE_LOTTERY  =    113,    //奖池抽奖（第一波用在周年庆第一趴上）
        SOURCE_ACTIVITY_THIRD_ANNIVERSARY=  114,    //三周年活动 伴手礼的标示
        SOURCE_ACTIVITY_ANNIVERSARY_SECOND= 115,    //周年庆第二趴
        SOURCE_ACTIVITY_ANNIVERSARY_THIRD = 116,    //周年庆第三趴,红包雨的
        SOURCE_ACTIVITY_ANNIVERSARY_THIRD_JNH = 118,    //周年庆第三趴,嘉年华
        SOURCE_ACTIVITY_HONGKONG_DAY    =   119,    //  香港回归20周年活动
        SOURCE_ACTIVITY_INVEST_MATCH_FIVE   =   120,    //看到见的安心活动
        SOURCE_ACTIVITY_JULY            =   121 ,   //夏利不利，畅想七月
        SOURCE_ACTIVITY_GOLD_CHEST      =   122,    //小金库活动
        SOURCE_ACTIVITY_AUTUMN_LOTTERY  =   123,    //立秋活动
        SOURCE_ACTIVITY_SEVEN_LOTTERY   =   124,    //新的七夕活动
        SOURCE_SEVEN_DAT                =  107,     //七夕   (旧的event_id标示)
        SOURCE_FATHER_DAY               =  316,     //父亲节 (旧的event_id标示)
        SOURCE_ACTIVITY_LOAN_BONUS      =   125,    //庆祝小贷活动
        SOURCE_ACTIVITY_NATIONAL_AUTUMN      =   126,    //2017年中秋国庆活动
        SOURCE_ACTIVITY_IPHONE8         =   127,    //Iphone8推广流量活动
        SOURCE_ACTIVITY_DOUBLE_ELEVEN   = 128,  //2017年双十一活动
        SOURCE_ACTIVITY_INSIDE_WK       = 129,  //内部内刊活动
        SOURCE_ACTIVITY_WINTER          = 130,  //内部内刊活动
        SOURCE_ACTIVITY_DOUBLE_TWELVE   = 131,  //2017双十二活动

        END = true;

    /**
     * @param $data
     * @return bool
     * @desc 增加记录
     */
    public function inRecord($data)
    {

        $this->user_id = isset($data['user_id']) ? $data['user_id'] : 0;

        $this->wx_id = isset($data['wx_id']) ? $data['wx_id'] : 0;

        $this->balance_change = $data['balance_change'];

        $this->type = $data['type'];

        $this->source = $data['source'];

        $this->note = isset($data['note']) ? $data['note'] : '';

        return $this->save();

    }

    /**
     * @param $where
     * @param $page
     * @param $pageSize
     * @return array
     * @desc 活动列表
     */
    public function getActivityFundHistoryList($where, $page, $pageSize){

        $start = $this->getLimitStart($page, $pageSize);
        $total = $this->where($where)->count();

        $list = $this->where($where)
            ->skip($start)
            ->take($pageSize)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        return ['list'=>$list,'total'=>$total];

    }

    /**
     * @desc 获取活动加币奖励记录
     * @param $where array
     * @param $activityId int
     * @param $userId int
     * @return array
     */
    public function getActivityAward($where, $activityId, $userId)
    {
        $list = $this->where($where)
            ->where('type', self::TYPE_IN)
            ->where('source', $activityId)
            ->where('user_id', $userId)
            ->get()
            ->toArray();
        return $list;
    }

    /**
     * @desc 设置要查找的字段
     */
    public function setSelectFields()
    {
        $this->_sql_builder =  $this->_sql_builder->select('user_id', 'balance_change', 'type', 'source', 'note');
        return $this;
    }

    /**
     * @desc 按照时间组装时间的条件
     * @param $start 开始时间
     * @param $end 结束时间
     * @return obj
     */
    public function getByDate($start = '', $end = '')
    {
        $this->_sql_builder =  $this->_sql_builder->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end);
        return $this;
    }

    /**
     * @desc  过滤活动资金来源,只保留活动奖励
     * @return Obj
     */
    public function filterActivitySource()
    {
        $this->_sql_builder = $this->_sql_builder->where('source', '>=', self::SOURCE_ADMIN_ADD_BALANCE);

        return $this;
    }

}
