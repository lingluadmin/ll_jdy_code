<?php

/**
 * Created by PhpStorm.
 * User: jinzhuotao
 * Date: 2017/11/21
 * Time: 下午6:27
 */

namespace App\Http\Models\Device;

use App\Http\Dbs\Device\DeviceDb;
use App\Http\Models\Model;
use App\Http\Models\Common\ExceptionCodeModel;
use App\Lang\LangModel;

class DeviceModel extends Model
{
    public static $codeArr = [
        'create'                                    => 1,
        'checkExist'                                => 2,
    ];

    public static $defaultNameSpace = ExceptionCodeModel::EXP_MODEL_PHONE_DEVICE;

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     * @desc
     *          $data['device_id']    //设备ID
     *          $data['channel_id']   //渠道ID
     *          $data['version_id']   //版本号
     *          $data['from']         //来源（android,ios）
     */
    public function creat($data){
        $db = new DeviceDb();
        $result = $db -> add($data);

        if(!$result){
            throw new \Exception(LangModel::getLang('ERROR_DEVICE_ID_ADD'), self::getFinalCode('doCreate'));
        }

        return $result;

    }

    /**
     * @param      $deviceId
     * @param bool $isThrow
     * @return bool
     * @throws \Exception
     * @desc    检查device_id是否已存在，如果存在，返回false或抛异常
     */
    public function checkExist($deviceId, $isThrow=false){
        $db = new DeviceDb();
        $result = $db -> get($deviceId);
        if($result){
            if($isThrow){
                throw new \Exception(LangModel::getLang('ERROR_DEVICE_IS_EXIST'), self::getFinalCode('checkExist'));
            }
            return false;
        }
        return true;
    }
}