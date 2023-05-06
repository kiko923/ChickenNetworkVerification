<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>生成充值卡</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>

<div class="layui-form layui-form-pane" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="margin: 15px;">
    <div class="layui-form-item">
        <label class="layui-form-label">选择软件</label>
        <div class="layui-input-block">
            <select id="applist" name="appid" lay-search lay-filter="applist"></select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择卡类</label>
        <div class="layui-input-block">
            <select id="cardtype" name="cardtype" lay-search lay-filter="cardtype"></select>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        <blockquote class="layui-elem-quote" style="font-size:12px;color:gray;" id="cardtypeinfo">请先选择卡类</blockquote>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">制卡数量</label>
        <div class="layui-input-block">
            <input type="text" name="sl" lay-verify="number" placeholder="必填" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">备注信息</label>
        <div class="layui-input-block">
            <input type="text" name="bz" placeholder="选填" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">卡密内容</label>
        <div class="layui-input-block">
            <textarea type="text" id="carddata" name="carddata" autocomplete="off" class="layui-textarea" style="height:200px;"></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-back-submit">提交</button>
    </div>
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
    
    var load = layer.load();
    $.ajax({
        url: '../interface/ajax.php?t=agent&a=get-applist',
        type: 'POST',
        dataType: 'html',
        data: '',
        success: function (data) {
            layer.close(load);
            $('#applist').html(data);
            form.render('select');
        },
        error: function (data) {
            layer.close(load);
            layer.msg('请求失败' + data);
        }
    });

      form.on('select(applist)', function(data){
          var load = layer.load();
          $.ajax({
              url: '../interface/ajax.php?t=agent&a=get-cardtype&id='+data.value,
              type: 'POST',
              dataType: 'html',
              data: '',
              success: function (res) {
                  layer.close(load);
                  $('#cardtype').html(res);
                  form.render('select');
              },
              error: function (res) {
                  layer.close(load);
                  layer.msg('请求失败' + res);
              }
          });
          return false;
      });
      form.on('select(cardtype)', function(data){
          var load = layer.load();
          $.ajax({
              url: '../interface/ajax.php?t=agent&a=get-cardtypeinfo&id='+data.value,
              type: 'POST',
              dataType: 'html',
              data: '',
              success: function (res) {
                  layer.close(load);
                  $('#cardtypeinfo').html(res);
                  form.render('select');
              },
              error: function (res) {
                  layer.close(load);
                  layer.msg('请求失败' + res);
              }
          });
          return false;
      });

    });
  </script>
</body>
</html>
