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
use App\Http\Logics\Activity\PromotionLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Models\Common\ValidateModel;
use Illuminate\Http\Request;

class NoviceController extends PcController
{

    public function extension(Request $request )
    {
        $channel        =   $request->input('channel');

        $registerUrl    =   '/register';

        if( !empty($channel) ){

            $registerUrl=   $registerUrl."?channel=".$channel;
        }

        //新手项目
        $projectNovice     =    ActivityPresentLogic::getNoviceProject();

        $userId            =    $this->getUserId ();

        $viewData   =   [
            'userStatus'     =>  $this->checkLogin() ,
            'registerUrl'    =>  $registerUrl,
            'project'        =>  $projectNovice,
            'isNovice'       =>  ValidateModel::isNoviceInvestUser($userId,false),
            'investList'     =>  PromotionLogic::getNewInvestList(30),
            ];

        return view("pc.activity.novice.second",$viewData);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Laravel\Lumen\Http\Redirector
     * @desc 跳转到新首页
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 百度落地页
     */
    public function extensionChannel(Request $request)
    {
        $channel        =   $request->input('channel');

        $registerUrl    =   '/activity/extension';

        if( !empty($channel) ){

            $registerUrl=   $registerUrl."?channel=".$channel;
        }

        //新手项目
        $projectNovice     =    ActivityPresentLogic::getNoviceProject();

        $userId            =    $this->getUserId ();

        $viewData   =   [
            'userStatus'     =>  $this->checkLogin() ,
            'registerUrl'    =>  $registerUrl,
            'project'        =>  $projectNovice,
            'channel'        =>  $channel ,
            'isNovice'       =>  ValidateModel::isNoviceInvestUser($userId,false),
            'investList'     =>  PromotionLogic::getNewInvestList(30),
        ];

        return view("pc.activity.baidu.extension_baidu",$viewData);
    }


}
