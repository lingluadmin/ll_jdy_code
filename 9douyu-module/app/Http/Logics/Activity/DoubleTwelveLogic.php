<?php
/**
 * Created By Vim
 * User: linguanghui
 * Date: 2017/10/18
 * Desc: 2017年-双十一签到及分享活动
 */

namespace App\Http\Logics\Activity;

use App\Http\Dbs\Activity\LotteryConfigDb;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic;
use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Logics\Activity\Statistics\ActivityStatisticsLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Models\Activity\ActivitySignModel;
use App\Http\Models\Activity\ActivityFundHistoryModel;
use App\Http\Models\Activity\AutumnNationModel;
use App\Http\Models\Common\CoreApi\OrderModel;
use App\Http\Dbs\Bonus\BonusDb;
use App\Http\Dbs\Bonus\UserBonusDb;
use App\Http\Models\Common\CoreApi\UserModel;
use App\Lang\LangModel;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Invest\CurrentLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Tools\ToolTime;
use App\Tools\ToolArray;
use App\Tools\ToolStr;
use Log;

class DoubleTwelveLogic extends ActivityLogic
{
    protected  $config ;

    public $activityTime ,$actToken;

    const

        ACTIVITY_CONFIG='DOUBLE_TWELVE_CONFIG', //双十二活动配置key
        END = true;

    public function __construct()
    {
        $this->config       =   $this->config();
        $this->activityTime =   $this->setActivityTime();
        $this->actToken     =   $this->getActToken ();
    }
    /**
     * @return mixed
     * @desc  活动的项目
     */
    public function getProjectList()
    {
        $projectList    =   parent::getProject($this->config['ACTIVITY_PROJECT']) ;
        if( empty($projectList) )  {
            return [] ;
        }

        foreach ($projectList as $key => &$project ) {
            $project['act_token']    =  $this->actToken . "_" . $project['id'] ;
        }

        return $projectList ;
    }

    /**
     * @param $userId
     * @param $bonus
     * @return array
     * @desc 领取红包
     */
    public function doReceiveBonus($userId , $bonus)
    {
        $userBonusLogic =   new UserBonusLogic();

        $bonusConfig    =   $this->setBonusConfig ();
        try {
            //是否登录
            AutumnNationModel::checkUserLogin($userId);
            //是否活动期间内
            AutumnNationModel::checkActivityTime($this->activityTime);

            //判断是否已经领取过当前红包
            $userGetBonus   = $this->getUserBonusList($userId);

            $userBonus      =   array_column ($userGetBonus,'total');

            $bonusId        =   $bonusConfig[$bonus]['bonus'];
            if(empty($bonusId)) {
                return self::callError(LangModel::getLang('ERROR_BONUS_REPEAT_NONE'));
            }
            if ( array_sum($userBonus) >= $this->getEveryDayReceiveNumber() ) {

                return self::callError(LangModel::getLang('ERROR_GET_BONUS_REPEAT'));
            }

            //执行发红包的操作
            $return = $userBonusLogic->doSendBonusByUserIdWithBonusId($userId, $bonusId);

            if ($return['status'] == false) {
                return self::callError($return['msg']);
            }
        } catch(\Exception $e) {
            Log::error(__METHOD__.'Error',['msg' => $e->getMessage(),'code' => $e->getCode()]);

            return self::callError($e->getMessage());
        }

        return self::callSuccess(sprintf(LangModel::getLang('RECEIVE_BONUS_SUCCESS'), $bonus));
    }

