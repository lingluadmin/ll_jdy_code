<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 8/29/17
 * Time: 3:47 PM
 */

namespace App\Http\Logics\Activity;

use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Dbs\Activity\ActivityPresentDb;
use App\Http\Dbs\Media\InviteDb;
use App\Http\Dbs\Notice\NoticeDb;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Media\InviteLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Models\Activity\ActivityPresentModel;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic;
use App\Http\Models\Common\NoticeModel;
use App\Http\Models\Common\ValidateModel;
use App\Lang\LangModel;

class ActivityPresentLogic extends ActivityLogic
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
        return   time() . '_' . self::setEventId() ;
    }

    /**
     * @return mixed
     * @desc novice project
     */
    public static function getNoviceProject()
    {
        //App4.0首页定期项目列表
        $projectLogic   = new ProjectLogic();

        $projectArr     = $projectLogic->getProjectPackAppV413();

        return isset($projectArr['novice']) ? $projectArr['novice'] : current ($projectArr);
    }
    /**
     * @param $data
     * @return array
     * @desc send user  present
     */
    public static function doImplementSendPresent($data)
    {
        //判断投资金额
        if( $data['cash'] < self::getInvestMinCash() ) {

            return self::callError ('投资金额不满足条件');
        }

        //判断用户是否在指定的推广渠道
        if( self::validUserInvite($data['user_id']) ) {
            return self::callError ('用户不在推广渠道内');
        }

        //是否是新手首次投资定期
        $userInvest =   TermLogic::getUserInvestDataByUserId ($data['user_id']);

        if( isset($userInvest['total']) && $userInvest['total'] !=1 ) {

            return self::callError ('不满足新手首次投资定期');
        }

        return UserLogic::doInsertUserBalance($data['user_id'], self::getAwardCash(), self::getActivityNote(self::setEventId ()), self::setEventId () ) ;
    }

    /**
     * @return string
     * @desc format notice message
     */
    public static function getNoticeMessage()
    {
        return sprintf ( self::getSendNoticeMessageTemplate () , self::getAwardCash () ) ;
    }

    /**
     * @return string
     * @desc format phone  message
     */
    public static function  getPhoneMessage()
    {
        return  sprintf ( self::getSendPhoneMessageTemplate () , self::getAwardCash () ) ;
    }
    /**
     * @param $userId
     * @return bool
     * @desc valid user invite
     */
    public static function validUserInvite($userId)
    {
        $userInvite     =   self::getUserInviteFromChannel($userId) ;

        if( !$userInvite  ) return false ;

        $inviteGroup    =   self::getCanSendPresentInvite() ;

        if( empty($inviteGroup) )return false;

        if( !in_array ($userInvite, $inviteGroup)) {
            return false;
        }

        return true ;
    }

    /**
     * @return bool
     * desc valid activity time
     */
    public static function validActivityTime()
    {
        $config     =   self::config () ;

        if( $config['START_TIME'] > time () || $config['END_TIME'] < time () ) {

            return false ;
        }

        return true ;
    }

    /**
     * @param $userId
     * @return array
     * @desc search user register from media invite
     */
    public static function getUserInviteFromChannel($userId)
    {
        $inviteDb   =   new InviteDb() ;

        $userInvite =   $inviteDb->getInviteByUserId ($userId) ;

        return isset($userInvite['channel_id']) ? $userInvite['channel_id'] : '' ;
    }

    /**
     * @return bool
     * @desc 自动发放的开关
     */
    public static function isAuto()
    {
        $config =   self::config ();

        if( isset($config['SYSTEM_AUTO_AWARD']) && trim($config['SYSTEM_AUTO_AWARD']) == 'open') {
            return true ;
        }
        return false;
    }
    /**
     * @return int
     */
    public static function getInvestMinCash()
    {
        $config     =   self::config () ;

        return isset($config['INVEST_MIN_CASH']) ? (int)$config['INVEST_MIN_CASH'] : 100 ;
    }

    /**
     * @return int|mixed
     * @desc award cash
     */
    public static function getAwardCash()
    {
        $config     =   self::config () ;

        return  isset($config['AWARD_CASH']) ? $config['AWARD_CASH'] : 50 ;
    }
    /**
     * @return array
     * @desc can send present channel
     */
    protected static function getCanSendPresentInvite()
    {
        $config =   self::config ();

        if( !isset($config['CHANNEL_TEXT']) || empty($config['CHANNEL_TEXT']) ) {
            return[] ;
        }

        return array_filter (explode (',', $config['CHANNEL_TEXT']) );
    }
    /**
     * @return mixed|string
     * @desc get send notice template
     */
    protected static function getSendNoticeMessageTemplate()
    {
        $config =   self::config () ;

        return isset($config['NOTICE_TEMPLATE']) ? $config['NOTICE_TEMPLATE'] : LangModel::getLang ('ACTIVITY_MOVIE_NOTICE_TEMPLATE') ;
    }

    /**
     * @return mixed|string
     * @desc get send phone message template
     */
    public static function getSendPhoneMessageTemplate()
    {
        $config =   self::config () ;

        return isset($config['PHONE_TEMPLATE']) ? $config['PHONE_TEMPLATE'] : LangModel::getLang ('ACTIVITY_MOVIE_PHONE_TEMPLATE') ;
    }

    /**
     * @return int
     * @desc activity only event
     */
    protected static function setEventId()
    {
        return ActivityFundHistoryDb::SOURCE_ACTIVITY_MOVIE_LOTTERY ;
    }
    /**
     * @return Common\格式化后的活动配置文件|array
     *
     */
    protected static function config()
    {
        return  AnalysisConfigLogic::make ('ACTIVITY_MOVIE_CONFIG') ;
    }

}
