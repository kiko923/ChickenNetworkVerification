<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>充值记录列表</title>
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
      <a><cite>充值记录列表</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">充值记录</div>
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
                      <option value="card">充值卡号</option>
                      <option value="c.user">充值账户</option>
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
                <button class="layui-btn layui-btn-sm" lay-event="show"><i class="layui-icon layui-icon-delete"></i>刷新</button>
              </div>
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
      ,url: '../interface/ajax.php?t=agent&a=cardlog-json'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,id: 'LAY-table-manage'
      ,title: '充值卡数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left'}
        ,{field:'id', title:'ID', width:50, unresize: true, align:'center'}
        ,{field:'name', title:'充值卡名', width:150}
        ,{field:'card', title:'充值卡号', minWidth:240}
        ,{field:'user', title:'充值用户', minWidth:150}
        ,{field:'appname', title:'所属软件', width:160}
        ,{field:'gname', title:'可充用户组', width:120}
        ,{field:'rgtime', title:'充值时间', minWidth:210}
        ,{field:'rgpoint', title:'充值点数', width:100, align:'center'}
        ,{field:'aid', title:'制卡人', width:100, align:'center'}
        ,{field:'addtime', title:'使用时间', minWidth:180, align:'center'}
        ,{field:'bz', title:'备注', minWidth:120}
      ]]
      ,page: true
      ,response: {
        statusCode: 200 //重新规定成功的状态码为 200，table 组件默认为 0
      }
    });
    
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'del':
          table.reload('LAY-table-manage', {
            page: {
              curr: 1 //重新从第 1 页开始
            }
          });
        break;
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确认删除充值记录['+data.card+']吗？', function(index){
            $.ajax({
                type:'POST',
                url:'../interface/ajax.php?t=admin&a=cardlog-del&id='+data.id,
                dataType: 'json',
                data: '',
                cache: false,
                success: function (data) {
                    if(data.code==200){
                        table.reload('LAY-table-manage');
                        layer.alert(data.msg, {icon: 1});
                    }else{
                        layer.alert(data.msg, {icon: 2});                    
                    }
                }
            });
            layer.close(index);
        });
      }
    });
  
  });
  </script>
</body>
</html>