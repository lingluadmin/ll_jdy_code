<?php
/**
 * Created by PhpStorm.
 * User: jinzhuotao
 * Date: 2017/2/22
 * Time: 下午6:49
 */

namespace Tests\Http\Logics\Device;

use App\Http\Logics\Device\DeviceLogic;

class ActivateTest extends \TestCase
{

    public function activateData(){

        return [
            [
                'is' => true,
                'data' => [
                    "device_id"     => 354360070138630,
                    "channel_id"    => 'TEST10001',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '成功'
            ],
            [
                'is' => true,
                'data' => [
                    "device_id"     => '354360070138631',
                    "channel_id"    => 'TEST10002',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '成功'
            ],
            [
                'is' => true,
                'data' => [
                    "device_id"     => '9904FF22-C0DB-4CE7-AC19-8F755D7915BB',
                    "channel_id"    => 'TEST10003',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '成功'
            ],
            [
                'is' => true,
                'data' => [
                    "device_id"     => '9f16aac0-dad2-4996-b61d-54f271eaf841R',
                    "channel_id"    => 'TEST10004',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '成功'
            ],
            [
                'is' => true,
                'data' => [
                    "device_id"     => '02:00:00:00:00:02',
                    "channel_id"    => 'TEST10005',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '成功'
            ],
            [
                'is' => false,
                'data' => [
                    "device_id"     => '9F16AAC0-DAD2-4996-B61D-54F271EAF841R',
                    "channel_id"    => 'TEST10006',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '设备ID已存在'
            ],
            [
                'is' => false,
                'data' => [
                    "channel_id"    => 'TEST10007',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '缺少设备ID'
            ],
            [
                'is' => false,
                'data' => [
                    "device_id"     => '',
                    "channel_id"    => 'TEST10008',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '缺少设备ID'
            ],
            [
                'is' => false,
                'data' => [
                    "device_id"     => null,
                    "channel_id"    => 'TEST10009',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '缺少设备ID'
            ],
            [
                'is' => false,
                'data' => [
                    "device_id"     => '354360070138630',
                    "channel_id"    => 'TEST10010',
                    "version_id"    => '4.2.3',
                ],
                'msg' => '设备ID已存在'
            ],
        ];

    }

    /**
     * @param $is
     * @param $data
     * @param $msg
     * @dataProvider activateData
     */
    public function testActivate($is, $data, $msg){
        $logic = new DeviceLogic();
        $result = $logic -> addActivateRecord($data);

        $this->assertEquals($is,$result['status']);
        $this->assertEquals($msg,$result['msg']);

    }

}