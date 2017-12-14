<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/9/19
 * Time: 15:12
 */

namespace App\Events\User;


use App\Events\Event;
use App\Http\Models\Common\CoreApi\UserModel;
use Log;

class VerifySuccessEvent extends Event
{
    /**
     * @var array 传入event参数
     */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->data = $data['data'];

        Log::info('data：' . json_encode($this->data));
    }

    /**
     * @return array
     * @desc 获取用户信息
     */
    public function getUserInfo()
    {
        if( empty($this->data['user_id'])){
            return [];
        }

        return UserModel::getCoreApiUserInfo ($this->data['user_id']);
    }

}