<?php
/**
 * 接口：验证登录
 * 时间：2022-07-15 08:59
 */

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

if(isset($_COOKIE["cookie_agent"]))
{
    $token = authcode(daddslashes($_COOKIE['cookie_agent']), 'DECODE', SYS_KEY);
    list($user, $sid) = explode("\t", $token);
    if(!$user && !$sid){
        json(201,'暂未登录');
    }
    $ip = getIP();
    $userinfo = DB::table('admin')->where(['user'=>$user,'cookie'=>$sid,'type'=>1,'ip'=>$ip])->find();
    if(!$userinfo){
        json(201,'暂未登录');
    }
}else{
    json(201,'暂未登录');
}

?>