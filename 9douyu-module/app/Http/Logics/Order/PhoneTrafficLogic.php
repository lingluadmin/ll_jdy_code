<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/9/19
 * Time: 14:59
 */

namespace App\Http\Logics\Order;


use App\Http\Dbs\Activity\LotteryRecordDb;
use App\Http\Dbs\Order\PhoneTrafficDb;
use App\Http\Logics\Logic;
use App\Http\Logics\SystemConfig\SystemConfigLogic;
use App\Http\Logics\Warning\WarningLogic;
use App\Http\Models\Activity\LotteryRecordModel;
use App\Http\Models\Common\ServiceApi\EmailModel;
use App\Http\Models\Common\ServiceApi\SmsModel;
use App\Http\Models\Common\ValidateModel;
use App\Http\Models\Order\PhoneTrafficModel;
use App\Tools\ToolStr;
use Config;
use Log;

class PhoneTrafficLogic extends Logic
{

    /**
     * @param $data
     * @desc 添加记录
     */
    public static function doAdd($data)
    {
        try{

            self::beginTransaction ();

            $orderId    =   ToolStr::getRandTicket ();

            PhoneTrafficModel::insertBefore ($orderId);

            ValidateModel::isCash($data['pack_price']);

            ValidateModel::isUserId ($data['user_id']) ;

            ValidateModel::isPhone ($data['phone']);

            PhoneTrafficModel::isInFlowType ($data['flow_type']);

            $sendRes    =   [] ;
            switch ($data['flow_type']) {
                case PhoneTrafficDb::ORDER_TYPE_FLOW :
                    $sendRes    =   SmsModel::sendFlow( $data['phone'], $data['pack_price'], $orderId,true) ;
                    break;
                case PhoneTrafficDb::ORDER_TYPE_CALLS:
                    $sendRes    =   SmsModel::sendCalls ($data['phone'], $data['pack_price'], $orderId, true) ;
                    break;
            }

            $data['status']     =   $sendRes['status'] == true ? PhoneTrafficDb::ORDER_STATUS_PENDING : PhoneTrafficDb::ORDER_STATUS_ERROR;
            $data['status_note']=   $sendRes['msg'] ;
            $data['order_id']   =   $orderId;
            PhoneTrafficModel::doInsert ($data);

            self::commit ();

        }catch ( \Exception $e ) {
            self::rollback ();
            $data['code']   =   $e->getCode ();
            $data['msg']    =   $e->getMessage ();

            Log::error(__METHOD__.'Error', $data);

            return self::callError ($e->getMessage ());
        }

        return self::callSuccess ();
    }
    /**
     * @param $data
     * @desc 添加记录
     */
    public static function doAddByLottery($data)
    {
        try{

            self::beginTransaction ();

            $orderId    =   ToolStr::getRandTicket ();

            PhoneTrafficModel::insertBefore ($orderId);

            ValidateModel::isCash($data['pack_price']);

            ValidateModel::isUserId ($data['user_id']) ;

            ValidateModel::isPhone ($data['phone']);

            PhoneTrafficModel::isInFlowType ($data['flow_type']);

            $sendRes    =   [] ;

            $recordModel    =   new LotteryRecordModel();

            $recordModel->doUpdate($data['record_id'] , ['status'=>LotteryRecordDb::LOTTERY_STATUS_SUCCESS,'user_name'=>trim ($data['user_name'])]) ;

            switch ($data['flow_type']) {
                case PhoneTrafficDb::ORDER_TYPE_FLOW :
                    $sendRes    =   SmsModel::sendFlow( $data['phone'], $data['pack_price'], $orderId) ;
                    break;
                case PhoneTrafficDb::ORDER_TYPE_CALLS:
                    $sendRes    =   SmsModel::sendCalls ($data['phone'], $data['pack_price'], $orderId) ;
                    break;
            }
            $data['status']     =   $sendRes['status'] == true ? PhoneTrafficDb::ORDER_STATUS_PENDING : PhoneTrafficDb::ORDER_STATUS_ERROR;
            $data['status_note']=   $sendRes['msg'] ;
            $data['order_id']   =   $orderId;
            PhoneTrafficModel::doInsert ($data);

            self::commit ();

        }catch ( \Exception $e ) {
            self::rollback ();
            $data['code']   =   $e->getCode ();
            $data['msg']    =   $e->getMessage ();

            Log::error(__METHOD__.'Error', $data);

            return self::callError ($e->getMessage ());
        }

        return self::callSuccess ();
    }
    /**
     * @param $data
     * @return array
     * @desc 更新记录
     */
    public static function doUpdate($data)
    {
        try{

            self::beginTransaction ();

            ValidateModel::isEmpty ($data);

            ValidateModel::isPhone ($data['phone']);

            $makeSign   =   self::setSign ($data) ;

            //ValidateModel::validSign($data['sign'], $makeSign) ;

            $orderInfo  =   PhoneTrafficModel::hasOrder ($data['orderId']);

            PhoneTrafficModel::validPhone ($data['phone'], $orderInfo['phone']);

            PhoneTrafficModel::doUpdate ($data['orderId'], self::doFormatUpdateData($data))  ;

            self::commit ();
        }catch ( \Exception $e ){
             self::rollback ();
             $data['code']  =   $e->getCode ();
             $data['msg']   =   $e->getMessage () ;
             Log::error(__METHOD__.'Error', $data);
             return self::callError ($e->getMessage ());
        }

        return self::callSuccess ();
    }

