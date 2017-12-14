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

class DoubleElevenLogic extends ActivityLogic
{
    protected $activityTime, $config;

    const
        ERROR_RECHARGE_NOT_ENOUGH = 10001001,//净充值金额不够
        ACTIVITY_CONFIG='DOUBLE_ELEVEN_CONFIG', //双十一活动配置key
        END = true;

    public function __construct()
    {
        $this->activityTime = self::setActivityTime();
        $this->config = self::config();
    }
    /**
     * @return mixed
     * @desc  活动的项目
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
     * @desc 设置活动的时间
     * @return array
     */
    public static function setActivityTime()
    {
        $config = self::config();

        return self::getTime($config['START_TIME'], $config['END_TIME']);
    }

    /**
     * @return int
     * @DESC 活动的唯一性标示
     */
    protected static function setActivityEventId()
    {
        return ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN ;
    }

    /**
     * @desc  设置当前活动的act_token
     */
    public static function getActToken()
    {
       return   time() . '_' . self::setActivityEventId() ;
    }

    /**################################[双十一签到活动]#########################**/
    /**
     * @return int
     * @desc 奖品的组号
     */
    public function getGroupId()
    {
        return $this->getActivityLotteryGroup (self::setActivityEventId ());
    }
    /**
     * @desc 双十一签到活动的执行逻辑
     * @author linguanghui
     * @param $data array 签到数据
     * @return array
     */
    public function doSign($data)
    {
        //检测活动参数是否为空
        if(empty($data)){
            return self::callError(LangModel::ERROR_ACTIVITY_PARAM_NULL);
        }

        $userId  = $data['user_id'];
        $activitySignModel = new ActivitySignModel();
        $activitySignLogic = new ActivitySignLogic();

        try {
            self::beginTransaction();
            //检测用户是否登陆
            AutumnNationModel::checkUserLogin($userId);
            //检测活动时间
            AutumnNationModel::checkActivityTime($this->activityTime);

            $currentLogic = new CurrentLogic();
            $investNums = TermLogic::getUserInvestDataByUserId($userId);
            $currentInvestNums = $currentLogic->getUserCurrentInvestNum($userId);
            //检测用户是否是老用户是否投资过定期or活期
            if ($investNums<=0 && $currentInvestNums<=0) {
                return self::callError('您还没有投资过，请投资后再来签到');
            }

            //检测是否已存在当前活动的签到记录
            $res = $activitySignModel->checkSignRecord($data['user_id'], $data['type']);
            //存在
            if($res){
                //检测当天是否重复签到
                $activitySignModel->checkSignRepeat($res['last_sign_day']);
                //检测是否连续签到
                $continue = $activitySignModel->checkSignContinue($res['last_sign_day']);

                if($continue){//连续签到
                    $activitySignModel->updateContinueSign($data['user_id'], $data['type']);
                }else{
                    $activitySignModel->updateNoContinueSign($data['user_id'], $data['type']);
                }
            }else{
                $addSignData = $activitySignLogic->formatAddSignData($data);
                //添加签到记录
                $activitySignModel->addSign($addSignData);
            }
            self::commit();
        } catch (\Exception $e) {
            self::rollBack();
            Log::error(__METHOD__.'Error',['msg' => $e->getMessage(),'code' => $e->getCode()]);

            return self::callError($e->getMessage());
        }

        $signData = $this->formatReturnSignData($userId);
        return self::callSuccess($signData);
    }

    /**
     * @desc 格式化签到成功返回的签到数据
     * @param $userId int
     * @return array
     */
    public function formatReturnSignData($userId)
    {
        $signData = json_decode($this->setUserSignData($userId, ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN), true);
        $signTimesAward = self::getAwardSignTimes();
        $signData['left_day'] = ($signTimesAward > $signData['sign_continue_num']) ? ($signTimesAward - $signData['sign_continue_num']) : 0;
        $signData['sign_note'] = sprintf(LangModel::getLang('DOUBLE_ELEVEN_SING_NOTE'), $signData['sign_continue_num']);

        return $signData;
    }

