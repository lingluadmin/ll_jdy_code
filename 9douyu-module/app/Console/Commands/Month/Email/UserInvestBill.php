<?php

namespace App\Console\Commands\Month\Email;

use App\Http\Logics\Data\UserInvestBillLogic;
use Illuminate\Console\Command;

class UserInvestBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:invest-bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每个月3号发送用户投资账单邮件';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //配置信息
        $config  = [
            'size' => 100,
            'view'  => 'email.userBill',
            'start_time' => date('Y-m-01', strtotime('-1 month')),
            'end_time'   => date('Y-m-t 23:59:59', strtotime('-1 month')),
        ];

        $userBill = new UserInvestBillLogic($config);

        $userBill->setUserEmailList();

        $userBill->setUserIds();

        $splitUser  =  $userBill->splitUserEmailList();

        foreach ($splitUser as $item) {

            $userBill->getUserInvestBill($item);

            if (!empty($userBill->invest_bill)) {
                //格式化投资账单
                $userBill->formatInvestBillData();

                //推送队列
                $userBill->pushInvestBillJob();
            }
        }

    }
}
