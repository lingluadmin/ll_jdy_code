<?php
/**
 * Created by 9douyu Coder.
 * User: scofie wu.changming@9douyu.com
 * Date: 09/05/2017.
 * Time: 3:53 PM.
 * Desc: ActivityStatisticsModel.php.
 */

namespace App\Http\Models\Activity;


use App\Http\Dbs\Activity\ActivityStatisticsDb;
use App\Http\Logics\Activity\Common\AnalysisConfigLogic;
use App\Http\Models\Common\ExceptionCodeModel;
use App\Http\Models\Invest\InvestModel;
use App\Http\Models\Model;
use App\Lang\LangModel;
use Mockery\CountValidator\Exception;
class ActivityStatisticsModel extends Model
{
    public static $codeArr = [
        'doCheckInAct'          =>  1,
        'doUpdateAct'           =>  2,
        'checkActivity'         =>  3,
        'checkInvest'           =>  4,
    ];

    public static $expNameSpace = ExceptionCodeModel::EXP_MODEL_ACTIVITY_ACCOUNT;

    protected $objectDb;


    public function __construct()
    {
        $this->objectDb = new ActivityStatisticsDb();
    }

    /**
     * @param $data
     * @return bool
     * @desc  记录数据
     */
    public  function inRecord( $data )
    {
        $return     =   $this->objectDb->inRecord( $data );

        if( !$return ||  empty($return) ){

            throw new Exception(LangModel::getLang('ERROR_RECORD_ADD_FAIL'),self::getFinalCode('doCheckInAct'));
        }

        return true;
    }

    /**
     * @param $investId
     * @param $cash
     * @desc 验证投资的数据
     */
    public function checkInvest( $actData )
    {
        $investModel    =   new InvestModel();

        $return         =   $investModel->getInvestByInvestId( $actData['invest_id'] );

        if( empty( $return ) ) {

            throw new Exception(LangModel::getLang('ERROR_ACTIVITY_INVEST_EMPTY'),self::getFinalCode('checkInvest'));
        }

        if( $return['user_id'] != $actData['user_id'] ) {

            throw new Exception(LangModel::getLang('ERROR_ACTIVITY_INVEST_ERROR'),self::getFinalCode('checkInvest'));
        }

        if( $return['cash'] != $actData['cash'] ) {

            throw new Exception(LangModel::getLang('ERROR_ACTIVITY_INVEST_CASH'),self::getFinalCode('checkInvest'));
        }

        return true;
    }

    /**
     * @param int $actId
     * @return mixed
     * @desc 验证活动的数据
     */
    public function checkActType( $actId = 0 )
    {
        $actGroup   =   ActivityFundHistoryModel::getActivityEventNote();

        if( !$actGroup[$actId] ) {

            throw new Exception(LangModel::getLang('ERROR_ACTIVITY_NOTE_EMPTY'),self::getFinalCode('checkActivity'));
        }
;
        return $actGroup[$actId];
    }

    /**
     * @param $id
     * @return mixed
     * @desc 更新记录为已经使用标识
     */
    public static function doUpdateRecordUsed($id)
    {
        $actDb      =   new ActivityStatisticsDb() ;

        $return     =   $actDb->doUpdateRecordUsed($id);

        if( empty($return) ) {

            throw new Exception('记录更新失败',self::getFinalCode('doUpdateAct'));
        }

        return $return;
    }

    /**
     * @param $userId
     * @param $investId
     * @return bool
     * @desc valid user invest form activity page credit assign
     */
    public static function validUserActInvestAssign( $userId, $investId )
    {
        $actDb      =   new ActivityStatisticsDb() ;

        $return     =   $actDb->getUserActRecordByInvestId ($userId, $investId);

        //$creditAssign = self::getUserInvestToActivityConfig (isset($return['act_id']) ? $return['act_id'] :0) ;

        if( !empty($return) && $return['is_assign'] == ActivityStatisticsDb::NOT_ASSIGN) {

            $actNoteArr =   ActivityFundHistoryModel::getActivityEventNote ();

            $actNote    =   isset($actNoteArr[$return['act_id']]) ? $actNoteArr[$return['act_id']] : '';

            $actNote    =   strstr ($actNote , '活动') ? $actNote : $actNote . '活动' ;

            throw new Exception(sprintf(LangModel::getLang('ERROR_ACTIVITY_INVEST_NOT_CREDIT_ASSIGN'),$actNote),self::getFinalCode('checkActivity'));

        }

        return true ;
    }

    /**
     * @param $actId
     * @return bool
     * @desc valid activity config is configure credit assign :default don't assign
     */
    protected static function getUserInvestToActivityConfig( $actId )
    {
        $activityConfigGroup    =   ActivityConfigModel::getConfig ('ACTIVITY_EVENT_ID_TO_CONFIG');

        $configString           =   isset($activityConfigGroup[$actId]) ? $activityConfigGroup[$actId] : '';

        if( empty($configString) ) {
            return false;
        }
        $activityConfig         =    AnalysisConfigLogic::make (explode ('|' ,$configString)[0]);

        if(isset($activityConfig['CREDIT_ASSIGN']) && $activityConfig['CREDIT_ASSIGN'] == true ){
            return true;
        }
        return false;
    }
}