<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/28/17
 * Time: 11:41 AM
 * Desc: 用户投资账单Class类
 */

namespace App\Http\Logics\User;


use App\Http\Logics\Invest\InvestLogic;
use App\Http\Logics\Refund\RefundRecordLogic;
use App\Http\Models\Invest\InvestModel;
use App\Http\Models\Refund\ProjectModel;
use App\Tools\ToolArray;
use App\Tools\ToolTime;

class InvestBillLogic extends InvestLogic
{

    const DAY_TYPE_1 = 20;
    const DAY_TYPE_2 = 90;
    const DAY_TYPE_3 = 365;


    /**
     * @var string 用户id
     */
    protected $user_ids;

    /**
     * @var string 开始时间
     */
    protected $start_time;

    /**
     * @var string 截止时间
     */
    protected $end_time;

    /**
     * @var array 投资详情
     */
    protected $invest_info;

    /**
     * @var array 投资列表
     */
    protected $invest_list;

    /**
     * @var array 回款详情
     */
    protected $refund_info;

    /**
     * @var array 回款列表
     */
    protected $refund_list;

    /**
     * @var string 投资项目天数类型
     */
    protected $day_type_key;

    /**
     * @var array 投资账单
     */
    public $invest_bill;


    /**
     * InvestBillLogic constructor.
     * @param array $requests
     */
    public function __construct(array $requests)
    {
        foreach($requests as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        if (!is_array($this->user_ids) && !empty($this->user_ids)) {
            $this->user_ids = explode(',', $this->user_ids);
        }
    }


    /**
     * @desc 获取用户投资账单的投资数据
     */
    public function getUserInvestData()
    {
        $invest = InvestModel::getUserInvestBill($this->user_ids, $this->start_time, $this->end_time);

        foreach ($invest as $property => $value) {

            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        if (!empty($this->invest_info)) {
            $this->invest_info = ToolArray::arrayToKey($this->invest_info, 'user_id');
        }

        return $this;
    }

    /**
     * @desc 格式化投资的数据
     */
    public function formatUserInvestData()
    {
        $investList =  $list =  [];
        $investLogic  = new InvestLogic();

        if (!empty($this->invest_list)) {

            foreach ($this->invest_list as $key => $value) {

                $investDays = ToolTime::getDayDiff($value['publish_at'], $value['end_at']);

                $this->setInvestDayType($investDays);

                if (isset($this->invest_info[$value['user_id']][$this->day_type_key])) {
                    $this->invest_info[$value['user_id']][$this->day_type_key] += $value['cash'];
                } else {
                    $this->invest_info[$value['user_id']][$this->day_type_key] = $value['cash'];
                }


                $investList[$key] = $investLogic->formatUserInvestRecord($value);
            }

            //用户分组处理
            $this->invest_list = ToolArray::arrayToKey($investList, 'user_id', true);

            foreach ($this->invest_list as $userId => $data) {

                $list[$userId]['invest_list'] = $data;

                if (isset($this->invest_info[$userId])) {
                    $list[$userId]['invest_info'] = $this->invest_info[$userId];
                }
            }

            $this->invest_list = $list;
        }

    }

    /**
     * @desc 设置投资天数的类型
     * @param $investDays
     */
    public function setInvestDayType($investDays)
    {

        switch ($investDays) {
            case $investDays >= self::DAY_TYPE_1 && $investDays < self::DAY_TYPE_2:
                $this->day_type_key = "day_type_1";
                break;

            case $investDays >= self::DAY_TYPE_2 && $investDays < self::DAY_TYPE_3:
                $this->day_type_key = 'day_type_2';
                break;

            case $investDays >= self::DAY_TYPE_3:
                $this->day_type_key = 'day_type_3';
                break;
        }
    }


    /**
     * @desc 获取用户投资账单的回款数据
     */
    public function getUserRefundData()
    {
        $refund  = ProjectModel::getInvestBillRefundData($this->user_ids, $this->start_time, $this->end_time);

        foreach ($refund as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        if (!empty($this->refund_info)) {
            $this->refund_info = ToolArray::arrayToKey($this->refund_info, 'user_id');
        }

        return $this;
    }

    /**
     * @desc 格式化用户的回款数据
     */
    public function formatUserRefundData()
    {
        $dataList = [];
        $refundLogic = new RefundRecordLogic();

        if (!empty($this->refund_list)) {
            $this->refund_list = $refundLogic->formatList($this->refund_list);


            $this->refund_list = ToolArray::arrayToKey($this->refund_list, 'user_id', true);

            foreach ($this->refund_list as $userId => $list) {
                if (isset($this->refund_info[$userId])){
                    $dataList[$userId]['refund_info'] = $this->refund_info[$userId];
                }
                $dataList[$userId]['refund_list'] = $refundLogic->formatRefundRecordData( $refundLogic->formatUserRefundPeriods($userId, $list) );
            }

            $this->refund_list = $dataList;
        }
    }

    /**
     * @desc 合并用户投资账单数据
     */
    public function mergeInvestBill()
    {
        $investBill = [];

        foreach ($this->invest_list as $userId => $item) {
            $investBill[$userId] = $item;
        }

        foreach ($this->refund_list as $userId => $item) {

            if (isset($investBill[$userId])) {
                $investBill[$userId] += $item;
            } else {
                $investBill[$userId] = $item;
            }
        }

        $this->invest_bill = $investBill;
    }

}