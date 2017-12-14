<?php
/**
 * Created By Vim
 * User: linguanghui
 * Date: 17/09/20
 * Desc: 中秋国庆活动测试用例
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Logics\Activity\AutumnNationLogic;
use App\Http\Logics\Activity\CelebrationLoanLogic;
use App\Http\Models\Activity\AutumnNationModel;

class AutumnNationTest extends TestCase
{

    /**
     * @desc 用户是否登陆验证数据供给
     */
    public function checkBonusGetData()
    {
        return [
            [
              'user_id' => 258082,
              'msg'  => true,
            ],
            [
              'user_id' => 0,
              'msg' => '您还没有登陆, 请登录后参与活动',
            ]
            ];
    }


    /**
     * @desc 测试用户是否登陆
     * @dataProvider checkBonusGetData
     */
    public function testUserLogin($userId, $msg)
    {
        try{
            $return = AutumnNationModel::checkUserLogin($userId);
            $this->assertTrue($msg);
        }catch(\Exception $e){
            $this->assertEquals($e->getMessage(), $msg);
        }
    }

    /**
     * 检测活动时间周期数据供给
     */
    public function checkActivityTimeData()
    {
        return [
            [ true,
            [
             'start' => strtotime('2017-09-01'),
             'end'   => strtotime('2017-10-01'),
            ]
            ],
            [ '活动未开始',
            [
             'start' => strtotime('2017-09-26'),
             'end'   => strtotime('2017-10-21'),
            ]
            ],
            [ '活动已结束',
            [
             'start' => strtotime('2017-09-01'),
             'end'   => strtotime('2017-09-20'),
            ]
            ],
            ];

    }

    /**
     * @desc 测试活动时间
     * @dataProvider checkActivityTimeData
     */
    public function testActivityTime($msg, $activityTime)
    {
        try{
            $res = AutumnNationModel::checkActivityTime($activityTime);
            $this->assertTrue($msg);
        }catch(\Exception $e){
            $this->assertEquals($e->getMessage(), $msg);
        }

    }

    /**
     * @desc 检测领取的红包是否正确数据供给
     */
    public function checkBonusRightData()
    {
        return [
            [true ,245,
            [
             1=>245,
             2=>246,
             3=>247,
            ]
            ],
            ['领取红包失败，红包ID没有配置' ,244,
            [
             1=>245,
             2=>246,
             3=>247,
            ]
            ],
            [true ,248,
            [248,249,250,251,252]
            ],
            ['领取红包失败，红包ID没有配置' ,253,
            [248,249,250,251,252]
            ],
            ];
    }

    /**
     * @desc 检测领取的红包ID是否配置
     * @dataProvider checkBonusRightData
     */
    public function testBonusIdIfRight($msg, $bonusId, $bonusArr)
    {
        try{
            $res = AutumnNationModel::checkBonusIfRight($bonusArr, $bonusId);
            $this->assertTrue($msg);
        }catch(\Exception $e){
            $this->assertEquals($e->getMessage(), $msg);
        }

    }

    /**
     * @desc 今日量取中秋红包数据供给
     */
    public function bonusGetTodayData()
    {
        return [
            [
             'msg'=> true,
             'receivedNum' => 0,
            ],
            [
             'msg'=> '今天已经领取过红包了',
             'receivedNum' => 1,
            ],
            ];
    }

    /**
     * @desc 测试是否可以领取中秋红包
     * @dataProvider bonusGetTodayData
     */
    public function testCanGetBonusToday($msg, $receivedNum)
    {
        $config = [
            'DRAW_NUM_EVERY_DAY' => 1,
            'DRAW_CYCLE'  => 'day',
            ];
        try{
            $res = AutumnNationModel::checkIfCanGetBonusByDay($receivedNum, $config);
            $this->assertTrue($msg);
        }catch(\Exception $e){
            $this->assertEquals($e->getMessage(), $msg);
        }
    }

    /**
     * @desc 检测用户量取国庆优惠券和注册年限是否匹配数据供给
     */
    public function checkUserLevelData()
    {
        return [
            [
            'bonusId' => 246,
            'registerLevel' => 2,
            'msg' => true,
            ],
            [
            'bonusId' => 246,
            'registerLevel' => 4,
            'msg' => '您当前的等级不能领取红包',
            ],
            [
            'bonusId' => 245,
            'registerLevel' => 2,
            'msg' => '您当前注册年限和您选择要领取的红包不符',
            ],
            ];
    }

    /**
     * @desc 按照注册年限检测领取优惠券是否正确
     * @dataProvider checkUserLevelData
     */
    public function testGetBonusByLevel($bonusId, $registerLevel, $msg)
    {
        $bonusArr = [
             1=>245,
             2=>246,
             3=>247,
            ];
        try{
            $res = AutumnNationModel::checkRegisterLevelGetBonus($bonusArr, $bonusId, $registerLevel);
            $this->assertTrue($msg);
        }catch(\Exception $e){
            $this->assertEquals($e->getMessage(), $msg);
        }

    }

    /**
     * @desc 领取国庆红包数据供给
     */
    public function bonusGetTimesData()
    {
        return [
            [
             'msg'=> true,
             'receivedNum' => 0,
            ],
            [
             'msg'=> '活动期间您只可以领取1张优惠券',
             'receivedNum' => 1,
            ],
            ];
    }

    /**
     * @desc 测试是否可以领取国庆加息券
     * @dataProvider bonusGetTimesData
     */
    public function testCanGetBonusTimes($msg, $receivedNum)
    {
        $config = [
            'DRAW_NUMBER' => 1,
            ];
        try{
            $res = AutumnNationModel::checkIfCanGetBonusByTimes($receivedNum, $config);
            $this->assertTrue($msg);
        }catch(\Exception $e){
            $this->assertEquals($e->getMessage(), $msg);
        }
    }

    public function  testExample()
    {
        $autumnLogic = new AutumnNationLogic();
        $res1 = $autumnLogic->doGetNationBonus('',246);

        $res2 = $autumnLogic->doGetAutumnBonus(258082,249);
        dd($res1, $res2);
    }

}
