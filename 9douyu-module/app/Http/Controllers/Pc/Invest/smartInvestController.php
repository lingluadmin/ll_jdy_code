<?php
/**
 * Created by PhpStorm.
 * User: scofie <bi.chunfeng@9douyu.com>
 * Date: 17/11/28
 * Time: 上午11:00
 */

namespace App\Http\Controllers\Pc\Invest;

use App\Http\Controllers\Pc\PcController;
use App\Tools\ToolJump;


class smartInvestController extends PcController
{
    
    public function investApply()
    {
        return view("pc.invest.project.smartInvest.apply");
    }

}