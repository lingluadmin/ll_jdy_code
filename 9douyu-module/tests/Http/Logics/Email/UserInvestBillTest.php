<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Logics\Data\UserInvestBillLogic;
class UserInvestBillTest extends TestCase
{

    /**
     * @desc 类初始化数据供给
     * @return array
     */
    public function dataUserBill()
    {
        //配置信息
        $config = [
            'size' => 100,
            'view'  => 'email.userBill',
            'start_time' => '2017-05-01',
            'end_time'   => '2017-10-31',
            'user_list'  => [['user_id'=> 258082, 'email' => 'lin.guanghui@9douyu.com']],
        ];

        $userBill = new UserInvestBillLogic($config);

        return [
            [
                $userBill
            ]
        ];
    }

    /**
     * @desc 测试用户信息相关处理的相关信息
     * @param $userBill
     * @dataProvider dataUserBill
     * @return void
     */
    public function testUserList($userBill)
    {

        $userList = $userBill->setUserEmailList();


        $this->assertClassHasAttribute('user_list', UserInvestBillLogic::class);

        $this->assertNotEmpty($userList);

        $this->assertArrayHasKey('email', $userList[0]);

        $userIds = $userBill->setUserIds();

        $this->assertClassHasAttribute('user_ids', UserInvestBillLogic::class);

        $this->assertNotEmpty($userIds);

        $userChunk = $userBill->splitUserEmailList();

        $this->assertNotEmpty($userChunk);
    }

    /**
     * @desc 测试获取用户投资账单数据
     * @param $userBill  object
     * @dataProvider dataUserBill
     */
    public function testGetInvestBill($userBill)
    {
        $userBill->getUserInvestBill([258082]);

        $this->assertNotEmpty($userBill->invest_bill);

        $this->assertCount(1, $userBill->invest_bill);

        $this->assertArrayHasKey(258082, $userBill->invest_bill);

        $this->assertArrayHasKey('invest_list', $userBill->invest_bill[258082]);

        $userBill->formatInvestBillData();

        $this->assertNotEmpty($userBill->invest_bill);

        $this->assertArrayHasKey('email', $userBill->invest_bill[258082]);
    }

    /**
     * @desc 测试获取邮件blade模版数据
     * @param $userBill
     * @dataProvider dataUserBill
     */
    public function testGetTemplate($userBill)
    {
        $data = [
            'invest_info' =>[
                'invest_counts'=> 5,
                'total_amount'=> 189709.35,
                'total_interest'=> 543.55,
                'day_type_1'=> 1900,
                'day_type_2'=> 3000,
                'day_type_3'=> 2500,

            ],
            'invest_list' => [
                [
                    'name' => '九省心3月期',
                    'format_name' => '171108-2',
                    'profit_percentage' => '11',
                    'refund_type_note' => '到期还本息',
                    'created_at'  =>'2017-11-01',
                    'cash' => '20000',
                ],
                [
                    'name' => '九省心3月期',
                    'format_name' => '171108-2',
                    'profit_percentage' => '11',
                    'refund_type_note' => '到期还本息',
                    'created_at'  =>'2017-11-03',
                    'cash' => '20000',
                ]

            ],
            'refund_info' => [
                'refund_counts' => 6,
                'total_interest' => 1500.80,
                'total_principal' => 10000,
                'total_amount'  => 30000,
            ],
            'refund_list' => [
                [
                    'times' => '2017-03-09',
                    'name' => '九省心 3月期 171019-1',
                    'cash' => '1,254.96',
                    'current_periods' => '1',
                    'periods' => '3',
                    'type'   => '0',
                    'principal' => 0,
                ],
                [
                    'times' => '2017-04-09',
                    'name' => '九省心 3月期 171019-1',
                    'cash' => '1,254.96',
                    'current_periods' => '2',
                    'periods' => '3',
                    'type'   => '0',
                    'principal' => 100000,
                ],

            ],
            'email' =>['lin.guanghui@9douyu.com' => 'lin.guanghui@9douyu.com'],
            'date'=>'2017年十月11日'
        ];

        $template = $userBill->getHtmlTemplate($data);

        $this->assertNotEmpty($template);

        $this->assertContains('九斗鱼对账单', (string)$template);
    }
}
