<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssetsPlatFormTest extends TestCase
{

    /**
     * @desc 项目对应债权接口的数据供给
     * @return array
     */
    public function dataProjectCredit()
    {
        return [
            [
                [
                'projectNo' => '201712114840',
                'page' => 1,
                'size' => 10,
                ]
            ]
        ];
    }

    /**
     * @desc 测试返回项目对应债权[分页]的接口的信息
     * @param $projectCredit array
     * @dataProvider dataProjectCredit
     */
    public function testProjectCreditApi($projectCredit)
    {

        $result  = \App\Http\Models\Common\AssetsPlatformApi\ProjectCreditApiModel::getProjectCreditRelate($projectCredit)['data'];

        $this->assertArrayHasKey('header', $result);
        $this->assertArrayHasKey('body', $result);

        $this->assertEquals(0, $result['header']['resCode']);

        $this->assertArrayHasKey('totalCount', $result['body']);
        $this->assertArrayHasKey('projectCreditList', $result['body']);

        $this->assertCount((int)$result['body']['totalCount'], $result['body']['projectCreditList']);
    }

    /**
     * @desc 测试智投项目投资金额
     */
    public function testSmartInvestCash()
    {

        $data = [
            'user_id' => 258082,
            'project_id' => 3979,
            'cash' => '1190',
            'trading_pwd' => 'qwe123',
        ];
        $termLogic = new \App\Http\Logics\Invest\TermLogic();

        $return = $termLogic->doInvest($data['user_id'], $data['project_id'], $data['cash'], $data['trading_pwd']);

        $this->assertEquals('投资金额必须是100整数倍', $return['msg']);
    }
}
