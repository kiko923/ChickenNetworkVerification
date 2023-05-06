<?php
/**
 * 接口：删除日志
 * 时间：2022-08-09 10:00
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //日志id
$res = DB::table('applog')->where(['id'=>$id])->del();
if(!$res){
    json(201,'删除日志失败');
}
json(200,'删除日志成功');
?>