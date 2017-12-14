<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no" />
    <meta content="email=no" name="format-detection" />
    <title>九斗鱼对账单</title>
</head>
<body style="margin: 0;padding:0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="700" style="border-collapse: collapse;margin-bottom: 28px;border:1px solid #ecebeb;box-shadow: 1px 1px 3px #eee;">
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0" width="670" style="border-collapse: collapse;margin-top: 25px;color:#000;">
                            <tr style="border-bottom:1px dashed #ecebeb;">
                                <td height="46" style="font-size: 14px;">尊敬的鱼客，您好：</td>
                            </tr>
                            <tr style="border-bottom:1px dashed #ecebeb;">
                                <td height="44" style="padding-left: 40px;font-size: 14px;">九斗鱼{{$data['date']}}账单已发出，请查收。</td>
                            </tr>
                            <tr style="border-bottom:1px dashed #ecebeb;">
                                <td height="44" style="padding-left: 40px;font-size: 14px;">如有疑问，欢迎致电九斗鱼客服热线进行咨询400-6686-568</td>
                            </tr>
                            <tr>
                                <td align="right" height="82">
                                    <table border="0" cellpadding="0" cellspacing="0" width="226" style="border-collapse: collapse;">
                                        <tr>
                                            <td width="116" style="padding-right: 16px;">
                                                <img src="https://img1.9douyu.com/static/images/pc4/logo/v4-logo.png?v=10000248" alt="" width="99"/>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0" width="130" height="28" style="border-collapse: collapse;color:#999999;border-left:2px solid #f1f1f1;margin-right:20px;">
                                                    <tr>
                                                        <td style="padding-left: 14px;font-size: 10px;">耀盛中国</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 14px;font-size: 10px;">旗下互联网金融平台</td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!----------------------------------------------------say hello------------------------------------>
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0" width="670" style="border-collapse: collapse;margin-bottom: 30px;box-shadow: 0 0 19px rgba(49,134,238,.2);">
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="670" style="border-collapse: collapse;color:#fff;">
                                        <tr bgcolor="#288af5">
                                            <td height="50" style="font-size: 16px;">
                                                <img style="display: inline-block;vertical-align: middle;margin-right:14px;margin-left: 18px;width:18px;" src="{{assetUrlByCdn('/static/edm/icon1.png')}}" alt=""/>投资详情</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" width="640" style="border-collapse: collapse;">
                                        <tr style="border-bottom:1px solid #ededed;">
                                            <td height="68" width="270" style="padding-left:10px;font-size: 16px;color:#222222;"><span style="color: #c6cfd8;">•</span><span style="font-size: 14px;color: #999999;padding-left:8px;padding-right:18px;">投资笔数</span>{{$data['invest_info']['invest_counts'] or 0}}笔</td>
                                            <td height="68" width="170"><span style="color: #c6cfd8;">•</span><span style="color:#999999;padding-left: 10px;font-size: 14px;">20-90天 (不含)</span></td>
                                            <td height="68" style="font-size: 16px;color: #222222;">￥{{ $data['invest_info']['day_type_1'] or 0 }}</td>
                                        </tr>

                                        <tr style="border-bottom:1px solid #ededed;">
                                            <td height="68" width="270" style="padding-left:10px;font-size: 16px;color:#222222;"><span style="color: #c6cfd8;">•</span><span style="font-size: 14px;color: #999999;padding-left:8px;padding-right:18px;">投资总额</span>￥{{$data['invest_info']['total_amount'] or 0}}</td>
                                            <td height="68" width="170"><span style="color: #c6cfd8;">•</span><span style="color:#999999;padding-left: 10px;font-size: 14px;">90天~365天 (不含)</span></td>
                                            <td height="68" style="font-size: 16px;color: #222222;">￥{{ $data['invest_info']['day_type_2'] or 0 }}</td>
                                        </tr>

                                        <tr>
                                            <td height="68" width="270" style="padding-left:10px;font-size: 16px;color:#222222;"><span style="color: #c6cfd8;">•</span><span style="font-size: 14px;color: #999999;padding-left:8px;padding-right:18px;">预期收益</span>￥{{$data['invest_info']['total_interest'] or 0}}</td>
                                            <td height="68" width="170"><span style="color: #c6cfd8;">•</span><span style="color:#999999;padding-left: 10px;font-size: 14px;">365天及以上</span></td>
                                            <td height="68" style="font-size: 16px;color: #222222;">￥{{ $data['invest_info']['day_type_3'] or 0 }}</td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!----------------------------------------------------show detail------------------------------------>
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0" width="670" style="border-collapse: collapse;">
                            <tr bgcolor="#f8f8f8" style="border-bottom:1px solid #ededed;color: #222222;">
                                <td height="48" width="188" style="padding-left: 15px;font-size: 16px;">项目名称</td>
                                <td height="48" width="84" style="padding-left: 15px;font-size: 16px;">利率</td>
                                <td height="48" width="92" style="padding-left: 15px;font-size: 16px;">回款方式</td>
                                <td height="48" width="110" style="padding-left: 15px;font-size: 16px;">投资时间</td>
                                <td height="48" style="padding-left: 15px;font-size: 16px;">投资金额</td>
                            </tr>
                            @if(!empty($data['invest_list']))
                                @foreach($data['invest_list'] as $item)

                                    <tr height="40" style="font-size: 14px;color: #666666;">
                                        <td height="48" width="188" style="padding-left: 15px;font-size: 16px;">{{$item['name'] or null}} {{$item['format_name'] or null}}</td>
                                        <td height="48" width="84" style="padding-left: 15px;font-size: 16px;">{{$item['profit_percentage'] or 0}}%</td>
                                        <td height="48" width="92" style="padding-left: 15px;font-size: 16px;">{{$item['refund_type_note'] or null}}</td>
                                        <td height="48" width="110" style="padding-left: 15px;font-size: 16px;">{{ date('Y-m-d', strtotime($item['created_at'])) }}</td>
                                        <td height="48" style="padding-left: 15px;font-size: 16px;">￥{{$item['cash'] or 0}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>

                    </td>
                </tr>
                <!----------------------------------------------------say hello------------------------------------>
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0" width="670" style="border-collapse: collapse;margin-bottom: 30px;margin-top: 30px;box-shadow: 0 0 19px rgba(49,134,238,.2);">
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="670" style="border-collapse: collapse;color:#fff;">
                                        <tr bgcolor="#288af5">
                                            <td height="50" style="font-size: 16px;">
                                                <img style="display: inline-block;vertical-align: middle;margin-right:14px;margin-left: 18px;width:17px;" src="{{assetUrlByCdn('/static/edm/icon2.png')}}" alt=""/>回款详情</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" width="618" style="border-collapse: collapse;margin-top:20px;margin-bottom:20px;">
                                        <tr>
                                            <td height="52" width="50%" style="font-size: 16px;color:#222222;"><span style="color: #c6cfd8;">•</span><span style="font-size: 14px;color: #999999;padding-left:10px;padding-right:20px;">回款笔数</span>{{$data['refund_info']['refund_counts'] or 0}}笔</td>
                                            <td height="52" style="font-size: 16px;color:#222222;"><span style="color: #c6cfd8;">•</span><span style="font-size: 14px;color: #999999;padding-left:10px;padding-right:20px;">回款收益</span>￥{{$data['refund_info']['total_interest'] or 0}}</td>
                                        </tr>
                                        <tr>
                                            <td height="52" style="font-size: 16px;color:#222222;"><span style="color: #c6cfd8;">•</span><span style="font-size: 14px;color: #999999;padding-left:10px;padding-right:20px;">回款本金</span>￥{{$data['refund_info']['total_principal'] or 0}}</td>
                                            <td height="52" style="font-size: 16px;color:#222222;"><span style="color: #c6cfd8;">•</span><span style="font-size: 14px;color: #999999;padding-left:10px;padding-right:20px;">回款总额</span>￥{{$data['refund_info']['total_amount'] or 0}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!----------------------------------------------------show detail------------------------------------>
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0" width="670" style="border-collapse: collapse;">
                            <tr bgcolor="#f8f8f8" style="border-bottom:1px solid #ededed;color: #222222;">
                                <td height="48" width="188" style="padding-left: 15px;font-size: 16px;">回款日期</td>
                                <td height="48" width="188" style="padding-left: 15px;font-size: 16px;">项目名称</td>
                                <td height="48" >回款金额</td>
                                <td height="48" width="84" style="padding-left: 15px;font-size: 16px;">回款期数</td>
                                <td height="48" width="92" style="padding-left: 15px;font-size: 16px;">回款状态</td>

                            </tr>
                            @if(!empty($data['refund_list']))
                                @foreach($data['refund_list'] as $item)
                                    <tr height="40" style="font-size: 14px;color: #666666;">
                                        <td style="padding-left: 15px;font-size: 14px;">{{$item['times'] or null}}</td>
                                        <td style="padding-left: 15px;font-size: 14px;">{{$item['name'] or null }}</td>
                                        <td align="center" style="font-size: 14px;">{{$item['cash'] or 0 }}</td>
                                        <td style="padding-left: 15px;font-size: 14px;">第 {{$item['current_periods'] or 0 }}/{{$item['periods'] or 0}} 期</td>
                                        <td style="padding-left: 15px;font-size: 14px;"> @if($item['type'] == 0) @if($item['principal'] == 0) 利息 @else 本金+利息 @endif @elseif($item['type'] == 1) 加息券 @endif</td>
                                    </tr>
                                @endforeach

                            @endif
                        </table>

                    </td>
                </tr>
                <!----------------------------------------------------show banner------------------------------------>
                <tr>
                    <td align="right">
                        <img width="241" height="152" style="display: inline-block;vertical-align: middle;margin-right:20px;margin-top: 20px;" src="{{assetUrlByCdn('/static/edm/icon3.png')}}" alt=""/></td>
                    </td>
                </tr>


            </table>
        </td>
    </tr>

</table>
</body>
</html>