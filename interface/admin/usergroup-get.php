<?php
/**
 * 接口：读取用户组
 * 时间：2022-09-23 15:06
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //用户组id
if(!$id){ //如果用户组id是空
    json(201,'读取失败，该用户组不存在');
}
$res = DB::table('usergroup')->where(['id'=>$id])->find();
if(!$res){
    json(201,'读取失败，该用户组不存在');
}
json(200,$res);
?>