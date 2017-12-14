<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/4/15
 * Time: 下午1:46
 */

namespace App\Http\Dbs;

use App\Http\Dbs\ProjectDb;
use App\Tools\ToolArray;


class InvestDb extends JdyDb{

    protected $table = 'invest';
    public $timestamps = false;

    const
        INVEST_TYPE = 0,                //定期项目投资类型
        INVSET_TYPE_CREDIT_ASSIGN = 1,  //债权转让项目投资类型

        INVEST_IS_NOT_MATCH = 0,        //未匹配
        INVEST_IS_MATCH     = 1,        //已匹配

        END=TRUE;


    /**
     * @param $data
     * @return bool
     * @desc 创建资金记录
     */
    public function add($data)
    {

        $this->project_id = $data['project_id'];

        $this->user_id = $data['user_id'];

        $this->cash = abs($data['cash']);

        $this->invest_type = $data['invest_type'];

        $this->assign_project_id = $data['assign_project_id'];

        $this->save();

        return $this->id;

    }

    /**
     * @param $id
     * @return mixed
     * @desc 获取user对象
     */
    public function getObj($id)
    {

        return $this->find($id);

    }

    /**
     * @param $id
     * @return mixed
     * @desc 获取投资记录信息
     */
    public function getInfoById($id)
    {

        $res = $this->where('id', $id)
            ->get()
            ->toArray();

        return ToolArray::arrayToSimple($res);

    }

    /**
     * @param int $size
     * @return mixed
     * @desc 获取最新的投资记录
     */
    public function getInvestNew($size = 30){

        $res = $this->orderBy('created_at','desc')
                    ->skip(0)
                    ->take($size)
                    ->get()
                    ->toArray();

        return $res;
    }

    /**
     * @param string $start
     * @param string $end
     * @return mixed
     * @desc 根据开始结束日期获取投资记录总额
     */
    public function getInvestAmountByDate($start = '',$end = ''){

        $obj = $this->select(\DB::raw('sum(cash) as cash'), \DB::raw('count(id) as total') ,\DB::raw('DATE_FORMAT(created_at,\'%Y%m%d\') as date'));

        if(!empty($start) && !empty($end)){

            $end   = date('Y-m-d',strtotime($end)+86400);

            $obj   = $obj->whereBetween('created_at',[$start,$end]);
        }

        $res = $obj->groupBy('date')
                    ->orderBy('date','desc')
                    ->get()
                    ->toArray();

        return $res;

    }

    /**
     * @param string $start
     * @param string $end
     * @return mixed
     * @desc 根据时间段获取投资总额
     */
    public function getInvestTermTotal($start = '', $end = ''){

        $obj = $this->select(\DB::raw('sum(cash) as cash'));

        if(!empty($start) && !empty($end)){

            $end   = date('Y-m-d',strtotime($end)+86400);

            $obj   = $obj->whereBetween('created_at',[$start,$end]);
        };

        $res = $obj->first();

        return $res;

    }


    /**
     * @param $projectIds
     * @return mixed
     * 获取指定项目的投资记录
     */
    public function getInvestListByProjectIds($projectIds){

        return $this->whereIn('project_id',$projectIds)
            ->get()
            ->toArray();
    }

    /**
     * @desc 通过多个投资ID获取投资记录
     * @param $investIds
     * @return mixed
     */
    public function getInvestByIds($investIds){

        return $this->whereIn('id',$investIds)
            ->get()
            ->toArray();
    }

    /**
     * @param $ids
     * @return mixed
     * @desc 根据ids获取列表
     */
    public function getListByUserIdIds($userId, $ids)
    {

        return $this->where('user_id', $userId)
            ->whereIn('id', $ids)
            ->get()
            ->toArray();

    }

    /**
     * @return mixed
     * @desc 定期投资总额
     */
    public function getInvestTotalCash()
    {

        $return = $this->select(\DB::raw('sum(cash) as cash'))
            ->first();

        return $return->cash;

    }