    /**
     * @return int|mixed
     * @desc 默认每个周期可以领取的个数
     */
    public function getEveryDayReceiveNumber()
    {
        if( isset($this->config['BONUS_DRAW_NUMBER']) ){
            return $this->config['BONUS_DRAW_NUMBER'] ;
        }
        return 1;
    }
    /**
     * @param $userId
     * @return array
     * @desc 加载页面红包的状态
     */
    public function getUserReceiveBonus($userId)
    {
        $bonusDb        =   new BonusDb();
        $bonusConfig    =   $this->setBonusConfig ();
        $bonusIds       =   array_column($bonusConfig, 'bonus');
        $bonusList      =   array_column($bonusDb->getByIds($bonusIds),null,'id');
        $userBonusList  =   $this->getUserBonusList($userId);
        foreach ($bonusConfig as $key => &$bonus ) {
            if(isset($bonusList[$bonus['bonus']])) {
                if( isset($userBonusList[$bonus['bonus']]) && $userBonusList[$bonus['bonus']] >0 ) {
                    $bonus['receive_status'] = 10;
                }else{
                    $bonus['receive_status'] = 20;
                }

                if($bonusList[$bonus['bonus']]['type'] == BonusDb::TYPE_CASH) {
                    $bonus['position']  =   floor ($bonusList[$bonus['bonus']]['money']);
                    $bonus['unit']      =   '元';
                    $bonus['note']      =   floor ($bonusList[$bonus['bonus']]['money']) . '元红包';
                }else{
                    $bonus['unit']      =   '%';
                    $bonus['position']  =   floor ($bonusList[$bonus['bonus']]['rate']);
                    $bonus['note']      =   floor ($bonusList[$bonus['bonus']]['rate']) . '%加息券';
                }
                $bonus['min_money']     =   floor ($bonusList[$bonus['bonus']]['min_money']);
            }
        }
        return $bonusConfig ;
    }

    /**
     * @param $userId
     * @return array
     * @desc 用户领取红包状态
     */
    public function getUserBonusList($userId)
    {
        $bonusConfig    =   $this->setBonusConfig ();
        $bonusIds       =   array_column($bonusConfig, 'bonus');
        $userBonusDB    =   new UserBonusDb();
        $timeSlot       =   $this->setReceiveBetweenTime ($this->config['START_TIME'], $this->config['END_TIME'],$this->setEveryDayReceiveStatus ());
        $userBonusList  =   [];
        if(!empty($userId) ){
            $userBonusList  =   array_column ($userBonusDB->getUserBonusUsedTotal($timeSlot['start'], $timeSlot['end'], $bonusIds, $userId ),null,'bonus_id') ;
        }

       return $userBonusList;
    }
    /**
     * @return bool
     * @desc 是否每天都可以领取
     */
    protected function setEveryDayReceiveStatus()
    {
        if( isset($this->config['BONUS_DRAW_CYCLE']) && $this->config['BONUS_DRAW_CYCLE'] == true ){

            return true;
        }

        return false;
    }
    /**
     * @return array
     * @desc format activity bonus config
     */
    public function setBonusConfig()
    {
        $bonusConfig = [];

        if (isset($this->config['RECEIVE_BONUS_CONFIG'])){
            $bonusArr = array_filter(explode(';', $this->config['RECEIVE_BONUS_CONFIG']));
            foreach ($bonusArr as $bonus) {
                $arr  = explode('=>', $bonus);
                $bonusConfig[$arr[0]] =['name' =>$arr[0] ,'bonus'=> $arr[1]];
            }
        }

        return $bonusConfig;
    }
    /**
     * @desc 设置活动的时间
     * @return array
     */
    public function setActivityTime()
    {
        return $this->getTime($this->config['START_TIME'], $this->config['END_TIME']);
    }

    /**
     * @return int
     * @DESC 活动的唯一性标示
     */
    protected function setActivityEventId()
    {
        return ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_TWELVE ;
    }

    /**
     * @desc  设置当前活动的act_token
     */
    public function getActToken()
    {
       return   time() . '_' . $this->setActivityEventId() ;
    }

    /**
     * @desc 获取双十一活动的配置
     * @return array
     */
    protected function config()
    {
        return AnalysisConfigLogic::make(self::ACTIVITY_CONFIG);
    }
}
