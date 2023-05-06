<?php
/**
 * 接口：读取授权
 * 时间：2022-07-18 11:39
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //授权id
if(!$id){json(201,'读取失败，该授权不存在');}
$res = DB::table('user')->where(['id'=>$id,'aid'=>$userinfo['id']])->find();
if(!$res){json(201,'读取失败，该授权不存在');}
$agent = DB::table('admin')->where(['id'=>$res['aid']])->find();
if($agent){$res['agent'] = $agent['user'];}
unset($res['pwd']);
unset($res['aid']);
json(200,$res);
?>