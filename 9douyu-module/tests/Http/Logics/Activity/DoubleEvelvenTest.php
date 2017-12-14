<?php
/**
 * Created by PHPStrom
 * User: linguanghui
 * Date: 2017/10/19
 * Desc: 2017年双十一活动测试用例
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class DoubleEvelven extends TestCase
{

    /**
     * @desc 签到数据供给
     * @author linguanghui
     * @return array
     */
    public function signData()
    {
        return [
            [
                'data' => [],
                'msg' => \App\Lang\LangModel::ERROR_ACTIVITY_PARAM_NULL,
            ],
            [
                'data' => ['user_id' => 0],
                'msg' => '您还没有登录, 请登录后参与活动',
            ],
            [
                'data' => ['user_id' => 258082, 'type'=> \App\Http\Dbs\Activity\ActivityFundHistoryDb::SOURCE_ACTIVITY_DOUBLE_ELEVEN],
                'msg' => '成功',
            ],
        ];
    }

    /**
     * @desc 测试签到流程逻辑
     * @param $data
     * @param $msg
     * @dataProvider signData
     *
     */
    public function testDoSign($data, $msg)
    {

        $doubleElevenLogic = new \App\Http\Logics\Activity\DoubleElevenLogic();

        $result = $doubleElevenLogic->doSign($data);

        //print_r($result);
        #$this->assertEquals($result['msg'], $msg);
    }

    /**
     * @desc 分享数据设置
     * @return array
     */
    public function shareData()
    {
        $phone = '15501191752';
        $code = md5($phone.App\Tools\ToolTime::dbDate());

        return [
            [
              'data' => [
                'user_id' => 1400729,
                'note' => '双十一活动,奖励加币',
                ],
            ],
            [
              'data' => [
                'user_id' => 258082,
                'note' => '双十一活动,奖励加币',
                ],
            ],
            ];

    }

    /**
     * @desc 测试活动分享功能
     * @param $data
     * @dataProvider shareData
     */
    public function testShare($data)
    {
        $doubleElevenLogic = new \App\Http\Logics\Activity\DoubleElevenLogic();
        $cash = $doubleElevenLogic->getRandShareMoney();
        $data['cash'] = $cash;
        $result = $doubleElevenLogic->doShareSuccess($data);
    //    print_r($result);

        $period = $doubleElevenLogic->getSignDateList('d');
     //   print_r($period);

        $signData = $doubleElevenLogic->setUserSignData($data['user_id']);
      //  print_r($signData);
    }


    /**
     * @desc 测试充值红包信息
     */
    public function testRechargeBonusConfig(){

        echo '获取红包的配置信息'.PHP_EOL;
        $bonusConfig = \App\Http\Logics\Activity\DoubleElevenLogic::getRechargeBonusConfig();
        print_r($bonusConfig);

        echo '获取红包雨的红包列表'.PHP_EOL;
        $bonusRainList = \App\Http\Logics\Activity\DoubleElevenLogic::setBonusRainList(258082);
        print_r($bonusRainList);

        echo '获取用户的获取的红包list'.PHP_EOL;
        $userGetBonus = \App\Http\Logics\Activity\DoubleElevenLogic::getUserGetBonus(258082);
        print_r($userGetBonus);

        echo '获取用户的净充值金额'.PHP_EOL;
        $netRecharge = \App\Http\Logics\Activity\DoubleElevenLogic::getUserNetRecharge(258082);
        echo $netRecharge.PHP_EOL;


        echo '测试用户的净充值等级'.PHP_EOL;
        $rechargeLevel = \App\Http\Logics\Activity\DoubleElevenLogic::getNetRechargeLevel(0);
        echo $rechargeLevel.PHP_EOL;

        echo '测试获取红包的配置等级'.PHP_EOL;
        $bonusLevel =  \App\Http\Logics\Activity\DoubleElevenLogic::getBonusLevel(265);
        print_r($bonusLevel).PHP_EOL;
    }

    /**
     * @desc 充值领红包数据供给
     */
    public function rechargeBonusData()
    {
        return [
            [
            'data' => [
                'user_id' => '258082',
                'bonus_id' => '265',
                'bonus_cash' => '60',
                'level' => '1',
                ]
            ],
            [
            'data' => [
                'user_id' => '258082',
                'bonus_id' => '266',
                'bonus_cash' => '100',
                'level' => '2',
                ]
            ],
            [
            'data' => [
                'user_id' => '258082',
                'bonus_id' => '267',
                'bonus_cash' => '200',
                'level' => '3',
             ]
            ],
            [
            'data' => [
                'user_id' => '258082',
                'bonus_id' => '268',
                'bonus_cash' => '300',
                'level' => '4',
             ]
            ],
            ];

    }
    /**
     * @desc 测试领取红包
     * @dataProvider rechargeBonusData
     */
    public function testGetBonus($data)
    {
        echo '测试红包的领取操作'.PHP_EOL;
        $doubleElevenLogic = new \App\Http\Logics\Activity\DoubleElevenLogic();

        $result = $doubleElevenLogic->doGetRechargeBonus($data);

        print_r($result);

    }
}
