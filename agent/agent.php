<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>下级管理</title>
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
        <a><cite>下级管理</cite></a>
    </div>
</div>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">下级列表</div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
                    <script type="text/html" id="test-table-toolbar-toolbarDemo">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="show"><i class="layui-icon layui-icon-refresh"></i>刷新</button>
                            <button class="layui-btn layui-btn-sm" lay-event="add"><i class="layui-icon layui-icon-slider"></i>添加子代</button>
                        </div>
                    </script>

                    <script type="text/html" id="test-table-toolbar-barDemo">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="flxx">返利明细</a>
                        <a class="layui-btn layui-btn-xs" lay-event="Aut">授权</a>
                        <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="zz">转账</a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit">编辑</a>
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
            url: '../interface/ajax.php?t=agent&a=login-ck',
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
            ,url: '../interface/ajax.php?t=agent&a=agent-json'
            ,toolbar: '#test-table-toolbar-toolbarDemo'
            ,id: 'LAY-table-manage'
            ,title: '人员数据表'
            ,cols: [[
                {type: 'checkbox', fixed: 'left'}
                ,{field:'id', title:'ID', width:50, unresize: true, align:'center'}
                ,{field:'name', title:'昵称', width:150, hide: true}
                ,{field:'user', title:'账号', width:180}
                ,{field:'aname', title:'等级', minWidth:100, align:'center'}
                ,{field:'zt', title:'状态', width:80, align:'center'}
                ,{field:'money', title:'余额', width:100, align:'center'}
                ,{field:'consume', title:'已消费', width:100, align:'center'}
                ,{field:'level', title:'制卡折扣', width:100, align:'center'}
                ,{field:'rebate', title:'消费返利', width:100, align:'center'}
                ,{field:'logintime', title:'登录时间', width:180, align:'center'}
                ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:240}
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
                case 'show':
                    table.reload('LAY-table-manage', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                    });
                    break;
                case 'add':
                    layer.open({
                        title:'添加子代'
                        ,type: 2
                        ,content: 'agentinfo.php'
                        ,shadeClose: true
                        ,area: admin.screen() < 2 ? ['100%', '100%'] : ['695px', '80%']
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
                                    url:'../interface/ajax.php?t=agent&a=agent-set',
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
            };
        });

        //监听行工具事件
        table.on('tool(test-table-toolbar)', function(obj){
            var data = obj.data;
            if(obj.event === 'Aut'){
                layer.open({
                    title:'授权软件[账号:'+data.user+']'
                    ,type: 2
                    ,content: 'agentapp.php?id=' + data.id
                    ,shadeClose: true
                    ,area: admin.screen() < 2 ? ['100%', '100%'] : ['515px', '508px']
                    ,btn: ['确定']
                    ,maxmin: true
                });
            }else if(obj.event === 'flxx') {
                layer.open({
                    title:'返利明细[账号:'+data.user+']'
                    ,type: 2
                    ,content: 'moneylog.php?id=' + data.id
                    ,shadeClose: true
                    ,area: admin.screen() < 2 ? ['100%', '100%'] : ['650px', '508px']
                    ,btn: ['确定']
                    ,maxmin: true
                });
            }else if(obj.event === 'zz') {
                layer.prompt({title: '<span style="color:blue">请输入转账金额，并确认</span>', formType: 0}, function(text, index){
                    $.ajax({
                        url: '../interface/ajax.php?t=agent&a=agent-zz',
                        type: 'POST',
                        dataType: 'json',
                        data: 'id='+data.id+'&je='+text,
                        success: function (res) {
                            if(res.code == '201') {
                                layer.msg(res.msg,{icon:0});
                            }else{
                                layer.msg(res.msg,{icon:1});
                                table.reload('LAY-table-manage');
                            }
                        }
                    });
                });
            }else if(obj.event === 'edit'){
                layer.open({
                    title:'修改子代[id:'+data.id+']'
                    ,type: 2
                    ,content: 'agentinfo.php?id='+data.id
                    ,shadeClose: true
                    ,area: admin.screen() < 2 ? ['100%', '100%'] : ['695px', '80%']
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
                                url:'../interface/ajax.php?t=agent&a=agent-set&id='+data.id,
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