<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/6/18
 * Time: 下午3:01
 */

namespace App\Http\Logics\User\Setting;

use App\Http\Logics\Logic;

use App\Http\Models\Common\SmsModel as Sms;

use App\Lang\LangModel;

use App\Http\Models\User\UserRegisterModel;

use App\Http\Models\Common\CoreApi\UserModel as CoreApiUserModel;

use App\Http\Models\User\UserModel;
use App\Tools\ToolStr;


class CodeLogic extends Logic
{
    /**
     * 修改密码短信验证码发送
     * @param int $phone
     * @return array
     */
    public function sendPhoneModifySms($phone = null){
        try{
            // 验证手机号 有效性
            UserModel::validationPhone($phone);

            // 是否已经注册的用户
            $user = CoreApiUserModel::getBaseUserInfo($phone);

            if( !empty($user) ){
                return self::callError('手机号已注册');
            }
            // 验证码生成
            $code    = Sms::getRandCode();
            $message = LangModel::getLang('PHONE_VERIFY_CODE_NEW_PHONE');
            $message = sprintf($message, $code);

            // 发送短信验证码
            UserRegisterModel::sendModifyPhoneNumSms($phone, $message);

            // 设置短信验证码
            Sms::setPhoneVerifyCode($code, $phone);

        }catch (\Exception $e){

            $data['phone']   = $phone;
            $data['msg']     = $e->getMessage();
            $data['code']    = $e->getCode();

            Log::error(__METHOD__ . 'Error', $data);

            return self::callError($e->getMessage());
        }
        return self::callSuccess([],sprintf(LangModel::getLang('PHONE_VERIFY_CODE_RECEIVED_TIPS'), ToolStr::hidePhone($phone,3,4)));
    }

    /**
     * @desc 发送验证码用于修改邮箱，紧急联系人灯验证
     * @param $phone
     * @return array
     */
    public function sendSmsForVerify($phone = null)
    {
        try {
            // 验证手机号 有效性
            UserModel::validationPhone($phone);

            // 是否已经注册的用户
            $user = CoreApiUserModel::getBaseUserInfo($phone);
            if (empty($user) || $user['status'] != 200){
                return self::callError('用户未注册');
            }
            // 验证码生成
            $code    = Sms::getRandCode();
            $message = LangModel::getLang('PHONE_VERIFY_CODE_COMMON');
            $message = sprintf($message, $code);

            // 发送短信验证码
            UserRegisterModel::sendModifyPhoneNumSms($phone, $message);

            //设置短信验证码
            Sms::setPhoneVerifyCode($code, $phone);

        }catch(\Exception $e){

            $data['phone']   = $phone;
            $data['msg']     = $e->getMessage();
            $data['code']    = $e->getCode();

            Log::error(__METHOD__ . 'Error', $data);

            return self::callError($e->getMessage());
        }
        return self::callSuccess([],sprintf(LangModel::getLang('PHONE_VERIFY_CODE_RECEIVED_TIPS'), $phone));
    }
}
