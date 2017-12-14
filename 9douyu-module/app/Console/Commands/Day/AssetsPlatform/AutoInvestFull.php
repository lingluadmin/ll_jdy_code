<?php

namespace App\Console\Commands\Day\AssetsPlatform;

use App\Http\Logics\AssetsPlatform\AutoInvestFullLogic;
use Illuminate\Console\Command;
use App\Http\Models\Common\ServiceApi\EmailModel;
use Config;

/**
 * 自动投满
 *
 * Class AutoInvestFull
 * @package App\Console\Commands\Day\AssetsPlatform
 */
class AutoInvestFull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AssetsPlatform:autoInvestFull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '资产平台 智投计划（一定赢） 签订自动投标协议者（目前只有一个用户）产品自动投满';

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
        //当前日期
        $start       = date("Y-m-d");

        $end         = date("Y-m-d 23:59:59");

        self::doing($start, $end);
    }

    /**
     * 递归调用获取可用的项目
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
            $results    = AutoInvestFullLogic::investFull($project['list']);

            \Log::info(__METHOD__, ['--AssetsPlatform——智投项目 自动投标失败结果：', $results]);

            if(!empty($results))
            {
                $emailContent = json_encode($results);
            }else{
                $emailContent = '没有检测到失败';
            }

            $emailModel    = new EmailModel();
            $receiveEmails = Config::get('email.monitor.assetsPlatform');

            $title         = '【notice】智投计划 超级用户自动投满' . env('APP_ENV');

            $emailModel->sendHtmlEmail($receiveEmails, $title, $emailContent);
        }
    }
}
