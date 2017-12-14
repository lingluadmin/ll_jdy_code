<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/4/20
 * Time: 下午1:28
 * Desc: 回款相关
 */

namespace App\Http\Logics\Refund;

use App\Http\Dbs\FundHistoryDb;
use App\Http\Dbs\InvestDb;
use App\Http\Dbs\InvestExtendDb;
use App\Http\Dbs\ProjectDb;
use App\Http\Dbs\RefundRecordDb;
use App\Http\Dbs\UserApplyBeforeRefundDb;
use App\Http\Logics\Logic;
use App\Http\Logics\Warning\RefundLogic;
use App\Http\Models\Common\IncomeModel;
use App\Http\Models\Common\UserFundModel;
use App\Http\Models\Fund\TicketModel;
use App\Http\Models\Invest\InvestModel;
use App\Http\Models\Refund\ProjectModel;
use App\Jobs\Refund\SendNoticeJob;
use App\Tools\ToolArray;
use App\Tools\ToolTime;
use Log;
use App\Jobs\Refund\ProjectJob;


class ProjectLogic extends Logic
{

    /**
     * @param $projectId
     * @return array
     * 满标生成项目的回款计划
     */
    public function projectFullCreateRefundRecord( $projectId ){

        $return       = self::callError();

        $investDb     = new InvestDb();

        $incomeModel  = new IncomeModel();

        $projectModel = new ProjectModel();

        $refundDb     = new RefundRecordDb();

        $projectDb    = new ProjectDb();

        $investExtend = new InvestExtendDb();

        try{

            $projectInfo = $projectDb->getInfoById( $projectId );

            if( empty($projectInfo) ){

                Log::error('projectFullCreateRefundRecordError', [ $projectId, 'project detail is empty']);

                return self::callError('生成回款记录的项目不存在');

            }

            if( empty($projectInfo['new']) || !$projectInfo['new'] ){

                Log::error('projectFullCreateRefundRecordError', [ $projectId, 'do not new project' ]);

                return self::callError('非满标生成还款计划项目');

            }

            if( $projectInfo['total_amount'] > $projectInfo['invested_amount'] ){

                Log::error('projectFullCreateRefundRecordError', [ $projectId, 'do not full' ]);

                return self::callError('项目还未满标暂不生成还款计划');

            }

            $investList = $investDb->getInvestListByProjectIds([ $projectId ]);

            if( empty($investList) ){

                Log::error('projectFullCreateRefundRecordError', [ $projectId, 'invest list empty' ]);

                return self::callError('暂无投资记录');

            }

            $investIds = ToolArray::arrayToIds($investList);

            $refundList = $refundDb->getByInvestIds( $investIds );

            $refundInvestIds = ToolArray::arrayToIds($refundList, 'invest_id');

            $useBonusInvest = $investExtend->getListByInvestIds($investIds);

            $useBonusInvestList = ToolArray::arrayToKey($useBonusInvest, 'invest_id');

            $refundDataArr = [];

            foreach( $investList as $key => $value ){

                if( !in_array($value['id'], $refundInvestIds) ){

                    $refundData   = $incomeModel->getIncome($value['project_id'], $value['cash'], $value['created_at']);

                    $records      = $this->recordListFormat($refundData, $value['id'], $value['user_id'], $value['project_id']);

                    if( isset( $useBonusInvestList[ $value['id'] ] ) ){

                        $addRate = $useBonusInvestList[$value['id']]['bonus_value'];

                        $records[] = $incomeModel->getRateRecord( $value['id'], $addRate );

                    }

                    $refundDataArr = array_merge($records, $refundDataArr);

                }

            }

            $res          = $projectModel -> createRefundList($refundDataArr);

            $return = self::callSuccess();

            Log::Info('projectFullCreateRefundRecord',['创建回款记录成功',$res]);

        }catch (\Exception $e){

            $return['msg'] = $e->getMessage();

            $log = [
                'msg'   => $e->getMessage(),
                'code'  => $e->getCode()
            ];

            Log::error('createRefundFail', $log);

        }

        return $return;

    }

