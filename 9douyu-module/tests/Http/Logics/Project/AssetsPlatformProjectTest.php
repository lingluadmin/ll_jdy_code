<?php
/**
 * Created by PhpStorm.
 * User: liu.qiuhui
 * Date: 17/11/28
 * Time: 16:34 Pm
 */


class AssetsPlatformProjectTest extends TestCase
{

    public function createProjectData(){

        return [
            [
                [
                    'total_amount' => 20000,
                    'invest_time'  => 30,
                    'invest_days'  => 1,
                    'refund_type'  => 10,
                    'product_line' => 400,
                    'base_rate'    => 10,
                    'after_rate'   => 1.3,
                    'end_at'       => '2017-12-28',
                    'category'     => 8,
                    'assets_platform_sign' => 'zc_'.time(),
                ],
            ],
        ];

    }

    /**
     * @param $data
     * @dataProvider createProjectData
     */
    public function testDoCreateProject( $data ){

        $logic = new \App\Http\Logics\Project\ProjectLogic();

        $result = $logic -> assetsPlatformCreateProject($data);

        var_dump($result);

    }

    /**
     * @desc 数据供给
     * @return array
     */
    public function dataProvider(){

        return
            [
                [
                    [
                        [   'invest_id'             => '291428',
                            'user_id'               => '132519',
                            'project_id'            => '3995',
                            'cash'                  => '1000.00',
                            'assets_platform_sign'  => '8888'
                        ],
                        [   'invest_id'             => '291424',
                            'user_id'               => '132519',
                            'project_id'            => '3995',
                            'cash'                  => '1000.00',
                            'assets_platform_sign'  => '8888'
                        ],

                    ]
                ]
            ];

    }

    /**
     * @param $project_ids
     * @dataProvider dataProvider
     */
    public function testUpdateIsMatch($data){

        $investLogic = new \App\Http\Logics\Project\ProjectLogic();

        $return = $investLogic->assetsPlatformMatchInvest($data);

        print_r($return);
    }

    public function caseData(){
        //291428	3995	132519	1000.00	2017-12-05 11:34:37	0	0	200			0	2017-12-08 18:40:00

        return [
            [
                'invest_id'     => 291428,
                'project_id'    => 3995,
                'user_id'       => 132519,
                'cash'          => 1000,
                'tradepwd'      => 'qwe123',
                'fee'           => 0,
                //'is_check'      => 1,


            ],
            /*[
                'invest_id'     => 291428,
                'project_id'    => 3995,
                'user_id'       => 132519,
                'cash'          => 1000,
                'tradepwd'      => 'qwe123',
                'fee'           => 0,
                'is_check'      => 0,

            ]*/
        ];

    }

    /**
     * @param $data
     * @dataProvider caseData
     */
    public function testApplyBeforeRefund($investId, $projectId, $userId, $cash, $tradePassword, $fee ){

        $logic = new \App\Http\Logics\Project\ProjectSmartLogic();

        $result = $logic->doInvestBeforeRefundApply($investId, $userId, $projectId, $cash, $tradePassword, $fee);

        var_dump($result);

    }



}
