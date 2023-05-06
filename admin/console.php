

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>炸鸡网络验证系统</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="../layuiadmin/style/free.css" media="all">
</head>
<body>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8">
            <div class="layui-card">
              <div class="layui-card-header">数据面板</div>
              <div class="layui-card-body">
                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs4">
                        <a class="layadmin-backlog-body">
                          <h3>软件数量</h3>
                          <p id="app"><cite>loading...</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs4">
                        <a class="layadmin-backlog-body">
                          <h3>在线用户</h3>
                          <p id="heartbeat"><cite>loading...</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs4">
                        <a class="layadmin-backlog-body">
                          <h3>用户总数</h3>
                          <p id="user"><cite>loading...</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs4">
                        <a class="layadmin-backlog-body">
                          <h3>代理数量</h3>
                          <p id="agent"><cite>loading...</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs4">
                        <a class="layadmin-backlog-body">
                          <h3>卡密库存</h3>
                          <p id="card"><cite>loading...</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs4">
                        <a class="layadmin-backlog-body">
                          <h3>已售卡密</h3>
                          <p id="cardlog"><cite>loading...</cite></p>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="layui-col-md4">
            <div class="layui-card">
              <div class="layui-card-header">快捷方式</div>
              <div class="layui-card-body">
                
                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs3">
                        <a lay-href="applist.php">
                          <i class="layui-icon layui-icon-app"></i>
                          <cite>软件管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="heartbeat.php">
                          <i class="layui-icon layui-icon-chart"></i>
                          <cite>在线管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="userlist.php">
                          <i class="layui-icon layui-icon-user"></i>
                          <cite>用户管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="cardlist.php">
                          <i class="layui-icon layui-icon-template-1"></i>
                          <cite>卡密管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="variablelist.php">
                          <i class="layui-icon layui-icon-fonts-code"></i>
                          <cite>常量管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="verlist.php">
                          <i class="layui-icon layui-icon-upload-drag"></i>
                          <cite>版本管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="noticelist.php">
                          <i class="layui-icon layui-icon-notice"></i>
                          <cite>公告管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="md5list.php">
                          <i class="layui-icon layui-icon-star"></i>
                          <cite>MD5管理</cite>
                        </a>
                      </li>
                    </ul>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs3">
                        <a lay-href="apilist.php">
                          <i class="layui-icon layui-icon-share"></i>
                          <cite>接口管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="apilog.php">
                          <i class="layui-icon layui-icon-log"></i>
                          <cite>接口日志</cite>
                        </a>
                      </li>
                    </ul>
                    
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="layui-col-md8">
            <div class="layui-card">
              <div class="layui-card-header">系统环境信息</div>
              <div class="layui-card-body">
                <table class="layui-table"  lay-even=""  lay-skin="nob" lay-size="lg">
                  <colgroup><col width="200"><col></colgroup>
                  <thead>
                  <tr>
                    <th>当前服务器时间：</th>
                    <th id="datetime"></th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>服务器时间格式：</td>
                    <td id="dategs"></td>
                  </tr>
                  <tr>
                    <td>当前登录账号：</td>
                    <td id="loginuser"></td>
                  </tr>
                  <tr>
                    <td>本次登录时间：</td>
                    <td id="logintime"></td>
                  </tr>
                  <tr>
                    <td>本次登录的IP：</td>
                    <td id="loginip"></td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
        <div class="layui-col-md4">
        <div class="layui-card">
          <div class="layui-card-header">版本信息</div>
          <div class="layui-card-body layui-text layadmin-version">
            <table class="layui-table">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody>
                <tr>
                  <td>项目名称</td>
                  <td>炸鸡网络验证</td>
                </tr>
                <tr>
                  <td>版本分类</td>
                  <td>PRO</td>
                </tr>
                <tr>
                  <td>当前版本</td>
                  <td id="ver">loading</td>
                </tr>
                <tr>
                    <td>注册编码</td>
                    <td id="cuid">loading</td>
                </tr>
                <tr>
                  <td>交流Q群</td>
                  <td><a href="https://jq.qq.com/?_wv=1027&k=uO3sWWqH" target="_blank"><u>780820650</u></a></td>
                </tr>
                <tr>
                  <td>主要特色</td>
                  <td>零门槛 / 响应式 / 清爽 / 极简</td>
                </tr>
                
              </tbody>
            </table>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
  </div>

  <script src="../layuiadmin/layui/layui.js?t=1"></script>  
  <script src="../layuiadmin/layui/jquery.min.js"></script>
  <script>
  layui.config({
    base: '../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'console'],function(){
      var admin = layui.admin;
    
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
        url: '../interface/ajax.php?t=admin&a=get-info',
        type: 'POST',
        dataType: 'json',
        data: '',
        success: function (res) {
            if(res.code == '200') {
                $('#agent').html('<cite>'+res.agent+'</cite>');
                $('#card').html('<cite>'+res.card+'</cite>');
                $('#cardlog').html('<cite>'+res.cardlog+'</cite>');
                $('#user').html('<cite>'+res.user+'</cite>');
                $('#heartbeat').html('<cite>'+res.heartbeat+'</cite>');
                $('#app').html('<cite>'+res.app+'</cite>');
                $('#ver').html(res.ver);
                $('#cuid').html(res.cuid);
                $('#loginuser').html(res.loginuser);
                $('#logintime').html(res.logintime);
                $('#loginip').html(res.loginip);
                $('#datetime').html(res.datetime);
                $('#dategs').html(res.dategs);
            }else{
                top.location.href="login.php";
            }
        }
    });
    
  });
  </script>
</body>
</html>

