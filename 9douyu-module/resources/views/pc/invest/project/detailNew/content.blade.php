<div class="v4-project-content nopadtop">
   <h4 class="v4-section-title"><span></span>项目流程</h4>
   <ul class="v4-project-flow clearfix">
       @if($project['status']==\App\Http\Dbs\Project\ProjectDb::STATUS_INVESTING)
           <li class="current">
               <i class="v4-iconfont">&#xe6b9;</i>
               <p>项目发布</p>
               <span class="line">募集中</span>
           </li>
           <li>
               <i class="v4-iconfont">&#xe6b8;</i>
               <p>募集成功</p>
               <span class="line">放款中</span>
           </li>
           <li>
               <i class="v4-iconfont">&#xe6b6;</i>
               <p>项目放款</p>
               <span class="line">还款中</span>
           </li>
           <li>
               <i class="v4-iconfont">&#xe6b7;</i>
               <p>项目完结</p>
           </li>
       @endif
       @if($project['status']==\App\Http\Dbs\Project\ProjectDb::STATUS_REFUNDING)
           <li class="current">
               <i class="v4-iconfont">&#xe6b9;</i>
               <p>项目发布</p>
               <span class="line">募集中</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6b8;</i>
               <p>募集成功</p>
               <span class="line">放款中</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6b6;</i>
               <p>项目放款</p>
               <span class="line">还款中</span>
           </li>
           <li>
               <i class="v4-iconfont">&#xe6b7;</i>
               <p>项目完结</p>
           </li>
       @endif
       @if($project['status']==\App\Http\Dbs\Project\ProjectDb::STATUS_FINISHED)
           <li class="current">
               <i class="v4-iconfont">&#xe6b9;</i>
               <p>项目发布</p>
               <span class="line">募集中</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6b8;</i>
               <p>募集成功</p>
               <span class="line">放款中</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6b6;</i>
               <p>项目放款</p>
               <span class="line">还款中</span>
           </li>
           <li class="current">
               <i class="v4-iconfont">&#xe6b7;</i>
               <p>项目完结</p>
           </li>
       @endif
   </ul>
   <h4 class="v4-section-title"><span></span>项目信息</h4>
   <div class="v4-tabel-detail-wrap">
      <table class="v4-tabel-detail v4-table-label1">
        <tr class="grey">
          <td width="20%"><label>项目名称</label></td>
          <td>{{$project['name']}}&nbsp;&nbsp;{{$project['format_name']}}</td>
        </tr>
        <tr>
          <td><label>项目介绍</label></td>
          <td>
    @if($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_THIRD_CREDIT) <!--第三方-->

            {!! $creditDetail['companyView']['project_desc'] or '' !!}

    @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_FACTORING) <!--保理-->
            {{isset($creditDetail['companyView']['factor_summarize']) ? htmlspecialchars_decode($creditDetail['companyView']['factor_summarize']) : '九安心产品是保理公司将应收账款收益权转让给出借人；原债权企业多为国企及上市公司，切负有连带责任，借款期限一般为30~90天，适合偏好短期，且稳定的出借人。'}}

    @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_CREDIT_LOAN)<!--信贷-->

           {{!empty($creditDetail['companyView']) && $creditDetail['companyView']['founded_time'] != '0000-00-00 00:00:00' && isset($creditDetail['companyView']['background']) ? $creditDetail['companyView']['background'] : ' 债权借款人均为工薪精英人群，该人群有较高的教育背景、稳定的经济收入及良好的信用意识。'}}

    @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_HOUSING_MORTGAGE)<!--房抵-->

          {{isset($creditDetail['companyView']['credit_desc']) ? $creditDetail['companyView']['credit_desc'] : '借款人因资金周转需要，故以个人名下房产作为抵押进行借款。此类借款人有稳定的经济收入及良好的信用意识。'}}

    @else
        九安心产品是保理公司将应收账款收益权转让给出借人；原债权企业多为国企及上市公司，切负有连带责任，借款期限一般为30~90天，适合偏好短期，且稳定的出借人。
    @endif

        </td>
        </tr>
        <tr class="grey">
          <td><label>期待年回报率</label></td>
          <td>{{(float)$project['profit_percentage']}}%</td>
        </tr>
        <tr>
          <td><label>项目期限</label></td>
          <td>{{ $project['format_invest_time'] . $project['invest_time_unit']}}</td>
        </tr>
        <tr class="grey">
          <td><label>计息方式</label></td>
          <td> @if( $project['new'] == 0 ) 出借当日计息 @else 满标当日计息 @endif</td>
        </tr>
        <tr>
          <td><label>还款方式</label></td>
          <td>{{ $project['refund_type_note'] }}</td>
        </tr>
        <tr class="grey">
          <td><label>预期回款日</label></td>
          <td>{{ $project['end_at'] }}</td>
        </tr>
        <tr>
          <td><label>借款金额</label></td>
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
          <td>最低100元起投，最高不超过剩余项目总额</td>
        </tr>
        <tr>
          <td><label>提前赎回方式</label></td>
            @if( $project['calculator_type'] != 'equalInterest' && $project['is_credit_assign'] == 1 &&  $project['assign_keep_days']>0)
                @if( $project['pledge'] == 2 )
                    <td>持有项目{{$project['assign_keep_days']}}天后可转让，仅支持单笔出借金额一次性全额转让；每日15点为转让结息时间，如在15点前（不含）出借成功，隔日转让成功后，计算1天收益；如15点后（含）出借成功，隔日15点前转让成功，将不计算利息，只返还本金；如隔日15点后转让成功，将计算1天收益。</td>
                @else
                    <td>持有项目{{$project['assign_keep_days']}}天及以上，可申请转让变现（本金回款当日不可转让），仅支持单笔出借金额一次性全额转让</td>
                @endif
            @else
                <td>不支持转让</td>
            @endif
        </tr>
        <tr class="grey">
          <td><label>费用</label></td>
          <td>买入费用：0.00%<br/>退出费用：0.00%<br/>提前赎回费用：0.00%</td>
        </tr>
        <tr>
          <td><label>协议范本</label></td>
          <td><a href="{{assetUrlByCdn('/static/pdf/InvestmentAndManagement.pdf')}}" target="_blank" class="v4-btn-text">《九斗鱼投资咨询与管理服务协议》</a></td>
        </tr>
        @if($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_THIRD_CREDIT)
        <tr class="grey">
          <td><label>债权列表</label></td>
          <td><a href="#" class="v4-btn-text" data-target="moduldetail">【查看借款人列表】</a></td>
        </tr>
       @endif
      </table>
    </div>

    @if($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_THIRD_CREDIT) <!--第三方-->

            @include('pc.invest.project.detailNew.credit_third')

    @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_FACTORING) <!--保理-->

             @include('pc.invest.project.detailNew.credit_factor')

    @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_CREDIT_LOAN)<!--信贷-->

             @include('pc.invest.project.detailNew.credit_loan')

    @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_HOUSING_MORTGAGE)<!--房抵-->

            @include('pc.invest.project.detailNew.credit_house')

    @elseif($creditDetail['projectWay'] == App\Http\Dbs\Credit\CreditDb::SOURCE_TAO_SHOP)<!--淘当铺-->

            @include('pc.invest.project.detailNew.credit_tao_shop')

    @else
            @include('pc.invest.project.detailNew.default')
    @endif
</div>
