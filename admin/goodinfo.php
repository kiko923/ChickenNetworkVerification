<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品信息</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-card-body" style="margin: 5px;">
    <form class="layui-form layui-form-pane" lay-filter="layuiadmin-form-admin">
        <div class="layui-form-item">
            <label class="layui-form-label">商品名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="必填" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">显示颜色</label>
            <div class="layui-input-block">
                <input type="text" name="color" value="" placeholder="请选择颜色" class="layui-input" id="test-colorpicker-form-input"><div id="test-colorpicker-dome3"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">商品状态</label>
            <div class="layui-input-block">
                <select class="form-control" name="zt">
                    <option value=""></option>
                    <option value="0">销售中</option>
                    <option value="1">已停售</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">商品类型</label>
            <div class="layui-input-block">
                <select name="type">
                    <option value=""></option>
                    <option value="0">卡密</option>
                    <option value="1">账户直充</option>
                    <option value="2">代理余额</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">绑定卡类</label>
            <div class="layui-input-block">
                <select id="cardtypelist" name="cid" lay-search lay-filter="cardtypelist"></select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">销售价格</label>
            <div class="layui-input-block">
                <input type="number" name="money" placeholder="可留空" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">限购数量</label>
            <div class="layui-input-block">
                <input type="number" name="quota" placeholder="0为不限制,非0为总限购数量" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户限购</label>
            <div class="layui-input-block">
                <input type="number" name="quota1" placeholder="开启限购后，每台机器或IP可购买次数" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">商品介绍</label>
            <div class="layui-input-block">
                <textarea type="text" name="introduce" autocomplete="off" class="layui-textarea" style="height:100px;"></textarea>
            </div>
        </div>

        <div class="layui-form-item layui-hide" >
            <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-back-submit" value="确认">
        </div>
    </form>
</div>

<script src="../layuiadmin/layui/layui.js"></script>
<script src="../layuiadmin/layui/jquery.min.js"></script>
<script>
    layui.config({
        base: '../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'laydate','colorpicker'], function(){
        var admin = layui.admin
            ,element = layui.element
            ,layer = layui.layer
            ,laydate = layui.laydate
            ,colorpicker = layui.colorpicker
            ,form = layui.form;

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

        laydate.render({
            elem: '#endtime',
            type: 'datetime'
        });

        var load = layer.load();
        $.ajax({
            url: '../interface/ajax.php?t=admin&a=get-cardtypes',
            type: 'POST',
            dataType: 'html',
            data: '',
            success: function (res) {
                layer.close(load);
                $('#cardtypelist').html(res);
                form.render('select');
            },
            error: function (res) {
                layer.close(load);
                layer.msg('请求失败' + res);
            }
        });

        var idd = GetQueryString("id");
        if (idd != null) {
            $.ajax({
                type:'GET',
                url:'../interface/ajax.php?t=admin&a=goods-get&id=' + idd,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    form.val('layuiadmin-form-admin', data.msg);
                    form.render();
                    colorpicker.render({
                        elem: '#test-colorpicker-dome3'
                        ,color:data.msg.color
                        ,done: function(color){
                            $('#test-colorpicker-form-input').val(color);
                        }
                    });
                }
            });
        }else{
            colorpicker.render({
                elem: '#test-colorpicker-dome3'
                ,color:'#1c97f5'
                ,done: function(color){
                    $('#test-colorpicker-form-input').val(color);
                }
            });
        }
    });

    function GetQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return decodeURI(r[2]);
        return null;
    };
</script>
</body>
</html>
