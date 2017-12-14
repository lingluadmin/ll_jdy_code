<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 8/17/17
 * Time: 2:57 PM
 * Desc: 用户优惠券
 */

namespace App\Http\Controllers\Pc\User;


use App\Http\Controllers\Pc\UserController;
use Illuminate\Http\Request;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Tools\ToolPaginate;

class BonusController extends UserController
{

    /**
     * @desc 用户优惠券页面
     * @param $type
     * @param Request $request
     */
    public function index( Request $request,$type=1)
    {
        $userId = $this->getUserId();
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 9);

        $logic = new UserBonusLogic();

        $list = $logic->getUserBonusList($userId, $page, $size, $type, true);

        $count = $list['data']['page']['total'];

        //分页问题
        $pageNation = new ToolPaginate($count, $page, $size, '/user/bonus/'.$type);
        $pager = $pageNation->getPagerInfo(10);

        unset( $list['data']['page']);

        $attributes = [
            'type' => $type,
            'page' => $page,
            'list' => $list['data'],
            'pager' => $pager,
            ];
        return view('pc.user.bonus_ajax', $attributes);
    }

    /**
     * @desc ajax 获取用户优惠券的列表
     */
    public function getBonusAjaxData(Request $request)
    {
        $data = [];

        $userId = $this->getUserId();
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 9);
        $type = (int)$request->input('bonusType',2);

        $logic = new UserBonusLogic();

        $list = $logic->getUserBonusList($userId, $page, $size, $type, true);

        $count = $list['data']['page']['total'];

        //分页问题
        $pageNation = new ToolPaginate($count, $page, $size, '/user/getBonusAjaxData');
        $pager = $pageNation->getPagerInfo(10);

        unset( $list['data']['page']);

        $config['staticHost'] = assetUrlByCdn('/',false);
        $data['config']  = $config;
        $data['list'] = $list['data'];
        $data['pager']   = $pager;
        $data['count']   = $count;
        return_json_format($data);
    }

}
