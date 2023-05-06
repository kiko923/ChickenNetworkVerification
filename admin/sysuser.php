<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>人员管理</title>
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
        <a><cite>人员管理</cite></a>
    </div>
</div>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">人员列表</div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
                    <script type="text/html" id="test-table-toolbar-toolbarDemo">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="add"><i class="layui-icon layui-icon-add-circle"></i>添加人员</button>
                            <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</button>
                        </div>
                    </script>

                    <script type="text/html" id="test-table-toolbar-barDemo">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="Aut">授权</a>
                        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
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
            ,url: '../interface/ajax.php?t=admin&a=admin-json'
            ,toolbar: '#test-table-toolbar-toolbarDemo'
            ,id: 'LAY-table-manage'
            ,title: '人员数据表'
            ,cols: [[
                {type: 'checkbox', fixed: 'left'}
                ,{field:'id', title:'ID', width:50, unresize: true, align:'center'}
                ,{field:'name', title:'昵称', width:150, hide: true}
                ,{field:'user', title:'账号', width:180}
                ,{field:'type', title:'类型', width:100, align:'center'}
                ,{field:'aname', title:'归属组别', minWidth:120, align:'center'}
                ,{field:'zt', title:'状态', width:100, align:'center'}
                ,{field:'adds', title:'添加下级', width:100, align:'center'}
                ,{field:'money', title:'余额', width:100, align:'center'}
                ,{field:'consume', title:'已消费', width:100, align:'center'}
                ,{field:'level', title:'制卡折扣', width:100, align:'center'}
                ,{field:'rebate', title:'返利上级', width:100, align:'center'}
                ,{field:'ktzk', title:'开通折扣', width:100, align:'center'}
                ,{field:'aid', title:'上级代理', width:130, align:'center'}
                ,{field:'logintime', title:'登录时间', width:180, align:'center'}
                ,{field:'bz', title:'备注', width:200}
                ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:180}
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
                        title:'添加人员'
                        ,type: 2
                        ,content: 'sysuserinfo.php'
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
                                    url:'../interface/ajax.php?t=admin&a=admin-set',
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
                    layer.confirm('确认删除选中人员吗？<br><span style="font-size:10px;color:red;">Ps:删除后已在线的人员将会被移除登录。</span>',{title:'二次确认'}, function(index){
                        $.ajax({
                            type:'POST',
                            url:'../interface/ajax.php?t=admin&a=admin-delor',
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

        function setdata(appid,uid,keys,value){
            $.ajax({
                type:'POST',
                url:'../interface/ajax.php?t=admin&a=admin-set&id='+uid,
                dataType: 'json',
                data: 'appid='+appid+'&'+keys+'='+value,
                cache: false,
                success: function (data) {
                    if(data.code == 200){
                        layer.msg('修改成功');
                    }else{
                        layer.msg('修改失败');
                    }
                }
            });
        }

        //监听行工具事件
        table.on('tool(test-table-toolbar)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确认删除人员['+data.user+']吗？', function(index){
                    $.ajax({
                        type:'POST',
                        url:'../interface/ajax.php?t=admin&a=admin-del&id='+data.id,
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
                    title:'修改人员[uid:'+data.id+']'
                    ,type: 2
                    ,content: 'sysuserinfo.php?id='+data.id
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
                                url:'../interface/ajax.php?t=admin&a=admin-set&id='+data.id,
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
            } else if(obj.event == 'Aut') {
                layer.open({
                    title:'授权软件[uid:'+data.id+']'
                    ,type: 2
                    ,content: 'sysuserapp.php?id=' + data.id
                    ,shadeClose: true
                    ,area: admin.screen() < 2 ? ['100%', '100%'] : ['515px', '508px']
                    ,btn: ['确定']
                    ,maxmin: true
                });
            }
        });

    });
</script>
</body>
</html>