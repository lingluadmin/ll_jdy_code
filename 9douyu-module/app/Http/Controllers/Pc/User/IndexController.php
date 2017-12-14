<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/6/12
 * Time: 下午6:02
 * Desc: 用户中心
 */

namespace App\Http\Controllers\Pc\User;

use App\Http\Controllers\Pc\UserController;
use App\Http\Dbs\Project\ProjectDb;
use App\Http\Logics\Logic;
use App\Http\Logics\Notice\NoticeLogic;
use App\Http\Logics\Project\RefundRecordLogic;
use App\Http\Logics\User\PasswordLogic;
use App\Http\Logics\User\UserInfoLogic;
use App\Http\Logics\User\UserLogic;
use App\Tools\ToolJump;
use App\Tools\ToolMoney;
use App\Tools\ToolPaginate;
use App\Tools\ToolStr;
use Illuminate\Http\Request;
use Cache;

class IndexController extends UserController
{


    public function index()
    {

        $userId = $this->getUserId();
        //用户回款中记录
        //$refundLogic = new RefundRecordLogic();

        //$refundList = $refundLogic->getRefundingListByDate($userId);

        $logic = new UserLogic();

        $userInfo = $logic -> getUser($userId);
        $userInfo['balance']      = ToolMoney::formatDbCashDelete($userInfo['balance']);
        $userInfo['phone']        = ToolStr::hidePhone($userInfo['phone']);

        //用户资产
        $userAccount = $logic -> getUserInfoAccount($userId);

        //计算匹配中未到期的累计收益
        $smartRefundInterestTotal = 0;
        if(!empty($userAccount['smart']['due_ids'])){
            $smartRefundInterestTotal = $logic->getSmartInvestRefundingInterest($userAccount['smart']['due_ids']);
        }
        $userAccount['smart']['due_interest'] = $smartRefundInterestTotal;


        $productLineArr = empty($userAccount['project']['product_line'])?'':$userAccount['project']['product_line'];
        $projectJsx     = empty($productLineArr[ProjectDb::PROJECT_PRODUCT_LINE_JSX])?['interest'=>0,'principal'=>0]:$productLineArr[ProjectDb::PROJECT_PRODUCT_LINE_JSX];
        $projectJax     = empty($productLineArr[ProjectDb::PROJECT_PRODUCT_LINE_JAX])?['interest'=>0,'principal'=>0]:$productLineArr[ProjectDb::PROJECT_PRODUCT_LINE_JAX];
        $projectSdf     = empty($productLineArr[ProjectDb::PROJECT_PRODUCT_LINE_SDF])?['interest'=>0,'principal'=>0]:$productLineArr[ProjectDb::PROJECT_PRODUCT_LINE_SDF];

        $userAccount['project']['total_amount'] = $projectJsx['interest'] + $projectJsx['principal'] + $projectJax['interest'] + $projectJax['principal'] + $projectSdf['principal'];
        $userAccount['project']['total_amount_principal'] = $projectJsx['principal'] + $projectJax['principal'] + $projectSdf['principal'];
        $userAccount['project']['total_amount_interest']  = $projectJsx['interest'] + $projectJax['interest'];

        if(empty($userAccount['current'])){
            $userAccount['current']['cash'] = 0;
        }

        $userInfo['total_amount'] = $userAccount['current']['cash'] + $userInfo['balance'] + $userAccount['project']['total_amount'];

        $userInfo['total_interest'] = $userAccount['project']['refund_interest'] + $userAccount['current']['interest'];

        //可用优惠券
        $totalBonus    = $logic -> getUserTotalBonus($userId);

        //银行卡信息
        $userBank = $logic->getCardInfo($userId);

        //风险评估信息
        $user = $this->getUser();
        $userInfoLogic = new UserInfoLogic();
        $userInfo['assessment_type'] = $userInfoLogic -> getAssessmentType($userId);
        $userInfo['assessment'] = !isset($user['user_info']['assessment_score']) || $user['user_info']['assessment_score']===null ? '1' : '0';

        $viewData = [
            'user_info'         => $userInfo,
            'user_bank'         => $userBank,
            'total_bonus'       => $totalBonus,
            'current_account'   => $userAccount['current'],
            'project_account'   => $userAccount['project'],
            'smart_account'     => $userAccount['smart'],
            'project_jsx'       => $projectJsx ?:[],
            'project_jax'       => $projectJax ?:[],
            'project_sdf'       => $projectSdf ?:[],
            'jsx_total'         => $projectJsx['interest']+$projectJsx['principal'],
            'jax_total'         => $projectJax['interest']+$projectJax['principal'],
            'sdf_total'         => $projectSdf['interest']+$projectSdf['principal'],
        ];

        return view('pc.user.index', $viewData);
    }


