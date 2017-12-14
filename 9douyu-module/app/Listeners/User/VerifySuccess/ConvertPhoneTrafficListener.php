<?php

/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/9/20
 * Time: 11:26
 */
namespace App\Listeners\User\VerifySuccess;

use App\Events\User\VerifySuccessEvent;
use App\Http\Dbs\Activity\LotteryConfigDb;
use App\Http\Dbs\Activity\LotteryRecordDb;
use App\Http\Dbs\Order\PhoneTrafficDb;
use App\Http\Logics\Activity\IphoneActivityLogic;
use App\Http\Logics\Activity\LotteryConfigLogic;
use App\Http\Logics\Logic;
use App\Http\Logics\Order\PhoneTrafficLogic;
use App\Http\Models\Common\ServiceApi\EmailModel;
use App\Http\Models\Order\PhoneTrafficModel;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConvertPhoneTrafficListener  implements ShouldQueue
{
    const MAX_EXE_TIMES = 3;//最大调用次数

    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  VerifySuccessEvent  $event
     * @return void
     */
    public function handle(VerifySuccessEvent $event){

        $attempts           = $this->attempts();    //请求的次数

        $userInfo   =   $event->getUserInfo();

        if($attempts >= self::MAX_EXE_TIMES){

            $this->delete();
        } else {

            $logic      =   new IphoneActivityLogic();

            $sendInfo    =   $this->validLotteryInIphone8 ($userInfo,$logic) ;

            if( $sendInfo['status'] == true ) {

                $sendInfo=$sendInfo['data'];

                $return =   $this->doSendPhoneTraffic($sendInfo,$userInfo) ;

                if($return['status'] == false){
                    \Log::error(__METHOD__.'Error',['data'=>'流量充值失败','msg' => $return]);

                    // 延迟通知【连续通知1次 和 2次 然后 第3次延迟2分钟、第4次延迟3分钟、依次类推】
                    if ($attempts >= 1 && $attempts <= self::MAX_EXE_TIMES) {

                        $delay = $attempts * 5;//5秒钟

                        $this->release($delay);
                    }
                    $this->delete();//删除任务 已经成功
                }

            } else {

                \Log::info('verify_exchange_error' , $sendInfo) ;
            }
        }

    }

    /**
     * @desc 验证活动的有效性
     */
    private function validLotteryInIphone8($userInfo, IphoneActivityLogic $logic)
    {
        $activity   =   $logic->validActivityStatus ($userInfo['id']);

        if( $activity['status']  == false) {
            \Log::info(__METHOD__.'error' ,$activity);
            return $activity ;
        }

        return  $this->validUserLotteryStatus ($userInfo['id'], $logic);
    }

    /**
     * @return array|int|mixed
     * @desc 验证用户是否可以兑奖
     */
    private function validUserLotteryStatus($userId, IphoneActivityLogic $logic)
    {
         $traffic   =   $logic->getPhoneTrafficExchange ($userId);
         if( $traffic['status'] == false ){
             \Log::info(__METHOD__.'traffic_error' ,$traffic);
             return $traffic;
         }
         $record    =   $logic->getUserOneLotteryInfo($userId);

         if( empty($record) || $record['status'] == LotteryRecordDb::LOTTERY_STATUS_SUCCESS ){
             \Log::info(__METHOD__.'lottery_error' ,$traffic);
             return Logic::callError ();
         }
         return Logic::callSuccess ($record);
    }

    /**
     * @param $data
     * @param $user
     * @desc 执行认证发奖
     */
    private function doSendPhoneTraffic($data,$user)
    {
        $lotteryLogic   =   new LotteryConfigLogic();

        $phoneTraffic   =   $lotteryLogic->getById ($data['prizes_id']);

        $phoneFlow  =   PhoneTrafficModel::getPhoneFlow();

        if( !empty($phoneTraffic) && isset($phoneFlow[$phoneTraffic['foreign_id']]) && ($phoneTraffic['type'] == LotteryConfigDb::LOTTERY_TYPE_PHONE_FLOW || $phoneTraffic['type']== LotteryConfigDb::LOTTERY_TYPE_PHONE_CALLS) ) {

            $flowType=   PhoneTrafficDb::ORDER_TYPE_FLOW;

            if($phoneTraffic['type'] == LotteryConfigDb::LOTTERY_TYPE_PHONE_CALLS) {
                $flowType=   PhoneTrafficDb::ORDER_TYPE_CALLS;
            }

            $formatData =   [
                'pack_price'=>  $phoneTraffic['foreign_id'] ,
                'user_id'   =>  $user['id'],
                'phone'     =>  $user['phone'],
                'flow_type' =>  $flowType,
                'record_id' =>  $data['id'],
                'user_name' =>  isset($user['real_name']) ? $user['real_name'] : '',
            ];
            $return =   PhoneTrafficLogic::doAddByLottery ($formatData);

            if( $return['status'] == false ) {

                $data['subject'] = json_encode ([$return,$formatData]);

                PhoneTrafficLogic::doSendPhoneTrafficWarning ($data);

                \Log::info(__METHOD__.'error',[$return , $formatData]) ;
            }
            return $return ;
        }

        return  Logic::callSuccess ();
    }
}