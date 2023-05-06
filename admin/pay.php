<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>支付配置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
</head>
<body>
    
    <div class="layui-card layadmin-header">
    <div class="layui-breadcrumb" lay-filter="breadcrumb">
      <a lay-href="">控制台</a>
      <a><cite>支付配置</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-card">
      <div class="layui-card-header">支付配置(V免签)</div>
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form layui-form-pane" action="" lay-filter="layuiadmin-form-admin">
          <div class="layui-form-item">
            <label class="layui-form-label">对接网址</label>
            <div class="layui-input-block">
              <input type="text" name="pay_url" placeholder="请输入V免签地址" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">通讯秘钥</label>
            <div class="layui-input-block">
              <input type="text" name="pay_key" placeholder="请输入通讯秘钥" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn layui-btn-sm" type="button" lay-submit lay-filter="submitA">保存</button>
            </div>
          </div>
          
        </form>
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
  }).use(['index', 'table','form'], function(){
    var admin = layui.admin
    ,form = layui.form
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
    
    $.ajax({
        type:'POST',
        url: '../interface/ajax.php?t=admin&a=get-core',
        type: 'POST',
        dataType: 'json',
        cache: false,
        success: function (res) {
            form.val('layuiadmin-form-admin', res.msg);
            form.render();
        }
    });

    form.on('submit(submitA)', function(data){
        $.ajax({
            type:'POST',
            url: '../interface/ajax.php?t=admin&a=set-core',
            type: 'POST',
            dataType: 'json',
            data: data.field,
            cache: false,
            success: function (res) {
                layer.alert(res.msg, {icon: 1});
            }
        });
    });
    
  });
  </script>
</body>
</html>
