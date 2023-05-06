<?php
/**
 * 接口：人员列表JSON
 * 时间：2022-07-15 08:35
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::query('SELECT a.*,b.name as appname FROM `ty_black` as a left join `ty_app` as b on a.appid = b.id order by a.id desc limit ' .($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
if(!$row){
    json(201,'暂无数据');
}
$jsondata['code'] = 200;
$jsondata['msg'] = '';
$jsondata['count'] = DB::table('black')->count();
foreach ($row as $value){
    $newinfo = array();
    $newinfo['id'] = $value['id'];
    $newinfo['appname'] = $value['appname'];
    $newinfo['type'] = $value['type'];
    $newinfo['data'] = $value['data'];
    $newinfo['bz'] = $value['bz'];
    if($value['type']==0){
        $newinfo['type'] = '<span class="layui-badge layui-bg-orange">账号</span>';
    }elseif($value['type']==1){
        $newinfo['type'] = '<span class="layui-badge layui-bg-green">设备码</span>';
    }elseif($value['type']==2){
        $newinfo['type'] = '<span class="layui-badge layui-bg-blue">设备IP</span>';
    }elseif($value['type']==3){
        $newinfo['type'] = '<span class="layui-badge layui-bg-cyan">自定义</span>';
    }

    $newinfo['addtime'] = $value['addtime'];

    $jsondata['data'][] = $newinfo;
}
die(json_encode($jsondata));
?>