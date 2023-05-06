<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>接口信息</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
    
    
    <div class="layui-card-body" style="margin: 5px;">
        <form class="layui-form layui-form-pane" action="" lay-filter="layuiadmin-form-admin">
          <div class="layui-form-item">
              <label class="layui-form-label">选择接口</label>
              <div class="layui-input-block">
                  <select name="name" lay-search>
                      <option value="">请选择一个接口</option>
                      <option value="用户注册">用户注册(reg)</option>
                      <option value="用户登录">用户登录(login)</option>
                      <option value="用户充值">用户充值(recharge)</option>
                      <option value="换绑信息">换绑信息(binding)</option>
                      <option value="更改密码">更改密码(uppwd)</option>
                      <option value="注销登录">注销登录(logout)</option>
                      <option value="在线心跳">在线心跳(heartbeat)</option>
                      <option value="验证授权">验证授权(checkauth)</option>
                      <option value="扣除点数">扣除点数(deductpoints)</option>
                      <option value="日志记录">日志记录(addlog)</option>
                      <option value="数据转发">数据转发(relay)</option>
                      <option value="取用户信息">取用户信息(getuser)</option>
                      <option value="取软件信息">取软件信息(init)</option>
                      <option value="取软件公告">取软件公告(notice)</option>
                      <option value="取版本信息">取版本信息(ver)</option>
                      <option value="取云常量">取云常量(constant)</option>
                      <option value="取云变量">取云变量(getvariable)</option>
                      <option value="写云变量">写云变量(setvariable)</option>
                      <option value="删云变量">删云变量(delvariable)</option>
                      <option value="取用账号">取用账号(takegaccount)</option>
                      <option value="归还账号">归还账号(stillgaccount)</option>
                      <option value="取用账号2">取用账号2(takegaccount2)</option>
                      <option value="归还账号2">归还账号2(stillgaccount2)</option>
                      <option value="取游戏账号列表">取游戏账号列表(getgameaccount)</option>
                      <option value="取云端数据">取云端数据(getudata)</option>
                      <option value="存云端数据">存云端数据(setudata)</option>
                      <option value="取云端数据2">取云端数据(getudata2)</option>
                      <option value="存云端数据2">存云端数据(setudata2)</option>
                      <option value="验证软件MD5">验证软件MD5(md5)</option>
                      <option value="调用云计算1">调用云计算1(callPHP)</option>
                      <option value="调用云计算2">调用云计算2(callPHP2)</option>
                      <option value="查询黑名单">查询黑名单(getblack)</option>
                      <option value="添加黑名单">添加黑名单(setblack)</option>
                      <option value="绑定推荐人">绑定推荐人(bindreferrer)</option>
                  </select>
              </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">加密与否</label>
            <div class="layui-input-block">
              <select name="type" lay-search>
                <option value="">请选择是否加密</option>
                <option value="0">不加密</option>
                <option value="1">加密接口</option>
              </select>
            </div>
          </div>
         
            <div class="layui-form-item layui-hide" >
              <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-back-submit" value="确认">
            </div>
        </form>
      </div>

  <script src="../layuiadmin/layui/layui.js"></script>  
  <script src="../layuiadmin/layui/jquery.min.js"></script>
  <script>
  layui.config({
    base: '../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'form', 'laydate'], function(){
    var admin = layui.admin
    ,element = layui.element
    ,layer = layui.layer
    ,laydate = layui.laydate
    ,form = layui.form;
    
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
  });
    
  </script>
</body>
</html>
