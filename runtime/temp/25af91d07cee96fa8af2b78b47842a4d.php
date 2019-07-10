<?php /*a:2:{s:71:"/Library/WebServer/documents/www/rhaphp/addons/h5/view//home/topup.html";i:1562668091;s:73:"/Library/WebServer/documents/www/rhaphp/addons/h5/view/./common/base.html";i:1562744799;}*/ ?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlentities($title); ?></title>
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link rel="stylesheet" type="text/css" href="/public/static//member/css/home.css" />
    <link rel="stylesheet" type="text/css" href="/public/static//icon/icon.css" />
    <script src="//cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
    <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/swiper.min.js"></script>
    <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js"></script>
</head>
<body>

<div class="weui-cells weui-cells_form" style="margin-top: 20%">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">充值金额:</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input money" type="number" name="money" placeholder="请输入金额 单位：元">

        </div>
    </div>
</div>
<br><br>
<div style="padding: 15px;">
    <a onclick="callpay()" class="weui-btn weui-btn_primary">去充值</a>
</div>
<?php echo hook('Jssdk'); ?>
<script>
    function callpay() {
        $(function () {
            var money=$('.money').val();
            $.post("",{money:money},function (res) {
                if(res.status==1){
                    window.location.href=res.url;
                }else{
                    $.alert(res.msg);
                }
            })
        })
    }

</script>

</body>
</html>