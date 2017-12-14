<div class="Js_tab_box t-center-left-4">
    <ul class="Js_tab t-center-tab tab-two">
        <li class="cur">项目详情<span></span></li>
        {{-- <li>安全保障<span></span></li> --}}
        <li class="t-brn">还款计划<span></span></li>
    </ul>
    <?php
    $company = isset($creditDetail['companyView']) ? $creditDetail['companyView'] : null;
    ?>
    <div class="js_tab_content">
        <!--项目描述-->
        <div class="Js_tab_main t-center-left-5" style="display:block;">
            <dl class="t-center-left-6">
                <dt><span></span>项目描述</dt>
                <?php
                if(!empty($company) && $creditDetail['companyView']['founded_time'] != '0000-00-00 00:00:00'){
                ?>
                <dd>
                    <?php
                        echo isset($company['background']) ? $company['background'] : null;
                    ?>
                </dd><br>
                <?php if(!empty($company['financing_company'])): ?>
                <dd>企业基本信息</dd>
                <dd>
                    <table width="610">
                        <tr>
                            <td width="305">融资企业： <?php
                                echo isset($company['financing_company']) ? $company['financing_company'] : null;
                                ?>
                            </td>
                            <td width="305">项目区域位置：<?php
                                echo isset($company['program_area_location']) ? $company['program_area_location'] : null;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>成立时间：
                                <?php
                                echo isset($company['founded_time']) ? date('Y年m月', strtotime($company['founded_time'])) : null;
                                ?>
                            </td>
                            <td>注册资金：
                                <?php
                                echo isset($company['registered_capital']) ? $company['registered_capital'] : null;
                                ?>
                                万元</td>
                        </tr>
                        <tr>
                            <td>借款用途：
                                <?php
                                echo isset($company['loan_use']) ? $company['loan_use'] : null;
                                ?>
                                </td>
                            <td>还款来源：
                                <?php
                                echo isset($company['repayment_source']) ? $company['repayment_source'] : null;
                                ?>
                                </td>
                        </tr>
                        <tr>
                            <td colspan="2">年收入：
                                <?php
                                echo isset($company['annual_income']) ? $company['annual_income'] : null;
                                ?>
                                万元</td>
                        </tr>
                    </table>
                </dd><br>
                <?php endif; ?>
                <?php if(!empty($company['age'])): ?>
                <dd>实际控制人信息</dd>
                <dd>
                    <table width="610">
                        <tr>
                            <td width="305">性别：
                                <?php echo ($company['sex'] == 1) ? '男' : '女'; ?>
                            </td>
                            <td width="305">年龄：
                                <?php
                                    echo isset($company['age']) ? $company['age'] : null;
                                ?>
                                </td>
                        </tr>
                        <tr>
                            <td>户籍所在地：
                                <?php
                                echo isset($company['family_register']) ? $company['family_register'] : null;
                                ?>
                            </td>
                            <td>居住地：
                                <?php
                                echo isset($company['residence']) ? $company['residence'] : null;
                                ?>
                                </td>
                        </tr>
                        <tr>
                            <td colspan="2">婚姻状况：
                                <?php
                                echo isset($company['home_stability']) ? $company['home_stability'] : null;
                                ?>
                                </td>
                        </tr>
                        <tr>
                            <td colspan="2">财产状况：
                                <?php
                                echo isset($company['esteemn']) ? htmlspecialchars_decode($company['esteemn']) : null;
                                ?>
                                </td>
                        </tr>
                        <tr>
                            <td colspan="2">借款人征信记录：
                                <?php
                                echo isset($company['credibility']) ? htmlspecialchars_decode($company['credibility']) : null;
                                ?>
                                </td>
                        </tr>
                        <tr>
                            <td colspan="2">涉诉情况：
                                <?php
                                echo isset($company['involved_appeal']) ? htmlspecialchars_decode($company['involved_appeal']) : null;
                                ?>
                                </td>
                        </tr>
                    </table>
                </dd><br>
                <?php endif; ?>
                <?php }elseif(!empty($company)){ ?>
                <p> <?php
                    echo isset($company['background']) ? htmlspecialchars_decode($company['background']) : null;
                    ?>
                    </p><br>
                <p>借款主体</p><p><?php
                    echo isset($company['financing_company']) ? htmlspecialchars_decode($company['financing_company']) : null;
                    ?></p><br>
                <p>借款用途</p><p>
                    <?php
                    echo isset($company['loan_use']) ? htmlspecialchars_decode($company['loan_use']) : null;
                    ?>

                    </p><br>
                <p>还款来源</p><p>
                    <?php
                    echo isset($company['repayment_source']) ? htmlspecialchars_decode($company['repayment_source']) : null;
                    ?>
                        </p><br>
                {{--<dd>企业经营信息</dd>--}}
                {{--<p>{$company.operate_info|htmlspecialchars_decode}</p><br>--}}
                {{--<p>实际控制人信息</p>--}}
                {{--<p>{$company.actual_controller|htmlspecialchars_decode}</p><br>--}}
                {{--<p>项目综述</p><p>{$company.project_summarize|htmlspecialchars_decode}</p><br>--}}
                {{--<p>担保机构简介及担保意见</p><p>{$company.guarantee|htmlspecialchars_decode}</p><br>--}}
                <?php } ?>
                <?php if(!empty($creditDetail['companyView']['agreement_images_links']) || !empty($creditDetail['companyView']['industry_images_links'])) { ?>

                <div class="default t-center-img">
                    <a href="#" class="prev">&lsaquo;</a>
                    <div class="carousel">
                        <ul>
                            <?php
                            if(!empty($creditDetail['companyView']['agreement_images_links'])) {
                            foreach($creditDetail['companyView']['agreement_images_links'] as $k1=> $image){
                            if(($k1+1)/3 == 0){
                                echo '<li class="t-pr0">';
                            }else{
                                echo '<li>';
                            }
                            ?>
                            <img width="177" height="127" src="<?php echo $image['thumb'][$view_ssl];?>" big-src="<?php echo $image['src'][$view_ssl];?>"><span>{{ $image['title'] }}</span>
                                </li>
                            <?php
                            }
                            }
                            ?>

                            <?php
                            if(!empty($creditDetail['companyView']['industry_images_links'])) {
                            foreach($creditDetail['companyView']['industry_images_links'] as $k2=> $image){
                            if(($k2+1)/3 == 0){
                                echo '<li class="t-pr0">';
                            }else{
                                echo '<li>';
                            }
                            ?>
                            <img width="177" height="127" src="<?php echo $image['thumb'][$view_ssl];?>" big-src="<?php echo $image['src'][$view_ssl];?>"><span>{{ $image['title'] }}</span>
                                </li>
                            <?php
                            }
                            }
                            ?>
                        </ul>
                    </div>
                    <a href="#" class="next">&rsaquo;</a>
                    <div class="clear"></div>
                </div>

                <?php } ?>
            </dl>
            
        </div>

        <!--风险控制-->
        {{-- <div class="Js_tab_main t-center-left-7" style="display:none;">
            <dl class="t-center-left-6">
                <dt><span></span>风险控制</dt>
                <dd>平台对每个投资项目都有相应保障措施，同时建立了风险准备金账户，对平台每个投资项目提取 1%作为风险准备金。</dd>
            </dl>
            <div class="t-online"></div>
            <dl class="t-center-left-6">
                <dt><span></span>资金安全</dt>
                <dd>
                    <p>1.九斗鱼记录出借人的每笔投资，并生成符合法律法规的有效合同文件，且所有的
资金流向均由独立第三方机构代为管理，以确保用户资金安全；</p>
                    <p>2.九斗鱼平台的所有投资项目均通过多重风险控制审核，并对投资项目进行全面风
险管理，以最大程度保障出借人的资金安全；</p>
                    <p>3.九斗鱼平台全程采用 VeriSign256 位 SSL 强制加密证书进行数据加密传输，有效
保障银行账号、交易密码等机密信息在网络传输过程中不被查看、修改或窃取。</p>
                    <p>4.平台所有的投资项目均交纳 1%作为风险准备金，由东亚银行监管；查看<a href="/content/article/reservefund?id=815">《风险准备金账户》</a></p>
                </dd>
            </dl>
        </div> --}}

        <!-- 引入还款计划 -->
        <div class="Js_tab_main t-repayment" style="display: none;">
            <table class="table table-theadbg table-textcenter">


                <thead>
                <tr>
                    <td>预计还款时间</td>
                    <td>还款类型</td>
                    <td>预计还款金额（元）      </tr>
                </thead>
                <tbody>
                @foreach($refundPlan as $plan)
                    <tr>
                        <td>{{ $plan['refund_time'] }}</td>
                        <td>{{ $plan['refund_note'] }}</td>
                        <td>{{ number_format($plan['refund_cash'],2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>


    </div>
</div>