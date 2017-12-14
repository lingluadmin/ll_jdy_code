<?php

namespace App\Console\Commands\Day\AssetsPlatform;

use App\Http\Logics\AssetsPlatform\AutoInvestFullLogic;
use Illuminate\Console\Command;
use App\Http\Models\Common\ServiceApi\EmailModel;
use Config;

class SendOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AssetsPlatform:SendOrder {start?} {end?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '资产平台 智投计划（一定赢） 向资产平台发送订单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = $this->argument('start');

        $end = $this->argument('end');

        if(empty($start) || empty($end))
        {
            //昨天
            $start = date("Y-m-d", strtotime("-1 day"));

            $end = date("Y-m-d 23:59:59", strtotime("-1 day"));
        }

        \Log::info(__METHOD__ . '--AssetsPlatform——智投项目 发送订单日期', [$start, $end]);

        self::doing($start, $end);
    }


    /**
     * 发送前一天订单
     *
     * @param $start
     * @param $end
     */
    private static function doing($start, $end)
    {
        //当天所有智投计划项目ID
        $project     = AutoInvestFullLogic::getInvestingSmartInvestProject($start, $end);

        \Log::info(__METHOD__ . '--AssetsPlatform——智投项目 ids', [$project]);

        if(!empty($project) && !empty($project['list']))
        {
            $results  = AutoInvestFullLogic::sendOrder($project['list'], $start, $end);

            \Log::info(__METHOD__, ['--AssetsPlatform——智投项目 发送投资订单返回结果：', $results]);

            if(!empty($results))
            {
                $emailModel = new EmailModel();
                $receiveEmails = Config::get('email.monitor.assetsPlatform');

                $title         = '【notice】资产平台 投资订单推送结果' . env('APP_ENV');

                $emailModel->sendHtmlEmail($receiveEmails, $title, json_encode($results));
            }
        }
    }
}
