<?php

namespace App\Listeners\Invest\ProjectSuccess;

use App\Events\CommonEvent;

use App\Http\Logics\Warning\WarningLogic;
use Log;

class SendEmailListener
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle   the event.
     *
     * @param   Invest/ProjectSuccessEvent  $event
     * @return  void
     * @desc    data 为二维数组，项目ID，剩余可投，投资金额，是否新手标
     *
     */
    public function handle(CommonEvent $event)
    {
        $data   = $event->getDataByKey('check_project_leftMoney');

        \Log::info(__METHOD__.' : '.__LINE__.' CHECK_PROJECT_LEFT_AMOUNT ', $data);

        WarningLogic::checkProjectLeftAmount( $data );

    }

}
