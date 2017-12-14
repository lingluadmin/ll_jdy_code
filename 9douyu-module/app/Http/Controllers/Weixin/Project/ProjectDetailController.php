<?php

/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/6/3
 * Time: 上午10:42
 *
 */

namespace App\Http\Controllers\Weixin\Project;

use App\Http\Controllers\Weixin\WeixinController;

use App\Http\Dbs\Credit\CreditDb;
use App\Http\Dbs\Project\ProjectDb;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Project\ProjectDetailLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Models\Common\ValidateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Logics\Invest\CurrentLogic;

/**
 * 项目详情
 * Class ProjectDetailController
 * @package App\Http\Controllers\weixin\Project
 */
class ProjectDetailController extends WeixinController
{
    /**
     * 项目详情逻辑类
     * @var ProjectDetailLogic|null
     */
    protected $ProjectDetailLogic = null;


    public function appendConstruct(){
        $this->ProjectDetailLogic = new ProjectDetailLogic;
    }

    public function getCreditDetail($id=0){

        $logicResult     = $this->ProjectDetailLogic->getProductCreditDetail($id);

        return view('app.project.detail.'.$logicResult['data']['view'], $logicResult['data']['data']);

    }

    /**
     * 项目详情页面
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($id = 0){

        //项目信息
        $project     = $this->ProjectDetailLogic->get($id);

        if(empty($project) || $project['status'] < ProjectDb::STATUS_UNPUBLISH)
            return Redirect::to("/project/lists");

        //投资概况
        $investBrief     = $this->ProjectDetailLogic->getInvestBrief($id);

        $userId = $this->getUserId();
        $user   = $this->getUser();

        //用户登录状态，实名状态，交易密码状态
        $userLogic  = new UserLogic();
        $status     = $userLogic -> getUserAuthStatus($user);

        //项目是否可用红包
        $termLogic       = new TermLogic();
        $userCanUseRate  = $termLogic->checkProjectRateLimit($project,1);

        // 债权
        $creditDetail      = $this->ProjectDetailLogic->getCreditBrowserShowData($id, $userId);
        $refundType      = [
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

        $assign          = [
            'user'         => $user,
            'status'       => $status,
            'isNovice'     => ValidateModel::isNoviceInvestUser($userId,false),
            'ableBonus'    => $userCanUseRate,
            'project'      => $project,
            'investBrief'  => $investBrief,
            'process'      => ($investBrief['cash']/$project['total_amount'])*100,
            'creditDetail' => $creditDetail,
        ];

        return view('wap.project.detail', $assign);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 计算器
     */
    public function calculator(){

        return view('wap.project.calculator');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     * @desc 项目详情
     */
    public function companyDetail( $id = 0){

        //项目信息
        $project           = $this->ProjectDetailLogic->get($id);

        if(empty($project))
            return Redirect::to("/project/lists");

        // 债权
        $creditDetail      = $this->ProjectDetailLogic->getCreditBrowserShowData($id);


        $projectWay        = $creditDetail['projectWay'];

        if(!in_array($projectWay, [CreditDb::SOURCE_FACTORING, CreditDb::SOURCE_HOUSING_MORTGAGE, CreditDb::SOURCE_CREDIT_LOAN])){
            return Redirect::to("/project/lists");
        }

        switch ($projectWay) {
            case CreditDb::SOURCE_CREDIT_LOAN :
                $tpl = "creditdetail";
                break;
            case CreditDb::SOURCE_FACTORING :
                $tpl = "factordetail";
                break;
            case CreditDb::SOURCE_HOUSING_MORTGAGE :
                $tpl = "housedetail";
                break;
        }

        $assign['project']      = $project;
        $assign['creditDetail'] = $creditDetail;

        \Log::info(__METHOD__, [$creditDetail]);

        return view('wap.project.' . $tpl, $assign);
    }

    /*
     * 零钱计划项目投资详情页
     */
    public function getCurrent(){

        $logic = new CurrentLogic();
        $assign = $logic->getCurrentBaseInfo();

        return view('wap.invest.current.detail',$assign);


    }

    /**
     * @param $projectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listRefundPlanByProject($projectId){
        $projectId = intval($projectId);
        //项目信息
        $project     = $this->ProjectDetailLogic->get($projectId);

        if(empty($project) || $project['status'] < ProjectDb::STATUS_UNPUBLISH){
            return Redirect::to("/project/lists");
        }
        //项目还款计划
        $refundPlan  = $this->ProjectDetailLogic->getRefundPlan($projectId);
        return view('wap.project.refund_plan', ['plan'=>$refundPlan]);

    }

    /**
     * @param $projectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listInvestRecordByProject($projectId){

        $projectId = intval($projectId);
        //项目信息
        $project     = $this->ProjectDetailLogic->get($projectId);

        if(empty($project) || $project['status'] < ProjectDb::STATUS_UNPUBLISH){
            return Redirect::to("/project/lists");
        }

        return view('wap.project.invest_record', ['projectId'=>$projectId]);

    }

    /**
     * @param $projectId
     * @param int $page
     */
    public function moreInvestRecordByProject($projectId,$page=1){
        $size = 10;
        if($page<1){
            $page = 1;
        }
        //投资列表
        $investList  = $this->ProjectDetailLogic->getInvestList($projectId,$page,$size);
        $view = [
            'list'          => $investList,
        ];
        return_json_format($view);
    }


}
