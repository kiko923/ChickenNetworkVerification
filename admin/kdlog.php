<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>计点日志</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/free.css" media="all">
</head>
<body>

<div class="layui-card layadmin-header">
    <div class="layui-breadcrumb" lay-filter="breadcrumb">
        <a lay-href="">控制台</a>
        <a><cite>计点日志</cite></a>
    </div>
</div>


    <div class="layui-row layui-col-space15">
            <div class="layui-card">
                    <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
            </div>
    </div>


<script src="../layuiadmin/layui/layui.js"></script>
<script src="../layuiadmin/layui/jquery.min.js"></script>
<script>
    layui.config({
        base: '../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table'], function(){
        var admin = layui.admin
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

        function GetQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null)
                return decodeURI(r[2]);
            return 0;
        };

        var idd = GetQueryString("id");

        table.render({
            elem: '#test-table-toolbar'
            ,url: '../interface/ajax.php?t=admin&a=kd-json&id='+idd
            ,id: 'LAY-table-manage'
            ,title: '计点数据表'
            ,cols: [[
                {field:'id', title:'ID', width:70, unresize: true, align:'center'}
                ,{field:'appname', title:'软件名称', minWidth:120}
                ,{field:'type', title:'类型', width:90, align:'center'}
                ,{field:'kdsl', title:'点数',minWidth:80, align:'center'}
                ,{field:'ver', title:'版本', width:90, align:'center'}
                ,{field:'clientid', title:'客户端ID', width:180, align:'center'}
                ,{field:'mac', title:'设备码', width:180, align:'center'}
                ,{field:'ip', title:'设备IP', width:180, align:'center'}
                ,{field:'addtime', title:'扣除时间', width:180, align:'center'}
            ]]
            ,page: true
            ,response: {
                statusCode: 200 //重新规定成功的状态码为 200，table 组件默认为 0
            }
        });

    });
</script>
</body>
</html>