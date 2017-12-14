<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 2017/2/21
 * Time: 下午2:37
 */

namespace App\Http\Controllers\WeiXin\Activity;


use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Activity\CouponLogic;
use App\Http\Logics\Partner\PartnerLogic;
use App\Http\Logics\RequestSourceLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;

class CouponController extends WeixinController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 春风十里活动wap端
     */
    public function coupon(Request $request)
    {
        $client         =   RequestSourceLogic::getSource();

        ToolJump::setLoginUrl('/activity/coupon');

        $userId         =   $this->getUserId();

        $viewData       =   [
            'activityTime'  =>  CouponLogic::setTime(),
            'client'        =>  $client,
            'actToken'      =>  CouponLogic::getActToken(),
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false
        ];

        return view('wap.activity.coupon.coupon',$viewData);
    }

    /**
     * @param Request $request
     * @return array
     * @desc 活动页数据包
     */
    public function getLotteryPacket( Request $request)
    {
        $userId         =   $this->getUserId();

        $packetData       =   [
            'projectList'   =>  CouponLogic::getProjectList(),
            'lotteryInfo'   =>  CouponLogic::getCouponLottery(),
            'couponBonus'   =>  CouponLogic::getBonusList(),
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false,
        ];

        return  $packetData ;
    }
    /**
     * @param Request $request
     * @return array
     * @desc 执行红包的领取
     */
    public function doReceiveBonus(Request $request)
    {
        $userId         =   $this->getUserId();

        $customValue    =   $request->input('custom_value','');
        //时间判断
        $receiveStatus  =   CouponLogic::isCanReceiveBonus($userId,$customValue);

        if( $receiveStatus['status'] ==false ){

            return $receiveStatus;
        }

        return  CouponLogic::doReceiveBonus($userId,$customValue);
    }
}
