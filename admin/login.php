<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>炸鸡网络验证 - 管理登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- App css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">

                    <!-- Logo -->
                    <!--<div class="card-header pt-4 pb-4 text-center bg-primary">
                        <a href="../index.php">
                            <span><img src="../assets/images/logo.png" alt="" height="18"></span>
                        </a>
                    </div>-->

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold">管理登录</h4>
                            <p class="text-muted mb-4">输入您的账号密码以访问管理面板.</p>
                        </div>
                            <div class="form-group">
                                <label for="emailaddress">登录账号</label>
                                <input class="form-control" type="text" id="account" required="" placeholder="请输入作者账号">
                            </div>

                            <div class="form-group">
                                <a href="pages-recoverpw.php" class="text-muted float-right"><small>忘记密码?</small></a>
                                <label for="password">登录密码</label>
                                <input class="form-control" type="password" required="" id="password" placeholder="请输入作者密码">
                            </div>

                            <div class="form-group">
                                <label>验证码</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="code" placeholder="请输入验证码">
                                    <span id="imgcode"><img src="../include/code.php" class="input-group-append" style="height: 37px"></span>
                                </div>
                            </div>


                        <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                    <label class="custom-control-label" for="checkbox-signin">记住密码</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary" type="submit" id="login"> 登录 </button>
                            </div>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <!-- <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">没有帐户? <a href="pages-register.php" class="text-muted ml-1"><b>点击注册</b></a></p>
                    </div>
                </div> -->
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt">
    2022 © 炸鸡网络验证
</footer>

<!-- App js -->
<script src="../layuiadmin/layui/layui.js"></script>  
<script src="../layuiadmin/layui/jquery.min.js"></script>
<script>
    $("#login").click(function(){
        var loading = layer.load();
        $.ajax({
            url: '../interface/ajax.php?t=admin&a=login',
            type: 'POST',
            dataType: 'json',
            data: {
                user: $("#account").val(),
                pwd: $("#password").val(),
                code: $("#code").val()
            },
            success: function (res) {
                layer.close(loading);
                if(res.code == '200') {
                    layer.msg('登录成功', {
                        icon: 1
                        ,time: 1000
                    }, function(){
                        layer.closeAll();
                        location.href = 'index.php'; //管理员后台主页
                    });
                }else{
                    layer.msg(res.msg);
                    $('#imgcode').trigger('click');
                }
            }
        });
    });

    $("#imgcode").click(function(){
        $('#imgcode').html('<img src="../include/code.php" class="input-group-append" style="height: 37px">');
    });

</script>
</body>
</html>
