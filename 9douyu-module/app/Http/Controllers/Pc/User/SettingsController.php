<?php
/**
 * Created by PhpStorm.
 * User: caelyn,hexing
 * Date: 16/6/18
 * Time: 下午6:02
 * Desc: 用户中心设置
 */

namespace App\Http\Controllers\Pc\User;

use App\Http\Controllers\Pc\UserController;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\User\LoginLogic;
use App\Http\Logics\User\PasswordLogic;
use App\Http\Logics\User\Setting\UserCheckLogic;

use App\Http\Logics\User\SessionLogic;

use App\Http\Logics\User\Setting\CodeLogic;
use App\Http\Logics\User\Setting\EmailLogic;

use App\Http\Logics\User\SmsLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Logics\User\UserInfoLogic;
use App\Http\Models\User\UserInfoModel;

use App\Http\Models\Common\SmsModel as Sms;

use App\Tools\ToolStr;
use Illuminate\Http\Request;
use Redirect;
use Session;

class SettingsController extends UserController
{

    /**
     * @return string
     * @desc   账户设置页面
     */
    public function index(){
        $userData = $this->getUser();

        $userInfo = !empty($userData['user_info']) ? $userData['user_info'] : [];

        $logic = new UserLogic();
        $data = $logic->formatUserInfo($userData,$userInfo);

        return view('pc.user.setting',['user' => $data]);
    }

    /**
     * 修改密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password()
    {

        return view('pc.user.password');

    }

    /**
     * 修改密码
     *
     * @param Request $request
     * @return mixed
     */
    public function doPassword( Request $request )
    {

        $request    = $request->all();

        $userId     = $this->getUserId();

        $userLogic  = new UserLogic();

        $res        = $userLogic->changePasswordByUserId($userId, $request['oldPassword'], $request['newPassword']);

        if(!$res['status'])
        {
            return Redirect::back()->with('errorMsg', $res['msg']);
        }

        return Redirect::to('/user/setting')->with('msg', '密码修改成功');
    }

    /**
     * 设置交易密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tradingPassword()
    {

        return view('pc.user.setTradingPassword');

    }

    /**
     * @param Request $request
     * @return mixed
     * 设置交易密码
     */
    public function doTradingPassword(Request $request){

        $password = $request->input('password');

        $password2 = $request->input('password2');

        if($password !== $password2){

            return redirect()->back()->withInput($request->input())->with('errors', '两次交易密码不一致');

        }

        //$userLogic = new UserLogic();

        $userId = $this->getUserId();

        $passwordLogic = new PasswordLogic();

        $result = $passwordLogic->setTradingPassword($password,$userId);

        if($result['status']){

            //跳转至交易密码
            return Redirect::to('/user/settings/success');

        }else {

            //返回
            return redirect()->back()->withInput($request->input())->with('errors', $result['msg']);

        }

    }

    /**
     * @desc 修改支付密码
     */
    public function changeTradingPassword()
    {
      return view('pc.user.changeTradingPassword');
    }


    /**
     * 修改交易密码
     * @param Request $request
     * @return mixed
     */
    public function doChangeTradingPassword( Request $request )
    {

        $request = $request->all();

        $userLogic = new UserLogic();

        $userId = $this->getUserId();

        $res = $userLogic->changePasswordByUserId($userId, $request['oldPassword'], $request['newPassword'], 'tradingPassword');


        if(!$res['status'])
        {
            return Redirect::back()->with('errorMsg', $res['msg']);
        }

        return Redirect::to('/user/setting')->with('msg', '交易密码修改成功');

    }


    /**
     * 找回交易密码－第一步－验证码
     * @return string
     */
    public function forgetTradingPassword()
    {

        return view('pc.user.forgetTradingPassword');
    }

