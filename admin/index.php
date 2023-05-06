
<html>
<head>
  <meta charset="utf-8">
  <title>炸鸡网络验证系统</title>
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
              <cite>Admin</cite>
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
                <dd data-name="core">
                  <a lay-href="core.php"><i class="layui-icon layui-icon-set"></i>网站配置</a>
                </dd>
                <dd data-name="info">
                  <a lay-href="stmp.php"><i class="layui-icon layui-icon-util"></i>邮箱配置</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="人员" lay-direction="2">
                <i class="layui-icon layui-icon-user"></i>
                <cite>人员管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="sysuser">
                  <a lay-href="sysuser.php"><i class="layui-icon layui-icon-list"></i>人员列表</a>
                </dd>
                <dd data-name="group">
                  <a lay-href="grouplist.php"><i class="layui-icon layui-icon-water"></i>代理组别</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="软件" lay-direction="2">
                <i class="layui-icon layui-icon-component"></i>
                <cite>项目管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="app">
                  <a lay-href="applist.php"><i class="layui-icon layui-icon-app"></i>软件列表</a>
                </dd>
                <dd data-name="ver">
                  <a lay-href="verlist.php"><i class="layui-icon layui-icon-upload-drag"></i>版本列表</a>
                </dd>
                <dd data-name="notice">
                    <a lay-href="noticelist.php"><i class="layui-icon layui-icon-notice"></i>公告列表</a>
                </dd>
                <dd data-name="md5">
                  <a lay-href="md5list.php"><i class="layui-icon layui-icon-star"></i>MD5列表</a>
                </dd>
                <dd data-name="applog">
                  <a lay-href="applog.php"><i class="layui-icon layui-icon-chart-screen"></i>日志记录</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="用户" lay-direction="2">
                <i class="layui-icon layui-icon-auz"></i>
                <cite>用户管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="userlist">
                  <a lay-href="userlist.php"><i class="layui-icon layui-icon-user"></i>普通用户</a>
                </dd>
                <dd data-name="userlist">
                  <a lay-href="ucodelist.php"><i class="layui-icon layui-icon-prev-circle"></i>单码用户</a>
                </dd>
                <dd data-name="heartbeat">
                  <a lay-href="heartbeat.php"><i class="layui-icon layui-icon-chart"></i>在线列表</a>
                </dd>
                <dd data-name="group">
                  <a lay-href="usergroup.php"><i class="layui-icon layui-icon-water"></i>用户组别</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="软件" lay-direction="2">
                <i class="layui-icon layui-icon-template-1"></i>
                <cite>卡密管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="cardtype">
                  <a lay-href="cardtype.php"><i class="layui-icon layui-icon-tabs"></i>卡类列表</a>
                </dd>
                <dd data-name="card">
                  <a lay-href="cardlist.php"><i class="layui-icon layui-icon-layouts"></i>卡密列表</a>
                </dd>
                <dd data-name="cardlog">
                  <a lay-href="cardlog.php"><i class="layui-icon layui-icon-log"></i>充值记录</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="接口" lay-direction="2">
                <i class="layui-icon layui-icon-share"></i>
                <cite>接口管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="api">
                  <a lay-href="apilist.php"><i class="layui-icon layui-icon-link"></i>接口列表</a>
                </dd>
                <dd data-name="apilog">
                  <a lay-href="apilog.php"><i class="layui-icon layui-icon-log"></i>接口记录</a>
                </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="接口" lay-direction="2">
                <i class="layui-icon layui-icon-senior"></i>
                <cite>高级功能</cite>
              </a>
              <dl class="layui-nav-child">
                  <dd data-name="variable">
                      <a lay-href="variablelist.php"><i class="layui-icon layui-icon-key"></i>常量列表</a>
                  </dd>
                  <dd data-name="variable">
                      <a lay-href="variablelist1.php"><i class="layui-icon layui-icon-slider"></i>变量列表</a>
                  </dd>
                  <dd data-name="api1">
                      <a lay-href="func.php"><i class="layui-icon layui-icon-fonts-code"></i>云计算_1</a>
                  </dd>
                  <dd data-name="api2">
                      <a lay-href="func2.php"><i class="layui-icon layui-icon-fonts-code"></i>云计算_2</a>
                  </dd>
                  <dd data-name="relay">
                      <a lay-href="relay.php"><i class="layui-icon layui-icon-chart-screen"></i>数据转发</a>
                  </dd>
                  <dd data-name="codes">
                      <a lay-href="codes.php"><i class="layui-icon layui-icon-code-circle"></i>自定义加解密</a>
                  </dd>
              </dl>
            </li>
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="防火墙" lay-direction="2">
                <i class="layui-icon layui-icon-util"></i>
                <cite>安全设置</cite>
              </a>
              <!--<dl class="layui-nav-child">
                <dd data-name="api">
                  <a lay-href="firewall.php"><i class="layui-icon layui-icon-engine"></i>防火墙</a>
                </dd>
              </dl>-->
              <dl class="layui-nav-child">
                <dd data-name="api">
                  <a lay-href="blacklist.php"><i class="layui-icon layui-icon-link"></i>黑名单表</a>
                </dd>
              </dl>
            </li>
              <li data-name="component" class="layui-nav-item">
                  <a href="javascript:;" lay-tips="拓展功能" lay-direction="2">
                      <i class="layui-icon layui-icon-transfer"></i>
                      <cite>拓展功能</cite>
                  </a>
                  <dl class="layui-nav-child">
                      <dd data-name="gameaccount">
                          <a lay-href="gameaccount.php"><i class="layui-icon layui-icon-group"></i>游戏账号[1]</a>
                      </dd>
                  </dl>
                  <dl class="layui-nav-child">
                      <dd data-name="gameaccount2">
                          <a lay-href="gameaccount2.php"><i class="layui-icon layui-icon-group"></i>游戏账号[2]</a>
                      </dd>
                  </dl>
              </li>
            <li data-name="component" class="layui-nav-item">
                  <a href="javascript:;" lay-tips="店铺" lay-direction="2">
                      <i class="layui-icon layui-icon-cart"></i>
                      <cite>店铺管理</cite>
                  </a>
                  <dl class="layui-nav-child">
                      <dd data-name="api">
                          <a lay-href="goodlist.php"><i class="layui-icon layui-icon-layouts"></i>商品列表</a>
                      </dd>
                      <dd data-name="api">
                          <a lay-href="orderlist.php"><i class="layui-icon layui-icon-form"></i>订单列表</a>
                      </dd>
                      <dd data-name="pay">
                          <a lay-href="pay.php"><i class="layui-icon layui-icon-rmb"></i>支付配置</a>
                      </dd>
                  </dl>
              </li>
            <li data-name="get" class="layui-nav-item">
              <a href="javascript:;" lay-href="upgrade.php" lay-tips="检测更新" lay-direction="2">
                <i class="layui-icon layui-icon-upload-circle"></i>
                <cite>检测更新</cite>
              </a>
            </li>
            <li data-name="get" class="layui-nav-item">
              <a href="javascript:;" lay-href="https://www.apifox.cn/apidoc/shared-9e3a3688-e4b9-436c-b822-bed41ac1e1e2" lay-tips="文档" lay-direction="2">
                <i class="layui-icon layui-icon-read"></i>
                <cite>开发文档</cite>
              </a>
            </li>
            <li data-name="get" class="layui-nav-item">
              <a href="javascript:;" layadmin-event="about" lay-tips="授权" lay-direction="2">
                <i class="layui-icon layui-icon-about"></i>
                <cite>关于</cite>
              </a>
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

    $.ajax({
      url: '../interface/admin/timer.php',
      type: 'GET'
    });
    
    setInterval(function(){
        $.ajax({
            url: '../interface/admin/timer.php',
            type: 'GET'
        });
    },60000);
    
    $('#logout').click(function() {
	    $.ajax({
        url: '../interface/ajax.php?t=admin&a=login-ot',
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


