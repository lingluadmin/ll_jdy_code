<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 2017/2/21
 * Time: 下午2:37
 */

namespace App\Http\Controllers\Pc\Activity;


use App\Http\Controllers\Pc\PcController;
use App\Http\Logics\Activity\CouponLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;

class CouponController extends PcController
{
    public function coupon(Request $request)
    {
        ToolJump::setLoginUrl('/activity/coupon');

        $userId         =   $this->getUserId();

        $viewData       =   [
            'activityTime'  =>   CouponLogic::setTime(),
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false,
            'actToken'      =>  CouponLogic::getActToken(),
        ];

        return view('pc.activity.coupon.index',$viewData);
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
