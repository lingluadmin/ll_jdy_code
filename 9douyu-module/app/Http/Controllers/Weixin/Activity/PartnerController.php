<?php
/**
 * Created by PhpStorm.
 * User: liuqiuhui
 * Date: 16/7/11
 * Time: 下午8:16
 */

namespace App\Http\Controllers\Weixin\Activity;


use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Partner\PartnerLogic;
use App\Http\Logics\SystemConfig\SystemConfigLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;
use EasyWeChat\Support\Url;
use App\Http\Logics\Weixin\WechatLogic;
use Redirect;

class PartnerController extends WeixinController
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 合伙人活动首页
     */
    public function index(Request $request){

        $userId = $this->getUserId();

        $partnerLogic = new PartnerLogic();

        if( $request->input('client') == 'android' && $userId ){

            $token = strtolower($request->input('token'));

            $partnerLogic->setCookieAndroid($token, $request->input('client'));

        }

        //获取合伙人活动配置
        $data['shareConfig'] = SystemConfigLogic::getConfig('WX_ACTIVE_INVITE');

        if( $userId ){

            $data['shareConfig']['line_link'] = $data['shareConfig']['line_link'].'?inviteId='.$userId;

        }

        $wechat = app('wechat');

        $data['js'] = $wechat->js;

        //获取邀请排行前三名
        $limit = 3;
        $partnerLogic = new PartnerLogic();

        $sortList = $partnerLogic->getInterestCashSort($limit);
        $partnerInfo = $partnerLogic->getUserIndexData($userId);

        $data['partner_info'] = $partnerInfo;
        $data['list'] = $sortList;

           return view('wap.activity.partner3.share',$data);
//        return view('wap.activity.partner3.partner4', $data);
//        return view('wap.activity.partner.index', $view);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 邀请好友分享页面 20170613
     */
    public function rule()
    {
        $userId = $this->getUserId();

        //获取合伙人活动配置
        $data['shareConfig'] = SystemConfigLogic::getConfig('WX_ACTIVE_INVITE');
        $data['shareConfig']['line_link'] = !empty($data['shareConfig']['line_link']) ? $data['shareConfig']['line_link'] : '';
        if( $userId ){

            $data['shareConfig']['line_link'] = $data['shareConfig']['line_link'].'?inviteId='.$userId;

        }

        $wechat = app('wechat');

        $data['js'] = $wechat->js;

        return view('wap.activity.partner3.rule',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 邀请好友分享页面 20171121
     */

    public function invite(Request $request)
    {
        $userId = $this->getUserId();
        //获取合伙人活动配置
        $data['shareConfig'] = SystemConfigLogic::getConfig('WX_ACTIVE_INVITE');

        if( $userId ){
            $data['shareConfig']['line_link'] = $data['shareConfig']['line_link'].'?inviteId='.$userId;
        }else{
            $data['shareConfig']['line_link'] = Url::current();
            $data['shareConfig']['desc_content'] = '九斗鱼合伙人计划';
        }
        $data['sdk'] = WechatLogic::jsSdk();

        $wechat = app('wechat');
        $data['js'] = $wechat->js;
        //获取邀请排行前三名
        $limit = 3;
        $partnerLogic = new PartnerLogic();

        $sortList = $partnerLogic->getInterestCashSort($limit);
        $partnerInfo = $partnerLogic->getUserIndexData($userId);

        $data['partner_info'] = $partnerInfo;
        $data['list'] = $sortList;
        $data['uid']  = $userId;

        return view('wap.activity.partner3.invite', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 邀请规则 20171121
     */

    public function inviteRule(Request $request)
    {
        return view('wap.activity.partner3.inviterule', []);
    }
    


}
