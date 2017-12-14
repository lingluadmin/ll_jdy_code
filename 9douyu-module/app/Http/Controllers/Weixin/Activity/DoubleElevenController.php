<?php
/**
 * Created by lili.
 * User: lili
 * Date: 17/10/19
 * Time: 10:00 am
 */

namespace App\Http\Controllers\Weixin\Activity;

use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Activity\DoubleElevenLogic;
use App\Http\Logics\Activity\IphoneActivityLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Models\Activity\ActivitySignModel;
use App\Http\Logics\Logic;
use App\Http\Models\SystemConfig\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\Activity\ReceiveBonusLogic;
use App\Tools\ToolJump;
use App\Http\Logics\Weixin\WechatLogic;
use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use Illuminate\Support\Facades\Redirect;

class DoubleElevenController extends WeixinController{


    public function index(Request $request)
    {

        $client         =   RequestSourceLogic::getSource();

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
            'client'        =>  $client,
            'channel'           =>  $channel,
            'actToken'      =>  DoubleElevenLogic::getActToken(),
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false,
            'signData'      => $doubleElevenLogic->getUserSignData($userId, ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN),
            'signTimesAward' => DoubleElevenLogic::getAwardSignTimes(),
            'rechargeBonusList' => DoubleElevenLogic::getBonusRainList($userId),
            'netRechargeConfig' => DoubleElevenLogic::getNetRechargeConfig(),
        ];
        $viewData['endBonusData'] = end($viewData['rechargeBonusList']);

        $viewData = array_merge_recursive($viewData, $this->_setWxInfo());

        return view('wap.activity.doubleEleven.index', $viewData);
    }

    /**
     * @desc 设置微信分享的内容信息
     * @return array
     */
    private function _setWxInfo()
    {
        $config = DoubleElevenLogic::getActivityShare(DoubleElevenLogic::ACTIVITY_CONFIG);

        $wxInfo  = [
            'sdk'         => WechatLogic::jsSdk(),
            'imgUrl'      => $config['imgUrl'],
            'lineLink'    => $config['lineLink'],
            'shareTitle'  => $config['shareTitle'],
            'descContent' => $config['descContent'],
            'shareCallBack' => '/activity/doubuleEleven/share',
        ];

        return $wxInfo;
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
     * @desc 双十一活动分享成功后回调
     * @return json
     */
    public function activityShare(Request $request)
    {
        $doubleElevenLogic = new DoubleElevenLogic();
        $data = [
            'user_id' => $this->getUserId(),
            'cash'    => $doubleElevenLogic->getRandShareMoney(),
            'note'    => '11.11理财节, 活动分享现金奖励',
            ];

        $result = $doubleElevenLogic->doShareSuccess($data);

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

    public function lottery(Request $request)
    {
        $channel    =   $request->input('channel','');

        $jumpUrl    =   '/activity/doubleEleven/lottery' ;

        if( !empty($channel) ){
            $jumpUrl=   $jumpUrl.'?channel=' . $channel ;
        }
        $logic      =   new DoubleElevenLogic();

        ToolJump::setLoginUrl ($jumpUrl);

        $viewData   =   [
            'activityTime'      =>  $logic->setActivityTime (),
            'actToken'          =>  $logic->getActToken (),
            'lotteryList'       =>  $logic->getLotteryList (),
            'userStatus'        =>  $this->getUserId () > 0 ? true :false,
            'channel'           =>  $channel,
        ];

        return view('wap.activity.doubleEleven.lottery', $viewData);
    }

    /**
     * @param Request $request
     * @return array
     * @desc 执行抽奖
     */
    public function doLuckDraw( Request $request)
    {
        $userId     =   $this->getUserId ();

        $logic      =   new DoubleElevenLogic();

        $activity   =   $logic->validActivityStatus ($userId);

        if( $activity['status'] == false )
            return $activity ;

        $lottery    =   $logic->validUserSignStatus ($userId);

        if( $lottery['status'] == false )
            return $lottery;

        return  $logic->doLuckDraw ($userId,$lottery['data'] );
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
