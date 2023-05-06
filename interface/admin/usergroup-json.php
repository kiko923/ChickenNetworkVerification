<?php
/**
 * 接口：用户组列表JSON
 * 时间：2022-09-23 15:05
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$row = DB::query('select a.*,b.name as appname from `ty_usergroup` as a left join `ty_app` as b on a.appid=b.id order by a.id desc limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
if(!$row){
    json(201,'暂无数据');
}
$jsondata['code'] = 200;
$jsondata['msg'] = '';
$jsondata['count'] = DB::table('usergroup')->count();
foreach ($row as $value){
    $newinfo = array();
    $newinfo['id'] = $value['id'];
    $newinfo['appname'] = $value['appname'];
    $newinfo['name'] = '<span style="color:'.$value['color'].'">'.$value['name'].'</span>';
    $newinfo['data'] = $value['data'];
    $newinfo['addtime'] = $value['addtime'];

    $jsondata['data'][] = $newinfo;
}
die(json_encode($jsondata));
?>