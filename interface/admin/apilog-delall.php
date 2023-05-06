<?php
/**
 * 接口：清空记录
 * 时间：2022-09-22 15:30
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$res = DB::table('apilog')->del();
if(!$res){
    json(201,'清空记录失败');
}
json(200,'清空记录成功');
?>