<?php
/**
 * Created by PhpStorm.
 * User: tianxiaoyan
 * Date: 17/11/27
 * Time: 下午11:00
 */

namespace App\Http\Controllers\Weixin\Activity;

use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Models\SystemConfig\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\Activity\ReceiveBonusLogic;
use App\Tools\ToolJump;

class MicroblogController extends WeixinController{
   
    public function index()
    {
        return view('wap.activity.microblog.index');
    }
     
}