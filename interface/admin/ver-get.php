<?php
/**
 * 接口：读取版本
 * 时间：2022-07-19 11:05
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //版本id
    if(!$id){ //如果版本id是空
        json(201,'读取失败，该版本不存在');
    }
    $res = DB::table('ver')->where(['id'=>$id])->find();
    if(!$res){
        json(201,'读取失败，该版本不存在');
    }
    if($res['update_text']){
        $res['update_text'] = base64_decode($res['update_text']);
    }
    json(200,$res);
?>