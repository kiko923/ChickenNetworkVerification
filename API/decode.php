<?php
// 以下为base64解密写法,直接调用$data变量即可,客户端加密传输过来的data数据已处理赋值给$data
// $data 加密的数据
// $app_res 软件配置数组,可调用任何的字段值
// $sign 客户端封包签名摘要
// DB 类,可直接调用操作数据库,如何调用请自行查看其他接口
// $de_data 系统内置调用变量,解密后的数据必须附加给此变量

$de_data = base64_decode($data);//base64解密