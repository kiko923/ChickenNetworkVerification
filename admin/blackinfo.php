<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>数据信息</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-card-body" style="margin: 5px;">
    <form class="layui-form layui-form-pane" lay-filter="layuiadmin-form-admin">
        <div class="layui-form-item">
            <label class="layui-form-label">所属软件</label>
            <div class="layui-input-block">
                <select id="applist" name="appid" lay-search lay-filter="applist"></select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据类型</label>
            <div class="layui-input-block">
                <select class="form-control" name="type">
                    <option value=""></option>
                    <option value="0">账号</option>
                    <option value="1">设备码</option>
                    <option value="2">设备IP</option>
                    <option value="3">自定义</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">云黑数据</label>
            <div class="layui-input-block">
                <textarea type="text" id="data" name="data" placeholder="请填写账号/设备码/设备IP等黑名单数据" autocomplete="off" class="layui-textarea" style="height:80px;"></textarea>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">备注信息</label>
            <div class="layui-input-block">
                <textarea type="text" id="bz" name="bz" autocomplete="off" class="layui-textarea" style="height:80px;"></textarea>
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

        laydate.render({
            elem: '#endtime',
            type: 'datetime'
        });

        var load = layer.load();
        $.ajax({
            url: '../interface/ajax.php?t=admin&a=get-applist',
            type: 'POST',
            dataType: 'html',
            data: '',
            async: false,
            success: function (data) {
                layer.close(load);
                $('#applist').html(data);
                form.render('select');
            },
            error: function (data) {
                layer.close(load);
                layer.msg('请求失败' + data);
            }
        });

        var idd = GetQueryString("id");
        if (idd != null) {
            $.ajax({
                type:'GET',
                url:'../interface/ajax.php?t=admin&a=black-get&id=' + idd,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    form.val('layuiadmin-form-admin', data.msg);
                    form.render();
                }
            });
        }
    });

    function GetQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return decodeURI(r[2]);
        return null;
    };
</script>
</body>
</html>
