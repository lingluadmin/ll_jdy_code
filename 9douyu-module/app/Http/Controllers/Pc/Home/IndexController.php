<?php
/**
 * Created by PhpStorm.
 * User: caelyn
 * Date: 16/6/17
 * Time: 下午2:33
 * Desc: 首页
 */

namespace App\Http\Controllers\Pc\Home;

use App\Http\Controllers\Pc\PcController;
use App\Http\Logics\Ad\AdLogic;
use App\Http\Logics\Article\ArticleLogic;
use App\Http\Logics\Project\CurrentLogic;
use App\Http\Logics\Project\ProjectLogic;
use App\Http\Logics\Statistics\StatLogic;
use App\Http\Logics\SystemConfig\SystemConfigLogic;
use App\Http\Logics\User\UserLogic;
use App\Http\Dbs\Article\CategoryDb;
use App\Http\Models\Picture\PictureModel;
use Illuminate\Http\Request;
use Redirect;

class IndexController extends PcController
{

    public function index(){

        if($this->isMobile()){
            $wxLink = env("APP_URL_WX");
            return Redirect::to($wxLink);
        }
        //设置弹窗的cookie
        setcookie('ad_already_pop',1);

        $tag    = (isset($_COOKIE['ad_already_pop']) && !empty($_COOKIE['ad_already_pop'])) ? $_COOKIE['ad_already_pop'] : '';

        $ad = [
            'noviceLeft'    => AdLogic::getAdByPositionId(35),  //新手项目（左侧）
            'noviceRight'   => AdLogic::getAdByPositionId(36),  //新手项目（右侧）
            'mediaShow'     => AdLogic::getAdByPositionId(37),  //媒体报道左图
        ];

        $data   = [
            'bannerList'    => AdLogic::getUseAbleListByPositionId(1),
            'tag'           => $tag,
            'ad'            => $ad
        ];
        return view('pc.home.index', $data);
    }

    /**
     * @param Request $request
     * @return array
     * @desc  create pc home data packet
     */
    public function getIndexDataPacket( Request $request)
    {
        $logic = new UserLogic();
        // 用户数据
        $userStatics    =   $logic -> getIndexHomeUserInfo ( $this->getUser () ) ;

        $current        =   (new CurrentLogic())->getShowProject();

        $projectLogic   =   new ProjectLogic();

        $projectArr     =   $projectLogic->getNewIndexProjectPack();

        $homeStat       =   $projectLogic->formatHomeStat($projectArr['stat']);                //平台数据
        unset($projectArr['stat']);

        $projectArr     =   $projectLogic->getFormatHomeProjectList($projectArr);
        //文章相关
        $articleLogic   =   new ArticleLogic();

        $articlePacket  =   $articleLogic->getHomeList();

        //首页注册按钮
        $indexButton    =   SystemConfigLogic::getConfig('INDEX_BUTTON');

        $dataPacket     =   [
            'current'       => $current,
            'articleList'   => $articlePacket,
            'userData'      => $userStatics,
            'indexButton'   => $indexButton,
            'projectList'   => $projectArr,
            'viewUser'      => $this->getUserId () ,
            'homeStat'      => $homeStat,

        ] ;

        return_json_format($dataPacket);
    }

}
