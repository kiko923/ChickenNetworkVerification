<?php
/**
 * 接口：清空日志
 * 时间：2022-08-15 15:38
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$res = DB::table('applog')->del();
if(!$res){
    json(201,'清空日志失败');
}
json(200,'清空日志成功');
?>