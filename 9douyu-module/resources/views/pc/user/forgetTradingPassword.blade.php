@extends('pc.common.layout')
@section('title', '交易密码')
@section('csspage')

@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="v4-account">
        <!-- account begins -->
        @include('pc.common/leftMenu')

        <div class="v4-content v4-account-white">
            <h2 class="v4-account-titlex">{{!empty($view_user['trading_password']) ? '找回' : '设置'}}交易密码</h2>
            <div class="v4-custody-main v4-phone-main">
                <form action="/" mehod="post" id="changeTradingPassword">

                    <dl class="v4-input-group">
                        <dt>
                            <label><span>*</span>手机号</label>
                        </dt>
                        <dd>
                            <p id="phone">{{ $view_user['phone'] }}</p>
                        </dd>
                        <dt>
                            <label for="phoneCode"><span>*</span>手机验证码</label>
                        </dt>
                        <dd>
                            <input name="phoneCode" id="phoneCode" value="" placeholder="请输入验证码" data-pattern="phonecode" class="v4-input v4-input-short">
                            <input value="获取验证码" type="button" class="v4-input-code" id="code" default-value="获取验证码">
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
    </div>

@endsection
@section('jspage')
    <script type="text/javascript">

        (function ($) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $(function () {
                // 检验输入框内容
//              $.validation('.v4-input');

                // 表单提交验证
                $("#changeTradingPassword").bind('submit', function () {
                    if (!$.formSubmitF('.v4-input', {
                            fromT: '#changeTradingPassword'
                        })) return false;

                    $('#v4-input-btn').addClass("disable").attr("disabled", true);

                    $.ajax({
                        url: '/user/doForgetTradingPassword',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'step': 'one',
                            'code': $.trim($('#phoneCode').val())}
                        ,
                        success: function (sendRes) {
                            if(sendRes.code == 302){
                                window.location.href ='/login';
                            }else if(sendRes.code == 200){
                                window.location.href ='/user/vaildTradingPassword';
                            }else{
                                $("#v4-input-msg").html(sendRes.msg);
                                $('#v4-input-btn').removeClass("disable").attr("disabled", null);
                            }
                        },
                        error: function (msg) {
                            $('#v4-input-btn').removeClass("disable").attr("disabled", null);
                        }
                    });

                    return false;

                });

                //密码eye
                $(".v4-eye-icon").click(function () {
                    if ($(this).hasClass("open")) {
                        $(this).removeClass("open");
                        $(this).html("&#xe6a1;");
                        $(this).prev().attr("type", "password");
                    } else {
                        $(this).addClass("open");
                        $(this).prev().attr("type", "text");
                        $(this).html("&#xe6a2;");
                    }
                })

            })
        })(jQuery);


        (function ($) {
            $(document).ready(function () {
                var timeout = 0, maxTimeout = 60;
                var desc = "秒后重发";

                $("#code").click(function () {

                    $("#code").addClass("disable").attr("disabled", true);

                    $.ajax({
                        url: '/common/sendSms',
                        type: 'POST',
                        dataType: 'json',
                        data: {'type': 'find_tradingPassword'},
                        success: function (sendRes) {
                            if(sendRes.code == 302){
                                window.location.href ='/login';
                            }else if (sendRes.code == 200) {
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
                            $("#v4-input-msg").text("服务器端错误，请点击重新获取");
                            $("#code").removeClass("disable").val($("#code").attr("default-value")).attr("disabled", null);
                            clearInterval(timer);
                        }
                    });
                });
            });
        })(jQuery);

    </script>
@endsection
