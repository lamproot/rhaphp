<?php /*a:1:{s:71:"/Library/WebServer/documents/www/rhaphp/addons/h5/view//admin/user.html";i:1562748573;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script type="text/javascript" src="/public/static//jquery/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/public/static//layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/static//layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/addons/h5/static//css/style.css" />
</head>
<?php if(isMobile() == true): ?>
<style>
    .layui-btn{margin-bottom: 5px;}
</style>
<script>
    $(function () {
        $('.vote_time').remove();
        $('.bm_id').remove();
    })
</script>
<?php endif; ?>
<body style="padding: 0px 10px;">
<table class="layui-table" lay-skin="nob" lay-size="sm">
    <thead>
    <tr>
        <th class="bm_id">ID</th>
        <th>用户</th>
        <th>级别</th>
        <th>开始时间</th>
        <th>截止时间</th>
        <th>添加时间</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
        <td class="bm_id"><?php echo htmlentities($vo['id']); ?></td>
        <td><?php echo htmlentities($vo['openid']); ?></td>
        <td><?php echo htmlentities($vo['type']); ?></td>
        <td class="vote_time"><?php echo date('Y-m-d H:i',$vo['started_at']); ?></td>
        <td class="vote_time"><?php echo date('Y-m-d H:i',$vo['stoped_at']); ?></td>
        <td class="vote_time"><?php echo date('Y-m-d H:i',$vo['created_at']); ?></td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>
<?php echo htmlentities($data->render()); ?>
</body>
<script>
    var layer;
    layui.use('layer',function () {
        layer = layui.layer;
    })
</script>
</html>