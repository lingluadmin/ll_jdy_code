<?php

/**
 * Created by PhpStorm.
 * User: liuqiuhui
 * Date: 2017/12/7
 * Time: 下午6:55
 */
class InvestTest extends TestCase
{

    /**
     * @desc 数据供给
     * @return array
     */
    public function dataProvider(){

        return
            [
                [
                    [
                        ['invest_id'             => '291428',
                        'user_id'               => '132519',
                        'project_id'            => '3995',
                        'cash'                  => '1000.00',
                        'assets_platform_sign'  => '8888']

                    ]
                ]
            ];

    }

    /**
     * @param $project_ids
     * @dataProvider dataProvider
     */
    public function testUpdateIsMatch($data){

        $investLogic = new \App\Http\Logics\Invest\InvestLogic();

        $return = $investLogic->doUpdateInvestRecordIsMatch($data);

        print_r($return);
    }


}