<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 16/7/18
 * Time: 下午5:19
 */

/*
 * pc 路由
 */

Route::group(['prefix' => '/', 'namespace' => 'Pc' ,'domain'=> $domain], function()
{
    Route::get('/', 'Home\IndexController@index');   //网站首页
    Route::get('login', 'User\LoginController@index');                          //pc 登陆页面
    Route::post('login/doLogin', 'User\LoginController@doLogin');               //pc 执行登陆
    Route::get('logout', 'User\LoginController@out');                           //pc 执行登出

    Route::get('forgetLoginPassword', 'User\LoginController@forgetLoginPassword');//pc 找回登录密码第一步[验证码]
    Route::get('verifyLoginPassword', 'User\LoginController@UserInfoVerify');//pc 找回登录密码第二步 验证码用户实名信息
    Route::any('resetLoginPassword', 'User\LoginController@resetLoginPassword');//pc 找回登录密码第三步，设置密码
    Route::post('doForgetPassword', 'User\LoginController@doForgetPassword');//pc 找回登录密码执行


//    Route::any('doResetLoginPassword', 'User\LoginController@doResetLoginPassword');//pc 设置登录密码处理
//    Route::get('forgetPasswordSetSuccess', 'User\LoginController@forgetPasswordSetSuccess');//pc 找回登录密码成功页面
//    Route::post('resetLoginPassword/sendSms', 'User\LoginController@sendSms');//pc 找回登录密码成功页面

    Route::get('register', 'User\RegisterController@index');                    //pc 注册页面
    Route::post('register/doRegister', 'User\RegisterController@doRegister');   //pc 注册处理
    Route::post('register/sendSms', 'User\RegisterController@sendSms');         // 发送注册短信验证码
    Route::post('register/getTestingPhoneCode', 'User\RegisterController@getTestingPhoneCode');         // 测试过程获取注册短信验证码

    /*项目详情*/
    Route::get('project/index', 'Project\IndexController@index');
    Route::get('project/sdf', 'Project\IndexController@sdfList');
    Route::get('project/debt', 'Project\IndexController@debt');

    Route::get('project/list/{page}', 'Project\IndexController@getProjectList');
    //智享计划列表
    Route::get('project/smartList/{page}', 'Project\IndexController@getSmartProjectList');

    /*项目详情*/
    Route::get('project/detail/{id}', 'Project\ProjectDetailController@get');
    /*项目详情 文章内别名*/
    Route::get('project/{id}', 'Project\ProjectDetailController@get');

    /*PC端零钱计划项目详情页*/
    Route::get('project/current/detail','Project\ProjectDetailController@getCurrent');

    /*用户中心*/
    Route::get('user', 'User\IndexController@index');

    /*文章详情*/
    Route::get('article/{id}','Article\ArticleController@detail');
    //平台数据统计
    Route::get('zt/statistics', 'Zt\StatisticsController@index');

    Route::get('pc','Home\IndexController@index');

    /*帮助中心*/
    Route::get('help/{id?}','Article\ArticleController@help');
    Route::get('risk/{id?}','Article\ArticleController@risk');

    /*404错误页面*/
    Route::get('error', 'Article\ArticleController@error');

    /*系统升级*/
    Route::get('upgrade', 'Article\ArticleController@upgrade');

    /*关于我们*/
    /*公司介绍Company Profile*/
    Route::get('about', 'Article\AboutController@index');
    Route::get('about/team', 'Article\AboutController@team');
    Route::get('about/honor', 'Article\AboutController@honor');
    Route::get('about/index', 'Article\AboutController@index');
    Route::get('about/index.html', 'Article\AboutController@index');
    /*中国耀盛China Glory Shine*/
    Route::get('about/sunholding', 'Article\AboutController@sunholding');
    /*合作伙伴Partner*/
    Route::get('about/partner', 'Article\AboutController@partner');
    /*媒体报道Media*/
    Route::get('about/media', 'Article\AboutController@media');
    /*网站公告Notice*/
    Route::get('about/notice', 'Article\AboutController@notice');
    Route::any('ajax/about/notice', 'Article\AboutController@ajaxNotice');
    Route::any('ajax/about/refund', 'Article\AboutController@ajaxNoticeRefund');
    /*加入我们Join Us*/
    Route::get('about/joinus', 'Article\AboutController@joinus');
    /*分支机构Branch*/
    Route::get('about/branch', 'Article\AboutController@branch');
    /*安全保障*/
    Route::get('about/insurance', 'Article\AboutController@insurance');
    /*发展历程*/
    Route::get('about/development', 'Article\AboutController@development');
    /*联系我们*/
    Route::get('about/contactus', 'Article\AboutController@contactus');
    /*新手指引*/
    Route::get('content/article/newentrance', 'Article\AboutController@newentrance');
    /**/
    Route::any('content/article/reservefund', 'Article\AboutController@reservefund');

    /* 安全保障pc4.2 */
    Route::any('about/security', 'Article\AboutController@security');

    // 生成短信长连接
    Route::any('smslink',           'Article\AboutController@smslink');

    /* 收益计算器 */
    Route::get('calculator', 'Article\AboutController@calculator');
    /* AAA信用评级.2 */
    Route::any('about/AAA', 'Article\AboutController@aaa');

    /* 认证跳转页 */
    Route::get('home/util/cnnic', 'Home\UntilController@cnnic');
    Route::get('home/util/plist', 'Home\UntilController@plist');
    /*机构信息*/
    Route::get('about/companyinfo', 'Article\AboutController@companyinfo');
     /*平台合规*/
    Route::get('compliance', 'Article\AboutController@compliance');



    /*首页*/
    Route::get('home','Home\IndexController@index');

    /*用户中心零钱计划页面*/
    Route::post('user/currentFund','User\IndexController@currentFund');

    /*用户中心账户设置*/
    Route::get('user/setting','User\SettingsController@index');

    /*用户中心 账户设置 手机号修改 第一步视图 */
    Route::get('user/setting/phone/stepOne', 'User\SettingsController@modifyPhoneViewStepOne');

    /*用户中心 账户设置 修改手机号 执行修改*/
    Route::post('user/setting/phone/modify', 'User\SettingsController@modifyPhone');

    /*用户中心 账户设置 手机号修改 交易密码验证*/
    Route::post('user/setting/phone/doVerifyTransactionPassword', 'User\SettingsController@verifyTransactionPassword');

    /*用户中心 账户设置 修改手机号 发送验证码*/
    Route::post('user/setting/phone/sendSms', 'User\SettingsController@sendSms');
    //验证类短信验证码
    Route::post('user/setting/verify/sendSms', 'User\SettingsController@sendVerifySms');

    /*用户实名+绑卡*/
    Route::get('user/setting/verify','User\SettingsController@verify');
    Route::get('user/verify','User\IndexController@verify');

    Route::post('user/setting/doVerify','User\SettingsController@doVerify');

    /*修改密码*/
    Route::get('user/password', 'User\SettingsController@password');
    Route::post('user/doPassword', 'User\SettingsController@doPassword');

    Route::get('user/setting/tradingPassword', 'User\SettingsController@tradingPassword');
    Route::post('user/setting/doTradingPassword', 'User\SettingsController@doTradingPassword');
    Route::get('user/settings/success', 'User\SettingsController@success');
    Route::get('user/settings/fail', 'User\SettingsController@fail');


    /* 修改交易密码页面 */
    Route::get('user/modify/tradingPassword', 'User\SettingsController@changeTradingPassword');
    /* 修改交易密码执行操作 */
    Route::post('user/doTradingPassword', 'User\SettingsController@doChangeTradingPassword');

    /* 找回交易密码 */
    Route::post('common/sendSms', 'CommonController@sendSms');
    Route::get('user/forgetTradingPassword', 'User\SettingsController@forgetTradingPassword');//第一步［验证码]
    Route::get('user/vaildTradingPassword', 'User\SettingsController@vaildTradingPassword');//第二步 验证身份信息
    Route::get('user/findTradingPassword', 'User\SettingsController@findTradingPassword'); //第三步 设置交易密码
    Route::post('user/doForgetTradingPassword', 'User\SettingsController@doForgetTradingPassword'); // 交易密码分步验证并设置


    /*PC端首页平台数据详情*/
    Route::get('getHomeStatistics','Home\StatisticsController@index');
    Route::get('user/bankcard','User\CardController@index');
    Route::get('user/bankcard/add','User\CardController@addBankCard');
    Route::post('user/bankcard/submit','User\CardController@submit');
    Route::get('user/bankcard/success','User\CardController@success');

    Route::get('user/fundhistory','User\FundHistoryController@getListByType');
    Route::get('user/investList','User\DownloadFileController@userInvestList');
    Route::get('user/ajaxCommonInvestList/{type?}/{status?}/{page?}','User\DownloadFileController@ajaxGetCommonInvestList');
    Route::get('user/ajaxSmartInvestList/{status?}/{page?}','User\DownloadFileController@ajaxGetSmartInvestList');
    Route::post('contract/doCreateDownLoad' ,  'User\DownloadFileController@doCreateDownLoad');
    Route::post('contract/checkContractStatus' ,  'User\DownloadFileController@checkContractStatus');



    /*投资模块*/
    Route::post('invest/term/confirm','Invest\TermController@confirm');
    Route::post('invest/term/submit','Invest\TermController@submit');
    Route::get('invest/term/success','Invest\TermController@success');
    Route::get('invest/term/fail','Invest\TermController@fail');
    Route::post('invest/project/confirm','Invest\ProjectController@confirmInvest');
    Route::get('invest/project/success','Invest\ProjectController@success');


    /*新的定期投资页面*/
    Route::any('invest/project/doInvest','Invest\ProjectController@doInvest');
    Route::post('invest/project/investConfirm','Invest\ProjectController@investConfirm');
    Route::get('project/getDetail/{id}', 'Project\ProjectDetailController@extra');
    Route::get('project/invest/list/{pid}/{page}', 'Project\ProjectDetailController@investList');

    /*智能计划项目详情*/
    Route::get('smartInvest/detail/{id}', 'Project\SmartInvestDetailController@get');
    Route::get('smartInvest/project/credit/{projectNo}/{page}', 'Project\SmartInvestDetailController@projectCreditRelation');

    /*零钱计划转入*/
    Route::post('invest/current/doInvest','Invest\CurrentController@doInvest');

    /*零钱计划转入成功*/
    Route::get('invest/current/investSuccess','Invest\CurrentController@investSuccess');

    /*零钱计划投资确认页面*/
    Route::any('invest/current/confirm','Invest\CurrentController@confirm');
    /*零钱计划转出*/
    Route::post('invest/current/doInvestOut','Invest\CurrentController@doInvestOut');

    //提现相关页面
    Route::get('pay/withdraw','Order\WithdrawController@index');
    Route::post('pay/withdraw/submit','Order\WithdrawController@submit');
    Route::get('pay/withdraw/success/{orderId}','Order\WithdrawController@success');
    //TODO: 三端改版-提现Ajax提交
    Route::post('pay/withdraw/ajaxSubmit','Order\WithdrawController@ajaxSubmit');

    /*闪电付息*/
    Route::get('project/sdf', 'Project\PreProjectController@index');
    /*闪电付息 确认投资页 Invest/Project/preDoInvest?id=1888*/
    Route::any('invest/sdf/investConfirm', 'Project\PreProjectController@investConfirm');
    /*闪电付息 确认交易密码 Ajax*/
    Route::post('user/ajaxCheckTradePassword', 'User\IndexController@checkTradePassword');

    /*PC端查看零钱计划债权*/
    Route::post('current/viewCredit','Current\CreditController@view');

    Route::post('current/checkAjax', 'Invest\CurrentController@checkAjax');

    /**
     * 定期资产
     */
    Route::get('user/term/investing', 'User\RefundController@getInvesting');
    Route::get('user/term/refunding', 'User\RefundController@getRefunding');
    Route::get('user/term/refunded', 'User\RefundController@getRefunded');


    /*****************************充值相关******************************/

    Route::get('recharge/index','Pay\RechargeController@index');
    Route::get('recharge/online','Pay\RechargeController@online');      //网银支付
    Route::post('recharge/submit','Pay\RechargeController@submit');
    Route::post('recharge/qdbSubmit','Pay\RechargeController@qdbSubmit');
    Route::post('recharge/reaSubmit','Pay\RechargeController@reaSubmit');
    Route::post('recharge/umpSubmit','Pay\RechargeController@umpSubmit');
    Route::post('recharge/bestSubmit','Pay\RechargeController@bestSubmit');
    #丰付支付
    Route::post('recharge/sumaSubmit',  'Pay\RechargeController@sumaSubmit');

    Route::get('app_guide','Article\ArticleController@download');

    /*************************PC端活动相关***********************************/
    /* 记录活动标示*/
    Route::post('activity/setActToken', 'Activity\ActivityController@setActToken');

    Route::get('activity/spike', 'Activity\SpikeController@activity');
    //项目加息
    Route::get('activity/interest', 'Activity\SpikeController@interest');

    // 晋升中关村金融协会副会长
    Route::get('activity/president', 'Activity\PresidentController@index');

    // 极客评选专题
    Route::get('activity/geeks', 'Activity\GeeksController@index');
    Route::get('activity/geeks/receiveBonus', 'Activity\GeeksController@doReceiveBonus');

    Route::get('activity/national', 'Activity\NationalController@index');

    // 邀请好友
    Route::get('activity/partner', 'Activity\PartnerController@index');

    // 2017国庆活动
    Route::get('activity/national/2017', 'Activity\NationalController@index2017');
    //执行领取国庆红包
    Route::post('activity/getNationBonus', 'Activity\NationalController@doGetNationBonus');
    //执行领取中秋红包
    Route::post('activity/getAutumnBonus', 'Activity\NationalController@doGetAutumnBonus');
    //获取国庆数据包ajax
    Route::post('activity/getActivityData', 'Activity\NationalController@getActivityData');

    //投资PK
    Route::get('activity/investpk/firstphase', 'Activity\InvestGameController@firstPhase');
    //投资PK 第二期
    Route::get('activity/investment/secondPhase', 'Activity\InvestGameController@secondPhase');
    //投资PK第三期
    Route::get('activity/investment/thirdPhase', 'Activity\InvestGameController@thirdPhase');
    //投资PK第四期
    Route::get('activity/investment/forthPhase', 'Activity\InvestGameController@forthPhase');


    Route::get('activity/halloween', 'Activity\HalloweenController@index');
    Route::post('activity/halloween/doLottery', 'Activity\HalloweenController@doLuckDraw');

    /* 投票 chanllenge 高校挑战赛*/
    Route::get('activity/challenge', 'Activity\ActivityVoteController@index');
    Route::get('activity/challenge/detail', 'Activity\ActivityVoteController@detail');
    Route::post('activity/challenge/doVote', 'Activity\ActivityVoteController@doVote');
    Route::any('redirect/{type}/{source}/{sourceId}', 'Home\IndexController@index');
    //双蛋活动 红包雨
    Route::get('activity/festival', 'Activity\DoubleFestivalController@festival');
    Route::get('activity/festivalTwo', 'Activity\DoubleFestivalController@festivalTwo');
    // 3% 零钱计划 加息
    Route::get('activity/bonusDay', 'Activity\ReceiveBonusController@bonus');

    //春节活动
    Route::get('activity/springFestival', 'Activity\SpringFestivalController@index');
    //春节签到
    Route::post('activity/spring/signIn', 'Activity\SpringFestivalController@doSignIn');
    //春节抽奖
    Route::post('activity/spring/lottery', 'Activity\SpringFestivalController@doLotterySpring');

    Route::post('activity/spring/exchange', 'Activity\SpringFestivalController@doExchange');
    //春游活动
    Route::get('activity/invitation', 'Activity\InvitationController@index');
    // 元宵节
    Route::get('activity/lantern', 'Activity\LanternController@index');
    Route::post('activity/lantern/doGuessRiddles', 'Activity\LanternController@doGuessRiddles');
    //投资加币活动
    Route::get('activity/canadian', 'Activity\CanadianController@index');
    //春风十里 领现金券活动
    Route::get('activity/coupon', 'Activity\CouponController@coupon');
    Route::post('activity/receive', 'Activity\CouponController@doReceiveBonus');
    Route::get('activity/coupon/packet', 'Activity\CouponController@getLotteryPacket');   //页面展示的数据包

    // 双十一活动 2017
    Route::get('activity/doubleEleven', 'Activity\DoubleElevenController@index');
    Route::post('activity/doubleEleven/doSign', 'Activity\DoubleElevenController@doSign');
    Route::post('activity/doubleEleven/doGetBonus', 'Activity\DoubleElevenController@doReceiveRechargeBonus');
    Route::post('activity/doubuleEleven/quitLottery', 'Activity\DoubleElevenController@quitLottery');//取消抽奖操作
    Route::get('activity/doubleEleven/asyncData', 'Activity\DoubleElevenController@getDoubleData');

   // 双十二活动 2017
    Route::get('activity/doubleTwelve', 'Activity\DoubleTwelveController@index');
    Route::get('activity/doubleTwelve/asyncData', 'Activity\DoubleTwelveController@getDoubleData');
    Route::post('activity/doubleTwelve/doGetBonus', 'Activity\DoubleTwelveController@doReceiveBonus');


    // 冬日活动
    Route::get('activity/winter', 'Activity\WinterController@index');
    Route::get('activity/winter/asyncData', 'Activity\WinterController@getSyncViewData');
    Route::post('activity/winter/receive', 'Activity\WinterController@doReceivePackage');

    //五一活动
    Route::get('activity/LabourDay', 'Activity\LabourDayController@index');
    //五一签到
    Route::post('activity/LabourDay/signIn', 'Activity\LabourDayController@doSignIn');
    //五一抽奖
    Route::post('activity/LabourDay/lottery', 'Activity\LabourDayController@doLottery');
    //五一兑换红包
    Route::post('activity/LabourDay/exchange', 'Activity\LabourDayController@doExchange');

    // 快金-我要借款
    Route::get('timecash/timecashloan', 'TimeCash\TimeCashController@index');
    Route::post('timecash/dotimecashloan', 'TimeCash\TimeCashController@doLoan');

    // 315专题
    Route::get('activity/zt315', 'Activity\Zt315Controller@index');
    // 金融大会专题
    Route::get('activity/finance', 'Activity\FinanceController@index');
    // 江苏银行
    Route::get('activity/custody', 'Activity\CustodyController@index');
     // 江西银行存管
    Route::get('activity/secondCustody', 'Activity\CustodyController@secondCustody');
     // 夏不为利
    Route::get('activity/July', 'Activity\JulyController@July');
    // 小贷专题
    Route::get('activity/Loan', 'Activity\ActivityController@CelebrationLoan');
    Route::post('activity/LoanBonus', 'Activity\ActivityController@doDrawBonus');
    // 金融科技杰出贡献奖专题
    Route::get('activity/contribution', 'Activity\ContributionController@index');


     // 推广落地页
    Route::get('activity/landon', 'Activity\LandonController@index');
    Route::get('activity/landonSuccess', 'Activity\LandonController@success');

    // 百度推广落地页
    Route::get('activity/extension', 'Activity\NoviceController@extensionChannel');

    // 立秋
    Route::get('activity/Autumn', 'Activity\AutumnController@index');
    Route::get('activity/autumn/project', 'Activity\AutumnController@getProject');
    Route::post('activity/autumn/luckDraw', 'Activity\AutumnController@doLuckDraw');

    // 新手活动
    Route::get('Novice/extension', 'Activity\NoviceController@extension');
    Route::get('redirect/noviceProject', 'Activity\NoviceController@toInvestNovice');

    // 风险承受能力测评表1
    Route::get('user/riskAssessment', 'User\IndexController@riskAssessment');
    // 风险承受能力测评表1
    Route::get('user/riskAssessment2', 'User\IndexController@riskAssessment2');
    // 风险承受能力测评表2
    Route::any('user/riskAssessmentSecond', 'User\IndexController@riskAssessmentSecond');
    // 风险承受能力测评
    Route::post('user/assessment', 'User\IndexController@doAssessment');
    // 取消风险评估弹框
    Route::post('user/assessmentOff', 'User\IndexController@doAssessmentOff');

    /***************三周年的庆典活动****************/
    //第一趴 first part
    Route::get('thirdAnniversary/firstPart', 'Activity\ThirdAnniversaryController@firstPart');
    //抽奖活动
    Route::post('thirdAnniversary/luckDraw', 'Activity\ThirdAnniversaryController@doLuckDraw');
    //用户抽奖信息
    Route::get('thirdAnniversary/userLevel', 'Activity\ThirdAnniversaryController@getLotteryConfig');

    //周年庆第二趴
    Route::get('thirdAnniversary/secondPart', 'Activity\ThirdAnniversaryController@secondPart');
    //排名数据
    Route::get('thirdAnniversary/ranking', 'Activity\ThirdAnniversaryController@getSecondRanking');
    //周年庆第三趴
    Route::get('thirdAnniversary/thirdPart', 'Activity\ThirdAnniversaryController@thirdPart');
    //周年庆第三趴展示的奖品的中奖记录
    Route::get('thirdAnniversary/triplePrize', 'Activity\ThirdAnniversaryController@getThirdLottery');
    /**********三周年公共部分数据*************/
    //三周年伴手礼记录和奖品配置
    Route::get('thirdAnniversary/souvenir', 'Activity\ThirdAnniversaryController@getLottery');
    //项目数据
    Route::get('thirdAnniversary/showProject', 'Activity\ThirdAnniversaryController@getProject');
    //获取投资总额
    Route::get('thirdAnniversary/summation', 'Activity\ThirdAnniversaryController@getInvestPercentage');

    Route::get('registerAgreement', 'Article\ArticleController@registerAgreement');


    /**********************[PC端改版-4-2新增路由]*******************/
    //设置常用邮箱
    Route::get('user/setting/email', 'User\SettingsController@setEmail');

    //修改常用邮箱的第一步和第二步
    Route::get('user/modify/email/stepOne', 'User\SettingsController@modifyEmailStepOne');
    Route::any('user/modify/email/stepTwo', 'User\SettingsController@modifyEmailStepTwo');

    //执行设置邮箱-修改邮箱
    Route::any('user/setting/doSetEmail', 'User\SettingsController@doSetEmail');

    //发送邮件激活邮箱
    Route::any('user/send/activeEmail', 'User\SettingsController@sendSetEmail');

    //设置紧急联系人
    Route::get('user/setting/urgentPhone', 'User\SettingsController@setUrgentPhone');

    //修改紧急联系人第一步和第二步
    Route::get('user/modify/urgent/stepOne', 'User\SettingsController@modifyUrgentStepOne');
    Route::any('user/modify/urgent/stepTwo', 'User\SettingsController@modifyUrgentStepTwo');

    //执行设置/修改紧急联系人的操作
    Route::post('user/setting/doUrgentPhone', 'User\SettingsController@doUrgentPhone');

    //修改设置联系人的地址
    Route::get('user/setting/address', 'User\SettingsController@setUserAddress');
    /*执行设置联系人地址*/
    Route::post('user/setting/modifyAddress', 'User\SettingsController@doSetUserAddress');


    //用户中心回款日历
    Route::any('user/refundPlan', 'User\RefundController@getUserRefundRecord');

    //用户优惠券
    Route::get('user/bonus/{type?}', 'User\BonusController@index');
    Route::post('user/getBonusAjaxData', 'User\BonusController@getBonusAjaxData');

    //用户消息中心
    Route::get('user/message', 'User\IndexController@message');
    Route::post('user/setNoticeRead', 'User\IndexController@setNoticeRead');

    //用户投资详情页面
    Route::get('user/invest/detail','User\FundHistoryController@investDetail');

    //智投计划用户投资详情页面
    Route::get('user/invest/smartDetail','User\FundHistoryController@investSmartDetail');
    Route::get('user/invest/smartDetailAjax',       'User\FundHistoryController@investSmartDetailAjax');

    //智投计划用户投资资金匹配详情页面
    Route::get('user/invest/smartMatchDetail',      'User\FundHistoryController@investSmartMatchDetail');
    Route::get('user/invest/smartMatchDetailAjax',  'User\FundHistoryController@investSmartMatchDetailAjax');

    /*智投计划页面*/

    Route::any('smart/invest/apply','Invest\ProjectController@investBeforeRefundApply');

    Route::post('smart/invest/doApply','Invest\ProjectController@doInvestBeforeRefundApply');

    /**********异步加载的数据路由*********/
    Route::get('/home/getPacket', 'Home\IndexController@getIndexDataPacket');   //网站网站首页数据包
    Route::get('/user/investDetail', 'User\FundHistoryController@getInvestDetailPacket');   //网站网站首页数据包


});
