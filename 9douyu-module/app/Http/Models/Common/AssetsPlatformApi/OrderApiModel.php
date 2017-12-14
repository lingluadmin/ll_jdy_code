<?php

namespace App\Http\Models\Common\AssetsPlatformApi;

use Config;

use Log;
use App\Http\Models\Model;

use App\Http\Models\Common\HttpQuery;

class OrderApiModel extends Model
{

    /**
     * @param $params
     * @return array|mixed
     * @desc 发送订单
     */
    public static function sendOrder($params)
    {
        $apiUrl = Config::get('assetsPlatformApi.order.send.url');
        $apiFuc = Config::get('assetsPlatformApi.order.send.functionId');

        Log::info(__METHOD__, [$apiUrl, $apiFuc, $params]);

        $return = HttpQuery::assetsPlatformPost($apiUrl, $params, $apiFuc);

        return $return;
    }

    /**
     * @param   $params
     * @return  array|mixed
     * @desc    获取订单每日收益
     */
    public static function getOrderInterestItem($params)
    {
        $apiUrl = Config::get('assetsPlatformApi.order.orderInterestItem.url');
        $apiFuc = Config::get('assetsPlatformApi.order.orderInterestItem.functionId');

        \Log::info(__METHOD__, [$apiUrl, $apiFuc, $params]);

        $return = HttpQuery::assetsPlatformPost($apiUrl, $params, $apiFuc);

        return $return;
    }

    /**
     * @param   $params
     * @return  array|mixed
     * @desc    获取订单每日收益
     */
    public static function getOrderMatchCredit($params)
    {
        $apiUrl = Config::get('assetsPlatformApi.order.orderMatchCredit.url');
        $apiFuc = Config::get('assetsPlatformApi.order.orderMatchCredit.functionId');

        \Log::info(__METHOD__, [$apiUrl, $apiFuc, $params]);

        $return = HttpQuery::assetsPlatformPost($apiUrl, $params, $apiFuc);

        return $return;
    }


    /**
     * @param $params
     * @return array|mixed
     * @desc 查询订单的历史收益
     */
    public static function getOrderInterest($params){

        $apiUrl = Config::get('assetsPlatformApi.order_interest.get.url');
        $apiFuc = Config::get('assetsPlatformApi.order_interest.get.functionId');

        Log::info(__METHOD__, [$apiUrl, $apiFuc, $params]);

        $ret = HttpQuery::assetsPlatformPost($apiUrl, $params, $apiFuc);

        return $ret;
    }

    /**
     * @param $params
     * @return array|mixed
     * @desc 查询订单的历史收益
     */
    public static function redeemOrder($params){

        $apiUrl = Config::get('assetsPlatformApi.order.orderApplyRefund.url');
        $apiFuc = Config::get('assetsPlatformApi.order.orderApplyRefund.functionId');

        \Log::info(__METHOD__, [$apiUrl, $apiFuc, $params]);

        $return = HttpQuery::assetsPlatformPost($apiUrl, $params, $apiFuc);

        return $return;
    }

    /**
     * @param $params
     * @return array|mixed
     * @desc 查询已匹配的订单收益总和
     */
    public static function getOrderTotalInterest($params){
        $apiUrl = Config::get('assetsPlatformApi.order_total_interest.get.url');
        $apiFuc = Config::get('assetsPlatformApi.order_total_interest.get.functionId');

        Log::info(__METHOD__, [$apiUrl, $apiFuc, $params]);

        $ret = HttpQuery::assetsPlatformPost($apiUrl, $params, $apiFuc);

        return $ret;
    }

}
