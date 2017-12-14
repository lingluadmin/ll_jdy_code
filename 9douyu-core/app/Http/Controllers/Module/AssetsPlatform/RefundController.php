<?php

namespace App\Http\Controllers\Module\AssetsPlatform;

use App\Http\Controllers\Controller;

use App\Http\Dbs\ProjectDb;
use App\Http\Logics\Refund\ProjectLogic;

use Illuminate\Http\Request;


/**
 * 资产平台回款
 *
 * Class RefundController
 * @package App\Http\Controllers\Module\AssetsPlatform
 */
class RefundController extends Controller
{

    /**
     * 到期回款
     *
     * @param Request $request
     * @return mixed
     */
    function endRefund(Request $request)
    {
        $refundRecord = $request->input('refundList');
        $isBefore     = $request->input('isBefore');

        $obj          = new ProjectLogic( );

        $result      = $obj->assetsPlatformSplitProjectRefund($refundRecord, $isBefore);

        \Log::info(__METHOD__, [$refundRecord, $result]);

        return self::returnJson($result);
    }

    /**
     * 提前赎回
     *
     * @param Request $request
     * @return array
     *
     */
    function beforeRefund(Request $request){

        $refundRecord = $request->input('refundList');

        $obj          = new ProjectLogic( );

        $result      = $obj->assetsPlatformProjectBeforeRefund($refundRecord);

        \Log::info(__METHOD__, [$refundRecord, $result]);

        return self::returnJson($result);

    }

    /**
     * @param Request $request
     * @return array
     * @desc 申请提前赎回
     */
    function applyBeforeRefund(Request $request){

        $investId   = (int)$request->input('invest_id', 0);
        $projectId  = (int)$request->input('project_id', 0);
        $userId     = (int)$request->input('user_id', 0);
        $cash       = (float)$request->input('cash', 0);
        $isCheck    = (int)$request->input('is_check', 0);
        $fee        = (float)$request->input('fee', 0);

        $obj        = new ProjectLogic();

        $result     = $obj->assetsPlatformApplyBeforeRefund($investId, $projectId, $userId, $cash, $isCheck, $fee);

        return self::returnJson($result);

    }
}

