<?php
/**
 * 接口：读取软件日志关联的调用数据
 * 时间：2022-10-11 19:12
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //索引id
if(!$id){ //如果索引id是空
    json(201,'读取失败，该日志不存在');
}
$res = DB::table('applog')->where(['id'=>$id])->find();
if(!$res){
    json(201,'读取失败，该日志不存在');
}
if(!$res['alid']){
    json(201,'该日志不存在关联的调用数据(可能已被清理)');
}
$ress = DB::table('apilog')->where(['id'=>$res['alid']])->find();
json(200,$ress['data']);
?>