<?php

/**
 * Created by PhpStorm.
 * User: jinzhuotao
 * Date: 2017/11/21
 * Time: 下午6:00
 */

namespace App\Http\Controllers\AppApi\V4_2_3\Device;

use App\Http\Controllers\AppApi\AppController;
use App\Http\Logics\Device\DeviceLogic;
use Illuminate\Http\Request;

class DeviceController extends AppController
{

    /**
     * @path  /app_activate
     * @param Request $request
     * @param device_id      设备唯一码
     * @param channel_id     渠道id
     * @param version_id     版本号
     * @return array
     * @desc  app首次登陆（激活）,记录设备号以及来源渠道，激活时间接口
     */
    public function appActivate(Request $request){

        $data           = $request->all();
        $data['from']   = $this->client;

        $logic = new DeviceLogic();
        $result = $logic->addActivateRecord($data);

        return $this->returnJsonData($result);
    }

}