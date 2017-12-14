<?php
/**
 * Created by Vim.
 * User: lgh-dev
 * Date: 17/8/18
 * Time: Am 11:01
 * Desc: 邮件设置相关逻辑
 */

namespace App\Http\Logics\User\Setting;

use App\Http\Logics\Logic;
use App\Lang\LangModel;
use App\Http\Models\Common\ValidateModel;
use App\Tools\ToolStr;
use App\Http\Models\Common\ServiceApi\EmailModel;


class EmailLogic extends Logic
{

    const ACTIVE_KEY_CACHE_TIME = 60*12,//邮件激活码缓存时间
        END = true;
    /**
     * @desc 发送激活邮件逻辑
     * @param $userId int
     * @param $email str
     * @param $url str
     * @param $other str
     * @return array
     */
    public function sendActiveEmail($userId, $email, $url, $other)
    {
        try{
            ValidateModel::isEmail($email);
            //生成随机激活码
            $activeCode = ToolStr::getRandStr(32);

            //设置用户激活邮箱邮件
            \Cache::put('USER_ACTIVE_CODE_'.$userId.'_'.$email, $activeCode, self::ACTIVE_KEY_CACHE_TIME);

            $url = $url.'?userId='.$userId.'&activation_key='.$activeCode.'&email='.$email.'&activeType='.$other;

            $subject = '用户设置常用邮箱激活验证';
            $to = [$email => $email];
            $body = sprintf(LangModel::getLang('EMAIL_ACTIVE_CONTENT'), $url, $url);

            $emailModel = new EmailModel();

            $result = $emailModel->sendHtmlEmail($to, $subject, $body);

            if ($result['status'] == false){
                \Log::error('用户设置常用邮箱的激活邮件发送失败'.json_encode($result));
                return self::callError($result['msg']);
            }
        }catch(\Exception $e){
            $data['phone']   = $phone;
            $data['msg']     = $e->getMessage();
            $data['code']    = $e->getCode();

            Log::error(__METHOD__ . 'Error', $data);

            return self::callError($e->getMessage());
        }
        \Log::info('用户设置常用邮箱的激活邮件发送成功');
        return self::callSuccess($result, '请登录您的邮箱激活，有效期12小时。');
    }

    /**
     * @desc 检测邮件激活的激活码等相关信息
     * @param $userId int
     * @param $email
     * $return array
     */
    public function checkActiveEmail($userId, $email, $activationKey)
    {
        $activeCode = \Cache::get('USER_ACTIVE_CODE_'.$userId.'_'.$email);

        if (empty($userId) || empty($email)){
            return self::callError('信息不完整');
        }

        if (empty($activationKey) || empty($activeCode) || ($activeCode!=$activationKey)){
            return self::callError('邮件激活码已经失效或激活码不对');
        }

        \Cache::forget('USER_ACTIVE_CODE_'.$userId.'_'.$email);
        return self::callSuccess();
    }
}

