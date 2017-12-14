<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/4/18
 * Time: 下午3:49
 */

namespace App\Http\Controllers\Pc\User;

use App\Http\Controllers\Pc\PcController;

use App\Http\Logics\Ad\AdLogic;
use App\Http\Logics\User\RegisterLogic;
use App\Http\Logics\User\UserLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;
use App\Http\Logics\User\UserInfoLogic;

use App\Http\Logics\User\LoginLogic;
use App\Http\Logics\User\PasswordLogic;
use App\Http\Logics\User\SessionLogic;
use App\Http\Logics\User\SmsLogic;

use Illuminate\Support\Facades\Redirect;
use App\Http\Models\Common\SmsModel as Sms;
use Session;

/**
 * pc登陆模块
 * Class LoginController
 * @package App\Http\User
 */
class LoginController extends PcController
{
    /**
     * pc 登陆页面
     */
    public function index(Request $request){
        //已经登陆的用户
        if(SessionLogic::getTokenSession()) {
            return redirect('/user');
        }

        //登录页面的广告

        $data['ad'] = AdLogic::getUseAbleListByPositionId(15);
        $data['action'] = 'login';
        $data['channel'] = $request->get ('channel','');
        return view('pc.user/login', $data);
    }

    /**
     * pc 登陆
     * @param Request $request
     * @return Redirect
     */
    public function doLogin(Request $request){
        //已经登陆的用户
        if(SessionLogic::getTokenSession()) {
            return redirect('/user');
        }
        $data   =[
            'factor'     => '',
            'username'   => $request->input('username'),
            'password'   => $request->input('password'),
        ];

        //检测登陆次数限制
        $checkLoginTimes = LoginLogic::checkLoginTimes($data['username']);
        if(!$checkLoginTimes['status']){
            return redirect('/login')->with('msg', $checkLoginTimes['msg']);
        }

        $LoginLogic = new LoginLogic();
        $logicData       = $LoginLogic->in($data);
        // 如果浏览器访问 写入 cookie
        if($logicData['status']) {
            $LoginLogic->handleFrom($logicData['data']);
            LoginLogic::logLoginTimes($data['username'], true);//清除登陆次数

            //跳转到个人中心 或者 是 设置过 登陆成功跳转页面
            $url = ToolJump::getLoginUrl();
            //检测用户是否做了风险评估
            $userInfoLogic  =   new UserInfoLogic();
            $userAssessment =   $userInfoLogic -> getAssessmentType($logicData['data']['userInfo']['id']);
            if( (empty($userAssessment) || is_null($userAssessment)) && strpos($url,'project/detail') ) {
                $url    =   '/user';
            }

            return redirect($url);

        }else{
            $errorTimesMsg = LoginLogic::logLoginTimes($data['username']); //记录登陆次数
            $msg = !empty($errorTimesMsg) && $logicData['msg'] != '手机号未注册'  ? $errorTimesMsg : $logicData['msg'];
            return redirect('/login')->with('msg', $msg);
        }

    }

    /**
     * 退出
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Laravel\Lumen\Http\Redirector
     */
    public function out(Request $request){
        $data = LoginLogic::destroy();
        if($data['status'])
            return Redirect::back()->with('msg', '退出成功');
        else
            return Redirect::back()->with('msg', '退出失败');
    }

   /*#######################忘记密码#############################*/

    /**
     * @desc 忘记密码页面
     * @return view
     **/
    public function forgetLoginPassword(){

        return view('pc.user.forgetpassword');
    }

    /**
     * @desc 验证用户实名信息for修改登录密码
     * @return string
     */
    public function UserInfoVerify()
    {
        $session = session('forgetPassword');

        \Log::info(__METHOD__, [$session]);

        if(!isset($session['step']) || $session['step'] != 'one'){
            return redirect('/forgetLoginPassword');
        }

        return view('pc.user.verifyLoginPassword');
    }

    /**
     * @desc 设置密码发送验证码
     * @return view
     **/
    public function resetLoginPassword()
    {
        $session = session('forgetPassword');

        \Log::info(__METHOD__, [$session]);

        if(!isset($session['step']) || $session['step'] != 'two'){
            return redirect('/forgetLoginPassword');
        }

        return view('pc.user.resetloginpassword');
    }


