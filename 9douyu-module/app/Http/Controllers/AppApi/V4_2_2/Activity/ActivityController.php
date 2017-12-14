<?php

namespace App\Http\Controllers\AppApi\V4_2_2\Activity;

use App\Http\Controllers\AppApi\AppController;
use Illuminate\Http\Request;
use App\Http\Logics\AppLogic;
use App\Http\Logics\Activity\Common\ActivityLogic;

/**
 * Created by PhpStorm.
 * User: jinzhuotao
 * Date: 2017/10/24
 * Time: 上午11:13
 */
class ActivityController extends AppController
{

    /**
     * @SWG\Post(
     *   path="activity_callback",
     *   tags={"APP-Home"},
     *   summary="活动回调接口 [Activity\ActivityController@index]",
     *   @SWG\Parameter(
     *      name="name",
     *      in="formData",
     *      description="发送请求的模块名称",
     *      required=true,
     *      type="string",
     *      default="cli_test_user",
     *   ),
     *   @SWG\Parameter(
     *      name="token",
     *      in="formData",
     *      description="token",
     *      required=true,
     *      type="string",
     *      default="653030e9f8e4f6559669386dfe4f56d4",
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
     *      default="4.2.2",
     *   ),
     *   @SWG\Parameter(
     *      name="activity_id",
     *      in="formData",
     *      description="活动id",
     *      required=true,
     *      type="string",
     *      default="107",
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="获取信息成功。",
     *   ),
     * )
     */
    public function index(Request $request){

        $activityId = $request->input('activity_id');

        $userId = $this->getUserId();

        //获取活动标示对应的活动配置信息
        $return =  ActivityLogic::getActivityConfigByAppReturn($activityId);

        if ($return['status'] == false) {
            return AppLogic::callSuccess($return['msg']);
        }

        $logic = new $return['data']['class']();

        $result = $logic->$return['data']['functions'](['user_id'=>$userId]);
        if ($result['status'] == false){
            return AppLogic::callSuccess($result['msg']);
        }

        return AppLogic::callSuccess($result['data']['msg']);
    }

}
