<?php
/**
 * 接口：删除用户组
 * 时间：2022-09-23 15:04
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //用户组id
$res = DB::table('usergroup')->where(['id'=>$id])->del();
if(!$res){
    json(201,'删除用户组失败');
}
json(200,'删除用户组成功');
?>