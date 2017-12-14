<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 2017/2/21
 * Time: 下午2:36
 */

namespace App\Http\Logics\Activity;


use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Http\Dbs\Bonus\BonusDb;
use App\Http\Dbs\Bonus\UserBonusDb;
use App\Http\Logics\Bonus\BonusLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Tools\ToolArray;
use App\Tools\ToolStr;
use App\Tools\ToolTime;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic;
use Cache;

class CouponLogic extends ActivityLogic
{
    const DEFAULT_GROUP =   18;  //默认的奖品配置

    /*******************************展示数据********************************/

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
     * @return mixed
     * @desc  活动的项目
     */
    public static function getProjectList()
    {

        $config         =   self::config();

        $projectList    =   parent::getProject($config['ACTIVITY_PROJECT']) ;

        if( empty($projectList) )  {
            return [] ;
        }

        foreach ($projectList as $key => &$project ) {

            $project['act_token']    =  self::getActToken () . "_" . $project['id'] ;
        }

        return $projectList ;
    }

    /**
     * @return array
     * @desc 读取奖品的相关数据
     */
    public static function getCouponLottery()
    {
        //$lotteryList    =   self::setCouponLotteryList(self::getActivityLotteryGroup(self::setActivityEventId ()));

        //$lotteryIndex   =   self::setShowLotteryIndex(count($lotteryList));

        //$lotteryInfo    =   isset($lotteryList[$lotteryIndex]) ? $lotteryList[$lotteryIndex] :[];
        $lotteryInfo    =   [] ;
        $config         =   self::config();

        $recordList     =   self::setCouponWinningList($config['START_TIME'] , $config['END_TIME'],self::setActivityEventId ()) ;

        if( !empty($recordList['list']) ) {
            foreach ($recordList['list'] as &$record ) {
                $record['lottery_time'] =   date("m月d日",strtotime($record['created_at'])) ;
                $record['hide_phone']   =   ToolStr::hidePhone ($record['phone'],3,4);
            }
        }

        return ['lottery' => $lotteryInfo,'record' => $recordList ];
    }
    /**
     * @return array|mixed
     * @desc 获取红包的数据
     */
    public static function getBonusList()
    {
        $bonusParam =   self::setBonus();

        $cacheKey   =   md5(json_encode($bonusParam));

        $bonusCacheList= Cache::get($cacheKey);

        if( !empty($bonusCacheList) ){

            return json_decode($bonusCacheList,true);
        }
        $bonusDb    =   new BonusDb();

        $bonusList  =   $bonusDb->getByIds($bonusParam);

        $logic      =   new BonusLogic();

        $bonusFormat=   $logic->doFormatBonusList($bonusList);

        $bonusParam =   array_flip($bonusParam);

        $formatBonus=   [] ;

        foreach ($bonusFormat as $key => &$bonus ){

            $bonus['custom_value'] = $bonusParam[$bonus['id']];

            $formatBonus[$bonusParam[$bonus['id']]] = $bonus;
        }

        Cache::put($cacheKey,json_encode($formatBonus), 10);

        return $formatBonus;
    }

    /*******************************领取红包的位置********************************/

    /**
     * @param $userId
     * @param $bonusId
     * @return array
     * @desc 执行红包的领取
     */
    public static function doReceiveBonus($userId,$customValue = 'one')
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
    public static function isCanReceiveBonus($userId = 0,$customValue = 'ten')
    {
        if( empty($userId) || $userId ==0 ){

            return self::callError('您还没有登录,请登录后后领取');
        }
        $config         =   self::config();

        $startTime      =   $config['START_TIME'];

        $nowTime        =   time();

        if( $nowTime < $startTime ){

            return self::callError("领取红包在".date('m.d',$startTime)."号准时开启!<br/>敬请期待!");
        }

        $endTime        =   $config['END_TIME'];

        if( $nowTime > $endTime ){

            return self::callError("领取红包活动已经结束!<br/>谢谢参与!");
        }

        return self::isCanReceiveBonusTimes($userId,$customValue);
    }

