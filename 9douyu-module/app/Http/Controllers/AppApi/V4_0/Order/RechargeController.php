<?php
/**
 * User: caelyn
 * Date: 16/6/28
 * Time: 下午2:51
 * Desc: 充值订单
 */

namespace App\Http\Controllers\AppApi\V4_0\Order;

use App\Http\Controllers\AppApi\AppController;
use App\Http\Logics\AppLogic;
use App\Http\Logics\Logic;
use App\Http\Logics\Pay\BFAuthLogic;
use App\Http\Logics\Pay\RechargeLogic;
use App\Http\Logics\Pay\UCFAuthLogic;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Models\Pay\RechargeModel;
use App\Http\Logics\Pay\LLAuthLogic;
use App\Http\Logics\Pay\YeeAuthLogic;
use App\Lang\AppLang;
use App\Http\Dbs\OrderDb;
use Illuminate\Http\Request;
use Cache;
class RechargeController extends AppController
{

	const source = 'app';

	/**
	 * @SWG\Post(
	 *   path="/user_recharge",
	 *   tags={"APP-User"},
	 *   summary="用户充值 [Order\RechargeController@makeOrderV4]",
	 *   @SWG\Parameter(
	 *      name="name",
	 *      in="formData",
	 *      description="发送请求的模块名称",
	 *      required=true,
	 *      type="string",
	 *      default="cli_test_user",
	 *   ),
	 *   @SWG\Parameter(
	 *      name="client",
	 *      in="formData",
	 *      description="客户端",
	 *      required=true,
	 *      type="string",
	 *      default="ios",
	 *   ),
	 *   @SWG\Parameter(
	 *      name="version",
	 *      in="formData",
	 *      description="客户端版本号",
	 *      required=true,
	 *      type="string",
	 *      default="4.0.0",
	 *   ),
	 *   @SWG\Parameter(
	 *      name="token",
	 *      in="formData",
	 *      description="token",
	 *      required=true,
	 *      type="string",
	 *      default="653030e9f8e4f6559669386dfe4f56d4",
	 *   ),
	 *   @SWG\Parameter(
	 *      name="cash",
	 *      in="formData",
	 *      description="充值金额",
	 *      required=true,
	 *      type="integer",
	 *      default=""
	 *   ),
	 *   @SWG\Parameter(
	 *      name="bank_id",
	 *      in="formData",
	 *      description="银行ID",
	 *      required=false,
	 *      type="integer",
	 *      default=""
	 *   ),
	 *   @SWG\Parameter(
	 *      name="card_no",
	 *      in="formData",
	 *      description="银行卡号",
	 *      required=false,
	 *      type="string",
	 *      default="",
	 *   ),
	 *   @SWG\Parameter(
	 *      name="pay_type",
	 *      in="formData",
	 *      description="支付渠道(1101-连连认证支付，1102-易宝认证支付，1203-宝付认证支付，1204-融宝代扣)",
	 *      required=true,
	 *      type="array",
	 *      @SWG\Items(type="integer"),
	 *      collectionFormat="multi",
	 *      default="1101",
	 *      enum={"1101","1102","1103","1204"}
	 *   ),
	 *   @SWG\Response(
	 *     response=200,
	 *     description="用户充值成功。",
	 *   ),
	 *   @SWG\Response(
	 *     response=500,
	 *     description="用户充值失败。",
	 *   )
	 * )
	 */
	public function makeOrderV4(Request $request) {


		$bankId     = $request->input('bank_id',0);     //银行ID
		$cardNo     = $request->input('card_no','');    //银行卡号

		$cash       = $request->input('cash',0);        //充值金额
		$payType    = $request->input('pay_type',0);    //支付通道

        $userId = $this->getUserId();

		$logic = new RechargeLogic();

		$result = $logic->makeOrder($userId,$bankId,$cardNo,$cash,$payType,$this->client,$this->version);


		if($result['status']){

			return $this->toRechargeView($result['data']);

		}else{
            if(!$result['status'])
                $result['code'] = AppLogic::CODE_ERROR;

			return self::returnJsonData($result);

		}

		
	}

