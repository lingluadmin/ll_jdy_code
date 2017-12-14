<?php

/**
 * Created by PhpStorm.
 * User: jinzhuotao
 * Date: 2017/11/21
 * Time: 下午6:42
 */

namespace App\Http\Dbs\Device;

use App\Http\Dbs\JdyDb;

class DeviceDb extends JdyDb
{

    /**
     * @param $data
     * @return mixed
     * @desc  添加激活记录数据
     */
    public function add($data){

        $this->device_id   = $data['device_id'];
        $this->channel     = $data['channel_id'];
        $this->version     = $data['version_id'];
        $this->app_request = $data['from'];

        $this->save();

        return $this->id;
    }

    /**
     * @param $deviceId
     * @return mixed
     * @desc
     */
    public function get($deviceId){
        return self::where('device_id',$deviceId)
            ->count();
    }
}