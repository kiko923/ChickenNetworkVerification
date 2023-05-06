<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$cztype = '取用户信息';
$czzt = '获取失败';
require 'profiler.php';

$arrs['user'] = $user['user'];
$arrs['endtime'] = $user['endtime'];
$arrs['point'] = $user['point'];
$arrs['mac'] = $user['mac'];
$arrs['ip'] = $user['ip'];
$arrs['dk'] = $user['dk'];
$arrs['email'] = $user['email'];
$arrs['userqq'] = $user['userqq'];
$arrs['ver'] = $user['ver'];
$arrs['addtime'] = $user['addtime'];
$arrs['logintime'] = $user['logintime'];
$arrs['data'] = base64_encode($user['data']);
if($user['tid']){
    $res = DB::table('user')->where(['id'=>$user['tid']])->find();
    if($res){
        $arrs['tjr'] = $res['user'];
    }
}
if($user['gid']){
    $usergroup = DB::table('usergroup')->where(['id'=>$user['gid']])->find();
    if($usergroup){
        $arrs['group'] = $usergroup['name'];
        $arrs['groupdata'] = base64_encode($usergroup['data']);
    }
}
insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取用户信息] > 获取成功.');
$arrs['ret_info'] = '获取成功!';
out(200,$arrs,$app_res);

?>