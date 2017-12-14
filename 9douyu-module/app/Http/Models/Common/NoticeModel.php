<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 2017/3/2
 * Time: 下午12:01
 * Desc: 站内信
 */

namespace App\Http\Models\Common;

use App\Http\Dbs\Notice\NoticeDb;
use App\Http\Models\Model;
use App\Lang\LangModel;

class NoticeModel extends Model{

    public static $codeArr            = [
        'doSend'            => 1,
        'getListByUserId'   => 2,
        'batchUpdateReadByUserId'   => 3,
        'getNoticeListByUserId' => 4,
        'getSiteNoticeListByUserId' => 5
    ];

    public static $expNameSpace       = ExceptionCodeModel::EXP_MODEL_NOTICE;


    /**
     * @param $data
     * @param int $type
     * @return mixed
     * @throws \Exception
     * @desc 执行发送(单个)
     */
    public static function doSend($data){

        $res = \DB::table('notice')->insert($data);

        if( !$res ){

            throw new \Exception(LangModel::getLang('ERROR_NOTICE_COMMON'), self::getFinalCode('doSend'));

        }

        return $res;

    }

    /**
     * @param $userId
     * @desc 根据user_id批量更新用户未读消息
     */
    public static function batchUpdateReadByUserId($userId){

        $res = \DB::table('notice')
            ->where('user_id', $userId)
            ->where('is_read', NoticeDb::UNREAD)
            ->update(array('is_read' => NoticeDb::READ));

        if( $res === false ){

            throw new \Exception(LangModel::getLang('ERROR_NOTICE_COMMON'), self::getFinalCode('batchUpdateReadByUserId'));

        }

        return $res;
    }
    /**
     * @param $userId
     * @desc 根据user_id批量更新用户未读消息
     */
    public static function updateReadByUserId($userId,$noticeId){

        $res = \DB::table('notice')
                ->where('user_id', $userId)
                ->where('id',$noticeId)
                ->where('is_read', NoticeDb::UNREAD)
                ->update(array('is_read' => NoticeDb::READ));

        if( $res === false ){

            throw new \Exception(LangModel::getLang('ERROR_NOTICE_COMMON'), self::getFinalCode('batchUpdateReadByUserId'));
        }

        return $res;
    }
    /**
     * @param $userId
     * @param $noticeId
     * @return mixed
     * @throws \Exception
     * @desc 阅读系统消息
     */
    public static function readSystemMsg($userId, $noticeId){

        $res = \DB::table('notice_read')->insert(
            [
                'user_id'   => $userId,
                'notice_id' => $noticeId
            ]
        );

        if( !$res ){

            throw new \Exception(LangModel::getLang('ERROR_NOTICE_COMMON'), self::getFinalCode('readSystemMsg'));

        }

        return $res;

    }

    /**
     * @param int $userId
     * @return mixed
     * @throws \Exception
     * @desc 查询站内信,不含站内公告
     */
    public function getNoticeListByUserId($userId=0, $page=1, $size=7){

        $dbPrefix = env('DB_PREFIX');

        $offset = ( max(0, $page -1) ) * $size;

        //上线一个月,通过数据分析,站内信的阅读量是1%,把sql直接简单化

        $sql = "select * from {$dbPrefix}notice where user_id = {$userId} and is_read = ".NoticeDb::UNREAD." order by id desc limit {$offset}, {$size}";

        /*$sql = "select * from {$dbPrefix}notice where user_id = {$userId} and is_read = ".NoticeDb::UNREAD."
union
select * from {$dbPrefix}notice where user_id = 0 and is_read = ".NoticeDb::UNREAD." and type <> ".NoticeDb::TYPE_SITE_NOTICE." and id not in (
	select notice_id from {$dbPrefix}notice_read where user_id = {$userId}
)
union
select * from {$dbPrefix}notice where user_id = {$userId} and is_read = ".NoticeDb::READ."
union
select id, title, user_id, message, 1 as is_read, type, created_at, updated_at from {$dbPrefix}notice where type <> ".NoticeDb::TYPE_SITE_NOTICE." and id in (
	select notice_id from {$dbPrefix}notice_read where user_id = {$userId}
) order by  `is_read`,  id desc limit {$offset}, {$size}";*/

        return app('db')->select($sql);

    }

