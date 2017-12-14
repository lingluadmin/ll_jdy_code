<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/7/15
 * Time: 下午4:48
 */

namespace App\Tools;

use App\Http\Logics\User\SessionLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Logics\Notice\NoticeLogic;
use App\Http\Logics\User\UserLogic;

/**
 * 视图间公用变量
 *
 * Class ViewShare
 * @package App\Tools
 */
class ViewShare
{
    const
        PRE = "view_",

        END = true;

    /**
     * 设置变量
     */
    public static function set(){
        // 视图公用的变量
        view()->share(
            self::PRE . 'ssl', ToolUrl::is_ssl()
        );

        // 用户信息
        view()->share(
            self::PRE . 'user', SessionLogic::getTokenSession()
        );


        $userId = SessionLogic::getTokenSession()['id'];
        // 用户总资产
        $totalAmount = UserLogic::getUserTotalAmount($userId);
        view()->share(
            self::PRE . 'user_total_amount', $totalAmount
        );

        //优惠券
        $userBonusLogic = new UserBonusLogic();
        $bonus = [
            'ableUserBonusCount' => $userBonusLogic->getAbleUserBonusCount($userId, true),
            ];
        view()->share(
            self::PRE.'bonus',$bonus
        );
        //消息通知
        $notice =   [
            'ableUserUnreadNotice'  =>  NoticeLogic::getUserUnReadNoticeTotal($userId),
       ];
        view()->share(
            self::PRE.'notice',$notice
        );
    }
}
