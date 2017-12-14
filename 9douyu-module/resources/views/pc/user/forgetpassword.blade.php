@extends('pc.common.layout')
@section('title', '找回登录密码')
@section('csspage')

@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="v4-wrap v4-custody-wrap">
        <h2 class="v4-account-titlex">找回登录密码</h2>
        <div class="v4-custody-main">
            <form action="/resetLoginPassword" method="post" id="findPasswordForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <dl class="v4-input-group">
                    <dt>
                        <label for="phone"><span>*</span> 手机号码</label>
                    </dt>
                    <dd>
                        <?php
                            if(!isset($view_user['phone'])){
                        ?>
                        <input type="text" name="phone" id="phone" placeholder="请输入11位手机号" data-pattern="registerphone" class="v4-input"/>
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                        <?php
                            }else{
                                echo '<input type="hidden" name="phone" id="phone" value="'. $view_user['phone'] .'" />';

                                echo $view_user['phone'];
                            }
                        ?>
                    </dd>

                    <dt>
                        <label for="phoneCode"><span>*</span> 手机验证码</label>
                    </dt>
                    <dd>
                        <input name="phoneCode" id="phoneCode" value="" placeholder="请输入验证码" data-pattern="phonecode"
                               class="v4-input v4-input-short">
                        <input value="获取验证码" default-value="获取验证码" type="button" class="v4-input-code" id="code">
                        <span class="v4-input-status"><i class="t1-icon v4-iconfont"></i></span>
                    </dd>
                    <dt>
                        &nbsp;
                    </dt>
                    <dd>
                        <div id="v4-input-msg" class="v4-input-msg">
                            @if(Session::has('errorMsg'))
                                {{ Session::get('errorMsg') }}
                            @endif
                        </div>
                        <input type="submit" class="v4-input-btn" value="下一步" id="v4-input-btn">
                    </dd>
                </dl>
            </form>
        </div>
    </div>

@endsection
@section('jspage')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
            // 检验输入框内容
            // $.validation('.v4-input');

            // 表单提交验证
            $("#findPasswordForm").bind('submit', function () {
                if (!$.formSubmitF('.v4-input', {
                        fromT: '#findPasswordForm'
                    })) return false;


                $('#v4-input-btn').addClass("disable").attr("disabled", true);

                var $phone = $.trim($("#phone").val());

                $.ajax({
                    url: '/doForgetPassword',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'step': 'one',
                        'code': $.trim($('#phoneCode').val()),
                        'phone': $phone
                    }
                    ,
                    success: function (sendRes) {
                        if (sendRes.code == 200) {
                            window.location.href = sendRes.data.jumpUrl;
                        } else {
                            $("#v4-input-msg").html(sendRes.msg);
                            $('#v4-input-btn').removeClass("disable").attr("disabled", null);
                        }
                    },
                    error: function (msg) {
                        $("#v4-input-msg").text("网络错误，请稍后重新点击");
                        $('#v4-input-btn').removeClass("disable").attr("disabled", null);
                    }
                });

                return false;
            });

        });


        (function ($) {
            $(document).ready(function () {
                var timeout = 0, maxTimeout = 60;
                var desc = "秒后重发";

                $("#code").click(function () {
                    var $phone = $.trim($("#phone").val());

                    if ($phone == undefined || $phone == "" || $phone == null)
                        return false;

                    var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[013678])\d{8}$/;
                    if (!$phone.match(pattern)) {
                        $("#v4-input-msg").text("请输入正确的手机号");
                        return false;
                    }

                    $("#code").addClass("disable").attr("disabled", true);

                    $.ajax({
                        url: '/common/sendSms',
                        type: 'POST',
                        dataType: 'json',
                        data: {'type': 'find_password', 'phone': $phone},
                        success: function (sendRes) {
                            if (sendRes.code == 302) {
                                window.location.href = '/login';
                            } else if (sendRes.code == 200) {
                                $("#v4-input-msg").html('短信验证码发送成功');
                                if (timeout <= 0) {
                                    timeout = maxTimeout;
                                    $("#code").addClass("disable").val(timeout + desc).attr("disabled", true);
                                }
                                var timer = setInterval(function () {
                                    timeout--;
                                    if (timeout > 0) {
                                        $("#code").addClass("disable").val(timeout + desc);
                                    } else {
                                        $("#code").removeClass("disable").val($("#code").attr("default-value")).attr("disabled", null);
                                        clearInterval(timer);
                                    }

                                }, 1000);

                            } else {
                                $("#code").removeClass("disable").val($("#code").attr("default-value")).attr("disabled", null);
                                $("#v4-input-msg").html(sendRes.msg);
                            }
                        },
                        error: function (msg) {
                            $("#v4-input-msg").text("网络错误，请稍后点击重新获取");
                            $("#code").removeClass("disable").val($("#code").attr("default-value")).attr("disabled", null);
                            clearInterval(timer);
                        }
                    });
                });
            });
        })(jQuery);

    </script>
@endsection