    /**
     * 用户中心零钱计划页面
     */

    /**
     * @SWG\Post(
     *   path="/user/currentFund",
     *   tags={"PC-User"},
     *   summary="用户中心零钱计划页面 [User\IndexController@currentFund]",
     *   @SWG\Response(
     *     response=200,
     *     description="获取用户中心零钱计划页面成功。",
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="获取用户中心零钱计划页面失败。",
     *   )
     * )
     */
    public function currentFund(){

        $logic  = new UserLogic();

        $userId = $this->getUserId();

        $result = $logic->getCurrentFund($userId);

        return self::returnJson($result);
    }

    /**
     * @param Request $request
     * @return mixed
     * @desc 验证交易密码是否证确认
     */
    public function checkTradePassword(Request $request){

        $password   = $request->input('trading_password');

        $userId     = $this->getUserId();

        $logic      = new PasswordLogic();

        $result     = $logic->checkTradingPassword($password,$userId);

        return json_encode($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 三要素实名
     */
    public function verify(Request $request){

        return view('pc.user/verifyBindCard');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 风险承受能力测评表1
     */
    public function riskAssessment(){

        return view('pc.user.riskAssessment');

    }

    /**
     * @param Request $request
     * @return string
     * @desc 风险承受能力测评
     */
    public function doAssessment(Request $request){

        $userId = $this->getUserId();

        $data = [];
        for($i=1;$i<=8;$i++){
            if(empty($request->input('question'.$i))){
                $result['status'] = false;
                $result['msg']    = "请选择第 $i 题";
                return self::returnJson($result);
            }
            $data['question'.$i] = $request->input('question'.$i);
        }

        $logic   = new UserInfoLogic();

        $result  = $logic->doSickAssessmentSecond($userId,$data);

        return self::returnJson($result);
    }


    /**
     * ajax将风险评估分数改为-1，避免弹窗
     */
    public function doAssessmentOff(){
        $userId = $this->getUserId();
        $logic   = new UserInfoLogic();

        $data = [];
        $score = (int)-1;
        $logic->doSickAssessmentSecond($userId,$data,$score);
    }

    /**
     * @desc 用户的消息中心
     */
    public function message( Request $request)
    {
        $userId         =   $this->getUserId () ;

        $page           =   $request->input ('page' ,1 );

        $noticeLogic    =   new NoticeLogic() ;

        $noticeList     =   $noticeLogic->getUserNoticeList ($userId ,$page ,6);

        $pageTool       =   new ToolPaginate($noticeList['total'], $page, 6, '/user/message');

        $paginate       =   $pageTool->getPaginate() ;

        $noticeList['paginate']= $paginate;

        return view('pc.user.message',$noticeList);
    }

    public function setNoticeRead(Request $request)
    {
        $userId         =   $this->getUserId () ;

        $noticeId       =   $request->input ('notice_id',0);

        $noticeLogic    =   new NoticeLogic() ;

        return  $noticeLogic->setNoticeReadByUserId ($userId ,$noticeId);
    }


}


