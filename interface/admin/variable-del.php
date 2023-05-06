<?php
/**
 * 接口：删除常量
 * 时间：2022-07-19 10:00
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //变量id
    $res = DB::table('variable')->where(['id'=>$id])->del();
    if(!$res){
        json(201,'删除常量失败');
    }
    json(200,'删除常量成功');
?>