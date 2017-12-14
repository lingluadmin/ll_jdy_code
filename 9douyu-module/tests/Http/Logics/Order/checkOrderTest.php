<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/11/17
 * Time: 11:33
 */

namespace Tests\Http\Logics\Order;


use App\Http\Logics\Recharge\CheckOrderLogic;

class checkOrderTest extends \TestCase
{
    public function checkOrderIdData(){

        return [
            //order_id以jdy_开头
            [
                'result'      => true,
                'order_id'    => 'JDY_201611280906461418',
            ],
            //order_id纯数字
            [
                'result'      => true,
                'order_id'    => '201611280906461418',
            ],
            //order_id以jdy_开头，长度不是22
            [
                'result'      => false,
                'order_id'    => 'JDY_20161128090646141',
            ],
            //order_id以jdy_开头，长度是22,数字长度不够18
            [
                'result'      => false,
                'order_id'    => 'JDY_2016112809064aa41',
            ],
            //order_id纯数字，长度不是18
            [
                'result'      => false,
                'order_id'    => '2014062317501766021',
            ],
            //order_id纯数字，长度不是18
            [
                'result'      => false,
                'order_id'    => '20140623175017660',
            ],
            //order_id 长度18，不是纯数字
            [
                'result'      => false,
                'order_id'    => '201406231750176aa2',
            ],
        ];
    }

    /**
     * @param $is
     * @param $data
     * @dataProvider checkOrderIdData
     */
    public function testDoCheckOrderId($returnResult, $orderId){


        $logic  =   new CheckOrderLogic();

        $result =   $logic->checkOrderId ($orderId);

        $this->assertEquals($returnResult, $result);

    }
}