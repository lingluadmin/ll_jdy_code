<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/4/19
 * Time: 上午11:57
 */
namespace App\Http\Logics\Weixin;

use App\Http\Logics\Logic;

use App\Http\Models\Weixin\WechatModel;

use App\Http\Dbs\Weixin\WechatDb;

use App\Tools\ToolCurl;
use App\Tools\ToolStr;
use Log;

/**
 * 微信信息
 * Class WechatLogic
 * @package App\Http\Logics\Weixin
 */
class WechatLogic extends Logic
{
    const
        API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin',
        AUTH_URL = '/token?grant_type=client_credential&',
        TICKET_URL = '/ticket/getticket?type=jsapi&access_token=',
        END = true;
    /**
     * 添加/编辑 微信信息
     * @param array $data
     * @return array
     */
    public static function updateOrCreate($data = []){
        try {
            $attributes = self::filterAttributes($data);

            Log::info('attributes: ', $attributes);

            $return     = WechatModel::updateOrCreate($attributes);

        }catch (\Exception $e){
            $attributes['data']           = $data;
            $attributes['msg']            = $e->getMessage();
            $attributes['code']           = $e->getCode();

            Log::error(__METHOD__.'Error', $attributes);

            return self::callError($e->getMessage());
        }

        return self::callSuccess([$return]);
    }

    /**
     * 添加/编辑 过滤白名单
     * @param array $data
     * @return array
     */
    public static function filterAttributes($data = []){
        $attributes = [
            'openid'            => $data['openid'],
            'nickname'          => $data['nickname'],
            'headimgurl'        => $data['headimgurl'],
            'type'              => !empty($data['type']) ? $data['type'] : WechatDb::TYPE_DEFAULT,
        ];

        return $attributes;
    }

    /**
     * @desc 获取微信的access_token信息
     * @return string
     */
    public static function getAccessToken()
    {
        $token_key = 'wx_access_token';
        $token = \Cache::get($token_key);

/*        if (empty($token)) {
            $weixin = config('wechat');
            $url = self::API_URL_PREFIX.self::AUTH_URL.'appid='.$weixin['app_id'].'&secret='.$weixin['secret'];

            $result = ToolCurl::curlGet($url);
            $result = json_decode($result, true);

            $token = isset($result['access_token']) ? $result['access_token'] : '';

            if( !empty($token) ) {
                \Cache::put($token_key, $token, 120);
            }
}*/

        $weixin = config('wechat');
        $url = self::API_URL_PREFIX.self::AUTH_URL.'appid='.$weixin['app_id'].'&secret='.$weixin['secret'];

        $result = ToolCurl::curlGet($url);
        $result = json_decode($result, true);

        $token = isset($result['access_token']) ? $result['access_token'] : '';

        Log::info('wechat share access_token: '.$token);

        return $token;
    }

    /**
     * @desc 获取微信签名所需要的ticket
     * @return string
     */
    public static function getTicket()
    {
        $ticket_key = 'wx_ticket';
        $ticket = \Cache::get($ticket_key);

        /*if (empty($ticket)) {
            $url = self::API_URL_PREFIX.self::TICKET_URL.self::getAccessToken();

            $result = ToolCurl::curlGet($url);

            $result = json_decode($result, true);

            $ticket = isset($result['ticket']) ? $result['ticket'] : '';

            if( !empty($ticket) ) {
                \Cache::put($ticket_key, $ticket, 60);
            }

        }*/
        $url = self::API_URL_PREFIX.self::TICKET_URL.self::getAccessToken();

        $result = ToolCurl::curlGet($url);

        $result = json_decode($result, true);

        $ticket = isset($result['ticket']) ? $result['ticket'] : '';

        Log::info('wechat share ticket: '.$ticket);

        return $ticket;
    }
    /**
     * @desc 获取微信的签名signature
     * @param $timestamp int 时间戳
     * @param $nonceStr string 随机字符串
     * @return string
     */
    public static function getSignature($timestamp, $nonceStr)
    {
        //获取微信签名所需要的ticket
        $jsapi_ticket = self::getTicket();

        $currentSec = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';

        //url
        $url = $currentSec.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $and = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url."";

        $signature      = sha1($and);

        Log::info('wechat share signature: '.$signature);
        return $signature;
    }

    /**
     * @desc 微信的JsSdk信息
     * @return param $url 跨域传的url
     */
    public static function jsSdk()
    {
        $weixin = config('wechat');

        Log::info('wechat config :', $weixin);

        //时间戳
        $timestamp = time();

        //随机字符串
        $nonceStr = ToolStr::getRandStr().substr(2, 15);

        $sdk = [
            'appId' => $weixin['app_id'],
            'timestamp' => $timestamp,
            'nonceStr'  => $nonceStr,
            'signature' => self::getSignature($timestamp, $nonceStr),
        ];

        return $sdk;
    }
}
