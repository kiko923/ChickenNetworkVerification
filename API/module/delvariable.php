<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$cztype = '删云变量';
$czzt = '删除失败';
require 'profiler.php';
$cloud_key = !empty($d['cloudkey']) ? purge($d['cloudkey']) : ''; //获取变量名
if(!$cloud_key){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[删云变量] > 删除失败,原因:变量名为空.');
    out(201,'变量名不可为空。',$app_res);
}
DB::table('variable1')->where(['appid'=>$appid,'cloud_key'=>$cloud_key])->del();
insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[删云变量] > 删除成功.');
$retg['ret_info'] = '删除成功!';
out(200,$retg,$app_res);
?>