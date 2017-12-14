<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 2017/3/24
 * Time: 上午11:36
 */

namespace App\Http\Logics\Activity\Common;

use App\Http\Dbs\OrderDb;
use App\Http\Logics\Activity\LotteryLogic;
use App\Http\Logics\Activity\Statistics\ActivityStatisticsLogic;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Models\Activity\ActivityFundHistoryModel;
use App\Http\Logics\Activity\LotteryConfigLogic;
use App\Http\Logics\Activity\LotteryRecordLogic;
use App\Http\Logics\Logic;
use App\Http\Logics\Ad\AdLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Models\Common\CoreApi\OrderModel;
use App\Http\Models\Activity\ActivityConfigModel;
use App\Tools\ToolArray;
use App\Tools\ToolTime;
use Session;
use Cache,Log;

class ActivityLogic extends Logic
{
    const
            DEFAULT_GROUP   =   1       //默认的奖品分组

            ;
    /**
     * @return array
     * @desc 活动时间点
     */
    protected  static function getTime( $startTime , $endTime )
    {
        return [ 'start'=>$startTime , 'end' => $endTime ];
    }
    /**
     * @param timestamp $startTime
     * @param timestamp $endTime
     * @param int $eveniId | null
     * @param int userId | null
     * @desc 判断用户是否登录，是否在活动时间内
     */
    protected static function isCanJoinActivity( $startTime , $endTime , $eventId , $userId = 0 )
    {
        if( $userId == 0 || empty($userId) ) {

            return self::callError('请在登录后参与活动',self::CODE_ERROR,[ 'type'=>'notLogged' ] );
        }

        $eventNote  =   self::getActivityEventIdNote();

        $note       =   isset($eventNote[$eventId]['name']) ? $eventNote[$eventId]['name'] : '';

        if($startTime > time()) {

            $errorMsg   =   $note . '活动在' . date('m月d日',$startTime) . '开启，敬请期待！';

            return self::callError( $errorMsg , self::CODE_ERROR,[ 'type'=>'notInTime' ] );
        }

        if($endTime < time()) {

            $errorMsg   =   $note . '活动在' . date('m月d日',$endTime) . '结束，谢谢参与！';

            return self::callError( $errorMsg , self::CODE_ERROR , [ 'type'=>'notInTime' ]);
        }

        return self::callSuccess();
    }

