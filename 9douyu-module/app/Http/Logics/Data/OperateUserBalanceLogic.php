<?php
/**
 * Created By Vim
 * User: linguanghui
 * Date: 2017-11-16
 * Desc: 每小时发送操作用户账户余额统计邮件[避免实时发送，导致邮件系统退回]
 */

namespace App\Http\Logics\Data;

use App\Http\Logics\Logic;
use App\Tools\ToolTime;
use App\Http\Models\Common\ServiceApi\EmailModel;
use App\Http\Models\Activity\ActivityFundHistoryModel;
use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use Log;

class OperateUserBalanceLogic extends Logic
{

    /**
     * @desc 数据查询的时间统计
     */
    public function duteTheTime()
    {
        //时间处理
        $hour = date('H');
        $startTime = date('Y-m-d').' '.($hour-1).':00:00';
        $endTime = date('Y-m-d').' '.($hour-1).':59:59';

        return [
            'start' => $startTime,
            'end'   => $endTime,
            ];
    }

    /**
     * @desc 格式化活动资金明细数据
     * @param $data
     * @return array
     */
    public function formatActivityFunHistory($data)
    {
        $activityFunHistoryData = [];

        if (empty($data)) {
            return [];
        }

        $activityEventNote = ActivityFundHistoryModel::getActivityEventNote();
        foreach ($data as $key => $value) {
            $activityFunHistoryData[$key]['user_id'] = $value['user_id'];
            $activityFunHistoryData[$key]['cash'] = $value['balance_change'];
            $activityFunHistoryData[$key]['type_note'] = $value['type'] == ActivityFundHistoryDb::TYPE_IN ? '转入' : '转出';
            $activityFunHistoryData[$key]['source_note'] = isset(ActivityFundHistoryModel::getActivityEventNote()[$value['source']]) ? ActivityFundHistoryModel::getActivityEventNote()[$value['source']] : $value['note'];
            $activityFunHistoryData[$key]['note'] = $value['note'];
            $activityFunHistoryData[$key]['event_id'] = $value['source'];
        }

        return $activityFunHistoryData;
    }

    /**
     * @desc 邮件接受者
     * @return array
     */
    public function getEmailReceived()
    {
        $receiveEmails = \Config::get('email.monitor.accessToken');

        return $receiveEmails;
    }

    /**
     * @desc 执行用户余额操作邮件发送
     */
    public function sendOperateBalanceData()
    {
        //获取时间
        $date = $this->duteTheTime();

        $model = new ActivityFundHistoryModel();

        //获取资金流水的数据
        $activityFunHistory = $model->getActivityFundHistoryListByDate($date['start'], $date['end']);

        $activityFunHistory = $this->formatActivityFunHistory($activityFunHistory);

        if (!empty($activityFunHistory)){

            //邮件的标题
            $title = "{$date['start']} ~ {$date['end']}用户活动资金流水明细";

            //邮件内容
            $body = $this->formatEmailContent($title, $activityFunHistory);

            //附件
            $savePath = $this->formatEmailAttachment($activityFunHistory);

            //执行邮件发送
            $this->sendActivityEmail($title, $body, $savePath);
        } else {
            Log::info("{$date['start']} ~ {$date['end']} 用户活动资金流水明细为空");
            return false;
        }
    }

    /**
     * @desc 格式化邮件发送的内容
     * @param $title
     * @param $activityFunHistory array
     * @return array
     */
    public function formatEmailContent($title, $activityFunHistory)
    {

        $dataStatisticsLogic = new DataStatisticsLogic();
        $body = "<br/>";
        $body  .= $dataStatisticsLogic->getCss();
        $body .="<p><h4>".$title."</h4></p>";
        $body .="<table class='table'><tr><th>用户ID</th><th>变动金额</th><th>操作类型</th><th>活动来源</th><th>资金流水备注</th></tr>";
        foreach($activityFunHistory as $k=>$val){
            $body .="<tr><td>{$val['user_id']}</td><td>{$val['cash']}</td><td>{$val['type_note']}</td><td>{$val['source_note']}</td><td>{$val['note']}</td></tr>";
        }
        $body .="</table>";

        return $body;
    }

    /**
     * @desc 格式化发送邮件的附件
     * @param $activityFunHistory
     * @return array
     */
    public function formatEmailAttachment($activityFunHistory)
    {
        $excelData[] =  "用户ID, 变动金额, 操作类型, 活动来源备注, 资金流水备注";
        foreach($activityFunHistory as $k=>$val) {
            $birthdayArr = array($val["user_id"], $val["cash"], $val["type_note"], $val["source_note"], $val["note"]);

            $excelData[] = implode(",", $birthdayArr);
        }
        //写入的文件路径
        $fileName   = "activity_fund_history.csv";
        //不存在目录时创建目录
        $dirPath = base_path() . '/public/uploads/activity/';
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777);
            chmod($dirPath, 0777);
        };
        //写入文件
        $savePath = $dirPath.$fileName;
        @file_put_contents($savePath, implode("\n", $excelData));
        return [$savePath];
    }


    /**
     * @desc 每小时活动资金流水明细执行邮件发送
     * @param $title
     * @param $body
     * @param  $savePath
     */
    public function sendActivityEmail($title,$body, $savePath=''){
        $dataStatisticsLogic = new DataStatisticsLogic();
        $emailModel = new EmailModel();
        //接受者邮箱
        $receiveEmails = $this->getEmailReceived();
        //发送邮件
        $result = $emailModel->sendHtmlEmail($receiveEmails, $title, $body, $savePath);

        if($result['status'] == false){
            Log::info('每小时活动资金流水明细执行邮件发送:'.\GuzzleHttp\json_encode($result));
        }else{
            foreach($savePath as $file) {
                @unlink($file);
            }
            Log::info('每小时活动资金流水明细执行邮件发送成功');
        }
    }
}
