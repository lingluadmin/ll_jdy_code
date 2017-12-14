<?php

namespace App\Http\Controllers\Pc\User;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Pc\UserController;
use App\Http\Logics\Invest\TermLogic;
use App\Tools\ToolPaginate;
use App\Tools\ToolTime;
use Illuminate\Http\Request;
use App\Http\Logics\Project\RefundRecordLogic;

/**
 * 用户定期资产类
 * Class TermRecordController
 * @package App\Http\Controllers\User
 */
class RefundController extends UserController
{
    const PAGE_SIZE = 10;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 投资中项目
     */
    public function getInvesting(Request $request)
    {
        $userId = $this -> getUserId();

        $page = $request->input('page', 1);
        $size = SELF::PAGE_SIZE;
        $assign = [];
        $termLogic = new TermLogic();
        $list = $termLogic->getInvesting($userId, $page, $size);
        if(!empty($list)){
            $toolPaginate = new ToolPaginate($list['total'], $page, $size, '/user/term/investing');
            $paginate = $toolPaginate->getPaginate();
            $assign['list'] = $list['record'];
            $assign['paginate'] = $paginate;
            $assign['page'] = ceil($paginate['total']/$size);
        }
        return view('pc.user.termInvesting', $assign);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 还款中项目
     */
    public function getRefunding(Request $request)
    {
        $page = $request->input('page', 1);
        $size = SELF::PAGE_SIZE;

        $userId = $this -> getUserId();
        $termLogic = new TermLogic();

        $list = $termLogic->getRefunding($userId, $page, $size);

        $toolPaginate = new ToolPaginate($list['total'], $page, $size, '/user/term/refunding');
        $paginate = $toolPaginate->getPaginate();

        $assign['list'] = $list['record'];
        $assign['paginate'] = $paginate;
        $assign['page'] = ceil($paginate['total']/$size);

        return view('pc.user.termRecord', $assign);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 已还款项目
     */
    public function getRefunded(Request $request)
    {
        $page = $request->input('page', 1);
        $size = SELF::PAGE_SIZE;

        $userId = $this -> getUserId();
        $termLogic = new TermLogic();

        $list = $termLogic->getRefunded($userId, $page, $size);

        $toolPaginate = new ToolPaginate($list['total'], $page, $size, '/user/term/refunding');
        $paginate = $toolPaginate->getPaginate();

        $assign['list'] = $list['record'];
        $assign['paginate'] = $paginate;
        $assign['page'] = ceil($paginate['total']/$size);

        return view('pc.user.termRecord', $assign);
    }

    /**
     * @desc 用户中心回款日历
     * @param Request $request
     */
    public function getUserRefundRecord(Request $request)
    {
        $size = 10;
        $refundRecordData = [];
        $userId = $this->getUserId();
        $page = $request->input('page', 1);

        //日期相关数据定义
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
        print_r($year,$month);
        $date = $year.'-'.$month;
        $dateStr = $year.'年'.$month.'月';
        //$date =  $request->input('day', ToolTime::dbDate());

        //格式化回款显示信息
        $refundRecordLogic = new RefundRecordLogic();
        //获取本月的回款数据
        $refundRecordData = $refundRecordLogic->refundPlanByDate($userId, $date);
        if($refundRecordData['status'] == true){

            $refundMonthAmount  = $refundRecordLogic->getRefundMonthAmount($refundRecordData['data']); //获取本月回款金额统计数据
            $monthAmount  = $refundRecordLogic->formatAppV4RefundAmountData($refundMonthAmount); //格式化本月回款统计数据

            //本月回款金额数据统计金额
            $refundMonthAmountData =[
                'refunded_cash_note' =>$monthAmount['refunded_cash_note'],
                'refunded_cash' =>$monthAmount['refunded_cash'],
                'refund_cash_note' =>$monthAmount['refund_cash_note'],
                'refund_cash' =>$monthAmount['refund_cash'],
                'refund_amount_unit' =>$monthAmount['refund_amount_unit'],
                'month_all_button' =>$monthAmount['month_all_button'],
                ];

            //回款时间格式化
            $refundDate = $refundRecordLogic->formatAppV4RefundDate($refundRecordData['data']);

            //用户当日回款记录列表
            $dayRefundList = $refundRecordLogic->getRefundListByDay($userId, $date);
            $dayRefundList = $refundRecordLogic->formatAppV4RefundDayList($dayRefundList);

            //$monthRefundList = array_merge_recursive($refundRecordData['data']['refund'], $refundRecordData['data']['refunded']);
        }

        //获取用户回款列表
        $monthRefundList = $refundRecordLogic->getUserRefundRecord($userId, $date, $page,  $size);

        //分页问题
        $count = $monthRefundList['total'];
        $pageNation = new ToolPaginate($count, $page, $size, '/user/refundPlan?year='.$year.'&month='.$month);
        $pager = $pageNation->getPagerInfo(10);

        $refundRecordData = [
            'refund_amount_data' => $refundMonthAmountData,
            'refund_date' => isset($refundDate['refund_date']) ? $refundDate['refund_date'] : [],
            'refunded_date' => isset($refundDate['refunded_date']) ? $refundDate['refunded_date'] : [],
            'day_refund_list' => $dayRefundList,
            'month_refund_list' => $monthRefundList['data'],
            'prev_year' => $month-1 > 0 ? $year : $year -1 ,
            'prev_month' => sprintf('%02d',$month-1 > 0 ? $month-1 : 12),
            'year' => $year,
            'month' => $month,
            'next_year' => $month + 1 > 12 ? $year+1 : $year,
            'next_month' => sprintf('%02d',$month + 1 > 12 ? 1 : $month+1),
            'date' => $date,
            'dateStr'=>$dateStr,
            'pager'=>$pager,
            ];

        return view('pc.user.refundRecord', $refundRecordData);
    }

}
