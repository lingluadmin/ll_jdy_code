<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 16/9/28
 * Time: 下午7:24
 */

namespace App\Http\Controllers\Pc\Activity;

use App\Http\Controllers\Pc\PcController;
use App\Http\Logics\Activity\DoubleElevenLogic;
use App\Tools\ToolJump;
use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use Illuminate\Http\Request;

class DoubleElevenController extends PcController
{

    public function index(Request $request)
    {
        $userId         =   $this->getUserId();

        $doubleElevenLogic = new DoubleElevenLogic();

        $channel    =   $request->input('channel','');

        $jumpUrl    =   '/activity/doubleEleven' ;

        if( !empty($channel) ){
            $jumpUrl=   $jumpUrl.'?channel=' . $channel ;
        }
        ToolJump::setLoginUrl ($jumpUrl);
        $viewData       =   [
            'activityTime'  =>  DoubleElevenLogic::setActivityTime(),
            'actToken'      =>  DoubleElevenLogic::getActToken(),
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false,
            'channel'           =>  $channel,
            'signData'      => $doubleElevenLogic->getUserSignData($userId, ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN),
            'signTimesAward' => DoubleElevenLogic::getAwardSignTimes(),
            'rechargeBonusList' => DoubleElevenLogic::getBonusRainList($userId),
            'netRechargeConfig' => DoubleElevenLogic::getNetRechargeConfig(),
        ];

        return view("pc.activity.doubleEleven.index", $viewData);
    }

    /**
     * @desc 执行活动签到的操作
     * @param Request $requet array
     * @return json
     */
    public function doSign(Request $request)
    {
        $doubleElevenLogic = new DoubleElevenLogic();

        $data = [
            'user_id' => $this->getUserId(),
            'type'    => ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN,
            ];

        $result = $doubleElevenLogic->doSign($data);

        return self::returnJson($result);
    }

    /**
     * @desc 执行领取净充值红包的操作
     * @param Illuminate\Http\Request $request array
     * @return array
     */
    public function doReceiveRechargeBonus(Request $request)
    {
        $doubleElevenLogic = new DoubleElevenLogic();
        $bonusId = $request->input('bonus_id', 0);
        $bonusCash = $request->input('bonus_cash', 0);

        $data = [
                'user_id' => $this->getUserId(),
                'bonus_id' =>$bonusId,
                'bonus_cash'=>$bonusCash,
            ];

        $result = $doubleElevenLogic->doGetRechargeBonus($data);

        return self::returnJson($result);
    }

    /**
     * @desc 放弃抽奖操作
     * @return json
     */
    public function quitLottery()
    {

        $doubleElevenLogic = new DoubleElevenLogic();
        $data = [
            'user_id' => $this->getUserId(),
            'type'    => ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN,
            ];

        $result  = $doubleElevenLogic->doQuitLottery($data);

        return self::returnJson($result);
    }

    /**
     * @param Request $request
     * @return string
     * @desc  自动加载数据
     */
    public function getDoubleData(Request $request)
    {
        $logic          =   new DoubleElevenLogic();

        $asyncData           =   [
            'rankList'=>$logic->getUserInvestPkList (),
            'projectList'=> $logic->getProjectList ()
        ];

        return self::returnJson ($asyncData);
    }


}