    /**
     * @desc 获取签到日期列表
     * @param $format string
     * @return array
     */
    public function getSignDateList($format){
        $config = $this->config();

        $start = date("Y-m-d",$config['START_TIME']);
        $end  = date("Y-m-d",$config['END_TIME']);
        $dateList = ToolTime::getDateList($format, $start, $end);

        return $dateList;
    }

    /**
     * @desc 设置用户签到的数据信息
     * @param $userId int 用户ID
     * @param $activityId int 活动标示
     * @return array
     */
    public function setUserSignData($userId, $activityId =ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN)
    {
        $cacheKey = $userId.'_'.$activityId.'_sign_data';

        $activitySignModel = new ActivitySignModel();

        $signData = $activitySignModel->getUserSignData($userId, $activityId);

        $dateList = $this->getSignDateList('d');

        if (empty($userId) || empty($signData)) {
            $signData['date_list'] = $dateList;
            return $this->cacheActivityData($cacheKey, $signData);
        }

        $signDate= array_filter(explode('|', $signData['sign_record']));

        foreach ($dateList as $key => $date) {
            if (in_array($date['date'], $signDate)) {
                $dateList[$key]['sign_status'] = 1;
            }
        }

        $signData['date_list'] = $dateList;

        $signData = $this->cacheActivityData($cacheKey, $signData);

        return $signData;
    }

    /**
     * @desc 获取用户的签到数据
     * @param $userId int 用户ID
     * @param $activityId int 活动标示
     * @return array
     */
    public function getUserSignData($userId, $activityId)
    {
        $key = $userId.'_'.$activityId.'_sign_data';

        $signData = \Cache::get($key);

        if (empty($signData)) {
            $signData= $this->setUserSignData($userId, $activityId);
        }
        return json_decode($signData, true);
    }

    /**
     * @desc 获取连续签到可以抽奖的次数
     * @return number
     */
    public static function getAwardSignTimes()
    {
        $config = self::config();

        return isset($config['CONTINUE_SIGN_TIMES']) ? $config['CONTINUE_SIGN_TIMES'] : 0;
    }
    /**################################[双十一签到活动]#########################**/

    /**########################微信分享活动##########################***/
    /**
     * @desc 微信分享成功后的回调函数
     * @return array
     */
    public function doShareSuccess($data)
    {
        //检测活动分享的参数是否为空
        if(empty($data)){
            return self::callError(LangModel::ERROR_ACTIVITY_PARAM_NULL);
        }

        $userId     =   $data['user_id'];

        try {
            self::beginTransaction();
            //检测用户是否登陆
            AutumnNationModel::checkUserLogin($userId);
            //检测活动时间
            AutumnNationModel::checkActivityTime($this->activityTime);

            //检测分享的用户是否投资过平台老用户
            $currentLogic = new CurrentLogic();
            $investNums = TermLogic::getUserInvestDataByUserId($userId);
            $currentInvestNums = $currentLogic->getUserCurrentInvestNum($userId);
            //检测用户是否是老用户是否投资过定期or活期
            if (isset($investNums['total']) && $investNums['total'] < 1 && $currentInvestNums < 1) {
                return self::callError('您还没有投资过，投资分享后才有现金奖励');
            }

            //检查今天是否已经领取过奖励
            ActivityFundHistoryModel::checkIfGetCashToday($userId, ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN);
            //执行加币的操作
            $userLogic = new UserLogic();
            //分享奖励的随机金额
            $cash = (isset($data['cash'])) ? $data['cash'] : $this->getRandShareMoney();
            //分享加币的备注
            $note = (isset($data['note'])) ? $data['note'] : '11.11理财节, 活动分享现金奖励' ;

            $result = $userLogic->doInsertUserBalance($userId, $cash, $note, ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN);
            self::commit();
        } catch(\Exception $e) {
            self::rollBack();
            Log::error(__METHOD__.'Error',['msg' => $e->getMessage(),'code' => $e->getCode()]);

            return self::callError($e->getMessage());
        }

        $data['msg'] = sprintf('恭喜您获得现金%s元', $cash);
        return self::callSuccess($data);
    }

    /**
     * @desc 获取分享成功后的奖励的现金数
     */
    public function getRandShareMoney()
    {
        $shareMoney = explode('-', $this->config['SHARE_CASH_RANGE']);

        $money = rand($shareMoney[0], $shareMoney[1])/10;

        return $money;
    }

