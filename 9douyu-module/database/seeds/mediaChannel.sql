
INSERT INTO `{db_prefix}media_group` (`id`, `name`, `desc`, `created_at`, `updated_at`)
VALUES
	(65, 'SM', '神马', '2016-05-20 17:12:35', '2016-09-18 16:44:56'),
	(66, 'FY', 'FY', '2016-05-20 17:12:45', '2016-09-18 16:45:13'),
	(67, 'JRTT', '今日头条', '2016-05-20 17:12:53', '2016-09-18 16:44:56'),
	(68, 'DSP', 'DSP', '2016-05-20 17:13:02', '2016-09-18 16:44:56'),
	(69, 'LB', '猎豹', '2016-05-20 17:13:29', '2016-09-18 16:44:56'),
	(72, 'Black', '黑包', '2016-06-01 17:36:53', '2016-09-18 16:44:56'),
	(73, '2周年', '2周年', '2016-06-06 19:19:57', '2016-09-18 16:45:07'),
	(74, '百度手机助手', '百度手机助手', '2016-06-07 16:55:28', '2016-09-18 16:44:56'),
	(75, '新手活动S8', '2.2.4', '2016-06-08 09:07:34', '2016-09-18 16:44:56'),
	(76, 'UC', 'UC', '2016-06-12 16:19:04', '2016-09-18 16:44:56'),
	(77, '网址导航', '网址导航', '2016-06-12 17:52:17', '2016-09-18 16:44:56'),
	(78, 'IOS-app store', 'IOS', '2016-06-12 19:08:29', '2016-09-18 16:44:56'),
	(79, '欧洲杯', '105', '2016-07-04 15:47:59', '2016-09-18 16:44:56'),
	(80, '地推', '2.2.106', '2016-07-19 14:24:24', '2016-09-18 16:44:56'),
	(81, '小知', '2.2.106', '2016-08-01 17:44:26', '2016-09-18 16:44:56'),
	(82, '豌豆荚', '2.2.106.', '2016-08-22 17:13:04', '2016-09-18 16:44:56'),
	(83, '网易有道', '2.2.888', '2016-08-30 14:00:48', '2016-09-18 16:44:56');


