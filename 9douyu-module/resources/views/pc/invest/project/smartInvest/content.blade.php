<div class="v4-project-content nopadtop">
   <h4 class="v4-section-title"><span></span>项目流程</h4>
   <ul class="v4-project-flow v4-smart-3 clearfix">
       @if($project['status']==\App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING)
           <li class="current">
               <i class="v4-iconfont">&#xe6b9;</i>
               <p>成功出借</p>
               <span class="line">一般1~2天</span>
           </li>
           <li>
               <i class="v4-iconfont">&#xe6dd;</i>
               <p class="v4-smart-4">开始锁定期</p>
               <span class="line">{{ $project['format_invest_time'] . $project['invest_time_unit']}}后</span>
           </li>
           <li>
               <i class="v4-iconfont">&#xe6b6;</i>
               <p class="v4-smart-4">结束锁定期</p>
               <span class="line">一般1~2天</span>
           </li>
           <li>
               <i class="v4-iconfont">&#xe6b7;</i>
               <p class="v4-smart-5">转让债权 本息到账</p>
           </li>
       @endif
       @if($project['status']==\App\Http\Dbs\Project\ProjectDb::STATUS_REFUNDING)
           <li class="current">
               <i class="v4-iconfont">&#xe6b9;</i>
               <p>成功出借</p>
               <span class="line">一般1~2天</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6dd;</i>
               <p class="v4-smart-4">开始锁定期</p>
               <span class="line">{{ $project['format_invest_time'] . $project['invest_time_unit']}}后</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6b6;</i>
               <p class="v4-smart-4">结束锁定期</p>
               <span class="line">一般1~2天</span>
           </li>
           <li>
               <i class="v4-iconfont">&#xe6b7;</i>
               <p class="v4-smart-5">转让债权 本息到账</p>
           </li>
       @endif
       @if($project['status']==\App\Http\Dbs\Project\ProjectDb::STATUS_FINISHED)
           <li class="current">
               <i class="v4-iconfont">&#xe6b9;</i>
               <p>成功出借</p>
               <span class="line">一般1~2天</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6dd;</i>
               <p class="v4-smart-4">开始锁定期</p>
               <span class="line">{{ $project['format_invest_time'] . $project['invest_time_unit']}}后</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6b6;</i>
               <p class="v4-smart-4">结束锁定期</p>
               <span class="line">一般1~2天</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6b7;</i>
               <p class="v4-smart-5">转让债权 本息到账</p>
           </li>
       @endif
   </ul>
   <h4 class="v4-section-title"><span></span>项目信息</h4>
   <div class="v4-tabel-detail-wrap">
      <table class="v4-tabel-detail v4-table-label1 v4-smart-1">
        <tr class="grey">
          <td width="20%"><label>项目名称</label></td>
          <td>{{$project['name']}}&nbsp;&nbsp;{{$project['format_name']}}</td>
        </tr>
        <tr>
          <td><label>项目介绍</label></td>
          <td>
    智投计划是九斗鱼推出的固定期限类出借服务。出借人通过智投计划服务将资金出借给九斗鱼平台上的忠诚用户， 采用智能
投标、循环出借的方式，提高资金的流动率和利用率。从而增加实际回报。

        </td>
        </tr>
        <tr class="grey">
          <td><label>期待年回报率</label></td>
          <td>{{(float)$project['profit_percentage']}}%</td>
        </tr>
        <tr>
          <td><label>借款期限</label></td>
          <td>{{ $project['format_invest_time'] . $project['invest_time_unit']}}</td>
        </tr>
        <tr class="grey">
          <td><label>计息方式</label></td>
          <td>T+1日计息</td>
        </tr>
        <tr>
          <td><label>还款方式</label></td>
          <td>{{ $project['refund_type_note'] }}</td>
        </tr>
        <tr class="grey">
          <td><label>收益说明</label></td>
          <td>以实际收益为准，实际收益={(已匹配债权资金*期待年回报率)/365}*投资天数</td>
        </tr>
        <tr>
          <td><label>借款总额</label></td>
          <td>{{ number_format($project['total_amount']) }}元</td>
        </tr>
        <tr class="grey">
          <td><label>募集周期</label></td>
          <td>最长不超过{{ $project['invest_days'] }}天</td>
        </tr>
        <tr>
          <td><label>风险等级</label></td>
          <td>稳定型</td>
        </tr>
        <tr class="grey">
          <td><label>出借条件</label></td>
          <td>最低1000元起投100元的整数倍增加，最高不超过项目剩余总额</td>
        </tr>
        <tr>
          <td><label>提前赎回方式</label></td>
          <td>{{ $project['format_invest_time'] . $project['invest_time_unit']}}锁定期内，不可赎回</td>
        </tr>
        <tr class="grey">
          <td><label>费用</label></td>
          <td>买入费用：0.00%<br/>退出费用：0.00%<br/>提前赎回费用：0.00%</td>
        </tr>
        <tr>
          <td><label>协议范本</label></td>
          <td><a href="" target="_blank" class="v4-btn-text">《智投计划服务协议》</a></td>
        </tr>
      </table>
    </div>
</div>
