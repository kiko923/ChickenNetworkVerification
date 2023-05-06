<?php
/**
 * 接口：删除在线
 * 时间：2022-07-20 09:08
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //在线id
$res = DB::query('delete a from ty_heartbeat as a left join ty_user as b on a.uid=b.id where a.id='.$id.' and b.aid='.$userinfo['id']);
if(!$res){
    json(201,'删除在线用户失败');
}
json(200,'删除在线用户成功');
?>