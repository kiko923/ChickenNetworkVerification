<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>网站配置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
</head>
<body>

<div class="layui-card layadmin-header">
    <div class="layui-breadcrumb" lay-filter="breadcrumb">
        <a lay-href="">控制台</a>
        <a><cite>网站配置</cite></a>
    </div>
</div>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">网站配置</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form layui-form-pane" action="" lay-filter="layuiadmin-form-admin">
                <div class="layui-form-item">
                    <label class="layui-form-label">网站名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="web_name" placeholder="请输入发信地址" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">站点网址</label>
                    <div class="layui-input-block">
                        <input type="text" name="web_url" placeholder="输入格式：http://www.baidu.com" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><a tabindex="-1" href="javascript:;" onclick="layer.alert('上传文件的大小，单位为kb，不要超过PHP设置的最大文件大小。',{title:'提示'})"><i class="layui-icon layui-icon-help text-gray" style="color:blue"></i></a>文件大小</label>
                    <div class="layui-input-block">
                        <input type="text" name="upload_size" placeholder="上传文件大小,单位:kb" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><a tabindex="-1" href="javascript:;" onclick="layer.alert('后台接口对接秘钥，调用后台开放接口需要输入指定秘钥才可调用。',{title:'提示'})"><i class="layui-icon layui-icon-help text-gray" style="color:blue"></i></a>对接秘钥</label>
                    <div class="layui-input-block">
                        <input type="text" name="webapi_key" placeholder="上传文件大小,单位:kb" class="layui-input">
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
