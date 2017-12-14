<?php
/**
 * Created by PhpStorm.
 * User: liuqiuhui
 * Date: 16/7/7
 * Time: 下午4:48
 */

namespace App\Http\Controllers\Weixin\User;


use App\Http\Controllers\Weixin\UserController;
use App\Http\Logics\Project\RefundRecordLogic;
use Illuminate\Http\Request;

class LendingRecordController extends UserController
{
 
    public function  LendingRecord(){

        return view('wap.user.LendingRecord.index');

    }

}