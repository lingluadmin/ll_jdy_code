<?php
/**
 * Created by 9douyu Coder.
 * User: scofie wu.changming@9douyu.com
 * Date: 15/05/2017.
 * Time: 6:13 PM.
 * Desc: ActivityController.php.
 */

namespace App\Http\Controllers\Weixin\Activity;


use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Activity\CelebrationLoanLogic;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;

class ActivityController extends WeixinController
{

    public function setActToken( Request $request)
    {
        $actToken   =   $request->input('act_token') ;

        return ActivityLogic::setActToken($this->getUserId () ,$actToken) ;
    }

    /**
     * @param Request $request
     * @desc 庆祝小贷工商注册完成的活动
     */
    public function CelebrationLoan( Request $request)
    {
        ToolJump::setLoginUrl('/activity/Loan');

        $activityTime   =   CelebrationLoanLogic::setTime();

        $viewData   =   [
            'activityTime'  =>  $activityTime,
        ];

        return view('wap.activity.loan.index', $viewData);
    }

    /**
     * @param Request $request
     * @desc 领取红包
     */
    public function doDrawBonus( Request $request)
    {
        $userId     =   $this->getUserId ();

        $bonusValue =   $request->input('custom' ,'percentile');


        $timeStatus  =   CelebrationLoanLogic::isCanReceiveBonusTimes($userId, $bonusValue);

        if( $timeStatus['status'] == false ) {

            return $timeStatus;
        }

        $actStatus  =   CelebrationLoanLogic::isCanReceiveBonus($userId, $bonusValue) ;

        if( $actStatus['status'] == false ) {

            return $actStatus;
        }

        return CelebrationLoanLogic::doReceiveBonus( $userId,  $bonusValue) ;

    }
}