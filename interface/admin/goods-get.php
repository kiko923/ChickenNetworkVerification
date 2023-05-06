<?php
/**
 * 接口：读取商品
 * 时间：2023-02-18 12:39
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //商品id
if(!$id){ //如果商品id是空
    json(201,'读取失败，该商品不存在');
}
$res = DB::table('goods')->where(['id'=>$id])->find();
if(!$res){
    json(201,'读取失败，该商品不存在');
}
json(200,$res);
?>