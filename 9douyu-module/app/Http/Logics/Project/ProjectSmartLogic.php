<?php
/**
 * Created by PhpStorm.
 * User: liuqiuhui
 * Date: 2017/12/5
 * Time: 下午2:38
 */

namespace App\Http\Logics\Project;


use App\Http\Logics\Logic;
use App\Http\Logics\User\PasswordLogic;
use App\Http\Models\Common\AssetsPlatformApi\OrderApiModel;
use App\Http\Models\Common\CoreApi\ProjectModel;
use App\Http\Models\Invest\InvestModel;
use App\Http\Models\SystemConfig\SystemConfigModel;
use App\Tools\ToolTime;

class ProjectSmartLogic extends Logic
{

    /**
     * @param $investId
     * @param $interest
     * @return array
     * 申请赎回接口
     */
    public function investBeforeRefundApply($investId, $interest){

        //查询订单信息
        $investModel            = new InvestModel();
        $investInfo             = $investModel->getInvestByInvestId($investId);

        //查询项目信息
        $projectId = $investInfo['project_id'];
        $projectModel = new ProjectModel();
        $projectInfo = $projectModel->getProjectDetail($projectId);

        //查询赎回手续费率
        $beforeRefundFeeRate = SystemConfigModel::getConfig('SMART_PROJECT_BEFORE_REFUND_RATE');
        $beforeRefundFeeRate = empty($beforeRefundFeeRate) ? 0.00 : $beforeRefundFeeRate;
        $fee                 = $investInfo['cash']*$beforeRefundFeeRate;

        //到账金额
        $refundCash         = $investInfo['cash'] + $interest - $fee;

        //已锁定天数
        $days               = ToolTime::getDayDiff($investInfo['created_at'], ToolTime::dbDate());

        $investApplyInfo = [
            'investId'     => $investId,
            'cash'          => $investInfo['cash'],
            'interest'      => $interest,
            'fee'           => $fee,
            'refund_cash'   => $refundCash,
            'lock_days'     => $days,
            'project'       => $projectInfo,
        ];

        return $investApplyInfo;

    }

    /**
     * @param $investId
     * @param $userId
     * @param $projectId
     * @param $cash
     * @param $tradePassword
     * @param $fee
     * @return array|null|void
     * 提交赎回申请
     */
    public function doInvestBeforeRefundApply($investId, $userId, $projectId, $cash, $tradePassword, $fee)
    {

        try{

            $model  = new InvestModel();
            $result = $model->checkUserIdIsBeforeRefund( $userId );
            if(!$result)
                throw new \Exception('您不能进行提前赎回');

            //项目信息
            $projectLogic       = new ProjectDetailLogic();
            $project            = $projectLogic->get($projectId);

            //检测交易密码
            $tradePasswordLogic = new PasswordLogic();

            $checkTradeResult = $tradePasswordLogic->checkTradingPassword($tradePassword, $userId);

            if (!$checkTradeResult['status']) {

                return $checkTradeResult;

            }

            $isCheck = 1;

            $result = ProjectModel::assetsPlatformUserApplyBeforeRefund($investId, $projectId, $userId, $cash, $isCheck, $fee);

            if($result['status']){

                $params = [
                    "orderNo"   =>(string)$investId,
                    "userId"    =>(string)$userId,
                    "projectNo" =>(string)$project['assets_platform_sign'],
                    "date"      =>(string)date('Y-m-d'),//应树浩要求 加 当前日期
                ];

                $zcResult = OrderApiModel::redeemOrder($params);

                if($zcResult['data']['header']['resCode'] == 1 ){

                    throw new \Exception($zcResult['data']['header']['errorMsg']);

                }

                $result = ProjectModel::assetsPlatformUserApplyBeforeRefund($investId, $projectId, $userId, $cash, 0, $fee);

            }

            return $result;

        }catch (\Exception $e){

            return self::callError($e->getMessage());

        }


    }

}