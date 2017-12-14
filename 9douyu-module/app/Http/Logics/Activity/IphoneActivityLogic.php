<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/9/20
 * Time: 13:45
 */

namespace App\Http\Logics\Activity;


use App\Http\Dbs\Activity\ActivityFundHistoryDb;
use App\Http\Dbs\Activity\LotteryRecordDb;
use App\Http\Dbs\Media\InviteDb;
use App\Http\Logics\Activity\Common\ActivityLogic;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic;
use App\Http\Logics\User\SessionLogic;
use App\Http\Models\Common\CoreApi\UserModel;
use App\Http\Models\Order\PhoneTrafficModel;
use App\Tools\ToolStr;
use App\Tools\ToolTime;

class IphoneActivityLogic extends ActivityLogic
{

    protected  $user    =   [] ;
    protected  $config  =   [] ;
    protected  $showUser=   [];

    const
        DEFAULT_CHANNEL =   '1423582',    //默认的的渠道号，上线的时候要根据实际配置的渠道号进行更新，FUCK
        LOTTERY_RECORD_KEY  =   'iphone8_lottery_record',


        END =   true ;

    public function __construct ()
    {
        $this->config   =   self::config ();
    }

    /**
     * @return array
     * @desc 活动时间点
     */
    public  function setTime()
    {
        return self::getTime( $this->config['START_TIME'] , $this->config['END_TIME'] );
    }
    /**
     * @desc  设置当前活动的act_token
     */
    public  function getActToken()
    {
        return   time() . '_' . self::setEventId() ;
    }
    /**
     * @return mixed
     * @desc 中奖记录
     */
    public function getLotteryList()
    {
        $cacheKey   =   self::LOTTERY_RECORD_KEY;

        $recordList =   \Cache::get($cacheKey);
        if( !empty($recordList) ){
            return json_decode($recordList, true);
        }
        $recordLogic        =   new  LotteryRecordLogic();

        $connection         =   [
            'start_time'    =>  date('Y-m-d H:i:s' , $this->config['START_TIME']),
            'end_time'      =>  date('Y-m-d H:i:s' , $this->config['END_TIME']),
            'activity_id'   =>  self::setEventId (),
            'limit'         =>  30 ,

        ];
        $recordList =     $recordLogic->getRecordByConnection( $connection );

        if( $recordList['lotteryNum'] > 0){
           \Cache::put($cacheKey , json_encode($recordList) ,60) ;
        }
        return  $recordList ;
    }
    //weixin('{{ $shareConfig['share_title'] }}','{{ $shareConfig['line_link'] }}','{{ $shareConfig['img_url'] }}','{{ $shareConfig['desc_content'] }}');
    public function getShareInfo()
    {
        return [
            'share_title'   =>  '护住你的肾，九斗鱼送iPhone8啦！',
            'line_link'     =>  env ('APP_URL_WX_HTTPS') . '/activity/iphone8',
            'img_url'       =>  assetUrlByCdn('/static/weixin/activity/iphone8/images/i8.png'),
            'desc_content'  =>  '我在九斗鱼抽中了iPhone8，有奖同享，你也快来抽奖吧',
        ];
    }
    /**
     * @param $userId
     * @return array
     * @desc search user register from media invite
     */
    public  function getUserInviteFromChannel($userId)
    {
        $userInvite =   (new InviteDb())->getInviteByUserId ($userId) ;

        return isset($userInvite['channel_id']) ? $userInvite['channel_id'] : '';
    }

    /**
     * @return array
     * @desc return page get information
     */
    public function getUserInformation($userId)
    {
        $lottery    =   $this->getUserOneLotteryInfo($userId);
        $awardName  =   isset($lottery['award_name']) ? $lottery['award_name'] : '' ;
        $phone      =   isset($lottery['phone']) ? ToolStr::hidePhone ($lottery['phone'],3,4) : '';
        return [
            'award_name'=>  $awardName,
            'phone'     =>  $phone,
        ];
    }
    /**
     * @param Common\timestamp $startTime
     * @param Common\timestamp $endTime
     * @param Common\activity_id $eventId
     * @param Common\user|int $userId
     * @return array|int|mixed
     * @desc 获取用户抽奖数据
     */
    public function getUserOneLotteryInfo ($userId)
    {
        if( empty($userId) ){
            return [];
        }
        $recordLogic    =   new LotteryRecordLogic();

        $params =   [
            'start_time'    =>  date ("Y-m-d H:i:s" ,$this->config['START_TIME']),
            'end_time'      =>  date ("Y-m-d H:i:s" ,$this->config['END_TIME']),
            'user_id'       =>  $userId,
            'activity_id'   =>  self::setEventId (),
            //'status'        =>  LotteryRecordDb::LOTTERY_STATUS_NOT_AUDITED,
        ];

        return  $recordLogic->getOneRecordByParams($params);
    }

    /**
     * @return array
     * @desc 执行抽奖的程序
     */
    public function doLuck($userId)
    {
        $lottery    =    $this->doLotteryDraw($userId, $this->getGroupId (), $this->setEventId());

        if( $lottery['status'] == true ){
            return array_merge ($lottery['data'], $this->getUserInformation ($userId)) ;
        }
        return $lottery ;
    }
    /**
     * @desc 活动的状态
     */
    public  function validActivityStatus($userId =0)
    {

        $showUser   =   $this->getUserInformation ($userId);
        //活动状态
        $activity = parent::isCanJoinActivity ($this->config['START_TIME'], $this->config['END_TIME'], self::setEventId (), $userId);
        if ($activity['status'] == false) {
            $activity['user']   =   $showUser;
            return $activity;
        }
        //用户的注册条件
        $registerTime = $this->isRegisterInActivityTime ($userId);
        if ($registerTime['status'] == false) {
            $registerTime['user']   =   $showUser;
            return $registerTime;
        }

        $channel    =    $this->isRegisterInActivityChannel ($userId);

        if ($channel['status'] == false ) {
            $channel['user']   =   $showUser;
        }
        //return self::callSuccess ();
        return $channel;
    }

