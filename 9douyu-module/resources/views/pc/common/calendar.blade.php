{{--回款日历--}}
<table class="v4-calendar-table">
<thead>
    <tr>
        <td>周日</td>
        <td>周一</td>
        <td>周二</td>
        <td>周三</td>
        <td>周四</td>
        <td>周五</td>
        <td>周六</td>
    </tr>
</thead>
<?php
        $year = !empty($year) ? $year : date("Y");
        $month = !empty($month) ? $month : date("m");
        $start_weekday = date('w', mktime(0,0,0, $month, 1, $year));
        $days = date('t', mktime(0,0,0, $month, 1, $year));
        //上个月天数
        $last_days = date('t', strtotime('last month', strtotime($date)));
        $out = '<tr>';
        $j = $k = $end =  0;
        for($j=0;$j<$start_weekday;$j++){
            $before = $last_days - $start_weekday+1+$j;
            $out .= '<td class="forbid">'.$before.'</td>';
        }
        for($k=1; $k<=$days;$k++){
            $j++;
            $day = $date.'-'.sprintf('%02d', $k);
            if (in_array($day, $refunded_date)){
                $out .= '<td><a href="javascript:;"><span class="active-incomplete">'.$k.'</span></a></td>';
            }elseif (in_array($day, $refund_date)){
                $out .= '<td><a href="javascript:;"><span class="active-uncomplete">'.$k.'</span></a></td>';
            }else{
                $out .= '<td><a href="javascript:;">'.$k.'</a></td>';
            }

            if ($j % 7 ==0){
                $out .= '</tr><tr>';
            }
        }
        while($j%7 != 0){
            $end++;
            $out .='<td class="forbid">'.$end.'</td>';
            $j++;
        }
        $out .= '</tr>';
        echo $out;
?>
</table>
