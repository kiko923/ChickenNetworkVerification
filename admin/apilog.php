<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>接口日志列表</title>
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
      <a><cite>接口日志</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">接口日志</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
            
            <script type="text/html" id="test-table-toolbar-toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除选中</button>
                <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="delall"><i class="layui-icon layui-icon-delete"></i>清空记录</button>
              </div>
            </script>
             
            <script type="text/html" id="test-table-toolbar-barDemo">
              <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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
  }).use(['index', 'table'], function(){
    var admin = layui.admin
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
  
    table.render({
      elem: '#test-table-toolbar'
      ,url: '../interface/ajax.php?t=admin&a=apilog-json'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,id: 'LAY-table-manage'
      ,title: '接口日志表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left'}
        ,{field:'id', title:'ID', width:70, unresize: true, align:'center'}
        ,{field:'appname', title:'来源软件', width:160}
        ,{field:'apiname', title:'接口名', width:180}
        ,{field:'type', title:'类型', width:80, align:'center'}
        ,{field:'url', title:'提交地址', minWidth:300}
        ,{field:'data', title:'提交数据', minWidth:200}
        ,{field:'ver', title:'版本', width:80, align:'center'}
        ,{field:'mac', title:'设备码', width:160, align:'center'}
        ,{field:'ip', title:'设备IP', width:160, align:'center'}
        ,{field:'addtime', title:'调用时间', minWidth:160, align:'center'}
        ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:80}
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
            var data = checkStatus.data;
            layer.confirm('确定删除选中接口调用记录？',{title:'二次确认'}, function(index){
            $.ajax({
                type:'POST',
                url:'../interface/ajax.php?t=admin&a=apilog-delor',
                dataType: 'json',
                data: 'data='+JSON.stringify(data),
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
        break;
        case 'delall':
          var data = checkStatus.data;
          layer.confirm('确认清空接口记录吗？',{title:'二次确认'}, function(index){
            $.ajax({
              type:'POST',
              url:'../interface/ajax.php?t=admin&a=apilog-delall',
              dataType: 'json',
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
          break;
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除选中接口调用记录？',{title:'二次确认'}, function(index){
            $.ajax({
                type:'POST',
                url:'../interface/ajax.php?t=admin&a=apilog-del&id='+data.id,
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
      } else if(obj.event === 'ver'){
        layer.open({
          type: 2
          ,title: '版本管理器'
          ,content: 'verlist.php?id='+data.id
          ,shadeClose: true
          ,area: admin.screen() < 2 ? ['100%', '100%'] : ['695px', '500px']
          ,maxmin: true
        });
      } else if(obj.event === 'rsa2'){
        var fjsj = '';
        $.ajax({
          type:'POST',
          url:'../interface/ajax.php?t=admin&a=app-get&id='+data.id,
          dataType: 'json',
          data: '',
          cache: false,
          async: false,
          success: function (data) {
            fjsj = data.msg.mi_rsa_private_key;
          }
        });
        layer.prompt({
          title: 'RSA2私钥',
          formType: 2,
          value: fjsj
        }, function (value, index, elem) {

          layer.close(index);
        });
      } else if(obj.event === 'md5'){
        layer.open({
          type: 2
          ,title: 'MD5管理器'
          ,content: 'md5list.php?id='+data.id
          ,shadeClose: true
          ,area: admin.screen() < 2 ? ['100%', '100%'] : ['695px', '500px']
          ,maxmin: true
        });
      }else if(obj.event === 'edit'){
        layer.open({
		  title:'修改软件[id:'+data.id+']'
          ,type: 2
          ,content: 'appinfo.php?id='+data.id
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
                    url:'../interface/ajax.php?t=admin&a=app-set&id='+data.id,
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