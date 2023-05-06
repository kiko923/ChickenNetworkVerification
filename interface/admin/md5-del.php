<?php
/**
 * 接口：删除MD5
 * 时间：2022-07-28 10:44
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //MD5id
    $res = DB::table('md5')->where(['id'=>$id])->del();
    if(!$res){
        json(201,'删除版本MD5失败');
    }
    json(200,'删除版本MD5成功');
?>