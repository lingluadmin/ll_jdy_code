<?php
/**
 * 账户中心
 * User: bihua
 * Date: 16/7/26
 * Time: 10:44
 */
namespace App\Http\Controllers\Weixin\User;

use App\Http\Controllers\Weixin\UserController;
use App\Http\Logics\AppButton\AppButtonLogic;
use App\Http\Logics\Bonus\UserBonusLogic;
use App\Http\Logics\Fund\FundHistoryLogic;
use App\Http\Logics\Order\OrderListsLogic;
use App\Http\Logics\User\UserLogic;
use App\Tools\ToolPaginate;
use Illuminate\Http\Request;

class IndexController extends UserController
{

    public function appendConstruct(){
        \Debugbar::disable();
    }

    protected $perPageSize = 10;

    function index(){

        $userId = $this->getUserId();

        $userLogic = new UserLogic();

        $user = $userLogic->getAppUserInfo($userId);

        //菜单
        //$appButtonLogic = new AppButtonLogic();

        //$menu = $appButtonLogic->getUserCenterMenu($userId);
        $assign = [
            'user'        => $user['data']['items'],
            //'menuList'    => $menu['data'],
            //'userActive'  => 'active',
        ];

        return view('wap.user.index.user',$assign);
    }


    /**
     * 交易明细
     */
    public function accountBalance()
    {
        $user        = $this->getUser();
        $accountLog  = $this->getLogList();

        $assign = [
            'title'         => '交易明细',
            'balance'       => $user['balance'],
            'totalRecharge' => isset($accountLog['data']['Summary']['recharge_summary']) ? $accountLog['data']['Summary']['recharge_summary'] : 0.00,
            'withdraw'      => isset($accountLog['data']['Summary']['withdraw_summary']) ? $accountLog['data']['Summary']['withdraw_summary'] : 0.00,
            'LogList'       => isset($accountLog['data']) ? $accountLog['data'] : [],
        ];

        return view('wap.user.AccountBalance/balance', $assign);
    }

    /**
     * 交易明细2017/9/18 wap4
     *
     * @param string $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accountRecord($type = 'all')
    {

        $request            = app('request');

        $data               = $request->all();

        $data['type']       = !empty($data['type']) ? $data['type'] : $type;

        $data['page']       = $request->input('page', 1);

        $data['size']       = 10;

        $data['user_id']    = $this->getUserId();

        $return             = FundHistoryLogic::getListByType($data);

        $list               = (isset($return['data']) && !empty($return['data']['data'])) ? $return['data'] : '';


        $paginate           = '';

        if( $list )
        {
            $params['type']       = isset($data['type']) ? $data['type'] : '';
            $params['start_time'] = isset($data['start_time']) ? $data['start_time'] : '';
            $params['end_time']   = isset($data['end_time']) ? $data['end_time'] : '';

            $paramsString         = http_build_query($params);

            $pageTool             = new ToolPaginate($list['total'], $data['page'], $data['size'], '/user/fundhistory' .'?'. $paramsString);

            $paginate             = $pageTool->getPaginate();

            \Log::info(__METHOD__. '__page__', [$paginate]);
        }

        $data = [
            'list'      => (isset($list['data']) && !empty($list['data'])) ? FundHistoryLogic::wapFormatList($list['data']) : '',
            'paginate'  => $paginate,
            'data'      => $data,
        ];

        \Log::info(__METHOD__ . '__data__', [$data]);

        if ($request->ajax())
        {
            $ajax = [
                'list'          => $data['list'],
                'page'          => empty($paginate) ? 1 : $paginate['last_page'],
            ];
            return_json_format($ajax, (!empty($ajax['list']) ? 0 : -1));
        }

        return view('wap.user.AccountBalance/fundhistory', $data);
    }


    /**
     * 交易明细
     *
     * @return array|string
     */
    public function getLogList(){
        $request         = app('request');
        $type            = $request->input('t', 1);

        $data['page']    = $request->input('p', 1);
        $data['size']    = $this->perPageSize;
        $data['user_id'] = $this->getUserId();

        if($type == 1) {
            $return = FundHistoryLogic::getListByType($data);
        }else{
            $return = OrderListsLogic::formatGetListOutput($data);
        }
        $return['data']['size'] = $data['size'];

        $ajax = [];
        if($request->ajax()){
            $assign          = ['LogList' => $return['data']];
            $content         = view('wap.user.AccountBalance/_balance_child', $assign)->render();
            $ajax['content'] = $content;
            $ajax['type']    = $type;
            $ajax['page']    = $data['page'];
            return json_encode($ajax);
        }
        return $return;

    }

    /**
     * @desc 用户可用优惠券列表
     * @author lgh-dev
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ableBonusList(){

        $userId = $this->getUserId();

        $userBonusLogic = new UserBonusLogic();

        $ableBonusList = $userBonusLogic->getBonus($userId);

        $assign['ableBonus']  =  $ableBonusList;

        return view('wap.user.bonus.index4',$assign);
    }

    /**
     * @desc 用户已过期的优惠券列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unableBonusList(){

        $userId = $this->getUserId();

        $userBonusLogic = new UserBonusLogic();

        $unableBonusList = $userBonusLogic->getExpireListByUserId($userId);

        $assign['unableBonus']  =  $unableBonusList;

        return view('wap.user.bonus.unable', $assign);
    }

    /**
     * @desc wap-用户中心优惠券列表[wap4.2改版]
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userBonusList(Request $request)
    {
        $userId = $this->getUserId();

        $type = (int)$request->input('type', 1);

        $logic = new UserBonusLogic();

        $bonusList = $logic->getUserBonusByType($userId, $type);

        return view('wap.user.bonus.index4');
    }

    /**
     * @desc wap-ajax获取红包数据
     * @return json
     */
    public function getAjaxBonusData(Request $request)
    {
        $userId = $this->getUserId();

        $type = (int)$request->input('type', 1);
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 5);

        $logic = new UserBonusLogic();

        //$bonusList = $logic->getUserBonusByType($userId, $type);
        $bonusList = $logic->getUserBonusList($userId, $page, $size, $type, true);
        $page_total = $bonusList['data']['page']['last_page'];

        unset($bonusList['data']['page']);
        $data = [
            'list' => $bonusList['data'],
            'page_total' => $page_total,
            ];

        return_json_format($data);
    }

    /**
     * @desc 投资选择优惠券
     * @author
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bonusList(){

        return view('wap.user.bonus.list');
    }

    /**
     * @desc 总资产
     * @author 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function asset(){

        $userId = $this->getUserId();

        $userLogic = new UserLogic();

        $user = $userLogic->getAppUserInfo($userId);

        $assign = [
            'user'        => $user['data']['items'],
        ];

        return view('wap.user.index.asset',$assign);
    }

}
