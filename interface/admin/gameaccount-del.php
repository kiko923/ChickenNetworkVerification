<?php

/**
 * 接口：删除游戏账号
 * 时间：2023-02-12 20:07
 */
if ($myurl != $_SERVER['SERVER_NAME']) { //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code' => 201, 'msg' => 'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //索引id
$res = DB::table('gameaccount')->where(['id' => $id])->del();
if (!$res) {
    json(201, '删除游戏账号失败');
}
json(200, '删除游戏账号成功');
