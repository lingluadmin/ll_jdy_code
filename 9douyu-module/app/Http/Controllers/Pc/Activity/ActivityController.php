<?php
/**
 * Created by 9douyu Coder.
 * User: scofie wu.changming@9douyu.com
 * Date: 15/05/2017.
 * Time: 5:49 PM.
 * Desc: ActivityController.php.
 */

namespace App\Http\Controllers\Pc\Activity;


use App\Http\Controllers\Pc\PcController;
use App\Http\Logics\Activity\CelebrationLoanLogic;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;

class ActivityController extends PcController
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

        $currentSec = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';
        if($currentSec=='https'){
            $schemaHttp = env('STATIC_URL_HTTPS');
        }else{
            $schemaHttp = env('STATIC_URL');
        }

        $viewData   =   [
            'activityTime' => $activityTime,
            'schema'       => $schemaHttp
        ];

        return view("pc.activity.loan.index" ,$viewData);
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