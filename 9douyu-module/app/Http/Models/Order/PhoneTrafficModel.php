<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/9/19
 * Time: 14:09
 */

namespace App\Http\Models\Order;


use App\Http\Dbs\Order\PhoneTrafficDb;
use App\Http\Models\Common\ExceptionCodeModel;
use App\Http\Models\Model;
use App\Lang\LangModel;

class PhoneTrafficModel extends Model
{
    public static $codeArr            = [
        'insert'    =>  1,
        'update'    =>  2,
        'repeat'    =>  3,
        'noneOrder' =>  4,
        'notType'   =>  5,
        'notLocal'  =>  6,

    ];

    public static $expNameSpace       = ExceptionCodeModel::EXP_MODEL_ORDER_PHONE_TRAFFIC;

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     * @desc 记录数据
     */
    public static function doInsert( $data )
    {
        $db =   new PhoneTrafficDb();

        $return =   $db->doAdd($data);

        if( empty($return) ) {
            throw new \Exception(LangModel::getLang('PHONE_TRAFFIC_ORDER_ADD_FAILED') , self::getFinalCode('insert'));
        }

        return $return ;
    }

    /**
     * @param $orderId
     * @param $status
     * @param string $statusNote
     * @return mixed
     * @throws \Exception
     * @desc 更新充值的状态，主要是通过三方接口进行回调进行订单处理
     */
    public static function doUpdate($orderId,$data)
    {
        $db     =   new PhoneTrafficDb();

        $return =   $db->doUpdate($orderId ,$data);

        if( empty($return) ) {
            throw new \Exception(LangModel::getLang('PHONE_TRAFFIC_ORDER_EDIT_FAILED') , self::getFinalCode('update'));
        }

        return $return ;
    }

    /**
     * @param $orderId
     * @return bool
     * @throws \Exception
     * @desc 验证订单号是否存在
     */
    public static function insertBefore($orderId)
    {
        if( self::getByOrderId ($orderId) ) {
            throw new \Exception(LangModel::getLang('PHONE_TRAFFIC_ORDER_NOT_UNIQUE') , self::getFinalCode('repeat'));
        }
        return true ;
    }

    /**
     * @param $orderId
     * @return array
     * @throws \Exception
     * @desc 验证订单是否存在
     */
    public static function hasOrder($orderId)
    {
        $orderInfo  =   self::getByOrderId ($orderId);

        if( !$orderInfo ) {
            throw new \Exception(LangModel::getLang('PHONE_TRAFFIC_ORDER_NOT_HAVE') , self::getFinalCode('noneOrder'));
        }

        return $orderInfo ;
    }

    /**
     * @param $orderId
     * @return array
     * @desc 通过订单号获取订单信息
     */
    public static function getByOrderId($orderId)
    {
        $db     =   new PhoneTrafficDb();

        return  $db->getByOrderId($orderId);
    }

    /**
     * @param $type
     * @return mixed
     * @throws \Exception
     * @desc 验证类型
     */
    public static function isInFlowType($type)
    {
        $flowTypes  =   [
            PhoneTrafficDb::ORDER_TYPE_CALLS ,PhoneTrafficDb::ORDER_TYPE_FLOW
        ];

        if( !in_array ($type ,$flowTypes) ) {
            throw new \Exception(LangModel::getLang('PHONE_TRAFFIC_ORDER_NOT_TYPE') , self::getFinalCode('notType'));
        }

        return $type ;
    }

    /**
     * @param $recPhone
     * @param $localPhone
     * @return bool
     * @throws \Exception
     * @desc 验证手机号码是否一致
     */
    public static function validPhone($recPhone , $localPhone)
    {
        if( $recPhone != $localPhone) {
            throw new \Exception(LangModel::getLang('PHONE_TRAFFIC_ORDER_DIFF_PHONE') , self::getFinalCode('notLocal'));
        }
        return  true;
    }

    /**
     * @return array
     * @desc 充值的流量包 先定义这些 根据实际的需求 后续进行增加
     */
    public static function getPhoneFlow()
    {
        $phoneFlowArr   =   [
            PhoneTrafficDb::PHONE_FLOW_MB_10    =>   '10MB', //10mb
            PhoneTrafficDb::PHONE_FLOW_MB_30    =>   '30MB', //20mb
            PhoneTrafficDb::PHONE_FLOW_MB_50    =>   '50MB', //50Mb
            PhoneTrafficDb::PHONE_FLOW_MB_100   =>   '100MB',//100mb
            PhoneTrafficDb::PHONE_FLOW_MB_200   =>   '200MB',//200mb
            PhoneTrafficDb::PHONE_FLOW_MB_300   =>   '300MB',//300MB
            PhoneTrafficDb::PHONE_FLOW_MB_500   =>   '500MB',//500MB
        ];

        return $phoneFlowArr ;
    }

    /**
     * @return array
     * @desc 充值的话费包 develop'time is very fuck sort , So phone calls used empty !
     */
    public static function getPhoneCalls()
    {
        return [];
    }

    /**
     * @param $userId
     * @param $startTime
     * @param $endTime
     * @param int $source
     * @return mixed
     * @desc 在指定时间内活的移动充值流量的记录
     */
    public static function getPhoneTrafficList($userId, $startTime, $endTime, $source = 0)
    {
        $dbObj      =   new PhoneTrafficDb();

        return  $dbObj->getPhoneTrafficList ($userId, $startTime, $endTime, $source );
    }
}