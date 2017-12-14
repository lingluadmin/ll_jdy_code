<?php

/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/6/12
 * Time: 下午6:35
 */
namespace App\Http\Controllers\Pc\User;


use App\Http\Controllers\Pc\UserController;
use App\Http\Logics\Fund\FundHistoryLogic;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Logic;
use App\Tools\ToolPaginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/**
 * 资金历史记录
 * Class FundHistoryController
 * @package App\Http\Controllers\Pc\User
 */
class FundHistoryController extends UserController
{

    /**
     * @desc 获取列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListByType()
    {

        $request = app('request');

        $data = $request->all();

        $data['type'] = !empty($data['type']) ? $data['type'] : 'all';

        $data['page'] = $request->input('page', 1);

        $data['size'] = 10;

        $data['user_id'] = $this->getUserId();

        //$data['user_id'] = 10;

        $return = FundHistoryLogic::getListByType($data);


        $list = (isset($return['data']) && !empty($return['data']['data'])) ? $return['data'] : '';

        $paginate = '';

        if( $list ){
            $params['type']       = isset($data['type']) ? $data['type'] : '';
            $params['start_time'] = isset($data['start_time']) ? $data['start_time'] : '';
            $params['end_time']   = isset($data['end_time']) ? $data['end_time'] : '';

            $paramsString         = http_build_query($params);

            $pageTool = new ToolPaginate($list['total'], $data['page'], $data['size'], '/user/fundhistory' .'?'. $paramsString);

            $paginate = $pageTool->getPaginate();

        }

        $data = [
            'list'      => (isset($list['data']) && !empty($list['data'])) ? $list['data'] : '',
            'paginate'  => $paginate,
            'data'      => $data,
        ];

        return view('pc.user/fundhistory', $data);

    }

    /**
     * @param Request $request
     * @desc user invest record detail
     */
    public function investDetail( Request $request )
    {
        $recordId       =   (int)$request->get ('record_id') ;

        $investDetail   =   TermLogic::getUserInvestDetail($this->getUserId (),$recordId);
        if(!$investDetail['data'] || $investDetail['status'] == false){

            return Redirect::to("/user/investList");
        }
        $viewData   =   [
            'investDetail'  =>  isset($investDetail['data']['invest_detail']) ? $investDetail['data']['invest_detail'] : [],
            'refundList'    =>  isset($investDetail['data']['refund_list']) ? $investDetail['data']['refund_list'] : []
        ];
        //This is user invest record detail

       return view('pc.user.investNewDetail' ,$viewData);
    }

    /**
     * @desc    账户中心-智投计划出借详情
     * @param   Request     $request
     * @param   $investId   投资ID
     *
     * 数据：
     *  1、根据投资ID，获取相应项目信息，投资信息
     *  2、通过API接口获取累计收益
     *  3、通过API接口获取每日收益
     *
     */
    public function investSmartDetail( Request $request )
    {
        $investId   = $request->input('record_id');
        $page       = $request->input('page', 1);

        $viewData   =   [
            'investId'  => $investId,
            'page'      => $page,
        ];
        # dd($viewData);
        return view('pc.user.investSmartDetail', $viewData);
    }


    /**
     * @desc    智投计划出借详情Ajax
     *
     **/
    public function investSmartDetailAjax( Request $request)
    {
        $investId   = $request->input('record_id');
        $page       = $request->input('page', 1);
        $size       = 10;

        $userId     = $this->getUserId ();

        # 出借详情
        $investDetail   = TermLogic::getInvestSmartDetail($userId, $investId);
        # 累计收益
        $orderInterest  = TermLogic::getInvestSmartInterestAlready($investId);
        # 每日收益
        $resData        = TermLogic::getInvestSmartInterestDay($investId,$page,$size);

        $pageTool       = new ToolPaginate($resData['total'], $page, $size, '/user/invest/smartDetailAjax' );

        $paginate       = $pageTool->getPaginate();

        $viewData   =   [
            'list'      => !empty($resData["data"]) ? $resData["data"]: [],
            'pager'     => $paginate,
            'count'     => $resData["total"],
            'investId'  => $investId,
            'investDetail'  => !empty($investDetail["invest_detail"]) ? $investDetail["invest_detail"] : [],
            'orderInterest' => $orderInterest,
        ];

        return_json_format($viewData);
    }


    /**
     * @param Request $request
     * @desc 智投计划资金匹配详情
     */
    public function investSmartMatchDetail( Request $request  )
    {
        $investId   = $request->get ('record_id','');
        $page       = $request->input('page', 1);

        $viewData   =   [
            'investId'  => $investId,
            'page'      => $page,
        ];

       return view('pc.user.investSmartMatchDetail', $viewData);
    }


    /**
     * @desc ajax 智投计划资金匹配详情
     */
    public function investSmartMatchDetailAjax( Request $request)
    {
        # $userId     = $this->getUserId();
        $investId   = $request->input('record_id');
        $page       = $request->input('page', 1);
        $size       = 10;

        $resData    = TermLogic::getOrderMatchCredit($investId,$page,$size);

        $pageTool   = new ToolPaginate($resData['total'], $page, $size, '/user/invest/smartMatchDetailAjax' );

        $paginate   = $pageTool->getPaginate();

        $viewData   =   [
            'list'      => !empty($resData["data"])? $resData["data"]:[],
            'pager'     => $paginate,
            'count'     => $resData["total"],
            'investId'  => $investId
        ];

        return_json_format($viewData);
    }


    /**
     * @param Request $request
     * @return array|mixed
     * @desc 异步加息投资记录数据
     */
    public function getInvestDetailPacket( Request $request )
    {
        $recordId       =   (int)$request->get ('record_id') ;

        if( !$this->getUserId () || empty($recordId) ) {

            return Logic::callError ();
        }

        return  TermLogic::getUserInvestDetail($this->getUserId (),$recordId);
    }
}
