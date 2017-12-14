<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
<script>
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$sdk['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$sdk['timestamp']}}" , // 必填，生成签名的时间戳
        nonceStr:  "{{$sdk['nonceStr']}}", // 必填，生成签名的随机串
        signature: "{{$sdk['signature']}}",// 必填，签名，见附录1
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
        ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });

    var weixin = function(title, link, imageurl, desc, shareUrl){
        wx.ready(function() {
            wx.checkJsApi({
                jsApiList: [
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                ],
                success: function (res) {
                }
            });

            //分享到朋友圈
            wx.onMenuShareTimeline({
                title: title,
                link: link,
                imgUrl: imageurl,
                success: function (res) {
                    shareCallback(shareUrl);
                },
                cancel: function (res) {
                    alert('用户已取消分享');
                }
            });
            //分享给朋友
            wx.onMenuShareAppMessage({
                title: title,
                link: link,
                imgUrl: imageurl,
                desc: desc,
                success: function (res) {
                    shareCallback(shareUrl);
                },
                cancel: function (res) {
                    alert('用户已取消分享');
                }
            });
        });
        wx.error(function(res) {
        });
    };
    weixin('{{$shareTitle}}','{{$lineLink}}','{{$imgUrl}}','{{$descContent}}', '{{$shareCallBack}}') ;
</script>
