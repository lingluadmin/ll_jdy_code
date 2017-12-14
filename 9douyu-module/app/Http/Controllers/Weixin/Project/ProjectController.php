<?php
/**
 * Created by PhpStorm.
 * User: liuqiuhui
 * Date: 16/7/25
 * Time: 下午6:10
 */

namespace App\Http\Controllers\Weixin\Project;


use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Dbs\Project\ProjectDb;
use App\Http\Logics\Invest\CurrentLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Logics\SystemConfig\SystemConfigLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Models\Common\IncomeModel;
use App\Tools\ToolPager;
use Illuminate\Http\Request;
use Session;
use Redirect;


class ProjectController extends WeixinController
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(){

        //用户状态
        $userId = $this->getUserId();
        //项目列表
        $projectLogic = new ProjectLogic();

        #新手项目
        $projectArr = $projectLogic->getProjectPackAppV413();
        $novice     = !empty($projectArr['novice']) ? $projectArr['novice'] : [];

        $data =[
            'userId' => $userId,
            'novice' => $novice,
         ];
        return view('wap.project.home', $data);

    }

    /**
     * 微信端项目列表页ajax
     */
    public function getMoreProjectList($page=1){
        $page = intval($page);
        if($page<1){
            $page = 1;
        }
        $size = 4;

        $projectLogic = new ProjectLogic();

        $list   = $projectLogic->getPreferredProjectlist( [ProjectDb::PROJECT_PRODUCT_LINE_JSX, ProjectDb::PROJECT_PRODUCT_LINE_JAX],
            $page,
            $size,
            [ProjectDb::STATUS_INVESTING, ProjectDb::STATUS_REFUNDING, ProjectDb::STATUS_FINISHED]
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
        $view = [
            'list'          => $list,
        ];
        return_json_format($view);
    }

    /**
     * @desc 已完结项目列表
     */
    public function more()
    {

        $page              = 1;
        $size              = 5;
        $logic             = new ProjectLogic();
        $fundedProject     = $logic->getFinishedList($page, $size);

        $viewData = [
            'size'      => $size,
            'page'      => $page,
            'projects'  => $fundedProject['list'],
            'title'     => '已售罄列表',
        ];

        return view("wap.project.finishedList", $viewData);

    }

    /**
     * @desc 什么是零钱计划
     */
    public function descriptions(){

        $logic  =   new CurrentLogic();

        $currentData    =  $logic->getAppCurrentDetail () ;

        return view('wap.project.descriptions' ,$currentData);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 普付宝项目列表
     */
    public function pfbList(){

        $page  = 1;
        $size  = 10;
        $logic = new ProjectLogic();

        $list  = $logic->getPfbProject($page,$size);
        //dd($list);
        $view  = [
            'project'   => $list['data']
        ];
        return view('wap.project.pfblist',$view);
    }

}