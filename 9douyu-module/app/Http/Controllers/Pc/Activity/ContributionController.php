<?php
/**
 * Created by PhpStorm.
 * User: tianxiaoyan
 * Date: 17/11/20
 * Time: 下午2:24
 */

namespace App\Http\Controllers\Pc\Activity;


use App\Http\Controllers\Pc\PcController;
use App\Tools\ToolJump;
use App\Http\Logics\Activity\AutumnNationLogic;
use Illuminate\Http\Request;
use App\Http\Dbs\Bonus\BonusDb;

class ContributionController extends PcController
{

    public function index()
    {
        return view("pc.activity.contribution.index");
    }

}
