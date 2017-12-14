<?php

namespace App\Listeners\User\RegisterSuccess;


use App\Http\Logics\SystemConfig\SystemConfigLogic;
use App\Events\User\RegisterSuccessEvent;
use App\Http\Models\Common\HttpQuery;
use App\Http\Logics\Logic;
use Log;
use Config;

/**
 * 用户注册成功-给用户发送短信
 * Class SendSuccessSms
 * @package App\Listeners\User\RegisterSuccess
 */
class SendSuccessSms
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * 用户注册成功-给用户发送短信
     * Handle the event.
     *
     * @param  RegisterSuccessEvent  $event
     * @return void
     */
    public function handle(RegisterSuccessEvent $event)
    {
        $phone = $event->getUserPhone();

        $smsContent = SystemConfigLogic::getConfig('REGISTER_SUCCESS_SMS_CONTENT');

        $msg = !empty($smsContent) ? $smsContent : '';

        $postData = [
            'phone' => $phone,
            'msg'   => $msg
        ];

        \Log::info('RegisterSuccessSmsSendLoading', $postData);

        if(!empty($msg)){

            $url   = Config::get('serviceApi.moduleSms.notice');

            $return = HttpQuery::serverPost($url, $postData);

            if( $return['code'] == Logic::CODE_ERROR ){

                \Log::Error(__CLASS__.__METHOD__.'Error', $postData);

            }

            \Log::info('RegisterSuccessSmsSend', $postData);
        }

    }
}
