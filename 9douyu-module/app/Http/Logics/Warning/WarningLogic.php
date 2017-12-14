<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 2016/12/2
 * Time: 上午11:17
 * Desc: 系统报警
 */

namespace App\Http\Logics\Warning;
use App\Http\Dbs\SystemConfig\SystemConfigDb;
use App\Http\Logics\Data\DataStatisticsLogic;
use App\Http\Logics\Logic;
use App\Http\Models\Common\ServiceApi\EmailModel;
use App\Http\Models\Common\ServiceApi\SmsModel;

class WarningLogic extends Logic{

    const   TYPE_EMAIL = 1, //邮件
            TYPE_PHONE = 2; //短信


    /**
     * @param $key
     * @return array
     * @desc 通过key获取配置信息
     */
    public static function getConfigDataByKey($key)
    {
        $db  = new SystemConfigDb();
        $res = $db->getConfig($key);
        if( !empty($res) ){

            $res['value']   = unserialize($res['value']);
            $res['second_des'] = unserialize($res['second_des']);

        }

        return $res;
    }


    /**
     * @param $phones
     * @param $title
     * @return bool
     * @desc 发送短信报警,如果失败,则持续报警,直至成功
     */
    public static function doSmsWarning($title){

        $logic = new DataStatisticsLogic();

        $phones = $logic->getMailTaskEmailConfig('systemWarning');

        if( empty($phones) ){

            return false;

        }

        $item = '';

        foreach ($phones as $v){

            $item[] = $v;

        }

        $result = SmsModel::sendNotice($item, $title);

        if( !$result['status'] ){

            \Log::Error(__METHOD__.'Error', [$title]);

            //self::doSmsWarning($title);

        }


    }

    /**
     * @param   $configData
     * @param   $data
     * @desc    执行发送
     */
    public static function doSendEmail($configData, $data,$attachment = [])
    {

        if(isset($configData['value']['RECEIVE']) && !empty($configData['value']['RECEIVE'])){

            $receiveList = $configData['value']['RECEIVE'];

            $receiveList = explode('|', $receiveList);

            foreach ($receiveList as $value){

                $receiveList = explode(',', $value);

                $email[$receiveList[0]] = $receiveList[1];

            };
            if( $configData['value']['TYPE'] == self::TYPE_EMAIL ){

                $emailModel = new EmailModel();
                $result = $emailModel->sendHtmlEmail($email, $data['title'], $data['subject'],$attachment);

                if( !$result['status'] ){

                    \Log::Error(__METHOD__.'doSendError', [json_encode($data)]);

                }

            }

            return $result;

        }


    }


    /**
     * @desc    检测项目剩余可投金额，发送邮件
     *
     **/
    public static function checkProjectLeftAmount( $data ){
        if( !empty($data) ){
            $projectId  = $data["project_id"];
            $left_amount= $data["left_amount"];
            $invest_cash= $data["invest_cash"];
            $pledge     = $data["pledge"];

            $key    = 'PROJECT_CHECK_LEFT_AMOUNT_'.$projectId;
            $expire = 180;

            $cacheV = \Cache::get($key);

            if( !$cacheV ){
                if($pledge == 1) {
                    // 新手标
                    #获取邮件接收者
                    $configData = WarningLogic::getConfigDataByKey('NOVICE_PROJECT_CHECK');
                    if (isset($configData['value']['RECEIVE']) && !empty($configData['value']['RECEIVE'])) {
                        $amount = !empty($configData['value']['AMOUNT']) ? $configData['value']['AMOUNT'] : 10000;

                        if (($left_amount - $invest_cash) > 0 && ($left_amount - $invest_cash) <= $amount) {

                            if (env("APP_ENV") == "production") {
                                $domain = env("APP_URL_PC_HTTPS");
                            } else {
                                $domain = env("APP_URL_PC");
                            }
                            $url = $domain . "/project/detail/" . $projectId;

                            $sendMsg = "[项目可投余额不足] 项目ID：" . $projectId . " 剩余可投金额 " . ($left_amount - $invest_cash) . "元 \n" . " 项目链接：" . $url;

                            $arr['subject'] = $sendMsg;

                            $arr['title'] = "[项目可投余额不足] 项目ID：" . $projectId;

                            WarningLogic::doSendEmail($configData, $arr);

                            \Cache::put($key, 1, $expire);
                        }
                    }
                }

            }

        }

    }

}