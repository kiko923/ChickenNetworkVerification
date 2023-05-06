<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>数据转发</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
</head>
<body>

<div class="layui-card layadmin-header">
    <div class="layui-breadcrumb" lay-filter="breadcrumb">
        <a lay-href="">高级功能</a>
        <a><cite>数据转发</cite></a>
    </div>
</div>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">转发配置</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form layui-form-pane" action="" lay-filter="layuiadmin-form-admin">
                <div class="layui-form-item">
                    <div class="layui-collapse" lay-accordion>
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">(1) 数据转发说明</h2>
                            <div class="layui-colla-content">数据转发是基于HTTP协议的，通过POST&GET进行数据投递，数据不做任何处理，原生转发，无需登录即可调用，每次转发最长等待结果时间为7秒，超时则返回空。<br>数据转发可用于一些其他语言的动态函数计算或为了达到某种需求和功能。</div>
                        </div>
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">(2) 投递数据结构</h2>
                            <div class="layui-colla-content">每次投递数据的内容包括接口号、软件ID、设备码、设备IP、客户端ID等信息，需要自行进行处理。</div>
                        </div>
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">(3) 接收接口构建</h2>
                            <div class="layui-colla-content">接收接口需要自行构建，官方不提供接收接口构建的SDK。</div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">转发地址</label>
                    <div class="layui-input-block">
                        <input type="text" name="relay_url" placeholder="请输入转发地址,请附带http(s)://前缀" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">转发方式</label>
                    <div class="layui-input-block">
                        <select name="relay_type">
                            <option value=""></option>
                            <option value="0">GET</option>
                            <option value="1">POST</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn layui-btn-sm" type="button" lay-submit lay-filter="submitA">保存修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="../layuiadmin/layui/layui.js"></script>
<script src="../layuiadmin/layui/jquery.min.js"></script>
<script>
    layui.config({
        base: '../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table','form'], function(){
        var admin = layui.admin
            ,form = layui.form
            ,table = layui.table;

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

        $.ajax({
            type:'POST',
            url: '../interface/ajax.php?t=admin&a=get-core',
            type: 'POST',
            dataType: 'json',
            cache: false,
            success: function (res) {
                form.val('layuiadmin-form-admin', res.msg);
                form.render();
            }
        });

        form.on('submit(submitA)', function(data){
            $.ajax({
                type:'POST',
                url: '../interface/ajax.php?t=admin&a=set-core',
                type: 'POST',
                dataType: 'json',
                data: data.field,
                cache: false,
                success: function (res) {
                    layer.alert(res.msg, {icon: 1});
                }
            });
        });
    });
</script>
</body>
</html>
