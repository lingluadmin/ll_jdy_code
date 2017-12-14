<?php
/**
 * Created By Vim
 * User: linguanghui
 * Date: 2017/09/20
 * Time: 16:29
 * Desc: 中秋国庆活动逻辑处理
 */

namespace App\Http\Logics\Activity;

use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic;
use App\Http\Dbs\Bonus\UserBonusDb;
use App\Http\Dbs\Bonus\BonusDb;
use App\Http\Logics\Bonus\BonusLogic;
use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Models\Activity\AutumnNationModel;
use App\Tools\ToolArray;

class AutumnNationLogic extends ActivityLogic
{

    protected $activityTime, $config;

    public function __construct()
    {
        $this->activityTime = self::setActivityTime();
        $this->config = self::config();

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
        return ActivityFundHistoryDb::SOURCE_ACTIVITY_NATIONAL_AUTUMN ;
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
     * @desc 执行获取国庆节活动的红包[按照注册年限领取一次]
     * @param $userId int
     * @return array
     */
    public function doGetNationBonus($userId, $bonusId)
    {
        if (empty($bonusId)){
            return self::callError('没有选择要领取的红包');
        }

        $userBonusLogic =   new UserBonusLogic();

        //用户活动期间领取的红包总数
        $receivedNum = self::getReceivedBonusNum($userId, false, 'REGISTER_BONUS_CONFIG');

        //国庆活动红包配置
        $bonusArr = self::getBonusConfig('REGISTER_BONUS_CONFIG');

        $registerLevel = AutumnNationModel::setUserRegisterLevel($userId);

        try{
            //检测是否登陆
            AutumnNationModel::checkUserLogin($userId);

            //检测是否在活动时间内
            AutumnNationModel::checkActivityTime($this->activityTime);

            //检测红包id是否配置
            AutumnNationModel::checkBonusIfRight($bonusArr, $bonusId);

            //检测用户活动期间是否可以领取红包
            AutumnNationModel::checkIfCanGetBonusByTimes($receivedNum, $this->config);

            //检测用户等级是否可以领取当前红包
            AutumnNationModel::checkRegisterLevelGetBonus($bonusArr, $bonusId, $registerLevel, $userId);

            $userBonusLogic->doSendBonusByUserIdWithBonusId($userId, $bonusId);
        }catch(\Exception $e){
            $attributes['msg'] = $e->getMessage();
            $attributes['code'] = $e->getCode();
            \Log::Error(__METHOD__.'Error', $attributes);
            return self::callError($e->getMessage(), $e->getCode());
        }

        $nationBonus = self::getAutumnNationBonus()['nation_bonus'];

        return self::callSuccess($nationBonus[$bonusId]);
    }

    /**
     * @desc 执行获取中秋节活动的发送红包[每天一次]
     * @param $userId int
     * @param $bonusId int
     * @return array
     */
    public function doGetAutumnBonus($userId, $bonusId, $customeValue='percentile')
    {
        if (empty($bonusId)){
            return self::callError('没有选择要领取的红包');
        }
        $userBonusLogic =   new UserBonusLogic();

        //用户当天已领取的红包总数
        $receivedNum = self::getReceivedBonusNum($userId, true);

        //中秋节红包活动配置
        $bonusArr = self::getBonusConfig('BONUS_CONFIG');

    //    $bonusArr = explode(',',$bonusConfig[$customeValue]);

        try{
            //检测是否登陆
            AutumnNationModel::checkUserLogin($userId);

            //检测是否在活动时间内
            AutumnNationModel::checkActivityTime($this->activityTime);

            //检测红包id是否配置
            AutumnNationModel::checkBonusIfRight($bonusArr, $bonusId);

            //检测今天是否可以领取红包
            AutumnNationModel::checkIfCanGetBonusByDay($receivedNum, $this->config);

            $userBonusLogic->doSendBonusByUserIdWithBonusId($userId, $bonusId);
        }catch(\Exception $e){
            $attributes['msg'] = $e->getMessage();
            $attributes['code'] = $e->getCode();
            \Log::Error(__METHOD__.'Error', $attributes);
            return self::callError($e->getMessage(), $e->getCode());
        }

        $autumnBonus = self::getAutumnNationBonus()['autumn_bonus'];

        $autumnBonus[$bonusId]['success_tip'] = sprintf('成功领取%s元红包一个<br>请至“我的账户”中查看',$autumnBonus[$bonusId]['money']);

        return self::callSuccess($autumnBonus[$bonusId]);
    }


    /**
     * @desc 获取活动中已领取红包总数
     * @param $userId int
     * @param $drawCycle bool
     * @return str|int
     */
    public static function getReceivedBonusNum($userId = 0, $drawCycle = false, $key = 'BONUS_CONFIG')
    {
        $receivedNum = 0;
        if ($userId == 0){
            return self::callError();
        }

        $userBonusDb = new UserBonusDb();

        $config = self::config();

        $bonusConfig = self::getBonusConfig($key);

        $betweenTime = self::setReceiveBetweenTime($config['START_TIME'], $config['END_TIME'], $drawCycle);

        $bonusArr = $userBonusDb->getUserBonusUsedTotal($betweenTime['start'], $betweenTime['end'], $bonusConfig, $userId);

        if (!empty($bonusArr)){
            foreach($bonusArr as $key=>$value){
                $receivedNum += $value['total'];
            }
        }
        return $receivedNum;
    }


    /**
     * @desc 获取活动红包的配置信息数据
     * @param $key str 活动配置key
     * @return array
     */
    public static function getBonusConfig($key, $customeValue ='percentile')
    {
        if (empty($key)){

            return [];
        }

        $config     =   self::config();

        $bonusArr   =   explode('|',$config[$key]);

        $returnArr  =   [];

        if( !empty($bonusArr) ){

            $bonusArr   =   array_filter($bonusArr);

            foreach ($bonusArr as $key => $bonusStr ){

                $bonusRes       =    explode('=',$bonusStr);

                $returnArr[$bonusRes[0]] = trim($bonusRes[1]);
            }
        }

        if (isset($returnArr[$customeValue])){
            $returnArr = explode(',',$returnArr[$customeValue]);
        }

        return $returnArr;
    }

    /**
     * @desc 获取中秋国庆活动的配置
     * @return array
     */
    protected static function config()
    {
        return AnalysisConfigLogic::make('AUTUMN_NATION_CONFIG');
    }

    /**
     * @desc 获取十一活动红包
     */
    public static function getAutumnNationBonus()
    {
        $nationBonus = self::getBonusConfig('REGISTER_BONUS_CONFIG');
        $autumnBonus = self::getBonusConfig('BONUS_CONFIG');

        $bonusDb    =   new BonusDb();

        $nationBonusList  =   self::formatActivityBonus($bonusDb->getByIds($nationBonus), $nationBonus);
        $autumnBonusList  =   self::formatActivityBonus($bonusDb->getByIds($autumnBonus));

        return [
            'nation_bonus' => $nationBonusList,
            'autumn_bonus' => $autumnBonusList,
            ];
    }

    /**
     * @desc 格式化活动红包
     * @param $bonusList array
     * @return array
     */
    public static function formatActivityBonus($bonusList, $bonusConfig=[])
    {
        if (empty($bonusList)){
            return [];
        }

        $formatBonus = [];

        foreach($bonusList as $key=>$value)
        {
            $formatBonus[$key]['id'] = $value['id'];
            $formatBonus[$key]['rate'] = (float)$value['rate'];
            $formatBonus[$key]['money'] = (int)$value['money'];
            $formatBonus[$key]['min_money'] = (int)$value['min_money'];
            if (!empty($bonusConfig)){
                $formatBonus[$key]['bonusLevelNote'] = self::getBonusLevelNote($bonusConfig, $value['id']);
            }
        }

        $formatBonus = ToolArray::arrayToKey($formatBonus);
        return $formatBonus;
    }

    /**
     * @desc 获取国庆红包量取资格文字
     * @param $bonusConfig array
     * @param $bonusId array
     * @return array
     */
    public static function getBonusLevelNote($bonusConfig, $bonusId)
    {
        $bonusLevelNote = '';
        if (!empty($bonusConfig)){
            $bonusConfig = array_flip($bonusConfig);
            switch($bonusConfig[$bonusId]){
            case AutumnNationModel::REGISTER_LEVEL_ONE:
                $bonusLevelNote = "注册时间<1年";
                break;
            case AutumnNationModel::REGISTER_LEVEL_TWO:
                $bonusLevelNote = "注册时间≥1年";
                break;
            case AutumnNationModel::REGISTER_LEVEL_THREE:
                $bonusLevelNote = "注册时间≥2年";
                break;
            }
        }
        return $bonusLevelNote;
    }
}
