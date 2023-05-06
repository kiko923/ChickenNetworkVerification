<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品列表</title>
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
        <a><cite>商品列表</cite></a>
    </div>
</div>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">商品列表</div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

                    <script type="text/html" id="test-table-toolbar-toolbarDemo">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="add"><i class="layui-icon layui-icon-add-circle"></i>添加</button>
                            <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</button>
                        </div>
                    </script>

                    <script type="text/html" id="test-table-toolbar-barDemo">
                        <a class="layui-btn layui-btn-xs layui-bg-green" lay-event="edit">配置</a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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

        table.render({
            elem: '#test-table-toolbar'
            ,url: '../interface/ajax.php?t=admin&a=goods-json'
            ,toolbar: '#test-table-toolbar-toolbarDemo'
            ,id: 'LAY-table-manage'
            ,title: '商品数据表'
            ,cols: [[
                {type: 'checkbox', fixed: 'left'}
                ,{field:'id', title:'ID', width:70, unresize: true, align:'center'}
                ,{field:'name', title:'商品名', minWidth:150}
                ,{field:'zt', title:'状态', minWidth:100, align:'center'}
                ,{field:'type', title:'类型', minWidth:100, align:'center'}
                ,{field:'money', title:'单价', minWidth:80, align:'center'}
                ,{field:'quota', title:'是否限购', minWidth:100, align:'center'}
                ,{field:'sale', title:'销售数量', minWidth:100, align:'center'}
                ,{field:'addtime', title:'添加时间', minWidth:180, align:'center'}
                ,{field:'introduce', title:'商品介绍', minWidth:300}
                ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:120}
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
                        title:'添加商品'
                        ,type: 2
                        ,content: 'goodinfo.php'
                        ,shadeClose: true
                        ,area: admin.screen() < 2 ? ['80%', '75%'] : ['695px', '80%']
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
                                    url:'../interface/ajax.php?t=admin&a=goods-set',
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
                    layer.confirm('确认删除选中商品吗？<br><span style="font-size:10px;color:red;">如有正在付款购买的用户，可能会导致购买失败！</span>',{title:'二次确认'}, function(index){
                        $.ajax({
                            type:'POST',
                            url:'../interface/ajax.php?t=admin&a=goods-delor',
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
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确认删除商品['+data.name+']吗？<br><span style="font-size:10px;color:red;">如有正在付款购买的用户，可能会导致购买失败！</span>',{title:'二次确认'}, function(index){
                    $.ajax({
                        type:'POST',
                        url:'../interface/ajax.php?t=admin&a=goods-del&id='+data.id,
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
            } else if(obj.event === 'edit'){
                layer.open({
                    title:'配置商品[名称:'+data.name+']'
                    ,type: 2
                    ,content: 'goodinfo.php?id='+data.id
                    ,shadeClose: true
                    ,area: admin.screen() < 2 ? ['80%', '75%'] : ['695px', '80%']
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
                                url:'../interface/ajax.php?t=admin&a=goods-set&id='+data.id,
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
            }
        });
    });
</script>
</body>
</html>