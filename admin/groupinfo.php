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
    <label class="layui-form-label">制卡折扣</label>
    <div class="layui-input-block">
      <input type="text" name="level" placeholder="选填" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">返利比例</label>
    <div class="layui-input-block">
      <input type="text" name="rebate" placeholder="选填,产生制卡消费时返利给上级的比例,百分比模式" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">开通价格</label>
    <div class="layui-input-block">
      <input type="text" name="ktjg" placeholder="选填,留空免费,开通下级代理或自助开通时,选择此用户组需要的费用" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">开通折扣</label>
    <div class="layui-input-block">
      <input type="text" name="ktzk" placeholder="选填,留空无折扣,开通下级代理时,优惠的折扣" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">添加下级</label>
    <div class="layui-input-block">
      <select name="adds">
        <option value=""></option>
        <option value="0">禁止</option>
        <option value="1">允许</option>
      </select>
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

    var idd = GetQueryString("id");
    if (idd != null) {
      $.ajax({
        type:'GET',
        url:'../interface/ajax.php?t=admin&a=group-get&id=' + idd,
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
