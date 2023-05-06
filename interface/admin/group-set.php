<?php
/**
 * 接口：添加/设置用户组
 * 时间：2022-09-23 15:07
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //用户组id
$data = $_POST;

if(!$id){ //如果用户组id是空 则是新增用户组
    $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
    $data['addtime'] = date('Y-m-d H:i:s',time());
    $res = DB::table('group')->add($data);
    if(!$res){
        json(201,'添加用户组失败，请重试。');
    }
    json(200,'添加用户组成功。');
}
$res = DB::table('group')->where(['id'=>$id])->update($data);
if(!$res){
    json(201,'修改用户组失败，请重试。');
}
json(200,'修改用户组成功。');
?>