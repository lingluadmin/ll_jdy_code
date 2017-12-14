<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/4/26
 * Time: 上午11:14
 */

namespace App\Http\Logics\Invest;

use App\Http\Dbs\CurrentAccountDb;
use App\Http\Dbs\InvestDb;
use App\Http\Dbs\RefundRecordDb;
use App\Http\Dbs\ProjectDb;
use App\Http\Logics\Logic;
use App\Http\Models\Common\ValidateModel;
use App\Http\Models\Invest\InvestModel;
use App\Http\Models\Refund\ProjectModel;
use App\Tools\ToolArray;
use Illuminate\Support\Facades\Lang;
use App\Tools\ToolString;
use Log;

class InvestLogic extends Logic
{

    /**
     * @param $id
     * @return mixed
     * @desc 获取投资记录信息
     */
    public function getInfoById($id)
    {

        $investDb = new InvestDb();

        return $investDb->getInfoById($id);

    }


    public function getListByUserId($userId)
    {



    }

    /**
     * @param int $size
     * @return mixed
     * @desc 获取最新的投资记录
     */
    public function getInvestNew($size = 0){

        $size     = $size>0 ? $size : 30;

        $investDb = new InvestDb();

        $list     = $investDb->getInvestNew($size);

        return $list;
    }

    /**
     * @param string $start
     * @param string $end
     * @return mixed
     * @desc 根据开始结束日期获取投资记录总额
     */
    public function getInvestAmountByDate($start = '',$end = ''){

        $investDb = new InvestDb();

        $list     = $investDb->getInvestAmountByDate($start,$end);

        return $list;
    }

    /**
     * @param string $start
     * @param string $end
     * @return mixed
     * @desc 根据时间段获取投资总额
     */
    public function getInvestTermTotal($start = '', $end = ''){

        $db   = new InvestDb();

        $res  = $db->getInvestTermTotal($start,$end);

        $cash = empty($res) ? 0 : $res['cash'];

        return $cash;
    }


    /**
     * @param $projectIds
     * @return mixed
     * 获取指定项目的投资记录
     */
    public function getInvestListByProjectIds($projectIds){

        $db = new InvestDb();
        return $db->getInvestListByProjectIds($projectIds);
    }

    /**
     * @desc 获取多个投资ID的投资记录投资列表
     * @param $investIds
     * @return mixed
     */
    public function getInvestListByIds($investIds){

        $investId = explode(',', $investIds);

        $investDb = new InvestDb();

        return $investDb->getInvestByIds($investId);
    }


    /**
     * @param $userIds
     * @param $allUserIds
     * 获取合伙人邀请人待收明细
     */
    public function getPartnerPrincipal($cash,$allUserIds){

        if(!$allUserIds){

            return self::callError('用户不存在');
        }

        $allUserIds = explode(',',$allUserIds);


        //定期还款计划列表
        $refundDb   = new RefundRecordDb();
        $refundData = $refundDb->getRefundByUserIds($allUserIds);

        $refundList = ToolArray::arrayToKey($refundData,'user_id');

        //活期账户信息
        $currentDb  = new CurrentAccountDb();
        $currentData = $currentDb->getByUserIds($allUserIds);

        $currentList = ToolArray::arrayToKey($currentData,'user_id');


        //定期总待收
        $refundCash = $refundDb->getRefundTotalByUserIds($allUserIds);
        //活期账户总金额
        $currentCash = $currentDb->getTotalCashByUserIds($allUserIds);

        $totalPrincipal = $currentCash + $refundCash['total_cash'];

        $inviteNum = 0;

        foreach($allUserIds as $id){

            $principal = 0;
            if(isset($refundList[$id])){
                $principal += $refundList[$id]['total_cash'];

            }

            if(isset($currentList[$id])){
                $principal += $currentList[$id]['cash'];
            }

            $list[$id] = $principal;

            if($principal > $cash){
                $inviteNum ++;
            }
        }

        $result['list'] = $list;
        $result['principal'] = $totalPrincipal;
        $result['inviteNum']  = $inviteNum;

        return self::callSuccess($result);
    }
    /**
     * @param $projectIds
     * @return mixed
     * 获取指定项目的投资记录
     */
    public function getNormalInvestListByProjectIds($projectIds){

        $projectIds = explode(',', $projectIds);

        $db     = new InvestDb();

        return $db->getNormalInvestListByProjectIds($projectIds);
    }
    /**
     * @param string $projectIds
     * @return array
     * @desc 从核心获取最后一次投资的数据(不包含原项目债转的记录)
     */
    public function getLastInvestTimeByProjectId($projectIds = '' )
    {
        $projectIds     =   explode(",",$projectIds);

        if( empty($projectIds) ){

            return [];
        }

        $investDb       =   new InvestDb();

        return $investDb->getLastInvestTimeByProjectId($projectIds);
    }

    /**
     * @param $userId
     * @param $page
     * @param $size
     * @return array
     * @desc 投资记录
     */
    public function getInvestListByUserId($userId, $refund='all', $status='all', $page=1, $size=10)
    {

        if( empty($userId) )
        {
            return self::callError ('用户Id不可以为空');
        }
        $refundType =   $statusType = '' ;

        if( $refund != 'all' ) {

            $refundList =   ProjectModel::getProjectRefundType () ;
            if( !in_array ($refund, $refundList) ) {

                return self::callError ('回款方式不存在' );
            }
            $refundList =   array_flip ( $refundList );

            $refundType =   $refundList[$refund] ;
        }

        if( $status != 'all' ) {

            $statusList =   ProjectModel::getProjectStatusList () ;

            if( !in_array ($status, $statusList ) ){

                return self::callError ('项目状态不存在' );
            }

            $statusList =   array_flip ( $statusList );

            $statusType =   $statusList[$status] ;
        }

        $investDb   = new InvestDb();

        $investList = $investDb->getInvestListByUserId($userId, $refundType, $statusType, $page, $size);

        if( !empty($investList['list']) ) {
            foreach ($investList['list'] as $Key => $invest ) {
                $investList['list'][$Key] =   $this->formatUserInvestRecord ($invest);
            }
        }

        return self::callSuccess($investList);

    }

