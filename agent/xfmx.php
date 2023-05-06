<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>消费明细</title>
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
    <a><cite>消费明细</cite></a>
  </div>
</div>
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">消费明细</div>
        <div class="layui-card-body">
          <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
          <script type="text/html" id="test-table-toolbar-barDemo">
            <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="dd">关联订单</a>
          </script>
</div></div></div></div></div></div>

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
      ,url: '../interface/ajax.php?t=agent&a=agentlog-json'
      ,id: 'LAY-table-manage'
      ,title: '消费数据表'
      ,cols: [[
        {field:'id', title:'ID', width:70, unresize: true, align:'center'}
        ,{field:'type', title:'操作类型', width:100, align:'center'}
        ,{field:'x_type', title:'子类型', width:80, align:'center'}
        ,{field:'money', title:'金额', width:100, align:'center'}
        ,{field:'syje', title:'<b>账户余额</b>', width:150, align:'center'}
        ,{field:'info', title:'记录信息', minWidth:300}
        ,{field:'addtime', title:'记录时间', width:160, align:'center'}
        ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:100}
      ]]
      ,page: true
      ,response: {
        statusCode: 200 //重新规定成功的状态码为 200，table 组件默认为 0
      }
    });

    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'dd'){
          $.ajax({
            type:'POST',
            url:'../interface/ajax.php?t=agent&a=get-moneylog&id='+data.id,
            dataType: 'json',
            data: '',
            cache: false,
            success: function (data) {
                layer.alert(data.msg,{'title':'关联订单'});
            }
          });
      }
    });

  });

</script>
</body>
</html>