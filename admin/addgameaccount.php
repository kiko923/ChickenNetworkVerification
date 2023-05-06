<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>软件信息</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-card-body" >
    <form class="layui-form layui-form-pane" lay-filter="layuiadmin-form-admin">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">账号数据</label>
            <div class="layui-input-block">
                <textarea type="text" name="gameaccounts" autocomplete="off" class="layui-textarea" style="height:300px;"></textarea>
            </div>
        </div>
        <div class="layui-form-item layui-hide" >
            <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-back-submit" value="确认">
        </div>
    </form>
</div>

<script src="../layuiadmin/layui/layui.js"></script>
<script src="../layuiadmin/layui/jquery.min.js"></script>
<script>
    layui.config({
        base: '../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'laydate'], function(){
        var admin = layui.admin
            ,element = layui.element
            ,layer = layui.layer
            ,laydate = layui.laydate
            ,form = layui.form;

        $.ajax({
            url: '../interface/ajax.php?t=admin&a=login-ck',
            type: 'POST',
            dataType: 'json',
            data: '',
            success: function (res) {
                if(res.code == '201') {
                    top.location.href="login.php";
                }
            }
        });
    });

</script>
</body>
</html>
