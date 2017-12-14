<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/11/8
 * Time: 13:55
 */

namespace App\Http\Logics\Activity;


use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Dbs\Activity\LotteryConfigDb;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic;
use App\Tools\ToolStr;

class InsideLotteryLogic extends ActivityLogic
{
    protected $config , $activityTime;

    public function __construct ()
    {
        $this->config   =   $this->config();

        $this->activityTime =   $this->setActivityTime ();
    }

    /**
     * @param $userId
     * @return array
     * @desc 执行抽奖
     */
    public function doLuckDraw($userId)
    {
        $lotteryLogic   =   new LotteryLogic();


        $lottery        =   [
            'activity_id'   =>  $this->setEventId() ,
            'group_id'      =>  $this->getGroupId () ,
            'user_id'       =>  $userId ,
        ];

        return  $lotteryLogic->doLuckDrawWithRateUseSign ($lottery);
    }

    /**
     * @return array
     * @desc 中奖记录
     */
    public function getLotteryList()
    {
        $lotteryList    =    parent::setCouponWinningList ($this->activityTime['start'], $this->activityTime['end'],$this->setEventId() ) ;

        $formatList     =   [];

        if( !empty($lotteryList['list']) ) {
            foreach ($lotteryList['list'] as  $key => $record ) {
                if($record['type'] != LotteryConfigDb::LOTTERY_TYPE_EMPTY){
                    $record['format_phone']    =   ToolStr::hidePhone ($record['phone'] ,3,4);
                    $formatList[]   = $record;
                }
            }
        }
        return $formatList ;
    }


    /**
     * @param $userId
     * @return array
     * @desc 判断用户和活动状态
     */
    public function validActivityStatus($userId)
    {
        return parent::isCanJoinActivity($this->activityTime['start'], $this->activityTime['end'], $this->setEventId() ,$userId);
    }

    /**
     * @note validUserInsideLotteryTimes valid user can lottery by lottery times
     * @param $userId
     * @return array
     * @desc valid user lottery times in this activity left times can lottery
     */
    public function validUserInsideLotteryTimes($userId)
    {

        if( $this->isLotteryOnlyInsideUser($userId) == true){
            return self::callError('本活动不对外开放',self::CODE_ERROR,[ 'type'=>'notLottery' ] );
        }
        $userLotteryTimes   =   $this->getUserLotteryInfo($this->activityTime['start'], $this->activityTime['end'], $this->setEventId (), $userId) ;

        if( $userLotteryTimes >= $this->insideLotteryTimes () ) {
            return self::callError('已经参加过抽奖',self::CODE_ERROR,[ 'type'=>'notLottery' ] );
        }

        return self::callSuccess ();
    }

    public function doLottery( $userId )
    {
        return  $this->doLotteryDraw( $userId, $this->getGroupId (), $this->setEventId ()) ;
    }
    /**
     * @desc 设置活动的时间
     * @return array
     */
    public  function setActivityTime()
    {
        return self::getTime($this->config['START_TIME'], $this->config['END_TIME']);
    }

    /**
     * @desc  设置当前活动的act_token
     */
    public function getActToken()
    {
        return   time() . '_' . self::setEventId() ;
    }

    /**
     * @note  this function is protected
     * @return int|mixed
     * @desc set inside lottery for every user max lottery times
     */
    protected function insideLotteryTimes()
    {
        return  isset( $this->config['INSIDE_LOTTERY_TIMES']) && !empty($this->config['INSIDE_LOTTERY_TIMES']) ? $this->config['INSIDE_LOTTERY_TIMES'] : 1 ;
    }

    /**
     * @param $userId
     * @return bool
     * @desc 用来断定抽奖的用户群组
     */
    protected function isLotteryOnlyInsideUser($userId)
    {
        $userGroup  =   $this->insideUserGroup() ;

        if( $this->isLotteryInsideUser() == true && !in_array ($userId, $userGroup)) {

            return true ;
        }

        return false ;
    }


    /**
     * @return bool
     * @desc 限制抽奖的用户组是否只使用内部员工
     */
    protected function isLotteryInsideUser()
    {
        if( isset($this->config['IS_LOTTERY_BY_INSIDE']) && (int)$this->config['IS_LOTTERY_BY_INSIDE'] == '1') {
            return  true;
        }
        return false;
    }
    /**
     * @return array
     * @desc get can lottery user greoup
     */
    protected function insideUserGroup()
    {
        $userString =   isset($this->config['INSIDE_USER_GROUP']) && !empty($this->config['INSIDE_USER_GROUP']) ? $this->config['INSIDE_USER_GROUP']: '' ;

        if( !empty($userString)) {
            return array_filter (explode (',', $userString) );
        }

        return [] ;
    }/**
     * @return int
     * @DESC 活动的唯一性标示
     */
    protected  function setEventId()
    {
        return ActivityFundHistoryDb::SOURCE_ACTIVITY_INSIDE_WK ;
    }

    /**
     * @return int
     * @desc 奖品的组号
     */
    protected function getGroupId()
    {
        return $this->getActivityLotteryGroup ( $this->setEventId () );
    }

    /**
     * @desc 获取双十一活动的配置
     * @return array
     */
    protected static function config()
    {
        return AnalysisConfigLogic::make('INSIDE_WK_LOTTERY_CONFIG');
    }
}