    /**
     * @param $userId
     * @return mixed
     * @desc 获取用户未读的公告
     */
    public function getUserUnReadSiteNoticeList($userId){

        $dbPrefix = env('DB_PREFIX');

        $sql = "select * from {$dbPrefix}notice where user_id = {$userId} and is_read = ".NoticeDb::UNREAD."
union
select * from {$dbPrefix}notice where user_id = 0 and is_read = ".NoticeDb::UNREAD." and type = ".NoticeDb::TYPE_SITE_NOTICE." and id not in (
	select notice_id from {$dbPrefix}notice_read where user_id = {$userId}
)";

        return app('db')->select($sql);

    }

    /**
     * @param $userId
     * @return mixed
     * @desc 获取用户未读站内信
     */
    public function getUserUnReadNoticeList($userId){

        $dbPrefix = env('DB_PREFIX');

        $sql = "select * from {$dbPrefix}notice where user_id = {$userId} and is_read = ".NoticeDb::UNREAD;

        return app('db')->select($sql);

    }

    public static function getUserUnReadNoticeTotal($userId){

        $noticeDb   =   new NoticeDb() ;

        $total      =  $noticeDb->where('user_id',$userId)->where('is_read',NoticeDb::UNREAD)->count('id');

        return $total ;
    }


    /**
     * @param $userId
     * @param int $page
     * @param int $size
     * @return mixed
     * @throws \Exception
     * @desc 获取站内公告列表
     */
    public function getSiteNoticeListByUserId($userId=0, $page=1, $size=7){

        $dbPrefix = env('DB_PREFIX');

        $offset = ( max(0, $page -1) ) * $size;

        $sql = "
select * from {$dbPrefix}notice where user_id = 0 and type = ".NoticeDb::TYPE_SITE_NOTICE." and id not in (
	select notice_id from {$dbPrefix}notice_read where user_id = {$userId}
)
union
select id, title, user_id, message, 1 as is_read, type, created_at, updated_at from {$dbPrefix}notice where user_id = 0 and type = ".NoticeDb::TYPE_SITE_NOTICE." and id in (
	select notice_id from {$dbPrefix}notice_read where user_id = {$userId}
) order by  `is_read`,  id desc limit {$offset}, {$size}";

        return app('db')->select($sql);

    }

    /**
     * @param $userId
     * @param int $page
     * @param int $size
     * @return array
     * @desc 获取用户的消息
     */
    public function getUserNoticeList($userId ,$page = 1 , $size =10 )
    {
        $noticeDb   =   new NoticeDb() ;

        $start      =   $noticeDb->getLimitStart($page, $size);

        $list       =   $noticeDb->where('user_id',$userId)
                                 ->orderBy('id','desc')
                                 ->skip($start)
                                 ->take($size)
                                 ->get()
                                 ->toArray();

        $total      =  $noticeDb->where('user_id',$userId)->count('id');

        return ['list' => $list ,'total' => $total] ;
    }
    /**
     * @param string $title
     * @param bool $notice
     * @return array|mixed
     * @desc return notice title to note
     */
    public static function getNoticeTitleNote( $title = '' , $notice = false)
    {
        $noticeTitleArray    =   [
            NoticeDb::TYPE_DEFAULT               => '系统消息',
            NoticeDb::TYPE_REGISTER              => '注册成功',         //注册成功
            /*--------订单---------*/
            NoticeDb::TYPE_ORDER_WITHDRAW_CREATE => '申请提现成功',     //申请提现,创建记录成功
            /*--------定期---------*/
            NoticeDb::TYPE_INVEST_PROJECT        => '投资出借成功',      //定期项目	买入成功
            /*--------债权转让---------*/
            NoticeDb::TYPE_ASSIGN_CREATE         => '债权申请转让',       //申请转让
            NoticeDb::TYPE_ASSIGN_CANCEL         => '债权取消转让',       //取消转让
            NoticeDb::TYPE_ASSIGN_SUCCESS        => '债权转让成功',       //转让成功
            /*--------活期---------*/
            NoticeDb::TYPE_CURRENT_IN            => '零钱计划买入',       //活期项目	买入成功
            NoticeDb::TYPE_CURRENT_OUT           => '零钱计划卖出',        //活期项目	卖出成功
            /*--------回款---------*/
            NoticeDb::TYPE_REFUND_INTEREST       => '定期利息回款',        //回款	定期项目	利息回款
            NoticeDb::TYPE_REFUND_CASH           => '定期本金回款',         //回款	定期项目	本息回款
            NoticeDb::TYPE_REFUND_BEFORE         => '投资提前回款',         //提前回款
            /*--------红包加息券---------*/
            NoticeDb::TYPE_BONUS_BIRTHDAY        => '生日红包发放',         //红包	生日发放
            NoticeDb::TYPE_BONUS_EXPIRE          => '红包过期提醒',         //红包 过期提醒
            NoticeDb::TYPE_BONUS_RATE_EXPIRE     => '加息券过期提现',        //加息券 过期提醒
            /*--------邀请---------*/
            NoticeDb::TYPE_INVITE_SUCCESS        => '合伙人邀请成功',           //合伙人	邀请成功
            NoticeDb::TYPE_FAMILY                => '加入家庭账户',     //家庭账户
            NoticeDb::TYPE_SYSTEM                => '系统消息',        //系统消息
            NoticeDb::TYPE_SITE_NOTICE           => '网站公告',        //公告
        ] ;
        if( $notice == false ) {

            return  isset($noticeTitleArray[$title]) ? $noticeTitleArray[$title]: $noticeTitleArray[NoticeDb::TYPE_DEFAULT] ;
        }
        return $noticeTitleArray ;
    }

