<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>明细查询</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">

  <link rel="stylesheet" href="../layuiadmin/style/free.css" media="all">
</head>
<body>

<div class="layui-fluid" style="padding: 0px 10px 5px 10px; position:absolute; left: 0; top: 0; bottom: 0px; right: 0;">
          <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
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

    var idd = GetQueryString("id");

    table.render({
      elem: '#test-table-toolbar'
      ,url: '../interface/ajax.php?t=agent&a=moneylog-json&id='+idd
      ,id: 'LAY-table-manage'
      ,title: '在线数据表'
      ,cols: [[
        {field:'id', title:'ID', width:70, unresize: true, align:'center'}
        ,{field:'type', title:'操作类型', width:100, align:'center'}
        ,{field:'x_type', title:'子类型', width:80, align:'center'}
        ,{field:'money', title:'金额', width:120, align:'center'}
        ,{field:'syje', title:'<b>账户余额</b>', width:120, align:'center'}
        ,{field:'addtime', title:'记录时间', width:160, align:'center'}
      ]]
      ,page: true
      ,response: {
        statusCode: 200 //重新规定成功的状态码为 200，table 组件默认为 0
      }
    });

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