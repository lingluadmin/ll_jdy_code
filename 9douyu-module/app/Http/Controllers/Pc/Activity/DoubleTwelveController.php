<?php
/**
 * Created by PhpStorm.
 * User: tianxiaoyan
 * Date: 17/11/30
 * Time: 下午2:13
 */

namespace App\Http\Controllers\Pc\Activity;


use App\Http\Controllers\Pc\PcController;
use App\Http\Logics\Activity\DoubleTwelveLogic;
use App\Tools\ToolJump;
use App\Http\Logics\Activity\AutumnNationLogic;
use Illuminate\Http\Request;
use App\Http\Dbs\Bonus\BonusDb;

class DoubleTwelveController extends PcController
{

    public function index(Request $request)
    {
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
        ];

        return view("pc.activity.doubleTwelve.index",$viewData);
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
