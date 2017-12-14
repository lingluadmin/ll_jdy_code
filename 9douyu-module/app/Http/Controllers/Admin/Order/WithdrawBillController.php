<?php
/**
 * Created by PhpStorm.
 * User: caelyn
 * Date: 16/6/3
 * Time: 上午10:35
 * Desc: 提现自动对账控制器
 */

namespace App\Http\Controllers\Admin\Order;

use App\Http\Dbs\Order\CheckBatchDb;
use App\Http\Logics\Order\WithdrawBillLogic;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Logics\Oss\OssLogic;
use App\Http\Models\Order\CheckBatchModel;
use App\Tools\AdminUser;
use App\Tools\ToolTime;
use Illuminate\Http\Request;
use App\Http\Logics\Recharge\CheckBatchLogic;
use App\Tools\ToolPaginate;
use Redirect;

/**
 * Class WithdrawBillController
 * @package App\Http\Controllers\Admin\Withdraw
 */
class WithdrawBillController extends AdminController{

    CONST
        SIZE = 20;

    /**rout
     * 自动对账form表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkBill(Request $request ){

        $page       = $request->get('page',1);
        $size       = self::SIZE;

        $logic      = new CheckBatchLogic();
        $list       = $logic->getWithdrawList($page , $size);

        $toolPaginate=new ToolPaginate($list['total'], $page, $size, '/admin/withdraw/checkBill');

        $paginate   = $toolPaginate->getPaginate();

        $viewData   = [
            'list'      => $list['list'],
            'total'     => $list['total'],
            'paginate'  => $paginate,
        ];

        #$data['uploadData'] = $this->getCache();
        return view('admin.order.withdrawCheckBill', $viewData);
    }

    /**
     * 自动对账提交
     * @param Request $request
     */
    public function uploadBill(Request $request){
        $file   = $_FILES['billFile'];
        $payChannel = $request->input('payChannel','jd');
        $doUpload   = "";
        //获取excel内容
        $withdrawBillLogic = new WithdrawBillLogic();

        if($payChannel == "suma" || $payChannel == "ucf"){

            $ossLogic = new OssLogic();
            //上传到oss public目录下
            $doUpload = $ossLogic->putFile($file,'uploads/withdrawbills');

            if(!$doUpload['status']){
                return Redirect::to('admin/withdraw/checkBill')->with('message',$doUpload['msg']);
            }

            $reader     = \Excel::load($file['tmp_name']);
            $data       = $reader->getSheet(0)->toArray();
            if($payChannel == "suma"){
                $note   = "丰付提现对账";
                $result     = $withdrawBillLogic->loadExcelSuma($data);
            }else{
                $note   = "先锋提现对账";
                $result     = $withdrawBillLogic->loadExcelUcf($data);
            }
        }else{
            $note   = "京东提现对账";
            $result = $withdrawBillLogic->loadExcel($file['tmp_name']);
        }

        //入库
        if(!empty($result)){

            if(isset($result['status']) && $result['status']==false){
                return Redirect::to('admin/withdraw/checkBill')->with('message',$result['msg']);
            }
            $res    = $withdrawBillLogic->addBillInfo($result);

            if($res['status']){
                $this->setCache($file['name']);

                $model      =   new CheckBatchModel();

                $data['name']       = $file['name'];
                $data['status']     = CheckBatchDb::STATUS_SUCCESS;
                $data['admin_id']   = AdminUser::getAdminUserId();
                $data['pay_channel']= CheckBatchDb::WITHDRAW_CHECK_BILL;
                $data['note']       = $note;
                $data['file_path']  = '/'.$doUpload['data']['path'].'/'.$doUpload['data']['name'];

                $model->doAdd($data);

                return Redirect::to('admin/withdraw/checkBill')->with('message',$res['msg']);
            }
            return Redirect::back()->with('message',$res['msg']);

        }
        return Redirect::to('admin/withdraw/checkBill');

    }

    /**
     * @return mixed
     * @desc 获取缓存
     */
    private function getCache(){

        return \Cache::get(ToolTime::dbDate().'_U_P_B', []);

    }

    /**
     * @param $fileName
     * @return mixed
     * @desc 设置缓存
     */
    private function setCache($fileName){

        $data = $this->getCache();

        $data[] = $fileName;

        return \Cache::put(ToolTime::dbDate().'_U_P_B', $data, 1440);

    }

}
