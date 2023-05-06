<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>自定义加解密</title>
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
        <div class="layui-card-header">自定义算法(PHP语法)</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form layui-form-pane" action="" lay-filter="layuiadmin-form-admin">
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i> <b><span style="color:darkmagenta">加密算法</span></b> <服务端返回给客户端的数据加密></label>
                    <div class="layui-input-block">
                        <textarea type="text" name="encode" id="encode"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-sm" type="button" lay-submit lay-filter="submitA">保存加密算法</button>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i> <b><span style="color:green">解密算法</span></b> <客户端发送给服务端的数据解密></label>
                    <div class="layui-input-block">
                        <textarea type="text" name="decode" id="decode"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-sm" type="button" lay-submit lay-filter="submitB">保存解密算法</button>
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

        var textarea = document.getElementById('decode');
        var textarea1 = document.getElementById('encode');
        var editor = CodeMirror.fromTextArea(textarea, {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true
        });
        var editor1 = CodeMirror.fromTextArea(textarea1, {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true
        });
        editor.setOption("theme", "darcula");
        editor1.setOption("theme", "darcula");

        $.ajax({
            url: '../interface/ajax.php?t=admin&a=get-codes',
            type: 'GET',
            dataType: 'text',
            async: false,
            success: function (data) {
                editor.setValue(data);
            }
        });
        $.ajax({
            url: '../interface/ajax.php?t=admin&a=get-codes&type=1',
            type: 'GET',
            dataType: 'text',
            async: false,
            success: function (data) {
                editor1.setValue(data);
            }
        });

        form.on('submit(submitA)', function(data){
            var txt = editor1.getValue();
            $.ajax({
                url: '../interface/ajax.php?t=admin&a=set-codes&type=1',
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

        form.on('submit(submitB)', function(data){
            var txt = editor.getValue();
            $.ajax({
                url: '../interface/ajax.php?t=admin&a=set-codes',
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
