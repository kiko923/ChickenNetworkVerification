<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$cztype = '取游戏账号列表';
$czzt = '获取失败';
require 'profiler.php';

$gname = !empty($d['gname']) ? purge($d['gname']) : '';

$row = DB::table('gameaccount2')->where(['c5'=>$gname])->select();
if(!$row){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取游戏账号列表] > 获取失败,原因:暂无游戏账号.');
    out(201,'暂无游戏账号',$app_res);
}
foreach ($row as $value){
    $newinfo = array();
    $newinfo['id'] = $value['id'];
    $newinfo['c1'] = $value['c1'];
    $newinfo['c5'] = $value['c5'];
    $newinfo['c6'] = $value['c6'];
    $newinfo['c7'] = $value['c7'];
    if($value['zt']==0){
        $newinfo['zt'] = '空闲中';
    }else if($value['zt']==1){
        $newinfo['zt'] = '占用中';
    }else{
        $newinfo['zt'] = '锁定中';
    }
    $newinfo['cs'] = $value['cs'];
    $retg['data_list'][] = $newinfo;
}
$retg['ret_info'] = '获取成功!';
insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取游戏账号列表] > 获取成功.');
out(200,$retg,$app_res);
?>