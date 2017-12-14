<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 16/9/26
 * Time: 下午4:11
 */

namespace App\Http\Controllers\Weixin\Activity;

use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Logics\Activity\NationalDayLogic;

use App\Http\Logics\Activity\ActivitySignLogic;

use App\Http\Logics\RequestSourceLogic;
use App\Lang\LangModel;
use App\Tools\ToolJump;
use Illuminate\Http\Request;
use Cache;
use App\Http\Logics\Activity\AutumnNationLogic;

class NationalDay2017Controller extends WeixinController
{


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 国庆活动的页面
     */

    public function index()
    {
        $client         =   RequestSourceLogic::getSource();

        ToolJump::setLoginUrl('/activity/national/2017');

        $userId         =   $this->getUserId();

        $viewData       =   [
            'activityTime'  =>  AutumnNationLogic::setActivityTime(),
            'client'        =>  $client,
            'actToken'      =>  AutumnNationLogic::getActToken(),
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false
        ];

        return view('wap.activity.national2017.index', $viewData);
    }

    /**
     * @desc 获取活动相关数据
     */
    public function getActivityData()
    {

        $bonusList = AutumnNationLogic::getAutumnNationBonus();
        $data = [
            'user_id'     => $this->getUserId(),
            'projectList' => AutumnNationLogic::getProjectList(),
            'nation_bonus' => $bonusList['nation_bonus'],
            'autumn_bonus' => $bonusList['autumn_bonus'],
            ];

        return_json_format($data);
    }

    /**
     * @desec 领取国庆节优惠券
     */
    public function doGetNationBonus(Request $request)
    {
        $autumnNationLogic = new AutumnNationLogic();

        $userId = $request->input('user_id', 0);

        $bonusId = $request->input('bonus_id', 0);

        $return = $autumnNationLogic->doGetNationBonus($userId, $bonusId);

        return $return;
    }

    /**
     * @desc 领取中秋节优惠券
     */
    public function doGetAutumnBonus(Request $request)
    {
        $autumnNationLogic = new AutumnNationLogic();

        $userId = $request->input('user_id', 0);

        $bonusId = $request->input('bonus_id', 0);

        $result = $autumnNationLogic->doGetAutumnBonus($userId, $bonusId);

        return $result;
    }


}
