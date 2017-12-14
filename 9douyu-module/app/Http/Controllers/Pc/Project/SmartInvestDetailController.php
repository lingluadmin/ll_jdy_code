<?php

/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 17/12/5
 * Time: 下午14:00
 * Desc: 智投计划项目详情
 *
 */

namespace App\Http\Controllers\Pc\Project;

use App\Http\Controllers\Pc\PcController;

use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Project\ProjectDetailLogic;
use App\Http\Logics\Project\ProjectExtendLogic;
use App\Http\Models\Common\AssetsPlatformApi\ProjectCreditApiModel;
use App\Http\Models\Common\ValidateModel;
use \App\Http\Dbs\Project\ProjectDb;
use App\Tools\ToolJump;
use App\Tools\ToolMoney;
use App\Tools\ToolStr;
use Illuminate\Support\Facades\Redirect;
use App\Tools\ToolPager;
use App\Http\Models\Credit\CreditModel;

/**
 * 项目详情
 * Class ProjectDetailController
 * @package App\Http\Controllers\Pc\Project
 */
class SmartInvestDetailController extends PcController
{
    //零钱计划详情ID
    const SMALL_CHANGE_PLAN_ARTICLE_DETAIL = 1422;

    //零钱计划问题ID
    const SMALL_CHANGE_PLAN_ARTICLE_QUES   = 1423;
    /**
     * 项目详情逻辑类
     * @var ProjectDetailLogic|null
     */
    protected $ProjectDetailLogic = null;


    public function appendConstruct(){
        $this->ProjectDetailLogic = new ProjectDetailLogic;
    }

    /**
     * 智投计划项目详情页面
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get( $id ){

        //项目信息
        $project         = $this->ProjectDetailLogic->get($id);

        if(empty($project) || $project['status'] < ProjectDb::STATUS_UNPUBLISH){
            return Redirect::to("/project/index");
        }

        if ($project['product_line'] != ProjectDb::PRODUCT_LINE_SMART_INVEST) {
            return Redirect::to('/project/detail/'.$id);
        }

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

        //用户信息
        $userId          = $this->getUserId();
        $user            = $this->ProjectDetailLogic->getUser($userId);
        $isNovice        = ValidateModel::isNoviceInvestUser($userId,false);

        if(empty($user)){
           $user['id']   = 0;
           $user['balance'] = 0;
        }

        $user['not_novice'] = $isNovice ? false : true;


        //是否可以使用优惠券
        $termLogic  = new TermLogic();
        $useBonus   = $termLogic->checkProjectRateLimit($project,1);

        $assign          = [
            'project'      => $project,
            'user'         => $user,
            'useBonus'     => $useBonus,
            'msg'          => session('msg') ? session('msg') : '',
            'activityNote' => ProjectExtendLogic::getByProjectId ($id),
        ];
        if(!$userId){
            ToolJump::setLoginUrl('/smartInvest/detail/' . $id);
        }

        return view('pc.invest.project.smartInvest', $assign);
    }

    /**
     * @desc  获取项目关联债权信息的列表
     * @param $projectNo
     * @param int $page
     */
    public function projectCreditRelation($projectNo, $page=1)
    {
        $size = 10;
        if ($page<1) {
            $page = 1;
        }

        $params = [
            'projectNo' => $projectNo,
            'page' => $page,
            'size' => $size,
        ];

        $creditList = [];
        $creditCount = 0;

        $return  =  ProjectCreditApiModel::getProjectCreditRelate($params);
        if (isset($return['data']) && !empty($return)) {
            $return = $return['data'];
        }

        if (!empty($return)) {
            $creditList = $this->formatCredit($return['body']['projectCreditList']);
            $creditCount = $return['body']['totalCount'];
        }

        $pageNation  = new ToolPager($creditCount, $page, $size, '/smartInvest/project/credit/'.$projectNo);
        $pager       = $pageNation->getPaginate();

        $data = [
            'creditList' => $creditList,
            'creditCount' => $creditCount,
            'pager' => $pager,
        ];

        return_json_format($data);
    }

    /**
     * @desc 获取债权信息格式化
     * @param array $creditData
     * @return array
     */
    public function formatCredit(array $creditData)
    {
        foreach ($creditData as $key => $value) {
            $creditData[$key]['hide_loan_name'] = ToolStr::hideStr($value['loanName'], 1);
            $creditData[$key]['loanTerm'] = $creditData[$key]['loanTerm'].'天';
            $creditData[$key]['hide_loan_card'] = ToolStr::hideNum($value['loanCard']);
            $creditData[$key]['loanAmount'] = ToolMoney::moneyFormat($value['loanAmount']);
            $creditData[$key]['repayment_type_note'] = CreditModel::refundType($value['repaymentType']);
            $creditData[$key]['loanPurpose'] = !empty($creditData[$key]['loanPurpose']) ? $creditData[$key]['loanPurpose']: '日常消费';
            $creditData[$key]['overdueNumber'] = !empty($creditData[$key]['overdueNumber']) ? $creditData[$key]['overdueNumber']."次": 0 ."次";
        }
        return $creditData;
    }

}
