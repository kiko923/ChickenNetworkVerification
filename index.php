<?php
include 'include/core.im.php';
function sysmsg($_arg_0 = "未知的异常", $_arg_1 = true)
{
    echo "  \r\n    <!DOCTYPE html>\r\n    <html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"zh-CN\">\r\n    <head>\r\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n        <title>站点提示信息</title>\r\n        <style type=\"text/css\">\r\nhtml{background:#eee}body{background:#fff;color:#333;font-family:\"微软雅黑\",\"Microsoft YaHei\",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px \"微软雅黑\",\"Microsoft YaHei\",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}\r\n        </style>\r\n    </head>\r\n    <body id=\"error-page\">\r\n        ";
    echo "<h3>站点提示信息</h3>";
    echo $_arg_0;
    echo "    </body>\r\n    </html>\r\n    ";
    return 0;
}
if (!file_exists('install/install.lock') && file_exists(ROOT . 'install/index.php')) {
    sysmsg('<h2>检测到您尚未安装！</h2><ul><li><font size="4">如果您尚未安装本程序，请<a href="./install/">前往安装</a></font></li><li><font size="4">如果您已经安装本程序，请手动删除install目录</li><li><b>为了您站点安全，在您完成它之前我们不会工作</b></font></li></ul><br/>', true);
    exit(0);
}

?>
<!DOCTYPE HTML>
 <html>
 <head>
 <meta charset="utf-8">
  <!--标题-->
 <title>炸鸡网络验证</title>
 <meta name="baidu-site-verification" content="b9lOcChmbf">
 <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
  <!--关键词-->
 <meta name="keywords" content="网络验证,网络验证系统,炸鸡网络验证,炸鸡网络验证系统,软件注册系统.">
 <!--描述-->
 <meta name="description" content="炸鸡网络验证系统是一套专业的软件收费系统,可为软件增加注册授权功能.服务端可架设到支持Php+MySql的主机上,客户端支持VC、VB、DELPHI、易语言、C#、VB.NET、Python、JAVA、TC、安卓、IOS、等所有主流开发语言.">
 <!--浏览器小图标，如有，请上传-->
 <link href="layuiadmin/images/favicon.ico" rel="icon">
 <link rel="stylesheet" href="layuiadmin/css/main.css">
 <link rel="stylesheet" href="layuiadmin/css/noscript.css">
 </head>
 <body>
 <div id="wrapper">
	<header id="header">
	<!--<div class="logo">-->
	  <!--头像地址-->
		<!--<span class="icon fa-users" aria-hidden="true"></span>
	</div>-->
	<div class="content">
		<div class="inner">
          <!--名称-->
			<h1>炸鸡网络验证</h1>
			<p>HTTP协议B/S架构,网页管理,简洁方便</p>
		</div>
	</div>
	<nav>
	<ul>
      <!--菜单-->
		<li><a href="/user/index.html">自助功能</a></li>
        <li><a href="/agent/login.php">代理后台</a></li>
		<li><a href="/admin/login.php">管理后台</a></li>
		<li><a href="#about">验证简介</a></li>
	</ul>
	</nav>
	</header>
	<div id="main">
		<article id="about">
			<h2 class="major">简介</h2>
			<p> 基于Php+MySql数据库架构的网络验证系统，安全稳定、性能强悍、承载能力强，支持高并发、高承载、多线路，支持服务器集群架设,高性能设计，速度非常快，效率非常高。<br>客户端支持VC、VB、DELPHI、易语言、C#、VB.NET、Python、JAVA、TC、安卓、IOS、等所有主流开发语言.</p>
		</article>
	</div>
	<footer id="footer">
		<p class="copyright">&copy; 2022-2023 <span>炸鸡网络验证系统</span></p>
	</footer>
	<div id="cc-myssl-id" style="position: fixed;right: 0;bottom: 0;width: 65px;height: 65px;z-index: 99;"> 
       <img src="layuiadmin/myssl-id.png" alt="安全认证" style="width:100%;height:100%" />
    </div>
</div>
<div id="bg"></div>
<script src="layuiadmin/layui/jquery.min.js"></script>
<script src="layuiadmin/skel.min.js"></script>
<script src="layuiadmin/util.js"></script>
<script src="layuiadmin/main.js"></script>
</body>
</html>
?>