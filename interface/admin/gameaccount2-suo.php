<?php
/**
 * 接口：锁定/解锁账号
 * 时间：2023-02-14 15:32
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //索引id
$type = isset($_GET['type']) ? purge($_GET['type']) : ''; //0解锁 1锁定
if($type==0){
    DB::table('gameaccount2')->where(['id'=>$id])->update(['zt'=>0]);
    json(200,'解锁成功');
}else{
    DB::table('gameaccount2')->where(['id'=>$id])->update(['zt'=>2]);
    json(200,'锁定成功');
}
?>