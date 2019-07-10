<?php /*a:1:{s:69:"/Library/WebServer/documents/www/rhaphp/addons/h5/view//home/pay.html";i:1562755211;}*/ ?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlentities($title); ?></title>
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <script type="text/javascript" src="/public/static//jquery/jquery-1.11.0.min.js"></script>
</head>
<body>
<h3>这是自定的模板页面</h3>
<div class="weui-form-preview">
    <div class="weui-form-preview__hd">
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">付款金额</label>
            <em class="weui-form-preview__value">¥<?php echo htmlentities($payment['money']); ?></em>
        </div>
    </div>
    <div class="weui-form-preview__bd">
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">商品</label>
            <span class="weui-form-preview__value"><?php echo htmlentities($payment['title']); ?></span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">附加信息</label>
            <span class="weui-form-preview__value"><?php echo htmlentities($payment['attach']); ?></span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">订单号</label>
            <span class="weui-form-preview__value"><?php echo htmlentities($payment['order_number']); ?></span>
        </div>
    </div>
</div><br>
<div style="padding: 15px;">
    <a onclick="callpay()" class="weui-btn weui-btn_primary">立即支付</a>
</div>

<script>
    function callpay() {
        $(function () {
            var money=$('.money').val();
            $.post("",{'payment_id':"<?php echo htmlentities($payment['payment_id']); ?>"},function (res) {
                if(res.status==1){
                    WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',
                        res.jsApiParameters,
                        function(res){
                            if(res.err_msg == 'get_brand_wcpay_request:ok') {
                                $.post("<?php echo url('queryOrderByWxpay'); ?>",{'ordernumber':"<?php echo htmlentities($payment['order_number']); ?>"},function (res) {
                                    if(res.status==1){
                                        $.toast(res.msg);
                                    }else{
                                        $.alert(res.msg);
                                    }
                                })
                            } else {
                                // $.alert('启动微信支付失败, 请检查你的支付参数');
                            }
                        }
                    );
                }else{
                    $.alert(res.msg);
                }
            })
        })
    }

</script>
</body>
</html>