    /**
     * 找回交易密码－第二步－验证页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vaildTradingPassword()
    {
        $session = session('forgetTradingPassword');

        \Log::info(__METHOD__, [$session]);

        if(!isset($session['step']) || $session['step'] != 'one'){
            return redirect('/user/forgetTradingPassword');
        }

        return view('pc.user.vaildTradingPassword4');
    }

    /**
     * 找回交易密码－第三步－设置交易密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function findTradingPassword( Request $request )
    {

        $session = session('forgetTradingPassword');

        \Log::info(__METHOD__, [$session]);

        if(!isset($session['step']) || $session['step'] != 'two'){
            return redirect('/user/vaildTradingPassword');
        }

        return view('pc.user.findTradingPassword');
    }


    /**
     * 忘记交易密码
     */
    public function doForgetTradingPassword( Request $request )
    {
        $step = $request->input('step', 'one');

        if(!in_array($step,['one', 'two', 'three']))
        {
            \Log::info(__METHOD__, ['非法请求', $request->all()]);

            response('404 not found！', 404);
        }

        $session = SessionLogic::getTokenSession();

        if($step == 'one'){
            $code = $request->input('code');
            //验证验证码有效性

            $logic   = new SmsLogic();
            $result  = $logic->checkCodeByType($session['phone'], $code, 'find_tradingPassword');

            if($result['status']){

                $sessionData = [
                    'forgetTradingPassword.step'  => $step,
                    'forgetTradingPassword.phone' => $session['phone'],
                ];

                session($sessionData);
            }

            return response()->json($result);

        }elseif($step == 'two'){
            $realName       = $request->input('realName');
            $identityCard   = $request->input('identityCard');

            if($session['real_name']  != $realName || $identityCard != $session['identity_card']) {
                return redirect()->back()->withInput($request->input())->with('errorMsg', '姓名或身份证号错误');
            }

            $sessionData = [
                'forgetTradingPassword.step'  => $step,
                'forgetTradingPassword.phone' => $session['phone'],
            ];

            session($sessionData);

            return redirect('user/findTradingPassword');

        }else{
            $passwordLogic = new PasswordLogic;
            $password      = $request->input('password');

            $setLogic      = $passwordLogic->setTradingPasswordV4($session['id'], $password);

            if(!$setLogic['status'])
                return redirect()->back()->withInput($request->input())->with('errorMsg', $setLogic['msg']);

            session()->forget('forgetTradingPassword');

            return Redirect::to('/user/setting')->with('msg', '交易密码找回成功');
        }
    }



    /**
     * 修改成功页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success(){
        //todo 修改成功页模版
        return view('pc.user.success');
    }

    /**
     * 修改失败页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fail(){
        //todo 修改失败页模版
        return view('pc.user.fail');
    }


    /**
     * 修改手机号 第一步 验证交易密码视图
     */
    public function modifyPhoneViewStepOne(){
        return view('pc.user.setting.modifyPhoneStepOne');
    }

    /**
     * 修改手机号 - 验证交易密码
     */
    public function verifyTransactionPassword(Request $request){
        $session = $this->getUser();
        if(empty($session['trading_password'])){
            return redirect()->back()->with('errorMsg', '请先实名认证');
        }
        $data           = [
            'password'              => $request->input('password'),
            'trading_password'      => $session['trading_password'],
        ];

        $logicReturn = UserCheckLogic::verifyTransactionPassword($data);

        if($logicReturn['status']){
            $userToken =  base64_encode(md5($session['id'] . $session['trading_password'] . $session['phone']));
            return view('pc.user.setting.modifyPhoneStepTwo',['token'=>$userToken]);
        }else{
            return redirect('/user/setting/phone/stepOne')->with('errorMsg', $logicReturn['msg']);
        }
    }

    /**
     * 修改手机号- 验证手机号 - 发送验证码
     */
    public function sendSms(Request $request){

        $phone = $request->input('phone');

        $codeLogic      = new CodeLogic;
        $logicResult    = $codeLogic->sendPhoneModifySms($phone);

        Session::save();

        return self::returnJson($logicResult);
    }

