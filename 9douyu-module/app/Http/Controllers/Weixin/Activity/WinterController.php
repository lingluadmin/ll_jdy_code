<?php
/**
 * Created by PhpStorm.
 * User: bichunfeng
 * Date: 17/11/16
 * Time: 上午10:00
 */

namespace App\Http\Controllers\Weixin\Activity;

use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Logics\Activity\WinterLogic;
use App\Http\Models\SystemConfig\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\Activity\ReceiveBonusLogic;
use App\Tools\ToolJump;

class WinterController extends WeixinController{


    public function index(Request $request)
    {
        $client     =   RequestSourceLogic::getSource();

        $userId     =   $this->getUserId();

        $channel    =   $request->input('channel','');

        $jumpUrl    =   '/activity/winter' ;

        if( !empty($channel) ){
            $jumpUrl=   $jumpUrl.'?channel=' . $channel ;
        }
        ToolJump::setLoginUrl ($jumpUrl);

        $viewData   =   [
            'activityTime'  =>  WinterLogic::setActivityTime (),
            'actToken'      =>  WinterLogic::getActToken(),
            'client'        =>  $client,
            'channel'       =>  $channel,
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false,
        ];
        return view('wap.activity.winter.index', $viewData);
    }


    /**
     * @param Request $request
     * @return string
     * @desc 自动加载数据
     */
    public function getSyncViewData(Request $request)
    {
        $logic      =   new WinterLogic();

        $asyncData  =   [

            'package'     =>  $logic->validUserPullDownPackage($this->getUserId ()),
            'projectList'=>  $logic->getProjectList ()
        ];

        return self::returnJson ($asyncData);
    }

    /**
     * @param Request $request
     * @return array
     * @desc 用户领取礼包
     */
    public function doReceivePackage(Request $request)
    {
        $logic      =   new WinterLogic();

        return $logic->doReceivePackage($this->getUserId ());
    }
}