    /**
     * @param $creditAssignId
     * @desc 根据债转Id获取债转项目的投资人
     * @return array
     */
    public function getInvestCreditAssign($creditAssignId)
    {

        $return = $this->where('assign_project_id',$creditAssignId)
            ->first();

        return $this->dbToArray($return);

    }

    /**
     * @param $projectId
     * @param $userId
     * @return mixed
     * 获取用户投资某个项目指定金额的所有记录
     */
    public function getByProjectIdAndUserId($projectId,$userId,$cash){

        return $this->where('project_id',$projectId)
            ->where('user_id',$userId)
            ->where('cash',$cash)
            ->get()
            ->toArray();
    }

    /**
     * @param $investId
     * @return array
     * @desc 确认转让信息页面数据
     */
    public function getInvestInfoById($investId){

        $result = self::select('invest.*', 'p.refund_type', 'p.product_line', 'p.type', 'p.profit_percentage', 'p.name', 'p.end_at','p.created_at as p_time','p.serial_number')
            ->join("project as p", 'p.id', '=', "invest.project_id")
            ->where('invest.id', $investId)
            ->first();

        return $this->dbToArray($result);

    }

    /**
     * @param $projectIds
     * @return mixed
     * @desc 获取正确投资的数据
     */
    public function getNormalInvestListByProjectIds($projectIds){

        return $this->whereIn('project_id',$projectIds)
                    ->where("invest_type",self::INVEST_TYPE)
                    ->get()
                    ->toArray();
    }

    /**
     * @param string $projectIds
     * @return array
     * @desc 从核心获取最后一次投资的数据(不包含原项目债转的记录)
     */
    public function getLastInvestTimeByProjectId( $projectIds = array())
    {
        return self::select(\DB::raw('max(created_at) as last_invest_time'), \DB::raw('max(id) as id'), 'project_id')
                    ->whereIn('project_id', $projectIds)
                    ->where("invest_type",self::INVEST_TYPE)
                    ->groupBy('project_id')
                    ->get()
                    ->toArray();
    }


    /**
     * @param $userId
     * @param int $page
     * @param int $size
     * @return array
     * @desc 投资记录
     */
    public function getInvestListByUserId($userId, $refund='', $status='', $page = 1, $size = 10)
    {
        $offset = $this->getLimitStart($page, $size);
        $investObj  =   $this->join("project as p", 'p.id', '=', "invest.project_id")
            ->where('invest.user_id', $userId)
            ->where('p.product_line','<>',ProjectDb::PROJECT_PRODUCT_LINE_SMART_INVEST)
            ->where('p.assets_platform_sign','');

        if( $refund ) {
            $investObj  =   $investObj->where('p.refund_type' , $refund) ;
        }

        if( $status ) {
            $investObj  =   $investObj->where('p.status' , $status) ;
        }
        $total  =   $investObj->count("invest.id");

        $list   = $investObj->select('invest.*', 'p.refund_type', 'p.product_line', 'p.type', 'p.profit_percentage','p.base_rate','p.after_rate', 'p.name', 'p.end_at','p.status','p.created_at as project_time','p.serial_number')
                ->orderBy('invest.id','desc')
                ->skip($offset)
                ->take($size)
                ->get()
                ->toArray();

        return [ 'list'=> $list, 'total'=> $total ];
    }



