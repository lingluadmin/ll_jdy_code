<!--房抵-->
   <h4 class="v4-section-title"><span></span>借款人信息</h4>
   <div class="v4-tabel-detail-wrap">
      <table class="v4-tabel-detail v4-table-label2">
        <tr class="grey">
          <td><label>借款人姓名</label>{{isset($creditDetail['companyView']['format_loan_username'])  && !empty($creditDetail['companyView']['format_loan_username']) ? substr($creditDetail['companyView']['format_loan_username'][0] ,0,3).'**' : null }}</td>
          <td><label class="label110">借款人性别</label>{{(isset($creditDetail['companyView']['sex']) && $creditDetail['companyView']['sex'] == 1) ? '男' : '女'}}</td>
        </tr>
        <tr>
          <td><label>身份证号</label>{{isset($creditDetail['companyView']['format_loan_user_identity'])  && !empty($creditDetail['companyView']['format_loan_user_identity']) ? substr($creditDetail['companyView']['format_loan_user_identity'][0] ,0,3) .'********'.substr($creditDetail['companyView']['format_loan_user_identity'][0] ,-3) : null }}</td>
          <td><label class="label110">户籍</label>{{isset($creditDetail['companyView']['family_register']) ? $creditDetail['companyView']['family_register'] : null}}</td>
        </tr>
        <tr class="grey">
          <td><label>借款用途</label>资金周转</td>
          <td></td>
        </tr>
      </table>
    </div>
   <h4 class="v4-section-title"><span></span>抵押物信息</h4>
   <div class="v4-tabel-detail-wrap">
      <table class="v4-tabel-detail v4-table-label2">
        <tr class="grey">
          <td><label>建筑面积</label>{{isset($creditDetail['companyView']['housing_area']) ? $creditDetail['companyView']['housing_area'] : null}}平方米</td>
          <td><label class="label110">评估总值</label>{{isset($creditDetail['companyView']['housing_valuation']) ? $creditDetail['companyView']['housing_valuation'] : null}}万元</td>
        </tr>
        <tr class="grey">
          <td></td>
        </tr>
      </table>
    </div>
