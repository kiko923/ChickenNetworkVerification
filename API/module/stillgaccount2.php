<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$cztype = '归还账号2';
$czzt = '还号失败';
require 'profiler.php';

$gname = !empty($d['gname']) ? purge($d['gname']) : '';
$c1 = !empty($d['c1']) ? purge($d['c1']) : '';
$zt = !empty($d['zt']) ? purge($d['zt']) : '';
if($zt==1){
    $zt = 2;
}else{
    $zt = 0;
}

DB::table('gameaccount2')->where(['c5'=>$gname,'c1'=>$c1,'zt'=>1])->update(['zt'=>$zt]);
$retginfo['ret_info'] = '还号成功!';
insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[归还账号2] > 还号成功,还号('.$gname.'|'.$c1.').');
out(200,$retginfo,$app_res);
?>