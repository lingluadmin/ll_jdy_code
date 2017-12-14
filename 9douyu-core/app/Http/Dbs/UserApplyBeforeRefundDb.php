<?php
/**
 * Created by PhpStorm.
 * User: zhangshuang
 * Date: 16/9/25
 * Time: 15:10
 */

namespace App\Http\Dbs;

use App\Tools\ToolTime;

class UserApplyBeforeRefundDb extends JdyDb{

    protected $table = "user_apply_before_refund";


    CONST
            STATUS_APPLY_ING = 100,   //赎回申请

            STATUS_APPLY_SUC = 200,   //赎回中

            STATUS_REFUND    = 300,   //赎回成功
        END=TRUE;


    /**
     * @param $data
     * @return mixed
     * 添加赎回申请记录
     */
    public function addRecord($data){

        return self::insert($data);
    }


    /**
     * @param $id
     * @return mixed
     * 赎回中
     */
    public function applyBeforeSuc($id){

        return self::where('invest_id',$id)
                ->where('status',self::STATUS_APPLY_ING)
                ->update(['status'=>self::STATUS_APPLY_SUC]);
    }

    /**
     * @param $id
     * @return mixed
     * 赎回成功
     */
    public function applyBeforeRefundSuc($id){

        return self::where('invest_id',$id)
            ->where('status',self::STATUS_APPLY_SUC)
            ->update(['status'=>self::STATUS_REFUND]);
    }

    /**
     * @param $id
     * @return mixed
     * 根据主键获取项目信息
     */
    public function getObj($id){

        return self::find($id);
    }

    /**
     * @param $investId
     * 根据投资ID获取对应的债权项目信息
     */
    public function getByInvestId($investId){

        return self::where('invest_id',$investId)
            ->where('status','<>',self::STATUS_CANCEL)
            ->first();
    }


    /**
     * @param $investId
     * 根据投资ID获取对应的债权项目信息
     */
    public function getInvestInfoById($investId){

        $result = self::where('invest_id',$investId)
            ->first();

        return self::dbToArray($result);
    }

}