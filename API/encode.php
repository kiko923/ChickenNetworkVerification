<?php
// 返回数据格式：{"data":$data,"sign":$sign);
// 其中$data为可自定义编写的部分
// 以下为base64加密写法,直接调用$data变量即可
// $data 加密的数据
// $mi 软件配置数组,可调用任何的字段值
// DB 类,可直接调用操作数据库,如何调用请自行查看其他接

$data = base64_encode($data);//此处就是一个base64,把数据变量$data给加密了