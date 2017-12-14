<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 2017/2/21
 * Time: 下午2:37
 */

namespace App\Http\Controllers\WeiXin\Activity;


use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Activity\ActivityPresentLogic;
use App\Http\Logics\Activity\CouponLogic;
use App\Http\Logics\Activity\LandonLogic;
use App\Http\Logics\Media\ChannelLogic;
use App\Http\Logics\Partner\PartnerLogic;
use App\Http\Logics\RequestSourceLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LandonController extends WeixinController
{

    public function index(Request $request)
    {
        $channel    =   $request->input('channel','');

        $jumpUrl    =   '/activity/landon' ;

        $redirect   =  '/activity/landonSuccess';

        if( !empty($channel) ){
            $jumpUrl=   '/activity/landon?channel=' . $channel ;
            $redirect   =  '/activity/landonSuccess?channel=' . $channel ;

        }
        ToolJump::setLoginUrl ($jumpUrl);

        $logic      = new ChannelLogic();

        $package    = $logic->getPackage($channel);//推广包名

        $viewData   =   [
            'activityTime'  =>  ActivityPresentLogic::setTime (),
            'actToken'      =>  '',
            'channel'       =>  $channel,
            'project'       =>  ActivityPresentLogic::getNoviceProject (),
            'userStatus'    =>  $this->checkLogin(),
            'backUrl'       =>  $jumpUrl,
            'redirect_url'  =>  $redirect,
            'package'       =>  $package
        ];

        return view('wap.activity.landon.index', $viewData);

    }
    public function success(Request $request)
    {
        $channel    =   $request->input('channel');

        $redirectUrl=   '/activity/landon';

        if( !empty($channel) ) {
            $redirectUrl    =   '/activity/landon?channel=' . $channel ;
        }
        if ( !$this->checkLogin() ) {
            return Redirect::to($redirectUrl)->with('errorMsg', '未登录');
        }
        $logic      = new ChannelLogic();

        $package    = $logic->getPackage($channel);//推广包名
        $viewData   =   [
            'package'       =>  $package
        ];
        return view('wap.activity.landon.success', $viewData);

    }
    
}
