<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$cztype = '取用账号2';
$czzt = '取号失败';
require 'profiler.php';

$gname = !empty($d['gname']) ? purge($d['gname']) : '';
$c1 = !empty($d['c1']) ? purge($d['c1']) : '';
$res = DB::table('gameaccount2')->where(['c5'=>$gname,'c1'=>$c1,'zt'=>0])->find();

if(!$res){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取用账号2] > 取号失败,当前账号未在空闲中.');
    out(201,'取号失败，当前账号未在空闲中。',$app_res);
}

$newcs = $res['cs']+1;
DB::table('gameaccount2')->where(['id'=>$res['id']])->update(['zt'=>1,'cs'=>$newcs,'zuser'=>$user['user']]);
$retginfo['c1'] = $res['c1'];
$retginfo['c2'] = $res['c2'];
$retginfo['c3'] = $res['c3'];
$retginfo['c4'] = $res['c4'];
$retginfo['c5'] = $res['c5'];
$retginfo['ret_info'] = '取号成功!';
insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取用账号2] > 取号成功,取号('.$gname.'|'.$res['c1'].').');
out(200,$retginfo,$app_res);
?>