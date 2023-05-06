<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$b_type = !empty($d['b_type']) ? purge($d['b_type']) : '';
$b_data = !empty($d['b_data']) ? purge($d['b_data']) : '';
$b_bz = !empty($d['b_bz']) ? purge($d['b_bz']) : '';

if($clientid == ''){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[添加云黑] > 添加失败,原因:客户端ID为空.');
    out(201,'客户端ID不可为空。',$app_res);
}

$res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
if($res['type']){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[添加云黑] > 添加失败,原因:版本过旧.');
    out(201,'当前版本已停用，请更新到最新版。',$app_res);
}

$res = DB::table('black')->where(['appid'=>$appid,'type'=>$b_type,'data'=>$b_data])->find();

if($res){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[添加云黑] > 添加失败,此数据已存在.');
    out(201,'添加失败。',$app_res);
}
unset($res);
$add['addtime'] = $g_date;
$add['appid'] = $appid;
$add['type'] = $b_type;
$add['data'] = $b_data;
$add['bz'] = $b_bz;
$res = DB::table('black')->add($add);
if(!$res){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[添加云黑] > 添加失败,数据库添加失败.');
    out(201,'添加失败，请稍后重试。',$app_res);
}

insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[添加云黑] > 添加成功,已拉黑.');
out(200,'添加成功。',$app_res);
?>