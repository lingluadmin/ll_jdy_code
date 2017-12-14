<?php
/**
 * Created by PhpStorm.
 * User: tianxiaoyan
 * Date: 16/12/27
 * Time: 下午5:00
 */

namespace App\Http\Controllers\Weixin\Activity;

use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Activity\DoubleTwelveLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Models\SystemConfig\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\Activity\ReceiveBonusLogic;
use App\Tools\ToolJump;

class DoubleTwelveController extends WeixinController{
   

    public function index(Request $request)
    {
        $client     =   RequestSourceLogic::getSource();

        $userId     =   $this->getUserId ();

        $channel    =   $request->input('channel','');

        $jumpUrl    =   '/activity/doubleTwelve' ;

        if( !empty($channel) ){
            $jumpUrl=   $jumpUrl.'?channel=' . $channel ;
        }

        ToolJump::setLoginUrl ($jumpUrl);

        $activityObject  =   new DoubleTwelveLogic();

        $viewData   =   [
            'activityTime'  =>  $activityObject->activityTime,
            'actToken'      =>  $activityObject->actToken,
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false,
            'client'        =>  $client,
            'channel'       =>  $channel,
        ];

        return view('wap.activity.doubleTwelve.index', $viewData);
    }


    /**
     * @param Request $request
     * @return string
     * @desc 页面数据
     */
    public function getDoubleData(Request $request)
    {
        $activityObject  =   new DoubleTwelveLogic();

        $asyncData           =   [
            'bonusList'=>$activityObject->getUserReceiveBonus ($this->getUserId ()),
            'projectList'=> $activityObject->getProjectList ()
        ];

        return self::returnJson ($asyncData);
    }

    /**
     * @param Request $request
     * @return string
     * @desc 领取红包
     */
    public function doReceiveBonus(Request $request)
    {
        $logic   =   new DoubleTwelveLogic();

        $bonus = $request->input('receive_bonus', '');

        $result = $logic->doReceiveBonus($this->getUserId (), $bonus);

        return self::returnJson($result);
    }
    
}