<?php
/**
 * 接口：查询关联订单
 * 时间：2022-10-22 13:36
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : '';
if(!$id){
    json(201,'请输入订单id');
}
$res = DB::table('moneylog')->where(['id'=>$id,'aid'=>$userinfo['id']])->find();
if(!$res){
    json(201,'未查询到此订单的关联订单信息');
}
if(!$res['glid']){
    json(201,'此订单非下级返利或返利扣除订单，无法查询关联订单');
}
$dd = DB::table('moneylog')->where(['id'=>$res['glid']])->find();
if(!$dd){
    json(201,'关联订单不存在');
}
$agent = DB::table('admin')->where(['id'=>$dd['aid']])->find();
$info = '订单ID：'.$dd['id'];
$info = $info.'<br>代理账号：'.$agent['user'];
if($dd['type']==1){
    $info = $info.'<br>操作类型：制卡';
    $info = $info.'<br>消费金额：'.$dd['money'].'元';
}elseif($dd['type']==2){
    $info = $info.'<br>操作类型：加授权';
    $info = $info.'<br>消费金额：'.$dd['money'].'元';
}elseif($dd['type']==4){
    $info = $info.'<br>操作类型：退卡';
    $info = $info.'<br>返还金额：'.$dd['money'].'元';
}
$info = $info.'<br>消费时间：'.$dd['addtime'];
$info = $info.'<br>详细信息：'.$dd['info'];
json(200,$info);
?>