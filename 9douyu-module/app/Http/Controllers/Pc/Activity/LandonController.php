<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 16/9/28
 * Time: 下午7:24
 */

namespace App\Http\Controllers\Pc\Activity;

use App\Http\Controllers\Pc\PcController;
use App\Http\Logics\Activity\ActivityPresentLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class LandonController extends PcController
{
    
    public function index( Request $request)
    {
        $channel    =   $request->input('channel','');

        $jumpUrl    =   '/activity/landon' ;

        if( !empty($channel) ){
            $jumpUrl=   '/activity/landon?channel=' . $channel ;
        }
        ToolJump::setLoginUrl ($jumpUrl);

        $viewData   =   [
            'activityTime'  =>  ActivityPresentLogic::setTime (),
            'actToken'      =>  '',
            'channel'       =>  $channel,
            'project'       =>  ActivityPresentLogic::getNoviceProject (),
            'userStatus'    =>  $this->checkLogin(),
            'backUrl'       =>  $jumpUrl
        ];

        return view("pc.activity.landon.index" ,$viewData);
    }
    
    public function success(Request $request)
    {
        $channel    =   $request->input('channel');

        $redirectUrl=   '/activity/landon';

        if( !empty($channel) ) {
            $redirectUrl    =   '/activity/landon?channel=' . $channel ;
        }
        if ( !$this->checkLogin()) {
            return Redirect::to($redirectUrl)->with('errorMsg', '未登录');
        }

        return view("pc.activity.landon.success");
    }

}