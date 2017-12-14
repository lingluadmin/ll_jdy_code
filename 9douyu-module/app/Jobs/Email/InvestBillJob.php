<?php

namespace App\Jobs\Email;

use App\Http\Logics\Data\UserInvestBillLogic;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvestBillJob extends Job
{

    protected $investBill = [];

    /**
     * Create a new job instance.
     * @param $data array
     * @return void
     */
    public function __construct(array $data)
    {
        $this->investBill = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO 投资账单发送邮件
        $investBill = new UserInvestBillLogic(['view' => 'email.userBill']);

        $investBill->sendEmail($this->investBill);
    }
}
