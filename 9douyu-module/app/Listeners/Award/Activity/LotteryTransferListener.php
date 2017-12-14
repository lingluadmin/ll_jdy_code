<?php
/**
 * Created by PhpStorm.
 * User: scofie <wu.changming@9douyu.com>
 * Date: 16/9/27
 * Time: 下午5:41
 */

namespace App\Listeners\Award\Activity;


use App\Events\Activity\LotteryEvent;
use App\Http\Dbs\Activity\LotteryConfigDb;
use App\Http\Dbs\Order\PhoneTrafficDb;
use App\Http\Logics\Activity\ActivityConfigLogic;
use App\Http\Logics\Activity\LotteryConfigLogic;
use App\Http\Logics\Logic;
use App\Http\Logics\Order\PhoneTrafficLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Models\Activity\ActivityFundHistoryModel;
use App\Http\Models\Common\HttpQuery;
use App\Http\Models\Common\ServiceApi\SmsModel;
use App\Lang\LangModel;
use App\Tools\ToolTime;
use Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LotteryTransferListener implements ShouldQueue
{

    const MAX_EXE_TIMES = 3;//最大调用次数

    use InteractsWithQueue;

    public function handle( LotteryEvent $event)
    {
        $attempts           = $this->attempts();    //请求的次数

        if($attempts >= self::MAX_EXE_TIMES){

            $this->delete();
        } else {
            $lotteryId  =   $event->data['prizes_id'];

            $phone      =   $event->data['phone'];

            $activityId =   $event->data['activity_id'];

            $userId     =   $event->data['user_id'];

            $logic      =   new LotteryConfigLogic();

            $lottery    =   $logic->getById($lotteryId);

            $actNote    =   ActivityFundHistoryModel::getActivityEventNote ();

            $note       =   isset($actNote[$activityId]) ? $actNote[$activityId] : '抽奖活动';

            $note       =   strstr ($note , '活动') ? $note : $note . '活动' ;

            $return     =   $this->doSendLottery ($userId, $phone, $note ,$lottery);

            if($return['status'] != true){

                \Log::error(__METHOD__.'Error',$return);

                // 延迟通知【连续通知1次 和 2次 然后 第3次延迟2分钟、第4次延迟3分钟、依次类推】
                if ($attempts >= 1 && $attempts <= self::MAX_EXE_TIMES) {

                    $delay = $attempts * 5;//5秒钟

                    $this->release($delay);
                }
                $this->delete();//删除任务 已经成功
            }
            if( $return['status'] == true ) {
                $this->doSendLotteryMsg ($phone, $note, $lottery) ;
            }
        }

    }

    /**
     * @param $userId
     * @param $phone
     * @param $note
     * @param array $lottery
     * @return array
     * @desc 发送奖品的过程
     */
    private function doSendLottery($userId, $phone , $note , $lottery = array())
    {
        $cash           =   $lottery['foreign_id'];

        $lotteryType    =   $lottery['type'];

        $return         =   [
            'status'    =>  true,
            'msg'       =>  '',
        ];

        if( $lottery['real_time'] != LotteryConfigDb::LOTTERY_REAL_TIME_ON) {
            return $return ;
        }
        switch ($lotteryType){
            case LotteryConfigDb::LOTTERY_TYPE_CASH:
                $return     =   $this->doSendLotteryCash($phone, $cash, $note);

                break;
            case LotteryConfigDb::LOTTERY_TYPE_PHONE_FLOW:
                $return     =   $this->doSendPhoneTraffic($userId, $phone, $cash ,PhoneTrafficDb::ORDER_TYPE_FLOW);
                break;
            case LotteryConfigDb::LOTTERY_TYPE_PHONE_CALLS:
                $return     =   $this->doSendPhoneTraffic($userId, $phone, $cash ,PhoneTrafficDb::ORDER_TYPE_FLOW);
                break;
        }

        if( $return['status'] != true ) {

            \Log::info('doSenLotteryInfo', $return);
        }

        return $return ;
    }

    /**
     * @param $phone
     * @param $note
     * @param $lotteryCash
     * @return array
     * @desc 发钱
     */
    private function doSendLotteryCash( $phone, $cash, $note='' )
    {
        $userLogic      =   new UserLogic();

        $code           =   $confirmCode    =   md5 (ToolTime::dbDate ());

        return  $userLogic->doChangeBalance ($phone, $cash, $note, $code, $confirmCode, 1);
    }

    /**
     * @param $userId
     * @param $phone
     * @param $cash
     * @param $flowType
     * @return array
     * @desc 移动话费流量
     */
    private function doSendPhoneTraffic($userId, $phone, $cash ,$flowType)
    {
        $logic      =   new PhoneTrafficLogic();

        return $logic->doAdd(['user_id' =>$userId, 'phone'=>$phone, 'pack_price'=> $cash, 'flow_type'=>$flowType]);
    }

    /**
     * @param $phone
     * @param $activityId
     * @param $lottery
     * @desc 发送中奖短信
     */
    private function doSendLotteryMsg($phone, $note, $lottery)
    {
        $templates  =   ActivityConfigLogic::getConfig ('LOTTERY_SEND_TEMPLATE' );

        switch ($lottery['type']){

            case LotteryConfigDb::LOTTERY_TYPE_CURRENT:
                $template=  isset($templates['LOTTERY_TYPE_CURRENT'])&& !empty($templates['LOTTERY_TYPE_CURRENT']) ? $templates['LOTTERY_TYPE_CURRENT'] :LangModel::getLang('LOTTERY_ENVELOPE_MESSAGE');
                $msg     =  sprintf($template, $note, $lottery['name']);

                break;
            case LotteryConfigDb::LOTTERY_TYPE_ENTITY:
                $template=  isset($templates['LOTTERY_ENTITY_MESSAGE'])&& !empty($templates['LOTTERY_ENTITY_MESSAGE']) ? $templates['LOTTERY_ENTITY_MESSAGE'] :LangModel::getLang('LOTTERY_ENTITY_MESSAGE');
                $msg     =  sprintf($template, $note, $lottery['name']);

                break;
            case LotteryConfigDb::LOTTERY_TYPE_ENVELOPE:
                $template=  isset($templates['LOTTERY_TYPE_ENVELOPE'])&& !empty($templates['LOTTERY_TYPE_ENVELOPE']) ? $templates['LOTTERY_TYPE_ENVELOPE'] :LangModel::getLang('LOTTERY_ENVELOPE_MESSAGE');
                $msg     =  sprintf($template, $note, $lottery['name']);

                break;
            case LotteryConfigDb::LOTTERY_TYPE_TICKET:
                $template=  isset($templates['LOTTERY_TYPE_TICKET'])&& !empty($templates['LOTTERY_TYPE_TICKET']) ? $templates['LOTTERY_TYPE_TICKET'] :LangModel::getLang('LOTTERY_ENVELOPE_MESSAGE');
                $msg     =  sprintf($template, $note, $lottery['name']);


                break;
            case LotteryConfigDb::LOTTERY_TYPE_PHONE_FLOW:
                if( $lottery['real_time'] == LotteryConfigDb::LOTTERY_REAL_TIME_ON){
                    $template=  isset($templates['PHONE_FLOW_REAL_TIME'])&& !empty($templates['PHONE_FLOW_REAL_TIME']) ? $templates['PHONE_FLOW_REAL_TIME'] :LangModel::getLang('PHONE_FLOW_REAL_TIME_MESSAGE');
                }else{
                    $template=  isset($templates['LOTTERY_TYPE_PHONE_FLOW'])&& !empty($templates['LOTTERY_TYPE_PHONE_FLOW']) ? $templates['LOTTERY_TYPE_PHONE_FLOW'] :LangModel::getLang('LOTTERY_PHONE_FLOW_MESSAGE');
                }

                $msg     =  sprintf($template, $note, $lottery['name']);
                break;
            case LotteryConfigDb::LOTTERY_TYPE_PHONE_CALLS:
                if( $lottery['real_time'] == LotteryConfigDb::LOTTERY_REAL_TIME_ON) {
                    $template = isset($templates['PHONE_CALLS_REAL_TIME']) && !empty($templates['PHONE_CALLS_REAL_TIME']) ? $templates['PHONE_CALLS_REAL_TIME'] : LangModel::getLang ('PHONE_CALLS_REAL_TIME_MESSAGE');
                }else{
                    $template = isset($templates['LOTTERY_TYPE_PHONE_CALLS']) && !empty($templates['LOTTERY_TYPE_PHONE_CALLS']) ? $templates['LOTTERY_TYPE_PHONE_CALLS'] : LangModel::getLang ('LOTTERY_PHONE_CALLS_MESSAGE');
                }
                $msg     =  sprintf($template, $note, $lottery['name']);
                break;
            case LotteryConfigDb::LOTTERY_TYPE_CASH:
                if( $lottery['real_time'] == LotteryConfigDb::LOTTERY_REAL_TIME_ON) {
                    $template = isset($templates['LOTTERY_CASH_REAL_TIME']) && !empty($templates['LOTTERY_CASH_REAL_TIME']) ? $templates['LOTTERY_CASH_REAL_TIME'] : LangModel::getLang ('LOTTERY_CASH_REAL_TIME_MESSAGE');
                }else{
                    $template = isset($templates['LOTTERY_TYPE_CASH']) && !empty($templates['LOTTERY_TYPE_CASH']) ? $templates['LOTTERY_TYPE_CASH'] : LangModel::getLang ('LOTTERY_TYPE_CASH_MESSAGE');
                }
                $msg     =  sprintf($template, $note, $lottery['name']);

                break;
            default:
                $msg = '';
                break;
        }

        if( $msg && $lottery['type'] !=LotteryConfigDb::LOTTERY_TYPE_EMPTY ) {

            $postData   = [
                'phone' => $phone,
                'msg'   => $msg
            ];
            if( env ('APP_ENV') != 'production'){
                \Log::info('doSenLotteryInfo', $postData);

            } else{
                $return     =    SmsModel::sendNotice($phone,$msg);

                if( $return['code'] == Logic::CODE_ERROR ){
                    Log::info('sendLotterySuccessMsgError',$postData);

                }
            }
        }
    }
}