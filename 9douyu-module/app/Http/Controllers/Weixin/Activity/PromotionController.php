<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/10/11
 * Time: 下午2:14
 * Desc: 推广相关
 */

namespace App\Http\Controllers\Weixin\Activity;

use App\Http\Logics\Activity\ActivityPresentLogic;
use App\Http\Logics\Partner\PartnerLogic;
use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Activity\PromotionLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\SystemConfig\SystemConfigLogic;
use App\Http\Models\Common\ValidateModel;
use App\Tools\ToolJump;
use Illuminate\Http\Request;
use App\Http\Logics\Media\ChannelLogic;
use Redirect;

class PromotionController extends WeixinController{


    public function index( Request $request )
    {

//        if( $this->checkLogin() ){
//
//            return Redirect::to('/user');
//
//        }

        $logic      = new ChannelLogic();

        $promotionLogic =   new PromotionLogic();

        $channel    =   $request->input('channel','');

        $timeArr    =   $promotionLogic->getTime();

        $registerUrl    =   '/register';

        if( !empty($channel) ){

            $registerUrl=   $registerUrl."?channel=".$channel;
        }

        ToolJump::setLoginUrl ($_SERVER['REQUEST_URI']);

        $package    = $logic->getPackage($channel);//推广包名

        $configArr  = SystemConfigLogic::getConfig('PROMOTION');

        $projectNovice     =    ActivityPresentLogic::getNoviceProject();

        $viewData   =   array(
            'userStatus'    =>  $this->checkLogin(),
            'activityTime'  =>  $timeArr,
            'actToken'      =>  '',
            'channel'       =>  $channel ,
            'package'       =>  $package ,
            'registerWord'  =>  isset($configArr['register_word']) ? $configArr['register_word'] : '提交注册',
            'project'       =>  $projectNovice,
            'isNovice'      =>  ValidateModel::isNoviceInvestUser($this->getUserId (),false),
            'investList'    =>  PromotionLogic::getNewInvestList(30),
            'registerUrl'   =>  $registerUrl,
            'client'        =>  $request->input('client',''),
        );
        if($timeArr['start'] > time() ){
            return view('wap/activity/novice/extension1', $viewData);
        }
        return view('wap.activity.novice.index1016', $viewData);

    }

    public function success( Request $request )
    {
        /*
        if( $this->checkLogin() ){

            return Redirect::to('/user');

        }
        */
        $data['phone'] = $request->input('phone');

        $logic = new ChannelLogic();

        $channel = $request->input('channel','');

        $data['package'] = $logic->getPackage($channel);//推广包名

        $configArr = SystemConfigLogic::getConfig('PROMOTION');

        $data['awardWord'] = isset($configArr['award_word']) ? explode('|', $configArr['award_word']) : '';

        //$data['channel_url'] = '/zt/appguide?channel='.$request->input('channel', '');
        $promotionLogic =   new PromotionLogic();

        $timeArr        =   $promotionLogic->getTime();
        if($timeArr['start'] > time() ){
            return view('wap/activity/novice/arrival', $data);
        }
       return view('wap.activity.novice.arrival1',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 理财列表页
     */
    public function noviceProjectList(Request $request)
    {

        $client     =   RequestSourceLogic::getSource();

        $token      =   $request->input('token');

        $logic      =   new PromotionLogic();

        $project    =   $logic->getFormatProject();

        $viewData   =   [
            'creditProject' => $project['show'],
            'moreProject'   => $project['more'],
            'currentProject'=> $project['current'],
            'client'    =>  $client,
        ];

        return view('wap/activity/novice/product',$viewData);
    }


    // 新手狂欢

    public function introduce(Request $request)
    {
//        $client         =   RequestSourceLogic::getSource();
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            $client = "ios";
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            $client = "android";
        }else{
            $client = "wap";
        }

        $token          =   $request->input('token');

        $userId         =   $this->getUserId();

        if($client == 'android' && $userId){

            $partnerLogic   =   new PartnerLogic();

            $partnerLogic->setCookieAndroid($token, $client);
        }

        $promotionLogic =   new PromotionLogic();

        //$statistics     =   $promotionLogic->getStatistics();

        $activityTime   =   $promotionLogic->getTime();

        $viewData       =   [
            //'data'           =>  $statistics,
            'activityTime'   =>  $activityTime,
            'client'         =>  $client,
            'userStatus'     => (!empty($userId)||$userId!=0) ? true : false,
            ];

        return view('wap.activity.novice.introduce',$viewData);
    }

    // ROI注册落地页
    public function roiIndex( Request $request )
    {

        $data['isLogin'] = $this->checkLogin() ? 1 : '';

        $logic = new ChannelLogic();

        $promotionLogic = new PromotionLogic();

        $projectLogic = new ProjectLogic();

        $project = $projectLogic->getPfbProjectDetail();
        $data['project'] = $project['data'];

        $channel = $request->input('channel', '');

        $data['channel'] = $channel;

        $data['package'] = $logic->getPackage($channel);//推广包名

        //$statistics = $promotionLogic->getStatistics();

        //$data = array_merge($data, $statistics);

        $roiProjectId = !empty($project['data']['id']) ? $project['data']['id'] : '';
        \Session::put("roiProjectId", $roiProjectId);

        return view('wap.activity.novice.another', $data);
    }

    // 新手活动20171016

    public function index1016(Request $request)
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

        return view('wap.activity.novice.index1016', $viewData);

    }

    // 百度落地页推广

     public function extensionChannel( Request $request )
    {
        
        $logic      = new ChannelLogic();

        $promotionLogic =   new PromotionLogic();

        $channel    =   $request->input('channel','');

        $timeArr    =   $promotionLogic->getTime();

        $registerUrl    =   '/activity/extension';

        if( !empty($channel) ){

            $registerUrl=   $registerUrl."?channel=".$channel;
        }

        ToolJump::setLoginUrl ($_SERVER['REQUEST_URI']);

        $package    = $logic->getPackage($channel);//推广包名

        $projectNovice     =    ActivityPresentLogic::getNoviceProject();

        $viewData   =   array(
            'userStatus'    =>  $this->checkLogin(),
            'activityTime'  =>  $timeArr,
            'actToken'      =>  '',
            'channel'       =>  $channel ,
            'package'       =>  $package ,
            'project'       =>  $projectNovice,
            'isNovice'      =>  ValidateModel::isNoviceInvestUser($this->getUserId (),false),
            'investList'    =>  PromotionLogic::getNewInvestList(30),
            'registerUrl'   =>  $registerUrl,
            'client'        =>  $request->input('client',''),
        );
        
        return view('wap.activity.baidu.index_baidu', $viewData);

    }
}
