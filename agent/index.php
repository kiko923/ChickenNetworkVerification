
<html>
<head>
  <meta charset="utf-8">
  <title>代理中心 | 炸鸡网络验证系统</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link href="../layuiadmin/images/favicon.ico" rel="icon">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="../layuiadmin/style/free.css" media="all">
</head>
<body class="layui-layout-body">
  
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="http://www.baidu.com/" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="note">
              <i class="layui-icon layui-icon-note"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
              <cite id="agentname">Agent</cite>
            </a>
            <dl class="layui-nav-child">
              <!--<dd><a lay-href="set/user/info.php">基本资料</a></dd>
              <dd><a lay-href="set/user/password.php">修改密码</a></dd>
              <hr>-->
              <dd id="logout" style="text-align: center;"><a>退出</a></dd>
            </dl>
          </li>
          
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="console.php">
            <span>炸鸡网络验证</span>
          </div>
          
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            <li data-name="home" class="layui-nav-item layui-nav-itemed">
              <a href="javascript:;" lay-tips="控制台" lay-direction="2">
                <i class="layui-icon layui-icon-home"></i>
                <cite>控制台</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console" class="layui-this">
                  <a lay-href="console.php"><i class="layui-icon layui-icon-windows"></i>数据面板</a>
                </dd>
                <dd data-name="xfmx">
                  <a lay-href="xfmx.php"><i class="layui-icon layui-icon-windows"></i>消费明细</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item" id="agl" style="display:none;">
              <a href="javascript:;" lay-tips="人员" lay-direction="2">
                <i class="layui-icon layui-icon-user"></i>
                <cite>下级管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="sysuser">
                  <a lay-href="agent.php"><i class="layui-icon layui-icon-list"></i>下级代理</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="软件" lay-direction="2">
                <i class="layui-icon layui-icon-auz"></i>
                <cite>用户管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="userlist">
                  <a lay-href="userlist.php"><i class="layui-icon layui-icon-user"></i>用户列表</a>
                </dd>
                <dd data-name="heartbeat">
                  <a lay-href="heartbeat.php"><i class="layui-icon layui-icon-chart"></i>在线列表</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="软件" lay-direction="2">
                <i class="layui-icon layui-icon-template-1"></i>
                <cite>卡密管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="card">
                  <a lay-href="cardlist.php"><i class="layui-icon layui-icon-layouts"></i>卡密列表</a>
                </dd>
                <dd data-name="cardlog">
                  <a lay-href="cardlog.php"><i class="layui-icon layui-icon-log"></i>充值记录</a>
                </dd>
              </dl>
            </li>
          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="console.php" lay-attr="console.php" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="console.php" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
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

    $.ajax({
      url: '../interface/ajax.php?t=agent&a=login-info',
      type: 'POST',
      dataType: 'json',
      data: '',
      success: function (res) {
        $('#agentname').html(res.user);
        if(res.adds == 1){
          $('#agl').show();
        }
      }
    });
    
    $('#logout').click(function() {
	    $.ajax({
        url: '../interface/ajax.php?t=agent&a=login-ot',
        type: 'GET',
        dataType: 'json',
        success: function (res) {
            top.location.href="login.php";  
        }
    });
	});
    
  });
  </script>
  
</body>
</html>

