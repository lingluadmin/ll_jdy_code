<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/9/19
 * Time: 11:49
 */

namespace App\Http\Dbs\Order;


use App\Http\Dbs\JdyDb;

class PhoneTrafficDb extends JdyDb
{
    protected $table    =   'phone_traffic';

    //200-成功，300-处理中，401-充值超时,500-失败
    const
        ORDER_STATUS_PENDING    =   300,  //处理中
        ORDER_STATUS_SUCCESS    =   200,  //充值成功
        ORDER_STATUS_OVERTIME   =   401,  //充值超时
        ORDER_STATUS_ERROR      =   500,  //失败

        //快捷对账的通道标示
        ORDER_TYPE_FLOW         =   1,    //流量订单
        ORDER_TYPE_CALLS        =   2,    //话费订单
        PASS_WORD_ACCOUNT       =   'Jdy201709' ,

        API_RESPONSE_SUCCESS    =   0,  //充值成功
        API_RESPONSE_FAILED     =   2,  //充值失败
        API_RESPONSE_ERROR      =   3,  //充值失败

        //临时定义可用的流量包的大小
        PHONE_FLOW_MB_10        =   10, //10mb
        PHONE_FLOW_MB_30        =   30, //20mb
        PHONE_FLOW_MB_50        =   50, //50Mb
        PHONE_FLOW_MB_100       =   100,//100mb
        PHONE_FLOW_MB_200       =   200,//200mb
        PHONE_FLOW_MB_300       =   300,//300mb
        PHONE_FLOW_MB_500       =   500,//500mb

        SYSTEM_TRAFFIC_SOURCE   =0 ,



        END =   true;

    public  function doAdd($data = [])
    {
        $filterAttrValue =   self::doFilterAttrValue($data) ;

        $model = new static( $filterAttrValue, array_keys($filterAttrValue) );

        return $model->save();
    }

    /**
    * @param array $data
    * @return array
    */
    private static function doFilterAttrValue($data = [])
    {
        return [
            'order_id'  =>  $data['order_id'] ,
            'user_id'   =>  $data['user_id'] ,
            'pack_price'=>  $data['pack_price'] ,
            'type'      =>  isset($data['type']) && !empty($data['type']) ? $data['type'] : self::ORDER_TYPE_FLOW ,
            'phone'     =>  isset($data['phone']) && !empty($data['phone']) ? $data['phone'] : '' ,
            'status'    =>  isset($data['status']) ? !$data['status'] : self::ORDER_STATUS_PENDING ,
            'note'      =>  isset($data['note']) ? $data['note'] : '流量充值',
            'status_note'=> isset($data['status_note']) ? $data['status_note'] : '',
            'source'    =>  isset($data['source']) && !empty($data['source']) ? $data['source'] : self::SYSTEM_TRAFFIC_SOURCE
        ];
    }

    /**
     * @param $orderId
     * @param $status
     * @param $statusNote
     * @return mixed
     * @desc 更新状态
     */
    public function doUpdate($orderId,$updateData)
    {
        return $this->where('order_id',$orderId)
                    ->update($updateData);
    }

    /**
     * @param $orderId
     * @return array
     * @desc 通过订单号获取订单信息
     */
    public function getByOrderId( $orderId )
    {
        return $this->dbToArray (
           $this->where('order_id' ,$orderId)->first()
        );
    }

    /**
     * @param $userId
     * @param $startTime
     * @param $endTime
     * @param int $source
     * @return mixed
     * @desc 在指定时间内活的移动充值流量的记录
     */
    public function getPhoneTrafficList($userId, $startTime, $endTime, $source = 0)
    {
        $getObj     =   $this->where('user_id', $userId)
                         ->where('created_at','>=', $startTime)
                         ->where('created_at','<=', $endTime);

        if( !empty($source) ) {
            $getObj =   $getObj->where('source', $source);
        }

        return $getObj->get()->toArray();
    }
}