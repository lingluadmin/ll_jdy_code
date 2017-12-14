<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/24/17
 * Time: 5:45 PM
 * Desc: 用户每月投资账单邮件发送
 */

namespace App\Http\Logics\Data;


use App\Http\Models\Common\CoreApi\UserModel;
use App\Http\Models\Common\ServiceApi\EmailModel;
use App\Http\Models\User\UserInfoModel;
use App\Jobs\Email\InvestBillJob;
use App\Tools\ToolArray;
use App\Tools\ToolTime;
use Closure;
use Illuminate\Support\Facades\View;

class UserInvestBillLogic
{

    /**
     * @var int 分批处理的数据大小
     */
    protected $size = 100;

    /**
     * @var string blade的模版的文件路径
     */
    protected $view;

    /**
     * @var string  blade模版的内容
     */
    protected $template;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string 开始时间
     */
    protected $start_time;

    /**
     * @var string 结束时间
     */
    protected $end_time;

    /**
     * @var string 上个月
     */
    protected $last_month;

    /**
     * @var array module填写邮箱的用户
     */
    protected $user_list;

    /**
     * @var array 填写邮箱用户的Id
     */
    protected $user_ids;

    /**
     * @var  string 用户的投资账单
     */
    public $invest_bill;

    /**
     * UserInvestBillLogic constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->last_month = date('Y年m月', strtotime('-1 month'));
        foreach ($config as $property => $value) {

            if (property_exists($this, $property)) {
                $this->$property = $value;
            }

        }
    }

    /**
     * @desc 设置用户邮箱信息属性
     * @return array
     */
    public function setUserEmailList()
    {
        $this->user_list = UserInfoModel::getUserEmailList();

        return $this->user_list;
    }

    /**
     * @desc 设置用户的id的列表属性
     * @return array
     */
    public function setUserIds()
    {
        $this->user_ids = !empty($this->user_list) ? ToolArray::arrayToIds($this->user_list, 'user_id') : [];

        return $this->user_ids;
    }

    /**
     * @desc 分割用户数据信息
     * @return array
     */
    public function splitUserEmailList()
    {
        return array_chunk($this->user_ids, $this->size);
    }

    /**
     * @desc 获取用户的投资账单数据
     * @param $userIds array|string
     * @return array|null|void
     */
    public function getUserInvestBill($userIds)
    {

        $this->invest_bill = UserModel::getUserInvestBill($userIds, $this->start_time, $this->end_time);

    }

    /**
     * @desc 格式化投资账单，关联用户邮箱
     * @return array|string
     */
    public function formatInvestBillData()
    {
        $investBillData = [];

        if (empty($this->invest_bill)) {
            return $investBillData;
        }

        $this->user_list = ToolArray::arrayToKey($this->user_list, 'user_id');

        foreach ($this->invest_bill as $userId => $item) {
            if (isset($this->user_list[$userId])) {
                $this->invest_bill[$userId]['email'] = [$this->user_list[$userId]['email'] => $this->user_list[$userId]['email']];
            }
        }
    }

    /**
     * @desc 推送投资账单数据入Job
     */
    public function pushInvestBillJob()
    {
        $res = \Queue::pushOn('default', new InvestBillJob($this->invest_bill));

        if (!$res) {
            \Log::Error(__METHOD__."push investbillData Error", $this->invest_bill);
        }
    }

    /**
     * @desc 获取要发送的邮件的blade模版
     * @param  $data array
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHtmlTemplate(array $data = [])
    {
        $this->template = View::exists($this->view) ? view($this->view, ['data' => $data]) : '';

        return $this->template;
    }


    /**
     * @desc 发送投资账单执行的邮件
     * @param $investBill
     */
    public function sendEmail($investBill)
    {
        $email = new EmailModel();

        foreach ($investBill as $userId => $item) {

            $item['date'] = $this->last_month;

            $this->getHtmlTemplate($item);

            $result = $email->sendHtmlEmail($item['email'], '九斗鱼'.$this->last_month.'用户投资账单', $this->template);

            if ($result['status'] == true) {
                \Log::info('用户ID为'.$userId.'的'.$this->last_month.'投资账单邮件发送成功', $item['email']);
            } else {
                \Log::Error('用户ID为'.$userId.'的'.$this->last_month.'投资账单邮件发送失败', $item['email']);
            }
        }
    }

}
