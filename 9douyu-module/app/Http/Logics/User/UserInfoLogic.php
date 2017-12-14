<?php

namespace App\Http\Logics\User;

use App\Http\Logics\AppLogic;
use App\Http\Logics\Logic;
use App\Http\Models\Common\ValidateModel;
use App\Http\Models\User\UserInfoModel;
use Illuminate\Support\Facades\Request;
use App\Http\Models\Common\SmsModel as Sms;
use Log;
use Cache;

class UserInfoLogic extends Logic
{

    /**
     * @param int $userId
     * @param array $data
     * @return array|mixed
     * @desc  计算风险承受能力
     */
    public function doSickAssessment( $userId, $data )
    {
        try{
            //验证用户ID
            ValidateModel::isUserId($userId);

            Cache::put('sickAssessment'.$userId, $data, 60);

            return self::callSuccess();

        }catch(\Exception $e){

            $attributes['data'] = $data;
            $attributes['msg'] = $e->getMessage();
            $attributes['code'] = $e->getCode();

            Log::error(__METHOD__ . 'Error', $attributes);

            return self::callError('提交失败,请稍后再试');
        }

    }

    /**
     * @param int $userId
     * @param array $data
     * @return array|mixed
     * @desc  计算风险承受能力
     */
    public function doSickAssessmentSecond( $userId, $data, $score=0 )
    {
        try{
            //验证用户ID
            ValidateModel::isUserId($userId);

            $count = $score == 0 ? $this->doScore($data) : $score;

            $module     =   new UserInfoModel();

            $userInfo   =  $module->getUserInfo($userId);

            if( empty($userInfo ) ) {

                $data   =   [
                    'userId'            =>  $userId,
                    'assessment_score'  =>  $count,
                    'source_code'       =>  '',
                    'invite_code'       =>  '',
                    'ip'                =>  isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : Request::getClientIp(),
                ];

                $result =   $module -> doCreate($data);

            } else {

                $result = UserInfoModel::doAssessmentScore($userId,$count);

            }

            if($result){

                $type = UserInfoModel::assessmentType($count);

                return self::callSuccess($type);
            }

            return self::callError($result);

        }catch(\Exception $e){

            $attributes['data'] = $data;
            $attributes['msg'] = $e->getMessage();
            $attributes['code'] = $e->getCode();

            Log::error(__METHOD__ . 'Error', $attributes);

            return self::callError($e->getMessage());
        }

    }

    /**
     * @param array $data
     * @return int
     * @desc  计算风险承受能力
     */
    public function doScore($data){

        $scoreArr = UserInfoModel::$scoreArr;

        $score  = 0;

        foreach($data as $key=>$value){
            $score += $scoreArr[$value];
        }

        return $score;

    }

    /**
     * @param int $userId
     * @return string
     * @desc  获取用户承受风险能力级别
     */
    public function getAssessmentType($userId){

        $model = new UserInfoModel();
        $info = $model->getUserInfo($userId);

        $type = '';
        if(!empty($info) && !is_null($info['assessment_score'])){
            $type = $model->assessmentType($info['assessment_score']);
        }

        return $type;

    }

    /**
     * @param $userId
     * @param $email
     * @param bool $isCheckMore
     * @return array
     * @desc 设置个人邮箱地址信息
     */
    public function setUserEmail($userId , $email, $isCheckMore=false){

        if(!((int)$userId)){
            return self::callError(trans('api.CODE_' . AppLogic::CODE_NO_USER_ID),AppLogic::CODE_NO_USER_ID);
        }

        try{
            $data['email'] = empty($email) ? '' : $email;

            if(!empty($data['email'])){
                //验证邮箱格式
                ValidateModel::isEmail($email);
            }

            //是否验证更多，兼容三端改版
            if ($isCheckMore){
                $userLogic = new UserLogic();
                $userInfo = $userLogic->getUser($userId);

                $phone = $userInfo['phone'];
                $code = \Cache::get('PHONE_VERIFY_URGENT_CODE'.$phone);
                $checkResult = Sms::checkPhoneCode($code, $phone);
                if (!$checkResult['status']){
                    return self::callError($checkResult['msg']);
                }
            }

            //修改邮箱信息
            $userInfoModel = new UserInfoModel();

            $userInfoModel->updateUserInfo( $userId, $data );

        }catch(\Exception $e){
            \Log::error(__METHOD__, [$e->getMessage()]);

            return self::callError($e->getMessage());
        }

        if ($isCheckMore){
            #清理验证码缓存
            \Cache::forget('PHONE_VERIFY_URGENT_CODE'. $phone);
        }
        return self::callSuccess();

    }

