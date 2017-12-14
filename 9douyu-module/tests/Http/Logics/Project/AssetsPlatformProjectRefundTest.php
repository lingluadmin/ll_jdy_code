<?php

/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 2017/12/8
 * Time: 下午3:29
 */
class AssetsPlatformProjectRefundTest extends \TestCase
{
    public function createRefundData(){

        $subData = [];
        for($i = 1; $i<=100000; $i++) {
            $subData [] = [
                'invest_id'            => 336159,
                'user_id'              => 69,
                'project_id'           => 4017,
                'principal'            => 20000.00,
                'interest'             => 1.11,
                'cash'                 => 12.1,
                'type'                 => 0,
                'assets_platform_sign' => 'ztxm_1511858010',
                'times'                => '2017-11-30',
                'refund_ticket'        => str_random(10). $i,
            ];
        }

        $data = [
            $subData,
        ];

        return [
            $data
        ];

    }

    /**
     * @param $data
     * @dataProvider createRefundData
     */
    public function testDoCreateRefund( $data ){

        $count = count($data);
        $page  = $count/100;
        $result= [];
        for ($i = 1; $i <=$page; $i++) {
            $subData = array_slice($data, (100 * ($i - 1)), 100);
            $logic = new \App\Http\Logics\Project\ProjectLogic();
            $result[] = $logic->assetsPlatformCreateRefund($subData);

            echo print_r($result, true);
        }

    }


    public function caseDataI()
    {
        //291428	3995	132519	1000.00	2017-12-05 11:34:37	0	0	200			0	2017-12-08 18:40:00

        return [
            [
                [
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
            ],

        ];

    }

    /**
     * @param $data
     * @dataProvider caseDataI
     */
    public function testDoBeforeRefund( $data ){

        $logic   = new \App\Http\Logics\Project\ProjectLogic();
        $result = $logic->assetsPlatformCreateRefund($data, 1);

        echo print_r($result, true);

    }



}