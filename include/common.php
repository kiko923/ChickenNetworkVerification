<?php

header("content-type:text/html; charset=utf-8");

require_once 'config.php';
require_once 'core.im.php';
require_once 'db.class.php';
require_once 'function.php';

$cookie = purge($_SESSION['cookie_admin']);
if(!$cookie){
    json(201,'暂未登录');
}
$ip = getIP();
$userinfo = DB::table('admin')->where(['cookie'=>$cookie,'type'=>0,'ip'=>$ip])->find();
if(!$userinfo){
    $_SESSION['cookie_admin'] = '';
    json(201,'暂未登录');
}
$starttime = strtotime($userinfo['logintime']);
$time = time();
if($time - $starttime >= 21600){ //登录6小时后过期
    $_SESSION['cookie_admin'] = '';
    json(201,'本次登录已过期，请重新登录。');
}

?>