    /**
     * @param $userId
     * @param $address
     * @param bool $isCheckMore
     * @return array
     * @desc 设置详细地址信息
     */
    public function setUserAddress( $userId , $address, $isCheckMore = false ){

        if(!((int)$userId)){
            return self::callError(trans('api.CODE_' . AppLogic::CODE_NO_USER_ID),AppLogic::CODE_NO_USER_ID);
        }

        try{
            //是否验证更多，三端改版4-2使用
            if ($isCheckMore){
                ValidateModel::checkSubmitContent($address, ValidateModel::MAX_ADDRESS_NUM, '用户联系地址');
            }

            //修改详细地址
            $userInfoModel = new UserInfoModel();

            $data['address_text'] = empty($address) ? '' : $address;
            $userInfoModel->updateUserInfo( $userId, $data );

        }catch(\Exception $e){
            \Log::error(__METHOD__, [$e->getMessage()]);

            return self::callError($e->getMessage());
        }

        return self::callSuccess();

    }

    /**
     * @desc 设置用户的紧急联系人
     * @param $userId int
     * @param $urgentPhone string
     * @param bool $isCheckMore
     * @return array
     */
    public function setUserUrgentPhone($userId, $urgentPhone, $isCheckMore = false)
    {
        if(!((int)$userId)){
            return self::callError(trans('api.CODE_' . AppLogic::CODE_NO_USER_ID),AppLogic::CODE_NO_USER_ID);
        }

        try{
            //修改设置紧急联系人
            $userInfoModel = new UserInfoModel();

            $data['urgent_linkman_phone'] = empty($urgentPhone)? '': $urgentPhone;

            //验证手机号格式
            if (!empty($urgentPhone)){
                ValidateModel::isPhone($urgentPhone);
            }

            //是否验证更多，兼容三端改版
            if ($isCheckMore){
                $userLogic = new UserLogic();
                $userInfo = $userLogic->getUser($userId);

                $phone = $userInfo['phone'];
                $code = \Cache::get('PHONE_VERIFY_URGENT_CODE'.$phone);
                $checkResult = Sms::checkPhoneCode($code, $phone);
                if (!$checkResult['status']){
                    return self::callError($checkResult['msg']);
                }
            }

            $userInfoModel->updateUserInfo( $userId, $data );
        } catch(\Exception $e){

            \Log::error(__METHOD__, [$e->getMessage()]);

            return self::callError($e->getMessage());
        }

        if ($isCheckMore){
            #清理手机验证码缓存
            \Cache::forget('PHONE_VERIFY_URGENT_CODE'. $phone);
        }
        return self::callSuccess();
    }

    public function doWapScore( $userId, $data){

        try{
            //验证用户ID
            ValidateModel::isUserId($userId);

            $count = $this->doScore($data);

            $module     =   new UserInfoModel();

            $userInfo   =  $module->getUserInfo($userId);

            if( empty($userInfo ) ) {

                $data   =   [
                    'userId'            =>  $userId,
                    'assessment_score'  =>  $count,
                    'source_code'       =>  '',
                    'invite_code'       =>  '',
                    'ip'                =>  isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : Request::getClientIp()
                ];

                $result =   $module -> doCreate($data);
            } else {
                $result = UserInfoModel::doAssessmentScore($userId,$count);
            }

            if($result){
                $type = UserInfoModel::assessmentType($count);
                return self::callSuccess($type);
            }
        }catch(\Exception $e){

            $attributes['data'] = $data;
            $attributes['msg'] = $e->getMessage();
            $attributes['code'] = $e->getCode();

            Log::error(__METHOD__ . 'Error', $attributes);

            return self::callError($e->getMessage());
        }

    }
}