    /**
     * @param string $timeStamp
     * @return bool
     * @desc 判断timeStamp 是否在有效的时间段内,默认为一个小时
     */
    protected static function decideOperationTimeWhetherEffective( $timeStamp = '' ,$usefulTime = 3600)
    {
        if( time() - $timeStamp > $usefulTime ) {

            return false;
        }

        return true;
    }
    /**
     * @param string $startTime
     * @param string $endTime
     * @return bool
     * @desc 判断是否在活动时间内
     */
    protected static function decideActivityTime( $startTime = '' , $endTime = ' ' )
    {
        if( $startTime > time() || $endTime < time() ){

            return false;
        }

        return true;
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @desc 执行抽奖的程序
     */
    public static function doLotteryDraw( $userId = 0 , $groupId = 0 ,$eventId = 0)
    {
        $lotteryLogic           =   new LotteryLogic();

        $lotteryParam           =[
            'activity_id'   =>  $eventId ,
            'group_id'      =>  $groupId ,
            'user_id'       =>  $userId ,
        ];

        return $lotteryLogic->doLuckDrawWithRate( $lotteryParam );
    }
    /**
     * @param int $userId
     * @param int $groupId
     * @desc 执行抽奖的程序
     */
    public static function doLuckDrawUseActSta( $userId = 0 , $groupId = 0 ,$eventId = 0 ,$actStaId = 0)
    {
        $lotteryLogic           =   new LotteryLogic();

        $lotteryParam           =[
            'activity_id'   =>  $eventId ,
            'group_id'      =>  $groupId ,
            'user_id'       =>  $userId ,
            'statics_id'    =>  $actStaId ,
        ];

        return $lotteryLogic->doLuckDrawWithRateUseActSta( $lotteryParam );
    }
    /**
     * @param $userId
     * @param $actId
     * @param $startTime
     * @param $endTime
     * @param $baseCash
     * @return mixed
     * @desc get user join activity total by this params
     */
    protected static function getUserActInRecordByBaseCash($userId , $actId , $startTime , $endTime ,$baseCash,$status =false)
    {
        $statistics =   ActivityStatisticsLogic::getUserActInRecordByBaseCash ($userId , $actId , $startTime , $endTime ,$baseCash ,$status) ;

        return $statistics['total'] ;
    }

    /**
     * @param timestamp | $startTime
     * @param timestamp | $endTime
     * @param activity_id | $eventId
     * @param user | int $userId
     * @return  mixed| int number
     * @desc 读取用户在某个活动中已经参与的抽奖次数
     */
    protected static function getUserLotteryInfo( $startTime , $endTime , $eventId , $userId )
    {
        if( empty($userId) || $userId ==0 ) {

            return [];
        }

        $logic  =   new LotteryRecordLogic();

        $param  =   [
            'start_time'    =>  date('Y-m-d H:i:s',$startTime),
            'end_time'      =>  date('Y-m-d H:i:s',$endTime),
            'activity_id'   =>  $eventId,
            'user_id'       =>  $userId,
            ];

        $return =    $logic->getRecordByConnection( $param );

        return isset($return['lotteryNum']) ? (int) $return['lotteryNum'] : 0;
    }

    /**
     * @param timestamp | $startTime
     * @param timestamp | $endTime
     * @pram user | int $userId
     * @return mixed| int cash number
     * @desc 获取用户在活动时间内的充值成功的金额
     */
    protected static function getUserRechargeTotal( $startTime , $endTime , $userId )
    {
        if( empty($userId) || $userId ==0) return 0;

        $params =   [
                'start_time'    =>  date('Y-m-d H:i:s',$startTime),
                'end_time'      =>  date('Y-m-d H:i:s',$endTime),
                'userId'       =>  $userId,
                'status'        =>  OrderDb::STATUS_SUCCESS,
            ];

        $rechargeTotal      =   OrderModel::getRechargeStatistics( $params );

        return isset($rechargeTotal['cash']) ? (int) $rechargeTotal['cash'] : 0;
    }

    /**
     * @param int $userId
     * @param timestamp $startTime
     * @param timestamp $endTime
     * @param int number $baseCash 最小投资金额
     * @param boolen |布尔值，是否是红包的状态
     * @return int number | investNumber
     * @desc 用户在指定时间内符合的要求的投资笔数
     */
    protected static function getUserSatisfyInvestNumber( $startTime , $endTime , $baseCash=0 , $userId=0 , $projectIds = [] , $bonus=false)
    {
        if( $userId == 0) return 0;

        $params             =   [
            'user_id'       =>  $userId,
            'start_time'    =>  date('Y-m-d H:i:s',$startTime),
            'end_time'      =>  date('Y-m-d H:i:s',$endTime),
        ];

        if($baseCash > 0) {

                $params['base_cash']    =   $baseCash;
        }

        if( $bonus == false ) {

            $params['bonusId'] = '0';
        }

        if( !empty($projectIds) ) {

            $params['p_ids']    =  $projectIds;
        }
        $investLogic    =   new TermLogic();

        $investTotal    =   $investLogic->getInvestStatistics($params);

        return isset($investTotal['investTotal']) ? (int) $investTotal['investTotal'] : 0;

    }

    /**
     * @param array $config
     * @return array|mixed
     * @desc 获取当前项目的简称
     */
    protected static function getProductLineAbbreviation( $config = [] )
    {
        return  isset( $config['ACTIVITY_PROJECT'] ) ? $config['ACTIVITY_PROJECT'] : [];
    }
    /**
     * @param int $userId
     * @param timestamp $startTime
     * @param timestamp $endTime
     * @param boolen |布尔值，是否是红包的状态
     * @return int number | cash
     * @desc 指定时间内的投资总额
     */
    protected static function getSatisfyInvestSummation($startTime,$endTime,$bonus=false)
    {

        $params             =   [
            'start_time'    =>  date('Y-m-d H:i:s',$startTime),
            'end_time'      =>  date('Y-m-d H:i:s',$endTime),
        ];

        if( $bonus == false ){

            $params['bonusId'] = '0';
        }

        $investLogic    =   new TermLogic();

        $investTotal    =   $investLogic->getInvestStatistics( $params );

        return isset($investTotal['cash']) ? $investTotal['cash'] : 0;
    }
    /**
     * @return mixed
     * @desc  活动的项目
     */
    protected static function getProject( $productLine =  array() )
    {
        if( empty($productLine) || $productLine == []) { return []; }

        return ProjectLogic::getActivityProject( $productLine) ;
    }
    /**
     * @return array
     * @desc  根据配置设置统计的时间段
     */
    protected static function setReceiveBetweenTime( $startTime , $endTime ,$isEveryDay = false )
    {
        if( $isEveryDay == false ) {

            return [
                'start' =>  date("Y-m-d H:i:s" , $startTime ),
                'end'   =>  date("Y-m-d H:i:s" , $endTime ),
            ];
        }

        return [
            'start' =>  date("Y-m-d 00:00:00" , time()),
            'end'   =>  date("Y-m-d 23:59:59" , time()),
        ];
    }
    /**
     * @param $groupId int 奖品分组
     * @return array
     * @desc 获取奖品的信息
     */
    protected static  function setCouponLotteryList( $groupId = 0 )
    {
        if( empty($groupId) || $groupId ==0) {

            return [];
        }
        $couponLotteryList  =   LotteryConfigLogic::getLotteryByGroup( $groupId );

        if( !empty($couponLotteryList) ) {

            return ToolArray::arrayToKey( $couponLotteryList , 'order_num' );
        }

        return [];
    }
    /**
     * @param $eventId | int 活动对应的事件ID
     * @return mixed
     * @desc 中奖的数据
     */
    protected static  function setCouponWinningList( $startTime , $endTime , $eventId = 0, $limit=30)
    {
        $cacheKey   =   'LOTTERY_LIST_' . $eventId;

        $cacheValue =   Cache::get($cacheKey);

        if( !empty($cacheValue) ) {
            return json_decode($cacheValue, true);
        }
        $recordLogic        =   new  LotteryRecordLogic();

        $connection         =   [
            'start_time'    =>  date('Y-m-d H:i:s' , $startTime),
            'end_time'      =>  date('Y-m-d H:i:s' , $endTime),
            'activity_id'   =>  $eventId,
            'limit'         =>  $limit
        ];

        $lotteryList        =   $recordLogic->getRecordByConnection( $connection );

        if( !empty($lotteryList['lotteryNum']) ) {
            Cache::put($cacheKey , json_encode($lotteryList) , 60) ;
        }

        return $lotteryList;
    }
    /**
     * @param $version
     * @return bool
     * @desc 判断当前的app版本号是否正常
     */
    protected static  function isInMatterAppVersion( $version = '',$matterVersion = [] )
    {
        if(empty($version) || empty($matterVersion) ) {

            return true;
        }

        if( in_array($version,$matterVersion) ) {

            return false;
        }

        return true;
    }
    /**
     * @return bool
     * @desc 周期内领取的次数
     */
    protected static  function getDrawNumber( $config =[] )
    {
        return $config['DRAW_NUMBER'];
    }
    /**
     * @return bool
     * @desc 抽取奖励、领取奖励的有效周期标示
     */
    protected static  function getDrawCycle( $config =[] )
    {
        return $config['DRAW_CYCLE'];
    }

    protected static function getMinInvestCash( $config = [] )
    {
        return $config['MIN_INVEST_CASH'];
    }
    /**
     * @return int
     * @desc   获取奖品分组
     */
    protected static  function getActivityLotteryGroup( $eventId='' )
    {
        $eventNote  =   self::getActivityEventIdNote();

        return isset($eventNote[$eventId]) ? $eventNote[$eventId]['group'] : self::DEFAULT_GROUP;
    }

    /**
     * @param event_id  | $activityId
     * @return activity name ,活动名词
     */
    protected static function getActivityNote( $activityId = 0 )
    {
        if($activityId == 0 || empty($activityId)) {

            return '运营活动';
        }

        $note   =    ActivityFundHistoryModel::getActivityEventNote();

        return isset($note[$activityId]) ? $note[$activityId] : '运营活动';
    }

    /**
     * @param string $actToken
     * @return array
     * @desc 记录Session的值
     */
    public static function setActToken($userId , $actToken = '' )
    {
        if( empty( $actToken) ) {

            Log::info('invest_activity_page_error', ['error' => '用户：'.$userId . ',ActToken is empty'] ) ;

            return self::callError( '活动唯一标示错误' );
        }

        if( Session::has('ACT_TOKEN') ){

            Session::forget('ACT_TOKEN');
        }

        Session::put( 'ACT_TOKEN' , $actToken );

        Session::save();

        Log::info('invest_activity_page_success', ['info' => '用户：'.$userId . ',ActToken is '.$actToken.',set success']  ) ;

        return self::callSuccess( explode('_' , $actToken) );
    }
    /**
     *@desc 格式化数字对文字
     */
    public static function getFormatNumberToWord()
    {
        return [0=>'零',1=>'一',2=>'二',3=>'三',4=>'四',5=>'五',6=>'六',7=>'七',8=>'八',9=>'九',10=>'十'];
    }
    /**
     * @return array
     * @desc 所有的包含抽奖活动的标示
     */
    protected static function getActivityEventIdNote()
    {
        return LotteryRecordLogic::getLotteryActivityEventNote();
    }


    /**################## [app分享交互功能函数]#####################################**/

    /**
     * @desc 通过app分享回调返回的活动id获取相应的配置
     * @param $activityId int
     * @return array
     */
    public static function getActivityConfigByAppReturn($activityId)
    {
        if (empty($activityId)) {
            return self::callError('活动标示ID为空');
        }

        //获取活动id对应的活动配置
        $activityToEventConfig = ActivityConfigModel::getConfig('ACTIVITY_EVENT_ID_TO_CONFIG');

        if (stripos($activityToEventConfig[$activityId], '|') !== false) {
            $arr = explode('|', $activityToEventConfig[$activityId]);
            $activityKey = $arr[0];
        }else {
            $activityKey = $activityToEventConfig[$activityId];
        }

        //获取相应的活动配置信息
        $activityConfig = ActivityConfigModel::getConfig($activityKey);

        if (empty($activityConfig) || empty($activityToEventConfig)){
            return self::callError('活动相关配置配置数据为空!');
        }


        $data = [
            'class' => isset($activityConfig['DO_SHARE_CALL_CLASS']) ? $activityConfig['DO_SHARE_CALL_CLASS'] : '',
            'functions' => isset($activityConfig['DO_SHARE_CALL_FUNCTION']) ? $activityConfig['DO_SHARE_CALL_FUNCTION'] : '',
            ];
        return self::callSuccess($data);
    }

    /**
     * @desc 获取微信分享的分享信息从活动配置中获取
     * @param $configKey string
     * @return array
     */
    public static function getActivityShare($configKey = '')
    {
        $shareConfig = $shareAd  = [];

        if (empty($configKey)) {
            return $shareConfig;
        }

        $config = ActivityConfigModel::getConfig($configKey);

        if (empty($config)) {
            return $shareConfig;
        }

        $adLogic = new AdLogic();
        //活动ID
        $adId = isset($config['AD_ID']) ? $config['AD_ID'] : 0;

        $adInfo = $adLogic->getUseAbleListByAdId([$adId]);

        //获取分享信息
        if (isset($adInfo[0]['param'])) {
            $shareAd = json_decode($adInfo[0]['param'], true);
        }

        $shareConfig = [
            'imgUrl'    => isset($shareAd['share_image_name']) && isset($shareAd['share_image_path']) ? assetUrlByCdn($shareAd['share_image_path'].$shareAd['share_image_name']) : '',
            'lineLink'    => isset($shareAd['share_url']) ? $shareAd['share_url'] : '',
            'descContent' => isset($shareAd['share_desc']) ? $shareAd['share_desc'] : '活动分享默认内容',
            'shareTitle' => isset($shareAd['share_title']) ? $shareAd['share_title'] : '活动分享标题',
            ];
        return $shareConfig;
    }
}
