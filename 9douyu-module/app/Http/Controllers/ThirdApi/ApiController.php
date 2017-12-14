<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/8/30
 * Time: 下午3:17
 */

namespace App\Http\Controllers\ThirdApi;


use App\Http\Controllers\Controller;
use App\Http\Logics\Logic;
use App\Http\Logics\User\TokenLogic;

use Log;

/**
 * 访问API 统一接口
 *
 * Class ApiController
 * @package App\Http\Controllers\ThirdApi
 */
class ApiController extends Controller
{
    /**
     * 允许访问的
     *
     * @var array
     */
    private static $allowMethod = ['requestToken'];

    /**
     * 验证 token
     */
    public function  __construct()
    {
        $request      = app('request');
        $token        = $request->input('token');
        $tokenLogic   = new TokenLogic;
        $isCheck      = $tokenLogic->apiCheckToken($token);
        $action       = self::getCurrentAction();

        if(!($action['controller'] === 'ApiController' && in_array($action['method'], self::$allowMethod))){
            if ($isCheck === false) {
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
            if($isCheck !== true && !empty($isCheck)){
                $controllers =  explode(',', $isCheck);

                $scope = str_replace('Controller' , '', $action['controller']);

                \Log::info(__METHOD__,[$controllers, $scope]);

                if(!in_array($scope, $controllers)){
                    header('HTTP/1.1 403 Forbidden');
                    exit;
                }
            }
        }
    }

    /**
     * 请求token【密码模式】
     *
     * @return array
     */
    public function requestToken()
    {
        $request             = app('request');

        try {

            $data['client_id']    = $request->input('client_id');

            $client_secret        = $request->input('jdy_api_token_client_secret');
            if(empty($client_secret))
            {
                $data['username'] = $request->input('username');
                $data['password'] = $request->input('password');
            }else{
                $data['jdy_api_token_client_secret'] = $client_secret;
            }

            //request token
            $TokenLogic            = new TokenLogic();
            $tokenData             = $TokenLogic->requestToken($data);
            $callResult            = Logic::callSuccess($tokenData);
        } catch (\Exception $e) {
            Log::info(sprintf(__METHOD__ . 'Exception code：%s message：%s post-param：%s', $e->getCode(), $e->getMessage(), json_encode($data)));
            $callResult = Logic::callError('authentication failed.', $e->getCode());
        }

        return self::returnJson($callResult);
    }

    /**
     * 获取当前控制器与方法
     *
     * @return array
     */

    protected static function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        $class = substr(strrchr($class,'\\'),1);

        return ['controller' => $class, 'method' => $method];
    }

}