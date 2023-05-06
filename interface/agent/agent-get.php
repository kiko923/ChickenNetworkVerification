<?php
/**
 * 接口：读取人员
 * 时间：2022-09-08 09:22
 */

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$group = DB::table('group')->where(['id'=>$userinfo['gid']])->find();
if(!$group['adds']){
    json(201,'无权限');
}

    $id = isset($_GET['id']) ? purge($_GET['id']) : ''; //人员id
    if(!$id){ //如果人员id是空
        json(201,'读取失败，该子代理不存在');
    }
    $res = DB::table('admin')->where(['id'=>$id,'aid'=>$userinfo['id']])->find();
    if(!$res){
        json(201,'读取失败，该子代理不存在');
    }
    $useri['user'] = $res['user'];
    $useri['zt'] = $res['zt'];
    $useri['gid'] = $res['gid'];
    json(200,$useri);
?>