    /**
     * @param $userId
     * @param string $status
     * @param int $match
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getSmartInvestListByUserId($userId, $status='',$match=0, $page = 1, $size = 10)
    {
        $offset = $this->getLimitStart($page, $size);
        $investObj  =   $this->join("project as p", 'p.id', '=', "invest.project_id")
            ->where('invest.user_id', $userId)
            ->where('p.product_line',ProjectDb::PROJECT_PRODUCT_LINE_SMART_INVEST)
            ->where('p.assets_platform_sign','<>','');

        if( $status ) {
            $investObj  =   $investObj->where('p.status' , $status) ;
            if($status == ProjectDb::STATUS_REFUNDING){
                $investObj  =  $investObj->where('invest.is_match',$match);
            }
        }

        $total  =   $investObj->count("invest.id");

        $list   = $investObj->select('invest.*', 'p.refund_type','p.invest_time', 'p.product_line', 'p.type', 'p.profit_percentage','p.base_rate','p.after_rate', 'p.name', 'p.end_at','p.status','p.created_at as project_time','p.serial_number')
            ->orderBy('invest.id','desc')
            ->skip($offset)
            ->take($size)
            ->get()
            ->toArray();

        return [ 'list'=> $list, 'total'=> $total ];
    }


    /**
     * @param $userId
     * @return mixed
     */
    public function getSmartInvestPrincipalByUserId($userId){
        $investObj  =   $this->join("project as p", 'p.id', '=', "invest.project_id")
            ->where('invest.user_id', $userId)
            ->whereIn('p.status',[ProjectDb::STATUS_REFUNDING,ProjectDb::STATUS_INVESTING])
            ->where('p.product_line',ProjectDb::PROJECT_PRODUCT_LINE_SMART_INVEST)
            ->where('p.assets_platform_sign','<>','');

        $total  =   $investObj->sum("invest.cash");


        return $total;
    }



    /**
     * @param $userId
     * @return mixed
     * @desc 用户总资产
     */
    public static function getUserNoFullAtProjectPrincipal( $userId ){

        $result = self::select('p.product_line', \DB::raw('sum(cash) as principal'))
            ->join('project as p', 'p.id', '=', 'invest.project_id')
            ->where('invest.user_id', $userId)
            ->where('invest.invest_type', self::INVEST_TYPE)
            ->where('p.new', ProjectDb::IS_NEW)
            ->where('p.status', ProjectDb::STATUS_INVESTING)
            ->groupBy('product_line')
            ->get()
            ->toArray();

        return $result;

    }

    /**
     * @param $userId
     * @return mixed
     * @desc  根据用户Id获取该用户投资记录（用来判断用户是否投资）
     */
    public static function getUserInvestDataByUserId($userId){
        $result = self::where('user_id', $userId)->count('id');
//            ->limit(1)
//            ->get()
//            ->toArray();

        return ['total' =>$result];
    }

    /**
     * 投资记录
     *
     * @param $projectId
     * @param int $page
     * @param int $size
     * @param string $startTime
     * @param string $endTime
     * @return array
     */
    public function getInvestByProjectId($projectId, $page=1, $size=10, $startTime='', $endTime='')
    {
        $offset = $this->getLimitStart($page, $size);

        $total = $this->where(['project_id' => $projectId, 'invest_type' => self::INVEST_TYPE])
            ->whereBetween('created_at', [$startTime, $endTime])
            ->count("id");

        $list = $this->join("user as u", 'u.id', '=', "invest.user_id")
            ->where(['invest.project_id' => $projectId, 'invest.invest_type' => self::INVEST_TYPE])
            ->whereBetween('invest.created_at', [$startTime, $endTime])
            ->skip($offset)
            ->take($size)
            ->orderBy('invest.id', 'desc')
            ->get(['invest.*','u.real_name'])
            ->toArray();

        return ['list' => $list, 'total' => $total];
    }
    /**
     * @desc 多个用户id检索投资条件
     * @param $userIds
     * @return $this
     */
    public function getMoreInvestUserIdParam($userIds)
    {
        $this->_sql_builder = $this->_sql_builder->whereIn('user_id', $userIds);

        return $this;
    }

    /**
     * @param 投资时间区间检索条件
     * @param $startTime
     * @param $endTime
     * @return $this
     */
    public function getInvestDateParam($startTime, $endTime)
    {
        $this->_sql_builder = $this->_sql_builder->where('invest.created_at', '>=', $startTime)->where('invest.created_at', '<=', $endTime);

        return $this;
    }

