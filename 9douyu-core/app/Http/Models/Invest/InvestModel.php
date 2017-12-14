<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/4/15
 * Time: 下午1:43
 * Desc: 投资记录
 */

namespace App\Http\Models\Invest;


use App\Http\Dbs\InvestDb;
use App\Http\Dbs\UserApplyBeforeRefundDb;
use App\Http\Models\Common\ExceptionCodeModel;
use App\Http\Models\Model;
use App\Lang\LangModel;

class InvestModel extends Model
{


    public static $codeArr = [
        'add'                    => 1,
        'getById'                => 2,
        'getByProjectIdAndUserId'=> 3,
        'updateIsMatch'          => 4,
        'addRecord'              => 5,
        'updateRecordRefundIng'  => 6,
        'updateRecordRefunded'   => 7,
    ];

    public static $expNameSpace = ExceptionCodeModel::EXP_MODEL_INVEST;

    /**
     * @param $projectId
     * @param $userId
     * @param $cash
     * @return bool
     * @throws \Exception
     * @desc 插入投资记录
     */
    public function add($projectId, $userId, $cash,$investType = InvestDb::INVEST_TYPE,$assignProjectId = 0)
    {

        $data = [
            'project_id'    => $projectId,
            'user_id'       => $userId,
            'cash'          => $cash,
            'invest_type'   => $investType,
            'assign_project_id' => $assignProjectId
        ];
        $db = new InvestDb();

        $res = $db->add($data);

        if( !$res ){

            throw new \Exception(LangModel::getLang('ERROR_INVEST_RECORD'), self::getFinalCode('add'));

        }

        return $res;

    }

    /**
     * @param $investId
     * 根据投资ID获取对应的数据
     */
    public function getById($investId){

        $db = new InvestDb();

        $res = $db->getObj($investId);

        if(!$res){

            throw new \Exception(LangModel::getLang('ERROR_EMPTY_RECORD'), self::getFinalCode('getById'));
        }
        return $res;

    }

    /**
     * @param $projectId
     * @param $userId
     * @return mixed
     * 获取用户投资某个项目指定金额的所有记录
     */
    public function getByProjectIdAndUserId($projectId,$userId,$cash){
        
        $db = new InvestDb();
        
        $result = $db->getByProjectIdAndUserId($projectId,$userId,$cash);

        if(!$result){

            throw new \Exception(LangModel::getLang('ERROR_EMPTY_RECORD'), self::getFinalCode('getByProjectIdAndUserId'));

        }

        return $result;
    }


    /**
     * @desc 获取用户投资数据的投资画像
     * @param $userIds
     * @param $startTime
     * @param $endTime
     * @return array
     */
    public static function getUserInvestBill($userIds, $startTime, $endTime)
    {
        $db = new InvestDb();

        $investInfo = $db->joinTableProject()
            ->investStatisticsField()
            ->getMoreInvestUserIdParam($userIds)
            ->getInvestDateParam($startTime, $endTime)
            ->getSqlBuilder()
            ->groupBy('user_id')
            ->get()
            ->toArray();

        $investList = $db->getSqlBuilder(true)
            ->joinTableProject()
            ->investListField()
            ->getMoreInvestUserIdParam($userIds)
            ->getInvestDateParam($startTime, $endTime)
            ->getSqlBuilder()
            ->get()
            ->toArray();

        return ['invest_info' => $investInfo, 'invest_list' => $investList];
    }

    /**
     * @param $investId
     * @param $projectId
     * @param $userId
     * @param $cash
     * @param $assetsPlatformSign
     * @return array
     * 检测投资记录
     */
    public function checkInvest($investId, $projectId, $userId, $cash, $assetsPlatformSign){

        $db = new InvestDb();

        $investInfo = $db->checkInvest($investId, $projectId, $userId, $cash, $assetsPlatformSign);

        return $investInfo;

    }

    /**
     * @param $investIds
     * @throws \Exception
     *
     */
    public function updateIsMatch( $investIds ){

        $db = new InvestDb();

        $result = $db->updateIsMatch($investIds);

        if( !$result ){

            throw new \Exception('数据更新失败', self::getFinalCode('updateIsMatch'));

        }

    }

    /**
     * @param $data
     * @throws \Exception
     * 申请赎回
     */
    public function addRecord( $data ){

        $db = new UserApplyBeforeRefundDb();

        $result = $db->addRecord($data);

        if( !$result )
            throw new \Exception('申请赎回数据添加失败', self::getFinalCode('addRecord'));

    }

    /**
     * @param $id
     * @throws \Exception
     * 赎回中
     */
    public function updateRecordRefundIng( $investId ){

        $db = new UserApplyBeforeRefundDb();

        $result = $db->applyBeforeSuc( $investId );

        if( !$result )
            throw new \Exception('申请赎回失败', self::getFinalCode('updateRecordRefundIng'));

    }

    /**
     * @param $id
     * @throws \Exception
     * 赎回成功
     */
    public function updateRecordRefunded( $id ){

        $db = new UserApplyBeforeRefundDb();

        $result = $db->applyBeforeRefundSuc( $id );

        if( !$result )
            throw new \Exception('赎回失败', self::getFinalCode('updateRecordRefunded'));

    }


}