<?php
/**
 * 接口：添加/设置商品
 * 时间：2023-02-18 12:41
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //商品id
$data = $_POST;

if(!$id){ //如果商品id是空 则是新增商品
    $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
    $data['addtime'] = date('Y-m-d H:i:s',time());
    $res = DB::table('goods')->add($data);
    if(!$res){
        json(201,'添加商品失败，请重试。');
    }
    json(200,'添加商品成功。');
}
$res = DB::table('goods')->where(['id'=>$id])->update($data);
if(!$res){
    json(201,'修改商品失败，请重试。');
}
json(200,'修改商品成功。');
?>