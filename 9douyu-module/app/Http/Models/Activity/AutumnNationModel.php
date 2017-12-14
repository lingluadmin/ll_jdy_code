<?php
/**
 * Create by Vim
 * User: linguanghui
 * Date: 2017/09/21
 * Time: 14:24Pm
 * Desc: 中秋国庆活动Model 处理
 */
namespace App\Http\Models\Activity;

use App\Http\Models\Model;
use App\Http\Models\Common\CoreApi\UserModel;
use App\Tools\ToolTime;

class AutumnNationModel extends Model
{

    const
        REGISTER_LEVEL_ONE = 1, //未满一年
        REGISTER_LEVEL_TWO = 2, //未满两年
        REGISTER_LEVEL_THREE = 3,//两年以上
        END = true;

    public static $codeArr = [
        'checkUserLogin'  => 1,
        'checkActivityTime' => 2,
        ];

    /**
     * @desc 监测用户是否登陆
     * @param $userId int 用户ID
     * @return array
     */
    public static function checkUserLogin($userId)
    {
        if (empty($userId) || $userId == 0){
            throw new \Exception('您还没有登录, 请登录后参与活动', self::getFinalCode(__FUNCTION__));
        }
        return true;
    }

    /**
     * @desc 检测活动的时间是否在配置时间内
     * @param $activityTime array
     * @return array
     */
    public static function checkActivityTime($activityTime)
    {
        $nowTime = time();

        //未开始
        if ($nowTime < $activityTime['start']){
            throw new \Exception('活动未开始', self::getFinalCode(__FUNCTION__));
        }
        //已结束
        if ($nowTime > $activityTime['end']){
            throw new \Exception('活动已结束', self::getFinalCode(__FUNCTION__));
        }
        return true;
    }

    /**
     * @desc 设置登陆用户注册年限level等级
     * @param $userId int
     * @return int
     */
    public static function setUserRegisterLevel($userId)
    {
        $regLevel = 0;
        if ($userId == 0 || empty($userId)){
            return $regLevel;
        }
        $userInfo = UserModel::getCoreApiUserInfo($userId);

        $registerTime = $userInfo['created_at'];

        $year = ToolTime::getYearDiff($registerTime, ToolTime::dbNow()) + 1;
        switch($year)
        {
            case $year == 1:
                $regLevel = self::REGISTER_LEVEL_ONE;
                break;
            case $year == 2:
                $regLevel = self::REGISTER_LEVEL_TWO;
                break;
            case $year >= 3:
                $regLevel = self::REGISTER_LEVEL_THREE;
                break;
        }

        return $regLevel;
    }

    /**
     * @desc 检测用户的等级是否可以领取当前红包
     * @param $bonusArr array
     * @param $bonusId
     * @param $regLevel
     * @return bool|exception
     */
    public static function checkRegisterLevelGetBonus($bonusArr, $bonusId, $regLevel, $userId)
    {
        $userInfo = UserModel::getCoreApiUserInfo($userId);

        $registerTime = date("Y年m月d日", strtotime($userInfo['created_at']));

        if (!isset($bonusArr[$regLevel])){
            throw new \Exception('您当前的等级不能领取红包', self::getFinalCode(__FUNCTION__));
        }
        if ($bonusId != $bonusArr[$regLevel]){
            throw new \Exception('您的注册时间为'.$registerTime.'，请领取对应条件的礼券。', self::getFinalCode(__FUNCTION__));
        }

        return true;
    }

    /**
     * @desc 检测活动期间是否已经领取过优惠券
     * @param $receivedNum int
     * @param $config array
     * @return bool| exception
     */
    public static function checkIfCanGetBonusByTimes($receivedNum, $config)
    {
        //获取活动期间最多可领次数
        $maxNum = self::getMaxBonusNum($config);

        if ($receivedNum >= $maxNum){

            throw new \Exception('很抱歉，您已经领取过了哦~', self::getFinalCode(__FUNCTION__));
        }

        return true;
    }

    /**
     * @desc 检测今天是否已经领取过优惠券
     * @param $receivedNum
     * @param $config
     * @return array
     */
    public static function checkIfCanGetBonusByDay($receivedNum, $config)
    {
        //每天可获取红包数
        $maxNumByDay = self::getMaxBonusNumByDay($config);

        $getByDayStatus = self::getReceivedStatus($config);

        //配置每天领取并且今日已经领取过
        if ($getByDayStatus && $receivedNum >= $maxNumByDay){
            throw new \Exception('今天已经领取过红包了，明天再来噢！', self::getFinalCode(__FUNCTION__));
        }
        return true;
    }

    /**
     * @desc 检测领取的红包是否正确
     * @param $bonusConfig  array
     * @param $bonusId int
     * @return bool|exception
     */
    public static function checkBonusIfRight($bonusConfig, $bonusId)
    {
        if (!in_array($bonusId, $bonusConfig)){
            throw new \Exception('领取红包失败，红包ID没有配置', self::getFinalCode(__FUNCTION__));
        }

        return true;
    }

    /**
     * @desc 获取每天最多可领取红包总数
     * @param $config array
     * @return array
     */
    public static function getMaxBonusNumByDay($config)
    {
        return isset($config['DRAW_NUMBER_EVERY_DAY']) ? $config['DRAW_NUMBER_EVERY_DAY'] : 1;
    }

    /**
     * @desc 获取活动期间最多可领取红包总数
     * @param $config array
     * @return array
     */
    public static function getMaxBonusNum($config)
    {
        return isset($config['DRAW_NUMBER']) ? $config['DRAW_NUMBER'] : 1;
    }

    /**
     * @desc 检测红包是否每天都可以领取[配置]
     * @param $config array
     * @return array
     */
    public static function getReceivedStatus($config)
    {
        return  isset($config['DRAW_CYCLE']) ? $config['DRAW_CYCLE']: false;
    }

}
