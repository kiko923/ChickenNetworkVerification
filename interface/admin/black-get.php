<?php
/**
 * 接口：读取黑名单
 * 时间：2022-10-09 09:55
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //索引id
if(!$id){ //如果索引id是空
    json(201,'读取失败，该黑名单不存在');
}
$res = DB::table('black')->where(['id'=>$id])->find();
if(!$res){
    json(201,'读取失败，该黑名单不存在');
}
json(200,$res);
?>