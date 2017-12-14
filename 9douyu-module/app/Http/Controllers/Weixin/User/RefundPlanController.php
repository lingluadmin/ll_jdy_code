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
use App\Tools\ToolPaginate;
use Illuminate\Http\Request;

class RefundPlanController extends UserController
{



    /**
     * @param Request $request
     * @return array
     * @desc 回款计划
     */
    public function refundPlan(Request $request){

        $userId = $this -> getUserId();

        $logic = new RefundRecordLogic();

        $result = $logic -> getRefundPlanByMonthByUserId( $userId );

        $list = [];
        if(!empty($result['data']['data'])){
            $lists = $logic->getRefundPlanFormatYear($result['data']['data']);
            $list = ['lists'=> $lists];
        }

        return view('wap.user.RefundPlan/index', $list);

    }
    /**
     * @param Request $request
     * @return array
     * @desc 回款日历
     */
    public function refundCalendar(Request $request){

        $userId = $this->getUserId();

        //日期相关数据定义
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
        $date = $year.'-'.$month;
        $dateStr = $year.'年'.$month.'月';

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

        }

        $refundRecordData = [
            'refund_amount_data' => $refundMonthAmountData,
            'refund_date' => isset($refundDate['refund_date']) ? $refundDate['refund_date'] : [],
            'refunded_date' => isset($refundDate['refunded_date']) ? $refundDate['refunded_date'] : [],
            'year' => $year,
            'month' => $month,
            'date' => $date,
            'dateStr'=>$dateStr,
        ];

        return view('wap.user.refundCalendar/index',$refundRecordData);

    }

    /**
     * @param Request $request
     * @desc 获取用户回款计划数据（精确到每个月）
     */
    public function refundCalendarAjax(Request $request){
        $userId = $this->getUserId();

        $size = 5;
        $page = $request->input('page', 1);

        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
        $date = $year.'-'.$month;

        //获取用户回款列表
        $refundRecordLogic = new RefundRecordLogic();
        $monthRefundList = $refundRecordLogic->getUserRefundRecord($userId, $date, $page,  $size);

        $view = [
            'list'          => $monthRefundList,
        ];
        return_json_format($view);
    }

    /**
     * @param Request $request
     * @return array
     * @desc 当月回款具体信息
     */
    public function refundPlanByDate($date, $total, $num){

        $userId = $this -> getUserId();

        $logic = new RefundRecordLogic();

        $result = $logic -> refundPlanByDate( $userId, $date );

        $list['lists'] = isset($result['data']) ? $result['data'] : [];

        $list['total'] = $total;

        $list['num'] = $num;

        return view('wap.user.RefundPlan/bydate', $list);

    }


}