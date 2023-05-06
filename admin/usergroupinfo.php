<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>用户组信息</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>

<div class="layui-form form-row layui-form-pane" lay-filter="layuiadmin-form-admin" style="padding: 20px 30px 0 20px;">
  <div class="layui-form-item">
    <label class="layui-form-label">组别名称</label>
    <div class="layui-input-block">
      <input type="text" name="name" lay-verify="text" placeholder="必填" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">显示颜色</label>
    <div class="layui-input-block">
      <input type="text" name="color" value="" placeholder="请选择颜色" class="layui-input" id="test-colorpicker-form-input"><div id="test-colorpicker-dome3"></div>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">所属软件</label>
    <div class="layui-input-block">
      <select id="applist" name="appid" lay-search lay-filter="applist"></select>
    </div>
  </div>
  <div class="layui-form-item">
    <blockquote class="layui-elem-quote" style="color:dodgerblue;">可存放一些自定义数据，如何使用自行决定。</blockquote>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">组别数据</label>
    <div class="layui-input-block">
      <textarea type="text" name="data" autocomplete="off" class="layui-textarea" style="height:100px;"></textarea>
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
  }).use(['index', 'form', 'laydate','colorpicker'], function(){
    var admin = layui.admin
            ,element = layui.element
            ,layer = layui.layer
            ,laydate = layui.laydate
            ,colorpicker = layui.colorpicker
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

    var load = layer.load();
    $.ajax({
      url: '../interface/ajax.php?t=admin&a=get-applist',
      type: 'POST',
      dataType: 'html',
      data: '',
      async: false,
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

    var idd = GetQueryString("id");
    if (idd != null) {
      $.ajax({
        type:'GET',
        url:'../interface/ajax.php?t=admin&a=usergroup-get&id=' + idd,
        dataType: 'json',
        cache: false,
        success: function (data) {
          form.val('layuiadmin-form-admin', data.msg);
          form.render();
          colorpicker.render({
            elem: '#test-colorpicker-dome3'
            ,color:data.msg.color
            ,done: function(color){
              $('#test-colorpicker-form-input').val(color);
            }
          });
        }
      });
    }else{
      colorpicker.render({
        elem: '#test-colorpicker-dome3'
        ,color:'#1c97f5'
        ,done: function(color){
          $('#test-colorpicker-form-input').val(color);
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
  };
</script>
</body>
</html>
