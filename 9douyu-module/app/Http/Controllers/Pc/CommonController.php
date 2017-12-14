<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 17/8/22
 * Time: 下午2:42
 */

namespace App\Http\Controllers\Pc;

use App\Http\Logics\User\SessionLogic;

use App\Http\Logics\User\SmsLogic;

use Illuminate\Http\Request;

use App\Tools\ToolEnv;

/**
 * pc 公共模块
 *
 * Class CommonController
 * @package App\Http\Controllers\Pc
 */
class CommonController extends PcController
{

    /**
     * pc wap 通用短信验证码
     *
     * phone 手机号
     *
     * type find_password || find_tradingPassword
     *
     * @param Request $request
     * @return mixed
     */
    public function sendSms(Request $request)
    {
        $type   = $request->input('type','');
        $phone  = $request->input('phone','');

        //找回交易密码判断登录状态
        if($type == 'find_tradingPassword')
        {
            $this->checkLogin(true);

            $session = SessionLogic::getTokenSession();
            $phone   = $session['phone'];
        }

        $sms    = new SmsLogic();

        $result = $sms->sendSms($phone, $type);

        $result['data']['msg'] = $result['msg'];

        if( ToolEnv::getAppEnv() != 'production' )
        {
            $cacheKey = "sms{$phone}_{$type}";

            $result['data']['verify_code'] = \Cache::get($cacheKey);
        }

        return  response()->json($result);
    }

}