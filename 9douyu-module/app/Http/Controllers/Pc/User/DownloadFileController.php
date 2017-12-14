<?php

/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/6/12
 * Time: 下午6:35
 */
namespace App\Http\Controllers\Pc\User;


use App\Http\Controllers\Pc\UserController;
use App\Http\Logics\Contract\ContractLogic;
use App\Http\Logics\Fund\FundHistoryLogic;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Oss\OssLogic;
use App\Http\Models\Project\ProjectModel;
use App\Tools\ToolPaginate;
use App\Tools\ToolUrl;
use Illuminate\Http\Request;
use App\Tools\ToolPager;
use Redirect;

/**
 * 投资记录合同下载
 * Class FundHistoryController
 * @package App\Http\Controllers\Pc\User
 */
class DownloadFileController extends UserController
{

    const PER_PAGE_SIZE = 10;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 获取投资记录列表
     */
    public function userInvestList(){
        return view('pc.user.investList');

    }

    /**
     * @param string $refund
     * @param string $status
     * @param int $page
     */
    public function ajaxGetCommonInvestList($refund='all',$status='all',$page=1){

        $userId =   $this->getUserId();

        $ret   = TermLogic::getInvestListByUserId( $userId, $refund, $status, $page, self::PER_PAGE_SIZE);
        $count = $ret['total'];
        //分页
        $pageNation = new ToolPager($count, $page, self::PER_PAGE_SIZE, '/user/ajaxCommonInvestList/'.$refund.'/'.$status);
        $pager = $pageNation->getPaginate();
        //data
        $data = [
            'list'   => (isset($ret['list']) && !empty($ret['list'])) ? $ret['list'] : [],
            'pager'  => $pager
        ];
        return_json_format($data);
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function ajaxGetSmartInvestList($status='all',$page=1){

        $userId =   $this->getUserId();

        $ret   = TermLogic::getSmartInvestListByUserId( $userId, $status, $page, self::PER_PAGE_SIZE);
        $count = $ret['total'];
        //分页
        $pageNation = new ToolPager($count, $page, self::PER_PAGE_SIZE, '/user/ajaxSmartInvestList/'.$status);
        $pager = $pageNation->getPaginate();
        //data
        $data = [
            'list'   => (isset($ret['list']) && !empty($ret['list'])) ? $ret['list'] : [],
            'pager'  => $pager
        ];
        return_json_format($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function backAjaxGetInvestList(Request $request){

        $params =   $request->all ();

        $page   =   $request->input('page', 1);

        $size   =   $request->input('size', 10);

        $refund =   $request->input ('refund_type' , 'all');

        $status =   $request->input ('status' , 'all' ) ;

        $userId =   $this->getUserId();

        $record = TermLogic::getInvestListByUserId( $userId, $refund, $status, $page, $size);

        $logic  =   new ContractLogic();

        $paginate = '';

        $contractList= '' ;

        if( isset($params['s']) ) {
            unset($params['s']) ;
        }
        unset($params['page']);

        $requestUrl     =   ToolUrl::getUrl ('/user/investList' , $params ) ;
        $searchParam    =   TermLogic::setUserInvestRecordSearch('/user/investList' ,$params);

        if( !empty($record['list']) ){

            $pageTool = new ToolPaginate($record['total'], $page, $size, $requestUrl);

            $paginate = $pageTool->getPaginate();

            $contractList   =   $logic  ->getContractListByInvestId( array_column ($record['list'],'id'));
        }

        $data = [
            'list'      => (isset($record['list']) && !empty($record['list'])) ? $record['list'] : [],
            'contract'  => $contractList,
            'paginate'  => $paginate,
            'searchParam'=> $searchParam,
            'params'    => $params
        ];

        return view('pc.user.investList', $data);

    }







    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @desc 合同下载
     */
    public function doCreateDownLoad(Request $request)
    {

        $logic = new ContractLogic();

        $data = $request->all();

        $dataType   =   $request->input ('dataType','');

        $result     = $logic->doDownLoadWay( $data );

        if($dataType == 'json') {

            return    $result;
        }

        if(!empty($result['status']) && $result['status'] == true){
            $ossLogic = new OssLogic('oss_2');
            $contents = $ossLogic->getObject($result['data']['down_load_url']);
            header('Content-type: application/pdf');
            header("Cache-Control: no-cache, private");
            header('Content-Disposition: attachment;filename='.$result['data']['file_name']);
            echo $contents;
            exit;
        }
    }

    /**
     * @param Request $request
     * @return array
     * @desc 检测合同生成状态
     */
    public function checkContractStatus(Request $request)
    {
        $logic = new ContractLogic();

        $data = $request->all();

        return $logic->doCheckContractStatus ($data['invest_id']);
    }
}
