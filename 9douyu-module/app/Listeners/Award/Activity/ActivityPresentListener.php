<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 8/29/17
 * Time: 6:39 PM
 */

namespace App\Listeners\Award\Activity;


use App\Events\CommonEvent;
use App\Http\Dbs\Notice\NoticeDb;
use App\Http\Logics\Activity\ActivityPresentLogic;
use App\Http\Logics\Logic;
use App\Http\Logics\Notice\NoticeLogic;
use App\Http\Models\Common\ServiceApi\SmsModel;
use Log;

class ActivityPresentListener
{
    public function handle( CommonEvent $event)
    {
        $data       =   $event->getDataByKey('activity');

        Log::info('send_present_param', $data) ;
        
        if( ActivityPresentLogic::isAuto () == true){
            $validTime  =   ActivityPresentLogic::validActivityTime ();

            $return['status'] =false ;

            if($validTime == true ) {

                $return =   ActivityPresentLogic::doImplementSendPresent($data) ;

            } else {

                Log::error('send_present_error', [ $data ,$return] ) ;
            }

            if( $return['status'] == true ) {

                $this->doSendNotice ($return['user_id']);
                $this->doSendPhoneMessage($return['phone']);
            }
        }

    }

    /**
     * @param $phone
     * @desc phone sms
     */
    protected function doSendPhoneMessage($phone)
    {
        $message     =   ActivityPresentLogic::getPhoneMessage ();

        $postData   = [
            'phone' => $phone,
            'msg'   => $message
        ];

        $return     =    SmsModel::sendNotice($phone,$message);

        if( $return['code'] == Logic::CODE_ERROR ){

            Log::info('sendPresentPhoneMsgError',$postData);
        }

    }

    /**
     * @param $userId
     * @desc send  notice
     */
    protected function doSendNotice($userId)
    {
        $message     =   ActivityPresentLogic::getPhoneMessage ();

        $postData   = [
            'user_id'   => $userId,
            'msg'       => $message
        ];

        $return     =    NoticeLogic::sendNoticeByType (NoticeDb::TYPE_ACTIVITY_CASH, $userId, $message, NoticeDb::TYPE_SYSTEM) ;

        if( $return['code'] == Logic::CODE_ERROR ){

            Log::info('sendNoticeMsgError',$postData);
        }
    }
}