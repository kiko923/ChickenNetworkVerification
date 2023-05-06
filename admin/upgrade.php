<html lang="zh-CN">
<head>
  <meta charSet="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel='stylesheet' id='_bootstrap-css' href='../assets/css/bootstrap.min.css?ver=6.7' type='text/css'/>
  <link rel='stylesheet' id='_main-css' href='../assets/css/main.min.css?ver=6.7' type='text/css'/>
  <link rel='stylesheet' id='_fontawesome-css' href='../assets/css/font-awesome.min.css?ver=6.7' type='text/css'/>
</head>
<body class="bg-light">
<div class="row" style="margin:15px">
  <div class="col-md-7">
    <div class="zib-widget pay-box">
      <div class="pay-tag abs-center"
           style="left: auto;right: 0;border-radius: 0 var(--main-radius) 0 var(--main-radius);">在线更新
      </div>
      <div class="but-download">
                <span id="btup"><a class="but c-blue mr10" onClick="UpdateVer();"><i aria-hidden="true" class="fa fa-cloud-upload"></i>检测更新</a></span>
        <span class="badg" id="ver">loading...</span>
      </div>
      <div class="theme-box"></div>
      <span id="upinfo">
        <div class="pay-extra-hide"><div class="mt10 mr20"><div class="ml20">
          <li class="c-yellow-2 mb6">请严格遵守授权本人使用规定，违规使用将做冻结处理并不予解冻</li>
          <li class="c-yellow">更新程序推荐使用一键在线更新，在线更新失败时请在群内下载更新包手动更新</li>
        </div></div></div>
    </span>
    </div>
  </div>
  <div class="col-md-3">
    <div class="zib-widget pay-box">
      <div class="pay-tag abs-center"
           style="left: auto;right: 0;border-radius: 0 var(--main-radius) 0 var(--main-radius);">扫码入群
      </div>
      <div class="theme-box">
        <div>
          <div class="text-center mt20 flex0">
            <div class="c-yellow "><img src="../assets/images/jq.png" style="width: 100px">
            </div>
            <div class="mt10">扫码加入正版用户群
              <div class=""><a class="c-yellow" target="_blank"
                                   href="https://jq.qq.com/?_wv=1027&k=0tfnSXFn">QQ群号：852644223</a>
              </div>
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
  }).use(['index', 'console'], function () {
    var admin = layui.admin;

    $.ajax({
      url: '../interface/ajax.php?t=admin&a=login-ck',
      type: 'POST',
      dataType: 'json',
      data: '',
      success: function (res) {
        if (res.code == '201') {
          top.location.href = "login.php";
        }
      }
    });

    $.ajax({
      url: '../interface/ajax.php?t=admin&a=get-info',
      type: 'POST',
      dataType: 'json',
      data: '',
      success: function (res) {
        if (res.code == '200') {
          $('#ver').html(res.ver);
        } else {
          top.location.href = "login.php";
        }
      }
    });

  });

  function UpdateVer() {
    $.ajax({
      url: '../interface/ajax.php?t=admin&a=newver',
      type: 'POST',
      dataType: 'json',
      data: '',
      success: function (res) {
        if (res.code == 200) {
          $('#btup').html('<a class="but jb-red mr10" onClick="yupver();"><i aria-hidden="true" class="fa fa-download"></i>确认更新</a>');
          $('#upinfo').html('<div class="pay-extra-hide"><div class="mt10 mr20"><div class="ml20"><span class="c-blue-2 mb6">' + res.msg.replace(/\n/g, "<br>") + '</span></div></div></div>');
        } else {
          $('#upinfo').html('<div class="pay-extra-hide"><div class="mt10 mr20"><div class="ml20"><span class="c-blue-2 mb6">' + res.msg+ '</span></div></div></div>');
        }
      }
    });
  }

  function yupver() {
    var load = layer.load();
    $.ajax({
      type: 'POST',
      url: '../interface/ajax.php?t=admin&a=upgrade',
      dataType: 'json',
      data: '',
      success: function (data) {
        layer.close(load);
        if (data.code == 200) {
          layer.alert(data.msg, {icon: 1});
        } else {
          layer.alert(data.msg, {icon: 2});
        }
      }
    });
  }
</script>
</body>
</html>