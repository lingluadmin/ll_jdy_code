<?php
/**
 * Created by PhpStorm.
 * User: tianxiaoyan
 * Date: 16/12/27
 * Time: 下午5:00
 */

namespace App\Http\Controllers\Weixin\Activity;

use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Activity\InsideLotteryLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Models\SystemConfig\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\Activity\ReceiveBonusLogic;
use App\Tools\ToolJump;

class InsideLotteryController extends WeixinController{


    public function index(Request $request)
    {
        $client         =   RequestSourceLogic::getSource();

        $channel        =   $request->input('channel','');

        $jumpUrl        =   '/activity/inside' ;

        if( !empty($channel) ){
            $jumpUrl    =   $jumpUrl.'?channel=' . $channel ;
        }

        ToolJump::setLoginUrl ($jumpUrl);

        $insideLogic    =   new InsideLotteryLogic();

        $viewData       =   [
            'activityTime'  =>  $insideLogic->setActivityTime(),
            'client'        =>  $client,
            'channel'       =>  $channel,
            'backUrl'       =>  $jumpUrl,
            'userStatus'    =>  $this->getUserId () > 0 ? true :false,
            'actToken'      =>  $insideLogic->getActToken(),
            'lotteryList'   =>  $insideLogic->getLotteryList()
        ];

        return view('wap.activity.lottery.lottery', $viewData);
    }

    /**
     * @param Request $request
     * @return array
     * @desc this controller is user lottery inside api
     */
    public function doLuckDraw( Request $request)
    {
        $userId         =   $this->getUserId ();

        $insideLogic    =   new InsideLotteryLogic();

        $activity       =   $insideLogic->validActivityStatus ($userId);

        if( $activity['status'] == false )
            return $activity ;

        $lottery        =   $insideLogic->validUserInsideLotteryTimes ($userId);

        if( $lottery['status'] == false )
            return $lottery;

        return  $insideLogic->doLottery ($userId);
    }


}