    /**
     * @param $investId
     * @param string $profit
     * @return array
     * @desc 创建回款记录，$profit 为加息券的利率
     */
    public function createRecord($investId)
    {

        $return       = self::callError();

        $investDb     = new InvestDb();

        $incomeModel  = new IncomeModel();

        $projectModel = new ProjectModel();

        $refundDb     = new RefundRecordDb();

        $projectDb    = new ProjectDb();

        $commonInfo = $refundDb->getCommonInfoByInvestId($investId);

        if( $commonInfo ){

            Log::Error(__METHOD__."Error", ['msg' => '记录已存在', 'invest_id' => $investId]);

            return self::callError('记录已存在');
            
        }

        try{

            $investInfo   = $investDb->getObj($investId);

            if( empty($investInfo) ){

                Log::error('createRecordError',['invest_id' => $investId]);

                return $return;

            }

            $projectInfo = $projectDb->getInfoById( $investInfo->project_id );

            if( empty($projectInfo) ){

                Log::error('createRecordError', [ $investInfo, 'project info is empty']);

                return self::callError('生成回款记录的项目不存在');

            }

            if( !empty($projectInfo['new']) && $projectInfo['new'] ){

                Log::error('createRecordError', [ $projectInfo, 'new project full create refund record' ]);

                return self::callError('新定期满标后生成项目还款计划');

            }

            $refundData   = $incomeModel->getIncome($investInfo->project_id, $investInfo->cash, $investInfo->created_at);

            Log::Info('createRecordInfo',$refundData);

            $records      = $this -> recordListFormat($refundData, $investId, $investInfo->user_id, $investInfo->project_id);

            $res          = $projectModel -> createRefundList($records);

            $return = self::callSuccess();

            Log::Info('createRefundRecordSuccess',['创建回款记录成功',$res]);

        }catch (\Exception $e){

            $return['msg'] = $e->getMessage();

            $log = [
                'msg'   => $e->getMessage(),
                'code'  => $e->getCode()
            ];

            Log::error('createRefundFail', $log);

        }

        return $return;

    }

    /**
     * @param string $times
     * @desc 拆分回款条数，加入任务队列
     */
    public function splitRefund($times='')
    {

        $return = self::callError();

        $refundDb = new RefundRecordDb();

        $count = $refundDb->getRefundCountByTimes($times);

        $size = 200;

        $page = ceil($count/$size);

        for( $i = 1; $i <= $page; $i++ ){

            $data = [
                'size'  => $size,
                'times' => $times
            ];

            $res = \Queue::pushOn('doRefund',new ProjectJob($data));

            if( !$res ){

                //短信报警
                $return['msg'] = '定期回款拆分加入队列失败';

                $return['data'] = $data;

                RefundLogic::splitRefundProjectWarning($return);

            }else{

                Log::info('splitRefundSuccess',$data);

            }

        }

        return self::callSuccess();

    }

    /**
     * @param string $times
     * @desc 检测定期项目是否回款失败
     */
    public function CheckProjectRefund($times = ''){

        $times = $times ? $times : ToolTime::dbDate();

        $refundDb = new RefundRecordDb();

        $count = $refundDb->getRefundCountByTimes($times);

        if( $count > 0 ){

            $return['msg'] = $times.'定期未回款,请工程师紧急处理';

            RefundLogic::CheckProjectRefund($return);

        }

    }