    /**########################微信分享活动##########################***/

    /**##################################[充值红包雨功能]###############################**/

    /**
     * @desc 执行充值领取红包雨的操作
     * @param $data array
     * @return array
     */
    public function doGetRechargeBonus($data)
    {
        //判断参数是否为空
        if(empty($data)){
            return self::callError(LangModel::ERROR_ACTIVITY_PARAM_NULL);
        }
        $userId = $data['user_id'];
        $bonusId = $data['bonus_id'];
        $userBonusLogic =   new UserBonusLogic();
        try {
            //是否登录
            AutumnNationModel::checkUserLogin($userId);
            //是否活动期间内
            AutumnNationModel::checkActivityTime($this->activityTime);

            //获取用户的净充值金额
            $netRechargeCash = self::getUserNetRecharge($userId);

            //净充值金额所属档次等级
            $netRechargeLevel = self::getNetRechargeLevel($netRechargeCash);

            //获取红包的配置等级
            $bonusLevel = self::getBonusLevel($data['bonus_id']);

            //判断当前的充值等级是否能领取当前红包
            if ($netRechargeLevel < $bonusLevel){
                return self::callError('您的净充值金额还不够，快去充值吧', self::ERROR_RECHARGE_NOT_ENOUGH);
            }

            //判断是否已经领取过当前红包
            $userGetBonus = self::getUserGetBonus($userId);

            if (isset($userGetBonus[$bonusId])) {
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

        //重新设置用户领取红包的数据
        $this->setBonusRainList($userId);

        $data['bonus_note'] = sprintf(LangModel::getLang('RECEIVE_BONUS_SUCCESS'), $data['bonus_cash']);
        return self::callSuccess($data);
    }

    /**
     * @desc 获取用户的净充值金额=充值金额-提现金额
     * @param $userId int
     * @return float
     */
    public static function getUserNetRecharge($userId)
    {
        if (empty($userId)) {
            return 0;
        }

        $config = self::config();
        $betweenTime = self::setReceiveBetweenTime($config['START_TIME'], $config['END_TIME'], false);

        $params = [
            'start_time' => $betweenTime['start'],
            'end_time'  => $betweenTime['end'],
            'userId'    => $userId,
            ];
        $recharge = OrderModel::getRechargeStatistics($params);
        $withdraw = OrderModel::getWithdrawStatistics($params);

        return (float)($recharge['cash']-$withdraw['cash']);
    }

    /**
     * @desc 获取用户净充值金额的等级
     * @param $netRechargeCash float 净充值金额
     * @return array
     */
    public static function  getNetRechargeLevel($netRechargeCash)
    {
        $rechargeLevel = 0;
        $config = self::config();
        $bonusConfig = self::getRechargeBonusConfig();

        if ($netRechargeCash == 0) {
            return $rechargeLevel;
        }

        if (isset($config['NET_RECHARGE_CONFIG'])) {
            $netConfig = array_filter(explode('|',$config['NET_RECHARGE_CONFIG']));
            switch ($netRechargeCash)
            {
                case $netRechargeCash >= $netConfig[0] && $netRechargeCash < $netConfig[1]:
                    $rechargeLevel = $bonusConfig[0]['level'];
                    break;
                case $netRechargeCash >= $netConfig[1] && $netRechargeCash < $netConfig[2]:
                    $rechargeLevel = $bonusConfig[1]['level'];
                    break;
                case $netRechargeCash >= $netConfig[2] && $netRechargeCash < $netConfig[3]:
                    $rechargeLevel = $bonusConfig[2]['level'];
                    break;
                case $netRechargeCash >= $netConfig[3]:
                    $rechargeLevel = $bonusConfig[3]['level'];
                    break;
            }
        }
        return $rechargeLevel;
    }

    /**
     * @desc 获取配置对应的红包等级
     * @param $bonusId int
     * @return int
     */
    public static function getBonusLevel($bonusId)
    {
        if (empty($bonusId)) {
            throw new \Exception('红包ID不能为空',500);
        }

        $rechargeBonusConfig = ToolArray::arrayToKey(self::getRechargeBonusConfig(), 'bonus_id');

        if (!isset($rechargeBonusConfig[$bonusId])) {
            throw new \Exception('此红包的等级未配置',500);
        }

        $level = $rechargeBonusConfig[$bonusId]['level'];

        return $level;
    }

    /**
     * @desc 获取并格式化充值红包雨的红包配置
     * @return array
     */
    public static function getRechargeBonusConfig()
    {
        $bonusConfig = [];
        $config = self::config();

        if (isset($config['RECHARGE_BONUS_CONFIG'])) {

            $bonusArr = array_filter(explode(';', $config['RECHARGE_BONUS_CONFIG']));
            foreach ($bonusArr as $bonus) {
                $arr = explode('=>', $bonus);

                $bonusConfig[] =[
                    'level' => $arr[0],
                    'bonus_id' => $arr[1],
                    ];

            }
        }
        return $bonusConfig;
    }

    /**
     * @desc 获取净充值金额限制的配置信息
     */
    public static function getNetRechargeConfig()
    {
        $netRechargeConfig = [];
        $config = self::config();

        if (isset($config['NET_RECHARGE_CONFIG'])) {
            $netRechargeConfig = array_filter(explode('|', $config['NET_RECHARGE_CONFIG']));
        }
        return $netRechargeConfig;
    }

    /**
     * @desc 设置页面的红包雨红包列表数据
     * @param $userId int 用户userID
     * @return array
     */
    public static function setBonusRainList($userId)
    {
        $bonusDb = new BonusDb();

        $bonusConfig = self::getRechargeBonusConfig();

        //获取红包信息
        $bonusIds = ToolArray::arrayToIds($bonusConfig, 'bonus_id');
        $bonusList = ToolArray::arrayToKey($bonusDb->getByIds($bonusIds));

        $userGetBonus = self::getUserGetBonus($userId);

        foreach ($bonusConfig as $key => $bonus) {
            if (isset($bonusList[$bonus['bonus_id']])) {
                $bonusConfig[$key]['money'] = (int)$bonusList[$bonus['bonus_id']]['money'];
                $bonusConfig[$key]['unit'] = '元';
            }

            $bonusConfig[$key]['is_get'] = isset($userGetBonus[$bonus['bonus_id']]) ? 1 : 0;
        }

        $cacheKey = $userId.'_bonus_rain_list';

        $bonusConfig = self::cacheActivityData($cacheKey, $bonusConfig);
        return $bonusConfig;
    }

    /**
     * @desc 获取用户红包雨列表数据
     * @param $userId
     */
    public static function getBonusRainList($userId)
    {
        $cacheKey = $userId.'_bonus_rain_list';

        $bonusRainList = \Cache::get($cacheKey);

        if (empty($bonusRainList)) {
            $bonusRainList = self::setBonusRainList($userId);
        }
        return json_decode($bonusRainList, true);
    }

    /**
     * @desc 获取用户已经获取红包记录
     * @param $userId int
     * @return array
     */
    public static function getUserGetBonus($userId)
    {
        if (empty($userId)) {
            return [];
        }

        $userBonusDb = new UserBonusDb();

        $bonusConfig = self::getRechargeBonusConfig();

        $bonusIds = ToolArray::arrayToIds($bonusConfig, 'bonus_id');

        $config = self::config();

        $betweenTime = self::setReceiveBetweenTime($config['START_TIME'], $config['END_TIME'], false);

        $bonusArr = $userBonusDb->getUserBonusUsedTotal($betweenTime['start'], $betweenTime['end'], $bonusIds, $userId);

        return ToolArray::arrayToKey($bonusArr, 'bonus_id');
    }

    /**##################################[充值红包雨功能]###############################**/

    /**
     * @desc 缓存活动的数据公共函数
     * @param $key 缓存的key
     * @param $data 要缓存的数据
     * @param $time 缓存的时长，默认60分
     * @return array;
     */
    public static function cacheActivityData($key, $data, $time = 60)
    {
        $cacheData = json_encode($data);

        \Cache::put($key, $cacheData, $time);

        return $cacheData;
    }

    /****************************************** 用户抽奖层的判断*************************************************/

    /**
     * @param $userId
     * @return array
     * @desc 判断用户和活动状态
     */
    public function validActivityStatus($userId)
    {
        return parent::isCanJoinActivity($this->config['START_TIME'], $this->config['END_TIME'], $this->setActivityEventId() ,$userId);
    }

    /**
     * @param $userId
     * @return array
     * @desc 验证用户的签名状态
     */
    public function validUserSignStatus($userId)
    {
        $signLogic      =   new ActivitySignLogic();

        $signNumber     =   $signLogic->getContinueSignNum($userId, $this->setActivityEventId());

        if( $signNumber < $this->getCanLotterySingNumber ()) {

            $errorMsg   =   '连续签到'.$this->getCanLotterySingNumber ().'天可抽奖';

            return self::callError ($errorMsg, self::CODE_ERROR, ['type'=> 'sign']);
        }

        return self::callSuccess ($signNumber);
    }

    /**
     * @return int|mixed
     * @desc 连续签名的天数
     */
    private function getCanLotterySingNumber()
    {
        return  isset($this->config['CONTINUE_SIGN_TIMES']) ? $this->config['CONTINUE_SIGN_TIMES'] : 7 ;
    }
    /**
     * @param $userId
     * @return array
     * @desc 执行抽奖
     */
    public function doLuckDraw($userId, $signNumber)
    {
        $lotteryLogic   =   new LotteryLogic();

        $countSign      =   0 ;

        if( $this->isCountSignNumber() == true ) {
            $countSign      =   $signNumber-$this->getCanLotterySingNumber ();
        }
        $lottery        =   [
            'activity_id'   =>  $this->setActivityEventId() ,
            'group_id'      =>  $this->getGroupId () ,
            'user_id'       =>  $userId ,
            'sign_number'   =>  $countSign
        ];

        return  $lotteryLogic->doLuckDrawWithRateUseSign ($lottery);
    }

    /**
     * @return bool
     * @desc 设置抽奖后签到天数是否清零
     */
    private function isCountSignNumber()
    {
        if( isset($this->config['IS_RECKON_SIGN']) && $this->config['IS_RECKON_SIGN'] =='1'){
            return true;
        }
        return false;
    }
    /**
     * @return array
     * @desc 中奖记录
     */
    public function getLotteryList()
    {
        $lotteryList    =    parent::setCouponWinningList ($this->config['START_TIME'], $this->config['END_TIME'],$this->setActivityEventId() ) ;

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

    /****************************************** 富豪排行榜********************************************/
    public  function getUserInvestPkList()
    {
        $staticLogic    =   new ActivityStatisticsLogic();

        $rankingList    =   $staticLogic->getUserCheckInActRanking($this->setActivityEventId(), $this->config['START_TIME'], $this->config['END_TIME'],10);

        if( empty($rankingList) ) {
            return [];
        }

        $userIds        =   implode (",",array_column ($rankingList, 'user_id') );

        $userInfo       =   UserModel::getUserListByIds ( $userIds );

        if( empty($userInfo) ) {
            return[];
        }

        $userInfo       =   ToolArray::arrayToKey ($userInfo, 'id');

        foreach ($rankingList as $key => &$value ) {
            $value['phone'] = isset($userInfo[$value['user_id']]) ? ToolStr::hidePhone ($userInfo[$value['user_id']]['phone']) : '';
        }

        return $rankingList;
    }

    /**
     * @desc 取消抽奖的操作
     * @param $data
     * @return
     */
    public function doQuitLottery($data)
    {
        if (empty($data)) {
            return self::callError(LangModel::ERROR_ACTIVITY_PARAM_NULL);
        }

        $signModel = new ActivitySignModel();
        try {
            //初始化签到信息
            $signModel->initSignNum($data['user_id'], $data['type']);

            //更新缓存数据
            $signData = $this->formatReturnSignData($data['user_id']);

        } catch(\Exception $e) {

            Log::error(__METHOD__.'Error',['msg' => $e->getMessage(),'code' => $e->getCode()]);

            return self::callError($e->getMessage());
        }

        return self::callSuccess($signData);
    }

    /**
     * @desc 获取双十一活动的配置
     * @return array
     */
    protected static function config()
    {
        return AnalysisConfigLogic::make('DOUBLE_ELEVEN_CONFIG');
    }
}
