<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 2017/11/27
 * Time: 上午11:47
 */
namespace App\Http\Controllers\ThirdApi;

use App\Http\Dbs\User\OAuthAccessTokenDb;
use App\Http\Logics\Logic;
use App\Http\Logics\Project\ProjectLogic;

class AssetsPlatformController extends ApiController
{

    public function __construct(){

        parent::__construct();

        $request      = app('request');

        $token        = $request->input('token');

        //防止非客户端请求的token  访问此控制器
        $tokenRecord  = OAuthAccessTokenDb::getUserIdByToken($token);

        if(empty($tokenRecord['scope']) && $tokenRecord['scope'] == null)
        {
            header('HTTP/1.1 403 Forbidden');
            exit;
        }
    }

    public function test()
    {
        $request  = app('request');

        return $request->all();
    }

    /**
     * 创建项目
     * @return string
     */
    public function createProject(){

        $request = app('request');

        $data = $request->input('data');

        $returnData = [];

        $projectLogic = new ProjectLogic();

        foreach ($data as $item) {

            $return = $projectLogic->assetsPlatformCreateProject($item);

            $returnData[] = $return['data'];

        }

        $return['data'] = $returnData;

        return self::returnJson($return);

    }

    /**
     * 提前赎回
     * @return string
     */
    public function beforeRefund()
    {

        $request = app('request');

        $data = $request->input('data');

        \Log::info(__METHOD__, [$data]);

        $projectLogic = new ProjectLogic();

        $return = $projectLogic->assetsPlatformCreateRefund($data, 1);

        return self::returnJson($return);

    }

    /**
     * 项目到期赎回
     * @return string
     */
    public function refund()
    {

        $request = app('request');

        $data    = $request->input('data');

        \Log::info(__METHOD__, [$data]);

        $projectLogic = new ProjectLogic();

        $return       = $projectLogic->assetsPlatformCreateRefund($data);

        return self::returnJson($return);

    }

    /**
     * 状态修改为已匹配
     * @return string
     */
    public function matchInvest(){

        $request = app('request');

        $data = $request->input('data');

        $projectLogic = new ProjectLogic();

        $return = $projectLogic->assetsPlatformMatchInvest( $data );

        return self::returnJson($return);

    }
}