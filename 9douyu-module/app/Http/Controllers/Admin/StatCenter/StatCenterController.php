<?php
/**
 * @desc    数据统计
 * @date    2017-05-24
 */
namespace App\Http\Controllers\Admin\StatCenter;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Logics\Statistics\StatLogic;
use Illuminate\Http\Request;


class StatCenterController extends AdminController{


    /**
     * @desc    数据统计
     *
     */
    public function homeStatData(Request $request){
        $startTime  = $request->input('startTime');
        $endTime    = $request->input('endTime');

        $viewData   = StatLogic::homeStatData($startTime,$endTime);

        $viewData["startTime"]  = $startTime;
        $viewData["endTime"]    = $endTime;

        return view('admin.statdata.statdata',$viewData);

    }

}