    /**
     * @return array|int|mixed
     * @desc 用户的奖品状态
     */
    public function validUserLotteryStatus($userId)
    {
        $showUser   =   $this->getUserInformation ($userId);
        //兑奖的状态
        $traffic    =   $this->getPhoneTrafficExchange ($userId);
        if( $traffic['status'] == false ){
            $traffic['user']   =   $showUser;
            return $traffic ;
        }
        $verify     =   $this->verifyStatus ($userId);
        if( $verify['status'] == false ){
            $verify['user']   =   $showUser;
            return $verify ;
        }

        $lottery    =   $this->validUserOneLotteryInfo ($userId);
        if( $lottery['status'] == false ) {
            $lottery['user']   =   $showUser;
            return $lottery ;
        }
        return self::callSuccess ();
    }

    /**
     * @param array $user
     * @return array|false|int
     * @desc 获取用户的注册时间
     */
    private  function getUserRegisterTime($userId)
    {
        $user   =    UserModel::getCoreApiUserInfo ($userId);

        return ToolTime::getUnixTime ($user['created_at'] , '');
    }

    /**
     * @param $user
     * @return array
     * @desc 判断用户是否在活动时间内注册
     */
    public function isRegisterInActivityTime($userId)
    {
        $serRegisterTime =  self::getUserRegisterTime($userId);

        if( $serRegisterTime > $this->config['END_TIME'] || $serRegisterTime < $this->config['START_TIME'] ) {

            return self::callError('活动时间内注册的用户',self::CODE_ERROR,[ 'type'=>'oldUser' ] );
        }

        return self::callSuccess ();
    }

    /**
     * @return array
     * @desc 判断是否在活动页面
     */
    public function isRegisterInActivityChannel($userId)
    {
        $userInvite =   $this->getUserInviteFromChannel($userId);

        if( empty($userInvite) ) {
            \Log::info('invite_info' ,['notInActivity']);
            return self::callError('不是活动页面注册的用户',self::CODE_ERROR,[ 'type'=>'notInActivity' ] );
        }

        if( !in_array ($userInvite, $this->getChannel() )  ) {
            \Log::info('invite_info' ,['notInActivity2']);
            return self::callError('不是活动页面注册的用户',self::CODE_ERROR,[ 'type'=>'notInActivity' ] );
        }

        return self::callSuccess ();
    }


    /**
     * @return array
     * @desc valid lottery
     */
    public function validUserOneLotteryInfo($userId)
    {
        if( !empty($this->getUserOneLotteryInfo($userId)) ){

            return self::callError('已经参与了抽奖，实名兑奖！',self::CODE_ERROR,[ 'type'=>'hasRecord' ] );
        }

        return self::callSuccess () ;
    }

    /**
     * @return array
     * @desc 获取用户在活动时间内是否存在兑换的记录
     */
    public function getPhoneTrafficExchange($userId)
    {
        $return     =   PhoneTrafficModel::getPhoneTrafficList ($userId, date ('Y-m-d H:i:s', $this->config['START_TIME']), date ('Y-m-d H:i:s', $this->config['END_TIME']), self::setEventId ()) ;

        if( !empty($return) ) {

            return self::callError('已经兑换过',self::CODE_ERROR,[ 'type'=>'haveTraffic'] );
        }
        return self::callSuccess ();
    }
    /**
     * @return array
     * @desc 验证用户的实名状态
     */
    private  function verifyStatus($userId=0)
    {
        $user = $this->getUser ($userId);

        if( !empty($user["real_name"]) ) {

            return self::callError('已经参与过本次活动！',self::CODE_ERROR,[ 'type'=>'verify' ] );
        }

        return self::callSuccess ([ 'type'=>'verify' ]);
    }

    /**
     * @return array
     * @desc 用来限制渠道的用户的信息
     */
    private  function getChannel()
    {
        if( empty($this->config['CHANNEL_TEXT']) ) {

            return [ self::DEFAULT_CHANNEL ];
        }

        $channelArray   =     explode (',', $this->config['CHANNEL_TEXT']) ;

        array_flip ($channelArray) ;

        array_push ($channelArray,self::DEFAULT_CHANNEL);

        return $channelArray ;
    }
    public function getOldUserActivityUrl()
    {
        $activityUrl    = isset($this->config['OLD_USER_ACTIVITY_URL']) ? $this->config['OLD_USER_ACTIVITY_URL'] : '/activity/partner?from=wap';

        return $activityUrl ;
    }
    /**
     * @return int
     * @desc 默认的组号
     */
    public function getDefaultChannel()
    {
        return  self::DEFAULT_CHANNEL ;
    }
    /**
     * @return int
     * @desc 奖品的组号
     */
    public function getGroupId()
    {
        return $this->getActivityLotteryGroup (self::setEventId ());
    }
    /**
     * @return int
     * @DESC 活动的唯一性标示
     */
    protected static function setEventId()
    {
        return ActivityFundHistoryDb::SOURCE_ACTIVITY_IPHONE8 ;
    }
    /**
     * @return array|mixed
     * @desc  春风十里活动的配置文件
     */
    private static function config()
    {
        return AnalysisConfigLogic::make('ACTIVITY_IPHONE8_CONFIG');
    }
}