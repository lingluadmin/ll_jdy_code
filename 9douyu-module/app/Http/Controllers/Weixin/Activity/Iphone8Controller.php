<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 2017/2/21
 * Time: 下午2:37
 */

namespace App\Http\Controllers\WeiXin\Activity;


use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Activity\IphoneActivityLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Iphone8Controller extends WeixinController
{

    public function index(Request $request)
    {

        $channel    =   $request->input('channel','');

        $jumpUrl    =   '/activity/iphone8' ;

        if( !empty($channel) ){
            $jumpUrl=   '/activity/iphone8?channel=' . $channel ;
        }
        $logic      =   new IphoneActivityLogic();

        ToolJump::setLoginUrl ($jumpUrl);
        if( empty($channel) ) {
            $channel=   $logic->getDefaultChannel ();
        }
        $userId     =   $this->getUserId ();
        if( $userId !=0 ) {
            $userRegister   =   $logic->isRegisterInActivityTime($userId);
            if($userRegister['status'] == false ) {
                return Redirect::to($logic->getOldUserActivityUrl());
            }
        }
        $weChat = app('wechat');

        $viewData   =   [
            'activityTime'      =>  $logic->setTime (),
            'userStatus'        =>  $userId != 0 ? true :false,
            'actToken'          =>  $logic->getActToken (),
            'lotteryList'       =>  $logic->getLotteryList (),
            'redirect_url'      =>  $jumpUrl,
            'backUrl'           =>  $jumpUrl,
            'channel'           =>  $channel,
            'exchange'          =>  $logic->getUserOneLotteryInfo ($userId),
            'shareConfig'       =>  $logic->getShareInfo (),
            'js'                =>  $weChat->js,
            'verify'            =>  $this->getVerifyStatus ()
        ];

        return view('wap.activity.iphone8.index', $viewData);
    }

    public function doLuck( Request $request)
    {
        $userId     =   $this->getUserId ();

        $logic      =   new IphoneActivityLogic();

        $activity   =   $logic->validActivityStatus ($userId);

        if( $activity['status'] == false )
            return $activity ;

        $lottery    =   $logic->validUserLotteryStatus ($userId);
        if( $lottery['status'] == false )
            return $lottery;

        return  $logic->doLuck ($userId);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Laravel\Lumen\Http\Redirector
     * @desc 跳转到新手投资页
     */
    public function toInvestNovice()
    {
        $projectLogic = new ProjectLogic();

        //新手项目
        $projectArr     = $projectLogic->getProjectPackAppV413();
        $projectNovice  = !empty($projectArr['novice']) ? $projectArr['novice'] : [];

        if( empty($projectNovice) ) {
            return redirect('/project/lists');
        }
        return redirect('/project/detail/' . $projectNovice['id']);
    }

//    /**
//     * @param Request $request
//     * @return array
//     * @desc 测试中奖概率的接口
//     */
//    public function doTestLuck(Request $request)
//    {
//        $logic      =   new IphoneActivityLogic();
//
//        $userId     =   $this->getUserId () ? $this->getUserId () :'289946' ;
//
//        return  $logic->doLuck ($userId);
//    }


}