    /**
     * @param string $times
     * @return array
     * @desc 执行回款
     */
    public function doRefund($times='', $size=200)
    {

        $return  = self::callError();

        self::beginTransaction();

        $refundProject = new ProjectModel();

        $userFundModel = new UserFundModel();

        $times = $times ? $times : ToolTime::dbDate();

        try{

            //获取还款列表
            $refundList = $refundProject->getRefundList($times, $size);

            //更新账户
            foreach( $refundList as $val ){

                $userFundModel->increaseUserBalance($val['user_id'], $val['cash'], FundHistoryDb::PROJECT_REFUND, '项目 '.$val["project_id"].' 回款');

            }

            //标记回款状态
            $ids = ToolArray::arrayToIds($refundList, 'id');

            $refundProject->updateRefundSuccessByIds($ids);

            self::commit();

            $return = self::callSuccess();

            $log = [
                'times' => $times,
                'msg'   => '还款成功'
            ];

            Log::info('doRefundSuccess',$log);

            $projectIds = ToolArray::arrayToIds($refundList, 'project_id');

            $eventData = [
                'project_ids'   => $projectIds,
                'end_time'      => $times
            ];

            //触发回款成功事件
            \Event::fire('App\Events\Refund\ProjectSuccessEvent', [$eventData]);
            
        }catch (\Exception $e) {

            self::rollback();

            //短信报警
            $return['msg'] = '回款失败，失败原因：'.$e->getMessage();

            $warningMsg = "时间:【{$times}】, 拆分SIZE:【{$size}】, 错误信息:".$e->getMessage().", errorCode:".$e->getCode();

            Log::error('doRefundError', [$warningMsg]);

            RefundLogic::doRefundProjectWarning($warningMsg);

        }

        return $return;

    }

    /**
     * @param $recordList
     * @param $investId
     * @param $userId
     * @param $projectId
     * @return mixed
     * @desc 格式化回款记录
     */
    public function recordListFormat($recordList, $investId, $userId, $projectId){

        foreach($recordList as $key => $value){

            $recordList[$key]['invest_id']  = $investId;

            $recordList[$key]['user_id']    = $userId;

            $recordList[$key]['project_id'] = $projectId;

            $recordList[$key]['type'] = RefundRecordDb::TYPE_COMMON;

            //$recordList[$key]['status']     = RefundRecordDb::STATUS_ING;

        }

        return $recordList;

    }

    /**
     * @return bool
     * @desc 获取明日回款列表,分页拆分加入队列,等待执行
     */
    public function splitRefundToJob()
    {

        $refundDb = new RefundRecordDb();

        $date = ToolTime::getDateAfterCurrent();

        $refundUserList = $refundDb->getRefundListByDate($date);

        if( !empty($refundUserList) ){

            $refundUserList = array_chunk($refundUserList, 100);

            foreach( $refundUserList as $key => $refundInfo ){

                $res = \Queue::pushOn('doSendRefundNotice',new SendNoticeJob($refundInfo));

                if( !$res ){

                    Log::Error(__METHOD__.'Error', ['key' => $key, 'data' => $refundInfo]);

                    return false;

                }
                
            }

        }

    }

    /**
     * 资产平台回款记录
     *
     * @param array $projectRefundList
     * @param array $isBefore
     * @return array
     */
    public function assetsPlatformSplitProjectRefund($projectRefundList = [], $isBefore=0)
    {
        $errorReturn      = [];

        foreach ($projectRefundList as $pid => $refundRecord)
        {
           $ret = $this->assetsPlatformCheck($pid, $refundRecord);

           if(!$ret['status'])
           {
               $errorReturn[] = ['data'=> $refundRecord, 'msg'=> $ret['msg']];

//               if($isBefore){
//                   $record['msg'] = $ret['msg'];
//                   $errorReturn[] = $record;
//               }
           }else {
               foreach ($refundRecord as $k => $record)
               {
                   $ret = $this->_assetsPlatformCreateRefundRecord($record, $isBefore);
                   if(!$ret['status'])
                   {
                       $errorReturn[] = ['data'=> [$record], 'msg'=> $ret['msg']];
                   }
//                   elseif(!$ret['status'] && $isBefore == 1)
//                   {
//                       $record['msg'] = $ret['msg'];
//                       $errorReturn[] = $record;
//                   }
               }
           }
        }
        \Log::info(__METHOD__, [$errorReturn]);

        return self::callSuccess($errorReturn);
    }

