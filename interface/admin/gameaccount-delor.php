<?php

/**
 * 接口：删除游戏账号(选中)
 * 时间：2023-02-12 20:04
 */
if ($myurl != $_SERVER['SERVER_NAME']) { //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code' => 201, 'msg' => 'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$data = $_POST['data'];
$arr = json_decode($data, true);
$count = 0;
foreach ($arr as $key => $value) {
    $res = DB::query('delete from `ty_gameaccount` where id=' . $value['id']);
    if ($res) {
        $count++;
    }
}
json(200, '执行删除账号成功,成功删除账号数量[' . $count . ']个');
