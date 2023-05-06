<?php
/**
 * 接口：账号列表JSON
 * 时间：2023-02-12 14:13
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::table('gameaccount2')->order('id' )->limit(($_GET['page'] - 1) * $_GET['limit'],$_GET['limit'])->select();
if(!$row){
    json(201,'暂无数据');
}
$jsondata['code'] = 200;
$jsondata['msg'] = '';
$jsondata['count'] = DB::table('gameaccount2')->count();
foreach ($row as $value){
    $newinfo = array();
    $newinfo['id'] = $value['id'];
    $newinfo['c1'] = $value['c1'];
    $newinfo['c2'] = $value['c2'];
    $newinfo['c3'] = $value['c3'];
    $newinfo['c4'] = $value['c4'];
    $newinfo['c5'] = $value['c5'];
    $newinfo['c6'] = $value['c6'];
    $newinfo['c7'] = $value['c7'];
    if($value['zt']==0){
        $newinfo['zt'] = '<span class="layui-badge layui-bg-gray">空闲中</span>';
    }else if($value['zt']==1){
        $newinfo['zt'] = '<span class="layui-badge layui-bg-blue">占用中</span>';
    }else{
        $newinfo['zt'] = '<span class="layui-badge layui-bg-red">锁定中</span>';
    }
    $newinfo['cs'] = '<span class="layui-badge layui-bg-gray">'.$value['cs'].'次</span>';
    $newinfo['zuser'] = $value['zuser'];
    $jsondata['data'][] = $newinfo;
}
die(json_encode($jsondata));
?>