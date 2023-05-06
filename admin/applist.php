<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>软件列表</title>
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
      <a><cite>软件列表</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">软件列表</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
            
            <script type="text/html" id="test-table-toolbar-toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="add"><i class="layui-icon layui-icon-add-circle"></i>添加</button>
                <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</button>
              </div>
            </script>
             
            <script type="text/html" id="test-table-toolbar-barDemo">
              <a class="layui-btn layui-btn-xs layui-bg-blue" lay-event="edit">配置</a>
              <a class="layui-btn layui-btn-xs" lay-event="more">更多 <i class="layui-icon layui-icon-down"></i></a>
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
  }).use(['index', 'table','dropdown'], function(){
    var admin = layui.admin
    ,table = layui.table
    ,dropdown = layui.dropdown;

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
      ,url: '../interface/ajax.php?t=admin&a=app-json'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,id: 'LAY-table-manage'
      ,title: '软件数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left'}
        ,{field:'id', title:'ID', width:60, unresize: true, align:'center'}
        ,{field:'name', title:'软件名称', width:160}
        ,{field:'tj_sl', title:'用户统计', width:100, align:'center'}
        ,{field:'orcheck', title:'服务状态', width:125, align:'center'}
        ,{field:'logintype', title:'登录方式', width:100, align:'center'}
        ,{field:'mi_type', title:'加密协议', width:100, align:'center'}
        ,{field:'xttime', title:'心跳时间', width:100, align:'center'}
        ,{field:'bd_type', title:'绑定方式', width:100, align:'center'}
        ,{field:'mi_sign', title:'校验签名', width:100, align:'center'}
        ,{field:'md5_check', title:'校验MD5', width:100, align:'center'}
        ,{field:'appkey', title:'软件密钥', minWidth:200}
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
    		  title:'添加软件'
              ,type: 2
              ,offset: 'rb'
              ,anim: 2
              ,content: 'appinfo.php'
              ,shadeClose: true
              ,area: admin.screen() < 2 ? ['100%', '100%'] : ['50%', '100%']
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
                        url:'../interface/ajax.php?t=admin&a=app-set',
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
            layer.confirm('确认删除选中软件吗？<br><span style="font-size:10px;color:red;">删除软件将会同时清理其他关联数据，包括不限于(充值卡类、充值卡密、授权用户、代理权限等)</span>',{title:'二次确认'}, function(index){
              $.ajax({
                  type:'POST',
                  url:'../interface/ajax.php?t=admin&a=app-delor',
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
      datax = obj.data;
      if(obj.event === 'more'){
        dropdown.render({
          elem: this
          ,show: true //外部事件触发即显示
          ,data: [{
                title: '冻结软件'
                ,templet: '<i class="layui-icon layui-icon-password layui-font-12"></i> {{d.title}}'
                ,id: 'djrj1'
                ,href: '#'
            },{
                title: '解冻软件'
                ,templet: '<i class="layui-icon layui-icon-password layui-font-12"></i> {{d.title}}'
                ,id: 'djrj2'
                ,href: '#'
            }, {
                title: '版本管理'
                ,templet: '<i class="layui-icon layui-icon-upload-drag layui-font-12"></i> {{d.title}}'
                ,id: 'ver'
                ,href: '#'
            },{
                title: '摘要管理'
                ,templet: '<i class="layui-icon layui-icon-rate layui-font-12"></i> {{d.title}}'
                ,id: 'md5'
                ,href: '#'
            }, {
                title: '删除软件'
                ,templet: '<i class="layui-icon layui-icon-delete layui-font-12"></i> {{d.title}}'
                ,id: 'del'
                ,href: '#'
          }]
          ,click: function(data, othis){
            //根据 id 做出不同操作
            if(data.id === 'ver'){
              layer.open({
                type: 2
                ,title: '版本管理器'
                ,content: 'verlist.php?id='+datax.id
                ,shadeClose: true
                ,area: admin.screen() < 2 ? ['100%', '100%'] : ['80%', '80%']
                ,maxmin: true
              });
            } else if(data.id ==='djrj1'){
                $.ajax({
                    type:'POST',
                    url:'../interface/ajax.php?t=admin&a=app-dj&type=1&id='+datax.id,
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
            } else if(data.id ==='djrj2'){
                $.ajax({
                    type:'POST',
                    url:'../interface/ajax.php?t=admin&a=app-dj&type=0&id='+datax.id,
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
            } else if(data.id ==='md5'){
              layer.open({
                type: 2
                ,title: 'MD5管理器'
                ,content: 'md5list.php?id='+datax.id
                ,shadeClose: true
                ,area: admin.screen() < 2 ? ['100%', '100%'] : ['80%', '80%']
                ,maxmin: true
              });
            } else if(data.id ==='del'){
              layer.confirm('确认删除软件['+datax.name+']吗？<br><span style="font-size:10px;color:red;">删除软件将会同时清理其他关联数据，包括不限于(充值卡类、充值卡密、授权用户、代理权限等)</span>',{title:'二次确认'}, function(index){
                $.ajax({
                  type:'POST',
                  url:'../interface/ajax.php?t=admin&a=app-del&id='+datax.id,
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
          }
          ,style: 'margin-left: -45px; box-shadow: 1px 1px 10px rgb(0 0 0 / 12%);' //设置额外样式
        });
      }else if(obj.event === 'edit'){
        layer.open({
		  title:'修改软件[id:'+datax.id+']'
          ,offset: 'rb'
          ,anim: 2
          ,type: 2
          ,content: 'appinfo.php?id='+datax.id
          ,shadeClose: true
          ,area: admin.screen() < 2 ? ['100%', '100%'] : ['50%', '100%']
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
                    url:'../interface/ajax.php?t=admin&a=app-set&id='+datax.id,
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