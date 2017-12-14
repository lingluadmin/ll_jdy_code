<?php
/**
 * Created by PhpStorm.
 * User: zhangshuang
 * Date: 16/7/26
 * Time: 18:21
 */

namespace App\Http\Controllers\Weixin\User;

use App\Http\Controllers\Weixin\UserController;
use App\Http\Logics\Current\CurrentUserLogic;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Logics\Current\CreditLogic;

class CurrentController extends UserController{

    /**
     * 我的零钱计划
     */
    public function index(){
        $client = 'wap';
        $userId = $this->getUserId();

        $logic = new CurrentUserLogic();

        $result = $logic->getAppV4Detail($userId, $client);

        return view('wap.user.current.index',$result['data']);
    }


    /**
     * 微信端查看零钱计划债权
     */
    public function viewCredit(){

        $userId = $this->getUserId();
        
        $result = CreditLogic::viewCredit($userId);

        return view('wap.user.current.credit',$result);
        
        
    }
}