    /**
     * @param $userId
     * @param string $status
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getSmartInvestListByUserId($userId,  $status='all', $page=1, $size=10)
    {

        if( empty($userId) )
        {
            return self::callError ('用户Id不可以为空');
        }
        $statusType = '' ;


        if( $status != 'all' ) {

            $statusList =   ProjectModel::getSmartProjectStatusList();

            if( !in_array ($status, $statusList ) ){

                return self::callError ('项目状态不存在' );
            }

            $statusList =   array_flip ( $statusList );

            $statusType =   $statusList[$status] ;
        }

        $investDb   = new InvestDb();

        $match  = 0;
        if($statusType == ProjectDb::STATUS_REFUNDING){
            $match = 1;
        }elseif($statusType == ProjectDb::STATUS_MATCHING){

            $statusType = ProjectDb::STATUS_REFUNDING;
        }

        $investList = $investDb->getSmartInvestListByUserId($userId,$statusType,$match,$page,$size);

        if( !empty($investList['list']) ) {
            foreach ($investList['list'] as $Key => $invest ) {
                $investList['list'][$Key] =   $this->formatUserInvestRecord ($invest,1);
            }
        }

        return self::callSuccess($investList);

    }

    /**
     * @param $userId
     * @return array
     * @desc 根据用户Id获取该用户投资记录（用来判断用户是否投资）
     */
    public function getUserInvestDataByUserId($userId){

        $investDb = new InvestDb();

        $result = $investDb->getUserInvestDataByUserId($userId);

        return self::callSuccess($result);

    }

    /**
     * @param array $investRecord
     * @param int $smartFlag
     * @return array
     * @desc format user invest record
     */
    protected function formatUserInvestRecord( $investRecord = [],$smartFlag=0 )
    {
        if( empty($investRecord) ) {

            return [] ;
        }
        //项目回款方式
        $investRecord['refund_type_note']   =   isset($investRecord['refund_type']) ? Lang::get('messages.PROJECT.REFUND_TYPE_' . $investRecord['refund_type']) : '先息后本';

        if($smartFlag==1 && $investRecord['status']==ProjectDb::STATUS_REFUNDING){

            $investRecord['status_note']        =   isset($investRecord['status']) ? Lang::get('messages.PROJECT.STATUS_' . $investRecord['status'].'_'.$investRecord['is_match']) : '未知状态' ;
        }else{

            $investRecord['status_note']        =   isset($investRecord['status']) ? Lang::get('messages.PROJECT.STATUS_' . $investRecord['status']) : '未知状态' ;
        }


        $investRecord['format_name']        =  ToolString::setProjectName($investRecord);

        return $investRecord ;
    }

    /**
     * 根据项目ID 获取投资记录
     *
     * @param $projectId
     * @param $page
     * @param $size
     * @param $startTime
     * @param $endTime
     * @return array
     */
    public function getInvestByProjectId($projectId, $page, $size, $startTime, $endTime)
    {
        $investDb  = new InvestDb();

        return $investDb->getInvestByProjectId($projectId, $page, $size, $startTime, $endTime);
    }


    /**
     * @param $data
     * @return array
     * 更新匹配状态
     */
    public function doUpdateInvestRecordIsMatch($data){

        if( empty($data) && is_array($data)){

            Log::error('更新匹配状态数据为空', [$data]);

            return self::callError('数据为空');
        }

        $model = new InvestModel();

        $errInvestArr = [];

        $investIds = [];

        foreach($data as $key => $item){

            if( empty($item) ){

                Log::error('更新匹配状态数据为空', [$item]);

                continue;

            }

            try{

                if(empty($item['invest_id']) || empty($item['project_id']) || empty($item['user_id']) || empty($item['cash']) || empty($item['assets_platform_sign'])  ){

                    $item['msg'] = '数据参数不全';

                    Log::error('更新匹配状态数据参数不全', [$item]);

                    $errInvestArr[] = $item;

                    continue;

                }

                $result = $model->checkInvest($item['invest_id'] , $item['project_id'], $item['user_id'], $item['cash'], $item['assets_platform_sign']);

                if( empty($result) ){

                    $item['msg'] = '查询无匹配投资订单';

                    Log::error('更新匹配状态数据查询无匹配投资订单', [$item]);

                    $errInvestArr[] = $item;

                    continue;

                }else{

                    $investIds[] = $item['invest_id'];

                }


            }catch (\Exception $e){

                //$item['err_msg'] = $e->getMessage();

                Log::error('更新匹配状态数据异常', [$item]);

                $errInvestArr[] = $item;

                continue;

            }

        }

        if( empty($investIds) ){

            Log::error('无符合数据', [$errInvestArr]);

            return self::callSuccess($errInvestArr);

        }

        try{

            Log::info('更新匹配状态数据', [$investIds]);

            $model->updateIsMatch($investIds);

        }catch (\Exception $e){

            Log::error('更新匹配状态数据异常', [$e->getMessage()]);

            return self::callError($e->getMessage());

        }

        return self::callSuccess($errInvestArr);

    }
}
