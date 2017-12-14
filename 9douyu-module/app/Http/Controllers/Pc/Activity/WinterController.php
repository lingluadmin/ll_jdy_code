<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 16/9/28
 * Time: 下午7:24
 */

namespace App\Http\Controllers\Pc\Activity;


use App\Http\Controllers\Pc\PcController;
use App\Http\Logics\Activity\WinterLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;

class WinterController extends PcController
{

    public function index( Request $request)
    {
        $userId     =   $this->getUserId();

        $channel    =   $request->input('channel','');

        $jumpUrl    =   '/activity/winter' ;

        if( !empty($channel) ){
            $jumpUrl=   $jumpUrl.'?channel=' . $channel ;
        }
        ToolJump::setLoginUrl ($jumpUrl);

        $viewData       =   [
            'activityTime'  =>  WinterLogic::setActivityTime(),
            'actToken'      =>  WinterLogic::getActToken(),
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false,
            'channel'           =>  $channel,
        ];

        return view("pc.activity.winter.index",$viewData);
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
