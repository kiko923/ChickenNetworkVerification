<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>游戏号列表</title>
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
        <a><cite>游戏号列表[1]</cite></a>
    </div>
</div>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">游戏号列表[1]</div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

                    <script type="text/html" id="test-table-toolbar-toolbarDemo">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="add"><i class="layui-icon layui-icon-add-circle"></i>导入</button>
                            <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</button>
                        </div>
                    </script>

                    <script type="text/html" id="test-table-toolbar-barDemo">
                        <a class="layui-btn layui-btn-xs layui-bg-red" lay-event="del">删除</a>
                    </script>
                </div>
            </div>
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
    }).use(['index', 'table','dropdown'], function(){
        var admin = layui.admin
            ,table = layui.table
            ,dropdown = layui.dropdown;

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

        table.render({
            elem: '#test-table-toolbar'
            ,url: '../interface/ajax.php?t=admin&a=gameaccount-json'
            ,toolbar: '#test-table-toolbar-toolbarDemo'
            ,id: 'LAY-table-manage'
            ,title: '游戏号数据表'
            ,cols: [[
                {type: 'checkbox', fixed: 'left'}
                ,{field:'id', title:'ID', width:60, unresize: true, align:'center'}
                ,{field:'c1', title:'账号', minWidth:160}
                ,{field:'c2', title:'密码', minWidth:160}
                ,{field:'c3', title:'授权文件', minWidth:125}
                ,{field:'c4', title:'游戏名称', minWidth:100, align:'center'}
                ,{field:'zt', title:'状态', width:100, align:'center'}
                ,{field:'cs', title:'取用', width:100, align:'center'}
                ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:70}
            ]]
            ,page: true
            ,response: {
                statusCode: 200 //重新规定成功的状态码为 200，table 组件默认为 0
            }
        });

        //头工具栏事件
        table.on('toolbar(test-table-toolbar)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            switch(obj.event){
                case 'add':
                    layer.open({
                        title:'导入账号 [格式：账号----密码----授权文件----游戏名称]'
                        ,type: 2
                        ,offset: 'rb'
                        ,anim: 2
                        ,content: 'addgameaccount.php'
                        ,shadeClose: true
                        ,area: admin.screen() < 2 ? ['100%', '100%'] : ['50%', '100%']
                        ,btn: ['确定', '取消']
                        ,maxmin: true
                        ,yes: function(index, layero){
                            var iframeWindow = window['layui-layer-iframe'+ index]
                                ,submitID = 'LAY-user-back-submit'
                                ,submit = layero.find('iframe').contents().find('#'+ submitID);
                            iframeWindow.layui.form.on('submit(LAY-user-front-submit)', function(datas){
                                var field = datas.field;
                                $.ajax({
                                    type:'POST',
                                    url:'../interface/ajax.php?t=admin&a=gameaccount-set',
                                    dataType: 'json',
                                    data: field,
                                    cache: false,
                                    success: function (data) {
                                        if(data.code==200){
                                            table.reload('LAY-table-manage');
                                            layer.alert(data.msg, {icon: 1});
                                        }else{
                                            layer.alert(data.msg, {icon: 0});
                                        }
                                    }
                                });
                                //layer.close(index); //关闭弹层
                            });
                            submit.trigger('click');
                        }
                    });
                    break;
                case 'del':
                    var data = checkStatus.data;
                    layer.confirm('确认删除选中账号吗？',{title:'二次确认'}, function(index){
                        $.ajax({
                            type:'POST',
                            url:'../interface/ajax.php?t=admin&a=gameaccount-delor',
                            dataType: 'json',
                            data: 'data='+JSON.stringify(data),
                            cache: false,
                            success: function (data) {
                                if(data.code==200){
                                    table.reload('LAY-table-manage');
                                    layer.alert(data.msg, {icon: 1});
                                }else{
                                    layer.alert(data.msg, {icon: 2});
                                }
                            }
                        });
                        layer.close(index);
                    });
                    break;
            };
        });

        //监听行工具事件
        table.on('tool(test-table-toolbar)', function(obj){
            datax = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确认删除账号['+datax.c1+']吗？',{title:'二次确认'}, function(index){
                    $.ajax({
                        type:'POST',
                        url:'../interface/ajax.php?t=admin&a=gameaccount-del&id='+datax.id,
                        dataType: 'json',
                        data: '',
                        cache: false,
                        success: function (data) {
                            if(data.code==200){
                                table.reload('LAY-table-manage');
                                layer.alert(data.msg, {icon: 1});
                            }else{
                                layer.alert(data.msg, {icon: 2});
                            }
                        }
                    });
                    layer.close(index);
                });
            }
        });

    });
</script>
</body>
</html>