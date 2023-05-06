<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$cztype = '取云数据2';
$czzt = '读取失败';
require 'profiler.php';

$arrs['data'] = $user['data3'];
$arrs['ret_info'] = '获取成功!';
insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云数据2] > 读取成功.');
out(200, $arrs, $app_res);

?>