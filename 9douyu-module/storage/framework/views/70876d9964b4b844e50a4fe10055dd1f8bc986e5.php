<?php $__env->startSection('title', '我要出借'); ?>

<?php $__env->startSection('content'); ?>
    <div class="v4-wrap">
        <div class="v4-project-banner">
            <a href="javascript:;"><img src="<?php echo e(!empty($ad[0]['purl']) ? $ad[0]['purl'] : assetUrlByCdn('/static/images/pc4/project/v4-project-banner.jpg')); ?>" width="1100" height="180"></a>
        </div>
        <div class="v4-bgwhite">

            <div class="pr Js_tab_box ms-controller" ms-controller="projectList">
                <p class="v4-project-list-tip">网贷有风险，出借需谨慎</p>
                <!-- <h2 class="v4-account-titlex">{%@title.invest%}</h2> -->
                <ul class="Js_tab v4-user-tab clearfix">
                    <li ms-class="[@toggle==1 && 'cur']"  ms-mouseover="changeTab($event)" data-li-id="1" style="cursor:pointer">{%@title.invest%}</li>
                    <!-- <li><a href="">{%@title.debt%}</a></li> -->
                    <li ms-class="[@toggle==2 %% 'cur']" ms-mouseover="changeTab($event)" data-li-id="2" style="cursor:pointer">{%@title.smart%}</li>
                </ul>
                <div class="js_tab_content">

                    <div class="Js_tab_main v4-list-tab-wrap current_tab_main v4-hidden-tabbox" ms-visible="@toggle==1">
                        <!-- loading加载 -->
                        <div class="v4-loading-wrap" style="display: none;">
                            <img src="<?php echo e(assetUrlByCdn('/static/images/pc4/v4-loading.png')); ?>" width="47" height="47" class="loading">
                        </div>
                        <ul class="v4-project-listitem">
                            <li ms-for="(k, v) in @list" ms-if="@v.status==130">
                                <div ms-if="@v.pledge==1" class="v4-listitem-icon"><span>新手专享</span></div>
                                <div ms-if="@v.pledge==2" class="v4-listitem-icon"><span>灵活转让</span></div>
                                <div ms-if="@v.act_info.type!=0" class="v4-listitem-icon"><span>{% @v.act_info.note %}</span></div>
                                <div class="v4-listitem-box v4-listitem-title">
                                    <p>
                                        <big><span class="v4-mr15">{% @v.name %}</span>{% @v.format_name %}</big>
                                    </p>
                                    <p>项目名称</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-rate">
                                    <p style="color:red">
                                        <?php /*<big>{% @v.profit_percentage | number(1) %}%</big>*/ ?>
                                        <?php /*<big ms-if="@v.after_rate<=0">{% @v.profit_percentage | number(1) %}%</big>*/ ?>
                                        <big>{% @v.base_rate | number(1) %}%</big>
                                        <span ms-if="@v.after_rate>0">
                                        +{% @v.after_rate | number(1) %}%
                                        </span>
                                    </p>
                                    <p>期待年回报率</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-limit">
                                    <p><big>{% @v.format_invest_time %}{% @v.invest_time_unit %}</big></p>
                                    <p>项目期限</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-repay">
                                    <p>
                                        <big>{% @v.refund_type_note %}</big>
                                    </p>
                                    <p>还款方式</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-progress">
                                    <div class="v4-listitem-progress-bar">
                                        <span ms-css="{'width':@v.invest_speed+'%'}"></span>
                                    </div>
                                    <p><small>募集进度</small><ins>{% @v.invest_speed %}%</ins></p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-btnbox">
                                    <a class="v4-listitem-btn"  ms-attr="{href:'/project/detail/' + v.id}">立即出借</a>
                                </div>
                            </li>

                            <li ms-for="(k, v) in @list" ms-if="@v.status>130" class="v4-listitem-soldout">
                                <div class="v4-listitem-box v4-listitem-title">
                                    <p>
                                        <big><span class="v4-mr15">{% @v.name %}</span>{% @v.format_name %}</big>
                                    </p>
                                    <p>项目名称</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-rate">
                                    <p>
                                        <big>{% @v.profit_percentage | number(1) %}%</big>
                                    </p>
                                    <p>期待年回报率</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-limit">
                                    <p><big>{% @v.format_invest_time %}{% @v.invest_time_unit %}</big></p>
                                    <p>项目期限</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-repay">
                                    <p>
                                        <big>{% @v.refund_type_note %}</big>
                                    </p>
                                    <p>还款方式</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-progress">
                                    <div class="v4-listitem-progress-bar">
                                        <span style="width: 100%;"></span>
                                    </div>
                                    <p><small>募集进度</small><ins>100%</ins></p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-btnbox">
                                    <a ms-if="@v.status==150" class="v4-listitem-btn"  ms-attr="{href:'/project/detail/' + v.id}">已售罄</a>
                                    <a ms-if="@v.status==160" class="v4-listitem-btn"  ms-attr="{href:'/project/detail/' + v.id}">已完结</a>
                                </div>
                            </li>
                        </ul>
                        <div class="v4-table-pagination">
                            <a ms-if="@pager.current_page > 1" href="javascript:void(0)" ms-attr="{'data-url':@pager.prev_page_url}" class="turn" ms-click="getProjectData($event)">上一页</a>
                            <span ms-for="(k,v) in @pager.view">
                               <a ms-if="@pager.current_page==@v" href="javascript:void(0)" class="active">{% @pager.current_page %}</a>
                               <a ms-if="@pager.current_page!=@v" href="javascript:void(0)" ms-attr="{'data-url':@pager.page_url+@v}" ms-click="getProjectData($event)">{% @v  %}</a>
                            </span>
                            <a ms-if="@pager.current_page<@pager.last_page" href="javascript:void(0)" ms-attr="{'data-url':@pager.next_page_url}" class="turn" ms-click="getProjectData($event)">下一页</a>
                        </div>
                    </div>
                   <!--智投项目列表-->
                    <div class="Js_tab_main" ms-visible="@toggle==2">
                        <!-- loading加载 -->
                        <div class="v4-loading-wrap" style="display: none;">
                            <img src="<?php echo e(assetUrlByCdn('/static/images/pc4/v4-loading.png')); ?>" width="47" height="47" class="loading">
                        </div>
                        <ul class="v4-project-listitem">
                            <li ms-for="(k, v) in @smart_list" ms-if="@v.status==130">
                                <div class="v4-listitem-box v4-listitem-title">
                                    <p>
                                        <big><span class="v4-mr15">{% @v.name %} </span> {% @v.format_name %}</big>
                                    </p>
                                    <p>项目名称</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-rate">
                                    <p style="color:red">
                                        <?php /*<big>{% @v.profit_percentage | number(1) %}%</big>*/ ?>
                                        <?php /*<big ms-if="@v.after_rate<=0">{% @v.profit_percentage | number(1) %}%</big>*/ ?>
                                        <big>{% @v.base_rate | number(1) %}%</big>
                                        <span ms-if="@v.after_rate>0">
                                        +{% @v.after_rate | number(1) %}%
                                        </span>
                                    </p>
                                    <p>期待年回报率</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-limit">
                                    <p><big>{% @v.format_invest_time %}{% @v.invest_time_unit %}</big></p>
                                    <p>锁定期限</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-repay">
                                    <p>
                                        <big>{% @v.refund_type_note %}</big>
                                    </p>
                                    <p>还款方式</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-progress">
                                    <div class="v4-listitem-progress-bar">
                                        <span ms-css="{'width':@v.invest_speed+'%'}"></span>
                                    </div>
                                    <p><small>募集进度</small><ins>{% @v.invest_speed %}%</ins></p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-btnbox">
                                    <a class="v4-listitem-btn"  ms-attr="{href:'/smartInvest/detail/' + v.id}">立即出借</a>
                                </div>
                            </li>

                            <li ms-for="(k, v) in @smart_list" ms-if="@v.status>130" class="v4-listitem-soldout">
                                <div class="v4-listitem-box v4-listitem-title">
                                    <p>
                                        <big><span class="v4-mr15">{% @v.name %}&nbsp;&nbsp;&nbsp;{% @v.invest_time_note %}</span>{% @v.format_name %}</big>
                                    </p>
                                    <p>项目名称</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-rate">
                                    <p>
                                        <big>{% @v.profit_percentage | number(1) %}%</big>
                                    </p>
                                    <p>期待年回报率</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-limit">
                                    <p><big>{% @v.format_invest_time %}{% @v.invest_time_unit %}</big></p>
                                    <p>项目期限</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-repay">
                                    <p>
                                        <big>{% @v.refund_type_note %}</big>
                                    </p>
                                    <p>还款方式</p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-progress">
                                    <div class="v4-listitem-progress-bar">
                                        <span style="width: 100%;"></span>
                                    </div>
                                    <p><small>募集进度</small><ins>100%</ins></p>
                                </div>
                                <div class="v4-listitem-box v4-listitem-btnbox">
                                    <a ms-if="@v.status==150" class="v4-listitem-btn"  ms-attr="{href:'/smartInvest/detail/' + v.id}">已售罄</a>
                                    <a ms-if="@v.status==160" class="v4-listitem-btn"  ms-attr="{href:'/smartInvest/detail/' + v.id}">已完结</a>
                                </div>
                            </li>

                        </ul>
                        <div class="v4-table-pagination">
                            <a ms-if="@smart_pager.current_page > 1" href="javascript:void(0)" ms-attr="{'data-url':@smart_pager.prev_page_url}" class="turn" ms-click="getProjectSmartData($event)">上一页</a>
                            <span ms-for="(k,v) in @smart_pager.view">
                               <a ms-if="@smart_pager.current_page==@v" href="javascript:void(0)" class="active">{% @smart_pager.current_page %}</a>
                               <a ms-if="@smart_pager.current_page!=@v" href="javascript:void(0)" ms-attr="{'data-url':@smart_pager.page_url+@v}" ms-click="getProjectSmartData($event)">{% @v  %}</a>
                            </span>
                            <a ms-if="@smart_pager.current_page<@smart_pager.last_page" href="javascript:void(0)" ms-attr="{'data-url':@smart_pager.next_page_url}" class="turn" ms-click="getProjectSmartData($event)">下一页</a>
                        </div>
                    </div>
                </div>
          </div>

        </div>
    </div>
    <input type="hidden" id="page" value="<?php echo e($page); ?>" />
    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('/static/lib/biz/project-index.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(assetUrlByCdn('/assets/js/pc4/tabs.js')); ?>"></script>
    <script type="text/javascript">
        $(function(){
             $(".Js_tab_box").tabs();
        })
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('pc.common.layoutNew', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>