    /**
     * 忘记密码
     */
    public function doForgetPassword( Request $request )
    {
        $step    = $request->input('step', 'one');

        if(!in_array($step,['one', 'two', 'three']))
        {
            \Log::info(__METHOD__, ['恶意请求', $request->all()]);

            response('404 not found！', 404);
        }

        if($step == 'one'){
            $phone   = $request->input('phone');
            $code    = $request->input('code');

            //验证验证码有效性
            $logic   = new SmsLogic();
            $result  = $logic->checkCodeByType($phone, $code, 'find_password');

            \Log::info(__METHOD__, ['checkCodeByType', $result]);

            if($result['status'])
            {
                //未实名的用户 跳过验证【身份证、姓名】 步骤
                $user = UserLogic::getCoreUser($phone);
                if(empty($user['real_name']) || empty($user['identity_card'])){
                    $step = 'two';
                    $result['data']['jumpUrl'] = '/resetLoginPassword';
                }else{
                    $result['data']['jumpUrl'] = '/verifyLoginPassword';
                }
                $sessionData = [
                    'forgetPassword.step'  => $step,
                    'forgetPassword.phone' => $phone,
                ];
                session($sessionData);

            }
            return response()->json($result);

        }elseif($step == 'two'){
            $realName       = $request->input('realName');
            $identityCard   = $request->input('identityCard');

            $session = session('forgetPassword');

            \Log::info(__METHOD__, [$session]);

            if(!isset($session['step']) || $session['step'] != 'one' || empty($session['phone'])){
                return redirect('/forgetLoginPassword');
            }

            $user = UserLogic::getCoreUser($session['phone']);

            \Log::info(__METHOD__ , ['核心用户信息', $user]);

            if(!$user['status']){
                \Log::error(__METHOD__, ['发送验证码成功, 获取核心用户信息失败',$user]);
                return redirect()->back()->withInput($request->input())->with('errorMsg', '姓名或身份证号错误');
            }

            if($user['real_name']  != $realName || $identityCard != $user['identity_card']) {
                return redirect()->back()->withInput($request->input())->with('errorMsg', '姓名或身份证号错误');
            }

            $sessionData = [
                'forgetPassword.step'  => $step,
                'forgetPassword.phone' => $session['phone'],
            ];
            session($sessionData);

            return redirect('resetLoginPassword');

        }else{
            $password  = $request->input('password','');
            $password2 = $request->input('passwordSec','');

            if($password !== $password2){
                return redirect()->back()->withInput($request->input())->with('errorMsg', '确认密码与新密码不一致');
            }

            $session = session('forgetPassword');

            \Log::info(__METHOD__, [$session]);

            if(!isset($session['step']) || $session['step'] != 'two' || empty($session['phone'])){
                \Log::info(__METHOD__, [$session]);
                return redirect()->back()->withInput($request->input())->with('errorMsg', '无效验证');
            }
            $logic      = new PasswordLogic();
            $result     = $logic->resetPassword($session['phone'], $password);

            if($result['status'])
            {
                session()->forget('forgetPassword');

                $session = SessionLogic::getTokenSession();
                if($session)
                    return Redirect::to('/user/setting')->with('msg', '密码找回成功');
                else
                    return Redirect::to('/login');
            }else{
                return redirect()->back()->withInput($request->input())->with('errorMsg', $result['msg']);
            }
        }
    }



    /**
     * @desc 验证设置交易密码的处理
     * @param Request $request
     **/
    public function doResetLoginPassword(Request $request){

        $phone     = $request->input('phone','');
        $code      = $request->input('code','');
        $password  = $request->input('password','');
        $password2 = $request->input('password2','');

        $codeNum   = Session::get('pc_tel_pwd_'.$phone);

        if($codeNum != $code){
            return redirect()->back()->withInput($request->input())->with('errorMsg', '您的验证码已失效');
        }

        if($password !== $password2){
            return redirect()->back()->withInput($request->input())->with('errorMsg', '确认密码与新密码不一致');
        }

        $logic      = new PasswordLogic();
        $result     = $logic->resetPassword($phone,$password);


        if($result['status']){
            Session::forget('pc_tel_pwd_'.$phone);
            return redirect()->to('forgetPasswordSetSuccess');
        }else{
            return redirect()->back()->withInput($request->input())->with('errorMsg', $result['msg']);
        }

    }

    /**
     * @desc 找回登录密码发送短信验证码
     * @param Request $request
     * @return Json
     */
    public function sendSms(Request $request){

        $type   = $request->input('type','find_password');
        $phone  = $request->input('phone','');
        $captcha = $request->input('captcha','');

        $registerLogic = new RegisterLogic();
        $result  = $registerLogic->checkCaptcha($captcha);

        if($result['status']){
            $sms    = new SmsLogic();
            $result = $sms->sendSms($phone,$type);

            if($result['status']){
                Session::put("SEND_CODE_TIME", time());
                Session::save();
            }
        }

        return self::returnJson($result);

    }
    /**
     * @desc 设置找回登录密码成功页面
     **/
    public function forgetPasswordSetSuccess(){

        return view('pc.user.forgetpasswordsetsuccess');
    }
}