    /**
     * 资产平台项目 创建回款记录
     *
     * 未满标 也可生产回款记录
     *
     * @param $projectId
     * @param $refundList
     * @return array
     */
    private function assetsPlatformCheck($projectId, $refundList)
    {

        $projectDb    = new ProjectDb();

        try{
            //本批次 不生成回款记录的数据检测 start------------------------------------------------------------
            $projectInfo = $projectDb->getInfoById( $projectId );

            if( empty($projectInfo) )
            {
                $msg = '生成回款记录的项目不存在';

                Log::error(__METHOD__, [ $projectId, $msg]);

                throw new \Exception($msg);

            }else{

                if( empty($projectInfo['assets_platform_sign']) || !$projectInfo['assets_platform_sign'] )
                {
                    $msg = '非资产平台项目要生成的还款计划';

                    Log::error(__METHOD__, [ $projectId, $msg]);

                    throw new \Exception($msg);
                }

                $assets_platform_signs = ToolArray::arrayToIds($refundList, 'assets_platform_sign');

                if(count($assets_platform_signs) == 1)
                {
                    if($assets_platform_signs[0] != $projectInfo['assets_platform_sign'])
                    {
                        $msg = '资产平台项目标示有和九斗鱼项目标示不匹配的数据';

                        Log::error(__METHOD__, [$projectId, $projectInfo['assets_platform_sign'], $assets_platform_signs, $msg]);

                        throw new \Exception($msg);
                    }
                }else{
                    $msg = '资产平台项目标示 和 九斗鱼项目标示 不匹配';

                    Log::error(__METHOD__, [$projectId, $projectInfo['assets_platform_sign'], $assets_platform_signs, $msg]);

                    throw new \Exception($msg);
                }
            }
            //本批次 不生成回款记录的数据检测  end ------------------------------------------------------------
        }catch (\Exception $e){

            \Log::info(__METHOD__,['Exception_', $e->getFile(), $e->getLine(), $e->getCode(), $e->getMessage()]);

            return self::callError($e->getMessage());
        }

        return self::callSuccess('允许生成回款记录');
    }


    /**
     * 创建回款记录
     *
     * @param array $record
     * @param array $isBefore
     * @return array
     */
    private function _assetsPlatformCreateRefundRecord($record = [], $isBefore=0)
    {
        //唯一票据
        $ticketModel  = new TicketModel( );
        $projectModel = new ProjectModel( );

        try{

            \Log::info(__METHOD__,[$record, $isBefore]);

            if(isset($record['assets_platform_sign']))
                unset($record['assets_platform_sign']);

            $ticketId = 'zcpt_' . $record['refund_ticket'];

            unset($record['refund_ticket']);

            self::beginTransaction();

            $ticketModel->checkTicketExist($ticketId);

            $investRecord = InvestDb::where(['project_id'=> $record['project_id'], 'user_id'=> $record['user_id'], 'id'=> $record['invest_id'], 'cash'=> $record['principal']])->first();

            if(empty($investRecord))
                throw new \Exception('未找到对应的投资记录');

            $refundRecord = RefundRecordDb::where(['project_id'=> $record['project_id'], 'user_id'=> $record['user_id'], 'invest_id'=> $record['invest_id'], 'principal'=> $record['principal']])->first();
            if(!empty($refundRecord))
                throw new \Exception('重复生成回款记录');

            if($isBefore){
                $record['status'] = RefundRecordDb::STATUS_SUCCESS;
                $record['times']  = ToolTime::dbDate();
            }
            $id = $projectModel->createRefundList($record);

            $ticketModel->doCreate($ticketId, $id);

            if($isBefore){

                self::_assetsPlatformProjectBeforeRefund($record);

            }

            self::commit();

        }catch (\Exception $e){
            //已经插入成功
            if($e->getCode() === 201027102 || $e->getMessage() === '重复生成回款记录' )
            {
                \Log::info(__METHOD__,['重复生成回款记录', $record]);
                return self::callSuccess('生成回款记录成功');
            }

            \Log::info(__METHOD__,[$record, $e->getFile(), $e->getLine(), $e->getCode(), $e->getMessage()]);

            self::rollback();

            return self::callError($e->getMessage());
        }

        return self::callSuccess('生成回款记录成功');

    }