    /**
     * 修改手机号
     *
     * @param Request $request
     * @return mixed
     */
    public function modifyPhone(Request $request)
    {
        $user = SessionLogic::getTokenSession();

        $data = $request->all();
        $data = UserLogic::modifyPhoneFormatInput($data);
        // token 验证
        $is = UserCheckLogic::verifyTransactionPasswordToken($data['token'], $user);

        if (!$is) {
            return redirect('/user/setting/phone/stepOne')->with('errorMsg', '请先验证交易密码');
        }

        $logicResult = UserLogic::modifyPhone($data,false);

        if($logicResult['status']){
            LoginLogic::destroy();
            Session::flash('msg','重置密码成功，请重新登录');
            Session::save();
            $logicResult['data']['url'] = '/login';
        }
        return self::returnJson($logicResult);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 三要素实名
     */
    public function verify(Request $request){
        $user = $this->getUser();
        $data = [
            'realName'  => !empty($user['real_name']) ? $user['real_name'] : '',
            'identityCard' => !empty($user['identity_card']) ? $user['identity_card'] : '',
        ];

        return view('pc.user/verifyBindCard',$data);

    }

    /**
     * @SWG\Post(
     *   path="/user/setting/doVerify",
     *   tags={"PC-User"},
     *   summary="三要素实名 [Pc\User\SettingsController@verify]",
     *   @SWG\Parameter(
     *      name="name",
     *      in="formData",
     *      description="姓名",
     *      required=true,
     *      type="string",
     *      default="",
     *   ),
     *     @SWG\Parameter(
     *      name="card_no",
     *      in="formData",
     *      description="银行卡号",
     *      required=true,
     *      type="string",
     *      default="",
     *   ),
     *     @SWG\Parameter(
     *      name="id_card",
     *      in="formData",
     *      description="身份证号",
     *      required=true,
     *      type="string",
     *      default="",
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="实名+绑卡成功。",
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="实名+绑卡失败。",
     *   )
     * )
     */
    public function doVerify( Request $request )
    {
        $userId           = $this->getUserId();
        $name             = $request->input('real_name', '');
        $idCard           = $request->input('card_no', '');
        $cardNo           = $request->input('bank_card', '');
        $tradingPassword  = $request->input('trading_password', '');

        $from             = RequestSourceLogic::getSource();
        $logic            = new UserLogic();

        $bankId           = null;
        if(!\App::environment("production")) {
            //ip 白名单 本地或测试环境无法成功module_bank
            $bankId = app('request')->input('bankId', 1); //默认工商银行
        }
        $result           = $logic->doVerifyTradingPassword($userId, $name, $cardNo, $idCard, $from, $tradingPassword, $bankId);

        return self::returnJson($result);
    }


    /***********************[PC4-2改版]****************************/

    /****************[用户邮箱设置]************************/
    /**
     * @desc 设置用户的常用邮箱
     */
    public function setEmail()
    {
        return view('pc.user.setting.setEmail');
    }

    /**
     * @desc 修改常用邮箱第一步
     */
    public function modifyEmailStepOne()
    {
        $userId = $this->getUserId();
        $userLogic = new UserLogic();
        $userInfo = $userLogic->getUser($userId);

        return view('pc.user.setting.modifyEmailStepOne', ['userInfo'=> $userInfo]);
    }

    /**
     * @desc 修改常用邮箱第二步
     */
    public function modifyEmailStepTwo(Request $request)
    {
        $data = $request->all();
        if ($request->isMethod('POST')){
            //验证验证码
            $checkResult = Sms::checkPhoneCode($data['phoneCode'], $data['phone'], false);
            if (!$checkResult['status']){
                return redirect()->back()->with('errorMsg', $checkResult['msg']);
            }
            #设置验证码缓存
            \Cache::put('PHONE_VERIFY_URGENT_CODE'.$data['phone'], $data['phoneCode'], 30);
        }
        return view('pc.user.setting.modifyEmailStepTwo');
    }

    /**
     * @desc 执行设置邮箱操作
     * @param Request $request
     */
    public function doSetEmail(Request $request)
    {

        $emailLgoic = new EmailLogic();
        $userInfoLogic = new UserInfoLogic();

        $userId = $request->input('userId');
        $email = $request->input('email');
        $activationKey = $request->input('activation_key');
        //激活类型
        $setType = $request->input('activeType');

        //验证激活码
        $result = $emailLgoic->checkActiveEmail($userId, $email, $activationKey);
        if (!$result['status']){
            if ($setType == 'set'){

                return redirect('/user/setting/email')->with('errorMsg', $result['msg']);
            }elseif($setType == 'modify'){

                return redirect('/user/modify/email/stepOne')->with('errorMsg', $result['msg']);
            }
        }

        if ($setType == 'set'){
            $result = $userInfoLogic->setUserEmail($userId, $email);
        }elseif($setType == 'modify'){

            $result = $userInfoLogic->setUserEmail($userId, $email, true);
        }

        if (!$result['status']){
            return redirect('/user/setting/email')->with('errorMsg', $result['status']);
        }

        return redirect('/user/setting');
    }

    /**
     * @desc 发送邮件ajax函数
     */
    public function sendSetEmail(Request $request)
    {
        $userId = $this->getUserId();
        $email = $request->input('email');
        $setting = $request->input('setting');
        $url = url('/user/setting/doSetEmail');

        $emailLgoic = new EmailLogic();

        $result = $emailLgoic->sendActiveEmail($userId, $email, $url, $setting);
        return self::returnJson($result);
    }

    /********************[设置紧急联系人相关]*************************/

    /**
     * @desc 设置紧急联系人页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setUrgentPhone()
    {
        return view('pc.user.setting.setUrgentPhone');
    }

    /**
     * @desc 修改紧急联系人第一步
     */
    public function modifyUrgentStepOne()
    {
        $userId = $this->getUserId();
        $userLogic = new UserLogic();
        $userInfo = $userLogic->getUser($userId);

        $attributes = [
            'userInfo' => $userInfo,
            ];

        return view('pc.user.setting.modifyUrgentStepOne', $attributes);
    }

    /**
     * @desc 修改紧急联系人第二步
     */
    public function modifyUrgentStepTwo(Request $request)
    {
        $data = $request->all();
        if ($request->isMethod('POST')){
            //验证验证码
            $checkResult = Sms::checkPhoneCode($data['phoneCode'], $data['phone'], false);
            if (!$checkResult['status']){
                return redirect()->back()->with('errorMsg', $checkResult['msg']);
            }
            #设置验证码缓存
            \Cache::put('PHONE_VERIFY_URGENT_CODE'.$data['phone'], $data['phoneCode'], 30);
        }

        return view('pc.user.setting.modifyUrgentStepTwo');
    }

    /**
     * @desc 执行设置/修改紧急联系人的操作
     * @param Request $request
     * @return url jump
     */
    public function doUrgentPhone(Request $request)
    {
        $userId = $this->getUserId();

        $userInfoLogic = new UserInfoLogic();

        $data = $request->all();
        //设置或者修改联系人判断
        if ($data['setting'] == 'set'){
            $result = $userInfoLogic->setUserUrgentPhone($userId, $data['urgent_phone']);
        }elseif($data['setting'] == 'modify'){
            $result = $userInfoLogic->setUserUrgentPhone($userId, $data['urgent_phone'], true);
        }
        if (!$result['status']){
            return redirect()->back()->with('errorMsg', $result['msg']);
        }
        return redirect('/user/setting');
    }

    /**
     * @desc 设置/修改用户的联系地址
     */
    public function setUserAddress()
    {
        $title = '设置联系地址';

        $userId = $this->getUserId();

        $userInfoModel = new UserInfoModel();

        $userInfo = $userInfoModel->getUserInfo($userId);

        $address = $userInfo['address_text'];

        if (!empty($userInfo['address_text'])){
            $title = '修改联系地址';
        }

        $attributes = [
            'address' => $address,
            'title'   => $title,
            ];

        return view('pc.user.setting.setUserAddress', $attributes);

    }

    /**
     * @desc 执行设置用户联系地址
     */
    public function doSetUserAddress(Request $request)
    {
        $userId = $this->getUserId();
        $address = $request->input('address');

        $userInfoLogic = new UserInfoLogic();

        $result = $userInfoLogic->setUserAddress($userId, $address, true);

        if (!$result['status']){
            return redirect()->back()->with('errorMsg', $result['msg']);
        }
        return redirect('/user/setting');
    }

    /**
     * 修改邮箱-紧急联系人等验证码短信
     * @return json
     */
    public function sendVerifySms(Request $request)
    {
        $session = SessionLogic::getTokenSession();

        if(!$session)
            return redirect('/login/index')->with('message', '请先登录');

        $phone = $request->input('phone');

        $codeLogic                = new CodeLogic;
        $logicResult             = $codeLogic->sendSmsForVerify($phone);

        Session::save();

        return self::returnJson($logicResult);
    }
}
