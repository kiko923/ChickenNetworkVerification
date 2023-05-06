

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>代理登录 | 炸鸡网络验证</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../../layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="../../layuiadmin/style/login.css" media="all">
</head>
<body>

<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

  <div class="layadmin-user-login-main">
    <div class="layadmin-user-login-box layadmin-user-login-header">
      <h2>代理登录</h2>
      <p> </p>
    </div>
    <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
      <div class="layui-form-item">
        <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
        <input type="text" name="user" id="LAY-user-login-username" lay-verify="required" placeholder="用户名" class="layui-input">
      </div>
      <div class="layui-form-item">
        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
        <input type="password" name="pwd" id="LAY-user-login-password" lay-verify="required" placeholder="密码" class="layui-input">
      </div>
      <div class="layui-form-item">
        <div class="layui-row">
          <div class="layui-col-xs7">
            <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
            <input type="text" name="code" id="LAY-user-login-vercode" lay-verify="required" placeholder="验证码" class="layui-input">
          </div>
          <div class="layui-col-xs5">
            <div style="margin-left: 10px;">
              <span id="codeimg"><img src="../include/code.php" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" style="margin-bottom: 20px;">
        <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
      </div>
      <div class="layui-form-item">
        <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-login-submit">登 入</button>
      </div>
    </div>
  </div>

  <div class="layui-trans layadmin-user-login-footer">

    <p>Copyright © 2023 · 竹影网络工作室</p>

  </div>

</div>

<script src="../layuiadmin/layui/layui.js"></script>
<script src="../layuiadmin/layui/jquery.min.js"></script>
<script>
  layui.config({
    base: '../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index'], function(){
    var admin = layui.admin
            ,form = layui.form;

    document.getElementById("codeimg").onclick=function(){show()};
    function show(){
      $('#codeimg').html('<img src="../include/code.php" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">');
    }

    //提交
    form.on('submit(LAY-user-login-submit)', function(obj){
      var loading = layer.load();
      $.ajax({
        url: '../interface/ajax.php?t=agent&a=login',
        type: 'POST',
        dataType: 'json',
        data: obj.field,
        success: function (res) {
          layer.close(loading);
          if(res.code == '200') {
            layer.msg('登录成功', {
              icon: 1
              ,time: 1000
            }, function(){
              layer.closeAll();
              top.location.href = 'index.php'; //管理员后台主页
            });
          }else{
            layer.msg(res.msg);
            $('#codeimg').trigger('click');
          }
        }
      });
    });

  });
</script>
</body>
</html>