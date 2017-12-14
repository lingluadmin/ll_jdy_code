<?php
/**
 * Created by PhpStorm.
 * User: xialili
 * Date: 17/11/21
 * Time: 10:30
 */

namespace App\Http\Controllers\Pc\Activity;

use App\Http\Controllers\Pc\PcController;
use App\Tools\ToolJump;


class PartnerController extends PcController
{
    
    public function index()
    {
        return view("pc.activity.partner.index");
    }

}