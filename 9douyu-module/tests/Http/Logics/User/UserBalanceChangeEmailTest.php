<?php

/**
 * created by Vim
 * User: linguanghui
 * Date: 2017-11-16
 * Desc: 测试所有调用用户加币方法的接口，测试邮件发送是否为预期设想
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\Common\CoreApi\UserModel;

class UserBalanceChangeEmailTest extends TestCase
{
    /**
     * @desc 用户加币操作数据供给
     */
    public function userIncBalanceData()
    {
        $userData = [
            [
                'data' => [
                    'user_id' => 258082,
                    'cash' => 100,
                    'trading_password' => 'lin189491',
                    'note' => '加钱操作',
                    'ticket_id' => \App\Tools\ToolStr::getRandTicket(),
                    'event_id' => '',
                    'admin' => '系统操作',
                ],
            ]
        ];
        return $userData;
    }

    /**
     * @param $data
     * @desc 测试管理后台用户加钱操作发送邮件，活动加币操作不发送邮件
     * @dataProvider userIncBalanceData
     */
    public function testAdminIncBalanceCall($data)
    {
        //发送
        UserModel::doIncBalance($data['user_id'], $data['cash'], $data['trading_password'], $data['note'], \App\Tools\ToolStr::getRandTicket(), '', 14);

        //不发送邮件
        UserModel::doIncBalance($data['user_id'], $data['cash'], $data['trading_password'], $data['note'], \App\Tools\ToolStr::getRandTicket(), '', $data['admin']);
    }
}
