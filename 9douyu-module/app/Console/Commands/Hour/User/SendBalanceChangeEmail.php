<?php
/**
 * Created By PhpStorm
 * User: linguanghui
 * Date: 2017-11-16
 * Desc: 定时每小时发送用户余额操作统计邮件
 */

namespace App\Console\Commands\Hour\User;

use App\Tools\ToolTime;
use Illuminate\Console\Command;
use App\Http\Logics\Data\OperateUserBalanceLogic;

class SendBalanceChangeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendBalanceChangeEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每个小时发送活动资金明细统计邮件[纪录操作用户账户余额纪录]';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $operateLogic = new OperateUserBalanceLogic();

        $operateLogic->sendOperateBalanceData();
    }
}
