<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>云端计算</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../assets/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="../assets/codemirror/theme/darcula.css">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">云端计算(无需登录)</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form layui-form-pane" action="" lay-filter="layuiadmin-form-admin">
                <div class="layui-form-item">
                    <blockquote class="layui-elem-quote">此处写的函数为 [<b><span style="color:blue">无需登录</span></b>] 即可调用使用的动态函数。</blockquote>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">自定义函数(PHP语法)</label>
                    <div class="layui-input-block">
                        <textarea type="text" name="code" id="code"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-sm" type="button" lay-submit lay-filter="submitA">保存修改</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="../assets/codemirror/lib/codemirror.js"></script>
<script src="../assets/codemirror/addon/edit/matchbrackets.js"></script>
<script src="../assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="../assets/codemirror/mode/xml/xml.js"></script>
<script src="../assets/codemirror/mode/javascript/javascript.js"></script>
<script src="../assets/codemirror/mode/css/css.js"></script>
<script src="../assets/codemirror/mode/clike/clike.js"></script>
<script src="../assets/codemirror/mode/php/php.js"></script>
<script src="../layuiadmin/layui/layui.js"></script>
<script src="../layuiadmin/layui/jquery.min.js"></script>
<script>
    layui.config({
        base: '../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table','form'], function(){
        var admin = layui.admin
            ,form = layui.form
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

        var textarea = document.getElementById('code');
        var editor = CodeMirror.fromTextArea(textarea, {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true
        });
        editor.setOption("theme", "darcula");

        $.ajax({
            url: '../interface/ajax.php?t=admin&a=get-func&type=1',
            type: 'GET',
            dataType: 'text',
            async: false,
            success: function (data) {
                editor.setValue(data);
            }
        });

        form.on('submit(submitA)', function(data){
            var txt = editor.getValue();
            $.ajax({
                url: '../interface/ajax.php?t=admin&a=set-func&type=1',
                type: 'POST',
                dataType: 'json',
                data: txt,
                success: function (res) {
                    if(res.code == 201){
                        layer.alert(res.msg,{icon:0});
                    }else{
                        layer.alert(res.msg,{icon:1})
                    }

                }
            });
        });

    });

</script>
</body>
</html>
