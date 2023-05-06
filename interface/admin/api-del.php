<?php
/**
 * 接口：删除接口
 * 时间：2022-08-22 08:45
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //接口id
    $res = DB::table('api')->where(['id'=>$id])->del();
    if(!$res){
        json(201,'删除接口失败');
    }
    json(200,'删除接口成功');
?>