    /**
     * @param int $type
     * @param bool $notice
     * @return array|mixed
     * @desc return notice type to note
     */
    public static function getNoticeTypeNote( $type= NoticeDb::TYPE_DEFAULT ,$notice = false)
    {
        $noticeTypeArray    =   [
            NoticeDb::TYPE_DEFAULT               => '系统消息',                  //系统默认消息
            NoticeDb::TYPE_REGISTER              => '注册成功',                  //注册成功
            /*--------订单---------*/
            NoticeDb::TYPE_ORDER_WITHDRAW_CREATE => '提现申请',     //申请提现,创建记录成功
            /*--------定期---------*/
            NoticeDb::TYPE_INVEST_PROJECT        => '投资项目',            //定期项目	买入成功
            /*--------债权转让---------*/
            NoticeDb::TYPE_ASSIGN_CREATE         => '债权转让',             //申请转让
            NoticeDb::TYPE_ASSIGN_CANCEL         => '债权转让',             //取消转让
            NoticeDb::TYPE_ASSIGN_SUCCESS        => '债权转让',            //转让成功
            /*--------活期---------*/
            NoticeDb::TYPE_CURRENT_IN            => '零钱计划',                //活期项目	买入成功
            NoticeDb::TYPE_CURRENT_OUT           => '零钱计划',               //活期项目	卖出成功
            /*--------回款---------*/
            NoticeDb::TYPE_REFUND_INTEREST       => '投资回款',           //回款	定期项目	利息回款
            NoticeDb::TYPE_REFUND_CASH           => '投资回款',              //回款	定期项目	本息回款
            NoticeDb::TYPE_REFUND_BEFORE         => '投资回款',            //提前回款
            /*--------红包加息券---------*/
            NoticeDb::TYPE_BONUS_BIRTHDAY        => '红包加息券',           //红包	生日发放
            NoticeDb::TYPE_BONUS_EXPIRE          => '红包加息券',             //红包 过期提醒
            NoticeDb::TYPE_BONUS_RATE_EXPIRE     => '红包加息券',        //加息券 过期提醒
            /*--------邀请---------*/
            NoticeDb::TYPE_INVITE_SUCCESS        => '合伙人',           //合伙人	邀请成功
            NoticeDb::TYPE_FAMILY                => '家庭账户',     //家庭账户
            NoticeDb::TYPE_SYSTEM                => '系统消息',        //系统消息
            NoticeDb::TYPE_SITE_NOTICE           => '网站公告',        //公告
        ] ;
        if( $notice == false ) {

            return  isset($noticeTypeArray[$type]) ? $noticeTypeArray[$type]: $noticeTypeArray[NoticeDb::TYPE_DEFAULT] ;
        }

        return $noticeTypeArray ;
    }





}
