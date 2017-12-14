<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/10/20
 * Time: 11:11
 */

namespace Tests\Listeners\Award\Activity;

use App\Http\Logics\Activity\LotteryLogic;

class LotteryTest extends \TestCase
{
    /**
     * @return array
     */
    public function lotteryData()
    {
        return [
            [
                'data' =>[
                    'activity_id'   =>  127 ,
                    'group_id'      =>  26 ,
                    'user_id'       =>  289946 ,
                ],
                'status'=> true
            ],
            [
                'data' =>[
                    'activity_id'   =>  127 ,
                    'group_id'      =>  26 ,
                    'user_id'       =>  1401030 ,
                ],
                'status'=> true
            ],
            [
                'data' =>[
                    'activity_id'   =>  127 ,
                    'group_id'      =>  26 ,
                    'user_id'       =>  1425350 ,
                ],
                'status'=> true
            ]
        ];
    }

    /**
     * @param $data
     * @param $status
     * @dataProvider lotteryData
     */
    public function testDoLottery($data, $status)
    {
        $lotteryLogic           =   new LotteryLogic();

        $return =    $lotteryLogic->doLuckDrawWithRate( $data );

        print_r ($return);

        $this->assertEquals ($return['status'], $status);
    }


}