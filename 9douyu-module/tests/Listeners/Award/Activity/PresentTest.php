<?php

namespace Tests\Listeners\Award\Activity;
use App\Http\Dbs\Notice\NoticeDb;
use App\Http\Logics\Activity\ActivityPresentLogic;
use App\Http\Logics\Notice\NoticeLogic;
use App\Http\Models\Common\ServiceApi\SmsModel;

/**
 * Created by PhpStorm.
 * User: jinzhuotao
 * Date: 2017/8/31
 * Time: 下午7:45
 */
class PresentTest extends \TestCase
{
    /**
     * @return array
     * @desc 测试填充数据
     *       成功条件：投资额不小于1000元，只有一次投资记录（参加活动时投资的那次）
     */
    public function InvestData(){
        return [
            [
                'data' =>[
                    'cash'          =>  500,
                    'project_id'    =>  3794,
                    'invest_id'     =>  262015,
                    'user_id'       =>  1426160,
                    'act_token'     =>  '',
                    'project_line'  =>  100,
                    'bonus_id'      =>  0,
                ],
                'status' => false
            ],
            [
                'data' =>[
                    'cash'          =>  1000,
                    'project_id'    =>  3794,
                    'invest_id'     =>  262015,
                    'user_id'       =>  1426160,
                    'act_token'     =>  '',
                    'project_line'  =>  100,
                    'bonus_id'      =>  0,
                ],
                'status' => true
            ],
        ];

    }

    /**
     * @param $data
     * @dataProvider InvestData
     */
    public function testPresentActivity($data,$status){
        //获取后台配置-开关信息
        $auto       = ActivityPresentLogic::isAuto();
        //获取后台配置-活动时间信息
        $validTime  = ActivityPresentLogic::validActivityTime();

        if(!$auto){
            echo '自动发放开关-关闭';
            exit;
        }

        if(!$validTime){
            echo '不在活动时间';
            exit;
        }

        $return = $this->doImplementSendPresent($data,$status);

        if($return['status']){
            $this->doSendPhoneMessage($return['data']['phone']);
            $this->doSendNotice($return['data']['user_id']);
        }

    }

    /**
     * @param $data
     * @param $status
     * @return array
     * @desc 测试自动加币，成功后在零钱计划中增加金额
     */
    protected function doImplementSendPresent($data,$status){
        $result = ActivityPresentLogic::doImplementSendPresent($data) ;

        if($result['status']){
            $this->assertNotEmpty($result, $result['data']['phone']);
            $this->assertNotEmpty($result, $result['data']['user_id']);
        }
        print_r($result);
        $this->assertEquals($result['status'], $status);

        return $result;
    }

    /**
     * @param $phone
     * @desc 测试发送参加活动成功短信
     */
    protected function doSendPhoneMessage($phone){
        $message = ActivityPresentLogic::getPhoneMessage ();

        $return = SmsModel::sendNotice($phone,$message);

        $this->assertTrue($return['status']);
    }

    /**
     * @param $userId
     * @desc 测试发送消息
     */
    protected function doSendNotice($userId){
        $message = ActivityPresentLogic::getPhoneMessage ();

        $return = NoticeLogic::sendNoticeByType (NoticeDb::TYPE_ACTIVITY_CASH, $userId, $message, NoticeDb::TYPE_SYSTEM) ;

        $this->assertTrue($return['status']);
    }
}
