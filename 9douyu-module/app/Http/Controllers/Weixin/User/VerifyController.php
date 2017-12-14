<?php
/**
 * Created by PhpStorm.
 * User: zhangshuang
 * Date: 16/7/27
 * Time: 10:48
 */
namespace App\Http\Controllers\Weixin\User;
use App\Http\Controllers\Weixin\UserController;
use App\Http\Logics\RequestSourceLogic;
use App\Tools\ToolJump;
use Illuminate\Http\Request;
use App\Http\Logics\User\UserLogic;


class VerifyController extends UserController{


    /**
     * @return mixed
     * 实名入口页
     * @param   verifyType - 已实名-1 ， 未实名-0
     */
    public function index(){

        $user = $this->getUser();
        $redirect   =   ToolJump::getLoginUrl();
        if( !empty($redirect)) {
            ToolJump::setLoginUrl ($redirect) ;
        }

        $data = [
            'realName'      => !empty($user['real_name'])       ? $user['real_name']    : '',
            'identityCard'  => !empty($user['identity_card'])   ? $user['identity_card']: '',
            'verifyType'    => !empty($user['real_name'])       ? 1 : 0,
            'redirect'      =>  $redirect
        ];

        return view('wap.user.verify.index', $data);
    }


    /**
     * @param Request $request
     * @return mixed
     * 实名业务逻辑
     */
    public function doVerify( Request $request )
    {

        $name       = $request->input('name','');

        $userId     = $this->getUserId();

        $from       = RequestSourceLogic::getSource();

        $cardNo     = $request->input('card_no','');

        $idCard     = $request->input('id_card','');
        $verifyType = $request->input('verifyType', '0');

        $redirect   = $request->input('redirect','');

        $logic      = new UserLogic();

        $result     = $logic->verify($userId,$name,$cardNo,$idCard,$from,$verifyType);

        if($result['status']){

            $roiProjectId = \Session::get("roiProjectId");
            if($roiProjectId){
                \Session::forget("roiProjectId");
                return redirect("/project/detail/".$roiProjectId);
            }
            $url = !empty($redirect) ? $redirect : '/user/verifySuccess';
            //跳转至交易密码
            return redirect($url)->with('message', '实名认证成功！');

        }else {

            //返回
            return redirect()->back()->withInput($request->input())->with('errors', $result['msg']);

        }

    }


    public function verifySuccess(){

        return view('wap.user.verify.success');
    }
}