    /**
     * @param $userId
     * @param $bonusId
     * @return array
     * @desc 判断是否可以领取红包
     */
    public static function isCanReceiveBonusTimes($userId ,$customValue='ten')
    {
        $bonusConfig    =   self::setBonus();

        if( !isset($bonusConfig[$customValue]) || empty($bonusConfig[$customValue])){

            return self::callError("红包信息错误,请确认后领取!");
        }

        $bonusId            =   $bonusConfig[$customValue];

        $userBonusTotalArr  =   self::setUserReceiveBonusTotal($userId);

        $maxCanBonusNumber  =   self::getMaxBonusNumber();

        $everyBonusReceive  =   self::everyBonusReceive();

        if($everyBonusReceive == true && array_sum($userBonusTotalArr) >=$maxCanBonusNumber){

            $errorMsg       =   '只可以领取一张红包,谢谢参与' ;
            if( self::setEveryDayReceiveStatus () == true ) {
                $errorMsg   =   '每天只可以领取一张,谢谢参与' ;
            }

            return self::callError($errorMsg);
        }

        if( $userBonusTotalArr[$bonusId] >= $maxCanBonusNumber ){

            return self::callError("您已经领取过该红包,谢谢参与");
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

        $betweenTime    =   self::setReceiveBetweenTime( $config['START_TIME'] , $config['END_TIME'] ,self::setEveryDayReceiveStatus());

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
    /*******************************获取奖品的位置********************************/

    /**
     * @return float|int
     * @desc 获取每天展示的奖品的索引
     */
    protected static function setShowLotteryIndex( $lotteryTotal = 0 )
    {
        if($lotteryTotal == 0){

            return 1;
        }
        $timeArr    =   self::setTime();

        if( time() < $timeArr['start'] ){

            return 1;
        }
        $startTime  =   date('Y-m-d',$timeArr['start']);

        $endTime    =   ToolTime::dbNow();

        if( time() >= $timeArr['end']){

            $endTime=   date('Y-m-d',$timeArr['end']);
        }

        $lotteryIndex=  ToolTime::getDayDiff($startTime,$endTime)+1;

        if( $lotteryIndex <= $lotteryTotal){

            return$lotteryIndex;
        }

        return ($lotteryIndex%$lotteryTotal)+1;
    }
    /*******************************解析配置文件的位置********************************/
    /**
     * @param $version
     * @return bool
     * @desc 判断当前的app版本号是否正常
     */
    public static function isUnUseAppVersion( $version = '' )
    {
        $config =   self::config();

        if( in_array($version,$config['UNUSED_APP_VERSION']) ){

            return false;
        }

        return true;
    }
    /**
     * @return bool
     * @desc 周期内领取的次数
     */
    protected static function everyBonusReceive()
    {
        $config     =   self::config();

        if( $config['EVERY_BONUS_RECEIVE'] == 1 ){

            return true;
        }

        return false;
    }
    /**
     * @return bool
     * @desc 是否每天都可以领取
     */
    protected static function setEveryDayReceiveStatus()
    {
        $config     =   self::config();

        if( $config['IS_EVERY_DAY_RECEIVE'] ==1 ){

            return true;
        }

        return false;
    }
    /**
     * @return int
     * @desc 获取红包的领取的最大次数
     */
    protected static function getMaxBonusNumber()
    {
        $config     =   self::config();

        return isset($config['MAX_RECEIVE_TIMES']) ? (int)$config['MAX_RECEIVE_TIMES'] : 1;
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
     * @return array
     * @desc 所有的包含抽奖活动的标示
     */
    protected static function setActivityEventIdNote()
    {
        return LotteryRecordLogic::getLotteryActivityEventNote();
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
     * @return array|mixed
     * @desc  春风十里活动的配置文件
     */
    private static function config()
    {
        return AnalysisConfigLogic::make('ACTIVITY_COUPON_CONFIG');
    }
}
