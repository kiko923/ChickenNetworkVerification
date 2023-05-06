<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>公告列表</title>
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
      <a><cite>公告列表</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">公告列表</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
            
            <script type="text/html" id="test-table-toolbar-toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="add"><i class="layui-icon layui-icon-add-circle"></i>添加</button>
                <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</button>
              </div>
            </script>
             
            <script type="text/html" id="test-table-toolbar-barDemo">
              <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
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
      ,url: '../interface/ajax.php?t=admin&a=notice-json'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,id: 'LAY-table-manage'
      ,title: '软件数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left'}
        ,{field:'id', title:'ID', width:70, unresize: true, align:'center'}
        ,{field:'appname', title:'所属软件', width:160}
        ,{field:'notice_title', title:'公告标题', width:200}
        ,{field:'notice_info', title:'公告内容', minWidth:350}
        ,{field:'addtime', title:'添加时间', width:180, align:'center'}
        ,{fixed: admin.screen() < 1 ? '' : 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
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
        case 'add':
            layer.open({
    		  title:'添加公告'
              ,type: 2
              ,content: 'noticeinfo.php'
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
                        url:'../interface/ajax.php?t=admin&a=notice-set',
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
        break;
        case 'del':
            var data = checkStatus.data;
            layer.confirm('确认删除选中公告吗？',{title:'二次确认'}, function(index){
            $.ajax({
                type:'POST',
                url:'../interface/ajax.php?t=admin&a=notice-delor',
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
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确认删除公告['+data.notice_title+']吗？',{title:'二次确认'}, function(index){
            $.ajax({
                type:'POST',
                url:'../interface/ajax.php?t=admin&a=notice-del&id='+data.id,
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
      } else if(obj.event === 'edit'){
        layer.open({
		  title:'修改公告[id:'+data.id+']'
          ,type: 2
          ,content: 'noticeinfo.php?id='+data.id
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
                    url:'../interface/ajax.php?t=admin&a=notice-set&id='+data.id,
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