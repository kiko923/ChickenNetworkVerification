<?php
/**
 * 接口：读取公告
 * 时间：2022-07-19 10:50
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //公告id
    if(!$id){ //如果公告id是空
        json(201,'读取失败，该公告不存在');
    }
    $res = DB::table('notice')->where(['id'=>$id])->find();
    if(!$res){
        json(201,'读取失败，该公告不存在');
    }
    json(200,$res);
?>