<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$cztype = '归还账号';
$czzt = '还号失败';
require 'profiler.php';

$gname = !empty($d['gname']) ? purge($d['gname']) : '';
$c1 = !empty($d['c1']) ? purge($d['c1']) : '';

DB::table('gameaccount')->where(['c4'=>$gname,'c1'=>$c1,'zt'=>1])->update(['zt'=>0]);
$retginfo['ret_info'] = '还号成功!';
insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[归还账号] > 还号成功,还号('.$gname.'|'.$c1.').');
out(200,$retginfo,$app_res);
?>