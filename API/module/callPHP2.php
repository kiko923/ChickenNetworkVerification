<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
if($clientid == ''){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[调用云计算2] > 调用失败,原因:客户端ID为空.');
    out(201,'客户端ID不可为空。',$app_res);
}

$res = DB::table('black')->where(['appid'=>$appid,'type'=>1,'data'=>$mac])->find();
if($res){
    out(201,'该设备码已被拉黑，如有疑问请联系客服咨询。',$app_res);
}
$res = DB::table('black')->where(['appid'=>$appid,'type'=>2,'data'=>$ip])->find();
if($res){
    out(201,'该设备IP已被拉黑，如有疑问请联系客服咨询。',$app_res);
}

if($app_res['md5_check']){
    $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
    if(!$res){
        insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[调用云计算2] > 调用失败,原因:MD5验证失败.');
        out(201,'MD5验证失败，请勿修改程序',$app_res);
    }elseif($res['md5']!=$md5){
        insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[调用云计算2] > 调用失败,原因:MD5验证失败.');
        out(201,'MD5验证失败，请勿修改程序',$app_res);
    }
}

$res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
if($res['type']){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[调用云计算2] > 调用失败,原因:版本过旧.');
    out(201,'当前版本已停用，请更新到最新版。',$app_res);
}

require 'func2.php';

$fun = $d['fun'];
$para = $d['para'];
$paras = explode(',', $para);
$ret = call_user_func_array($fun,$paras);
out(200,$ret,$app_res);
?>