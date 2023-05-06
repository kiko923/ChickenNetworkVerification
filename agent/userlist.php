<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>用户列表</title>
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
      <a><cite>用户列表</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">用户列表</div>
          <div class="layui-card-body">

            <form class="layui-form layui-form-pane" lay-filter="layuiadmin-form-admin">
              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">软件名称</label>
                  <div class="layui-input-block">
                    <select id="applist" name="s_appid" lay-search lay-filter="applist"></select>
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">搜索类型</label>
                  <div class="layui-input-block">
                    <select name="s_type">
                      <option value=""></option>
                      <option value="user">用户账户</option>
                      <option value="userqq">凭证QQ号</option>
                      <option value="email">绑定邮箱</option>
                      <option value="ver">软件版本</option>
                      <option value="mac">[绑定] 设备码</option>
                      <option value="ip">[绑定] 设备IP</option>
                      <option value="rgmac">[注册] 设备码</option>
                      <option value="rgip">[注册] 设备IP</option>
                    </select>
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">搜索目标</label>
                  <div class="layui-input-block">
                    <input class="layui-input" name="s_infos" autocomplete="off">
                  </div>
                </div>
                <div class="layui-inline">
                  <a class="layui-btn layui-btn-normal" lay-filter="submitA" lay-submit title="搜索">
                    <i class="layui-icon layui-icon-search"></i></a>
                </div>
              </div>
            </form>

            <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
            
            <script type="text/html" id="test-table-toolbar-toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="add"><i class="layui-icon layui-icon-add-circle"></i>添加用户</button>
                </div>
            </script>
             
            <script type="text/html" id="test-table-toolbar-barDemo">
              <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            </script>
          </div>
        </div>
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
  }).use(['index', 'table', 'form'], function(){
    var admin = layui.admin
    ,form = layui.form
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

    form.on('submit(submitA)', function(data){
      //执行重载
      table.reload('LAY-table-manage', {
        page: {
          curr: 1 //重新从第 1 页开始
        }
        ,where: {
          type: data.field.s_type,
          infos: data.field.s_infos,
          appid: data.field.s_appid
        }
      });
      return false;
    });
  
    table.render({
      elem: '#test-table-toolbar'
      ,url: '../interface/ajax.php?t=agent&a=user-json'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,id: 'LAY-table-manage'
      ,title: '用户数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left'}
        ,{field:'id', title:'ID', width:70, unresize: true, align:'center'}
        ,{field:'user', title:'账户', width:180}
        ,{field:'zt', title:'状态', width:70, align:'center'}
        ,{field:'type', title:'类型', width:70, align:'center'}
        ,{field:'appname', title:'所属软件', width:150}
        ,{field:'gname', title:'用户组', width:120, align:'center'}
        ,{field:'endtime', title:'过期时间', width:180}
        ,{field:'point', title:'点数', width:80, align:'center'}
        ,{field:'ver', title:'版本', width:80, align:'center'}
        ,{field:'mac', title:'设备码 <span style="color:salmon;font-size:12px;">[绑定]</span>', width:120, align:'center'}
        ,{field:'ip', title:'设备IP <span style="color:salmon;font-size:12px;">[绑定]</span>', width:130, align:'center'}
        ,{field:'rgmac', title:'设备码 <span style="color:#A901DB;font-size:12px;">[注册]</span>', width:120, align:'center'}
        ,{field:'rgip', title:'设备IP <span style="color:#A901DB;font-size:12px;">[注册]</span>', width:130, align:'center'}
        ,{field:'userqq', title:'凭证QQ', width:120, align:'center'}
        ,{field:'email', title:'邮箱', width:180}
        ,{field:'logintime', title:'登录时间', width:180}
        ,{field:'addtime', title:'添加时间', width:180}
        ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:70}
      ]]
      ,page: true
      ,response: {
        statusCode: 200 //重新规定成功的状态码为 200，table 组件默认为 0
      }
    });
    
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      let money = 0;
      switch(obj.event){
        case 'add':
            layer.open({
    		  title:'添加用户'
              ,type: 2
              ,content: 'adduser.php'
              ,shadeClose: true
              ,area: admin.screen() < 2 ? ['100%', '100%'] : ['695px', '80%']
    		  ,btn: ['确定', '取消']
              ,maxmin: true
              ,yes: function(index, layero){
                var iframeWindow = window['layui-layer-iframe'+ index]
                ,submitID = 'LAY-user-back-submit'
                ,submit = layero.find('iframe').contents().find('#'+ submitID);
                iframeWindow.layui.form.on('submit(LAY-user-front-submit)', function(datas){
                  var field = datas.field;
                    $.ajax({
                        type:'POST',
                        url:'../interface/ajax.php?t=agent&a=user-set',
                        dataType: 'json',
                        data: field,
                        cache: false,
                        success: function (data) {
                          console.log(data);
                            if(data.code==200){
                                table.reload('LAY-table-manage');
                                layer.alert(data.msg, {icon: 1});
                            }else{
                                layer.alert(data.msg, {icon: 0});
                            }
                        }
                    });
                  //layer.close(index); //关闭弹层
                });  
                submit.trigger('click');
                }
		  });
        break;
      };
    });

    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'edit'){
        layer.open({
		  title:'修改用户[id:'+data.id+']'
          ,type: 2
          ,content: 'userinfo.php?id='+data.id
          ,shadeClose: true
          ,area: admin.screen() < 2 ? ['100%', '100%'] : ['695px', '80%']
		  ,btn: ['确定', '取消']
          ,maxmin: true
          ,yes: function(index, layero){
            var iframeWindow = window['layui-layer-iframe'+ index]
            ,submitID = 'LAY-user-back-submit'
            ,submit = layero.find('iframe').contents().find('#'+ submitID);
            iframeWindow.layui.form.on('submit(LAY-user-front-submit)', function(datas){
              var field = datas.field;
                $.ajax({
                    type:'POST',
                    url:'../interface/ajax.php?t=agent&a=user-set&id='+data.id,
                    dataType: 'json',
                    data: field,
                    cache: false,
                    success: function (data) {
                        if(data.code==200){
                            table.reload('LAY-table-manage');
                            layer.alert(data.msg, {icon: 1});
                        }else{
                            layer.alert(data.msg, {icon: 0});
                        }
                    }
                });
              //layer.close(index); //关闭弹层
            });  
            submit.trigger('click');
            }
		  });
      }
    });
  
  });
  </script>
</body>
</html>