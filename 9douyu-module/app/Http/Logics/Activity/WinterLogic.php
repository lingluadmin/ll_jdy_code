<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/11/20
 * Time: 10:17
 */

namespace App\Http\Logics\Activity;


use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Dbs\Bonus\UserBonusDb;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Models\Common\CoreApi\OrderModel;
use Cache;

class WinterLogic extends ActivityLogic
{
    protected $activityTime, $config;

    const
            DEFAULT_NET_RECHARGE_CASH   =   10000,

            END =   true;



    public function __construct()
    {
        $this->activityTime = self::setActivityTime();
        $this->config = self::config();
    }
    /**
     * @return array
     *  @desc configure the activity valid's time
     */
    public static function setActivityTime()
    {
        $config = self::config();

        return self::getTime($config['START_TIME'], $config['END_TIME']);
    }
    /**
     * @return mixed
     * @desc  configure the activity project join activity
     */
    public static function getProjectList()
    {
        $projectList    =   parent::getProject(self::config()['ACTIVITY_PROJECT']) ;

        if( empty($projectList) )  {
            return [] ;
        }

        foreach ($projectList as $key => &$project ) {

            $project['act_token']    =  self::getActToken () . "_" . $project['id'] ;
        }

        return $projectList ;
    }

    /**
     * @param int $userId
     * @return array
     * @desc valid user be joined the activity's package
     */
    public function validUserPullDownPackage($userId = 0)
    {
        if( empty($userId) ){
            $error      =   '请在登录后参与活动';
            $errorType  =   [ 'type'=>'notLogged' ] ;
            return self::callError($error,self::CODE_ERROR,$errorType );
        }

        $userBonusDb =  new UserBonusDb();

        $betweenTime =  self::setReceiveBetweenTime($this->config['START_TIME'], $this->config['END_TIME'], false);

        $bonusInfo   =  $userBonusDb->getUserBonusUsedTotal($betweenTime['start'], $betweenTime['end'], $this->getNetRechargePackage (), $userId);

        if( !empty($bonusInfo) ) {
            $error      =   '您已经领取过礼包';
            $errorType  =   [ 'type'=>'joined' ] ;
            return self::callError($error,self::CODE_ERROR,$errorType );
        }

        return self::callSuccess ();
    }

    /**
     * @param $userId
     * @return array
     * @desc the login user receive the activity package
     */
    public function doReceivePackage( $userId )
    {

        $isActivity  =   $this->isCanJoinActivity($this->config['START_TIME'], $this->config['END_TIME'],$this->setActivityEventId(), $userId);

        if( $isActivity['status'] == false) {
            return $isActivity;
        }

        $validUsesBonus =   $this->validUserPullDownPackage($userId);

        if($validUsesBonus['status']  == false) {
            return $validUsesBonus ;
        }

        if( $this->getUserNetRechargeCash($userId) < $this->getMinNetRechargeCash() ) {
            $error      =   '净充值金额满'.$this->getMinNetRechargeCash().'才可领取！';
            $errorType  =   [ 'type'=>'recharge' ] ;
           return self::callError ($error, self::CODE_ERROR, $errorType) ;
        }

        $userBonusLogic =   new UserBonusLogic();

        return $userBonusLogic->doSendMoreBonusByUserId($userId, $this->getNetRechargePackage());

    }
    /**
     * @param int $userId
     * @return int
     * @desc read user net recharge cash in the activity's time
     */
    protected function getUserNetRechargeCash( $userId = 0)
    {
        if( empty($userId) ){
            return 0;
        }
        $betweenTime =  self::setReceiveBetweenTime($this->config['START_TIME'], $this->config['END_TIME'], false);

        $param          =   [
            'start_time'    =>  $betweenTime['start'],
            'end_time'      =>  $betweenTime['end'],
            'userId'        =>  $userId,
        ];
        $userOrderInfo  =   OrderModel::getUserNetRecharge($param);

        $rechargeCash   =   isset($userOrderInfo['rechargeCash']) ? $userOrderInfo['rechargeCash'] : 0 ;

        $withdrawCash   =   isset($userOrderInfo['withdrawCash']) ? $userOrderInfo['withdrawCash'] : 0;

        if($rechargeCash > $withdrawCash) {

            return $rechargeCash - $withdrawCash ;
        }

        return 0;
    }
    /**
     * @return array
     * @desc configure the activity's net recharge package's config : every bonusId use ',' implode
     */
    protected function getNetRechargePackage()
    {
        if( isset($this->config['RECHARGE_BONUS_CONFIG']) ) {
            return explode (',', $this->config['RECHARGE_BONUS_CONFIG']);
        }
        return [];
    }
    /**
     * @return int|mixed
     * @desc configure the activity's package min net recharge cash for to lottery package
     */
    protected function getMinNetRechargeCash()
    {
        return isset($this->config['NET_RECHARGE_CASH']) ? $this->config['NET_RECHARGE_CASH'] : self::DEFAULT_NET_RECHARGE_CASH;
    }

    /**
     * @return int
     * @DESC configure the activity unique event id
     */
    protected static function setActivityEventId()
    {
        return ActivityFundHistoryDb::SOURCE_ACTIVITY_WINTER ;
    }

    /**
     * @return string
     * @desc configure the activity unique token by time && activity event id
     */
    public static function getActToken()
    {
        return   time() . '_' . self::setActivityEventId() ;
    }
    /**
     * @desc configure the activity config
     * @return array
     */
    protected static function config()
    {
        return AnalysisConfigLogic::make('ACTIVITY_WINTER_CONFIG');
    }
}
