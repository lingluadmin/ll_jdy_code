<?php
/**
 * Created by PhpStorm.
 * User: gyl-dev
 * Date: 16/6/16
 * Time: 上午11:58
 * Desc: 定期项目相关信息
 */

namespace App\Http\Controllers\Pc\Project;

use App\Http\Controllers\Controller;
use App\Http\Dbs\Project\ProjectDb;
use App\Http\Logics\Ad\AdLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Logics\SystemConfig\SystemConfigLogic;
use App\Tools\ToolArray;
use App\Tools\ToolPaginate;
use App\Tools\ToolPager;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 项目列表页
     */
    public function index( Request $request )
    {

        $type = $request->input('type', 'Preferred');

        $page = $request->input('page', 1);
        $type = htmlspecialchars($type);
        $page = (int)$page;

        //头部广告
        $ad = AdLogic::getUseAbleListByPositionId(16);
        $data = [
            'type'   => $type,
            'page'   => $page,
            'ad'     => $ad,
            'actNote'=> ProjectLogic::getActivityNoteList (),
        ];
        return view('pc.project/list', $data);
    }


    /**
     * @param int $page
     *
     */
    public function getProjectList($page=1){
        $page = intval($page);
        if($page<1){
            $page = 1;
        }
        $size = 10;
        //项目列表
        $projectLogic = new ProjectLogic();

        #新手项目
        $projectArr     = $projectLogic->getProjectPackAppV413();
        $projectNovice[]  = !empty($projectArr['novice']) ? $projectArr['novice'] : [];

        $list   = $projectLogic->getPreferredProjectlist( [ProjectDb::PROJECT_PRODUCT_LINE_JSX, ProjectDb::PROJECT_PRODUCT_LINE_JAX],
                                                           $page,
                                                           $size,
                                                           [ProjectDb::STATUS_INVESTING, ProjectDb::STATUS_REFUNDING, ProjectDb::STATUS_FINISHED],
                                                           $projectNovice
                                                        );
        $count = $list['total'];

        if(isset($list['list']) && !empty($list['list'])){
            $list = $list['list'];
            $needHiddenArr = SystemConfigLogic::getConfig('HIDE_PROJECT_ID');
            if( !empty($needHiddenArr) ){
                $hiddenProjectIds = explode(',', $needHiddenArr);
                foreach ($list as $key => $record) {
                    if (in_array($record['id'], $hiddenProjectIds)) {
                        unset($list['list'][$key]);
                        continue;
                    }
                }
            }
        }

        //分页
        $pageNation = new ToolPager($count, $page, $size, '/project/list');
        $pager = $pageNation->getPaginate();

        $data['list']    = $list;
        $data['pager']   = $pager;
        return_json_format($data);
    }

    /**
     * @desc 获取智享计划项目列表页面
     * @param $page int
     * @return json
     */
    public function getSmartProjectList($page)
    {
        $page = (int)$page;

        if ($page < 1) {
            $page = 1;
        }
        $size = 10;

        //项目列表
        $project = new ProjectLogic();

        $list = $project->getPreferredProjectlist([ProjectDb::PRODUCT_LINE_SMART_INVEST],
                                                   $page,
                                                   $size,
                                                   [ProjectDb::STATUS_INVESTING, ProjectDb::STATUS_REFUNDING, ProjectDb::STATUS_FINISHED]
                                                );
        $count = $list['total'];

        //分页
        $pageNation = new ToolPager($count, $page, $size, '/project/smartList');
        $pager = $pageNation->getPaginate();

        $data['list']    = $list['list'];
        $data['pager']   = $pager;
        return_json_format($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 闪电付息列表页面
     */
    public function sdfList()
    {

        return view('pc.project/sdf');

    }

    /**
     *
     */
    public function debt(){

        echo 'debt';

    }


}

