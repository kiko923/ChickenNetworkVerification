<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>人员信息</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-card-body" style="margin: 5px;">
    <form class="layui-form layui-form-pane" action="" lay-filter="layuiadmin-form-admin">
        <div class="layui-form-item">
            <label class="layui-form-label">人员账号</label>
            <div class="layui-input-block">
                <input type="text" name="user" lay-verify="required" placeholder="必填" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">人员密码</label>
            <div class="layui-input-block">
                <span type="text" id="pwd"></span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">账号状态</label>
            <div class="layui-input-block">
                <select class="form-control" name="zt">
                    <option value=""></option>
                    <option value="1">正常</option>
                    <option value="0">封禁</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">账号类型</label>
            <div class="layui-input-block">
                <select class="form-control" name="type">
                    <option value=""></option>
                    <option value="0">管理员</option>
                    <option value="1">代理账号</option>
                    <option value="2">作者账号</option>
                    <option value="3">普通用户</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">可用余额</label>
            <div class="layui-input-block">
                <input type="number" name="money" placeholder="非必填" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">消费金额</label>
            <div class="layui-input-block">
                <input type="number" name="consume" placeholder="非必填" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">用户组别</label>
            <div class="layui-input-block">
                <select id="grouplist" name="gid" lay-search lay-filter="grouplist"></select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属代理</label>
            <div class="layui-input-block">
                <input type="text" name="agent" placeholder="请输入代理账号(非必填)" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">账号备注</label>
            <div class="layui-input-block">
                <textarea type="text" id="bz" name="bz" autocomplete="off" class="layui-textarea" style="height:100px;"></textarea>
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

        var load = layer.load();
        $.ajax({
            url: '../interface/ajax.php?t=admin&a=get-group',
            type: 'POST',
            dataType: 'html',
            data: '',
            async: false,
            success: function (data) {
                layer.close(load);
                $('#grouplist').html(data);
                form.render('select');
            },
            error: function (data) {
                layer.close(load);
                layer.msg('请求失败' + data);
            }
        });

        var idd = GetQueryString("id");
        if (idd != null) {
            $('#pwd').html('<input type="text" name="pwd" placeholder="留空不修改密码" autocomplete="off" class="layui-input">');
            $.ajax({
                type:'GET',
                url:'../interface/ajax.php?t=admin&a=admin-get&id=' + idd,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    form.val('layuiadmin-form-admin', data.msg);
                    form.render();
                }
            });
        }else{
            $('#pwd').html('<input type="text" name="pwd" placeholder="留空默认密码123456" autocomplete="off" class="layui-input">');
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
