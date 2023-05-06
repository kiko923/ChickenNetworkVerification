<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>在线列表</title>
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
      <a><cite>在线列表</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">在线列表</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
            
            <script type="text/html" id="test-table-toolbar-toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>强制下线</button>
              </div>
            </script>
             
            <script type="text/html" id="test-table-toolbar-barDemo">
              <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">强制下线</a>
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
      ,url: '../interface/ajax.php?t=admin&a=heartbeat-json'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,id: 'LAY-table-manage'
      ,title: '在线数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left'}
        ,{field:'id', title:'ID', width:70, unresize: true, align:'center'}
        ,{field:'user', title:'账户', width:180}
        ,{field:'appname', title:'软件名', width:150}
        ,{field:'ver', title:'版本', width:80, align:'center'}
        ,{field:'logintime', title:'登录时间', width:180, align:'center'}
        ,{field:'hbtime', title:'心跳时间', width:180, align:'center'}
        ,{field:'clientID', title:'客户端ID', width:180, align:'center'}
        ,{field:'mac', title:'设备码', width:120, align:'center'}
        ,{field:'ip', title:'设备IP', width:130, align:'center'}
        ,{field:'endtime', title:'过期时间', width:180, align:'center'}
        ,{field:'point', title:'点数', width:100, align:'center'}
        ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
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
        case 'del':
            var data = checkStatus.data;
            layer.confirm('确认强制下线选中用户吗？<br><span style="font-size:10px;color:red;">强制下线后用户将在下次心跳后离线</span>',{title:'二次确认'}, function(index){
            $.ajax({
                type:'POST',
                url:'../interface/ajax.php?t=admin&a=heartbeat-delor',
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
        layer.confirm('确认强制下线['+data.user+']用户吗？<br><span style="font-size:10px;color:red;">强制下线后用户将在下次心跳后离线</span>',{title:'二次确认'}, function(index){
            $.ajax({
                type:'POST',
                url:'../interface/ajax.php?t=admin&a=heartbeat-del&id='+data.id,
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