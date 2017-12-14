<?php

/**
 * Created by PhpStorm.
 * User: liuqiuhui
 * Date: 2017/12/9
 * Time: 上午9:59
 */
class ProjectBeforeTest extends TestCase
{

    public function caseData(){
        //291428	3995	132519	1000.00	2017-12-05 11:34:37	0	0	200			0	2017-12-08 18:40:00

        return [
            [
                'invest_id'     => 291428,
                'project_id'    => 3995,
                'user_id'       => 132519,
                'cash'          => 1000,
                'is_check'      => 1,
                'fee'           => 0,

            ],
            [
                'invest_id'     => 291428,
                'project_id'    => 3995,
                'user_id'       => 132519,
                'cash'          => 1000,
                'is_check'      => 0,
                'fee'           => 0,

            ]
        ];

    }

    /**
     * @param $data
     * @dataProvider caseData
     */
    public function testApplyBeforeRefund( $investId, $projectId, $userId, $cash, $isCheck, $fee ){

        $logic = new \App\Http\Logics\Refund\ProjectLogic();

        $result = $logic->assetsPlatformApplyBeforeRefund($investId, $projectId, $userId, $cash, $isCheck, $fee);

        var_dump($result);

    }

    public function caseDataI()
    {
        //291428	3995	132519	1000.00	2017-12-05 11:34:37	0	0	200			0	2017-12-08 18:40:00

        return [
            [
                ['3995' =>[
                    [
                        'invest_id'     => 291428,
                        'project_id'    => 3995,
                        'user_id'       => 132519,
                        'principal'     => 1000,
                        'interest'      => 200,
                        'cash'          => 1200,
                        'type'          => 0,
                        'assets_platform_sign' => '8888',
                        'refund_ticket' => 'a21',

                    ],
                    [
                        'invest_id'     => 291428,
                        'project_id'    => 3995,
                        'user_id'       => 132519,
                        'principal'     => 1000,
                        'interest'      => 200,
                        'cash'          => 1200,
                        'type'          => 0,
                        'assets_platform_sign' => '8888',
                        'refund_ticket' => 'a11',
                    ],
                    [
                        'invest_id'     => 291428,
                        'project_id'    => 3995,
                        'user_id'       => 132519,
                        'principal'     => 1000,
                        'interest'      => 200,
                        'cash'          => 1200,
                        'type'          => 0,
                        'assets_platform_sign' => '8888',
                        'refund_ticket' => 'a11',
                    ],
                ]
                ]
            ],

        ];

    }

    /**
    * @param $data
    * @dataProvider caseDataI
    */
    public function testApplyBeforeRefunds( $data ){

        $logic = new \App\Http\Logics\Refund\ProjectLogic();

        $result = $logic->assetsPlatformSplitProjectRefund($data, 1);

        print_r($result);

    }

}