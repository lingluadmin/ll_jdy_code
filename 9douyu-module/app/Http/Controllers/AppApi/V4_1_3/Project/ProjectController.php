<?php
/**
 * Created by PhpStorm.
 * User: jinzhuotao
 * Date: 17/8/2
 * Time: 下午10:33
 */

namespace App\Http\Controllers\AppApi\V4_1_3\Project;

use App\Http\Controllers\AppApi\AppController;
use App\Http\Logics\Ad\AdLogic;
use App\Http\Logics\Project\ProjectAppLogic;
use Illuminate\Http\Request;
use App\Http\Logics\AppLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Logics\Project\CurrentLogic;
use App\Http\Dbs\Project\ProjectDb;

class ProjectController extends AppController{

    protected $projectAppLogic = null;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->projectAppLogic = new ProjectAppLogic();

    }

    /**
     * @SWG\Post(
     *   path="/project_index?version=4.1.3",
     *   tags={"APP-Project"},
     *   summary="理财列表-定期项目 [Project\ProjectController@index]",
     *   @SWG\Parameter(
     *      name="name",
     *      in="formData",
     *      description="发送请求的模块名称",
     *      required=true,
     *      type="string",
     *      default="cli_test_user",
     *   ),
     *   @SWG\Parameter(
     *      name="client",
     *      in="formData",
     *      description="客户端",
     *      required=true,
     *      type="string",
     *      default="ios",
     *   ),
     *   @SWG\Parameter(
     *      name="version",
     *      in="formData",
     *      description="客户端版本号",
     *      required=true,
     *      type="string",
     *      default="4.0",
     *   ),
     *   @SWG\Parameter(
     *      name="token",
     *      in="formData",
     *      description="token",
     *      required=true,
     *      type="string",
     *      default="653030e9f8e4f6559669386dfe4f56d4",
     *   ),
     *   @SWG\Parameter(
     *      name="page",
     *      in="formData",
     *      description="页数",
     *      required=true,
     *      type="string",
     *      default="1",
     *   ),
     *   @SWG\Parameter(
     *      name="size",
     *      in="formData",
     *      description="条数",
     *      required=true,
     *      type="string",
     *      default="10",
     *   ),

     *   @SWG\Response(
     *     response=200,
     *     description="获取项目列表成功。",
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="获取项目列表失败。",
     *   )
     * )
     */

    /**
     * @desc app4.0定期理财列表
     * @return array
     */
    public function index(Request $request){

        $page = $request->input('page', 1);
        $size = $request->input('size', 6);

        $projectList = [];

        //App4.0首页定期项目列表
        $projectLogic = new ProjectLogic();

        #新手项目
        $projectArr     = $projectLogic->getProjectPackAppV413();
        $projectNovice[]  = !empty($projectArr['novice']) ? $projectArr['novice'] : [];

        $projectList   = $projectLogic->getAppV4ProjectList( [ProjectDb::PROJECT_PRODUCT_LINE_JSX, ProjectDb::PROJECT_PRODUCT_LINE_JAX], $page, $size, [ProjectDb::STATUS_INVESTING, ProjectDb::STATUS_REFUNDING, ProjectDb::STATUS_FINISHED],$projectNovice);

        return AppLogic::callSuccess($projectList);
    }


    /**
     * @SWG\Post(
     *   path="/project_preview?version=4.1.3",
     *   tags={"APP-Project"},
     *   summary="理财列表-Preview-4.20 [Project\ProjectController@newList]",
     *   @SWG\Parameter(
     *      name="name",
     *      in="formData",
     *      description="发送请求的模块名称",
     *      required=true,
     *      type="string",
     *      default="cli_test_user",
     *   ),
     *   @SWG\Parameter(
     *      name="client",
     *      in="formData",
     *      description="客户端",
     *      required=true,
     *      type="string",
     *      default="ios",
     *   ),
     *   @SWG\Parameter(
     *      name="version",
     *      in="formData",
     *      description="客户端版本号",
     *      required=true,
     *      type="string",
     *      default="4.0",
     *   ),
     *   @SWG\Parameter(
     *      name="token",
     *      in="formData",
     *      description="token",
     *      required=true,
     *      type="string",
     *      default="653030e9f8e4f6559669386dfe4f56d4",
     *   ),


     *   @SWG\Response(
     *     response=200,
     *     description="获取项目列表成功。",
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="获取项目列表失败。",
     *   )
     * )
     */
    /**
     * @desc app4.0定期理财列表 改版
     * @return array
     */
    public function newList(Request $request){

        $page =  1;
        $size =  10;

        //App4.0首页定期项目列表
        $projectLogic = new ProjectLogic();

        #新手项目
        $projectArr     = $projectLogic->getProjectPackAppV413();
        $projectNovice  = !empty($projectArr['novice']) ? $projectArr['novice'] : [];
        if(!empty($projectNovice)){
            if(isset($projectNovice['new'])){
                unset($projectNovice['new']);
            }

            $projectNovice['format_project_name'] = $projectNovice['name'].' '.$projectNovice['format_name'];
            $projectNovice['invest_tip'] = '仅限首次投资';
            $projectNovice['except_year_rate']   =  ProjectDb::INTEREST_RATE_NOTE.'(%)';
            $projectNovice['profit_percentage']  =  number_format( $projectNovice['profit_percentage'], 1);
            $projectNovice['project_time_note']  =  '项目期限';
            $projectNovice['base_rate']   =  number_format( $projectNovice['base_rate'], 1);
            $projectNovice['after_rate']  =  number_format( $projectNovice['after_rate'],1);
            $projectNovice['invest_time_note']  =  $projectNovice['format_invest_time'].$projectNovice['invest_time_unit'];

        }
        #九随心项目
        $projectHeart  = !empty($projectArr['heart']) ? $projectArr['heart'] : [];
        if(!empty($projectHeart)){
            $projectHeart['format_project_name']= $projectHeart['name'].' '.$projectHeart['format_name'];
            $projectHeart['invest_tip']         = '仅限首次投资';
            $projectHeart['except_year_rate']   =  ProjectDb::INTEREST_RATE_NOTE.'(%)';
            $projectHeart['profit_percentage']  =  number_format( $projectHeart['profit_percentage'], 1);
            $projectHeart['project_time_note']  =  '项目期限';
            $projectHeart['base_rate']          =  number_format( $projectHeart['base_rate'], 1);
            $projectHeart['after_rate']         =  number_format( $projectHeart['after_rate'],1);
            $projectHeart['invest_time_note']   =  $projectHeart['format_invest_time'].$projectHeart['invest_time_unit'];
            $projectHeart['project_tip']        = $projectHeart['assign_keep_days'].'天可债转';
        }

        #优选项目
        $projectList   = $projectLogic->getAppV4ProjectList( [ProjectDb::PROJECT_PRODUCT_LINE_JSX, ProjectDb::PROJECT_PRODUCT_LINE_JAX], $page, $size, [ProjectDb::STATUS_INVESTING, ProjectDb::STATUS_REFUNDING, ProjectDb::STATUS_FINISHED]);

        $projectNew = [];
        foreach($projectList as $key=>$value){
            //将项目列表中九随心项目过滤
            if(!empty($value) && $value['pledge']!=2){
                $projectNew[] = $value;
            }
            if(count($projectNew) == 3){
                break;
            }
        }

        #零钱计划
        $currentLogic = new CurrentLogic();
        $current = $currentLogic->getShowProject();
        if(!empty($current)){
            $current['except_year_rate']   = ProjectDb::INTEREST_RATE_NOTE.'(%)';
            $current['project_time_note']  = '项目期限';
            $current['profit_percentage']  = number_format( $current['latest_interest_rate'], 1);
            $current['refund_type_note']   = '1元可投';
            $current['invest_time_note']   = '灵活存取';
            $current['base_rate']          =  number_format( $current['base_rate'], 1);
            $current['min_invest']         = 1;
        }

        //根据广告位获取app项目列表模块排序
        $adLogic = new AdLogic();
        $titleList = $adLogic->getAppProjectModelSort(38);

        $data= [
            'titleList'        => $titleList,         //项目模块排序
            'novice_project'   => [$projectNovice],   //新手项目
            'heart_project'    => [$projectHeart],    //九随心项目项目
            'current_project'  => [$current],         //零钱计划
            'invest_project'   => $projectNew,        //项目列表
        ];

        return AppLogic::callSuccess($data);
    }

}


