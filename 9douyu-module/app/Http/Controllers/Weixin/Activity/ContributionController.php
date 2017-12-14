<?php
/**
 * Created by PhpStorm.
 * User: xialili
 * Date: 17/11/20
 * Time: 下午2:00
 */

namespace App\Http\Controllers\Weixin\Activity;

use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Models\SystemConfig\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Logics\Activity\ReceiveBonusLogic;
use App\Tools\ToolJump;

class ContributionController extends WeixinController{


    public function index(Request $request)
    {


        return view('wap.activity.contribution.index', []);
    }


}
