<?php
/**
 * 接口：读取软件
 * 时间：2022-07-15 14:38
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //软件id
    if(!$id){ //如果软件id是空
        json(201,'读取失败，该软件不存在');
    }
    $res = DB::table('app')->where(['id'=>$id])->find();
    if(!$res){
        json(201,'读取失败，该软件不存在');
    }
    json(200,$res);
?>