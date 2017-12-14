<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 16/9/28
 * Time: 下午7:24
 */

namespace App\Http\Controllers\Pc\Activity;


use App\Http\Controllers\Pc\PcController;
use App\Tools\ToolJump;
use App\Http\Logics\Activity\AutumnNationLogic;
use Illuminate\Http\Request;
use App\Http\Dbs\Bonus\BonusDb;

class NationalController extends PcController
{

    public function index()
    {
        return view("pc.activity.national.national");
    }

    /**
     * @desc Pc中秋国庆活动
     */
    public function index2017()
    {
        ToolJump::setLoginUrl('/activity/national/2017');

        $userId = $this->getUserId();

        $viewData = [
            'activityTime' => AutumnNationLogic::setActivityTime(),
            'userStatus'    => (!empty($userId)||$userId!=0) ? true : false,
            'actToken'      =>  AutumnNationLogic::getActToken(),
            ];

        return view("pc.activity.national2017.index", $viewData);
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