    /**
     * @param $data
     * @return string
     * @desc 生成sign
     */
    private static function setSign($data)
    {
        //todo sign 的生成方法
        // clientOrderId=201709121001&mobile=15701288783&callBackTime=2017-09-21 15:22:56&status=0&errorCode=&errorDesc=&intervalTime=4281&clientSubmitTime=2017-09-21 14:11:35&discount=9.10&costMoney=2.73&f4bc232a79c5d12d24394c6c56bcb935
        // clientOrderId=d58e9f3a71b34ca98234be189ccf87ac&mobile=13162762655&callBackTime=2016-05-13 10:21:09&status=3&errorCode=10010&errorDesc=欠费停机&intervalTime=30&clientSubmitTime=2016-05-13 10:20:39&discount=10.0&costMoney=0&MD5(pwd)
        $signString =   'clientOrderId=' . $data['orderId'];

        $signString .=  '&mobile=' . $data['phone'];

        $signString .=  '&callBackTime=' . $data['callBackTime'] ;

        $signString .=  '&status=' . $data['status'] ;

        if( !empty($data['errorCode']) ) {
            $signString .=  '&errorCode=' . $data['errorCode'] ;
        }
        if( !empty($data['errorDesc']) ) {
            $signString .=  '&errorDesc=' . $data['errorDesc'] ;
        }

        $signString .=  '&intervalTime=' . $data['intervalTime'] ;
        $signString .=  '&clientSubmitTime=' . $data['clientSubmitTime'] ;

        $signString .=  '&discount=' . $data['discount'] ;

        $signString .=  '&costMoney=' . $data['costMoney'] ;

        $signString .=  '&' . md5 (PhoneTrafficDb::PASS_WORD_ACCOUNT) ;
        $sign       =     md5 (urlencode($signString)) ;
        Log::info('dahan_sign', ['signString'=>$signString,'urlencode'=> urlencode($signString) ,'sign'=>$sign]);
        return $sign ;
    }

    /**
     * @param array $data
     * @return array
     * @desc 格式化更新数据
     */
    private static function doFormatUpdateData( $data = [])
    {
        $return =   [
            'status'        =>  $data['status'] ==PhoneTrafficDb::API_RESPONSE_SUCCESS ? PhoneTrafficDb::ORDER_STATUS_SUCCESS : PhoneTrafficDb::ORDER_STATUS_ERROR,
            'status_note'   =>  $data['status'] ==PhoneTrafficDb::API_RESPONSE_SUCCESS ? '充值成功' :  $data['errorDesc'] ,
            'handle_time'   =>  $data['callBackTime'] ,
        ];

        if( $data['status'] ==PhoneTrafficDb::API_RESPONSE_SUCCESS) {
            $return['discount']     =   $data['discount'];
            $return['cost_money']   =   $data['costMoney'];
        }

        return  $return;
    }

    public static function unConstruct($result = '')
    {
        if( empty($result) ) {
            return [];
        }
        $result =    json_decode($result , true);

        $result['phone']    =   isset($result['mobile']) ? $result['mobile'] :'';
        $result['orderId']  =   isset($result['clientOrderId'] )? $result['clientOrderId'] :'' ;

        return $result ;
    }

    /**
     * @param $data
     * @param $emails
     * @return bool
     * @desc 发送失败邮件
     */
    public static function doSendPhoneTrafficWarning($data)
    {
        $arr['subject'] = $data['subject'];
        $arr['title']   =  "【Warning】用户充值话费流量失败提示";
        $emails         = self::getEmail ();
        $emailModel     = new EmailModel();
        $return         = $emailModel->sendHtmlEmail($emails, $arr['title'], $arr['subject']);
        if( $return['status'] === false){
            Log::Error(__METHOD__.'error' , $arr);
        }
    }

    private static function getEmail()
    {
        $config =   SystemConfigLogic::getConfig ('WARNING_PHONE_TRAFFIC_EMAIL');
        $email  =   [];
        if( empty($config['RECEIVE']) ) {
            return Config::get('email.monitor.accessToken') ;
        }

        $receiveList = explode(',', $config['RECEIVE']);

        foreach ($receiveList as $value){

            $receiveList = explode('|', $value);

            $email[$receiveList[0]] = $receiveList[1];
        };

        return $email;
    }

}
