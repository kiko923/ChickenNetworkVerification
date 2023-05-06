<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$cztype = '取云变量';
$czzt = '读取失败';

require 'profiler.php';
$cloud_key = !empty($d['cloudkey']) ? purge($d['cloudkey']) : ''; //获取变量名
if(!$cloud_key){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云变量] > 读取失败,原因:变量名为空.');
    out(201,'变量名不可为空。',$app_res);
}
$cloud = DB::table('variable1')->where(['appid'=>$appid,'cloud_key'=>$cloud_key])->find();
if(!$cloud){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云变量] > 读取失败,原因:不存在此变量.');
    out(201,'获取失败，不存在此变量。',$app_res);
}
$retg['values'] = base64_encode($cloud['cloud_value']);
$retg['ret_info'] = '获取成功!';
$new_sl = $cloud['callsl'] + 1;
DB::table('variable1')->where(['id'=>$cloud['id']])->update(['callsl'=>$new_sl]);
insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云变量] > 读取失败,变量:'.$cloud_key.'.');
out(200,$retg,$app_res);
?>