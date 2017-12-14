<?php
/**
 * Created by PhpStorm.
 * User: bihua
 * Date: 16/7/22
 * Time: 下午2:58
 * Desc: 定期项目投资
 */

namespace App\Http\Controllers\Weixin\Invest;

use App\Http\Controllers\Weixin\UserController;
use App\Http\Logics\Bonus\BonusLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Project\ProjectDetailLogic;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Models\Common\ValidateModel;
use App\Http\Models\Invest\InvestModel;
use App\Http\Models\Project\ProjectModel;
use App\Http\Models\SystemConfig\SystemConfigModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Dbs\Project\ProjectDb;
use Illuminate\Http\Request;
use Cache;

class ProjectController extends UserController{

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm( $id = 0){

        //项目信息
        $logic     = new ProjectDetailLogic();

        $project   = $logic->get($id);

        if(empty($project)){
            return Redirect::to("/project/index");
        }
        //补充项目信息
        $refundType = [
            'baseInterest'   =>  ProjectDb::REFUND_TYPE_BASE_INTEREST,
            'onlyInterest'   =>  ProjectDb::REFUND_TYPE_ONLY_INTEREST,
            'firstInterest'  =>  ProjectDb::REFUND_TYPE_FIRST_INTEREST,
            'equalInterest'  =>  ProjectDb::REFUND_TYPE_EQUAL_INTEREST,
        ];
        $project['calculator_type'] = "equalInterest";
        if($project['refund_type'] == $refundType['onlyInterest']){
            $project['calculator_type'] = "onlyInterest";
        }elseif($project['refund_type'] == $refundType['baseInterest']){
            $project['calculator_type'] = "baseInterest";
        }elseif($project['refund_type'] == $refundType['firstInterest']){
            $project['calculator_type'] = "cycleInvest";
        }


        //用户信息
        $userId   = $this->getUserId();
        $userInfo = $this->getUser();

        //用户登录状态，实名状态，交易密码状态
        $userLogic  = new UserLogic();
        $status     = $userLogic -> getUserAuthStatus($userInfo);

        //新手项目用户最大投资额
        $limitCash = !empty(SystemConfigModel::getConfig('NOVICE_PROJECT_INVEST_LIMIT')) ? SystemConfigModel::getConfig('NOVICE_PROJECT_INVEST_LIMIT') : 50000;
        //判断是否为新手
        $isNovice = ValidateModel::isNoviceInvestUser($userId,false);

        //红包信息
        $userBonusLogic  = new UserBonusLogic();
        $bonus           = $userBonusLogic->getWapUserUsableBonus($userId,$id,'wap',$project);

        //过滤红包
        $termLogic       = new TermLogic();
        $userCanUseRate  = $termLogic->checkProjectRateLimit($project,1);
        $bonus           = $userBonusLogic->filterUserBonus($bonus['data']['list'],$userCanUseRate,0);

        $assign = [
            'project'   => $project,
            'balance'   => $userInfo['balance'],
            'userId'    => $userId,
            'bonus'     => $bonus,
            'bonusNum'  => count($bonus),
            'msg'       => session('msg') ? session('msg') : '',
            'novice_invest_max' => $isNovice ? $limitCash : 0,
            'status'    => $status,
        ];

        return view('wap.invest.project.confirm',$assign);
    }

    /**
     * @param Request $request
     * @return mixed
     * @desc 确认投资
     */
    public function doInvest( Request $request){

        $userId = $this->getUserId();

        $projectId = $request->input('project_id');

        $cash      = $request->input('cash');

        $bonusId   = $request->input('bonus_id');

        $tradePassword = $request->input('trade_password');
        
        $termLogic = new TermLogic();

        //$appRequest              = RequestSourceLogic::getSourceKey('wap');

        $result = $termLogic->doInvest($userId,$projectId,$cash,$tradePassword,$bonusId,'wap',self::getActToken());

        return self::returnJson($result);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 投资成功
     */
    public function success(){

        $investId  = Cache::get('invest_id');

        if(empty($investId)){

            return Redirect::to("/project/lists");
        }

        Cache::forget('invest_id');

        $invest        = InvestModel::getInvestByInvestId($investId);

        $projectLogic  = new ProjectDetailLogic();

        //项目信息
        $project       = $projectLogic->get($invest['project_id'], true);

        $termLogic     = new TermLogic();

        $bonusLogic    = new BonusLogic();

        $bonus         = $bonusLogic->getBonusValueByType($invest['bonus_type'],$invest['bonus_value']);

        //预期收益 项目基本利率收益+加息券收益
        //$fee           =  $termLogic->getProfit($invest['project_id'],$invest['cash'],$bonus['rate']);


        //首次回款
        $refund        = $termLogic->getFirstRefund($invest['project_id'], $invest['cash'],$invest['created_at']);

        $assign    = [
            'cash'            => $invest['cash'],
            'project'         => $project,
            'refund_times'    => $refund['times'],
            'projectId'       => $invest['project_id'],
            'profit'          => $refund['interest'],
            'rate'            => $bonus['rate'],
        ];

        return view('wap.invest.project.success',$assign);
    }

    /**
     * @param $id
     * @desc 投资详情
     */
    public function detail($investId)
    {

        $userId = $this->getUserId();

        $termLogic = new TermLogic();

        $result = $termLogic->getInvestDetailByIdForApp($userId, $investId);

        print_r($result);

    }

    /**
     * @return bool
     * @desc 获取活动标示
     */
    protected function getActToken()
    {
       $actToken    =   \Session::get('ACT_TOKEN');

        \Log::info('invest_activity',['user_id' =>$this->getUserId () ,'act_token' => $actToken]);

       return $actToken;
    }
}