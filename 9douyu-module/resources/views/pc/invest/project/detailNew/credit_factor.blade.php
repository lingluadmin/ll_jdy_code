<!--保理-->
   <h4 class="v4-section-title"><span></span>债权企业信息</h4>
   <div class="v4-tabel-detail-wrap">
      <table class="v4-tabel-detail v4-table-label2">
        <tr class="grey">
          <td><label>债权企业名称</label>{{isset($creditDetail['companyView']['credit_company']) ? $creditDetail['companyView']['credit_company'] : null}}</td>
          <td><label class="label110">企业证件号</label>{{isset($creditDetail['companyView']['format_loan_user_identity']) && !empty($creditDetail['companyView']['format_loan_user_identity']) ? substr($creditDetail['companyView']['format_loan_user_identity'][0] ,0,4) .'******' : null}}</td>
        </tr>
        <tr>
          <td><label >借款用途</label>资金周转</td>
          {{--<td><label>经营地址</label>{{isset($creditDetail['companyView']['family_register']) ? $creditDetail['companyView']['family_register'] : null}}</td>--}}
          <td><label class="label110" ></label></td>
        </tr>
      </table>
    </div>
