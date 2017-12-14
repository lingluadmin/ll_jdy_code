<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/6/3
 * Time: 上午9:53
 * Desc: Curl工具类
 */

namespace App\Tools;

use GuzzleHttp\Client;

class ToolCurl{

    /**
     * @param $url
     * @param array $params
     * @return string
     * @desc curlPost
     */
    public static function curlPost($url, $params = [], $headers = []) {

        $client = new Client();

        if(!empty($params)) {
            $params = ['form_params' => $params];
        }
        
        if(!empty($headers)) {
            $params['headers'] = $headers;
        }

        $params['connect_timeout'] = 5;

        try {
            $startTime = microtime();
            \Log::info(__METHOD__, $params);
            $response = $client->request('post', $url, $params);
            $endTime = microtime();
            \Log::info('TIME-CONSUMING', ['url' => $url, 'time' => $endTime - $startTime, '单位' => '毫秒']);
        } catch(\Exception $e) {
            return json_encode(["status" => false, "code" => 500, "msg" => $e->getMessage(), "data" => []]);
        }

        return (string)$response->getBody();

    }

    /**
     * @param $url
     * @param array $params
     * @return string
     * @desc curlPost
     */
    public static function curlPostNoVerify($url, $params = [], $headers = []) {

        $client = new Client(['verify'=> false]);

        if(!empty($params)) {
            $params = ['form_params' => $params];
        }

        if(!empty($headers)) {
            $params['headers'] = $headers;
        }

        try {
            \Log::info(__METHOD__, $params);
            $response = $client->request('post', $url, $params);
        } catch(\Exception $e) {
            return json_encode(["status" => false, "code" => 500, "msg" => $e->getMessage(), "data" => []]);
        }

        return (string)$response->getBody();

    }

    /**
     * @param $url
     * @param array $params
     * @return string
     * @desc curlGet
     */
    public static function curlGet($url, $params = []) {

        $client = new Client();

        if(!empty($params)) {
            $params = ['form_params' => $params];
        }

        $response = $client->request('get', $url, $params);

        return (string)$response->getBody();

    }

    /**
     * @return mixed
     * @desc 获取核心接口url
     */
    public static function getCoreUrl( $paramsUrl='' )
    {

        return env('CORE_URL').$paramsUrl;

    }
    /**
     * @return mixed
     * @desc 获取服务接口url
     */
    public static function getServiceUrl( $paramsUrl='' )
    {

        return env('SERVICE_URL').$paramsUrl;

    }

    /**
     * @param 邮件发送[可带附件]接口url
     * @param       $url
     * @param array $params
     * @param array $headers
     * @return string
     */
    public static function curlEmailPost($url, $params = [], $headers = []){

        $client = new Client();

        if(!empty($headers)) {
            $params['headers'] = $headers;
        }

        try {

            $params['connect_timeout'] = 5;

            $startTime = microtime();

            \Log::info(__METHOD__, $params);

            $response = $client->request('post', $url, $params);

            $endTime = microtime();

            \Log::info('TIME-CONSUMING', ['url' => $url, 'time' => $endTime - $startTime, '单位' => '毫秒']);

        } catch(\Exception $e) {

            return json_encode(["status" => false, "code" => 500, "msg" => $e->getMessage(), "data" => []]);

        }

        return (string)$response->getBody();
    }


    /**
     * 资产平台 请求接口
     *
     * @param $url
     * @param array $params
     * @return string
     * @desc curlPost
     */
    public static function assetsPlatformPost($url, $params = []) {

        $debug = false;
        
        if(env('APP_ENV') == 'production')
        {
            $debug = false;
        }
        $client = new Client(['debug' => $debug, 'connect_timeout'=> 5]);

        if(!empty($params))
        {
            $params = ['json' => $params];
        }

        \Log::info(__METHOD__, $params);

        try {
            $startTime = microtime();
            $response  = $client->request('post', $url, $params);
            $endTime   = microtime();

            \Log::info('TIME-CONSUMING', ['url' => $url, 'time' => $endTime - $startTime, '单位' => '毫秒']);

        } catch(\Exception $e) {

            \Log::info(__METHOD__, ['Exception', $e->getCode(), $e->getCode(), $e->getFile(), $e->getMessage()]);

            return json_encode(["resCode" => 1, "errorCode" => 909090, "errorMsg" => $e->getMessage(), "returnTime" => date('Y-m-d H:i:s')]);
        }
        return (string)$response->getBody();
    }

}