    /**
     * @param $record
     * @throws \Exception
     * 提前赎回操作
     */
    private function _assetsPlatformProjectBeforeRefund ( $record ){

        //检测试是否有赎回记录
        $applyRecord = UserApplyBeforeRefundDb::where(['project_id'=> $record['project_id'], 'user_id'=> $record['user_id'], 'invest_id'=> $record['invest_id'], 'cash'=> $record['principal']])->first();

        if(empty($applyRecord))
            throw new \Exception('未找到对应的申请赎回记录');

        //给用户回款
        $userFundModel = new UserFundModel();
        $userFundModel->increaseUserBalance($record['user_id'], $record['cash'], FundHistoryDb::PROJECT_REFUND, '提前赎回-'.$record['invest_id']);

        //扣除手续费
        if($applyRecord['fee'] > 0)
            $userFundModel->decreaseUserBalance($record['user_id'], $applyRecord['fee'], FundHistoryDb::CHARGE_BALANCE, '提前赎回手续费-'.$record['invest_id']);

        //更新赎回状态
        $applyModel = new investModel();

        $applyModel->updateRecordRefunded( $record['invest_id'] );

    }

    /**
     * @param $data
     * @return bool
     * @desc 获取提前赎回订单,加入队列,等待执行
     */
    public function assetsPlatformProjectBeforeRefund( $data ){

        $errorReturn      = [];

        foreach ($data as $refundRecord)
        {
            $ret = $this->assetsPlatformCheck($refundRecord['project_id'], [$refundRecord]);

            if(!$ret['status'])
            {
                $errorReturn[] = ['data'=> $refundRecord, 'msg'=> $ret['msg']];
            }else {
                $refundRecord['times'] = ToolTime::dbDate();
                $refundRecord['status'] = RefundRecordDb::STATUS_SUCCESS;
                $ret = $this->_assetsPlatformCreateRefundRecord($refundRecord, 1);
                if(!$ret['status'])
                {
                    $refundRecord['msg'] = $ret['msg'];
                    $errorReturn[] = $refundRecord;
                }
            }
        }
        \Log::info(__METHOD__, [$errorReturn]);

        return self::callSuccess($errorReturn);

    }

    /**
     * @param $investId
     * @param $projectId
     * @param $userId
     * @param $cash
     * @param $isCheck
     * @param $fee
     * @return bool
     * @desc 申请提前赎回
     * 1. 检测数据是否正确
     * 2. 检测数据是否存在
     * 3. 检测数据是否已提交过赎回申请
     * 2. 添加赎回记录
     */
    public function assetsPlatformApplyBeforeRefund($investId, $projectId, $userId, $cash, $isCheck=1, $fee){

        try {

            if (empty($investId) || empty($projectId) || empty($userId) || empty($cash))
                throw new \Exception('参数不全');

            $investRecord = InvestDb::where(['project_id' => $projectId, 'user_id' => $userId, 'id' => $investId, 'cash' => $cash])->first();

            if (empty($investRecord))
                throw new \Exception('未找到对应的投资记录');

            if (ToolTime::getDate($investRecord['created_at']) == ToolTime::dbDate())
                throw new \Exception('投资当日不可申请赎回');

            $applyRecord = UserApplyBeforeRefundDb::where(['project_id' => $projectId, 'user_id' => $userId, 'invest_id' => $investId])->first();

            $projectRecord = ProjectDb::where(['id' => $projectId])->first();

            if (empty($projectRecord))
                throw new \Exception('未找到对应的项目');

            if ($projectRecord['status'] == ProjectDb::STATUS_FINISHED)
                throw new \Exception('此项目已完结不可申请赎回');

            $model = new InvestModel();

            if ($isCheck){

                if (!empty($applyRecord))
                    throw new \Exception('此投资记录已提交过赎回申请');

                $data = [
                    'invest_id'     => $investId,
                    'project_id'    => $projectId,
                    'user_id'       => $userId,
                    'cash'          => $cash,
                    'end_at'        => $projectRecord['end_at'],
                    'fee'           => $fee,
                ];

                $model->addRecord($data);

            }else{

                if (empty($applyRecord))
                    throw new \Exception('此投资未申请赎回');

                $model->updateRecordRefundIng($investId);

                $data = $applyRecord->toArray();

            }

        }catch(\Exception $e){

            Log::error('申请赎回失败:', [$e->getMessage(), $e->getLine() ]);
            return self::callError($e->getMessage());

        }

        return self::callSuccess($data, '申请赎回成功');

    }

    

}