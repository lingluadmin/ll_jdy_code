<?php

/**
 * Created by PhpStorm.
 * User: jinzhuotao
 * Date: 2017/11/21
 * Time: 下午6:17
 */

namespace App\Http\Logics\Device;

use App\Http\Logics\Logic;
use App\Http\Models\Device\DeviceModel;
use Log;

class DeviceLogic extends Logic
{
    /**
     * 如果deviceId未保存，则记录激活设备数据
     *
     * @param $param
     * @return array
     * @desc
     *          $param['device_id']    //设备ID
     *          $param['channel_id']   //渠道ID
     *          $param['version_id']   //版本号
     *          $param['from']         //来源（android,ios）
     */
    public function addActivateRecord($param){

        $data = [];

        try{
            $data = [
                'device_id'     => !empty($param['device_id']) ? $param['device_id'] : '',
                'channel_id'    => !empty($param['channel_id']) ? $param['channel_id'] : '',
                'version_id'    => !empty($param['version_id']) ? $param['version_id'] : '',
                'from'          => !empty($param['from']) ? $param['from'] : '',
            ];

            if($data['device_id'] == ''){
                throw new \Exception('缺少设备ID');
            }

            Log::info(__METHOD__.'Data : ',$data);

            $model = new DeviceModel();
            //查找是否有记录
            $notExist = $model->checkExist($data['device_id']);

            //如果不存在，则添加设备记录
            if($notExist){
                $model->creat($data);
            }

            Log::info(__METHOD__.'Success', $param);

        }catch(\Exception $e){
            $param['data']           = $data;
            $param['msg']            = $e->getMessage();
            $param['code']           = $e->getCode();

            Log::error(__METHOD__.'Error', $param);

            return self::callError($e->getMessage());
        }

        return self::callSuccess();
    }
}