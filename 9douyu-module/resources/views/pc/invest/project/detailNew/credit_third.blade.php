  <!-- 借款人列表弹窗 -->

  <div class="v4-layer_wrap js-mask" data-modul="moduldetail" style="display: none;">
        <div class="Js_layer_mask v4-layer_mask" data-toggle="mask" data-target="js-mask"></div>
            <div class="Js_layer v4-layer">
                    <div class="v4-module-header">
                    <table class="v4-layout-table table-theadbg table-textcenter">
                        <thead>
                            <tr>
                                <td width="120">借款人姓名</td>
                                <td width="170">借款人身份证号</td>
                                <td width="170">借款金额（元）</td>
                                <td>借款用途</td>
                            </tr>
                        </thead>
                    </table>
                    </div>
                    <div class="v4-module-table-wrap">
                        <table class="table table-theadbg table-textcenter">
                            <tbody>
                            @if(!empty($creditDetail['companyView']['credit_list_info']))
                                 @foreach($creditDetail['companyView']['credit_list_info'] as $key =>$credit_item)
                                        <tr>
                                            <td width="120"> {{ $credit_item['realname'] }} </td>
                                            <td width="170"> {{ $credit_item['identity_card'] }}  </td>
                                            <td width="170"> {{ number_format($credit_item['amount'],2) }} </td>
                                            <td>个人消费</td>
                                        </tr>
                                @endforeach
                            @endif
                                                                                                </tbody>
                    </table>
                </div>
                <a href="#" data-toggle="mask" data-target="js-mask" class="v4-input-btn v4-lay-mg">关闭</a>

        </div>
    </div>
