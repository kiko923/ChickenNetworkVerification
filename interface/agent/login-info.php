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
$useri['money'] = $userinfo['money'];
$useri['consume'] = $userinfo['consume'];
$useri['logintime'] = $userinfo['logintime'];
if($userinfo['aid']){
    $res = DB::table('admin')->where(['id'=>$userinfo['aid']])->find();
    $useri['aid'] = $userinfo['aid'];
    $useri['auser'] = $res['user'];
}
$group = DB::table('group')->where(['id'=>$userinfo['gid']])->find();
if($group){
    $useri['adds'] = $group['adds'];
    $useri['gname'] = '<span style="color:'.$group['color'].'">'.$group['name'].'</span>';
}else{
    $useri['adds'] = 0;
}
die(json_encode($useri));
?>