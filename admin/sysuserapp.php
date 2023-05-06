<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>人员管理</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-card-body">

  <div id="test-transfer-demo1"></div>
</div>

<script src="../layuiadmin/layui/layui.js"></script>
<script src="../layuiadmin/layui/jquery.min.js"></script>
<script>
  layui.config({
    base: '../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','form', 'transfer'], function(){
        var admin = layui.admin
            ,transfer = layui.transfer
            ,form = layui.form ;

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

    var idd = GetQueryString("id");

    transfer.render({
      elem: '#test-transfer-demo1'
      ,title: ['未授权软件', '已授权软件']
      ,showSearch: true
      ,id: 'AutApp'
      ,onchange: function(obj, index){
        var Appdata = transfer.getData('AutApp');
        $.ajax({
          type:'POST',
          url:'../interface/ajax.php?t=admin&a=admin-usersetapp&id=' + idd,
          dataType: 'json',
          data: 'data=' + JSON.stringify(Appdata),
          cache: false,
          success: function (data) {
            if(data.code==200){
              layer.msg(data.msg, {icon: 1});
            }else{
              layer.msg(data.msg, {icon: 0});
            }
          }
        });
      }
    });

    if (idd != null) {
      $.ajax({
        type:'GET',
        url:'../interface/ajax.php?t=admin&a=admin-usergetapp&id=' + idd,
        dataType: 'json',
        cache: false,
        success: function (res) {
          transfer.reload('AutApp',res);
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
    }

</script>
</body>
</html>