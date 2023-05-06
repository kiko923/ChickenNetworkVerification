<?php
/**
 * 接口：退出登录
 * 时间：2022-08-24 10:10
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$_SESSION['cookie_admin'] = '';
    json(200,'您已注销登录');
?>