    /**
     * @desc 联合project查询数据
     * @return $this
     */
    public function joinTableProject()
    {
        $this->_sql_builder = $this->_sql_builder->join("project as p", 'p.id', '=', "invest.project_id");
        return $this;
    }

    /**
     * @desc 投资数据统计筛选字段
     * @return $this
     */
    public function investStatisticsField()
    {
        $this->_sql_builder = $this->_sql_builder->select('user_id', \DB::raw('sum(cash) as total_amount'), \DB::raw('sum(cash*profit_percentage/100) as total_interest'), \DB::raw('count(project_id) as invest_counts'));

        return $this;
    }

    /**
     * @desc 投资数据列表筛选字段
     * @return $this
     */
    public function investListField()
    {
        $this->_sql_builder = $this->_sql_builder->select('invest.*', 'p.refund_type', 'p.product_line', 'p.type', 'p.profit_percentage','p.base_rate','p.after_rate', 'p.name', 'p.end_at','p.status','p.created_at as project_time','p.serial_number','p.publish_at', 'p.end_at');

        return $this;
    }


    /**
     * @desc    根据投资ID，获取投资信息，以及相关项目信息
     * @param   $investId
     * @return  array
     *
     **/
    public function getInvestAndProjectByInvestId( $investId ){

        $result = self::select('invest.*',
            'p.name',       'p.total_amount','p.invest_time',   'p.invested_amount',    'p.invest_days',
            'p.refund_type','p.type',       'p.product_line',   'p.profit_percentage',  'p.status AS project_status',
            'p.publish_at', 'p.end_at',     'p.pledge',         'p.created_at as p_time','p.before_refund',
            'p.full_at',    'p.category',   'p.serial_number',  'p.is_credit_assign',   'p.assign_keep_days',
            'p.assets_platform_sign')
            ->join("project as p", 'p.id', '=', "invest.project_id")
            ->where('invest.id', $investId)
            ->first();

        return $this->dbToArray($result);

    }

    /**
     * @param $investId
     * @param $projectId
     * @param $userId
     * @param $cash
     * @param $assetsPlatformSign
     * @return array
     * 检测数据是否存在
     */
    public function checkInvest($investId, $projectId, $userId, $cash, $assetsPlatformSign){

        $result = $this->select('invest.id')
            ->join('project as p', 'p.id', '=', 'invest.project_id')
            ->where('invest.id', $investId)
            ->where('invest.project_id', $projectId)
            ->where('invest.user_id', $userId)
            ->where('invest.cash', $cash)
            ->where('invest.is_match', self::INVEST_IS_NOT_MATCH)
            ->where('p.id', $projectId)
            ->where('p.product_line' , ProjectDb::PROJECT_PRODUCT_LINE_SMART_INVEST)
            ->where('p.assets_platform_sign', $assetsPlatformSign)
            ->first();

        return $this->dbToArray($result);

    }


    /**
     * @param $investIds
     * @return mixed
     * 更新为已匹配状态
     */
    public function updateIsMatch( $investIds ){

        $result = $this->whereIn('id', $investIds)
            ->update(['is_match' => self::INVEST_IS_MATCH]);

        return $result;

    }


    /**
     * @param $userId
     */
    public function getSmartInvestFinishIds($userId){
        $ret  =   $this->select('invest.id as orderNo')
                       ->join("project as p", 'p.id', '=', "invest.project_id")
                       ->where('invest.user_id',  $userId)
                       ->where('invest.is_match', 1)
                       ->where('p.product_line',ProjectDb::PROJECT_PRODUCT_LINE_SMART_INVEST)
                       ->where('p.status',ProjectDb::STATUS_REFUNDING)
                       ->where('p.assets_platform_sign','<>','')
                       ->get()
                       ->toArray();
        return $ret;

    }


}
