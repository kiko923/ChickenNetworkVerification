<?php
/**
 * 接口：添加/设置黑名单
 * 时间：2022-07-14 16:55
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //索引id
$data = $_POST;

if(!$id){ //如果索引id是空 则是新增黑名单
    $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
    $res = DB::table('black')->where(['data'=>$data['data'],'type'=>$data['type'],'appid'=>$data['appid']])->find();
    if($res){
        json(201,'此黑名单已存在，请重新填写');
    }
    unset($res);
    $data['addtime'] = date('Y-m-d H:i:s',time());
    $res = DB::table('black')->add($data);
    if(!$res){
        json(201,'添加黑名单失败，请重试。');
    }
    json(200,'添加黑名单成功。');
}

$res = DB::table('black')->where(['id'=>$id])->update($data);
if(!$res){
    json(201,'修改黑名单失败，请重试');
}
json(200,'修改黑名单成功');
?>