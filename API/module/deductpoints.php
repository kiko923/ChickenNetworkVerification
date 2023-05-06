<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$cztype = '扣除点数';
$czzt = '扣除失败';
require 'profiler.php';

$sl = !empty($d['sl']) ? purge($d['sl']) : 1;

if($user['point'] < $sl){
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[扣除点数] > 扣除失败,原因:点数不足.');
    out(201,'点数不足，扣除失败！',$app_res);
}
$newp = $user['point'] - $sl;
$res = DB::table('user')->where(['id'=>$user['id']])->update(['point'=>$newp]);
if(!$res){
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[扣除点数] > 扣除失败,原因:更改扣除后的点数失败.');
    out(201,'扣除失败，请稍后再试！',$app_res);
}
$kdlog['type'] = 1;
$kdlog['appid'] = $appid;
$kdlog['ver'] = $ver;
$kdlog['uid'] = $user['id'];
$kdlog['mac'] = $mac;
$kdlog['ip'] = $ip;
$kdlog['clientid'] = $clientid;
$kdlog['kdsj'] = $g_date_rq;
$kdlog['kdsl'] = $sl;
$kdlog['addtime'] = date('Y-m-d H:i:s');
DB::table('kdlog')->add($kdlog);

$arrs['user'] = $user['user'];
$arrs['endtime'] = $user['endtime'];
$arrs['point'] = $newp;
$arrs['ret_info'] = '扣除成功!';
insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[扣除点数] > 扣除成功.');
out(200,$arrs,$app_res);
?>