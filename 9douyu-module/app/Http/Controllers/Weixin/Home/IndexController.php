<?php
/**
 * create By Phpstorm
 * @author linguanghui
 * Date 16/07/25  AM 10:43
 * @desc 微信首页
 */
namespace App\Http\Controllers\Weixin\Home;

use App\Http\Controllers\Weixin\WeixinController;
use App\Http\Logics\Ad\AdLogic;
use App\Http\Logics\Article\ArticleLogic;
use App\Http\Logics\Invest\CurrentLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Logics\RequestSourceLogic;
use App\Http\Models\Common\IncomeModel;
use App\Http\Models\Picture\PictureModel;
use App\Tools\ToolJump;

class IndexController extends WeixinController{
    /**
     * @desc Wap端首页
     * @author linguanghui
     */
    public function index(){
        $wapBannerList = AdLogic::getUseAbleListByPositionId(2);

        //首页定期项目列表
        $projectLogic   = new ProjectLogic();
        $projectArr     = $projectLogic->getProjectPackAppV413();

        //格式化定期项目
        $projectArr     = $projectLogic->getProjectRecordAppV413Format($projectArr);

        #新手项目
        $projectNovice[]  = $projectArr["novice"];

        unset($projectArr["novice"]);
        $projectArrNew  = [];
        foreach ($projectArr as $val){
            $projectArrNew[]    = $val;
        }

        //头条
        $articleLogic = new ArticleLogic();
        $article = $articleLogic->getAppV4Article([18],3);//获取1条记录
        $article = $articleLogic->formatArticle($article);//格式化wap首页头条数据

        $data = [
            'novice_project'    => $projectNovice,   //新手项目
            'invest_project'    => $projectArrNew,   //项目列表
            'wapBannerList'     => $wapBannerList,   //Banner
            'article'           => $article,         //头条
        ];

        return view('wap.home.index', $data);
    }
}