INSERT INTO `{db_prefix}media_channel` (`id`, `group_id`, `name`, `desc`, `url`, `package`, `award_key`, `start_date`, `end_date`, `created_at`, `updated_at`)
VALUES
	(1400464, 65, 'sm_news', '神马新手注册页', 'http://wx.9douyu.com/register?channel=sm_news', 'jiudouyu2.2.1_shenma_news100_1400464.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:47:44'),
	(1400466, 68, 'DSP_news', 'dsp新手注册页', 'http://wx.9douyu.com/register?channel=DSP_news', 'jiudouyu2.2.888_1400466DSP_news.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:57:23'),
	(1400486, 66, 'fy_news', '新浪扶翼新手注册页', 'http://wx.9douyu.com/register?channel=fy_news', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1400489, 68, 'DSP_download', 'dsp下载页', 'http://wx.9douyu.com/register?channel=DSP_download', 'jiudouyu2.2.888_1400489DSP_download.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:57:34'),
	(1400631, 67, 'jrtt_download', '今日头条下载页面', 'http://wx.9douyu.com/register?channel=jrtt_download', 'jiudouyu2.2.888_1400631jrtt_download.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:53:43'),
	(1400774, 66, 'fy_family', '新浪扶翼家庭账户推广页', 'http://wx.9douyu.com/register?channel=fy_family', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1400775, 68, 'DSP_family', 'dsp家庭账户推广页', 'http://wx.9douyu.com/register?channel=DSP_family', 'jiudouyu2.2.888_1400775DSP_family.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:57:49'),
	(1400776, 65, 'sm_family', '神马家庭账户推广页', 'http://wx.9douyu.com/register?channel=sm_family', 'jiudouyu2.2.1_2016-05-12__1400776family.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:47:49'),
	(1400777, 67, 'jrtt_family', '今日头条家庭账户推广页', 'http://wx.9douyu.com/register?channel=jrtt_family', 'jiudouyu2.2.888_1400777jrtt_family.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:56:43'),
	(1401056, 67, 'jrtt_news', '今日头条新手注册页', 'http://wx.9douyu.com/register?channel=jrtt_news', 'jiudouyu2.2.888_1401056jrtt_news.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:56:54'),
	(1401150, 69, 'lb_family', '猎豹家庭账户推广页', 'http://wx.9douyu.com/register?channel=lb_family', 'jiudouyu2.2.104_1401150lb_family.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:58:01'),
	(1401151, 69, 'lb_news', '猎豹新手注册推广页', 'http://wx.9douyu.com/register?channel=lb_news', 'jiudouyu2.2.106_1401151lbnews.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:58:09'),
	(1401152, 69, 'lb_download', '猎豹下载页', 'http://wx.9douyu.com/register?channel=lb_download', 'jiudouyu2.2.104_1401152lb_download.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:58:18'),
	(1401190, 69, 'lb_news2', '猎豹新手注册页2', 'http://wx.9douyu.com/register?channel=lb_news2', 'jiudouyu2.2.3_1401190lbnews2.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:58:30'),
	(1401191, 69, 'lb_news3', '猎豹新手注册页3', 'http://wx.9douyu.com/register?channel=lb_news3', 'jiudouyu2.2.104_1401194lb_download3.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:58:39'),
	(1401192, 69, 'lb_news4', '猎豹新手注册页4', 'http://wx.9douyu.com/register?channel=lb_news4', 'jiudouyu2.2.3_1401192lbnews4.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:58:57'),
	(1401193, 69, 'lb_download2', '猎豹直投下载包', 'http://wx.9douyu.com/register?channel=lb_download2', 'jiudouyu2.2.104_1401193lb_download2.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:59:06'),
	(1401194, 69, 'lb_download3', '猎豹直投下载包', 'http://wx.9douyu.com/register?channel=lb_download3', 'jiudouyu2.2.104_1401194lb_download3.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:59:13'),
	(1401195, 69, 'lb_download4', '猎豹直投下载包', 'http://wx.9douyu.com/register?channel=lb_download4', 'iudouyu2.2.104_1401195lb_download4.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:59:24'),
	(1401754, 72, 'Black1', 'black', 'http://wx.9douyu.com/register?channel=Black1', 'jiudouyu2.2.888_1401754Black1.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:01:02'),
	(1402531, 69, 'lb_news8', 'lb_news8n', 'http://wx.9douyu.com/register?channel=lb_news8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402533, 68, 'DSP_news8', 'DSP新手s8', 'http://wx.9douyu.com/register?channel=DSP_news8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402535, 67, 'jrtt_news8', '今日头条新手S8', 'http://wx.9douyu.com/register?channel=jrtt_news8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:56:16'),
	(1402536, 65, 'sm_news8', '神马新手S8', 'http://wx.9douyu.com/register?channel=sm_news8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:48:03'),
	(1402541, 72, 'Blcak2', 'Black2', 'http://wx.9douyu.com/register?channel=Blcak2', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402552, 73, '2year_zhuli', '两周年助力的链接', 'http://wx.9douyu.com/register?channel=2year_zhuli', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402612, 72, 'black1_1', '黑包渠道1-1.1', 'http://wx.9douyu.com/register?channel=black1_1', 'jiudouyu2.2.888_1402612black1_1.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:01:19'),
	(1402613, 72, 'black1_2', '黑包渠道1－1.2', 'http://wx.9douyu.com/register?channel=black1_2', 'jiudouyu2.2.888_1402613black1_2.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:01:27'),
	(1402614, 72, 'black1_3', '黑包渠道1-1.3', 'http://wx.9douyu.com/register?channel=black1_3', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402615, 72, 'black1_4', '黑包渠道1-1.4', 'http://wx.9douyu.com/register?channel=black1_4', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402625, 72, 'black1_5', '黑包渠道1-1.5', 'http://wx.9douyu.com/register?channel=black1_5', 'jiudouyu2.2.888_1402625black1_5.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:00:05'),
	(1402726, 74, 'baiduzhushou', '百度手机助手推广安装包', 'http://wx.9douyu.com/register?channel=baiduzhushou', 'jiudouyu2.2.888_1402726baiduzhushou.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:01:45'),
	(1402737, 72, 'black1_6', '黑包渠道1-1.6', 'http://wx.9douyu.com/register?channel=black1_6', 'jiudouyu2.2.888_1402737black1_6.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:00:42'),
	(1402896, 75, 'daohang_news8', '导航推广', 'http://wx.9douyu.com/register?channel=daohang_news8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402898, 75, '39_news8', '三九养生堂', 'http://wx.9douyu.com/register?channel=39_news8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402899, 75, 'shafa_news8', '沙发', 'http://wx.9douyu.com/register?channel=shafa_news8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402989, 69, 'lb_downloadnews8_1', '新手S8猎豹下载包', 'http://wx.9douyu.com/register?channel=lb_downloadnews8_1', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402993, 69, 'lb_downloadnews8_2', '猎豹新手S8下载包2', 'http://wx.9douyu.com/register?channel=lb_downloadnews8_2', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402995, 69, 'lb_downloadnews8_3', '猎豹新手S8下载包3', 'http://wx.9douyu.com/register?channel=lb_downloadnews8_3', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1402997, 69, 'lb_downloadnews8_4', '猎豹新手S8下载包4', 'http://wx.9douyu.com/register?channel=lb_downloadnews8_4', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1403009, 72, 'Blcak2_1', '黑包渠道2_1', 'http://wx.9douyu.com/register?channel=Blcak2_1', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1403010, 72, 'Blcak2_2', '黑包渠道2_2', 'http://wx.9douyu.com/register?channel=Blcak2_2', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1403917, 76, 'uc_news', 'ucnews', 'http://wx.9douyu.com/register?channel=uc_news', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1403918, 76, 'uc_family', 'ucfamily', 'http://wx.9douyu.com/register?channel=uc_family', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1403966, 77, 'wzdh_news', '网址导航news', 'http://wx.9douyu.com/register?channel=wzdh_news', 'jiudouyu2.2.5_1403966wzdhnews.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:02:57'),
	(1403967, 77, 'wzdh_family', '网址导航family', 'http://wx.9douyu.com/register?channel=wzdh_family', 'jiudouyu2.2.5_1403967wzdhfamil.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:02:35'),
	(1404028, 78, 'appstore_ios', 'App Store', 'http://wx.9douyu.com/register?channel=appstore_ios', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1405562, 69, 'lb_download5', '猎豹直接下载包5', 'http://wx.9douyu.com/register?channel=lb_download5', 'jiudouyu2.2.104_lb_download5.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:59:31'),
	(1405566, 69, 'lb_download6', '猎豹直接下载包6', 'http://wx.9douyu.com/register?channel=lb_download6', 'jiudouyu2.2.104_lb_download6.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:59:41'),
	(1405981, 67, 'jrtt_download1', '今日头条下载包', 'http://wx.9douyu.com/register?channel=jrtt_download1', 'jiudouyu2.2.888_1405981jrtt_download1.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:55:17'),
	(1405982, 67, 'jrtt_download2', '今日头条下载包3', 'http://wx.9douyu.com/register?channel=jrtt_download2', 'jiudouyu2.2.888_1405982jrtt_download2.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:55:00'),
	(1405984, 67, 'jrtt_download3', '今日头条下载包4', 'http://wx.9douyu.com/register?channel=jrtt_download3', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:54:18'),
	(1405985, 67, 'jrtt_download4', '今日头条下载包5', 'http://wx.9douyu.com/register?channel=jrtt_download4', 'jiudouyu2.2.888_1405985jrtt_download4.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:53:58'),
	(1405993, 72, 'black1_8', 'black1下载包8', 'http://wx.9douyu.com/register?channel=black1_8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1409841, 72, 'black1_9', '黑包渠道1-1.9', 'http://wx.9douyu.com/register?channel=black1_9', 'jiudouyu2.2.888_1409841black1_9.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:00:14'),
	(1410153, 67, 'jrtt_download5', '今日头条下载包5', 'http://wx.9douyu.com/register?channel=jrtt_download5', 'jiudouyu2.2.888_1410153jrtt_download5.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:56:00'),
	(1410239, 72, 'black1_10', 'black1_10', 'http://wx.9douyu.com/register?channel=black1_10', 'jiudouyu2.2.888_1410239black1_10.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:01:10'),
	(1411079, 74, 'baiduzhushou_2', '百度手机助手推广安装包2', 'http://wx.9douyu.com/register?channel=baiduzhushou_2', 'jiudouyu2.2.888_1411079baiduzhushou_2.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:01:47'),
	(1411082, 79, 'lb_football', '猎豹欧洲杯推广', 'http://wx.9douyu.com/register?channel=lb_football', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1411083, 79, 'uc_football', 'UC欧洲杯推广', 'http://wx.9douyu.com/register?channel=uc_football', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1411344, 75, 'fm_news8', '蓝鲸FM新手活动S8', 'http://wx.9douyu.com/register?channel=fm_news8', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1411431, 69, 'lb_family2', '猎豹family2', 'http://wx.9douyu.com/register?channel=lb_family2', 'jiudouyu2.2.106_1411431lbfamily.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:58:49'),
	(1411644, 67, 'jrtt_download6', '今日头条下载包6', 'http://wx.9douyu.com/register?channel=jrtt_download6', 'jiudouyu2.2.888_1411644jrtt_download6.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:55:35'),
	(1411646, 67, 'jrtt_download7', '今日头条下载包7', 'http://wx.9douyu.com/register?channel=jrtt_download7', 'jiudouyu2.2.888_1411646jrtt_download7.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:55:45'),
	(1411647, 67, 'jrtt_download8', '今日头条下载包8', 'http://wx.9douyu.com/register?channel=jrtt_download8', 'jiudouyu2.2.888_1411647jrtt_download8.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:55:52'),
	(1411688, 72, 'black1_11', '黑包渠道1-1.11', 'http://wx.9douyu.com/register?channel=black1_11', 'jiudouyu2.2.888_1411688black1_11.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:00:22'),
	(1411689, 72, 'black1_12', '黑包渠道1-1.12', 'http://wx.9douyu.com/register?channel=black1_12', 'jiudouyu2.2.888_1411689black1_12.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:00:32'),
	(1411722, 72, 'black1_13', '黑包渠道1-1.13', 'http://wx.9douyu.com/register?channel=black1_13', 'jiudouyu2.2.888_1411722black1_13.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:00:50'),
	(1412078, 76, 'uc_news1', 'uc_news1', 'http://wx.9douyu.com/register?channel=uc_news1', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1412079, 76, 'uc_news2', 'uc_news2', 'http://wx.9douyu.com/register?channel=uc_news2', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1412080, 76, 'uc_news3', 'uc_news3', 'http://wx.9douyu.com/register?channel=uc_news3', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1412081, 76, 'uc_news4', 'uc_news4', 'http://wx.9douyu.com/register?channel=uc_news4', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1412082, 76, 'uc_news5', 'uc_news5', 'http://wx.9douyu.com/register?channel=uc_news5', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1412084, 76, 'uc_news6', 'uc_news6', 'http://wx.9douyu.com/register?channel=uc_news6', 'jiudouyu2.2.888jiudouyu.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:51:07'),
	(1414736, 76, 'uc_download1', 'uc_download1', 'http://wx.9douyu.com/register?channel=uc_download1', 'jiudouyu2.2.888_1414736uc_download1.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:02:01'),
	(1414738, 76, 'uc_download2', 'uc_download2', 'http://wx.9douyu.com/register?channel=uc_download2', 'jiudouyu2.2.888_1414738uc_download2.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:02:13'),
	(1414740, 76, 'uc_download3', 'uc_download3', 'http://wx.9douyu.com/register?channel=uc_download3', 'jiudouyu2.2.888_1414740uc_download3.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:02:16'),
	(1418912, 81, 'xiaozhi_news', '小知新手', 'http://wx.9douyu.com/register?channel=xiaozhi_news', 'jiudouyu2.2.888_1418912xiaozhi_news.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:03:18'),
	(1418913, 81, 'xiaozhi_family', 'xiaozhi_family', 'http://wx.9douyu.com/register?channel=xiaozhi_family', 'jiudouyu2.2.888_1418913xiaozhi_family.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 18:03:21'),
	(1418951, 67, 'jrtt_download9', '今日头条下载包9', 'http://wx.9douyu.com/register?channel=jrtt_download9', 'jiudouyu2.2.106_1418951jrtt_download9.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:56:25'),
	(1419357, 68, 'DSP_apk', 'dsp下载页', 'http://wx.9douyu.com/register?channel=DSP_apk', 'jiudouyu2.2.888_1400489DSP_download.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:57:11'),
	(1422109, 67, 'jrtt2_download1', '今日头条－紫博兰', 'http://wx.9douyu.com/register?channel=jrtt2_download1', 'jiudouyu2.2.888_1422109jrtt2_download1.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:20:47', '2016-09-20 17:55:09'),
	(1422110, 67, 'jrtt2_download2', '今日头条－紫博兰2', 'http://wx.9douyu.com/register?channel=jrtt2_download2', 'jiudouyu2.2.888_1422110jrtt2_download2.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:20:47', '2016-09-20 17:54:51'),
	(1422124, 78, 'Appstore_majia', 'ios马甲', 'http://wx.9douyu.com/register?channel=Appstore_majia', '', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:44:01', '2016-09-20 17:33:04'),
	(1422290, 65, 'wandoujia', '豌豆荚', 'http://wx.9douyu.com/register?channel=wandoujia', 'jiudouyu2.2.888_1422290wandoujia.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:20:47', '2016-09-20 17:48:21'),
	(1422647, 83, 'youdao_news', '有道新手1', 'http://wx.9douyu.com/register?channel=youdao_news', 'jiudouyu2.2.888_1422647youdao_news.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:20:47', '2016-09-20 18:03:46'),
	(1423500, 83, 'youdao_news2', '有道新手2', 'http://wx.9douyu.com/register?channel=youdao_news2', 'jiudouyu2.2.888_1423500youdao_news2.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:20:47', '2016-09-20 18:03:57'),
	(1423501, 83, 'youdao_news3', '有道新手3', 'http://wx.9douyu.com/register?channel=youdao_news3', 'jiudouyu2.2.888_1423501youdao_news3.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:20:47', '2016-09-20 18:04:05'),
	(1423502, 83, 'youdao_news4', '有道新手4', 'http://wx.9douyu.com/register?channel=youdao_news4', 'jiudouyu2.2.888_1423502youdao_news4.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:20:47', '2016-09-20 18:04:35'),
	(1423503, 65, 'youdao_news5', '有道新手5', 'http://wx.9douyu.com/register?channel=youdao_news5', 'jiudouyu2.2.888_1423503youdao_news5.apk', 'NOVICE_ACTIVITY_S10', '2016-08-30', '2016-09-07', '2016-09-18 17:20:47', '2016-09-20 18:04:38');

