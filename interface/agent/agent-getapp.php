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
$group = DB::table('group')->where(['id'=>$userinfo['gid']])->find();
if(!$group['adds']){
    json(201,'无权限');
}
$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //人员id
if($userinfo['appsid']){
    $row = DB::query('select * from ty_app where id in ('.$userinfo['appsid'].')');
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
}
die();
?>