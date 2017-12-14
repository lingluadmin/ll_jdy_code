<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/9/19
 * Time: 19:23
 */

namespace App\Http\Controllers\ThirdApi;


use App\Http\Controllers\Controller;
use App\Http\Logics\Order\PhoneTrafficLogic;
use Illuminate\Http\Request;

class PhoneApiController extends Controller
{
    /**
     * @param Request $request
     * @desc 流量充值的回调接口
     */
    public function response( )
    {
        $response   =   file_get_contents('php://input');
        $returnArr  =   ['resultCode'=>'1111' ,'resultMsg' =>'处理失败'];
        if( !empty($response) ){
            \Log::info('phone_traffic_response_message', [$response]) ;
            $return =PhoneTrafficLogic::doUpdate (PhoneTrafficLogic::unConstruct ($response)) ;
            if( $return['status'] == false ) {
                $returnArr  =   [
                    'resultCode'=>'1111' ,
                    'resultMsg' =>empty($return['msg']) ? '处理失败':$return['msg'],
                ];
            }

            if( $return['status']== true ) {
                $returnArr  =   ['resultCode'=>'0000' ,'resultMsg' =>'处理成功'];
            }

        } else{
            $returnArr['resultMsg'] = '回调信息为空';
        }

        \Log::info(__METHOD__.'info' ,[$returnArr,$response]);

        return json_encode ($returnArr) ;
    }
}