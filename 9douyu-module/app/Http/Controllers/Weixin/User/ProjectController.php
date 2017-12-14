<?php
/**
 * WeChat 用户优选项目信息
 * Created by PhpStorm.
 * User: scofie
 * Date: 2017/9/12
 * Time: PM2:41
 */

namespace App\Http\Controllers\Weixin\User;


use App\Http\Controllers\Weixin\UserController;
use App\Http\Logics\Invest\TermLogic;
use App\Http\Logics\Logic;
use Illuminate\Http\Request;

class ProjectController extends UserController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 优选项目
     */
    public function PreferredItem( Request $request)
    {
        $type 	    =   $request->input('holdType','investing');

        $view['holdType']   =   $type ;

        return view('wap.user.project.index', $view);
    }

    /**
     * @param Request $request
     * @return array
     * @desc  获取用户数据
     */
    public function getUserHoldPreferredItem(Request $request)
    {
        $userId     =   $this->getUserId();

        $page 	    =   $request->input('page',  1);

        $size 	    =   $request->input('size',10);

        # type  投资中，转让中，已完结
        $holdType 	=   $request->input('holdType','investing');

        $termLogic  =   new TermLogic();

        $userTermList=  $termLogic->appV4UserTermRecord($userId, $holdType, $page, $size) ;

        $userTermList['pageTotal']  =   ceil($userTermList['total'] / $size) ;

        return return_json_format ( $userTermList ) ;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @desc 用户的投资详情
     */
    public function investDetail( Request $request)
    {
        $userId     =   $this->getUserId ();

        $investId   =   $request->input ('investId' , '') ;

        return view('wap.user.project.detail', ['investId' =>$investId ]);
    }

    /**
     * @param Request $request
     * @desc 用户投资数据
     */
    public function getUserInvestDetail(Request $request)
    {
        $userId     =   $this->getUserId();

        $investId 	=   $request->input('investId', '');

        $resData    =   TermLogic::wapV4UserTermDetail($userId,$investId);

        return return_json_format($resData);
    }
}