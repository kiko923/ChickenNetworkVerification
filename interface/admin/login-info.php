<?php
/**
 * 接口：取登录信息
 * 时间：2022-10-17 11:59
 */

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$useri['name'] = $userinfo['name'];
$useri['user'] = $userinfo['user'];
json(200,$useri);
?>