<?php
/**
 * 接口：软件授权JSON
 * 时间：2022-09-14 16:52
 */

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //人员id
$row = DB::table('app')->select();
foreach ($row as $value){
    $newinfo = array();
    $newinfo['value'] = $value['id'];
    $newinfo['title'] = $value['name'];

    $jsondata['data'][] = $newinfo;
}

$res = DB::table('admin')->where(['id'=>$id])->find();
if($res['appsid']){
    $data = explode(',', $res['appsid']);
    $jsondata['value'] = $data;
}

die(json_encode($jsondata));
?>