<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$cztype = '写云变量';
$czzt = '写入失败';

require 'profiler.php';
$cloud_key = !empty($d['cloudkey']) ? purge($d['cloudkey']) : ''; //获取变量名
$cloud_value = !empty($d['cloudvalue']) ? purge($d['cloudvalue']) : ''; //获取变量值
if(!$cloud_key || !$cloud_value){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[写云变量] > 写入失败,原因:变量名或变量值为空.');
    out(201,'变量名或变量值不可为空。',$app_res);
}
$cloud = DB::table('variable1')->where(['appid'=>$appid,'cloud_key'=>$cloud_key])->find();
if(!$cloud){
    DB::table('variable1')->add(['appid'=>$appid,'cloud_key'=>$cloud_key,'cloud_value'=>$cloud_value,'addtime'=>$g_date,'callsl'=>1]);
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[写云变量] > 创建变量(√),原因:不存在此变量.');
}else{
    $new_sl = $cloud['callsl'] + 1;
    DB::table('variable1')->where(['appid'=>$appid,'cloud_key'=>$cloud_key])->update(['cloud_value'=>$cloud_value,'callsl'=>$new_sl]);
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[写云变量] > 写入成功,变量:'.$cloud_key);
}
$retg['ret_info'] = '写入成功!';
out(200,$retg,$app_res);
?>