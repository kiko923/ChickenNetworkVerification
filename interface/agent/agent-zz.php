<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_POST['id']) ? purge($_POST['id']) : ''; //人员id
$je = isset($_POST['je']) ? purge($_POST['je']) : ''; //金额

$uss = DB::table('admin')->where(['id'=>$id])->find();
if($uss['aid']!=$userinfo['id']){
    json(201,'未查询到此下级代理');
}
if($userinfo['money']<$je){
    json(201,'账户余额不足，无法转账');
}
$newmoney = $userinfo['money'] - $je;
$res = DB::table('admin')->where(['id'=>$userinfo['id']])->update(['money'=>$newmoney]);
if(!$res){
    json(201,'转账失败，请稍后重试');
}
$newmoney1 = $uss['money'] + $je;
unset($res);
$res = DB::table('admin')->where(['id'=>$id])->update(['money'=>$newmoney1]);
if(!$res){
    $res = DB::table('admin')->where(['id'=>$userinfo['id']])->update(['money'=>$userinfo['money']]);
    json(201,'转账失败，请稍后重试');
}
moneylog($userinfo['id'],'',$je,'',0,0,$newmoney,'给下级代理['.$uss['user'].']转入金额['.$je.']元.');
moneylog($id,'',$je,'',0,1,$newmoney1,'上级代理['.$userinfo['user'].']手动转入金额['.$je.']元.');
json(200,'转账成功');
?>