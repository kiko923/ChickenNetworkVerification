<?php
/**
 * 接口：计点列表JSON
 * 时间：2022-09-23 15:05
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$uid = isset($_GET['id']) ? $_GET['id'] : '';
$row = DB::query('SELECT a.*,b.name as name FROM `ty_kdlog` as a left join `ty_app` as b on a.appid=b.id order by a.id desc limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
if(!$row){
    json(201,'暂无数据');
}
$jsondata['code'] = 200;
$jsondata['msg'] = '';
$jsondata['count'] = DB::query('SELECT count(a.*) FROM `ty_kdlog` as a left join `ty_app` as b on a.appid=b.id order by a.id desc');
foreach ($row as $value){
    $newinfo = array();
    $newinfo['id'] = $value['id'];
    $newinfo['appname'] = $value['name'];
    $newinfo['mac'] = $value['mac'];
    $newinfo['ip'] = $value['ip'];
    $newinfo['clientid'] = $value['clientid'];
    $newinfo['type'] = $value['type'] ? '<span class="layui-badge layui-bg-gray"><span style="color:darkorchid"><b>手动</b></span></span>' : '<span class="layui-badge layui-bg-gray"><span style="color:blue"><b>自动</b></span></span>';
    $newinfo['kdsl'] = '<b>-'.$value['kdsl'].'</b>';
    $newinfo['ver'] = $value['ver'];
    $newinfo['addtime'] = $value['addtime'];

    $jsondata['data'][] = $newinfo;
}
die(json_encode($jsondata));
?>