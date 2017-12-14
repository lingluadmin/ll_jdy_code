<?php

namespace App\Http\Logics\AssetsPlatform;


use App\Http\Dbs\Project\ProjectDb;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Logic;
use App\Http\Models\Common\AssetsPlatformApi\OrderApiModel;
use App\Http\Models\Common\CoreApi\ProjectModel;
use Cache;

/**
 * 签署自动投标协议用户 自动投标 发送订单到资产平台
 *
 * Class AutoInvestFullLogic
 * @package App\Http\Logics\AssetsPlatform
 */
class AutoInvestFullLogic extends Logic
{

    private static $lockIds = [];
    /**
     * 获取再投智投项目列表
     *
     * @param $start
     * @param $end
     * @return array
     */
    public static function getInvestingSmartInvestProject($start, $end)
    {
        $status = [ProjectDb::STATUS_INVESTING, ProjectDb::STATUS_REFUNDING];

        return ProjectModel::getSmartInvestProjectList($start, $end, $status);
    }

    /**
     * 签署 自动投标协议的用户ID
     * @return int
     */
    public static function getSuperUserId()
    {
        return 69;
    }

    /**
     * 自动投满
     *
     * @param array $projectIds
     * @param array $errResults
     * @return array
     */
    public static function investFull($projectIds = [], $errResults=[])
    {

        foreach ($projectIds as $ind => $projectDb)
        {
            $projectId       = $projectDb['id'];

            \Log::info(__METHOD__, ['--AssetsPlatform—— 当前处理项目ID',$projectId]);

            $cacheKey = sprintf(TermLogic::PROJECT_LOCK, $projectId);

            if (!Cache::has($cacheKey))
            {
                Cache::put($cacheKey, 1, 0.2);

                $project     = ProjectModel::getProjectDetail($projectId);

                $left_amount = $project['total_amount'] - $project['invested_amount'];

                //自动满标
                if ($project['status'] == ProjectDb::STATUS_INVESTING && $left_amount > 0) {

                    $investReturn = self::_investFull($project, $left_amount);
                    //自动满标失败
                    if (!$investReturn['status'])
                    {
                        $errResults[] = $investReturn;
                    }
                } else {
                    \Log::info(__METHOD__, ['--AssetsPlatform—— 其他情况项目', $project]);
                }

                // 锁定的重新处理后 清除
                if(!empty(self::$lockIds))
                {
                    \Log::info(__METHOD__, ['--AssetsPlatform—— 尝试清除锁定项目',$projectId,self::$lockIds]);

                    if (isset(self::$lockIds[$projectId]))
                    {
                        \Log::info(__METHOD__, ['--AssetsPlatform—— 清除锁定项目成功'. $projectId]);

                        unset(self::$lockIds[$projectId]);
                    }
                }

            } else {

                \Log::info(__METHOD__, ['--AssetsPlatform—— 锁定项目', $projectDb]);

                self::$lockIds[$projectId] = $projectDb;
            }

        }

        if (!empty(self::$lockIds))
        {
            sleep(2);

            \Log::info(__METHOD__, ['--AssetsPlatform—— 尝试处理锁定项目', self::$lockIds]);

            self::investFull(self::$lockIds, $errResults);
        }

        return $errResults;
    }

    /**
     * 签署自动投标用户 投资
     *
     * @param $project
     * @param $left_amount
     * @return array
     */
    private static function _investFull($project, $left_amount)
    {
        $userId    = self::getSuperUserId();

        $termLogic = new TermLogic();

        $investReturn = $termLogic->doInvest($userId, $project['id'], $left_amount, '', 0, 'pc', '', false, true);

        \Log::error(__METHOD__, ['--AssetsPlatform—— 自动满标结果：', $userId, $project, $left_amount, $investReturn]);

        return $investReturn;
    }


    /**
     * 发送投资记录
     *
     * @param array $projectIds
     * @param $start
     * @param $end
     * @return array
     */
    public static function sendOrder($projectIds = [], $start, $end)
    {

        $return = [];

        foreach ($projectIds as $index => $projectDb)
        {
            $size            = 50;

            $page            = 1;

            $projectId       = $projectDb['id'];

            $investDb        = ProjectModel::getInvestListByProjectId($projectId, $page, $size, $start, $end);

            \Log::info(__METHOD__, ['--AssetsPlatform—— order 指定项目投资列表：', $projectDb, $investDb]);

            if(!empty($investDb) && isset($investDb['total']) && isset($investDb['list']))
            {
                $total     = $investDb['total'];

                $totalPage = ceil($total/$size);

                // 发送第一批
                $return[] = self::_sendOrder($projectDb['assets_platform_sign'], $investDb['list']);
                // 发送第其他页面
                if($totalPage > 1) {
                    for ($page = 2; $page <= $totalPage; $page++) {
                        $investDb  = ProjectModel::getInvestListByProjectId($projectId, $page, $size, $start, $end);

                        if(isset($investDb['list'])) {
                            $return[] = self::_sendOrder($projectDb['assets_platform_sign'], $investDb['list']);
                        }
                    }
                }
            }
        }

        return $return;
    }

    /**
     * 发送订单
     *
     * @param string $projectId
     * @param array $investDb
     * @return array
     */
    private static function _sendOrder($projectId = '', $investDb =[]){

        if(empty($investDb)){
            return [];
        }
        $orderList = [];
        foreach ($investDb as $key => $record)
        {
            $orderList[] = [
                'projectNo' => (string)$projectId,
                'userId'    => (string)$record['user_id'],
                'amount'    => (string)$record['cash'],
                'orderDate' => (string)$record['created_at'],
                'orderNo'   => (string)$record['id'],
                'isSuper'   => (string)(intval(self::getSuperUserId() == $record['user_id'])),
                'realName' => (string)(isset($record['real_name']) ? $record['real_name'] : '')
            ];
        }

        $infoList = [
            'infoList'=> [
                [
                    'projectNo' => (string)$projectId,
                    'orderList' => $orderList
                ]
            ]
        ];

        $return = OrderApiModel::sendOrder($infoList);

        \Log::info(__METHOD__, ['--AssetsPlatform—— order send：', $projectId, $investDb, $infoList, $return]);

        return $return;
    }

}

