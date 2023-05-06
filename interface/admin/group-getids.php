<?php
/**
 * 接口：设置权JSON
 * 时间：2022-10-21 12:58
 */

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //组别id
$row = DB::table('group')->select();
foreach ($row as $value){
    $newinfo = array();
    $newinfo['value'] = $value['id'];
    $newinfo['title'] = $value['name'];

    $jsondata['data'][] = $newinfo;
}

$res = DB::table('group')->where(['id'=>$id])->find();
if($res['groupsid']){
    $data = explode(',', $res['groupsid']);
    $jsondata['value'] = $data;
}

die(json_encode($jsondata));
?>