	/**
	 * 跳转到相应的充值页
	 * @param  array $data 
	 * @return json  
	 */
	private function toRechargeView($data){
		
		switch ($data['payChannel']) {

			case OrderDb::RECHARGE_YEEPAY_AUTH_TYPE: //易宝

				$logic = new YeeAuthLogic();

       			$result = $logic->submit($data['userId'],$data['cardNo'],$data['cash'],$data['orderId'],self::source);

				$result["params"]['url']   = isset($result['url'])?$result['url']:"";

	       		$result["pay_type"]        = OrderDb::RECHARGE_APP_JUMP_WX_TYPE;
				$result['order_id'] 	   = $data['orderId'];

				break;

			case OrderDb::RECHARGE_UCFPAY_AUTH_TYPE: //先锋支付

				$logic = new UCFAuthLogic();

				$result = $logic->submit($data['userId'],$data['cardNo'],$data['cash'],$data['orderId'],self::source,$data['bankId']);

				$result["params"]['url']   = isset($result['url'])?$result['url']:"";

				$result["pay_type"]        = OrderDb::RECHARGE_APP_JUMP_UCF_TYPE;
				$result['order_id'] 	   = $data['orderId'];

				break;

			case OrderDb::RECHARGE_LLPAY_AUTH_TYPE: //连连

				$logic = new LLAuthLogic();

       			$result = $logic->submit($data['userId'],$data['cardNo'],$data['cash'],$data['orderId'],self::source);
				//$result["params"]   = $result['url'];
				$result["params"]   = isset($result['parameter'])?$result['parameter']:"";

				unset($result['parameter']);

	       		$result["pay_type"]        = OrderDb::RECHARGE_APP_JUMP_LL_TYPE;
	       		
				break;

			case OrderDb::RECHARGE_BFPAY_AUTH_TYPE:

				$logic  = new BFAuthLogic();

				$result = $logic->submit($data['userId'],$data['cardNo'],$data['cash'],$data['orderId'],self::source,$data['bankId']);
				//$result["params"]   = $result['url'];
				$return  = isset($result['parameter'])?$result['parameter']:"";

				//成功
				if($return['retCode'] == '0000'){

					$result['params']['tradeNo'] = $return['tradeNo'];
				}else{
				    return $this->returnJsonData(Logic::callSuccess($result));
				}

				unset($result['parameter']);

				$result["pay_type"]        = OrderDb::RECHARGE_APP_JUMP_BF_TYPE;

				break ;


			default: //其他通道


				switch ($this->client){
					
					case RequestSourceLogic::SOURCE_IOS:{
						$subDomain = env('IOS_SUB_DOMAIN');
						break;
					}
					case RequestSourceLogic::SOURCE_ANDROID:{
						$subDomain = env('ANDROID_SUB_DOMAIN');
						break;
					}
				}

				//跳转页面
				$url = env('APP_URL_WX').'/pay/appConfirm/'.$data['payChannel'].'/'.$data['userId'].'/'.$data['bankId'].'/'.$data['cash'].'/'.$data['cardNo'].'/'.$data['orderId'].'/'.$this->version.'/'.$this->client;

//				$httpQuery = [
//
//					'version' => $this->version,
//					'client' => $this->client,
//					'token'	=> $this->token,
//					//'url' => $url,
//				];
//
//				$query = http_build_query($httpQuery);


				//$result["params"]['url'] = "http://".$subDomain.env('MAIN_DOMAIN')."/app_sign_login?".$query.'&url='.$url;
                $result["params"]['url'] = $url;

				//$result["params"]['url']   = env('APP_URL_WX').'/pay/appConfirm/'.$data['payChannel'].'/'.$data['userId'].'/'.$data['bankId'].'/'.$data['cash'].'/'.$data['cardNo'].'/'.$data['orderId'].'/'.$this->version.'/'.$this->client;

        		$result["pay_type"]        = OrderDb::RECHARGE_APP_JUMP_WX_TYPE;
            
        		$result["order_id"]        = $data['orderId'];
                \Log::info(__METHOD__." : ".__LINE__. json_encode($result));
				break;
		}

        return $this->returnJsonData(Logic::callSuccess($result));
	}


	/**
	 * @SWG\Post(
	 *   path="/give_up_recharge",
	 *   tags={"APP-Order"},
	 *   summary="放弃支付(订单标识为超时) [Order\RechargeController@giveUpRecharge]",
	 *   @SWG\Parameter(
	 *      name="name",
	 *      in="formData",
	 *      description="发送请求的模块名称",
	 *      required=true,
	 *      type="string",
	 *      default="cli_test_user",
	 *   ),
	 *  @SWG\Parameter(
	 *      name="client",
	 *      in="formData",
	 *      description="客户端来源",
	 *      required=true,
	 *      type="array",
	 *      @SWG\Items(type="string"),
	 *      collectionFormat="multi",
	 *      default="ios",
	 *      enum={"ios","android"}
	 *   ),
	 *   @SWG\Parameter(
	 *      name="version",
	 *      in="formData",
	 *      description="版本号",
	 *      required=true,
	 *      type="string",
	 *      default="4.0.0",
	 *   ),
	 *   @SWG\Parameter(
	 *      name="token",
	 *      in="formData",
	 *      description="token",
	 *      required=true,
	 *      type="string",
	 *      default="653030e9f8e4f6559669386dfe4f56d4",
	 *   ),
	 *   @SWG\Parameter(
	 *      name="order_id",
	 *      in="formData",
	 *      description="订单号",
	 *      required=true,
	 *      type="string",
	 *      default="",
	 *   ),
	 *   @SWG\Response(
	 *     response=200,
	 *     description="放弃支付(订单标识为超时)成功。",
	 *   ),
	 *   @SWG\Response(
	 *     response=500,
	 *     description="放弃支付(订单标识为超时)失败。",
	 *   )
	 * )
	 */
	public function giveUpRecharge(Request $request){
		
		$orderId	= $request->input('order_id','');

		$logic		= new RechargeLogic();
		$result		= $logic->giveUpRecharge($orderId);

		if(!$result['status'])
            $result['code'] = AppLogic::CODE_ERROR;

		return $this->returnJsonData($result);
	}

}