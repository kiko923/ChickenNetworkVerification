<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>用户信息</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
    <div class="layui-card-body" style="margin: 5px;">
        <form class="layui-form layui-form-pane" lay-filter="layuiadmin-form-admin">
            <div class="layui-form-item">
                <label class="layui-form-label">用户账号</label>
                <div class="layui-input-block">
                    <input type="text" name="user" lay-verify="required" placeholder="必填" autocomplete="off" class="layui-input" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">用户密码</label>
                <div class="layui-input-block">
                    <span id="pwd"></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">账户类型</label>
                <div class="layui-input-block">
                    <select name="type" disabled>
                        <option value=""></option>
                        <option value="1">收费</option>
                        <option value="0">免费</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">到期时间</label>
                <div class="layui-input-block">
                    <input type="text" name="endtime" id="endtime" placeholder="请选择到期时间" autocomplete="off" class="layui-input" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">点数余额</label>
                <div class="layui-input-block">
                    <input type="number" name="point" placeholder="可留空" autocomplete="off" class="layui-input" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设备码值</label>
                <div class="layui-input-block">
                    <input type="text" name="mac" placeholder="请输入设备码(可留空)" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设备IP值</label>
                <div class="layui-input-block">
                    <input type="text" name="ip" placeholder="请输入设备IP(可留空)" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">多开数量</label>
                <div class="layui-input-block">
                    <input type="text" name="dk" placeholder="多开数量(可留空)" autocomplete="off" class="layui-input" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">凭证QQ</label>
                <div class="layui-input-block">
                    <input type="text" name="userqq" placeholder="请输入凭证QQ(可留空)" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">所属代理</label>
                <div class="layui-input-block">
                    <input type="text" name="agent" placeholder="请输入代理账号(可留空)" autocomplete="off" class="layui-input" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">绑定邮箱</label>
                <div class="layui-input-block">
                    <input type="text" name="email" placeholder="请输入邮箱号(可留空)" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">所属软件</label>
                <div class="layui-input-block">
                    <select id="applist" name="appid" lay-search lay-filter="applist" disabled></select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">账号状态</label>
                <div class="layui-input-block">
                    <select class="form-control" name="zt">
                        <option value=""></option>
                        <option value="0">封禁</option>
                        <option value="1">正常</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">封禁原因</label>
                <div class="layui-input-block">
                    <input type="text" name="reason" placeholder="封禁原因(可留空)" autocomplete="off" class="layui-input">
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
    
    laydate.render({
        elem: '#endtime',
        type: 'datetime'
    });
    
    var load = layer.load();
    $.ajax({
        url: '../interface/ajax.php?t=agent&a=get-applist',
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
        $('#pwd').html('<input type="text" name="pwd" placeholder="留空不修改密码" autocomplete="off" class="layui-input">');
        $.ajax({
            type:'GET',
            url:'../interface/ajax.php?t=agent&a=user-get&id=' + idd,
            dataType: 'json',
            cache: false,
            success: function (data) {
                form.val('layuiadmin-form-admin', data.msg);
                form.render();
                }
        });
    }else{
        $('#pwd').html('<input type="text" name="pwd" placeholder="留空默认密码123456" autocomplete="off" class="layui-input">');
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
