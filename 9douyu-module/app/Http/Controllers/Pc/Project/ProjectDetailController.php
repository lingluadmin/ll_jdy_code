<?php

/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/6/3
 * Time: 上午10:42
 *
 */

namespace App\Http\Controllers\Pc\Project;

use App\Http\Controllers\Pc\PcController;

use App\Http\Logics\Ad\AdLogic;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Project\ProjectDetailLogic;
use App\Http\Logics\Project\ProjectExtendLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\SystemConfig\SystemConfigLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Logics\User\UserInfoLogic;
use App\Http\Models\Common\ValidateModel;
use App\Http\Models\Invest\InvestModel;
use App\Http\Logics\Invest\CurrentLogic;
use \App\Http\Dbs\Project\ProjectDb;
use App\Http\Logics\Article\ArticleLogic;
use App\Tools\ToolJump;
use Illuminate\Support\Facades\Redirect;
use App\Tools\ToolPager;

/**
 * 项目详情
 * Class ProjectDetailController
 * @package App\Http\Controllers\Pc\Project
 */
class ProjectDetailController extends PcController
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
     * 项目详情页面
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get( $id ){

        //项目信息
        $project         = $this->ProjectDetailLogic->get($id);
        if(empty($project) || $project['status'] < ProjectDb::STATUS_UNPUBLISH){
            return Redirect::to("/project/index");
        }

        if ($project['product_line'] == ProjectDb::PRODUCT_LINE_SMART_INVEST) {
            return Redirect::to('/smartInvest/detail/'.$id);
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
        // 债权
        $creditDetail = $this->ProjectDetailLogic->getCreditBrowserShowData($id, $this->getUserId());
        //解析债券中存在的人或者公司的信息
        $creditDetail['companyView']   =   $this->ProjectDetailLogic->doFormatCreditLoadUser($creditDetail['companyView']);


        //是否可以使用优惠券
        $termLogic  = new TermLogic();
        $useBonus   = $termLogic->checkProjectRateLimit($project,1);

        $assign          = [
            'project'      => $project,
            'user'         => $user,
            'useBonus'     => $useBonus,
            'msg'          => session('msg') ? session('msg') : '',
            'creditDetail' => $creditDetail,
            'activityNote' => ProjectExtendLogic::getByProjectId ($id),
        ];
        if(!$userId){
            ToolJump::setLoginUrl('/project/detail/' . $id);
        }

        return view('pc.invest.project.detailNew', $assign);
    }


    /**
     * @param $id
     * 获取项目的后加载信息
     */
    public function extra($id){

        $page = 1;
        $size = 10;

        //项目还款计划
        $refundPlan  = $this->ProjectDetailLogic->getRefundPlan($id);
        //获取项目的满标时间
        $projectInfo = $this->ProjectDetailLogic->get($id);
        $fullAt      = $projectInfo['full_at'];
        if($projectInfo['status'] <= 130){
             $fullAt = 0;
        }
        //投资列表
        $investList  = $this->ProjectDetailLogic->getInvestList($id,$page,$size,$fullAt);
        $count       = $this->ProjectDetailLogic->getInvestTotalByProject($id);
        //分页
        $pageNation  = new ToolPager($count, $page, $size, '/project/invest/list/'.$id);
        $pager       = $pageNation->getPaginate();

        //渲染数据
        $data = [
            'investList' => $investList,
            'Plan'       => $refundPlan,
            'pager'      => $pager
        ];
        return_json_format($data);
    }


    /**
     * @param $projectId
     * @param int $page
     */
    public function investList($projectId,$page=1){
        $size        = 10;
        $count       = $this->ProjectDetailLogic->getInvestTotalByProject($projectId);
        if($page < 1 ){
            $page = 1;
        }
        $maxPage = floor(ceil($count/$size));
        if($page>$maxPage){
            $page = $maxPage;
        }

        $pageNation  = new ToolPager($count, $page, $size, '/project/invest/list/'.$projectId);
        $pager       = $pageNation->getPaginate();
        //投资列表
        $investList  = $this->ProjectDetailLogic->getInvestList($projectId,$page,$size);
        //渲染数据
        $data = [
            'investList' => $investList,
            'pager'      => $pager
        ];
        return_json_format($data);
    }


    /**
     * 零钱计划项目投资详情页
     */
    public function getCurrent(){

        $isLogin        = $this->checkLogin();

        $from           = RequestSourceLogic::getSource();
        $logic          = new CurrentLogic();
        $userId = $this->getUserId();

        $viewData       = $logic->projectDetail($userId,$from);

        $userInfo       = $isLogin ? $this->getUser() : [];

        //获取用户状态
        $userStatus     = UserLogic::getUserAuthStatus($userInfo);

        $assign             = $viewData['data'];
        $assign['showStatus'] = $userStatus;
        //dd($assign);
        if(!$userId)
            ToolJump::setLoginUrl('/project/current/detail');

        //零钱计划详情 & 常见问题
        $articleLogic    = new ArticleLogic();
        $articlePlan     = $articleLogic->getById(self::SMALL_CHANGE_PLAN_ARTICLE_DETAIL);
        $articleQues     = $articleLogic->getById(self::SMALL_CHANGE_PLAN_ARTICLE_QUES);
        $footerAtr = array();
        if(isset($articlePlan) && !empty($articlePlan['content'])){
            $plan  = html_entity_decode($articlePlan['content']);
            $footerAtr['plan']   = $plan;
        }
        if(isset($articleQues) && !empty($articleQues['content'])){
            $ques  = html_entity_decode($articleQues['content']);
            $footerAtr['ques']   = $ques;
        }
        $assign['assessment']=  '';
        if( $isLogin ) {
            $userInfoLogic  =   new UserInfoLogic();
            $assign['assessment'] =   $userInfoLogic -> getAssessmentType($userId);
        }
        $assign['footerAtr'] = $footerAtr;
        return view('pc.invest.current.detail',$assign);

    }


    public function index(){

        return view('pc.invest.current.index');

    }


}
