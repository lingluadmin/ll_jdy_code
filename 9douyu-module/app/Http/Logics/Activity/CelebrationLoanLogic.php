<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 8/30/17
 * Time: 3:14 PM
 */

namespace App\Http\Logics\Activity;


use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Dbs\Bonus\UserBonusDb;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic ;
use App\Http\Logics\Ad\AdLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Tools\ToolArray;

class CelebrationLoanLogic extends ActivityLogic
{


    /**
     * @return array
     * @desc 活动时间点
     */
    public static function setTime()
    {
        $config =   self::config();

        return self::getTime( $config['START_TIME'] , $config['END_TIME'] );
    }

    /**
     * @desc  设置当前活动的act_token
     */
    public static function getActToken()
    {
        return   time() . '_' . self::setActivityEventId() ;
    }

    /**
     * @param $positionId
     * @return mixed
     * @desc get add list
     */
    public static function getAdByPositionId($positionId)
    {
        $adLogic    =   new AdLogic();

        return  $adLogic->getUseAbleListByPositionId ($positionId) ;
    }
    /**
     * @param $userId
     * @param $bonusId
     * @return array
     * @desc 执行红包的领取
     */
    public static function doReceiveBonus($userId,$customValue = 'percentile')
    {
        $userBonusLogic =   new UserBonusLogic();

        $bonusConfig    =   self::setBonus();

        $bonusId        =   $bonusConfig[$customValue];

        return $userBonusLogic->doSendBonusByUserIdWithBonusId($userId,$bonusId);
    }
    /**
     * @param int $userId
     * @param int $bonusId
     * @return array
     * @desc 领取红包的条件判断
     */
    public static function isCanReceiveBonusTimes($userId = 0,$customValue = 'ten')
    {
        if( empty($userId) || $userId ==0 ){

            return self::callError('您还没有登录,请登录后后领取' ,self::CODE_ERROR, ['code'=>'login']);
        }
        $config         =   self::config();

        $startTime      =   $config['START_TIME'];

        $nowTime        =   time();

        if( $nowTime < $startTime ){

            return self::callError("领取红包在".date('m.d',$startTime)."号准时开启!<br/>敬请期待!", self::CODE_ERROR, ['code'=>'warning'] );
        }

        $endTime        =   $config['END_TIME'];

        if( $nowTime > $endTime ){

            return self::callError("领取红包活动已经结束!<br/>谢谢参与!", self::CODE_ERROR, ['code'=>'warning'] );
        }

        return self::callSuccess ();
    }

    /**
     * @param $userId
     * @param $bonusId
     * @return array
     * @desc 判断是否可以领取红包
     */
    public static function isCanReceiveBonus($userId ,$customValue='ten')
    {
        $bonusConfig    =   self::setBonus();

        if( !isset($bonusConfig[$customValue]) || empty($bonusConfig[$customValue])){

            return self::callError("红包信息错误,请确认后领取!", self::CODE_ERROR,  ['code'=>'warning'] );
        }

        $userBonusTotalArr  =   self::setUserReceiveBonusTotal($userId);

        if( array_sum($userBonusTotalArr) >= self::getMaxBonusNumber() ){

            $errorMsg       =   '只可以领取一张红包,谢谢参与' ;

            if( self::setEveryDayReceiveStatus () == true ) {

                $errorMsg   =   '每天只可以领取一张,谢谢参与' ;
            }

            return self::callError($errorMsg, self::CODE_ERROR,  ['code'=>'warning'] );
        }

        return self::callSuccess();
    }
    /**
     * @param int $userId
     * @return array
     * @desc 红包的领取数据
     */
    protected static function setUserReceiveBonusTotal($userId = 0)
    {
        $bonusParam =   self::setBonus();

        $config         =   self::config();

        $userBonusDb=   new UserBonusDb();

        $betweenTime    =   self::setReceiveBetweenTime( $config['START_TIME'] , $config['END_TIME'] ,$config['DRAW_CYCLE']);

        return self::setFormatUserBonusTotal($userBonusDb->getUserBonusUsedTotal($betweenTime['start'],$betweenTime['end'],$bonusParam,$userId));
    }

    /**
     * @param array $totalList
     * @return array
     * @desc 格式化红包的数量
     */
    protected static function setFormatUserBonusTotal($totalList = array() )
    {
        $bonusParam =   self::setBonus();

        $formatBonusTotal   =   [];

        $totalList  =   ToolArray::arrayToKey($totalList,'bonus_id');

        foreach ($bonusParam as $key => $bonusId ){

            $formatBonusTotal[$bonusId] =   isset($totalList[$bonusId]) ? $totalList[$bonusId]['total'] : 0;
        }

        return $formatBonusTotal;
    }
    /**
     * @return array
     * @desc  活动红包的数据
     */
    public static function setBonus()
    {
        $config     =   self::config();

        $bonusArr   =   explode('|',$config['BONUS_CONFIG']);

        $returnArr  =   [];

        if( !empty($bonusArr) ){

            $bonusArr   =   array_filter($bonusArr);

            foreach ($bonusArr as $key => $bonusStr ){

                $bonusRes       =    explode('=',$bonusStr);

                $returnArr[$bonusRes[0]] = trim($bonusRes[1]);
            }
        }

        return $returnArr;
    }
    /**
     * @return bool
     * @desc 周期内领取的次数
     */
    protected static function getMaxBonusNumber()
    {
        $config     =   self::config();

        return isset($config['DRAW_NUMBER']) ? $config['DRAW_NUMBER'] : 1 ;
    }
    /**
     * @return bool
     * @desc 是否每天都可以领取
     */
    protected static function setEveryDayReceiveStatus()
    {
        $config     =   self::config();

        return  isset($config['DRAW_CYCLE']) ? $config['DRAW_CYCLE']: false;
    }
    /**
     * @return int
     * @DESC 活动的唯一性标示
     */
    protected static function setActivityEventId()
    {
        return ActivityFundHistoryDb::SOURCE_ACTIVITY_SEVEN_LOTTERY ;
    }
    /**
     * @return array
     * @desc get config
     */
    protected static function config()
    {
        return AnalysisConfigLogic::make ('ACTIVITY_LOAN_BONUS_CONFIG') ;
    }
}